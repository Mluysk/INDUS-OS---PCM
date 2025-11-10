<?php
/** @var array $technicians */
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-0">Equipe técnica</h2>
        <p class="text-muted mb-0">Gestão de competências, contatos e disponibilidade</p>
    </div>
    <a href="/technicians.php?action=create" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i> Novo técnico</a>
</div>
<div class="card border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th>Especialidade</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($technicians)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Nenhum técnico cadastrado.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($technicians as $technician): ?>
                            <tr>
                                <td class="fw-semibold"><?= htmlspecialchars($technician['name']) ?></td>
                                <td><?= htmlspecialchars($technician['email'] ?? '—') ?></td>
                                <td><?= htmlspecialchars($technician['phone'] ?? '—') ?></td>
                                <td><?= htmlspecialchars($technician['specialty'] ?? '—') ?></td>
                                <td class="text-end">
                                    <a href="/technicians.php?action=edit&id=<?= $technician['id'] ?>" class="btn btn-sm btn-outline-secondary me-2"><i class="bi bi-pencil"></i></a>
                                    <form method="post" action="/technicians.php" class="d-inline" onsubmit="return confirm('Confirma a exclusão do técnico?');">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(pcm_csrf_token()) ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?= $technician['id'] ?>">
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
