<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailSetting;
use App\Models\EmailTemplate;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminEmailController extends Controller
{
    public function index()
    {
        $page = Page::all();
        $profile = Auth::user()->profile;


        $templates = EmailTemplate::orderBy('created_at', 'desc')->get();
        $emailSetting = EmailSetting::first() ?? [];
        return view('admin.emails', compact('page', 'profile', 'templates', 'emailSetting'));
    }

    public function create()
    {
        $page = Page::all();
        $profile = Auth::user()->profile;

        return view('admin.email_detail', [
            'page' => $page,
            'profile' => $profile,
            'template' => new EmailTemplate(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|string|max:255|unique:email_templates,slug',
            'subject' => 'required|string|max:255',
            'body_html' => 'required|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['slug'], '_');
        $validated['is_active'] = $request->has('is_active');

        EmailTemplate::create($validated);

        return redirect()->route('emails.admin')->with('success', 'Email template created successfully.');
    }

    public function edit($id)
    {
        $page = Page::all();
        $profile = Auth::user()->profile;
        $template = EmailTemplate::findOrFail($id);

        return view('admin.email_detail', [
            'page' => $page,
            'profile' => $profile,
            'template' => $template,
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, $id)
    {
        $template = EmailTemplate::findOrFail($id);

        $validated = $request->validate([
            'slug' => 'required|string|max:255|unique:email_templates,slug,' . $template->id,
            'subject' => 'required|string|max:255',
            'body_html' => 'required|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['slug'], '_');
        $validated['is_active'] = $request->has('is_active');

        $template->update($validated);

        return redirect()->route('emails.admin')->with('success', 'Email template updated successfully.');
    }

    public function destroy($id)
    {
        $template = EmailTemplate::findOrFail($id);
        $template->delete();

        return redirect()->route('emails.admin')->with('success', 'Email template deleted successfully.');
    }

    public function updateGlobal(Request $request)
    {
        $validated = $request->validate([
            'header_html' => 'nullable|string',
            'footer_html' => 'nullable|string',
        ]);

        $emailSetting = EmailSetting::first() ?? new EmailSetting();
        $emailSetting->header_html = $validated['header_html'] ?? '';
        $emailSetting->footer_html = $validated['footer_html'] ?? '';
        $emailSetting->save();

        return redirect()->back()->with('success', 'Global email header & footer updated successfully.');
    }

    public function preview($id)
    {
        $template = EmailTemplate::findOrFail($id);
        $emailSetting = EmailSetting::first();

        $header = $emailSetting ? $emailSetting->header_html : '<div style="background-color: #0f1016; padding: 24px; text-align: center; border-radius: 8px 8px 0 0;"><h1 style="color: #6c8eff; margin: 0; font-family: sans-serif;">Portfolio Systems</h1></div>';
        $footer = $emailSetting ? $emailSetting->footer_html : '<div style="background-color: #f8fafc; padding: 18px; text-align: center; font-size: 12px; color: #64748b; border-radius: 0 0 8px 8px;"><p style="margin: 0;">© ' . date('Y') . ' Portfolio Systems. All rights reserved.</p></div>';

        // Sample data for preview placeholders
        $sampleData = [
            'name' => Auth::user()?->name ?? 'John Doe',
            'email' => Auth::user()?->email ?? 'visitor@example.com',
            'subject' => $template->subject ?: 'General Inquiry',
            'reply_message' => 'Thank you for reaching out! We have received your inquiry and will be happy to work together on this project.',
            'sender_name' => Auth::user()?->name ?? 'Kelvin Aso',
            'body' => 'Thank you for contacting us. We will get back to you shortly.',
        ];

        $renderedSubject = $template->subject;
        $renderedBody = $template->body_html;
        foreach ($sampleData as $key => $val) {
            $renderedSubject = str_replace(['{{ ' . $key . ' }}', '{{' . $key . '}}'], e($val), $renderedSubject);
            $renderedBody = str_replace(['{{ ' . $key . ' }}', '{{' . $key . '}}'], $val, $renderedBody);
        }

        $fullHtml = $header . '<div style="background: #ffffff; color: #1e293b; padding: 32px 24px; font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, sans-serif; font-size: 15px; line-height: 1.6;">' . $renderedBody . '</div>' . $footer;

        return response($fullHtml, 200)->header('Content-Type', 'text/html; charset=UTF-8');
    }

    public function sendTestEmail(Request $request)
    {
        $validated = $request->validate([
            'test_email' => 'required|email',
        ]);

        $emailSetting = EmailSetting::first();
        $header = $emailSetting ? $emailSetting->header_html : '';
        $footer = $emailSetting ? $emailSetting->footer_html : '';

        $testContent = "<div style=\"padding: 24px; font-family: sans-serif;\"><h3>Test Email Dispatch</h3><p>This is a test email sent from your Portfolio Admin Panel.</p><p>If you are receiving this message, your mail configuration is working perfectly! ✨</p></div>";
        $fullHtml = $header . $testContent . $footer;

        try {
            Mail::html($fullHtml, function ($message) use ($validated) {
                $message->to($validated['test_email'])
                    ->subject('Test Email from Portfolio Systems Admin');
            });

            return redirect()->back()->with('success', 'Test email sent successfully to ' . $validated['test_email']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to send test email: ' . $e->getMessage());
        }
    }
}
