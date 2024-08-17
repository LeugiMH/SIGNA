<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include_once "resource/head.php";?>
    <title>SIGNA</title>
    <style>

    #map { height: 500px; z-index: 100; }
    </style>
</head>
<body>
    <div class="corpo h-100">
        <?php include_once "resource/navbarControle.php";?>
        <div class="conteudo bg-secondary h-100">
            <div class="container-fluid folhas1 pt-5 m-0 row justify-content-center align-content-center" style="min-height: 50vh;">
                <!--Container de conteúdo-->
                <div class="col-lg-6" style="z-index: 2;">
                    <h1 class="display-1 text-center my-5">Login</h1>
                </div>
            </div>
            <div class="container-fluid folhas2 p-3 m-0  row justify-content-center align-content-center position-relative" style="min-height: 50vh;">
                <img src="<?php echo URL.'resource/ui/bg/bg_nuvem_icon.svg'?>" class="nuvem nuvem-top px-0 mt-0">
                <div class="col-lg-6 mt-5">
                    <!--Container de conteúdo-->
                </div>
            </div>
        </div>
        <div class="rodape bg-dark text-white h-100">
            <div class="py-4 text-center row m-0 p-0">
                <h3 class="m-0 p-0 col" id="teste_coord">RODAPÉ</h3>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>