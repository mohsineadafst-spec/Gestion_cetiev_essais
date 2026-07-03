{{-- sidebar.blade.php — Root Admin Sidebar --}}

<aside class="sidebar" id="sidebar" x-data="{ open: true }"
    :class="{ 'sidebar--collapsed': !open }">

    {{-- ─── Brand ─────────────────────────────── --}}
    

    {{-- ─── User ─────────────────────────────── --}}
    <div class="sidebar__user">

        <div class="sidebar__avatar">
            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
            <span class="sidebar__status"></span>
        </div>
        

        <div class="sidebar__user-info">
            <strong>{{ Auth::user()->name ?? 'Utilisateur' }}</strong>
            <em>{{ Auth::user()->role ?? 'Utilisateur' }}</em>
        </div>
         <button class="sidebar__toggle"
            @click="open = !open"
            title="Réduire la barre">

            <svg viewBox="0 0 18 18"
                fill="none"
                stroke="currentColor"
                stroke-width="2">

                <path d="M15 18l-6-6 6-6" />
            </svg>
        </button>
    </div>
    

    {{-- ─── Navigation ─────────────────────────────── --}}
    <nav class="sidebar__nav">
        {{-- Dashboards --}}
        <div class="nav-group">

            <a href="{{ route('dashboard.index') }}" class="nav-item"
                title="Tableau de bord">

                <span class="nav-item__icon">
                    <svg viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8">

                        <path d="M3 12h4l3 8 4-16 3 8h4" />
                    </svg>
                </span>

                <span class="nav-item__label">
                    Tableaux de bord
                </span>
            </a>

            <a href="{{ route('produits.index') }}" class="nav-item">
                <span class="nav-item__icon">
                    <svg viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8">

                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" />
                        <rect x="9" y="3" width="6" height="4" rx="1" />
                        <path d="M9 12h6" />
                        <path d="M9 16h6" />
                    </svg>
                </span>

                <span class="nav-item__label">
                    Demandes
                </span>
            </a>

            <a href="{{ route('demande_essai.index') }}" class="nav-item">
                <span class="nav-item__icon">
                    <svg viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8">

                        <path d="M9 3v11.5A3.5 3.5 0 0012.5 18v0A3.5 3.5 0 0016 14.5V3" />
                        <line x1="6" y1="3" x2="18" y2="3" />
                        <path d="M9 11h6" />
                    </svg>
                </span>

                <span class="nav-item__label">
                    Assignations Essais
                </span>
            </a>

            <a href="{{ route('demandes_confirmees.index') }}" class="nav-item">
                <span class="nav-item__icon">
                    <svg viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8">

                        <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                </span>

                <span class="nav-item__label">
                    Demandes Confirmées
                </span>
            </a>

<a href="{{ route('planifier.index') }}" class="nav-item">
                <span class="nav-item__icon">
                    <svg viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8">

                        <rect x="3" y="4" width="18" height="18" rx="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                </span>

                <span class="nav-item__label">
                    Planification
                </span>
            </a>


        </div>


        {{-- ── Administration ── --}}
        <div class="nav-section">
            <span class="nav-section__label">Administration</span>
        </div>

        {{-- Users --}}
        <div class="nav-group" x-data="{ expanded: false }">

            <button class="nav-item nav-item--parent"
                @click="expanded = !expanded"
                title="Utilisateurs & Rôles">

                <span class="nav-item__icon">
                    <svg viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8">

                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 00-3-3.87" />
                        <path d="M16 3.13a4 4 0 010 7.75" />
                    </svg>
                </span>

                <span class="nav-item__label">
                    <a href="{{ route('users.index') }}" class="block w-full h-full">
                    Utilisateurs & Rôles
                    </a>
                </span>

                <span class="nav-item__chevron"
                    :class="{ 'rotated': expanded }">

                    <svg viewBox="0 0 16 16"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2">

                        <path d="M4.5 6l3.5 3.5L11.5 6" />
                    </svg>
                </span>
            </button>


        </div>

        {{-- Laboratoires --}}
        <div class="nav-group" x-data="{ expanded: false }">

            <button class="nav-item nav-item--parent"
                @click="expanded = !expanded"
                title="Laboratoires">

                <span class="nav-item__icon">
                    <svg viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8">

                        <path d="M9 3v11.5A3.5 3.5 0 0012.5 18v0A3.5 3.5 0 0016 14.5V3" />
                        <line x1="6" y1="3" x2="18" y2="3" />
                        <path d="M9 11h6" />
                    </svg>
                </span>

                <span class="nav-item__label">
                    <a href="{{ route('laboratoires.index') }}" class="block w-full h-full">
                    Laboratoires
                    </a>
                </span>

                <span class="nav-item__chevron"
                    :class="{ 'rotated': expanded }">

                    <svg viewBox="0 0 16 16"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2">

                        <path d="M4.5 6l3.5 3.5L11.5 6" />
                    </svg>
                </span>
            </button>


        </div>



        {{-- ── Supervision ── --}}
        <div class="nav-section">
            <span class="nav-section__label">
                Supervision
            </span>
        </div>

        {{-- Logs --}}
        <div class="nav-group" x-data="{ expanded: false }">

            <button class="nav-item nav-item--parent"
                @click="expanded = !expanded"
                title="Audit & Logs">

                <span class="nav-item__icon">
                    <svg viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8">

                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                        <polyline points="9 12 11 14 15 10" />
                    </svg>
                </span>

                <span class="nav-item__label">
                    <a href="{{ route('logs.index') }}" class="block w-full h-full">
                    Audit & Logs
                    </a>
                </span>

                <span class="nav-item__chevron"
                    :class="{ 'rotated': expanded }">

                    <svg viewBox="0 0 16 16"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2">

                        <path d="M4.5 6l3.5 3.5L11.5 6" />
                    </svg>
                </span>
            </button>


        </div>

    </nav>

    {{-- ─── Footer ─────────────────────────────── --}}
    <div class="sidebar__footer">

        <a href="{{ route('profile.show') }}" class="nav-item" title="Mon profil">

            <span class="nav-item__icon">
                <svg viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8">

                    <circle cx="12" cy="8" r="4" />
                    <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                </svg>
            </span>

            <span class="nav-item__label">
                Mon profil
            </span>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit"
                class="nav-item nav-item--logout"
                title="Déconnexion">

                <span class="nav-item__icon">
                    <svg viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8">

                        <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" y1="12" x2="9" y2="12" />
                    </svg>
                </span>

                <span class="nav-item__label">
                    Déconnexion
                </span>
            </button>
        </form>
    </div>

