    <style>
        /* ── Cetiev Welcome Page ── */
        @import url('https://fonts.googleapis.com/css2?family=Barlow:wght@300;400;600;700&family=Barlow+Condensed:wght@600;700&display=swap');

        :root {
            --cetiev-blue:    #1A3A6B;
            --cetiev-accent:  #2563EB;
            --cetiev-light:   #E8EEF8;
            --cetiev-silver:  #B0BEC5;
            --cetiev-dark:    #0D1F3C;
            --cetiev-white:   #F5F7FA;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        .cet-hero {
            font-family: 'Barlow', sans-serif;
            min-height: 100vh;
            background-color: var(--cetiev-dark);
            display: flex;
            flex-direction: column;
        }

        /* ── Top bar ── */
        .cet-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.2rem 3rem;
            background: rgba(13, 31, 60, 0.95);
            border-bottom: 2px solid var(--cetiev-accent);
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(6px);
        }

        .cet-logo-wrap {
            display: flex;
            align-items: center;
            gap: 0.9rem;
        }

        .cet-logo-badge {
            width: 166px;
            height: 66px;
            background: #fff;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 700;
            font-size: 1.1rem;
            color: #fff;
            letter-spacing: 0.05em;
        }

        .cet-logo-text {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 700;
            font-size: 1.4rem;
            color: #fff;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .cet-logo-text span {
            display: block;
            font-family: 'Barlow', sans-serif;
            font-weight: 300;
            font-size: 0.65rem;
            letter-spacing: 0.05em;
            color: var(--cetiev-silver);
            text-transform: none;
        }

        .cet-btn-login {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.65rem 1.6rem;
            background: var(--cetiev-accent);
            color: #fff;
            font-family: 'Barlow', sans-serif;
            font-weight: 600;
            font-size: 0.9rem;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            text-decoration: none;
            border-radius: 4px;
            transition: background 0.2s ease, transform 0.15s ease;
        }

        .cet-btn-login:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }

        .cet-btn-login svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        /* ── Main split layout ── */
        .cet-main {
            flex: 1;
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: calc(100vh - 72px);
        }

        /* Left — image panel */
       .cet-image-panel img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

       

        /* Right — content panel */
        .cet-content-panel {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 4rem 4rem 4rem 3rem;
            background: var(--cetiev-dark);
        }

        .cet-eyebrow {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.2em;
            color: var(--cetiev-accent);
            text-transform: uppercase;
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .cet-eyebrow::before {
            content: '';
            display: inline-block;
            width: 28px;
            height: 2px;
            background: var(--cetiev-accent);
        }

        .cet-headline {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 700;
            font-size: clamp(2rem, 3.5vw, 3rem);
            line-height: 1.1;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 0.5rem;
        }

        .cet-headline em {
            font-style: normal;
            color: var(--cetiev-accent);
        }

        .cet-fullname {
            font-size: 0.95rem;
            font-weight: 400;
            color: var(--cetiev-silver);
            line-height: 1.6;
            margin-bottom: 2.2rem;
            max-width: 380px;
        }

        .cet-divider {
            width: 48px;
            height: 3px;
            background: linear-gradient(90deg, var(--cetiev-accent), transparent);
            margin-bottom: 2rem;
            border-radius: 2px;
        }

        .cet-description {
            font-size: 1rem;
            color: var(--cetiev-silver);
            line-height: 1.75;
            max-width: 400px;
            margin-bottom: 2.8rem;
        }

        .cet-cta-group {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .cet-btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.85rem 2rem;
            background: var(--cetiev-accent);
            color: #fff;
            font-family: 'Barlow', sans-serif;
            font-weight: 700;
            font-size: 0.95rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            text-decoration: none;
            border-radius: 4px;
            transition: background 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 4px 18px rgba(37, 99, 235, 0.35);
        }

        .cet-btn-primary:hover {
            background: #1d4ed8;
            box-shadow: 0 6px 24px rgba(37, 99, 235, 0.5);
        }

        .cet-btn-primary svg {
            width: 18px;
            height: 18px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .cet-contact-link {
            font-size: 0.875rem;
            color: var(--cetiev-silver);
            text-decoration: none;
            border-bottom: 1px solid transparent;
            transition: color 0.2s, border-color 0.2s;
        }

        .cet-contact-link:hover {
            color: #fff;
            border-color: var(--cetiev-silver);
        }

        /* ── Stats strip ── */
        .cet-stats {
            margin-top: 3.5rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(176, 190, 197, 0.2);
            display: flex;
            gap: 2.5rem;
        }

        .cet-stat-item {}

        .cet-stat-number {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 700;
            font-size: 1.8rem;
            color: #fff;
            line-height: 1;
        }

        .cet-stat-label {
            font-size: 0.75rem;
            color: var(--cetiev-silver);
            letter-spacing: 0.05em;
            margin-top: 0.2rem;
        }

        /* ── Footer ── */
        .cet-footer {
            background: rgba(13, 31, 60, 0.95);
            border-top: 1px solid rgba(176, 190, 197, 0.15);
            padding: 1rem 3rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.78rem;
            color: var(--cetiev-silver);
        }

        .cet-footer a {
            color: var(--cetiev-silver);
            text-decoration: none;
        }

        .cet-footer a:hover { color: #fff; }

        /* ── Responsive ── */
        @media (max-width: 900px) {
            .cet-main { grid-template-columns: 1fr; }

            .cet-image-panel {
                height: 300px;
            }

            .cet-image-overlay {
                background: linear-gradient(
                    180deg,
                    transparent 40%,
                    var(--cetiev-dark) 100%
                );
            }

            .cet-content-panel {
                padding: 2.5rem 1.5rem;
            }

            .cet-topbar {
                padding: 1rem 1.5rem;
            }

            .cet-stats { gap: 1.5rem; }
        }
    </style>

    {{-- ── TOP BAR ── --}}
    <div class="cet-hero">
        <header class="cet-topbar">
            <div class="cet-logo-wrap">
                <div class="cet-logo-badge">
                    <x-application-logo class="block h-6 w-auto fill-current text-white" />
                </div>
                
            </div>

            <a href="{{ route('login') }}" class="cet-btn-login">
                <svg viewBox="0 0 24 24">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                    <polyline points="10 17 15 12 10 7"/>
                    <line x1="15" y1="12" x2="3" y2="12"/>
                </svg>
                Se connecter
            </a>
        </header>

        {{-- ── MAIN SPLIT ── --}}
        <main class="cet-main">

            {{-- Image panel --}}
            <div class="cet-image-panel">
               <x-cetiev-image />
                <div class="cet-image-overlay"></div>
            </div>

            {{-- Content panel --}}
            <div class="cet-content-panel">

                <p class="cet-eyebrow">Plateforme officielle</p>

                <h1 class="cet-headline">
                    <em>CETIEV</em><br>
                    Portail de gestion
                </h1>

                <p class="cet-fullname">
                    Centre Technique des Industries<br>
                    des Équipements pour Véhicules
                </p>

                <div class="cet-divider"></div>

                <p class="cet-description">
                    Bienvenue sur la plateforme interne du CETIEV.
                    Accédez à vos espaces de travail, suivez les dossiers techniques
                    et coordonnez les demandes d’essais et de planification.
                </p>

             
                </div>

              
            </div>

        </main>

        {{-- ── FOOTER ── --}}
        <footer class="cet-footer">
            <span>&copy; {{ date('Y') }} CETIEV — Tous droits réservés</span>
           
        </footer>
    </div>
