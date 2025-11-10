<?php
/** @var array $metrics */
?>
<div class="row g-4 app-metric-grid">
    <div class="col-md-3">
        <div class="card border-0 app-metric-card app-metric-card--blue">
            <div class="card-body">
                <div class="app-metric-icon">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div>
                    <h6 class="text-uppercase small mb-1 opacity-75">Equipamentos</h6>
                    <h3 class="fw-semibold mb-0"><?= $metrics['equipment'] ?></h3>
                    <span class="d-block small opacity-75">Inventário monitorado</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 app-metric-card app-metric-card--emerald">
            <div class="card-body">
                <div class="app-metric-icon">
                    <i class="bi bi-calendar2-check"></i>
                </div>
                <div>
                    <h6 class="text-uppercase small mb-1 opacity-75">Planos</h6>
                    <h3 class="fw-semibold mb-0"><?= $metrics['plans'] ?></h3>
                    <span class="d-block small opacity-75">Rotinas preventivas</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 app-metric-card app-metric-card--amber">
            <div class="card-body">
                <div class="app-metric-icon">
                    <i class="bi bi-clipboard-check"></i>
                </div>
                <div>
                    <h6 class="text-uppercase small mb-1 opacity-75">Ordens Abertas</h6>
                    <h3 class="fw-semibold mb-0"><?= $metrics['open_work_orders'] ?></h3>
                    <span class="d-block small opacity-75">Em execução</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 app-metric-card app-metric-card--sky">
            <div class="card-body">
                <div class="app-metric-icon">
                    <i class="bi bi-people"></i>
                </div>
                <div>
                    <h6 class="text-uppercase small mb-1 opacity-75">Técnicos</h6>
                    <h3 class="fw-semibold mb-0"><?= $metrics['technicians'] ?></h3>
                    <span class="d-block small opacity-75">Equipe disponível</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-2">
    <div class="col-lg-8">
        <div class="card border-0 h-100 app-table-card">
            <div class="card-header bg-white border-0 pb-0 d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h5 mb-0">Ordens de Serviço Recentes</h2>
                    <p class="text-muted small mb-0">Acompanhe as últimas movimentações da operação</p>
                </div>
                <span class="badge text-bg-light text-uppercase">Tempo real</span>
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
                                        <td class="fw-semibold">#<?= $order['id'] ?></td>
                                        <td>
                                            <?= htmlspecialchars($order['equipment_name']) ?><br>
                                            <small class="text-muted">Plano: <?= htmlspecialchars($order['plan_title'] ?? '—') ?></small>
                                        </td>
                                        <td><?= htmlspecialchars($order['technician_name'] ?? '—') ?></td>
                                        <td><span class="badge text-bg-dark text-uppercase px-3 py-2"><?= htmlspecialchars($order['status']) ?></span></td>
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
                <p class="text-muted small mb-0">Distribuição geral</p>
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
