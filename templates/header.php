<?php
/** @var string $appName */
/** @var array|null $currentUser */
/** @var array $flashMessages */
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($appName) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --pcm-brand-gradient: linear-gradient(135deg, #4f46e5 0%, #0ea5e9 100%);
            --pcm-brand-secondary: linear-gradient(135deg, #f97316 0%, #ec4899 100%);
            --pcm-surface: #ffffff;
            --pcm-surface-alt: rgba(79, 70, 229, 0.08);
            --pcm-background: #eef2ff;
            --pcm-text: #111827;
            --pcm-muted: #6b7280;
        }

        * {
            letter-spacing: -0.01em;
        }

        body {
            background:
                radial-gradient(120% 120% at 100% 0%, rgba(14, 165, 233, 0.18) 0%, rgba(14, 165, 233, 0) 70%),
                radial-gradient(120% 120% at 0% 100%, rgba(79, 70, 229, 0.18) 0%, rgba(79, 70, 229, 0) 65%),
                linear-gradient(180deg, #f8fafc 0%, #e0e7ff 100%);
            font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
            color: var(--pcm-text);
            min-height: 100vh;
        }

        .app-layout {
            backdrop-filter: blur(14px);
        }

        .app-sidebar {
            background: radial-gradient(circle at 20% 20%, rgba(236, 72, 153, 0.45) 0%, transparent 55%),
                        linear-gradient(205deg, #0f172a 0%, #1d4ed8 48%, #2563eb 100%);
            color: rgba(255, 255, 255, 0.92);
            min-height: 100vh;
            position: relative;
            overflow: hidden;
            box-shadow: 12px 0 40px rgba(15, 23, 42, 0.25);
        }

        .app-sidebar::after {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 10% 20%, rgba(255, 255, 255, 0.14), transparent 45%),
                        radial-gradient(circle at 80% 90%, rgba(255, 255, 255, 0.12), transparent 55%);
            pointer-events: none;
        }

        .app-sidebar .border-light-subtle {
            border-color: rgba(255, 255, 255, 0.16) !important;
        }

        .app-sidebar nav {
            padding: 1rem 0;
        }

        .app-sidebar nav a + a {
            margin-top: 0.35rem;
        }

        .app-sidebar a {
            color: rgba(255, 255, 255, 0.78);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.85rem 1.5rem;
            font-weight: 500;
            position: relative;
            transition: all 0.25s ease;
            z-index: 1;
            border-radius: 0 18px 18px 0;
            margin-right: 1.5rem;
        }

        .app-sidebar a .bi {
            opacity: 0.85;
        }

        .app-sidebar a:hover,
        .app-sidebar a:focus {
            color: #fff;
            transform: translateX(6px);
        }

        .app-sidebar a.active {
            color: #fff;
        }

        .app-sidebar a::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.14), rgba(255, 255, 255, 0.05));
            border-left: 3px solid rgba(255, 255, 255, 0);
            border-radius: inherit;
            transform: scaleX(0.2);
            opacity: 0;
            transition: all 0.25s ease;
            z-index: -1;
        }

        .app-sidebar a:hover::before,
        .app-sidebar a:focus::before,
        .app-sidebar a.active::before {
            transform: scaleX(1);
            opacity: 1;
            border-left-color: rgba(255, 255, 255, 0.8);
        }

        .app-logo {
            font-weight: 700;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: #fff;
            font-size: 1.1rem;
        }

        .app-sidebar .small {
            letter-spacing: 0.12em;
        }

        main {
            padding: clamp(1.75rem, 4vw, 3rem);
        }

        .app-content {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.92) 0%, rgba(248, 250, 252, 0.94) 100%);
            backdrop-filter: blur(12px);
            border-top-left-radius: 36px;
            border-top-right-radius: 36px;
            min-height: 100vh;
        }

        .app-main-inner {
            max-width: 1240px;
            margin: 0 auto;
        }

        .app-page-header {
            background: radial-gradient(140% 140% at 0% 0%, rgba(79, 70, 229, 0.12) 0%, rgba(79, 70, 229, 0) 60%),
                        radial-gradient(140% 140% at 100% 100%, rgba(14, 165, 233, 0.12) 0%, rgba(14, 165, 233, 0) 55%),
                        rgba(255, 255, 255, 0.78);
            border: 1px solid rgba(15, 23, 42, 0.06);
            border-radius: 26px;
            padding: 1.75rem 2rem;
            margin-bottom: 2.75rem;
            box-shadow: 0 35px 70px -40px rgba(15, 23, 42, 0.45);
            position: relative;
            overflow: hidden;
        }

        .app-page-header::after {
            content: '';
            position: absolute;
            top: -60px;
            right: -40px;
            width: 220px;
            height: 220px;
            background: conic-gradient(from 140deg, rgba(79, 70, 229, 0.18), rgba(14, 165, 233, 0));
            filter: blur(0.5px);
            opacity: 0.65;
            pointer-events: none;
        }

        .app-page-header h1 {
            font-weight: 600;
            letter-spacing: -0.02em;
        }

        .app-page-header p {
            margin-bottom: 0;
            color: var(--pcm-muted);
            max-width: 40ch;
        }

        .app-kicker {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.35rem 0.85rem;
            border-radius: 999px;
            background: rgba(79, 70, 229, 0.12);
            color: #4f46e5;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 0.16em;
        }

        .app-toolbar {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .app-toolbar-divider {
            width: 1px;
            height: 32px;
            background: rgba(15, 23, 42, 0.1);
        }

        .app-toolbar-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            padding: 0.45rem 0.85rem;
            border-radius: 999px;
            background: rgba(79, 70, 229, 0.08);
            color: #312e81;
            font-weight: 600;
        }

        .btn-primary {
            background: var(--pcm-brand-gradient);
            border: none;
            box-shadow: 0 18px 45px rgba(79, 70, 229, 0.35);
            border-radius: 14px;
            padding: 0.75rem 1.35rem;
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background: linear-gradient(135deg, #4338ca 0%, #0284c7 100%);
            box-shadow: 0 20px 50px rgba(30, 64, 175, 0.4);
        }

        .btn-soft {
            background: rgba(15, 23, 42, 0.04);
            border-radius: 14px;
            padding: 0.75rem 1.35rem;
            border: 1px solid rgba(15, 23, 42, 0.08);
            color: #1e3a8a;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-soft:hover,
        .btn-soft:focus {
            background: rgba(79, 70, 229, 0.12);
            border-color: rgba(79, 70, 229, 0.18);
            color: #312e81;
        }

        .btn-outline-light {
            border-color: rgba(255, 255, 255, 0.6);
            color: #fff;
        }

        .btn-outline-light:hover,
        .btn-outline-light:focus {
            background: rgba(255, 255, 255, 0.16);
            border-color: transparent;
        }

        .card {
            border: 0;
            border-radius: 26px;
            box-shadow: 0 35px 70px -40px rgba(15, 23, 42, 0.4);
            background: var(--pcm-surface);
            overflow: hidden;
        }

        .card-header {
            border-bottom: 0;
            background: transparent;
            font-weight: 600;
        }

        .card-body {
            padding: 1.75rem 2rem;
        }

        .app-metric-card {
            position: relative;
            border-radius: 24px;
            overflow: hidden;
            color: #0f172a;
        }

        .app-metric-card::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            background: radial-gradient(circle at 110% -20%, rgba(255, 255, 255, 0.65), transparent 55%);
            pointer-events: none;
        }

        .app-metric-card .card-body {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 1.25rem;
            padding: 1.5rem 1.75rem;
        }

        .app-metric-card--blue {
            background: linear-gradient(135deg, #4338ca 0%, #6366f1 100%);
            color: #f8fafc;
        }

        .app-metric-card--emerald {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            color: #ecfdf5;
        }

        .app-metric-card--amber {
            background: linear-gradient(135deg, #f97316 0%, #facc15 100%);
            color: #451a03;
        }

        .app-metric-card--sky {
            background: linear-gradient(135deg, #0ea5e9 0%, #22d3ee 100%);
            color: #0f172a;
        }

        .app-metric-card--violet {
            background: linear-gradient(135deg, #7c3aed 0%, #c084fc 100%);
            color: #f5f3ff;
        }

        .app-metric-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 3.5rem;
            height: 3.5rem;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.22);
            color: inherit;
            font-size: 1.8rem;
        }

        .app-section-head {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.92), rgba(248, 250, 252, 0.92));
            border: 1px solid rgba(15, 23, 42, 0.05);
            border-radius: 24px;
            padding: 1.5rem 1.75rem;
            margin-bottom: 1.75rem;
            box-shadow: 0 24px 55px -40px rgba(15, 23, 42, 0.35);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .app-section-head h2 {
            margin-bottom: 0.35rem;
        }

        .app-section-head p {
            margin-bottom: 0;
            color: var(--pcm-muted);
        }

        .app-section-head .btn {
            box-shadow: none;
        }

        .app-section-head .btn-primary {
            box-shadow: 0 18px 40px rgba(99, 102, 241, 0.35);
        }

        .app-table-card .card-body {
            padding: 0;
        }

        .app-table-card .table-responsive {
            padding: 1.5rem 1.75rem;
        }

        .table {
            --bs-table-bg: transparent;
            margin-bottom: 0;
        }

        .table > :not(caption) > * > * {
            padding: 1rem 1.15rem;
            vertical-align: middle;
            border-bottom-color: rgba(15, 23, 42, 0.06);
        }

        .table thead th {
            text-transform: uppercase;
            font-size: 0.72rem;
            letter-spacing: 0.14em;
            color: var(--pcm-muted);
            border-bottom: 1px solid rgba(15, 23, 42, 0.08);
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.08), rgba(14, 165, 233, 0.05));
        }

        .table tbody tr {
            transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        }

        .table tbody tr:hover {
            background: rgba(79, 70, 229, 0.08);
            transform: translateY(-1px);
            box-shadow: inset 0 0 0 1px rgba(79, 70, 229, 0.12);
        }

        .badge {
            border-radius: 999px;
            padding: 0.45rem 0.9rem;
            font-weight: 600;
            letter-spacing: 0.04em;
        }

        .list-group-item {
            padding: 1rem 0;
            border: none;
            border-bottom: 1px solid rgba(15, 23, 42, 0.06);
        }

        .list-group-item:last-child {
            border-bottom: none;
        }

        .form-control,
        .form-select {
            border-radius: 16px;
            border-color: rgba(15, 23, 42, 0.08);
            padding: 0.85rem 1rem;
            background-color: rgba(255, 255, 255, 0.9);
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 0.25rem rgba(79, 70, 229, 0.15);
            border-color: rgba(79, 70, 229, 0.65);
        }

        .app-form-card .card-body {
            padding: 2rem 2.5rem;
        }

        .alert {
            border-radius: 20px;
            border: none;
            box-shadow: 0 20px 45px rgba(79, 70, 229, 0.15);
        }

        .btn-light {
            border-radius: 14px;
            padding: 0.75rem 1.35rem;
            border: 1px solid rgba(15, 23, 42, 0.1);
            color: #334155;
            font-weight: 600;
        }

        .btn-light:hover,
        .btn-light:focus {
            background: rgba(148, 163, 184, 0.15);
            border-color: rgba(148, 163, 184, 0.35);
        }

        @media (max-width: 1199.98px) {
            .app-main-inner {
                padding-inline: 1rem;
            }
        }

        @media (max-width: 991.98px) {
            .app-sidebar {
                min-height: auto;
                border-bottom-left-radius: 0;
                border-bottom-right-radius: 0;
            }

            .app-sidebar a {
                padding-inline: 1.25rem;
            }

            .app-content {
                border-top-left-radius: 0;
                border-top-right-radius: 0;
            }

            .app-main-inner {
                padding-inline: 1.25rem;
            }
        }

        @media (max-width: 575.98px) {
            .app-page-header {
                padding: 1.4rem 1.5rem;
            }

            .app-page-header h1 {
                font-size: 1.45rem;
            }

            .app-section-head {
                padding: 1.25rem 1.35rem;
            }

            .card-body {
                padding: 1.5rem 1.35rem;
            }
        }
    </style>
