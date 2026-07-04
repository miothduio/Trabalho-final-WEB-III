<div class="modal fade" id="produtoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"> <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            
            <div class="modal-header border-0 pb-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <span class="text-uppercase small fw-bold tracking-wider text-muted">Detalhes do Item</span>
                <button type="button" class="btn-close p-2 bg-light rounded-circle" data-bs-dismiss="modal" aria-label="Close" style="font-size: 0.75rem;"></button>
            </div>

            <div class="modal-body p-4">
                <div class="row g-4 align-items-start">
                    
                    <div class="col-md-6">
                        <div class="position-relative shadow-sm rounded-3 overflow-hidden bg-light d-flex align-items-center justify-content-center" style="min-height: 280px; max-height: 340px;">
                            <img id="modalImagem" class="img-fluid w-100 h-100" style="object-fit: cover; max-height: 340px;" alt="Imagem do produto">
                        </div>
                    </div>

                    <div class="col-md-6 d-flex flex-column justify-content-between">
                        <div>
                            <h2 id="modalNome" class="fw-bold text-dark mb-2 fs-3"></h2>
                            <p id="modalDescricao" class="text-muted small mb-4" style="line-height: 1.5;"></p>
                            
                            <div class="d-flex align-items-baseline gap-2 mb-3">
                                <span class="text-muted small fw-medium">Preço unitário:</span>
                                <h3 id="modalPreco" class="fw-bold text-success m-0 fs-2"></h3>
                            </div>
                        </div>

                        <hr class="text-muted my-3 opacity-25">

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-uppercase text-muted mb-2">Quantidade</label>
                            <div class="d-flex align-items-center" style="max-width: 160px;">
                                <button type="button" class="btn btn-outline-secondary px-3 py-2 border-end-0" onclick="alterarQuantidadeModal(-1)" style="border-radius: 8px 0 0 8px; font-weight: bold;">
                                    -
                                </button>
                                
                                <input type="number" value="1" min="1" id="quantidade" class="form-control text-center py-2 fw-bold fs-5 border-start-0 border-end-0 rounded-0" readonly style="background: transparent; box-shadow: none;">
                                
                                <button type="button" class="btn btn-outline-secondary px-3 py-2 border-start-0" onclick="alterarQuantidadeModal(1)" style="border-radius: 0 8px 8px 0; font-weight: bold;">
                                    +
                                </button>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="observacao" class="form-label fw-semibold small text-uppercase text-muted mb-2">Alguma observação? (Opcional)</label>
                            <textarea id="observacao" class="form-control border-light-subtle" rows="3" placeholder="Ex: Tirar cebola, ponto da carne, gelo e limão..." style="border-radius: 10px; resize: none; padding: 12px; font-size: 0.95rem;"></textarea>
                        </div>

                        <button class="btn btn-success w-100 py-3 fw-bold rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2 transition-all" onclick="adicionarCarrinho()" style="font-size: 1.05rem;">
                            <span>Adicionar à Sacola</span>
                            <span style="font-size: 1.15rem;">🛍️</span>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
function alterarQuantidadeModal(valor) {
    const inputQtd = document.getElementById('quantidade');
    let atual = parseInt(inputQtd.value) || 1;
    let novo = atual + valor;
    
    if (novo >= 1) {
        inputQtd.value = novo;
    }
}
</script>