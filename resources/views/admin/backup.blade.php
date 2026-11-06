<x-admin-layout :page="$page" :profile="$profile">

    <div class="page-header" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
        <div>
            <h1>Database Backup & Snapshots</h1>
            <div class="sub">Manage database backups, create automated snapshots, and restore database state.</div>
        </div>
        <form action="{{ route('backup.create.admin') }}" method="POST">
            @csrf
            <button type="submit" class="btn" style="display:flex;align-items:center;gap:8px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                    <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                    <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
                    <line x1="12" y1="9" x2="12" y2="15"></line>
                    <line x1="9" y1="12" x2="15" y2="12"></line>
                </svg>
                Create Backup Now
            </button>
        </form>
    </div>

    <!-- Stats Overview Cards -->
    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));gap:16px;margin-bottom:24px;">
        <div class="card" style="padding:20px;">
            <div class="muted" style="font-size:0.85rem;font-weight:500;margin-bottom:6px;">Database Driver</div>
            <div style="font-size:1.5rem;font-weight:700;color:var(--c-text);">{{ $dbInfo['connection'] }}</div>
        </div>
        <div class="card" style="padding:20px;">
            <div class="muted" style="font-size:0.85rem;font-weight:500;margin-bottom:6px;">Database File Size</div>
            <div style="font-size:1.5rem;font-weight:700;color:var(--c-text);">{{ $dbInfo['size'] }}</div>
        </div>
        <div class="card" style="padding:20px;">
            <div class="muted" style="font-size:0.85rem;font-weight:500;margin-bottom:6px;">Total Database Tables</div>
            <div style="font-size:1.5rem;font-weight:700;color:var(--c-text);">{{ $dbInfo['table_count'] }}</div>
        </div>
        <div class="card" style="padding:20px;">
            <div class="muted" style="font-size:0.85rem;font-weight:500;margin-bottom:6px;">Saved Snapshots</div>
            <div style="font-size:1.5rem;font-weight:700;color:var(--c-text);">{{ $dbInfo['total_backups'] }}</div>
        </div>
    </div>

    <!-- Backup Snapshots Table Card -->
    <div class="card">
        <div class="card-head" style="padding:16px 20px;border-bottom:1px solid var(--c-border);">
            <h3>Backup Snapshots History</h3>
            <div class="muted" style="font-size:0.85rem;">All database backups stored in
                <code>storage/app/backups</code>.</div>
        </div>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Snapshot File</th>
                        <th>Size</th>
                        <th>Created Date</th>
                        <th>Status</th>
                        <th class="right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($backups as $backup)
                        <tr>
                            <td>
                                <div style="font-weight:600;font-family:monospace;color:var(--c-text);">
                                    {{ $backup['filename'] }}</div>
                            </td>
                            <td class="muted">{{ $backup['size'] }}</td>
                            <td class="muted">{{ $backup['created_at'] }}</td>
                            <td>
                                <span class="status-badge"
                                    style="color:#16a34a;background:#dcfce7;padding:2px 8px;border-radius:12px;font-size:12px;font-weight:500;">
                                    Available
                                </span>
                            </td>
                            <td class="right" style="display:flex;gap:8px;justify-content:flex-end;">
                                <a class="btn ghost sm" href="{{ route('backup.download.admin', $backup['filename']) }}"
                                    title="Download Snapshot">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="7 10 12 15 17 10"></polyline>
                                        <line x1="12" y1="15" x2="12" y2="3"></line>
                                    </svg>
                                    Download
                                </a>

                                <form action="{{ route('backup.restore.admin', $backup['filename']) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to restore database snapshot: {{ $backup['filename'] }}? A safety backup will be created automatically.');">
                                    @csrf
                                    <button class="btn secondary sm" type="submit" title="Restore Database">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <polyline points="1 4 1 10 7 10"></polyline>
                                            <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path>
                                        </svg>
                                        Restore
                                    </button>
                                </form>

                                <form action="{{ route('backup.destroy.admin', $backup['filename']) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete backup snapshot {{ $backup['filename'] }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn ghost sm" type="submit" style="color:#ef4444;"
                                        title="Delete Snapshot">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path
                                                d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                            </path>
                                        </svg>
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="muted" style="text-align:center;padding:32px;">
                                No database snapshots found. Click <strong>"Create Backup Now"</strong> above to
                                generate your first backup.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-admin-layout>
