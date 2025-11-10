<?php

declare(strict_types=1);

function pcm_require_login(): void
{
    pcm_start_session();
    if (!isset($_SESSION['user'])) {
        pcm_redirect('login.php');
    }
}

function pcm_base_path(): string
{
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
    if ($scriptName === '') {
        return '';
    }

    $directory = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');
    if ($directory === '/' || $directory === '.') {
        return '';
    }

    return $directory;
}

function pcm_url(string $path = ''): string
{
    $base = pcm_base_path();
    $normalizedPath = '/' . ltrim($path, '/');

    if ($base === '' || $base === '/') {
        return $normalizedPath;
    }

    return $base . $normalizedPath;
}

function pcm_start_session(): void
{
    $config = require __DIR__ . '/config.php';
    if (session_status() === PHP_SESSION_NONE) {
        session_name($config['session_name']);
        session_start();
    }
}

function pcm_csrf_token(): string
{
    pcm_start_session();
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
    }

    return $_SESSION['csrf_token'];
}

function pcm_validate_csrf(): void
{
    pcm_start_session();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $token = $_POST['csrf_token'] ?? '';
        if (empty($token) || $token !== ($_SESSION['csrf_token'] ?? null)) {
            http_response_code(400);
            echo 'Token CSRF inválido.';
            exit;
        }
    }
}

function pcm_flash(string $type, string $message): void
{
    pcm_start_session();
    $_SESSION['flash'][] = ['type' => $type, 'message' => $message];
}

function pcm_get_flash(): array
{
    pcm_start_session();
    $messages = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $messages;
}

function pcm_old(string $field, string $default = ''): string
{
    pcm_start_session();
    $value = $_SESSION['old'][$field] ?? $default;
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function pcm_remember_old(array $data): void
{
    pcm_start_session();
    $_SESSION['old'] = $data;
}

function pcm_clear_old(): void
{
    pcm_start_session();
    unset($_SESSION['old']);
}

function pcm_current_user(): ?array
{
    pcm_start_session();
    return $_SESSION['user'] ?? null;
}

function pcm_format_date(?string $date): string
{
    if (!$date) {
        return '';
    }
    $dateTime = new DateTime($date);
    return $dateTime->format('d/m/Y');
}

function pcm_format_datetime(?string $date): string
{
    if (!$date) {
        return '';
    }
    $dateTime = new DateTime($date);
    return $dateTime->format('d/m/Y H:i');
}

function pcm_render(string $template, array $data = []): void
{
    extract($data, EXTR_SKIP);
    $config = require __DIR__ . '/config.php';
    $appName = $config['app_name'];
    $currentUser = pcm_current_user();
    $flashMessages = pcm_get_flash();
    include __DIR__ . '/templates/header.php';
    include __DIR__ . '/templates/' . $template . '.php';
    include __DIR__ . '/templates/footer.php';
}

function pcm_redirect(string $path): void
{
    if (!preg_match('#^https?://#i', $path)) {
        $path = pcm_url($path);
    }

    header('Location: ' . $path);
    exit;
}
