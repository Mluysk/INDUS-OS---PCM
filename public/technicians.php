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
            pcm_delete_technician($id);
            pcm_flash('success', 'Técnico removido com sucesso.');
        }
        pcm_redirect('technicians.php');
    }

    $id = isset($_POST['id']) ? (int) $_POST['id'] : null;
    $name = trim($_POST['name'] ?? '');

    if ($name === '') {
        pcm_flash('danger', 'Nome do técnico é obrigatório.');
        pcm_remember_old($_POST);
        $redirect = $id ? 'technicians.php?action=edit&id=' . $id : 'technicians.php?action=create';
        pcm_redirect($redirect);
    }

    pcm_save_technician([
        'name' => $name,
        'email' => trim($_POST['email'] ?? ''),
        'phone' => trim($_POST['phone'] ?? ''),
        'specialty' => trim($_POST['specialty'] ?? ''),
    ], $id ?: null);

    pcm_flash('success', 'Técnico salvo com sucesso.');
    pcm_clear_old();
    pcm_redirect('technicians.php');
}

if ($action === 'create') {
    pcm_render('technicians/form', [
        'title' => 'Cadastrar técnico',
        'technician' => null,
        'old' => $_SESSION['old'] ?? [],
    ]);
    exit;
}

if ($action === 'edit') {
    $id = (int) ($_GET['id'] ?? 0);
    $technicians = pcm_all_technicians();
    $technician = null;
    foreach ($technicians as $row) {
        if ((int) $row['id'] === $id) {
            $technician = $row;
            break;
        }
    }

    if (!$technician) {
        pcm_flash('danger', 'Técnico não encontrado.');
        pcm_redirect('technicians.php');
    }

    pcm_render('technicians/form', [
        'title' => 'Editar técnico',
        'technician' => $technician,
        'old' => $_SESSION['old'] ?? [],
    ]);
    exit;
}

$technicians = pcm_all_technicians();
pcm_render('technicians/index', [
    'technicians' => $technicians,
]);
