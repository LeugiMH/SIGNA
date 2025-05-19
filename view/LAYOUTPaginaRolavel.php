<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include_once "resource/head.php";?>
    <title>SIGNA - Sistema de Gerenciamente do Núcleo arbóreo</title>
</head>
<body>
    <div class="corpo h-100">
        <?php include_once "resource/navbarControle.php";?>
        <div class="conteudo bg-secondary h-100 clouds">
            <section class="container-fluid folhas1 pt-5 m-0 row justify-content-center align-content-center" >
                <div class="col-lg-6" style="z-index: 2;">
                    <!-- Conteúdo -->
                    <header class="display-1 text-center my-4">CONTAINER 1</header>
                </div>
            </section>
            <img src="<?php echo URL.'resource/ui/bg/bg_nuvem_corrected.svg'?>" class="nuvem nuvem-top px-0">
            <section class="container-fluid folhas2 p-3 m-0  row justify-content-center align-content-center position-relative">
                <div class="col-lg-6 mt-5" style="z-index: 2;">
                </div>
            </section>
        </div>
        <?php include_once "resource/footerControle.php";?>
    </div>
    <?php include_once "resource/plugins.php";?>
</body>
</html>