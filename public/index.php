<?php

declare(strict_types=1);

require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../pcm_service.php';

pcm_require_login();

$metrics = pcm_dashboard_metrics();
pcm_render('dashboard', ['metrics' => $metrics]);
