<?php
/** @var string $title */
/** @var array|null $client */
/** @var array $old */

$zipRaw = $old['zip_code'] ?? $client['zip_code'] ?? '';
if (preg_match('/^\d{8}$/', $zipRaw)) {
    $zipRaw = substr($zipRaw, 0, 5) . '-' . substr($zipRaw, 5);
}
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
                <div class="col-md-3">
                    <label class="form-label">CEP</label>
                    <input type="text" name="zip_code" id="client_zip_code" class="form-control" inputmode="numeric" pattern="\d{5}-?\d{3}" placeholder="00000-000" value="<?= htmlspecialchars($zipRaw) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Número</label>
                    <input type="text" name="number" id="client_number" class="form-control" value="<?= htmlspecialchars($old['number'] ?? $client['number'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Endereço</label>
                    <input type="text" name="street" id="client_street" class="form-control" value="<?= htmlspecialchars($old['street'] ?? $client['street'] ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Bairro</label>
                    <input type="text" name="neighborhood" id="client_neighborhood" class="form-control" value="<?= htmlspecialchars($old['neighborhood'] ?? $client['neighborhood'] ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Cidade</label>
                    <input type="text" name="city" id="client_city" class="form-control" value="<?= htmlspecialchars($old['city'] ?? $client['city'] ?? '') ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Estado</label>
                    <input type="text" name="state" id="client_state" class="form-control text-uppercase" maxlength="2" value="<?= htmlspecialchars($old['state'] ?? $client['state'] ?? '') ?>">
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cepInput = document.getElementById('client_zip_code');
        if (!cepInput) {
            return;
        }

        const streetInput = document.getElementById('client_street');
        const numberInput = document.getElementById('client_number');
        const neighborhoodInput = document.getElementById('client_neighborhood');
        const cityInput = document.getElementById('client_city');
        const stateInput = document.getElementById('client_state');

        if (!streetInput || !numberInput || !neighborhoodInput || !cityInput || !stateInput) {
            return;
        }

        const clearAddressFields = () => {
            streetInput.value = '';
            neighborhoodInput.value = '';
            cityInput.value = '';
            stateInput.value = '';
        };

        const setCepValidity = (message) => {
            cepInput.setCustomValidity(message);
            if (message) {
                cepInput.reportValidity();
            }
        };

        cepInput.addEventListener('input', () => {
            setCepValidity('');
        });

        cepInput.addEventListener('blur', () => {
            let cep = cepInput.value.replace(/\D/g, '');
            if (cep.length === 0) {
                setCepValidity('');
                return;
            }

            if (cep.length !== 8) {
                setCepValidity('Informe um CEP válido com 8 dígitos.');
                return;
            }

            setCepValidity('');
            cepInput.value = cep.replace(/(\d{5})(\d{3})/, '$1-$2');

            fetch('https://viacep.com.br/ws/' + cep + '/json/')
                .then((response) => response.json())
                .then((data) => {
                    if (data.erro) {
                        clearAddressFields();
                        setCepValidity('CEP não encontrado.');
                        return;
                    }

                    if (data.logradouro) streetInput.value = data.logradouro;
                    if (data.bairro) neighborhoodInput.value = data.bairro;
                    if (data.localidade) cityInput.value = data.localidade;
                    if (data.uf) stateInput.value = data.uf;
                    setCepValidity('');
                    if (!numberInput.value) {
                        numberInput.focus();
                    }
                })
                .catch(() => {
                    clearAddressFields();
                    setCepValidity('Não foi possível buscar o CEP agora.');
                });
        });
    });
</script>
