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
            <div
                class="container-fluid folhas p-0 m-0 row justify-content-center align-content-center position-relative h-100">
                <div class="col-sm-12 col-lg-10 col-xl-8 p-0 my-5" style="z-index: 2;">
                    <!-- Conteúdo -->
                    <h1 class="display-1 text-center mb-5">ESPÉCIES</h1>
                    <div class="bg-verde p-3 p-lg-5 rounded-4 text-white">
                        <a href="<?php echo URL.'especies/cadastrar';?>" class="btn btn-warning">Cadastrar</a>
                        <table id="lista" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>IDESPÉCIE</th>
                                    <th>NOMECIE</th>
                                    <th>NOMEPOP</th>
                                    <th>FAMILIA</th>
                                    <th>HABITAT</th>
                                    <th>ALTURA</th>
                                    <th>IMAGEM</th>
                                    <th>DESCRICAOIMG</th>
                                    <th>DATACAD</th>
                                    <th>IDCADADM</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach($especies as $especie)
                                {
                                echo "
                                <tr>
                                    <td>$especie->IDESPECIE</td>
                                    <td>$especie->NOMECIE</td>
                                    <td>$especie->NOMEPOP</td>
                                    <td>$especie->FAMILIA</td>
                                    <td>$especie->HABITAT</td>
                                    <td>$especie->ALTURA</td>
                                    <td>$especie->IMAGEM</td>
                                    <td>$especie->DESCRICAOIMG</td>
                                    <td>$especie->DATACAD</td>                               
                                    <td>$especie->IDCADADM</td>                               
                                </tr>
                                ";
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>IDESPÉCIE</th>
                                    <th>NOMECIE</th>
                                    <th>NOMEPOP</th>
                                    <th>FAMILIA</th>
                                    <th>HABITAT</th>
                                    <th>ALTURA</th>
                                    <th>IMAGEM</th>
                                    <th>DESCRICAOIMG</th>
                                    <th>DATACAD</th>
                                    <th>IDCADADM</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <img src="<?php echo URL.'resource/ui/bg/bg_nuvem_completo.svg'?>" class="nuvem nuvem-mid p-0"
                    style="z-index: 0!important;">
            </div>
        </div>
        <?php include_once "resource/rodape.php";?>
    </div>

    <!---->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>


    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.3/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.3/js/responsive.bootstrap5.js"></script>

    <script>
    $(document).ready(function() {
        $('#lista').DataTable({
            responsive: true,
            language: {
                url: "<?php echo URL.'resource/json/pt_br.json';?>"
            },
            stateSave: true
        });
    });
    </script>


</body>

</html>