</head>
<body>
<div class="container-fluid app-layout px-0">
    <div class="row g-0 min-vh-100">
        <?php if ($currentUser): ?>
            <aside class="col-md-2 app-sidebar d-flex flex-column p-0">
                <div class="p-4 border-bottom border-light-subtle">
                    <div class="app-logo">INDUS OS</div>
                    <div class="small text-white-50">PCM - Planejamento e Controle de Manutenção</div>
                </div>
                <nav class="flex-grow-1">
                    <?php
                        $menu = [
                            ['href' => pcm_url('index.php'), 'label' => 'Dashboard', 'icon' => 'bi-speedometer2'],
                            ['href' => pcm_url('equipment.php'), 'label' => 'Ativos & Equipamentos', 'icon' => 'bi-box-seam'],
                            ['href' => pcm_url('plans.php'), 'label' => 'Planos de Manutenção', 'icon' => 'bi-calendar2-check'],
                            ['href' => pcm_url('work_orders.php'), 'label' => 'Ordens de Serviço', 'icon' => 'bi-clipboard-check'],
                            ['href' => pcm_url('clients.php'), 'label' => 'Clientes', 'icon' => 'bi-briefcase'],
                            ['href' => pcm_url('technicians.php'), 'label' => 'Técnicos', 'icon' => 'bi-people'],
                        ];
                        $currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?? '';
                        $basePath = pcm_base_path();
                        $homePath = $basePath === '' ? '/' : $basePath . '/';
                        if ($currentPath === '' || $currentPath === $homePath) {
                            $currentPath = pcm_url('index.php');
                        }
                    ?>
                    <?php foreach ($menu as $item): ?>
                        <a href="<?= htmlspecialchars($item['href']) ?>" class="<?= $currentPath === $item['href'] ? 'active' : '' ?>">
                            <i class="bi <?= $item['icon'] ?> me-2"></i><?= htmlspecialchars($item['label']) ?>
                        </a>
                    <?php endforeach; ?>
                </nav>
                <div class="p-3 border-top border-light-subtle mt-auto">
                    <div class="text-white fw-semibold"><?= htmlspecialchars($currentUser['name']) ?></div>
                    <div class="text-white-50 small mb-2"><?= htmlspecialchars($currentUser['email']) ?></div>
                    <a href="<?= htmlspecialchars(pcm_url('logout.php')) ?>" class="btn btn-outline-light btn-sm w-100"><i class="bi bi-box-arrow-right me-1"></i> Sair</a>
                </div>
            </aside>
            <main class="col-md-10 ms-sm-auto app-content">
        <?php else: ?>
            <main class="col-12 app-content">
        <?php endif; ?>
                <div class="app-main-inner">
                    <header class="app-page-header d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div class="d-flex flex-column gap-3">
                            <?php if ($currentUser): ?>
                                <span class="app-kicker"><i class="bi bi-stars"></i> PCM Inteligente</span>
                            <?php endif; ?>
                            <div>
                                <h1 class="h3 mb-0"><?= htmlspecialchars($appName) ?></h1>
                                <p class="text-muted">Sistema completo de Planejamento e Controle de Manutenção (PCM)</p>
                            </div>
                        </div>
                        <?php if ($currentUser): ?>
                            <div class="app-toolbar">
                                <a href="<?= htmlspecialchars(pcm_url('work_orders.php?action=create')) ?>" class="btn btn-primary"><i class="bi bi-clipboard-plus me-1"></i> Nova OS</a>
                                <a href="<?= htmlspecialchars(pcm_url('equipment.php?action=create')) ?>" class="btn btn-soft"><i class="bi bi-cpu me-1"></i> Cadastrar ativo</a>
                                <a href="<?= htmlspecialchars(pcm_url('clients.php?action=create')) ?>" class="btn btn-soft"><i class="bi bi-person-plus me-1"></i> Novo cliente</a>
                                <div class="app-toolbar-divider"></div>
                                <div class="app-toolbar-pill">
                                    <i class="bi bi-person-badge"></i>
                                    <span><?= htmlspecialchars($currentUser['name']) ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                    </header>
                <?php foreach ($flashMessages as $flash): ?>
                    <div class="alert alert-<?= htmlspecialchars($flash['type']) ?> alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($flash['message']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                    </div>
                <?php endforeach; ?>
