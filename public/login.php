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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: radial-gradient(circle at top left, rgba(13, 110, 253, 0.25), transparent 55%),
                        radial-gradient(circle at bottom right, rgba(102, 16, 242, 0.25), transparent 50%),
                        linear-gradient(135deg, #0d1b44 0%, #0d6efd 55%, #6610f2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        .login-card {
            max-width: 440px;
            margin: 0 auto;
            border-radius: 28px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(16px);
            box-shadow: 0 40px 80px rgba(6, 24, 73, 0.45);
        }

        .login-card .card-body {
            padding: 3rem;
        }

        .login-card .brand-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            background: rgba(13, 110, 253, 0.12);
            color: #0d6efd;
            border-radius: 999px;
            padding: 0.4rem 0.9rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            font-size: 0.7rem;
        }

        .login-card .form-control {
            border-radius: 14px;
            padding: 0.9rem 1rem;
            border-color: rgba(13, 110, 253, 0.25);
        }

        .login-card .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
            border-color: rgba(13, 110, 253, 0.8);
        }

        .login-card .btn-primary {
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            border: none;
            padding: 0.8rem;
            font-weight: 600;
            box-shadow: 0 15px 35px rgba(13, 110, 253, 0.35);
        }

        .login-card .btn-primary:hover,
        .login-card .btn-primary:focus {
            background: linear-gradient(135deg, #0b5ed7, #520dc2);
        }

        .login-card .card-footer {
            border-top: 1px solid rgba(13, 110, 253, 0.08);
            background: rgba(255, 255, 255, 0.65);
            text-align: center;
            padding: 1rem 3rem 2rem;
            color: rgba(13, 17, 23, 0.65);
            font-size: 0.9rem;
        }

        .login-card .text-muted {
            color: rgba(17, 25, 40, 0.65) !important;
        }

        .login-card .alert {
            border-radius: 16px;
            border: none;
            box-shadow: 0 20px 45px rgba(13, 110, 253, 0.15);
        }

        @media (max-width: 575.98px) {
            .login-card .card-body {
                padding: 2.4rem 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="login-card card border-0">
            <div class="card-body">
                <div class="text-center mb-4">
                    <span class="brand-pill"><i class="bi bi-shield-check"></i> INDUS OS</span>
                    <h1 class="h4 fw-semibold mt-3 mb-1">PCM Profissional</h1>
                    <p class="text-muted mb-0">Entre para acompanhar ativos, planos e ordens de manutenção em tempo real.</p>
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
                    <button type="submit" class="btn btn-primary w-100">Entrar</button>
                </form>
            </div>
            <div class="card-footer">
                <small>&copy; <?= date('Y') ?> INDUS OS • Solução completa de PCM</small>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