</aside>



<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap');

:root{
    --sidebar-w:256px;
    --sidebar-w-collapsed:68px;
    --sidebar-bg:#0F1117;
    --sidebar-border:rgba(255,255,255,.06);
    --nav-text:#9BA3B5;
    --nav-text-hover:#E8EAF0;
    --nav-active-bg:rgba(79,110,247,.14);
    --nav-active-text:#7B9BFF;
    --nav-active-accent:#4F6EF7;
    --section-label:#4B5263;
    --footer-border:rgba(255,255,255,.06);
    --transition:220ms cubic-bezier(.4,0,.2,1);
    --font:'DM Sans',system-ui,sans-serif;
}

.sidebar{
    display:flex;
    flex-direction:column;
    width:var(--sidebar-w);
    min-width:var(--sidebar-w);
    flex:0 0 var(--sidebar-w);
    box-sizing:border-box;
    height:100vh;
    background:var(--sidebar-bg);
    border-right:1px solid var(--sidebar-border);
    overflow:hidden;
    position:sticky;
    top:0;
    transition:width var(--transition);
    font-family:var(--font);
}

@media (min-width: 1024px){
    .sidebar{
        position:fixed;
        left:0;
        top:0;
        z-index:40;
    }
}

.sidebar--collapsed{
    width:var(--sidebar-w-collapsed);
    min-width:var(--sidebar-w-collapsed);
    flex-basis:var(--sidebar-w-collapsed);
}

.sidebar__brand,
.sidebar__user{
    display:flex;
    align-items:center;
    gap:10px;
    padding:16px;
    border-bottom:1px solid var(--sidebar-border);
}

.sidebar__logo{
    width:32px;
    height:32px;
}

.sidebar__brand-name{
    color:#fff;
    font-weight:700;
}

.sidebar__toggle{
    margin-left:auto;
    background:none;
    border:none;
    color:#9BA3B5;
    cursor:pointer;
}

.sidebar__toggle svg{
    width:18px;
    height:18px;
}

.sidebar__avatar{
    width:34px;
    height:34px;
    border-radius:50%;
    background:linear-gradient(135deg,#4F6EF7,#7C3AED);
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:700;
    position:relative;
}

.sidebar__status{
    position:absolute;
    right:1px;
    bottom:1px;
    width:8px;
    height:8px;
    border-radius:50%;
    background:#22C55E;
}

.sidebar__user-info strong{
    display:block;
    color:#E8EAF0;
    font-size:13px;
}

.sidebar__user-info em{
    color:#7B9BFF;
    font-size:11px;
    font-style:normal;
}

.sidebar__nav{
    flex:1;
    overflow-y:auto;
    padding:10px 0;
}

.nav-section{
    padding:14px 18px 6px;
}

.nav-section__label{
    font-size:10px;
    text-transform:uppercase;
    color:#4B5263;
    font-weight:700;
}

.nav-item{
    display:flex;
    align-items:center;
    gap:10px;
    width:calc(100% - 16px);
    margin:4px 8px;
    padding:10px 14px;
    border:none;
    border-radius:8px;
    background:none;
    color:#9BA3B5;
    cursor:pointer;
    transition:.2s;
    text-align:left;
    text-decoration:none;
}

.nav-item:hover{
    background:rgba(255,255,255,.05);
    color:#fff;
}

.nav-item__icon{
    width:18px;
    height:18px;
    display:flex;
    align-items:center;
    justify-content:center;
}

.nav-item__icon svg{
    width:18px;
    height:18px;
}

.nav-item__label{
    flex:1;
}

.nav-item__chevron{
    transition:.2s;
}

.nav-item__chevron.rotated{
    transform:rotate(180deg);
}

.nav-item--child{
    padding-left:42px;
    font-size:13px;
}

.nav-item__dot{
    width:5px;
    height:5px;
    border-radius:50%;
    background:currentColor;
}

.nav-item__badge{
    font-size:10px;
    padding:2px 6px;
    border-radius:20px;
}

.nav-item__badge--orange{
    background:rgba(249,115,22,.2);
    color:#FDBA74;
}

.sidebar__footer{
    border-top:1px solid var(--footer-border);
    padding:8px 0;
}

.sidebar__footer form{
    display:contents;
}

.nav-item--logout:hover{
    background:rgba(239,68,68,.1);
    color:#FCA5A5;
}

/* collapsed */

.sidebar--collapsed .sidebar__brand-name,
.sidebar--collapsed .sidebar__user-info,
.sidebar--collapsed .nav-item__label,
.sidebar--collapsed .nav-item__chevron,
.sidebar--collapsed .nav-section__label,
.sidebar--collapsed .nav-item__badge{
    display:none;
}

.sidebar--collapsed .nav-item{
    width:44px;
    justify-content:center;
    padding:10px;
    margin:auto;
}

.sidebar--collapsed .nav-item--child{
    display:none;
}
</style>