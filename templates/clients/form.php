<?php
/** @var string $title */
/** @var array|null $client */
/** @var array $old */
?>
<div class="app-section-head">
    <div>
        <h2 class="h4 mb-0"><?= htmlspecialchars($title) ?></h2>
        <p class="text-muted mb-0">Centralize informações comerciais e facilite o vínculo entre manutenção e contratantes.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= htmlspecialchars(pcm_url('clients.php')) ?>" class="btn btn-soft"><i class="bi bi-arrow-left"></i> Voltar</a>
    </div>
</div>
<div class="card border-0 app-form-card">
    <div class="card-body">
        <form method="post" action="<?= htmlspecialchars(pcm_url('clients.php')) ?>">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(pcm_csrf_token()) ?>">
            <?php if ($client): ?>
                <input type="hidden" name="id" value="<?= $client['id'] ?>">
            <?php endif; ?>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nome / Razão social *</label>
                    <input type="text" name="company_name" class="form-control" required value="<?= htmlspecialchars($old['company_name'] ?? $client['company_name'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Documento (CNPJ/CPF)</label>
                    <input type="text" name="document" class="form-control" value="<?= htmlspecialchars($old['document'] ?? $client['document'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Contato responsável</label>
                    <input type="text" name="contact_name" class="form-control" value="<?= htmlspecialchars($old['contact_name'] ?? $client['contact_name'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Segmento</label>
                    <input type="text" name="segment" class="form-control" value="<?= htmlspecialchars($old['segment'] ?? $client['segment'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">E-mail</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($old['email'] ?? $client['email'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Telefone</label>
                    <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($old['phone'] ?? $client['phone'] ?? '') ?>">
                </div>
                <div class="col-12">
                    <label class="form-label">Observações</label>
                    <textarea name="notes" class="form-control" rows="4"><?= htmlspecialchars($old['notes'] ?? $client['notes'] ?? '') ?></textarea>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="<?= htmlspecialchars(pcm_url('clients.php')) ?>" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-primary">Salvar cliente</button>
            </div>
        </form>
    </div>
</div>
