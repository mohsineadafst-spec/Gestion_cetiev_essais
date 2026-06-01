{{-- Sidebar Vide --}}
<div class="sidebar-empty">
    <div class="sidebar-empty__header">
        <div class="sidebar-empty__logo">
            <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="32" height="32" rx="8" fill="url(#grad)"/>
                <path d="M8 22L14 10L20 18L24 14" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                <defs>
                    <linearGradient id="grad" x1="0" y1="0" x2="32" y2="32">
                        <stop offset="0%" stop-color="#4F6EF7"/>
                        <stop offset="100%" stop-color="#7C3AED"/>
                    </linearGradient>
                </defs>
            </svg>
        </div>
        <span class="sidebar-empty__title">Gestion</span>
    </div>

    <nav class="sidebar-empty__nav">
        <!-- Navigation vide - à remplir -->
    </nav>

    <div class="sidebar-empty__footer">
        <form method="POST" action="{{ route('logout') }}" class="sidebar-empty__logout-form">
            @csrf
            <button type="submit" class="sidebar-empty__logout">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/>
                    <polyline points="16 17 21 12 16 7"/>
                    <line x1="21" y1="12" x2="9" y2="12"/>
                </svg>
                <span>Déconnexion</span>
            </button>
        </form>
    </div>
</div>

@push('styles')
<style>
.sidebar-empty {
    width: 256px;
    height: 100vh;
    background: #0F1117;
    border-right: 1px solid rgba(255, 255, 255, 0.06);
    display: flex;
    flex-direction: column;
    position: sticky;
    top: 0;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
}

.sidebar-empty__header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 20px 16px 16px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.06);
}

.sidebar-empty__logo {
    width: 32px;
    height: 32px;
    flex-shrink: 0;
}

.sidebar-empty__logo svg {
    width: 32px;
    height: 32px;
    display: block;
}

.sidebar-empty__title {
    font-size: 15px;
    font-weight: 700;
    color: #E8EAF0;
    letter-spacing: -0.3px;
}

.sidebar-empty__nav {
    flex: 1;
    padding: 8px 0;
    overflow-y: auto;
}

.sidebar-empty__footer {
    border-top: 1px solid rgba(255, 255, 255, 0.06);
    padding: 8px;
}

.sidebar-empty__logout-form {
    margin: 0;
}

.sidebar-empty__logout {
    display: flex;
    align-items: center;
    gap: 10px;
    width: 100%;
    padding: 9px 14px;
    border-radius: 8px;
    border: none;
    background: none;
    color: #9BA3B5;
    font-size: 13.5px;
    font-weight: 500;
    cursor: pointer;
    text-align: left;
    transition: background 220ms ease, color 220ms ease;
}

.sidebar-empty__logout:hover {
    background: rgba(239, 68, 68, 0.1);
    color: #FCA5A5;
}

.sidebar-empty__logout svg {
    width: 18px;
    height: 18px;
    flex-shrink: 0;
}
</style>
@endpush
