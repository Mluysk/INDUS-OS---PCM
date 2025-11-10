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
            pcm_delete_plan($id);
            pcm_flash('success', 'Plano de manutenção removido.');
        }
        pcm_redirect('/plans.php');
    }

    $id = isset($_POST['id']) ? (int) $_POST['id'] : null;
    $equipmentId = (int) ($_POST['equipment_id'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    $frequency = trim($_POST['frequency'] ?? '');

    if ($equipmentId <= 0 || $title === '' || $frequency === '') {
        pcm_flash('danger', 'Selecione o equipamento, informe o título e a frequência.');
        pcm_remember_old($_POST);
        $redirect = $id ? '/plans.php?action=edit&id=' . $id : '/plans.php?action=create';
        pcm_redirect($redirect);
    }

    pcm_save_plan([
        'equipment_id' => $equipmentId,
        'title' => $title,
        'description' => trim($_POST['description'] ?? ''),
        'frequency' => $frequency,
        'estimated_duration' => $_POST['estimated_duration'] ?? '',
        'required_tools' => trim($_POST['required_tools'] ?? ''),
        'safety_notes' => trim($_POST['safety_notes'] ?? ''),
    ], $id ?: null);

    pcm_flash('success', 'Plano de manutenção salvo com sucesso.');
    pcm_clear_old();
    pcm_redirect('/plans.php');
}

$equipmentOptions = pcm_all_equipment();

if ($action === 'create') {
    pcm_render('plans/form', [
        'title' => 'Cadastrar plano de manutenção',
        'plan' => null,
        'old' => $_SESSION['old'] ?? [],
        'equipmentOptions' => $equipmentOptions,
    ]);
    exit;
}

if ($action === 'edit') {
    $id = (int) ($_GET['id'] ?? 0);
    $plan = $id ? pcm_find_plan($id) : null;
    if (!$plan) {
        pcm_flash('danger', 'Plano não encontrado.');
        pcm_redirect('/plans.php');
    }

    pcm_render('plans/form', [
        'title' => 'Editar plano de manutenção',
        'plan' => $plan,
        'old' => $_SESSION['old'] ?? [],
        'equipmentOptions' => $equipmentOptions,
    ]);
    exit;
}

$plans = pcm_all_plans();
pcm_render('plans/index', [
    'plans' => $plans,
    'equipmentOptions' => $equipmentOptions,
]);
