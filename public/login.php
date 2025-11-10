<?php

declare(strict_types=1);

require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../auth.php';

pcm_start_session();
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    pcm_handle_login();
}

$config = require __DIR__ . '/../config.php';
$appName = $config['app_name'];
$flashMessages = pcm_get_flash();
$old = $_SESSION['old'] ?? [];
?><!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($appName) ?> - Acesso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body { background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%); min-height: 100vh; display: flex; align-items: center; }
        .login-card { max-width: 420px; margin: 0 auto; }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="login-card card shadow-lg border-0">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <div class="text-uppercase fw-bold text-primary">INDUS OS</div>
                    <h1 class="h4 fw-semibold">PCM Profissional</h1>
                    <p class="text-muted mb-0">Acesse o painel de Planejamento e Controle de Manutenção</p>
                </div>
                <?php foreach ($flashMessages as $flash): ?>
                    <div class="alert alert-<?= htmlspecialchars($flash['type']) ?> alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($flash['message']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                    </div>
                <?php endforeach; ?>
                <form method="post" novalidate>
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(pcm_csrf_token()) ?>">
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail corporativo</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($old['email'] ?? '') ?>" required autofocus>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <div class="form-text">Use a senha padrão <code>pcm123</code> no primeiro acesso.</div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2">Entrar</button>
                </form>
            </div>
        </div>
        <p class="text-center text-white-50 mt-4 small">&copy; <?= date('Y') ?> INDUS OS • Solução completa de PCM</p>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
