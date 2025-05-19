<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include_once "resource/head.php";?>
    <title>SIGNA - Sistema de Gerenciamente do Núcleo arbóreo</title>
</head>
<body>
    <div class="corpo min-vh-100 h-100">
        <?php include_once "resource/navbarControle.php";?>
        <div class="conteudo bg-secondary h-100 clouds">
            <div class="container-fluid folhas p-0 m-0 row justify-content-center align-content-center position-relative h-100">
                <section class="col-sm-8 col-lg-6 col-xl-4 p-0 my-5" style="z-index: 2;">
                    <!-- Conteúdo -->
                    <header class="display-1 text-center mb-4">CONTAINER</header>
                    <article class="bg-verde p-3 p-lg-5 rounded-4 text-white m-0">
                    </article>
                </section>
                <img src="<?php echo URL.'resource/ui/bg/bg_nuvem_completo.svg'?>" class="nuvem nuvem-mid p-0" style="z-index: 0!important;">
            </div>
        </div>
        <?php include_once "resource/footerControle.php";?>
    </div>
    <?php include_once "resource/footerControle.php";?>
</body>
</html>