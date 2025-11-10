<?php

declare(strict_types=1);

require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../pcm_service.php';

pcm_require_login();

$action = $_GET['action'] ?? 'index';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    pcm_validate_csrf();
    if (($action = $_POST['action'] ?? '') === 'delete') {
        $id = (int) ($_POST['id'] ?? 0);
        if ($id) {
            pcm_delete_client($id);
            pcm_flash('success', 'Cliente removido com sucesso.');
        }
        pcm_redirect('clients.php');
    }

    $id = isset($_POST['id']) ? (int) $_POST['id'] : null;
    $companyName = trim($_POST['company_name'] ?? '');

    if ($companyName === '') {
        pcm_flash('danger', 'Nome do cliente é obrigatório.');
        pcm_remember_old($_POST);
        $redirect = $id ? 'clients.php?action=edit&id=' . $id : 'clients.php?action=create';
        pcm_redirect($redirect);
    }

    pcm_save_client([
        'company_name' => $companyName,
        'contact_name' => trim($_POST['contact_name'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'phone' => trim($_POST['phone'] ?? ''),
        'document' => trim($_POST['document'] ?? ''),
        'segment' => trim($_POST['segment'] ?? ''),
        'notes' => trim($_POST['notes'] ?? ''),
    ], $id ?: null);

    pcm_flash('success', 'Cliente salvo com sucesso.');
    pcm_clear_old();
    pcm_redirect('clients.php');
}

if ($action === 'create') {
    pcm_render('clients/form', [
        'title' => 'Cadastrar cliente',
        'client' => null,
        'old' => $_SESSION['old'] ?? [],
    ]);
    exit;
}

if ($action === 'edit') {
    $id = (int) ($_GET['id'] ?? 0);
    $client = $id ? pcm_find_client($id) : null;
    if (!$client) {
        pcm_flash('danger', 'Cliente não encontrado.');
        pcm_redirect('clients.php');
    }

    pcm_render('clients/form', [
        'title' => 'Editar cliente',
        'client' => $client,
        'old' => $_SESSION['old'] ?? [],
    ]);
    exit;
}

$clients = pcm_all_clients();
pcm_render('clients/index', [
    'clients' => $clients,
]);
