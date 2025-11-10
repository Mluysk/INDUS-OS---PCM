<?php

declare(strict_types=1);

require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../pcm_service.php';

pcm_require_login();

$action = $_GET['action'] ?? 'index';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    pcm_validate_csrf();
    $postAction = $_POST['action'] ?? '';

    if ($postAction === 'delete') {
        $id = (int) ($_POST['id'] ?? 0);
        if ($id) {
            pcm_delete_work_order($id);
            pcm_flash('success', 'Ordem de serviço removida.');
        }
        pcm_redirect('/work_orders.php');
    }

    if ($postAction === 'save_task') {
        $workOrderId = (int) ($_POST['work_order_id'] ?? 0);
        if ($workOrderId) {
            pcm_save_task([
                'work_order_id' => $workOrderId,
                'description' => trim($_POST['description'] ?? ''),
                'is_completed' => !empty($_POST['is_completed']),
            ], isset($_POST['id']) ? (int) $_POST['id'] : null);
            pcm_flash('success', 'Checklist atualizado.');
        }
        pcm_redirect('/work_orders.php?action=edit&id=' . $workOrderId);
    }

    if ($postAction === 'delete_task') {
        $taskId = (int) ($_POST['id'] ?? 0);
        $workOrderId = (int) ($_POST['work_order_id'] ?? 0);
        if ($taskId) {
            pcm_delete_task($taskId);
            pcm_flash('success', 'Item removido do checklist.');
        }
        pcm_redirect('/work_orders.php?action=edit&id=' . $workOrderId);
    }

    $id = isset($_POST['id']) ? (int) $_POST['id'] : null;
    $equipmentId = (int) ($_POST['equipment_id'] ?? 0);
    $status = trim($_POST['status'] ?? 'aberta');
    $priority = trim($_POST['priority'] ?? 'media');

    if ($equipmentId <= 0) {
        pcm_flash('danger', 'Selecione o equipamento.');
        pcm_remember_old($_POST);
        $redirect = $id ? '/work_orders.php?action=edit&id=' . $id : '/work_orders.php?action=create';
        pcm_redirect($redirect);
    }

    pcm_save_work_order([
        'plan_id' => $_POST['plan_id'] ?? '',
        'equipment_id' => $equipmentId,
        'technician_id' => $_POST['technician_id'] ?? '',
        'status' => $status,
        'priority' => $priority,
        'due_date' => $_POST['due_date'] ?? null,
        'started_at' => $_POST['started_at'] ?? null,
        'completed_at' => $_POST['completed_at'] ?? null,
        'notes' => trim($_POST['notes'] ?? ''),
        'feedback' => trim($_POST['feedback'] ?? ''),
    ], $id ?: null);

    pcm_flash('success', 'Ordem de serviço registrada com sucesso.');
    pcm_clear_old();
    pcm_redirect('/work_orders.php');
}

$equipmentOptions = pcm_all_equipment();
$technicianOptions = pcm_all_technicians();
$planOptions = pcm_all_plans();

if ($action === 'create') {
    pcm_render('work_orders/form', [
        'title' => 'Abrir ordem de serviço',
        'order' => null,
        'old' => $_SESSION['old'] ?? [],
        'equipmentOptions' => $equipmentOptions,
        'technicianOptions' => $technicianOptions,
        'planOptions' => $planOptions,
        'tasks' => [],
    ]);
    exit;
}

if ($action === 'edit') {
    $id = (int) ($_GET['id'] ?? 0);
    $order = $id ? pcm_find_work_order($id) : null;
    if (!$order) {
        pcm_flash('danger', 'Ordem de serviço não encontrada.');
        pcm_redirect('/work_orders.php');
    }
    $tasks = pcm_tasks_for_work_order($id);

    pcm_render('work_orders/form', [
        'title' => 'Atualizar ordem de serviço #' . $order['id'],
        'order' => $order,
        'old' => $_SESSION['old'] ?? [],
        'equipmentOptions' => $equipmentOptions,
        'technicianOptions' => $technicianOptions,
        'planOptions' => $planOptions,
        'tasks' => $tasks,
    ]);
    exit;
}

$workOrders = pcm_all_work_orders();
pcm_render('work_orders/index', [
    'workOrders' => $workOrders,
]);
