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
            --pcm-brand-gradient: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%);
            --pcm-surface: #ffffff;
            --pcm-surface-alt: rgba(13, 110, 253, 0.08);
            --pcm-background: #eff3fb;
            --pcm-text: #1f2937;
            --pcm-muted: #6b7280;
        }

        * {
            letter-spacing: -0.01em;
        }

        body {
            background: radial-gradient(circle at top left, rgba(13, 110, 253, 0.12), transparent 55%),
                        radial-gradient(circle at bottom right, rgba(102, 16, 242, 0.12), transparent 50%),
                        var(--pcm-background);
            font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
            color: var(--pcm-text);
            min-height: 100vh;
        }

        .app-layout {
            backdrop-filter: blur(12px);
        }

        .app-sidebar {
            background: linear-gradient(205deg, #061a4b 0%, #0d6efd 55%, #1b98f5 100%);
            color: rgba(255, 255, 255, 0.92);
            min-height: 100vh;
            position: relative;
            overflow: hidden;
            box-shadow: 8px 0 30px rgba(13, 110, 253, 0.25);
        }

        .app-sidebar::after {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 10% 20%, rgba(255, 255, 255, 0.18), transparent 45%),
                        radial-gradient(circle at 80% 90%, rgba(255, 255, 255, 0.1), transparent 55%);
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
            display: block;
            padding: 0.85rem 1.5rem;
            font-weight: 500;
            position: relative;
            transition: all 0.25s ease;
            z-index: 1;
        }

        .app-sidebar a .bi {
            opacity: 0.8;
        }

        .app-sidebar a:hover,
        .app-sidebar a:focus {
            color: #fff;
            transform: translateX(4px);
        }

        .app-sidebar a.active {
            color: #fff;
        }

        .app-sidebar a.active::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.16), rgba(255, 255, 255, 0));
            border-left: 3px solid rgba(255, 255, 255, 0.8);
            pointer-events: none;
            z-index: 0;
        }

        .app-logo {
            font-weight: 700;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: #fff;
            font-size: 1.1rem;
        }

        .app-sidebar .small {
            letter-spacing: 0.08em;
        }

        main {
            padding: clamp(1.75rem, 4vw, 3rem);
        }

        .app-content {
            background: linear-gradient(165deg, rgba(255, 255, 255, 0.92), rgba(255, 255, 255, 0.82));
            backdrop-filter: blur(8px);
            border-top-left-radius: 32px;
            border-top-right-radius: 32px;
            min-height: 100vh;
        }

        .app-page-header {
            background: rgba(255, 255, 255, 0.65);
            border: 1px solid rgba(13, 110, 253, 0.05);
            border-radius: 20px;
            padding: 1.5rem 1.75rem;
            margin-bottom: 2.5rem;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.06);
            position: relative;
            overflow: hidden;
        }

        .app-page-header::after {
            content: '';
            position: absolute;
            top: -50px;
            right: -40px;
            width: 160px;
            height: 160px;
            background: radial-gradient(circle, rgba(13, 110, 253, 0.2) 0%, transparent 65%);
            pointer-events: none;
        }

        .app-page-header h1 {
            font-weight: 600;
            letter-spacing: -0.02em;
        }

        .app-page-header p {
            margin-bottom: 0;
            color: var(--pcm-muted);
        }

        .card {
            border: 0;
            border-radius: 22px;
            box-shadow: 0 25px 50px -20px rgba(15, 23, 42, 0.15);
            background: var(--pcm-surface);
            overflow: hidden;
        }

        .card-header {
            border-bottom: 0;
            background: transparent;
            font-weight: 600;
        }

        .table {
            --bs-table-bg: transparent;
            margin-bottom: 0;
        }

        .table > :not(caption) > * > * {
            padding: 1rem 1.15rem;
            vertical-align: middle;
        }

        .table thead th {
            text-transform: uppercase;
            font-size: 0.72rem;
            letter-spacing: 0.12em;
            color: var(--pcm-muted);
            border-bottom: 1px solid rgba(15, 23, 42, 0.08);
            background: linear-gradient(135deg, rgba(13, 110, 253, 0.08), transparent);
        }

        .table tbody tr {
            border-bottom-color: rgba(15, 23, 42, 0.06);
            transition: background 0.2s ease;
        }

        .table tbody tr:hover {
            background: rgba(13, 110, 253, 0.04);
        }

        .badge {
            border-radius: 999px;
            padding: 0.45rem 0.9rem;
            font-weight: 600;
            letter-spacing: 0.04em;
        }

        .btn-primary {
            background: var(--pcm-brand-gradient);
            border: none;
            box-shadow: 0 15px 30px rgba(13, 110, 253, 0.35);
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background: linear-gradient(135deg, #0b5ed7 0%, #520dc2 100%);
            box-shadow: 0 18px 35px rgba(82, 13, 194, 0.35);
        }

        .btn-outline-light {
            border-color: rgba(255, 255, 255, 0.6);
            color: #fff;
        }

        .btn-outline-light:hover,
        .btn-outline-light:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: transparent;
        }

        .form-control,
        .form-select {
            border-radius: 14px;
            border-color: rgba(15, 23, 42, 0.08);
            padding: 0.75rem 1rem;
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.18);
            border-color: rgba(13, 110, 253, 0.65);
        }

        .alert {
            border-radius: 18px;
            border: none;
            box-shadow: 0 15px 30px rgba(15, 23, 42, 0.08);
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
        }

        @media (max-width: 575.98px) {
            .app-page-header {
                padding: 1.25rem 1.5rem;
            }

            .app-page-header h1 {
                font-size: 1.5rem;
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
                <header class="app-page-header d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h1 class="h3 mb-0"><?= htmlspecialchars($appName) ?></h1>
                        <p class="text-muted">Sistema completo de Planejamento e Controle de Manutenção (PCM)</p>
                    </div>
                </header>
                <?php foreach ($flashMessages as $flash): ?>
                    <div class="alert alert-<?= htmlspecialchars($flash['type']) ?> alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($flash['message']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                    </div>
                <?php endforeach; ?>
