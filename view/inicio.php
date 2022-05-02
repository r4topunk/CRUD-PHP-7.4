<?php include 'inicio-html.php' ?>

<div class="px-4 text-center">
    <h1 class="display-5 fw-bold"> <?= $titulo ?> </h1>
    <div class="col-lg-6 mx-auto">
        <p class="lead mb-4">Teste Back-end</p>
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            <a href="/consulta-pessoas" class="btn btn-primary btn-lg px-4 gap-3">Pessoas</a>
            <a href="/consulta-contatos"" class=" btn btn-outline-secondary btn-lg px-4">Contatos</a>
        </div>
    </div>
</div>

<?php include 'fim-html.php' ?>