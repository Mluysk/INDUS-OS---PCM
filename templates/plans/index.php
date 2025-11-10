<?php
/** @var array $plans */
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-0">Planos de manutenção</h2>
        <p class="text-muted mb-0">Programações preventivas, inspeções e rotinas padronizadas</p>
    </div>
    <a href="<?= htmlspecialchars(pcm_url('plans.php?action=create')) ?>" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i> Novo plano</a>
</div>
<div class="card border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Plano</th>
                        <th>Equipamento</th>
                        <th>Frequência</th>
                        <th>Duração estimada</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($plans)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Nenhum plano cadastrado.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($plans as $plan): ?>
                            <tr>
                                <td class="fw-semibold">
                                    <?= htmlspecialchars($plan['title']) ?><br>
                                    <span class="text-muted small"><?= htmlspecialchars($plan['description'] ?? 'Sem descrição detalhada') ?></span>
                                </td>
                                <td><?= htmlspecialchars($plan['equipment_name']) ?></td>
                                <td><?= htmlspecialchars($plan['frequency']) ?></td>
                                <td><?= $plan['estimated_duration'] ? htmlspecialchars($plan['estimated_duration'] . ' min') : '—' ?></td>
                                <td class="text-end">
                                    <a href="<?= htmlspecialchars(pcm_url('plans.php?action=edit&id=' . $plan['id'])) ?>" class="btn btn-sm btn-outline-secondary me-2"><i class="bi bi-pencil"></i></a>
                                    <form method="post" action="<?= htmlspecialchars(pcm_url('plans.php')) ?>" class="d-inline" onsubmit="return confirm('Confirma a exclusão do plano?');">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(pcm_csrf_token()) ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?= $plan['id'] ?>">
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
