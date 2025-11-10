<?php

declare(strict_types=1);

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/helpers.php';

function pcm_handle_login(): void
{
    pcm_validate_csrf();
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        pcm_flash('danger', 'Informe e-mail e senha.');
        pcm_remember_old($_POST);
        pcm_redirect('/login.php');
    }

    $pdo = pcm_db();
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password_hash'])) {
        pcm_flash('danger', 'Credenciais inválidas.');
        pcm_remember_old($_POST);
        pcm_redirect('/login.php');
    }

    pcm_start_session();
    unset($user['password_hash']);
    $_SESSION['user'] = $user;
    pcm_clear_old();
    pcm_flash('success', 'Bem-vindo de volta, ' . $user['name'] . '!');
    pcm_redirect('/index.php');
}

function pcm_logout(): void
{
    pcm_start_session();
    session_destroy();
    pcm_redirect('/login.php');
}
