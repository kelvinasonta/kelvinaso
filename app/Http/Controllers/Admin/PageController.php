<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Http\Requests\PageDetailRequest;
use App\Models\PageSection;
use Illuminate\Support\Facades\Auth;


class PageController extends Controller
{
    public function index()
    {
        $pages = Page::all();
        $profile = Auth::user()?->profile;

         

        return view('admin.pages', compact(
            'pages',
            'profile'
        ));
    }

    public function show(string $slug)
    {
        $page = Page::where('slug', $slug)->first();

        if (!$page) {
            abort(404);
        }
        
        $profile = Auth::user()?->profile;

        return view('admin.page_detail', compact(
            'page',
            'profile'
        ));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'robots' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        $slug = !empty($validated['slug']) ? \Illuminate\Support\Str::slug($validated['slug']) : \Illuminate\Support\Str::slug($validated['title']);
        $originalSlug = $slug;
        $count = 1;
        while (Page::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $page = Page::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'content' => [
                'meta_description' => $validated['meta_description'] ?? '',
                'meta_keywords' => $validated['meta_keywords'] ?? '',
                'robots' => $validated['robots'] ?? 'index, follow',
            ],
            'is_active' => isset($validated['status']) ? filter_var($validated['status'], FILTER_VALIDATE_BOOLEAN) : true,
        ]);

        return redirect()
            ->route('pages.show', $page->slug)
            ->with('success', 'Page created successfully.');
    }

    public function update(string $slug, PageDetailRequest $request)
    {
        $page = Page::where('slug', $slug)->first();

        if (!$page) {
            abort(404);
        }
        
        $validated = $request->validated();

        $data = [
            'title' => $validated['title'] ?? $page->title,
            'slug' => $validated['slug'] ?? $page->slug,
            'content' => [
                'meta_description' => $validated['meta_description'] ?? '',
                'meta_keywords' => $validated['meta_keywords'] ?? '',
                'robots' => $validated['robots'] ?? 'index, follow',
            ],
            'is_active' => filter_var($validated['status'] ?? true, FILTER_VALIDATE_BOOLEAN),
        ];

        if (isset($validated['sections']) && is_array($validated['sections'])) {
            $submitted = $validated['sections'];
            $keptIds = [];

            foreach ($submitted as $index => $s) {
                if (!is_array($s)) {
                    continue;
                }

                $id = $s['id'] ?? null;
                $order = isset($s['order']) ? (int) $s['order'] : $index;
                $is_active = true;
                if (isset($s['is_visible'])) {
                    $is_active = filter_var($s['is_visible'], FILTER_VALIDATE_BOOLEAN);
                } elseif (isset($s['is_active'])) {
                    $is_active = filter_var($s['is_active'], FILTER_VALIDATE_BOOLEAN);
                }

                $sectionData = [
                    'page_id' => $page->id,
                    'section_name' => $s['section_name'] ?? ('section_' . ($index + 1)),
                    'order' => $order,
                    'content' => $s['content'] ?? [],
                    'is_active' => $is_active,
                ];

                if (!empty($id)) {
                    $ps = PageSection::where('id', $id)->where('page_id', $page->id)->first();
                    if ($ps) {
                        $ps->update($sectionData);
                        $keptIds[] = $ps->id;
                        continue;
                    }
                }

                $new = PageSection::create($sectionData);
                $keptIds[] = $new->id;
            }

            PageSection::where('page_id', $page->id)->whereNotIn('id', $keptIds)->delete();
        }

        $result = $page->update($data);

        if (!$result) {
            return redirect()
                ->route('pages.show', $page->slug)
                ->with('error', 'An error occurred while updating the page.');
        }

        return redirect()
            ->route('pages.show', $page->slug)
            ->with('success', $data['title'] . ' page updated successfully.');
    }
}
