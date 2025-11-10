<?php
/** @var string $title */
/** @var array|null $plan */
/** @var array $old */
/** @var array $equipmentOptions */
?>
<div class="app-section-head">
    <div>
        <h2 class="h4 mb-0"><?= htmlspecialchars($title) ?></h2>
        <p class="text-muted mb-0">Organize rotinas preventivas, responsáveis e tempo padrão de execução.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= htmlspecialchars(pcm_url('plans.php')) ?>" class="btn btn-soft"><i class="bi bi-arrow-left"></i> Voltar</a>
    </div>
</div>
<div class="card border-0 app-form-card">
    <div class="card-body">
        <form method="post" action="<?= htmlspecialchars(pcm_url('plans.php')) ?>">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(pcm_csrf_token()) ?>">
            <?php if ($plan): ?>
                <input type="hidden" name="id" value="<?= $plan['id'] ?>">
            <?php endif; ?>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Equipamento *</label>
                    <select name="equipment_id" class="form-select" required>
                        <option value="">Selecione o ativo...</option>
                        <?php $selectedEquipment = $old['equipment_id'] ?? $plan['equipment_id'] ?? ''; ?>
                        <?php foreach ($equipmentOptions as $equipment): ?>
                            <option value="<?= $equipment['id'] ?>" <?= (string) $selectedEquipment === (string) $equipment['id'] ? 'selected' : '' ?>><?= htmlspecialchars($equipment['name']) ?> (<?= htmlspecialchars($equipment['asset_tag']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Título do plano *</label>
                    <input type="text" name="title" class="form-control" required value="<?= htmlspecialchars($old['title'] ?? $plan['title'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Frequência *</label>
                    <input type="text" name="frequency" class="form-control" required placeholder="Ex: Mensal, a cada 500h" value="<?= htmlspecialchars($old['frequency'] ?? $plan['frequency'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Duração estimada (minutos)</label>
                    <input type="number" name="estimated_duration" class="form-control" min="0" value="<?= htmlspecialchars($old['estimated_duration'] ?? $plan['estimated_duration'] ?? '') ?>">
                </div>
                <div class="col-12">
                    <label class="form-label">Descrição detalhada</label>
                    <textarea name="description" rows="4" class="form-control" placeholder="Passo a passo, checklists e orientações"><?= htmlspecialchars($old['description'] ?? $plan['description'] ?? '') ?></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Ferramentas / materiais necessários</label>
                    <textarea name="required_tools" rows="3" class="form-control"><?= htmlspecialchars($old['required_tools'] ?? $plan['required_tools'] ?? '') ?></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Notas de segurança</label>
                    <textarea name="safety_notes" rows="3" class="form-control">&bull; Utilize EPI adequado para a atividade.
&bull; Bloqueie e identifique fontes de energia antes de intervir.
<?= htmlspecialchars($old['safety_notes'] ?? $plan['safety_notes'] ?? '') ?></textarea>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="<?= htmlspecialchars(pcm_url('plans.php')) ?>" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-primary">Salvar plano</button>
            </div>
        </form>
    </div>
</div>
