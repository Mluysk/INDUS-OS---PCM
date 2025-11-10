<?php
/** @var string $title */
/** @var array|null $technician */
/** @var array $old */
?>
<div class="app-section-head">
    <div>
        <h2 class="h4 mb-0"><?= htmlspecialchars($title) ?></h2>
        <p class="text-muted mb-0">Mantenha dados atualizados para direcionar chamados e competências.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= htmlspecialchars(pcm_url('technicians.php')) ?>" class="btn btn-soft"><i class="bi bi-arrow-left"></i> Voltar</a>
    </div>
</div>
<div class="card border-0 app-form-card">
    <div class="card-body">
        <form method="post" action="<?= htmlspecialchars(pcm_url('technicians.php')) ?>">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(pcm_csrf_token()) ?>">
            <?php if ($technician): ?>
                <input type="hidden" name="id" value="<?= $technician['id'] ?>">
            <?php endif; ?>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nome completo *</label>
                    <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($old['name'] ?? $technician['name'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">E-mail</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($old['email'] ?? $technician['email'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Telefone</label>
                    <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($old['phone'] ?? $technician['phone'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Especialidade</label>
                    <input type="text" name="specialty" class="form-control" value="<?= htmlspecialchars($old['specialty'] ?? $technician['specialty'] ?? '') ?>">
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="<?= htmlspecialchars(pcm_url('technicians.php')) ?>" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-primary">Salvar técnico</button>
            </div>
        </form>
    </div>
</div>
