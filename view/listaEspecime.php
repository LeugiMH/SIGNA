<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include_once "resource/head.php";?>
    <title>SIGNA</title>
</head>

<body class="d-flex flex-column min-vh-100">
    <div class="corpo-list min-vh-100 h-100">
        <?php include_once "resource/navbarControle.php";?>
        <div class="conteudo bg-secondary h-100">
            <div
                class="container-fluid folhas p-0 m-0 row justify-content-center align-content-center position-relative h-100">
                <div class="col-sm-12 col-lg-10 col-xl-8 p-0 my-5" style="z-index: 2;">
                    <!-- Conteúdo -->
                    <h1 class="display-1 text-center mb-5">Plantas Registradas</h1>
                    <div class="bg-verde p-3 rounded-4 text-white">
                        <div class="table-responsive">
                        <table id="tabela" class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Espécie</th>
                                    <th>Estado</th>
                                    <th>Coord</th>
                                    <th>DAP</th>
                                    <th>Imagem</th>
                                    <th>DescImg</th>
                                    <th>Cadastro</th>
                                    <th>Admin</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach($plantas as $planta)
                                {
                                echo "
                                <tr>
                                    <td>$planta->IDESPECIME</td>
                                    <td>$planta->IDESPECIE</td>
                                    <td>$planta->ESTADO</td>
                                    <td>$planta->COORD</td>
                                    <td>$planta->DAP</td>
                                    <td>$planta->IMAGEM</td>
                                    <td>$planta->DESCRICAOIMG</td>
                                    <td>$planta->DATACAD</td>                               
                                    <td>$planta->IDCADADM</td>                               
                                </tr>
                                ";
                                }
                                ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Espécie</th>
                                <th>Estado</th>
                                <th>Coord</th>
                                <th>DAP</th>
                                <th>Imagem</th>
                                <th>DescImg</th>
                                <th>Cadastro</th>
                                <th>Admin</th>
                                </tr>
                            </tfoot>
                        </table>
                        </div>
                    </div>
                </div>
                <img src="<?php echo URL.'resource/ui/bg/bg_nuvem_completo.svg'?>" class="nuvem nuvem-mid p-0"
                    style="z-index: 0!important;">
            </div>
        </div>
        <?php include_once "resource/footerControle.php";?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.bootstrap5.js"></script>
    <script>
    $(document).ready(function() {
        $('#tabela').DataTable({
            language: {
                url: "<?php echo URL.'resource/json/pt_br.json';?>"
            }
        });
    });
    </script>
</body>

</html>