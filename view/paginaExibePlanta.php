<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include_once "resource/head.php";?>
    <title>SIGNA</title>
</head>
<body>
    <div class="corpo min-vh-100 h-100">
        <?php include_once "resource/navbarControle.php";?>
        <div class="conteudo bg-secondary h-100">
            <div class="container-fluid folhas p-0 m-0 row justify-content-center align-content-center position-relative h-100">
                <section class="col-sm-10 col-lg-8 col-xl-6 p-0 my-5" style="z-index: 2;">
                    <!-- Conteúdo -->
                    <header class="display-1 text-center mb-3 text-break"><?php echo $planta->NOMEPOP;?></header>
                    <h2 class="text-center mb-5"><?php echo $planta->NOMECIE;?></h2>
                    <article class="bg-verde p-3 p-lg-5 rounded-4 text-white ">
                        <div class="row m-0 mb-md-3">
                            <div class="col-md-6 p-0 mb-3 mb-md-0">
                                <figure class="figure imgview1">
                                    <img src="<?php echo isset($planta->IMGESPECIE) ? URL."resource/imagens/especies/$planta->IMGESPECIE" : URL."resource/sem_imagem.jpg";?>" aria-label="<?php echo "$planta->DESCESPECIE";?>" alt="<?php echo "$planta->DESCESPECIE";?>" class="w-100 rounded">
                                    <figcaption class="figure-caption text-white">Imagem de exemplo da espécie.</figcaption>
                                </figure>
                                    
                            </div>
                            <div class="col-md-6 p-0">
                                <p><strong><?php echo "Diâmetro na altura do peito (m):</strong> ".number_format($planta->DAP, 2, ',', '.');?></p>
                                <hr>
                                <p><strong><?php echo "Data de plantio:</strong> ".date("d/m/Y",strtotime($planta->DATPLANT));?></p>
                            </div>
                        </div>
                        <div class="row m-0">
                            <div class="col-md-6 p-0">
                                <p><strong><?php echo "Família:</strong> $planta->FAMILIA";?></p>
                                <hr>
                                <p><strong><?php echo "Habitat natural:</strong> $planta->HABITAT";?></p>
                                <hr>
                                <p><strong><?php echo "Altura máxima:</strong> ".number_format($planta->ALTURA, 2, ',', '.')." metro(s)";?></p>
                                <?php
                                    foreach ($atributos as $atributo)
                                    {
                                        echo "<hr><p><strong>$atributo->NOMEATRIBUTO:</strong> $atributo->DESCRICAO</p>";
                                    }
                                ?>
                            </div>
                            <div class="col-md-6 p-0">
                                <figure class="figure imgview2">
                                    <img src="<?php echo isset($planta->IMGESPECIME) ? URL."resource/imagens/especimes/$planta->IMGESPECIME" : URL."resource/sem_imagem.jpg" ;?>" aria-label="<?php echo "$planta->DESCESPECIME";?>" class=" w-100 figure-img img-fluid rounded" alt="<?php echo "$planta->DESCESPECIME";?>">
                                    <figcaption class="figure-caption text-end text-white">Imagem da planta na instituição.</figcaption>
                                </figure>
                                <!--<img src="<?php echo URL."resource/imagens/especimes/$planta->IMGESPECIME";?>" aria-label="<?php echo "$planta->DESCESPECIME";?>" alt="Imagem da espécie" class="w-100 rounded imgview2">-->
                            </div>
                        </div>
                    </article>
                </section>
                <img src="<?php echo URL.'resource/ui/bg/bg_nuvem_completo.svg'?>" class="nuvem nuvem-mid p-0" style="z-index: 0!important;">
            </div>
        </div>
        <?php include_once "resource/rodape.php";?>
    </div>
    <?php include_once "resource/plugins.php";?>
</body>
</html>