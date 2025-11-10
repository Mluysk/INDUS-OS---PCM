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
    <style>
        body { background-color: #f4f6f9; }
        .app-sidebar { min-height: 100vh; background-color: #0d6efd; }
        .app-sidebar a { color: rgba(255,255,255,0.85); text-decoration: none; display: block; padding: 0.75rem 1rem; }
        .app-sidebar a:hover, .app-sidebar a.active { background-color: rgba(0,0,0,0.15); color: #fff; }
        .app-logo { font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: #fff; }
        main { padding: 2rem; }
        .card { box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.05); }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
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
            <main class="col-md-10 ms-sm-auto">
        <?php else: ?>
            <main class="col-12">
        <?php endif; ?>
                <header class="d-flex justify-content-between align-items-center mb-4">
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
