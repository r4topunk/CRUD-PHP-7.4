<?php

namespace Magazord\View;

require_once __DIR__ . '/../../vendor/autoload.php';
include __DIR__ . '/../inicio-html.php';
?>

<script>
    function deletaPessoa($iId) {
        const params = new URLSearchParams();
        debugger;
        params.append('id', $iId);
        axios.post('/manutencao-pessoa?processo=manutencao&acao=deletar', params);
        document.location.reload(true);
    }
</script>

<div class="d-grid gap-2 my-2">
    <a class="btn btn-primary" href="/manutencao-pessoa?processo=exibicao&acao=incluir" role="button">Inserir Pessoa</a>
</div>

<table class="table">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Nome</th>
            <th scope="col">CPF</th>
            <th scope="col">Ações</th>
        </tr>
    </thead>
    <tbody>

        <?php

        foreach ($aPessoas as $oPessoa) {
            $sUrlManutencao = '/manutencao-pessoa?processo=exibicao&id=' . $oPessoa->getId();

            echo '<tr>';
            echo "<th scope=\"row\">{$oPessoa->getId()}</th>";
            echo "<td>{$oPessoa->getNome()}</td>";
            echo "<td>{$oPessoa->getCpf()}</td>";
            echo '<td>';
            echo '<a href="' . $sUrlManutencao . '&acao=visualizar" class="view" title="View" data-toggle="tooltip"><i class="material-icons">&#xE417;</i></a>';
            echo '<a href="' . $sUrlManutencao . '&acao=alterar" class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>';
            echo "<a onclick=\"deletaPessoa({$oPessoa->getId()})\" href=\"javascript:void()\" class=\"delete\" title=\"Delete\" data-toggle=\"tooltip\"><i class=\"material-icons\">&#xE872;</i></a>";
            echo '</td>';
            echo '</tr>';
        }

        ?>

    </tbody>
</table>

<?php include __DIR__ . '/../fim-html.php' ?>