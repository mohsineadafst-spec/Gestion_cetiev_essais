{{-- ─────────────────────────────────────────────────────────────
     resources/views/components/sidebar.blade.php
     Usage : @include('components.sidebar')  ou  <x-sidebar />
───────────────────────────────────────────────────────────── --}}

<aside class="sb" id="rootpanel-sidebar" x-data="{ collapsed: false }" :class="{ 'sb--collapsed': collapsed }">

    {{-- ── Brand ─────────────────────────────────── --}}
    <div class="sb-brand">
        <div class="sb-logo" aria-hidden="true">
            <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" width="18" height="18">
                <path d="M6 22L12 10L18 18L22 14" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>

        <span class="sb-name">RootPanel</span>

        <button class="sb-toggle" @click="collapsed = !collapsed" :title="collapsed ? 'Développer' : 'Réduire'">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="17" height="17" aria-hidden="true">
                <path d="M15 18l-6-6 6-6"/>
            </svg>
        </button>
    </div>

    {{-- ── User ──────────────────────────────────── --}}
    <div class="sb-user">
        <div class="sb-avatar" aria-hidden="true">
            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
            <span class="sb-dot"></span>
        </div>

        <div class="sb-user-info" x-show="!collapsed">
            <strong>{{ Auth::user()->name ?? 'Utilisateur' }}</strong>
            <em>{{ Auth::user()->role ?? 'Utilisateur' }}</em>
        </div>
    </div>

    {{-- ── Navigation ───────────────────────────── --}}
    <nav class="sb-nav" aria-label="Navigation principale">

        {{-- Tableau de bord --}}
        <a href="{{ route('dashboard') }}"
           class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}"
           title="Tableau de bord">
            <span class="ni-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="18" height="18">
                    <rect x="3" y="3" width="7" height="7" rx="1"/>
                    <rect x="14" y="3" width="7" height="7" rx="1"/>
                    <rect x="3" y="14" width="7" height="7" rx="1"/>
                    <rect x="14" y="14" width="7" height="7" rx="1"/>
                </svg>
            </span>
            <span class="ni-label" x-show="!collapsed">Tableau de bord</span>
        </a>

        {{-- ── Section : Gestion ── --}}
        <div class="sb-section" x-show="!collapsed">
            <span>Gestion</span>
        </div>
        <div class="sb-section-divider" x-show="collapsed" aria-hidden="true"></div>

        <a href="{{ route('produits.index') }}"
           class="nav-item {{ request()->routeIs('produits.*') ? 'active' : '' }}"
           title="Demandes">
            <span class="ni-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="18" height="18">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                    <polyline points="10 9 9 9 8 9"/>
                </svg>
            </span>
            <span class="ni-label" x-show="!collapsed">Demandes</span>
        </a>

        <a href="{{ route('demande_essai.index') }}"
           class="nav-item {{ request()->routeIs('demande_essai.*') ? 'active' : '' }}"
           title="Assignations Essais">
            <span class="ni-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="18" height="18">
                    <path d="M9 3v11.5A3.5 3.5 0 0012.5 18v0A3.5 3.5 0 0016 14.5V3"/>
                    <line x1="6" y1="3" x2="18" y2="3"/>
                    <path d="M9 11h6"/>
                </svg>
            </span>
            <span class="ni-label" x-show="!collapsed">Assignations Essais</span>
        </a>

        <a href="{{ route('demandes_confirmees.index') }}"
           class="nav-item {{ request()->routeIs('demandes_confirmees.*') ? 'active' : '' }}"
           title="Demandes Confirmées">
            <span class="ni-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="18" height="18">
                    <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            </span>
            <span class="ni-label" x-show="!collapsed">Demandes Confirmées</span>
        </a>

        {{-- ── Section : Administration ── --}}
        <div class="sb-section" x-show="!collapsed">
            <span>Administration</span>
        </div>
        <div class="sb-section-divider" x-show="collapsed" aria-hidden="true"></div>

        <a href="{{ route('users.index') }}"
           class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}"
           title="Utilisateurs & Rôles">
            <span class="ni-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="18" height="18">
                    <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 00-3-3.87"/>
                    <path d="M16 3.13a4 4 0 010 7.75"/>
                </svg>
            </span>
            <span class="ni-label" x-show="!collapsed">Utilisateurs & Rôles</span>
        </a>

        <a href="{{ route('laboratoires.index') }}"
           class="nav-item {{ request()->routeIs('laboratoires.*') ? 'active' : '' }}"
           title="Laboratoires">
            <span class="ni-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="18" height="18">
                    <path d="M8 3v4l-4 9a2 2 0 001.8 2.9h12.4A2 2 0 0020 16.9L16 7V3"/>
                    <line x1="8" y1="3" x2="16" y2="3"/>
                    <path d="M8 13h8"/>
                </svg>
            </span>
            <span class="ni-label" x-show="!collapsed">Laboratoires</span>
        </a>

        {{-- ── Section : Supervision ── --}}
        <div class="sb-section" x-show="!collapsed">
            <span>Supervision</span>
        </div>
        <div class="sb-section-divider" x-show="collapsed" aria-hidden="true"></div>

        <a href="{{ route('audit.index') }}"
           class="nav-item {{ request()->routeIs('audit.*') ? 'active' : '' }}"
           title="Audit & Logs">
            <span class="ni-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="18" height="18">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    <polyline points="9 12 11 14 15 10"/>
                </svg>
            </span>
            <span class="ni-label" x-show="!collapsed">Audit & Logs</span>
        </a>

    </nav>

    {{-- ── Footer ────────────────────────────────── --}}
    <div class="sb-footer">

        <a href="{{ route('profile.show') }}"
           class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}"
           title="Mon profil">
            <span class="ni-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="18" height="18">
                    <circle cx="12" cy="8" r="4"/>
                    <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                </svg>
            </span>
            <span class="ni-label" x-show="!collapsed">Mon profil</span>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-item nav-item--logout" title="Déconnexion">
                <span class="ni-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="18" height="18">
                        <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                </span>
                <span class="ni-label" x-show="!collapsed">Déconnexion</span>
            </button>
        </form>

    </div>

