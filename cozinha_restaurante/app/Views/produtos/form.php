<?= $this->extend($layout) ?>

<?= $this->section('content') ?>

<?php

$editando = isset($produto);

?>

<div class="container-fluid">

    <div class="row justify-content-center">

        <div class="col-lg-10">

            <div class="card shadow-sm">

                <div class="card-header bg-white">

                    <h3 class="mb-0">

                        <?= $editando ? 'Editar Produto' : 'Novo Produto' ?>

                    </h3>

                </div>

                <div class="card-body">

                    <form

                        action="<?= $editando
                            ? base_url('produtos/atualizar/'.$produto['id'])
                            : base_url('produtos/salvar') ?>"

                        method="post"

                        enctype="multipart/form-data">

                        <div class="row">

                            <div class="col-md-8">

                                <div class="mb-3">

                                    <label class="form-label">

                                        Nome do Produto

                                    </label>

                                    <input

                                        type="text"

                                        class="form-control"

                                        name="nome"

                                        required

                                        value="<?= $editando ? esc($produto['nome']) : '' ?>">

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="mb-3">

                                    <label class="form-label">

                                        Categoria

                                    </label>

                                    <select

                                        class="form-select"

                                        name="categoria"

                                        required>

                                        <option value="">

                                            Selecione

                                        </option>

                                        <?php foreach($categorias as $categoria): ?>

                                            <option

                                                value="<?= $categoria['id'] ?>"

                                                <?= ($editando && $produto['categoria_id']==$categoria['id']) ? 'selected' : '' ?>>

                                                <?= esc($categoria['nome']) ?>

                                            </option>

                                        <?php endforeach; ?>

                                    </select>

                                </div>

                            </div>

                        </div>

                        <div class="mb-4">

                            <label class="form-label">

                                Descrição

                            </label>

                            <textarea

                                class="form-control"

                                rows="5"

                                name="descricao"><?= $editando ? esc($produto['descricao']) : '' ?></textarea>

                        </div>

                        <div class="row">

                            <div class="col-md-4">

                                <div class="mb-3">

                                    <label class="form-label">

                                        Preço

                                    </label>

                                    <input

                                        type="text"

                                        id="preco"

                                        class="form-control"

                                        name="preco"

                                        value="<?= $editando ? $produto['preco'] : '' ?>">

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="mb-3">

                                    <label class="form-label">

                                        Estoque

                                    </label>

                                    <input

                                        type="number"

                                        class="form-control"

                                        min="0"

                                        name="estoque"

                                        value="<?= $editando ? $produto['estoque'] : 0 ?>">

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="mb-3">

                                    <label class="form-label">

                                        Tempo de Preparo (min)

                                    </label>

                                    <input

                                        type="number"

                                        class="form-control"

                                        min="0"

                                        name="tempo_preparo"

                                        value="<?= $editando ? $produto['tempo_preparo'] : '' ?>">

                                </div>

                            </div>

                        </div>
                                                <hr>

                        <div class="row">

                            <div class="col-md-6">

                                <label class="form-label fw-bold">

                                    Imagem do Produto

                                </label>

                                <?php

                                $imagemAtual = '';

                                if($editando && !empty($produto['imagem'])){

                                    $imagemAtual = base_url($produto['imagem']);

                                }

                                ?>

                                <div
                                    class="border rounded p-3 text-center bg-light">

                                    <img

                                        id="preview"

                                        src="<?= $imagemAtual ?: 'https://placehold.co/350x250?text=Selecione+uma+imagem' ?>"

                                        style="

                                        width:100%;

                                        max-width:350px;

                                        height:250px;

                                        object-fit:cover;

                                        border-radius:12px;

                                        border:2px dashed #CCC;

                                        cursor:pointer;

                                        ">

                                    <div class="mt-3">

                                        <input

                                            type="file"

                                            id="imagem"

                                            name="imagem"

                                            class="form-control"

                                            accept=".jpg,.jpeg,.png,.webp">

                                    </div>

                                    <small class="text-muted">

                                        Clique na imagem ou selecione um arquivo.

                                    </small>

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="mb-3">

                                    <label class="form-label">

                                        Produto Ativo

                                    </label>

                                    <select

                                        class="form-select"

                                        name="ativo">

                                        <option

                                            value="1"

                                            <?= (!$editando || $produto['ativo']) ? 'selected' : '' ?>>

                                            Sim

                                        </option>

                                        <option

                                            value="0"

                                            <?= ($editando && !$produto['ativo']) ? 'selected' : '' ?>>

                                            Não

                                        </option>

                                    </select>

                                </div>

                                <div class="mb-3">

                                    <label class="form-label">

                                        Produto em Destaque

                                    </label>

                                    <select

                                        class="form-select"

                                        name="destaque">

                                        <option

                                            value="1"

                                            <?= ($editando && $produto['destaque']) ? 'selected' : '' ?>>

                                            Sim

                                        </option>

                                        <option

                                            value="0"

                                            <?= (!$editando || !$produto['destaque']) ? 'selected' : '' ?>>

                                            Não

                                        </option>

                                    </select>

                                </div>

                                <div class="alert alert-info mt-4">

                                    <strong>Dica</strong>

                                    <hr>

                                    • Utilize imagens na proporção 1:1.

                                    <br>

                                    • Tamanho máximo recomendado: 2 MB.

                                    <br>

                                    • Formatos aceitos: JPG, PNG e WEBP.

                                </div>

                            </div>

                        </div>

                        <hr>

                        <div class="d-flex justify-content-end gap-2">

                            <a

                                href="<?= base_url('produtos') ?>"

                                class="btn btn-secondary">

                                Cancelar

                            </a>

                            <button

                                type="submit"

                                class="btn btn-success">

                                <i class="bi bi-check-circle"></i>

                                Salvar Produto

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>
<script>

const inputImagem = document.getElementById("imagem");

const preview = document.getElementById("preview");

preview.addEventListener("click",function(){

    inputImagem.click();

});

inputImagem.addEventListener("change",function(e){

    const arquivo = e.target.files[0];

    if(!arquivo){

        return;

    }

    if(!arquivo.type.startsWith("image/")){

        alert("Selecione apenas imagens.");

        this.value="";

        return;

    }

    if(arquivo.size > 2 * 1024 * 1024){

        alert("A imagem deve possuir no máximo 2 MB.");

        this.value="";

        return;

    }

    const leitor = new FileReader();

    leitor.onload = function(event){

        preview.src = event.target.result;

    }

    leitor.readAsDataURL(arquivo);

});

const preco = document.getElementById("preco");

preco.addEventListener("input",function(){

    let valor = this.value.replace(/\D/g,'');

    if(valor === ""){

        this.value = "";

        return;

    }

    valor = (parseInt(valor)/100)
        .toFixed(2)
        .replace(".",",");

    valor = valor.replace(

        /\B(?=(\d{3})+(?!\d))/g,

        "."

    );

    this.value = valor;

});

document.querySelector("form").addEventListener("submit",function(){

    let valor = preco.value;

    valor = valor.replace(/\./g,'');

    valor = valor.replace(",", ".");

    preco.value = valor;

});

</script>

<?= $this->endSection() ?>