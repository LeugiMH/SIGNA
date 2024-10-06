<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include_once "resource/head.php";?>
    <title>SIGNA</title>
</head>
<body>
    <div class="corpo h-100">
        <?php include_once "resource/navbarControle.php";?>
        <div class="conteudo bg-secondary h-100">
            <section class="container-fluid folhas1 pt-5 m-0 row justify-content-center align-content-center" style="min-height: 50vh;">
                <div class="col-lg-6" style="z-index: 2;">
                    <!-- Conteúdo -->
                    <header class="display-1 text-center my-4">CONTAINER 1</header>
                </div>
            </section>
            <section class="container-fluid folhas2 p-3 m-0  row justify-content-center align-content-center position-relative" style="min-height: 50vh;">
                <img src="<?php echo URL.'resource/ui/bg/bg_nuvem_icon.svg'?>" class="nuvem nuvem-top px-0 mt-0">
                <div class="col-lg-6 mt-5" style="z-index: 2;">
                    <!-- Conteúdo -->
                    <header class="display-1 text-center my-4">CONTAINER 2</header>
                </div>
            </section>
        </div>
        <?php include_once "resource/footerControle.php";?>
    </div>
    <?php include_once "resource/plugins.php";?>
</body>
</html>