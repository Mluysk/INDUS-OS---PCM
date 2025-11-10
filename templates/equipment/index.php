<?php
/** @var array $equipmentList */
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-0">Ativos & Equipamentos</h2>
        <p class="text-muted mb-0">Controle completo do parque industrial, criticidade e histórico</p>
    </div>
    <a href="<?= htmlspecialchars(pcm_url('equipment.php?action=create')) ?>" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i> Novo equipamento</a>
</div>
<div class="card border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Ativo</th>
                        <th>Tag patrimonial</th>
                        <th>Localização</th>
                        <th>Criticidade</th>
                        <th>Fabricante</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($equipmentList)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Nenhum equipamento cadastrado.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($equipmentList as $equipment): ?>
                            <tr>
                                <td class="fw-semibold">
                                    <?= htmlspecialchars($equipment['name']) ?><br>
                                    <span class="text-muted small">Instalado em <?= htmlspecialchars(pcm_format_date($equipment['installation_date'])) ?: '—' ?></span>
                                </td>
                                <td><?= htmlspecialchars($equipment['asset_tag']) ?></td>
                                <td><?= htmlspecialchars($equipment['location'] ?? '—') ?></td>
                                <td><?= htmlspecialchars($equipment['criticality'] ?? '—') ?></td>
                                <td><?= htmlspecialchars($equipment['manufacturer'] ?? '—') ?></td>
                                <td class="text-end">
                                    <a href="<?= htmlspecialchars(pcm_url('equipment.php?action=edit&id=' . $equipment['id'])) ?>" class="btn btn-sm btn-outline-secondary me-2"><i class="bi bi-pencil"></i></a>
                                    <form action="<?= htmlspecialchars(pcm_url('equipment.php')) ?>" method="post" class="d-inline" onsubmit="return confirm('Confirma a exclusão do equipamento?');">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(pcm_csrf_token()) ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?= $equipment['id'] ?>">
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
