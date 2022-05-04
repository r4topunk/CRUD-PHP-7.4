<?php

namespace Magazord\View;

require_once __DIR__ . '/../../vendor/autoload.php';
include __DIR__ . '/../inicio-html.php';
?>

<form method="post" action="/manutencao-pessoa?processo=manutencao&acao=<?= $bIsInclusao ? 'incluir' : 'alterar' ?>">

    <?php if (!$bIsInclusao) { ?>
        <div class="form-group">
            <label for="idPessoa">ID</label>
            <input name='id' type="number" class="form-control" id="id" value="<?= $xId ?>" readonly>
        </div>
    <?php } ?>

    <div class="form-group">
        <label for="nome">Nome</label>
        <input name="nome" type="text" class="form-control" id="nome" value="<?= $xNome ?>" placeholder="Ex: Gustavo Rafael Kuhl" required <?= !$bReadOnly ?: 'readonly' ?>>
    </div>
    <div class="form-group">
        <label for="cpf">CPF</label>
        <input name="cpf" type="text" class="form-control" id="cpf" value="<?= $xCpf ?>" onkeypress="$(this).mask('000.000.000-00');" required placeholder="000.000.000-00" <?= !$bReadOnly ?: 'readonly' ?>>
    </div>

    <div class="mt-1">
    <?php if (!$bReadOnly) { ?>
        <button type="submit" class="btn btn-primary">Enviar</button>
        <?php } ?>
        <a href="/consulta-pessoas"" class=" btn btn-outline-warning">Voltar</a>
    </div>

</form>

<?php include __DIR__ . '/../fim-html.php' ?>