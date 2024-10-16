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
                <section class="col-sm-12 col-lg-11 p-0 my-5" style="z-index: 2;">
                    <!-- Conteúdo -->
                    <header class="display-1 text-center mb-5">ADMINISTRADORES</header>
                    <article class="bg-verde p-3 p-lg-5 rounded-4 text-white">
                        <?php
                            //Exibindo mensagem de erro
                            if(isset($_COOKIE["msgLista"]))
                            {echo $_COOKIE["msgLista"];}
                        ?>
                        <a href="<?php echo URL.'admins/cadastro';?>" class="btn btn-warning">Cadastrar</a>
                        <table id="lista" class="table table-striped text-center">
                            <thead>
                                <tr>
                                    <th>IDADMIN</th>
                                    <th>NOME</th>
                                    <th>MATRICULA</th>
                                    <th>EMAIL</th>
                                    <th>DATACAD</th>
                                    <th>SITUAÇÃO</th>
                                    <th>AÇÕES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach($admins as $admin)
                                {
                                    if($admin->IDADMIN == $_SESSION['sessaoLogada']->IDADMIN)
                                    {
                                        echo "<tr class='table-info'>";
                                    }
                                    else
                                    {
                                        echo "<tr>";
                                    }
                                    echo "
                                    <td>$admin->IDADMIN</td>
                                    <td>$admin->NOME</td>
                                    <td>$admin->MATRICULA</td>
                                    <td>$admin->EMAIL</td>
                                    <td>".date("d/m/Y H:i",strtotime($admin->DATACAD))."</td>
                                    <td>"; echo $admin->ESTADO == 1 ?  "<span class='badge text-bg-success'>Ativo</span>" : "<span class='badge text-bg-danger'>Inativo</span>"; echo"</td>
                                    <td>
                                    <a href='".URL."admins/altera/$admin->IDADMIN'><img src='".URL."resource/imagens/icons/caneta-de-pena.png' style='width:25px;'></a><div class='vr mx-2'></div>
                                    <a href='".URL."admins/alterarEstado/$admin->IDADMIN'><img src='".URL."resource/imagens/icons/on-off.png' style='width:25px;'></a><div class='vr mx-2'></div>
                                    <a href='".URL."admins/excluir/$admin->IDADMIN'><img src='".URL."resource/imagens/icons/trash.png' style='width:25px;'></a>
                                    </td>
                                </tr>
                                ";
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>IDADMIN</th>
                                    <th>NOME</th>
                                    <th>MATRICULA</th>
                                    <th>EMAIL</th>
                                    <th>DATACAD</th>
                                    <th>SITUAÇÃO</th>
                                    <th>AÇÕES</th>
                                </tr>
                            </tfoot>
                        </table>
                    </article>
                </section>
                <img src="<?php echo URL.'resource/ui/bg/bg_nuvem_completo.svg'?>" class="nuvem nuvem-mid p-0"
                    style="z-index: 0!important;">
            </div>
        </div>
        <?php include_once "resource/rodape.php";?>
    </div>
	<!--Imports-->  
    <?php include_once "resource/plugins.php";?>
    <?php include_once "resource/pluginsDataTables.php";?>
</body>

</html>