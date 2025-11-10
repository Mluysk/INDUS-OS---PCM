<?php
/** @var string $title */
/** @var array|null $order */
/** @var array $old */
/** @var array $equipmentOptions */
/** @var array $technicianOptions */
/** @var array $planOptions */
/** @var array $tasks */
?>
<div class="mb-4 d-flex justify-content-between align-items-center">
    <a href="<?= htmlspecialchars(pcm_url('work_orders.php')) ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Voltar</a>
    <?php if ($order): ?>
        <span class="badge text-bg-info text-uppercase">Status atual: <?= htmlspecialchars($order['status']) ?></span>
    <?php endif; ?>
</div>
<div class="card border-0 mb-4">
    <div class="card-header bg-white border-0 pb-0">
        <h2 class="h4 mb-0"><?= htmlspecialchars($title) ?></h2>
    </div>
    <div class="card-body">
        <form method="post" action="<?= htmlspecialchars(pcm_url('work_orders.php')) ?>">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(pcm_csrf_token()) ?>">
            <?php if ($order): ?>
                <input type="hidden" name="id" value="<?= $order['id'] ?>">
            <?php endif; ?>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Equipamento *</label>
                    <select name="equipment_id" class="form-select" required>
                        <option value="">Selecione...</option>
                        <?php $selectedEquipment = $old['equipment_id'] ?? $order['equipment_id'] ?? ''; ?>
                        <?php foreach ($equipmentOptions as $equipment): ?>
                            <option value="<?= $equipment['id'] ?>" <?= (string) $selectedEquipment === (string) $equipment['id'] ? 'selected' : '' ?>><?= htmlspecialchars($equipment['name']) ?> (<?= htmlspecialchars($equipment['asset_tag']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Plano associado</label>
                    <select name="plan_id" class="form-select">
                        <option value="">Sem vínculo</option>
                        <?php $selectedPlan = $old['plan_id'] ?? $order['plan_id'] ?? ''; ?>
                        <?php foreach ($planOptions as $plan): ?>
                            <option value="<?= $plan['id'] ?>" <?= (string) $selectedPlan === (string) $plan['id'] ? 'selected' : '' ?>><?= htmlspecialchars($plan['title']) ?> — <?= htmlspecialchars($plan['equipment_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Responsável</label>
                    <select name="technician_id" class="form-select">
                        <option value="">Definir depois</option>
                        <?php $selectedTechnician = $old['technician_id'] ?? $order['technician_id'] ?? ''; ?>
                        <?php foreach ($technicianOptions as $technician): ?>
                            <option value="<?= $technician['id'] ?>" <?= (string) $selectedTechnician === (string) $technician['id'] ? 'selected' : '' ?>><?= htmlspecialchars($technician['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <?php $selectedStatus = $old['status'] ?? $order['status'] ?? 'aberta'; ?>
                    <select name="status" class="form-select">
                        <?php foreach (['aberta' => 'Aberta', 'planejada' => 'Planejada', 'em_execucao' => 'Em execução', 'aguardando' => 'Aguardando peças', 'concluida' => 'Concluída'] as $value => $label): ?>
                            <option value="<?= $value ?>" <?= $selectedStatus === $value ? 'selected' : '' ?>><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Prioridade</label>
                    <?php $selectedPriority = $old['priority'] ?? $order['priority'] ?? 'media'; ?>
                    <select name="priority" class="form-select">
                        <?php foreach (['baixa' => 'Baixa', 'media' => 'Média', 'alta' => 'Alta', 'critica' => 'Crítica'] as $value => $label): ?>
                            <option value="<?= $value ?>" <?= $selectedPriority === $value ? 'selected' : '' ?>><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Previsão de término</label>
                    <input type="date" name="due_date" class="form-control" value="<?= htmlspecialchars($old['due_date'] ?? ($order['due_date'] ? substr($order['due_date'], 0, 10) : '') ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Início</label>
                    <input type="datetime-local" name="started_at" class="form-control" value="<?= htmlspecialchars($old['started_at'] ?? ($order['started_at'] ? str_replace(' ', 'T', substr($order['started_at'], 0, 16)) : '') ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Conclusão</label>
                    <input type="datetime-local" name="completed_at" class="form-control" value="<?= htmlspecialchars($old['completed_at'] ?? ($order['completed_at'] ? str_replace(' ', 'T', substr($order['completed_at'], 0, 16)) : '') ?? '') ?>">
                </div>
                <div class="col-12">
                    <label class="form-label">Notas operacionais</label>
                    <textarea name="notes" rows="3" class="form-control" placeholder="Sintoma, diagnóstico, providências..."><?= htmlspecialchars($old['notes'] ?? $order['notes'] ?? '') ?></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Feedback pós-serviço</label>
                    <textarea name="feedback" rows="3" class="form-control" placeholder="Resultados, recomendações, peças substituídas..."><?= htmlspecialchars($old['feedback'] ?? $order['feedback'] ?? '') ?></textarea>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="<?= htmlspecialchars(pcm_url('work_orders.php')) ?>" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-primary">Salvar OS</button>
            </div>
        </form>
    </div>
</div>

<?php if ($order): ?>
<div class="card border-0">
    <div class="card-header bg-white border-0 pb-0 d-flex justify-content-between align-items-center">
        <div>
            <h2 class="h5 mb-0">Checklist da OS</h2>
            <p class="text-muted mb-0">Detalhe as atividades executadas e marque o progresso.</p>
        </div>
    </div>
    <div class="card-body">
        <form method="post" action="<?= htmlspecialchars(pcm_url('work_orders.php')) ?>" class="row g-3 align-items-end">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(pcm_csrf_token()) ?>">
            <input type="hidden" name="action" value="save_task">
            <input type="hidden" name="work_order_id" value="<?= $order['id'] ?>">
            <div class="col-md-8">
                <label class="form-label">Nova atividade</label>
                <input type="text" name="description" class="form-control" placeholder="Descreva a atividade a ser executada" required>
            </div>
            <div class="col-md-2">
                <div class="form-check mt-4">
                    <input class="form-check-input" type="checkbox" name="is_completed" id="taskCompleted">
                    <label class="form-check-label" for="taskCompleted">Concluída</label>
                </div>
            </div>
            <div class="col-md-2 text-end">
                <button type="submit" class="btn btn-success w-100">Adicionar</button>
            </div>
        </form>
        <hr>
        <?php if (empty($tasks)): ?>
            <p class="text-muted mb-0">Nenhuma atividade registrada ainda.</p>
        <?php else: ?>
            <ul class="list-group list-group-flush">
                <?php foreach ($tasks as $task): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <span class="fw-semibold <?= $task['is_completed'] ? 'text-success' : '' ?>">
                                <?= htmlspecialchars($task['description']) ?>
                            </span>
                            <?php if ($task['is_completed']): ?>
                                <span class="badge bg-success-subtle text-success ms-2">feito</span>
                            <?php endif; ?>
                        </div>
                        <div class="d-flex gap-2">
                            <form method="post" action="<?= htmlspecialchars(pcm_url('work_orders.php')) ?>" class="d-inline">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(pcm_csrf_token()) ?>">
                                <input type="hidden" name="action" value="save_task">
                                <input type="hidden" name="id" value="<?= $task['id'] ?>">
                                <input type="hidden" name="work_order_id" value="<?= $order['id'] ?>">
                                <input type="hidden" name="description" value="<?= htmlspecialchars($task['description'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
                                <input type="hidden" name="is_completed" value="<?= $task['is_completed'] ? '' : '1' ?>">
                                <button type="submit" class="btn btn-sm btn-outline-secondary">
                                    <?= $task['is_completed'] ? 'Desmarcar' : 'Concluir' ?>
                                </button>
                            </form>
                            <form method="post" action="<?= htmlspecialchars(pcm_url('work_orders.php')) ?>" class="d-inline" onsubmit="return confirm('Remover esta atividade?');">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(pcm_csrf_token()) ?>">
                                <input type="hidden" name="action" value="delete_task">
                                <input type="hidden" name="id" value="<?= $task['id'] ?>">
                                <input type="hidden" name="work_order_id" value="<?= $order['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>
