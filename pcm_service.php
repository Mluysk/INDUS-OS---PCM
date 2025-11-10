<?php

declare(strict_types=1);

require_once __DIR__ . '/database.php';

function pcm_dashboard_metrics(): array
{
    $pdo = pcm_db();
    $equipment = (int) $pdo->query('SELECT COUNT(*) FROM equipment')->fetchColumn();
    $plans = (int) $pdo->query('SELECT COUNT(*) FROM maintenance_plans')->fetchColumn();
    $openWorkOrders = (int) $pdo->query("SELECT COUNT(*) FROM work_orders WHERE status IN ('aberta','em_execucao')")->fetchColumn();
    $technicians = (int) $pdo->query('SELECT COUNT(*) FROM technicians')->fetchColumn();
    $clients = (int) $pdo->query('SELECT COUNT(*) FROM clients')->fetchColumn();

    $statusDistribution = $pdo->query('SELECT status, COUNT(*) as total FROM work_orders GROUP BY status')->fetchAll();
    $recentWorkOrders = $pdo->query('SELECT wo.*, eq.name AS equipment_name, tech.name AS technician_name, mp.title AS plan_title
        FROM work_orders wo
        LEFT JOIN equipment eq ON eq.id = wo.equipment_id
        LEFT JOIN technicians tech ON tech.id = wo.technician_id
        LEFT JOIN maintenance_plans mp ON mp.id = wo.plan_id
        ORDER BY wo.id DESC LIMIT 5')->fetchAll();

    return [
        'equipment' => $equipment,
        'plans' => $plans,
        'open_work_orders' => $openWorkOrders,
        'technicians' => $technicians,
        'clients' => $clients,
        'status_distribution' => $statusDistribution,
        'recent_work_orders' => $recentWorkOrders,
    ];
}

function pcm_all_equipment(): array
{
    $pdo = pcm_db();
    return $pdo->query('SELECT * FROM equipment ORDER BY name')->fetchAll();
}

function pcm_find_equipment(int $id): ?array
{
    $pdo = pcm_db();
    $stmt = $pdo->prepare('SELECT * FROM equipment WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $equipment = $stmt->fetch();
    return $equipment ?: null;
}

function pcm_save_equipment(array $data, ?int $id = null): void
{
    $pdo = pcm_db();
    if ($id) {
        $stmt = $pdo->prepare('UPDATE equipment SET name = :name, asset_tag = :asset_tag, location = :location, criticality = :criticality, manufacturer = :manufacturer, model = :model, serial_number = :serial_number, installation_date = :installation_date, notes = :notes WHERE id = :id');
        $stmt->execute([
            ':name' => $data['name'],
            ':asset_tag' => $data['asset_tag'],
            ':location' => $data['location'] ?? null,
            ':criticality' => $data['criticality'] ?? null,
            ':manufacturer' => $data['manufacturer'] ?? null,
            ':model' => $data['model'] ?? null,
            ':serial_number' => $data['serial_number'] ?? null,
            ':installation_date' => $data['installation_date'] ?? null,
            ':notes' => $data['notes'] ?? null,
            ':id' => $id,
        ]);
    } else {
        $stmt = $pdo->prepare('INSERT INTO equipment (name, asset_tag, location, criticality, manufacturer, model, serial_number, installation_date, notes) VALUES (:name, :asset_tag, :location, :criticality, :manufacturer, :model, :serial_number, :installation_date, :notes)');
        $stmt->execute([
            ':name' => $data['name'],
            ':asset_tag' => $data['asset_tag'],
            ':location' => $data['location'] ?? null,
            ':criticality' => $data['criticality'] ?? null,
            ':manufacturer' => $data['manufacturer'] ?? null,
            ':model' => $data['model'] ?? null,
            ':serial_number' => $data['serial_number'] ?? null,
            ':installation_date' => $data['installation_date'] ?? null,
            ':notes' => $data['notes'] ?? null,
        ]);
    }
}

function pcm_delete_equipment(int $id): void
{
    $pdo = pcm_db();
    $stmt = $pdo->prepare('DELETE FROM equipment WHERE id = :id');
    $stmt->execute([':id' => $id]);
}

function pcm_all_technicians(): array
{
    $pdo = pcm_db();
    return $pdo->query('SELECT * FROM technicians ORDER BY name')->fetchAll();
}

function pcm_all_clients(): array
{
    $pdo = pcm_db();
    return $pdo->query('SELECT * FROM clients ORDER BY company_name')->fetchAll();
}

function pcm_save_technician(array $data, ?int $id = null): void
{
    $pdo = pcm_db();
    if ($id) {
        $stmt = $pdo->prepare('UPDATE technicians SET name = :name, email = :email, phone = :phone, specialty = :specialty WHERE id = :id');
        $stmt->execute([
            ':name' => $data['name'],
            ':email' => $data['email'] ?? null,
            ':phone' => $data['phone'] ?? null,
            ':specialty' => $data['specialty'] ?? null,
            ':id' => $id,
        ]);
    } else {
        $stmt = $pdo->prepare('INSERT INTO technicians (name, email, phone, specialty) VALUES (:name, :email, :phone, :specialty)');
        $stmt->execute([
            ':name' => $data['name'],
            ':email' => $data['email'] ?? null,
            ':phone' => $data['phone'] ?? null,
            ':specialty' => $data['specialty'] ?? null,
        ]);
    }
}

function pcm_find_client(int $id): ?array
{
    $pdo = pcm_db();
    $stmt = $pdo->prepare('SELECT * FROM clients WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $client = $stmt->fetch();
    return $client ?: null;
}

function pcm_save_client(array $data, ?int $id = null): void
{
    $pdo = pcm_db();
    if ($id) {
        $stmt = $pdo->prepare('UPDATE clients SET company_name = :company_name, contact_name = :contact_name, email = :email, phone = :phone, document = :document, segment = :segment, notes = :notes WHERE id = :id');
        $stmt->execute([
            ':company_name' => $data['company_name'],
            ':contact_name' => $data['contact_name'] !== '' ? $data['contact_name'] : null,
            ':email' => $data['email'] !== '' ? $data['email'] : null,
            ':phone' => $data['phone'] !== '' ? $data['phone'] : null,
            ':document' => $data['document'] !== '' ? $data['document'] : null,
            ':segment' => $data['segment'] !== '' ? $data['segment'] : null,
            ':notes' => $data['notes'] !== '' ? $data['notes'] : null,
            ':id' => $id,
        ]);
    } else {
        $stmt = $pdo->prepare('INSERT INTO clients (company_name, contact_name, email, phone, document, segment, notes) VALUES (:company_name, :contact_name, :email, :phone, :document, :segment, :notes)');
        $stmt->execute([
            ':company_name' => $data['company_name'],
            ':contact_name' => $data['contact_name'] !== '' ? $data['contact_name'] : null,
            ':email' => $data['email'] !== '' ? $data['email'] : null,
            ':phone' => $data['phone'] !== '' ? $data['phone'] : null,
            ':document' => $data['document'] !== '' ? $data['document'] : null,
            ':segment' => $data['segment'] !== '' ? $data['segment'] : null,
            ':notes' => $data['notes'] !== '' ? $data['notes'] : null,
        ]);
    }
}

function pcm_delete_client(int $id): void
{
    $pdo = pcm_db();
    $stmt = $pdo->prepare('DELETE FROM clients WHERE id = :id');
    $stmt->execute([':id' => $id]);
}

function pcm_delete_technician(int $id): void
{
    $pdo = pcm_db();
    $stmt = $pdo->prepare('DELETE FROM technicians WHERE id = :id');
    $stmt->execute([':id' => $id]);
}

function pcm_all_plans(): array
{
    $pdo = pcm_db();
    $stmt = $pdo->query('SELECT mp.*, eq.name AS equipment_name FROM maintenance_plans mp JOIN equipment eq ON eq.id = mp.equipment_id ORDER BY mp.title');
    return $stmt->fetchAll();
}

function pcm_find_plan(int $id): ?array
{
    $pdo = pcm_db();
    $stmt = $pdo->prepare('SELECT mp.*, eq.name AS equipment_name FROM maintenance_plans mp JOIN equipment eq ON eq.id = mp.equipment_id WHERE mp.id = :id');
    $stmt->execute([':id' => $id]);
    $plan = $stmt->fetch();
    return $plan ?: null;
}

function pcm_save_plan(array $data, ?int $id = null): void
{
    $pdo = pcm_db();
    if ($id) {
        $stmt = $pdo->prepare('UPDATE maintenance_plans SET equipment_id = :equipment_id, title = :title, description = :description, frequency = :frequency, estimated_duration = :estimated_duration, required_tools = :required_tools, safety_notes = :safety_notes WHERE id = :id');
        $stmt->execute([
            ':equipment_id' => (int) $data['equipment_id'],
            ':title' => $data['title'],
            ':description' => $data['description'] ?? null,
            ':frequency' => $data['frequency'],
            ':estimated_duration' => $data['estimated_duration'] !== '' ? (int) $data['estimated_duration'] : null,
            ':required_tools' => $data['required_tools'] ?? null,
            ':safety_notes' => $data['safety_notes'] ?? null,
            ':id' => $id,
        ]);
    } else {
        $stmt = $pdo->prepare('INSERT INTO maintenance_plans (equipment_id, title, description, frequency, estimated_duration, required_tools, safety_notes) VALUES (:equipment_id, :title, :description, :frequency, :estimated_duration, :required_tools, :safety_notes)');
        $stmt->execute([
            ':equipment_id' => (int) $data['equipment_id'],
            ':title' => $data['title'],
            ':description' => $data['description'] ?? null,
            ':frequency' => $data['frequency'],
            ':estimated_duration' => $data['estimated_duration'] !== '' ? (int) $data['estimated_duration'] : null,
            ':required_tools' => $data['required_tools'] ?? null,
            ':safety_notes' => $data['safety_notes'] ?? null,
        ]);
    }
}

function pcm_delete_plan(int $id): void
{
    $pdo = pcm_db();
    $stmt = $pdo->prepare('DELETE FROM maintenance_plans WHERE id = :id');
    $stmt->execute([':id' => $id]);
}

function pcm_all_work_orders(): array
{
    $pdo = pcm_db();
    $stmt = $pdo->query('SELECT wo.*, eq.name AS equipment_name, tech.name AS technician_name, mp.title AS plan_title
        FROM work_orders wo
        JOIN equipment eq ON eq.id = wo.equipment_id
        LEFT JOIN technicians tech ON tech.id = wo.technician_id
        LEFT JOIN maintenance_plans mp ON mp.id = wo.plan_id
        ORDER BY wo.id DESC');
    return $stmt->fetchAll();
}

function pcm_find_work_order(int $id): ?array
{
    $pdo = pcm_db();
    $stmt = $pdo->prepare('SELECT wo.*, eq.name AS equipment_name, tech.name AS technician_name, mp.title AS plan_title
        FROM work_orders wo
        JOIN equipment eq ON eq.id = wo.equipment_id
        LEFT JOIN technicians tech ON tech.id = wo.technician_id
        LEFT JOIN maintenance_plans mp ON mp.id = wo.plan_id
        WHERE wo.id = :id');
    $stmt->execute([':id' => $id]);
    $order = $stmt->fetch();
    return $order ?: null;
}

function pcm_save_work_order(array $data, ?int $id = null): void
{
    $pdo = pcm_db();
    if ($id) {
        $stmt = $pdo->prepare('UPDATE work_orders SET plan_id = :plan_id, equipment_id = :equipment_id, technician_id = :technician_id, status = :status, priority = :priority, due_date = :due_date, started_at = :started_at, completed_at = :completed_at, notes = :notes, feedback = :feedback WHERE id = :id');
        $stmt->execute([
            ':plan_id' => $data['plan_id'] !== '' ? (int) $data['plan_id'] : null,
            ':equipment_id' => (int) $data['equipment_id'],
            ':technician_id' => $data['technician_id'] !== '' ? (int) $data['technician_id'] : null,
            ':status' => $data['status'],
            ':priority' => $data['priority'],
            ':due_date' => $data['due_date'] ?? null,
            ':started_at' => $data['started_at'] ?? null,
            ':completed_at' => $data['completed_at'] ?? null,
            ':notes' => $data['notes'] ?? null,
            ':feedback' => $data['feedback'] ?? null,
            ':id' => $id,
        ]);
    } else {
        $stmt = $pdo->prepare('INSERT INTO work_orders (plan_id, equipment_id, technician_id, status, priority, due_date, started_at, completed_at, notes, feedback) VALUES (:plan_id, :equipment_id, :technician_id, :status, :priority, :due_date, :started_at, :completed_at, :notes, :feedback)');
        $stmt->execute([
            ':plan_id' => $data['plan_id'] !== '' ? (int) $data['plan_id'] : null,
            ':equipment_id' => (int) $data['equipment_id'],
            ':technician_id' => $data['technician_id'] !== '' ? (int) $data['technician_id'] : null,
            ':status' => $data['status'],
            ':priority' => $data['priority'],
            ':due_date' => $data['due_date'] ?? null,
            ':started_at' => $data['started_at'] ?? null,
            ':completed_at' => $data['completed_at'] ?? null,
            ':notes' => $data['notes'] ?? null,
            ':feedback' => $data['feedback'] ?? null,
        ]);
    }
}

function pcm_delete_work_order(int $id): void
{
    $pdo = pcm_db();
    $stmt = $pdo->prepare('DELETE FROM work_orders WHERE id = :id');
    $stmt->execute([':id' => $id]);
}

function pcm_tasks_for_work_order(int $workOrderId): array
{
    $pdo = pcm_db();
    $stmt = $pdo->prepare('SELECT * FROM work_order_tasks WHERE work_order_id = :id');
    $stmt->execute([':id' => $workOrderId]);
    return $stmt->fetchAll();
}

function pcm_save_task(array $data, ?int $id = null): void
{
    $pdo = pcm_db();
    if ($id) {
        $stmt = $pdo->prepare('UPDATE work_order_tasks SET description = :description, is_completed = :is_completed WHERE id = :id');
        $stmt->execute([
            ':description' => $data['description'],
            ':is_completed' => !empty($data['is_completed']) ? 1 : 0,
            ':id' => $id,
        ]);
    } else {
        $stmt = $pdo->prepare('INSERT INTO work_order_tasks (work_order_id, description, is_completed) VALUES (:work_order_id, :description, :is_completed)');
        $stmt->execute([
            ':work_order_id' => (int) $data['work_order_id'],
            ':description' => $data['description'],
            ':is_completed' => !empty($data['is_completed']) ? 1 : 0,
        ]);
    }
}

function pcm_delete_task(int $id): void
{
    $pdo = pcm_db();
    $stmt = $pdo->prepare('DELETE FROM work_order_tasks WHERE id = :id');
    $stmt->execute([':id' => $id]);
}

function pcm_all_plans_for_equipment(int $equipmentId): array
{
    $pdo = pcm_db();
    $stmt = $pdo->prepare('SELECT * FROM maintenance_plans WHERE equipment_id = :equipment_id');
    $stmt->execute([':equipment_id' => $equipmentId]);
    return $stmt->fetchAll();
}
