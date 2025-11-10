<?php
/** @var array $workOrders */
?>
<div class="app-section-head">
    <div>
        <h2 class="h4 mb-0">Ordens de serviço</h2>
        <p class="text-muted mb-0">Controle operacional de corretivas, preventivas e inspeções</p>
    </div>
    <a href="<?= htmlspecialchars(pcm_url('work_orders.php?action=create')) ?>" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i> Nova ordem</a>
</div>
<div class="card border-0 app-table-card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Equipamento</th>
                        <th>Plano</th>
                        <th>Responsável</th>
                        <th>Status</th>
                        <th>Prioridade</th>
                        <th>Previsão</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($workOrders)): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">Nenhuma ordem registrada.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($workOrders as $order): ?>
                            <tr>
                                <td class="fw-semibold">#<?= $order['id'] ?></td>
                                <td><?= htmlspecialchars($order['equipment_name']) ?></td>
                                <td>
                                    <?php if ($order['plan_id']): ?>
                                        <span class="badge text-bg-light text-uppercase d-inline-flex align-items-center gap-1 mb-1"><i class="bi bi-diagram-3"></i> <?= htmlspecialchars($order['plan_title'] ?? ('Plano #' . $order['plan_id'])) ?></span>
                                        <div class="small text-muted">#<?= $order['plan_id'] ?></div>
                                    <?php else: ?>
                                        —
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($order['technician_name'] ?? '—') ?></td>
                                <td><span class="badge text-bg-dark text-uppercase px-3 py-2"><?= htmlspecialchars($order['status']) ?></span></td>
                                <td><?= htmlspecialchars(ucfirst($order['priority'])) ?></td>
                                <td><?= htmlspecialchars(pcm_format_date($order['due_date'])) ?></td>
                                <td class="text-end">
                                    <a href="<?= htmlspecialchars(pcm_url('work_orders.php?action=edit&id=' . $order['id'])) ?>" class="btn btn-sm btn-outline-secondary me-2"><i class="bi bi-pencil"></i></a>
                                    <form method="post" action="<?= htmlspecialchars(pcm_url('work_orders.php')) ?>" class="d-inline" onsubmit="return confirm('Confirma a exclusão da OS?');">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(pcm_csrf_token()) ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?= $order['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
