<?php

namespace Magazord\View;

require_once __DIR__ . '/../../vendor/autoload.php';
include __DIR__ . '/../inicio-html.php';
?>

<script>
    function deletaContato($iId) {
        const params = new URLSearchParams();
        params.append('id', $iId);
        axios.post('/manutencao-contato?processo=manutencao&acao=deletar', params);
        document.location.reload(true);
    }
</script>

<div class="d-grid gap-2 my-2">
    <a class="btn btn-primary" href="/manutencao-contato?acao=incluir&processo=exibicao" role="button">Inserir Contato</a>
</div>

<table class="table">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Tipo</th>
            <th scope="col">Descrição</th>
            <th scope="col">Pessoa</th>
            <th scope="col">Ações</th>
        </tr>
    </thead>
    <tbody>

        <?php

        foreach ($aContatos as $oContato) {
            $sTipo = $oContato->getTipo() ? 'true' : 'false';
            $sUrlManutencao = '/manutencao-contato?id=' . $oContato->getId();

            echo '<tr>';
            echo "<th scope=\"row\">{$oContato->getId()}</th>";
            echo "<td>$sTipo</td>";
            echo "<td>{$oContato->getDescricao()}</td>";
            echo "<td>{$oContato->getPessoa()->getNome()}</td>";
            echo '<td>';
            echo '<a href="' . $sUrlManutencao . '&acao=visualizar&processo=exibicao" class="view" title="View" data-toggle="tooltip"><i class="material-icons">&#xE417;</i></a>';
            echo '<a href="' . $sUrlManutencao . '&acao=alterar&processo=exibicao" class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>';
            echo "<a onclick=\"deletaContato({$oContato->getId()})\" href=\"javascript:void()\" idContato=\"{$oContato->getId()}\" class=\"delete\" title=\"Delete\" data-toggle=\"tooltip\"><i class=\"material-icons\">&#xE872;</i></a>";
            echo '</td>';
            echo '</tr>';
        }

        ?>

    </tbody>
</table>

<?php include __DIR__ . '/../fim-html.php' ?>