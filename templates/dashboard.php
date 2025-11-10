<?php
/** @var array $metrics */
?>
<div class="row g-4">
    <div class="col-md-3">
        <div class="card border-0">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 bg-primary bg-opacity-10 text-primary rounded-3 p-3 me-3">
                        <i class="bi bi-box-seam fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-uppercase text-muted small mb-1">Equipamentos</h6>
                        <h3 class="fw-semibold mb-0"><?= $metrics['equipment'] ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 bg-success bg-opacity-10 text-success rounded-3 p-3 me-3">
                        <i class="bi bi-calendar2-check fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-uppercase text-muted small mb-1">Planos</h6>
                        <h3 class="fw-semibold mb-0"><?= $metrics['plans'] ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 bg-warning bg-opacity-10 text-warning rounded-3 p-3 me-3">
                        <i class="bi bi-clipboard-check fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-uppercase text-muted small mb-1">Ordens Abertas</h6>
                        <h3 class="fw-semibold mb-0"><?= $metrics['open_work_orders'] ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 bg-info bg-opacity-10 text-info rounded-3 p-3 me-3">
                        <i class="bi bi-people fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-uppercase text-muted small mb-1">Técnicos</h6>
                        <h3 class="fw-semibold mb-0"><?= $metrics['technicians'] ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-2">
    <div class="col-lg-8">
        <div class="card border-0 h-100">
            <div class="card-header bg-white border-0 pb-0">
                <h2 class="h5 mb-0">Ordens de Serviço Recentes</h2>
            </div>
            <div class="card-body">
                <?php if (empty($metrics['recent_work_orders'])): ?>
                    <p class="text-muted mb-0">Nenhuma ordem cadastrada ainda.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Equipamento</th>
                                    <th>Responsável</th>
                                    <th>Status</th>
                                    <th>Prioridade</th>
                                    <th>Prevista</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($metrics['recent_work_orders'] as $order): ?>
                                    <tr>
                                        <td>#<?= $order['id'] ?></td>
                                        <td><?= htmlspecialchars($order['equipment_name']) ?></td>
                                        <td><?= htmlspecialchars($order['technician_name'] ?? '—') ?></td>
                                        <td><span class="badge bg-secondary text-uppercase"><?= htmlspecialchars($order['status']) ?></span></td>
                                        <td><?= htmlspecialchars(ucfirst($order['priority'])) ?></td>
                                        <td><?= htmlspecialchars(pcm_format_date($order['due_date'])) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 h-100">
            <div class="card-header bg-white border-0 pb-0">
                <h2 class="h5 mb-0">Status das OS</h2>
            </div>
            <div class="card-body">
                <?php if (empty($metrics['status_distribution'])): ?>
                    <p class="text-muted mb-0">Nenhuma ordem cadastrada.</p>
                <?php else: ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($metrics['status_distribution'] as $row): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="text-uppercase fw-semibold"><?= htmlspecialchars($row['status']) ?></span>
                                <span class="badge rounded-pill text-bg-primary"><?= $row['total'] ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
