<?php
/** @var string $title */
/** @var array|null $equipment */
/** @var array $old */
?>
<div class="app-section-head">
    <div>
        <h2 class="h4 mb-0"><?= htmlspecialchars($title) ?></h2>
        <p class="text-muted mb-0">Cadastre os dados técnicos, criticidade e histórico operacional do ativo.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= htmlspecialchars(pcm_url('equipment.php')) ?>" class="btn btn-soft"><i class="bi bi-arrow-left"></i> Voltar</a>
    </div>
</div>
<div class="card border-0 app-form-card">
    <div class="card-body">
        <form method="post" action="<?= htmlspecialchars(pcm_url('equipment.php')) ?>">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(pcm_csrf_token()) ?>">
            <?php if ($equipment): ?>
                <input type="hidden" name="id" value="<?= $equipment['id'] ?>">
            <?php endif; ?>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nome do ativo *</label>
                    <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($old['name'] ?? $equipment['name'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tag patrimonial *</label>
                    <input type="text" name="asset_tag" class="form-control" required value="<?= htmlspecialchars($old['asset_tag'] ?? $equipment['asset_tag'] ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Localização</label>
                    <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($old['location'] ?? $equipment['location'] ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Criticidade</label>
                    <select name="criticality" class="form-select">
                        <?php
                            $criticalityOptions = ['Alta', 'Média', 'Baixa'];
                            $selectedCriticality = $old['criticality'] ?? $equipment['criticality'] ?? '';
                        ?>
                        <option value="">Selecione...</option>
                        <?php foreach ($criticalityOptions as $option): ?>
                            <option value="<?= $option ?>" <?= $selectedCriticality === $option ? 'selected' : '' ?>><?= $option ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Data de instalação</label>
                    <input type="date" name="installation_date" class="form-control" value="<?= htmlspecialchars($old['installation_date'] ?? $equipment['installation_date'] ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fabricante</label>
                    <input type="text" name="manufacturer" class="form-control" value="<?= htmlspecialchars($old['manufacturer'] ?? $equipment['manufacturer'] ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Modelo</label>
                    <input type="text" name="model" class="form-control" value="<?= htmlspecialchars($old['model'] ?? $equipment['model'] ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Número de série</label>
                    <input type="text" name="serial_number" class="form-control" value="<?= htmlspecialchars($old['serial_number'] ?? $equipment['serial_number'] ?? '') ?>">
                </div>
                <div class="col-12">
                    <label class="form-label">Observações</label>
                    <textarea name="notes" rows="4" class="form-control"><?= htmlspecialchars($old['notes'] ?? $equipment['notes'] ?? '') ?></textarea>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="<?= htmlspecialchars(pcm_url('equipment.php')) ?>" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-primary">Salvar equipamento</button>
            </div>
        </form>
    </div>
</div>
