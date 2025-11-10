<?php

declare(strict_types=1);

function pcm_db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $config = require __DIR__ . '/config.php';
    $isNew = !file_exists($config['db_path']);
    $pdo = new PDO('sqlite:' . $config['db_path']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    if ($isNew) {
        pcm_bootstrap_schema($pdo);
    }

    pcm_update_schema($pdo);

    return $pdo;
}

function pcm_update_schema(PDO $pdo): void
{
    $pdo->exec('CREATE TABLE IF NOT EXISTS clients (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        company_name TEXT NOT NULL,
        contact_name TEXT,
        email TEXT,
        phone TEXT,
        document TEXT,
        segment TEXT,
        notes TEXT,
        zip_code TEXT,
        street TEXT,
        number TEXT,
        neighborhood TEXT,
        city TEXT,
        state TEXT
    )');

    $columns = $pdo->query('PRAGMA table_info(clients)')->fetchAll(PDO::FETCH_COLUMN, 1);
    $desired = [
        'zip_code' => 'TEXT',
        'street' => 'TEXT',
        'number' => 'TEXT',
        'neighborhood' => 'TEXT',
        'city' => 'TEXT',
        'state' => 'TEXT',
    ];

    foreach ($desired as $column => $type) {
        if (!in_array($column, $columns, true)) {
            $pdo->exec(sprintf('ALTER TABLE clients ADD COLUMN %s %s', $column, $type));
        }
    }
}

function pcm_bootstrap_schema(PDO $pdo): void
{
    $pdo->exec('CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        email TEXT NOT NULL UNIQUE,
        password_hash TEXT NOT NULL,
        role TEXT NOT NULL DEFAULT "admin"
    )');

    $pdo->exec('CREATE TABLE IF NOT EXISTS technicians (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        email TEXT,
        phone TEXT,
        specialty TEXT
    )');

    $pdo->exec('CREATE TABLE IF NOT EXISTS equipment (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        asset_tag TEXT NOT NULL UNIQUE,
        location TEXT,
        criticality TEXT,
        manufacturer TEXT,
        model TEXT,
        serial_number TEXT,
        installation_date TEXT,
        notes TEXT
    )');

    $pdo->exec('CREATE TABLE IF NOT EXISTS maintenance_plans (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        equipment_id INTEGER NOT NULL,
        title TEXT NOT NULL,
        description TEXT,
        frequency TEXT NOT NULL,
        estimated_duration INTEGER,
        required_tools TEXT,
        safety_notes TEXT,
        FOREIGN KEY (equipment_id) REFERENCES equipment(id) ON DELETE CASCADE
    )');

    $pdo->exec('CREATE TABLE IF NOT EXISTS work_orders (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        plan_id INTEGER,
        equipment_id INTEGER NOT NULL,
        technician_id INTEGER,
        status TEXT NOT NULL DEFAULT "aberta",
        priority TEXT NOT NULL DEFAULT "media",
        due_date TEXT,
        started_at TEXT,
        completed_at TEXT,
        notes TEXT,
        feedback TEXT,
        FOREIGN KEY (plan_id) REFERENCES maintenance_plans(id) ON DELETE SET NULL,
        FOREIGN KEY (equipment_id) REFERENCES equipment(id) ON DELETE CASCADE,
        FOREIGN KEY (technician_id) REFERENCES technicians(id) ON DELETE SET NULL
    )');

    $pdo->exec('CREATE TABLE IF NOT EXISTS inspections (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        equipment_id INTEGER NOT NULL,
        inspector TEXT,
        inspection_date TEXT NOT NULL,
        status TEXT NOT NULL,
        notes TEXT,
        FOREIGN KEY (equipment_id) REFERENCES equipment(id) ON DELETE CASCADE
    )');

    $pdo->exec('CREATE TABLE IF NOT EXISTS documents (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        equipment_id INTEGER,
        name TEXT NOT NULL,
        category TEXT,
        file_path TEXT NOT NULL,
        uploaded_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (equipment_id) REFERENCES equipment(id) ON DELETE SET NULL
    )');

    $pdo->exec('CREATE TABLE IF NOT EXISTS work_order_tasks (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        work_order_id INTEGER NOT NULL,
        description TEXT NOT NULL,
        is_completed INTEGER NOT NULL DEFAULT 0,
        FOREIGN KEY (work_order_id) REFERENCES work_orders(id) ON DELETE CASCADE
    )');

    // Seed default admin user
    $stmt = $pdo->prepare('INSERT INTO users (name, email, password_hash, role) VALUES (:name, :email, :password_hash, :role)');
    $stmt->execute([
        ':name' => 'Administrador',
        ':email' => 'admin@pcm.local',
        ':password_hash' => password_hash('pcm123', PASSWORD_DEFAULT),
        ':role' => 'admin',
    ]);
}
