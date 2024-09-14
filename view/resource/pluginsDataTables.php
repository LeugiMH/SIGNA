
<!--Importando Bibliotecas-->
<script src="<?php echo URL.'resource/js/jquery-3.7.1.js';?>"></script>
<script src="<?php echo URL.'resource/js/dataTables.js';?>"></script>
<script src="<?php echo URL.'resource/js/dataTables.bootstrap5.js';?>"></script>
<script src="<?php echo URL.'resource/js/dataTables.responsive.js';?>"></script>
<script src="<?php echo URL.'resource/js/responsive.bootstrap5.js';?>"></script>

<!--Configuração de setup-->
<script>
    $(document).ready(function() {
        $('#lista').DataTable({
            responsive: true,
            language: {
                url: "<?php echo URL.'resource/json/pt_br.json';?>"
            }
        });
    });
</script>