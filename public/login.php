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
            min-height: 100vh;
            margin: 0;
            background: radial-gradient(circle at top right, rgba(14, 165, 233, 0.32), transparent 60%),
                        radial-gradient(circle at bottom left, rgba(129, 140, 248, 0.35), transparent 55%),
                        linear-gradient(160deg, #111827 0%, #1e293b 35%, #0f172a 100%);
            font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
            position: relative;
            overflow-x: hidden;
        }

        .login-backdrop {
            position: fixed;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .login-backdrop::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, rgba(59, 130, 246, 0.35), rgba(236, 72, 153, 0.18));
            filter: blur(160px);
            opacity: 0.55;
        }

        .login-backdrop .orb {
            position: absolute;
            border-radius: 999px;
            filter: blur(0px);
            opacity: 0.55;
        }

        .login-backdrop .orb-1 {
            width: 420px;
            height: 420px;
            top: -120px;
            right: -140px;
            background: radial-gradient(circle at center, rgba(56, 189, 248, 0.7), transparent 65%);
        }

        .login-backdrop .orb-2 {
            width: 320px;
            height: 320px;
            bottom: -100px;
            left: -120px;
            background: radial-gradient(circle at center, rgba(236, 72, 153, 0.65), transparent 60%);
        }

        .login-card {
            max-width: 460px;
            margin: 0 auto;
            border-radius: 32px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(22px);
            box-shadow: 0 45px 120px -40px rgba(15, 23, 42, 0.8);
            position: relative;
        }

        .login-card::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.05), rgba(14, 165, 233, 0.08));
            pointer-events: none;
        }

        .login-card .card-body {
            position: relative;
            z-index: 1;
            padding: clamp(2.5rem, 4vw, 3.25rem);
        }

        .login-card .brand-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            background: rgba(99, 102, 241, 0.12);
            color: #4f46e5;
            border-radius: 999px;
            padding: 0.45rem 0.95rem;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            font-size: 0.7rem;
        }

        .login-card .form-control {
            border-radius: 16px;
            padding: 0.95rem 1.1rem;
            border-color: rgba(79, 70, 229, 0.25);
            background-color: rgba(248, 250, 252, 0.8);
        }

        .login-card .form-control:focus {
            box-shadow: 0 0 0 0.3rem rgba(79, 70, 229, 0.15);
            border-color: rgba(79, 70, 229, 0.65);
        }

        .login-card .btn-primary {
            background: linear-gradient(135deg, #4f46e5 0%, #0ea5e9 100%);
            border: none;
            padding: 0.85rem;
            font-weight: 600;
            border-radius: 16px;
            box-shadow: 0 20px 45px rgba(59, 130, 246, 0.45);
        }

        .login-card .btn-primary:hover,
        .login-card .btn-primary:focus {
            background: linear-gradient(135deg, #4338ca 0%, #0284c7 100%);
        }

        .login-card .card-footer {
            position: relative;
            border-top: 1px solid rgba(79, 70, 229, 0.08);
            background: rgba(241, 245, 249, 0.85);
            text-align: center;
            padding: 1.1rem 3rem 2.2rem;
            color: rgba(15, 23, 42, 0.65);
            font-size: 0.9rem;
        }

        .login-card .text-muted {
            color: rgba(17, 25, 40, 0.65) !important;
        }

        .login-card .alert {
            border-radius: 18px;
            border: none;
            box-shadow: 0 25px 55px rgba(79, 70, 229, 0.25);
        }

        .login-highlight {
            border-radius: 32px;
            padding: clamp(2.5rem, 4vw, 3.25rem);
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.85), rgba(236, 72, 153, 0.75));
            color: #f8fafc;
            box-shadow: 0 40px 100px -50px rgba(236, 72, 153, 0.8);
            position: relative;
            overflow: hidden;
        }

        .login-highlight::after {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top right, rgba(255, 255, 255, 0.35), transparent 55%);
            mix-blend-mode: screen;
            opacity: 0.8;
        }

        .login-highlight .login-tag {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            font-size: 0.75rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            padding: 0.4rem 0.95rem;
            border-radius: 999px;
            background: rgba(15, 23, 42, 0.25);
            position: relative;
            z-index: 1;
            font-weight: 600;
        }

        .login-highlight h2 {
            position: relative;
            z-index: 1;
            margin-top: 1.5rem;
            font-weight: 600;
            letter-spacing: -0.02em;
        }

        .login-highlight p,
        .login-highlight ul {
            position: relative;
            z-index: 1;
        }

        .login-perks {
            list-style: none;
            padding: 0;
            margin: 1.75rem 0 0;
            display: grid;
            gap: 0.9rem;
        }

        .login-perks li {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            font-weight: 500;
        }

        .login-perks .badge-icon {
            display: inline-flex;
            width: 2rem;
            height: 2rem;
            border-radius: 999px;
            background: rgba(15, 23, 42, 0.3);
            align-items: center;
            justify-content: center;
        }

        @media (max-width: 991.98px) {
            body {
                padding-top: 2rem;
                padding-bottom: 2rem;
            }

            .login-highlight {
                margin-bottom: 2rem;
            }
        }

        @media (max-width: 575.98px) {
            .login-card .card-body {
                padding: 2.5rem 1.9rem;
            }

            .login-card .card-footer {
                padding-inline: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-backdrop">
        <span class="orb orb-1"></span>
        <span class="orb orb-2"></span>
    </div>
    <div class="container py-5 position-relative">
        <div class="row align-items-center justify-content-center g-4">
            <div class="col-xl-4 col-lg-5 d-none d-lg-block">
                <div class="login-highlight">
                    <span class="login-tag"><i class="bi bi-lightning-charge"></i> INDUS PCM</span>
                    <h2>Gestão moderna e inteligente da manutenção industrial.</h2>
                    <p class="mb-4">Dashboards, ordens de serviço conectadas e planos preventivos com alertas inteligentes em um único cockpit.</p>
                    <ul class="login-perks">
                        <li><span class="badge-icon"><i class="bi bi-speedometer2"></i></span> Indicadores em tempo real</li>
                        <li><span class="badge-icon"><i class="bi bi-diagram-3"></i></span> Planos preventivos integrados</li>
                        <li><span class="badge-icon"><i class="bi bi-people"></i></span> Equipes sincronizadas por ordem</li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-4 col-lg-5">
                <div class="login-card card border-0">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <span class="brand-pill"><i class="bi bi-shield-check"></i> INDUS OS</span>
                            <h1 class="h4 fw-semibold mt-3 mb-1">Portal PCM</h1>
                            <p class="text-muted mb-0">Entre com sua conta corporativa para controlar ativos, planos e ordens.</p>
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
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
