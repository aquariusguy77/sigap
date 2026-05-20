<style>
    :root{
        --surface:#ffffff;
        --surface-soft:#f0fafa;
        --surface-warm:#fdf8ea;
        --text:#0b3640;
        --muted:#5d7884;
        --line:#dbe9ec;
        --tosca:#0891b2;
        --tosca-deep:#155e75;
        --tosca-soft:#cffafe;
        --tosca-tint:rgba(8,145,178,.10);
        --gold:#d4a017;
        --gold-deep:#a17912;
        --gold-soft:#fef3c7;
        --gold-tint:rgba(212,160,23,.12);
        --green:#0d9488;
        --danger:#dc2626;
        --warn:#ea8a1a;
        --shadow-sm:0 4px 14px rgba(11,54,64,.06);
        --shadow:0 18px 48px rgba(11,54,64,.10);
        --shadow-lg:0 28px 70px rgba(11,54,64,.14);
        --sidebar-width:286px;
        --topbar-height:80px;
        --radius:18px;
        --radius-lg:24px;
        --radius-xl:30px;
    }
    *{box-sizing:border-box}
    html{scroll-behavior:smooth}
    body{
        margin:0;
        font-family:'Plus Jakarta Sans',Poppins,Inter,"Segoe UI",sans-serif;
        color:var(--text);
        background:
            radial-gradient(circle at 8% 6%,rgba(8,145,178,.10),transparent 35%),
            radial-gradient(circle at 96% 4%,rgba(212,160,23,.10),transparent 32%),
            radial-gradient(circle at 80% 92%,rgba(13,148,136,.08),transparent 36%),
            linear-gradient(180deg,#f5fbfb 0%,#fefdf8 55%,#f3f9fa 100%);
        min-height:100vh;
    }
    a{color:inherit;text-decoration:none}
    button,input,select,textarea{font:inherit}
    img,svg{max-width:100%;display:block}

    /* SHELL */
    .app-shell{display:grid;grid-template-columns:var(--sidebar-width) minmax(0,1fr);min-height:100vh}
    .sidebar{
        position:sticky;top:0;display:flex;flex-direction:column;
        height:100vh;padding:26px 20px;
        background:linear-gradient(180deg,#06343d 0%,#0a4a57 48%,#0e6473 100%);
        color:#e9f9fb;
        box-shadow:inset -1px 0 0 rgba(255,255,255,.06), 6px 0 30px rgba(6,52,61,.12);
        z-index:20;overflow:hidden;
    }
    .sidebar::before{
        content:"";position:absolute;inset:-30% -40% auto auto;width:320px;height:320px;
        background:radial-gradient(circle,rgba(212,160,23,.22),transparent 65%);pointer-events:none;
    }
    .brand{display:flex;align-items:center;gap:14px;margin-bottom:24px;position:relative;z-index:1}
    .brand-mark{
        width:54px;height:54px;display:grid;place-items:center;border-radius:18px;
        background:linear-gradient(135deg,rgba(212,160,23,.85),rgba(212,160,23,.45));
        border:1px solid rgba(255,255,255,.18);
        box-shadow:0 12px 28px rgba(212,160,23,.30),inset 0 1px 0 rgba(255,255,255,.30);
        color:#fff;
    }
    .brand h1{margin:0;font-size:1.05rem;line-height:1.25;font-weight:800;letter-spacing:.4px}
    .brand p{margin:3px 0 0;font-size:.78rem;color:rgba(233,249,251,.74)}
    .sidebar-note{
        position:relative;z-index:1;
        margin:0 0 14px;padding:13px 15px;border-radius:16px;
        background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.10);
        font-size:.84rem;line-height:1.55;color:rgba(233,249,251,.84);
    }
    .nav-label{display:block;margin:14px 8px 10px;font-size:.7rem;font-weight:700;letter-spacing:.10em;text-transform:uppercase;color:rgba(233,249,251,.55);position:relative;z-index:1}
    .menu{display:grid;gap:6px;flex:1 1 auto;min-height:0;overflow:auto;padding-right:6px;margin-right:-6px;position:relative;z-index:1}
    .menu::-webkit-scrollbar{width:5px}
    .menu::-webkit-scrollbar-thumb{background:rgba(255,255,255,.14);border-radius:4px}
    .menu-link{
        display:flex;align-items:center;gap:12px;padding:11px 14px;border-radius:14px;
        transition:transform .22s ease,background .22s ease,box-shadow .22s ease;
        position:relative;
    }
    .menu-link:hover{background:rgba(255,255,255,.10);transform:translateX(3px)}
    .menu-link.active{
        background:linear-gradient(135deg,rgba(212,160,23,.22),rgba(212,160,23,.10));
        box-shadow:inset 3px 0 0 var(--gold),0 8px 22px rgba(212,160,23,.18);
    }
    .menu-link.active::before{
        content:"";position:absolute;left:-20px;top:50%;transform:translateY(-50%);
        width:4px;height:24px;border-radius:0 4px 4px 0;background:var(--gold);
    }
    .menu-link span:last-child{color:#f3fbfc;font-size:.93rem;font-weight:500}
    .menu-link.active span:last-child{font-weight:600}
    .menu-icon,.section-icon,.stat-icon,.chip-icon{width:20px;height:20px;flex:0 0 20px}
    .sidebar-footer{display:grid;gap:10px;margin-top:auto;padding-top:16px;flex-shrink:0;position:relative;z-index:1}
    .status-card,.logout-button{border-radius:16px;border:1px solid rgba(255,255,255,.12);background:rgba(255,255,255,.08)}
    .status-card{padding:12px 14px}
    .status-card strong{display:block;margin-bottom:4px;font-size:.88rem;color:#fdf8ea}
    .status-note{margin:0;font-size:.78rem;line-height:1.5;color:rgba(233,249,251,.74)}
    .logout-button{
        display:flex;align-items:center;justify-content:center;gap:10px;
        padding:11px 14px;color:#fff;cursor:pointer;
        background:linear-gradient(135deg,rgba(220,38,38,.25),rgba(220,38,38,.10));
        border-color:rgba(220,38,38,.30);
        transition:background .2s ease;
    }
    .logout-button:hover{background:linear-gradient(135deg,rgba(220,38,38,.40),rgba(220,38,38,.20))}

    /* TOPBAR */
    .main-content{min-width:0}
    .topbar{
        position:sticky;top:0;z-index:15;
        display:flex;align-items:center;justify-content:space-between;gap:18px;
        min-height:var(--topbar-height);padding:18px 30px;
        background:rgba(253,252,247,.86);
        backdrop-filter:blur(14px) saturate(140%);
        border-bottom:1px solid rgba(11,54,64,.06);
    }
    .topbar-left,.topbar-right{display:flex;align-items:center;gap:14px}
    .sidebar-toggle{
        display:none;width:44px;height:44px;border:none;border-radius:14px;
        background:var(--surface);box-shadow:var(--shadow-sm);color:var(--tosca);cursor:pointer;
    }
    .page-title h2{margin:0;font-size:1.4rem;font-weight:800;letter-spacing:-.01em}
    .page-title p{margin:4px 0 0;color:var(--muted);font-size:.92rem;max-width:560px}
    .toolbar-search{
        display:flex;align-items:center;gap:10px;width:min(420px,100%);
        padding:11px 16px;border-radius:14px;
        background:var(--surface);border:1px solid rgba(8,145,178,.10);
        box-shadow:var(--shadow-sm);
    }
    .toolbar-search input{width:100%;border:none;outline:none;background:transparent;color:var(--text)}
    .toolbar-search:focus-within{border-color:rgba(8,145,178,.35);box-shadow:0 0 0 4px rgba(8,145,178,.10)}

    /* CHIPS / BADGES */
    .status-pill,.badge,.mini-badge{display:inline-flex;align-items:center;gap:7px;border-radius:999px;font-size:.8rem;font-weight:600}
    .status-pill{padding:10px 14px;background:var(--tosca-tint);color:var(--tosca-deep);border:1px solid rgba(8,145,178,.16)}
    .user-chip{
        display:flex;align-items:center;gap:12px;padding:7px 12px 7px 7px;
        border-radius:18px;background:var(--surface);box-shadow:var(--shadow-sm);
        border:1px solid rgba(11,54,64,.05);
    }
    .avatar{
        width:42px;height:42px;display:grid;place-items:center;border-radius:13px;
        background:linear-gradient(135deg,var(--tosca),var(--gold));color:#fff;font-weight:700;
        box-shadow:0 6px 14px rgba(8,145,178,.24);
    }
    .user-chip strong{display:block;font-size:.92rem}
    .user-chip small{color:var(--muted);font-size:.78rem}

    /* HERO */
    .page-body{padding:22px 30px 34px}
    .hero-panel{
        position:relative;overflow:hidden;
        display:grid;grid-template-columns:1.35fr .85fr;gap:24px;
        padding:32px;border-radius:var(--radius-xl);
        background:
            linear-gradient(135deg,rgba(6,52,61,.96),rgba(14,100,115,.94)),
            radial-gradient(circle at 90% 0%,rgba(212,160,23,.22),transparent 50%);
        box-shadow:var(--shadow-lg);
        color:#fff;
    }
    .hero-panel::before{
        content:"";position:absolute;left:-60px;top:-80px;width:260px;height:260px;border-radius:50%;
        background:radial-gradient(circle,rgba(212,160,23,.32),transparent 65%);
        filter:blur(8px);pointer-events:none;
    }
    .hero-panel::after{
        content:"";position:absolute;right:-90px;bottom:-100px;width:300px;height:300px;border-radius:40px;
        background:linear-gradient(135deg,rgba(212,160,23,.18),rgba(255,255,255,.04));
        transform:rotate(28deg);pointer-events:none;
    }
    .eyebrow,.hero-copy p,.hero-meta,.highlight-card p{color:rgba(255,255,255,.80)}
    .eyebrow{
        display:inline-flex;align-items:center;gap:8px;padding:8px 14px;border-radius:999px;
        background:rgba(212,160,23,.20);color:#fef3c7;
        font-size:.78rem;font-weight:600;border:1px solid rgba(212,160,23,.30);position:relative;z-index:1;
    }
    .hero-copy h3{margin:18px 0 12px;font-size:clamp(1.85rem,3vw,2.8rem);line-height:1.12;font-weight:800;letter-spacing:-.02em;position:relative;z-index:1}
    .hero-copy p{max-width:600px;margin:0;font-size:.96rem;line-height:1.75;position:relative;z-index:1}
    .hero-meta{display:flex;flex-wrap:wrap;gap:22px;margin-top:24px;position:relative;z-index:1}
    .hero-meta strong,.highlight-card strong{display:block;color:#fff;font-size:1.05rem;font-weight:700}
    .hero-meta span,.highlight-card p{font-size:.82rem;line-height:1.6}
    .hero-side{position:relative;z-index:1;display:grid;gap:14px;align-content:start}
    .highlight-card{
        padding:18px 20px;border-radius:20px;
        background:rgba(255,255,255,.10);border:1px solid rgba(255,255,255,.14);
        backdrop-filter:blur(12px);
    }

    /* SECTIONS */
    .highlight-head,.section-head,.table-toolbar,.split-header,.setting-head{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap}
    .highlight-head{margin-bottom:14px}
    .mini-badge{padding:6px 11px;color:#856010;background:var(--gold-tint);border:1px solid rgba(212,160,23,.22)}

    /* GRIDS */
    .dashboard-grid,.content-grid,.triple-grid,.double-grid{display:grid;gap:22px;margin-top:24px}
    .dashboard-grid{grid-template-columns:repeat(12,minmax(0,1fr));align-items:stretch}
    .content-grid{grid-template-columns:minmax(0,1.55fr) minmax(320px,.95fr);align-items:start}
    .double-grid{grid-template-columns:repeat(2,minmax(0,1fr))}
    .triple-grid{grid-template-columns:repeat(3,minmax(0,1fr))}

    /* CARDS */
    .stat-card,.panel,.list-item,.timeline-item,.setting-card{
        background:var(--surface);border:1px solid rgba(11,54,64,.05);box-shadow:var(--shadow);
    }
    .stat-card{
        display:flex;flex-direction:column;min-height:212px;padding:22px;border-radius:var(--radius-lg);
        overflow:hidden;transition:transform .25s ease,box-shadow .25s ease;position:relative;
    }
    .stat-card::before{
        content:"";position:absolute;left:0;right:0;top:0;height:3px;
        background:linear-gradient(90deg,var(--tosca),var(--gold));opacity:.7;
    }
    .stat-card:hover{transform:translateY(-3px);box-shadow:var(--shadow-lg)}
    .stat-head{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:18px}
    .stat-icon-wrap,.section-icon-wrap{display:grid;place-items:center;border-radius:14px}
    .stat-icon-wrap{width:46px;height:46px;background:var(--tosca-tint);color:var(--tosca-deep)}
    .tone-green{color:var(--green)!important;background:rgba(13,148,136,.10)!important}
    .tone-orange{color:var(--warn)!important;background:var(--gold-tint)!important}
    .tone-deep{color:var(--gold-deep)!important;background:rgba(212,160,23,.14)!important}
    .stat-card h4,.panel h4{margin:0;font-size:.95rem;font-weight:700}
    .stat-card strong{display:block;margin:0 0 8px;font-size:2.1rem;line-height:1;font-weight:800;letter-spacing:-.02em;color:var(--tosca-deep)}
    .metric-note{margin:0;color:var(--muted);font-size:.84rem;line-height:1.6}
    .dashboard-grid .stat-card{grid-column:span 4}
    .stat-card.featured{
        position:relative;grid-column:9/span 4;grid-row:1/span 2;justify-content:space-between;
        background:
            linear-gradient(180deg,rgba(6,52,61,.97),rgba(14,100,115,.95)),
            radial-gradient(circle at 80% 100%,rgba(212,160,23,.22),transparent 60%);
        border-color:rgba(6,52,61,.18);color:#fff;
        box-shadow:0 28px 56px rgba(6,52,61,.22);
    }
    .stat-card.featured::before{display:none}
    .stat-card.featured::after{
        content:"";position:absolute;right:-48px;bottom:-56px;width:200px;height:200px;border-radius:32px;
        background:linear-gradient(135deg,rgba(212,160,23,.32),rgba(255,255,255,.05));transform:rotate(18deg);
    }
    .stat-card.featured .stat-head,.stat-card.featured strong,.stat-card.featured .metric-note{position:relative;z-index:1}
    .stat-card.featured .stat-head h4{color:#fdf8ea}
    .stat-card.featured strong{color:#fff}
    .stat-card.featured .metric-note{color:rgba(255,255,255,.84);max-width:18rem}
    .stat-card.featured .stat-icon-wrap{background:rgba(212,160,23,.25);color:var(--gold-soft)}

    .panel{border-radius:var(--radius-lg);padding:26px}
    .section-tag{
        display:inline-flex;align-items:center;gap:8px;padding:8px 13px;border-radius:999px;
        background:var(--tosca-tint);color:var(--tosca-deep);font-size:.78rem;font-weight:700;
        border:1px solid rgba(8,145,178,.18);
    }
    .section-tag.gold{background:var(--gold-tint);color:var(--gold-deep);border-color:rgba(212,160,23,.22)}
    .section-head{margin-bottom:18px}
    .section-head h3,.split-header h3,.setting-head h3{margin:0;font-size:1.1rem;font-weight:700;letter-spacing:-.01em}
    .section-intro,.split-header p,.setting-copy p,.table-toolbar p{margin:6px 0 0;color:var(--muted);font-size:.9rem;line-height:1.65}
    .badge{padding:8px 12px;background:rgba(11,54,64,.06);color:var(--text)}
    .table-toolbar{margin:20px 0 16px}
    .filters{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:12px;margin-bottom:16px}

    /* FORM CONTROLS */
    .control{
        padding:12px 14px;outline:none;color:var(--text);
        border-radius:14px;border:1px solid var(--line);background:#fafdfd;
        transition:border-color .2s ease,box-shadow .2s ease,background .2s ease;
        width:100%;
    }
    .control:focus{border-color:var(--tosca);box-shadow:0 0 0 4px rgba(8,145,178,.12);background:#fff}
    .control::placeholder{color:#9bb0b9}
    .step-card,.doc-card,.report-card{border-radius:16px;border:1px solid var(--line);background:#fbfdfd}

    /* BUTTONS */
    .btn{
        display:inline-flex;align-items:center;gap:8px;
        padding:11px 18px;border:none;border-radius:14px;
        font-weight:600;font-size:.9rem;cursor:pointer;
        transition:transform .15s ease,box-shadow .2s ease,background .2s ease;
        text-decoration:none;
    }
    .btn-primary{
        background:linear-gradient(135deg,var(--tosca),var(--tosca-deep));color:#fff;
        box-shadow:0 10px 24px rgba(8,145,178,.30);
    }
    .btn-primary:hover{transform:translateY(-1px);box-shadow:0 14px 28px rgba(8,145,178,.36)}
    .btn-gold{
        background:linear-gradient(135deg,var(--gold),var(--gold-deep));color:#fff;
        box-shadow:0 10px 24px rgba(212,160,23,.30);
    }
    .btn-gold:hover{transform:translateY(-1px);box-shadow:0 14px 28px rgba(212,160,23,.36)}
    .btn-ghost{background:var(--surface);color:var(--text);border:1px solid var(--line);box-shadow:var(--shadow-sm)}
    .btn-ghost:hover{background:#f7fafa;border-color:var(--tosca);color:var(--tosca-deep)}
    .btn-danger{background:linear-gradient(135deg,#ef4444,#b91c1c);color:#fff;box-shadow:0 10px 24px rgba(220,38,38,.28)}
    .btn-danger:hover{transform:translateY(-1px)}
    .btn-sm{padding:8px 13px;font-size:.84rem;border-radius:11px}

    /* TABLES */
    table{width:100%;border-collapse:collapse}
    th,td{padding:14px 12px;text-align:left;border-bottom:1px solid rgba(11,54,64,.07);vertical-align:top;font-size:.91rem}
    th{color:var(--muted);font-size:.74rem;text-transform:uppercase;letter-spacing:.06em;font-weight:700;background:rgba(8,145,178,.03)}
    tbody tr{transition:background .15s ease}
    tbody tr:hover{background:rgba(8,145,178,.04)}
    .table-meta{color:var(--muted);font-size:.82rem}
    .badge.success,.mini-badge.success{background:rgba(13,148,136,.12);color:#0c635c;border:1px solid rgba(13,148,136,.20)}
    .badge.warn,.mini-badge.warn{background:rgba(234,138,26,.14);color:#9a560a;border:1px solid rgba(234,138,26,.22)}
    .badge.danger,.mini-badge.danger{background:rgba(220,38,38,.12);color:#9b1c1c;border:1px solid rgba(220,38,38,.20)}

    /* LIST / TIMELINE */
    .list-group,.timeline,.settings-grid{display:grid;gap:14px}
    .list-item,.timeline-item,.setting-card{padding:20px;border-radius:18px;transition:transform .2s ease,box-shadow .2s ease}
    .list-item:hover,.timeline-item:hover{transform:translateY(-2px);box-shadow:var(--shadow-lg)}
    .list-item strong,.timeline-item strong,.setting-card strong,.doc-card strong,.report-card strong,.step-card strong{display:block;margin-bottom:6px;font-size:.95rem;font-weight:700}
    .list-item p,.timeline-item p,.setting-card p,.doc-card p,.report-card p,.step-card p{margin:0;color:var(--muted);font-size:.86rem;line-height:1.65}
    .split{display:grid;grid-template-columns:minmax(0,1.15fr) minmax(0,.85fr);gap:20px}
    .step-grid,.doc-grid,.report-grid{display:grid;gap:14px;margin-top:18px}
    .step-grid{grid-template-columns:repeat(4,minmax(0,1fr))}
    .doc-grid,.report-grid{grid-template-columns:repeat(2,minmax(0,1fr))}
    .step-card,.doc-card,.report-card{padding:18px}
    .step-card.active{
        border-color:rgba(8,145,178,.30);
        background:linear-gradient(180deg,rgba(8,145,178,.08),rgba(212,160,23,.06));
        box-shadow:var(--shadow-sm);
    }
    .step-index{
        display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;
        margin-bottom:12px;border-radius:12px;
        background:linear-gradient(135deg,var(--tosca-tint),var(--gold-tint));
        color:var(--tosca-deep);font-weight:700;font-size:.95rem;
    }
    .subtle-box{
        margin-top:18px;padding:18px;border-radius:18px;
        background:linear-gradient(180deg,#f8fdfd 0%,#eef9fb 100%);
        border:1px dashed rgba(8,145,178,.28);
    }
    .subtle-box h4{margin:0 0 10px;font-size:.96rem;font-weight:700}
    .subtle-box ul{margin:0;padding-left:18px;color:var(--muted);line-height:1.8;font-size:.88rem}
    .timeline-item{display:grid;grid-template-columns:54px minmax(0,1fr);gap:14px;align-items:start}
    .timeline-mark{
        width:54px;height:54px;display:grid;place-items:center;border-radius:16px;
        background:linear-gradient(135deg,var(--tosca-tint),var(--gold-tint));
        color:var(--tosca-deep);
        box-shadow:0 6px 14px rgba(8,145,178,.12);
    }
    .timeline-meta{margin-top:8px;color:var(--muted);font-size:.78rem}
    .report-card{background:linear-gradient(180deg,#fff 0%,#f7fcfc 100%)}
    .setting-card{display:flex;gap:16px;align-items:flex-start}
    .section-anchor{scroll-margin-top:100px}

    /* FLASH / ALERTS */
    .flash{
        margin-bottom:18px;padding:14px 18px;border-radius:14px;
        background:linear-gradient(135deg,rgba(13,148,136,.10),rgba(8,145,178,.06));
        border:1px solid rgba(13,148,136,.22);color:#0c635c;
        display:flex;align-items:center;gap:12px;font-weight:500;
    }
    .alert-error{
        background:linear-gradient(135deg,rgba(220,38,38,.10),rgba(220,38,38,.04));
        border-color:rgba(220,38,38,.22);color:#9b1c1c;
    }
    .alert-error ul{margin:6px 0 0;padding-left:18px}

    /* FOOTER */
    .footer{margin-top:30px;padding:22px 8px 0;color:var(--muted);font-size:.85rem;border-top:1px dashed rgba(11,54,64,.10)}
    .footer strong{color:var(--text)}
    .overlay{display:none}

    /* RESPONSIVE */
    @media (max-width:1240px){
        .dashboard-grid{grid-template-columns:repeat(2,minmax(0,1fr))}
        .dashboard-grid .stat-card,.stat-card.featured{grid-column:auto;grid-row:auto}
        .stat-card.featured{min-height:212px}
        .step-grid{grid-template-columns:repeat(2,minmax(0,1fr))}
        .content-grid,.split,.double-grid,.doc-grid,.report-grid,.triple-grid,.hero-panel{grid-template-columns:1fr}
        .filters{grid-template-columns:repeat(2,minmax(0,1fr))}
    }
    @media (max-width:980px){
        .app-shell{grid-template-columns:1fr}
        .sidebar{position:fixed;inset:0 auto 0 0;width:min(86vw,320px);transform:translateX(-100%);transition:transform .28s ease}
        .sidebar.open{transform:translateX(0)}
        .sidebar-toggle,.overlay.visible{display:inline-grid}
        .overlay.visible{position:fixed;inset:0;background:rgba(6,30,38,.46);backdrop-filter:blur(2px);z-index:18}
        .topbar{padding:18px 20px}
        .topbar-left,.topbar-right{width:100%}
        .topbar-right{justify-content:stretch}
        .status-pill,.toolbar-search,.user-chip{width:100%}
        .status-pill{justify-content:center}
        .page-body{padding:16px 20px 30px}
        .topbar,.topbar-right{flex-wrap:wrap}
        .hero-meta{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:14px}
    }
    @media (max-width:640px){
        .dashboard-grid,.filters,.step-grid,.doc-grid,.report-grid,.triple-grid{grid-template-columns:1fr}
        .hero-panel,.panel,.stat-card{padding:22px;border-radius:22px}
        .hero-meta{grid-template-columns:1fr}
        .topbar{min-height:auto}
        .page-title h2{font-size:1.1rem}
        .user-chip{width:100%;justify-content:flex-start}
        .status-pill{justify-content:flex-start}
        th:nth-child(4),td:nth-child(4),th:nth-child(6),td:nth-child(6){display:none}
    }
</style>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
