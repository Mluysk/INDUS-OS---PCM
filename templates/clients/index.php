<?php
/** @var array $clients */
?>
<div class="app-section-head">
    <div>
        <h2 class="h4 mb-0">Clientes</h2>
        <p class="text-muted mb-0">Cadastre parceiros e mantenha visibilidade dos contratos atendidos.</p>
    </div>
    <a href="<?= htmlspecialchars(pcm_url('clients.php?action=create')) ?>" class="btn btn-primary"><i class="bi bi-person-plus me-1"></i> Novo cliente</a>
</div>
<div class="card border-0 app-table-card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Responsável</th>
                        <th>Contato</th>
                        <th>Segmento</th>
                        <th>Localização</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($clients)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Nenhum cliente cadastrado.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($clients as $client): ?>
                            <tr>
                                <td class="fw-semibold">
                                    <?= htmlspecialchars($client['company_name']) ?><br>
                                    <small class="text-muted">Documento: <?= htmlspecialchars($client['document'] ?: '—') ?></small>
                                </td>
                                <td><?= htmlspecialchars($client['contact_name'] ?: '—') ?></td>
                                <td>
                                    <div><?= htmlspecialchars($client['email'] ?: '—') ?></div>
                                    <div class="text-muted small"><?= htmlspecialchars($client['phone'] ?: '') ?></div>
                                </td>
                                <td><?= htmlspecialchars($client['segment'] ?: '—') ?></td>
                                <td>
                                    <?php
                                    $addressLines = [];
                                    if (!empty($client['street'])) {
                                        $line = $client['street'];
                                        if (!empty($client['number'])) {
                                            $line .= ', ' . $client['number'];
                                        }
                                        $addressLines[] = $line;
                                    }
                                    if (!empty($client['neighborhood'])) {
                                        $addressLines[] = $client['neighborhood'];
                                    }
                                    $cityState = trim(($client['city'] ?? '') . (!empty($client['state']) ? ' / ' . $client['state'] : ''));
                                    if ($cityState !== '') {
                                        $addressLines[] = $cityState;
                                    }
                                    if (!empty($client['zip_code'])) {
                                        $zip = $client['zip_code'];
                                        if (preg_match('/^\d{8}$/', $zip)) {
                                            $zip = substr($zip, 0, 5) . '-' . substr($zip, 5);
                                        }
                                        $addressLines[] = 'CEP ' . $zip;
                                    }
                                    ?>
                                    <?php if (!empty($addressLines)): ?>
                                        <?php foreach ($addressLines as $line): ?>
                                            <div><?= htmlspecialchars($line) ?></div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <a href="<?= htmlspecialchars(pcm_url('clients.php?action=edit&id=' . $client['id'])) ?>" class="btn btn-sm btn-outline-secondary me-2"><i class="bi bi-pencil"></i></a>
                                    <form method="post" action="<?= htmlspecialchars(pcm_url('clients.php')) ?>" class="d-inline" onsubmit="return confirm('Confirma a exclusão do cliente?');">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(pcm_csrf_token()) ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?= $client['id'] ?>">
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
