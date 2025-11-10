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
            pcm_delete_equipment($id);
            pcm_flash('success', 'Equipamento removido com sucesso.');
        }
        pcm_redirect('/equipment.php');
    }

    $id = isset($_POST['id']) ? (int) $_POST['id'] : null;
    $name = trim($_POST['name'] ?? '');
    $assetTag = trim($_POST['asset_tag'] ?? '');

    if ($name === '' || $assetTag === '') {
        pcm_flash('danger', 'Nome e tag patrimonial são obrigatórios.');
        pcm_remember_old($_POST);
        $redirect = $id ? '/equipment.php?action=edit&id=' . $id : '/equipment.php?action=create';
        pcm_redirect($redirect);
    }

    pcm_save_equipment([
        'name' => $name,
        'asset_tag' => $assetTag,
        'location' => trim($_POST['location'] ?? ''),
        'criticality' => trim($_POST['criticality'] ?? ''),
        'manufacturer' => trim($_POST['manufacturer'] ?? ''),
        'model' => trim($_POST['model'] ?? ''),
        'serial_number' => trim($_POST['serial_number'] ?? ''),
        'installation_date' => $_POST['installation_date'] ?? null,
        'notes' => trim($_POST['notes'] ?? ''),
    ], $id ?: null);

    pcm_flash('success', 'Equipamento salvo com sucesso.');
    pcm_clear_old();
    pcm_redirect('/equipment.php');
}

if ($action === 'create') {
    pcm_render('equipment/form', [
        'title' => 'Cadastrar equipamento',
        'equipment' => null,
        'old' => $_SESSION['old'] ?? [],
    ]);
    exit;
}

if ($action === 'edit') {
    $id = (int) ($_GET['id'] ?? 0);
    $equipment = $id ? pcm_find_equipment($id) : null;
    if (!$equipment) {
        pcm_flash('danger', 'Equipamento não encontrado.');
        pcm_redirect('/equipment.php');
    }

    pcm_render('equipment/form', [
        'title' => 'Editar equipamento',
        'equipment' => $equipment,
        'old' => $_SESSION['old'] ?? [],
    ]);
    exit;
}

$equipmentList = pcm_all_equipment();
pcm_render('equipment/index', [
    'equipmentList' => $equipmentList,
]);