</aside>


{{-- ════════════════════════════════════════════════════════════
     STYLES  —  à déplacer dans resources/css/sidebar.css
════════════════════════════════════════════════════════════ --}}
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap');

:root {
    --sb-w: 256px;
    --sb-w-collapsed: 68px;
    --sb-bg: #0D0F14;
    --sb-border: rgba(255,255,255,.07);
    --sb-text: #7C8598;
    --sb-text-hover: #C8CDD8;
    --sb-text-active: #A8BFFF;
    --sb-active-bg: rgba(99,130,255,.12);
    --sb-active-border: #6382FF;
    --sb-section-color: #3A4155;
    --sb-transition: 220ms cubic-bezier(.4,0,.2,1);
    --sb-font: 'Inter', system-ui, sans-serif;
}

/* ── Layout ── */
.sb {
    display: flex;
    flex-direction: column;
    width: var(--sb-w);
    height: 100vh;
    background: var(--sb-bg);
    border-right: 1px solid var(--sb-border);
    position: sticky;
    top: 0;
    overflow: hidden;
    transition: width var(--sb-transition);
    font-family: var(--sb-font);
}

.sb--collapsed { width: var(--sb-w-collapsed); }

/* ── Brand ── */
.sb-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 18px 16px;
    border-bottom: 1px solid var(--sb-border);
    flex-shrink: 0;
}

.sb-logo {
    width: 32px;
    height: 32px;
    min-width: 32px;
    border-radius: 9px;
    background: linear-gradient(135deg, #4F6EF7, #7C3AED);
    display: flex;
    align-items: center;
    justify-content: center;
}

.sb-name {
    color: #E8EAF0;
    font-size: 14px;
    font-weight: 600;
    white-space: nowrap;
    letter-spacing: -.2px;
    flex: 1;
}

.sb-toggle {
    margin-left: auto;
    background: none;
    border: none;
    color: var(--sb-text);
    cursor: pointer;
    padding: 4px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background .15s, color .15s;
    flex-shrink: 0;
}

.sb-toggle:hover {
    background: rgba(255,255,255,.06);
    color: var(--sb-text-hover);
}

.sb--collapsed .sb-toggle svg { transform: rotate(180deg); }

/* ── User ── */
.sb-user {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 16px;
    border-bottom: 1px solid var(--sb-border);
    flex-shrink: 0;
    overflow: hidden;
}

.sb-avatar {
    width: 34px;
    min-width: 34px;
    height: 34px;
    border-radius: 50%;
    background: linear-gradient(135deg, #4F6EF7, #7C3AED);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 13px;
    position: relative;
}

.sb-dot {
    position: absolute;
    bottom: 1px;
    right: 1px;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #22C55E;
    border: 1.5px solid var(--sb-bg);
}

.sb-user-info {
    overflow: hidden;
    white-space: nowrap;
}

.sb-user-info strong {
    display: block;
    color: #D0D5E0;
    font-size: 13px;
    font-weight: 500;
}

.sb-user-info em {
    display: block;
    color: #6382FF;
    font-size: 11px;
    font-style: normal;
    margin-top: 2px;
}

/* ── Nav ── */
.sb-nav {
    flex: 1;
    overflow-y: auto;
    padding: 8px 0;
    scrollbar-width: none;
}

.sb-nav::-webkit-scrollbar { display: none; }

.sb-section {
    padding: 16px 18px 5px;
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: .8px;
    color: var(--sb-section-color);
    font-weight: 600;
    white-space: nowrap;
}

.sb-section-divider {
    height: 1px;
    background: var(--sb-border);
    margin: 8px 12px;
}

/* ── Nav items ── */
.nav-item {
    display: flex;
    align-items: center;
    gap: 10px;
    width: calc(100% - 12px);
    margin: 2px 6px;
    padding: 9px 12px;
    border-radius: 8px;
    border: none;
    background: none;
    color: var(--sb-text);
    cursor: pointer;
    text-align: left;
    font-family: var(--sb-font);
    font-size: 13px;
    font-weight: 400;
    text-decoration: none;
    transition: background .15s, color .15s;
    position: relative;
    overflow: hidden;
    white-space: nowrap;
}

.nav-item:hover {
    background: rgba(255,255,255,.05);
    color: var(--sb-text-hover);
}

.nav-item.active {
    background: var(--sb-active-bg);
    color: var(--sb-text-active);
    font-weight: 500;
}

.nav-item.active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 22%;
    bottom: 22%;
    width: 2.5px;
    border-radius: 0 2px 2px 0;
    background: var(--sb-active-border);
}

.ni-icon {
    width: 20px;
    min-width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.ni-label { flex: 1; }

/* ── Footer ── */
.sb-footer {
    border-top: 1px solid var(--sb-border);
    padding: 8px 0;
    flex-shrink: 0;
}

.sb-footer form { display: contents; }

.nav-item--logout:hover {
    background: rgba(239,68,68,.1) !important;
    color: #FCA5A5 !important;
}

/* ── Collapsed state ── */
.sb--collapsed .sb-name,
.sb--collapsed .sb-user-info,
.sb--collapsed .ni-label,
.sb--collapsed .sb-section { display: none; }

.sb--collapsed .nav-item {
    width: 44px;
    justify-content: center;
    padding: 10px;
    margin: 2px auto;
}
</style>
