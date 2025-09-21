
//Escreve manejo na tabela
function escreveManejo(data)
{
    //Criar linha
    var linha = `<tr id="manejo_${data.IDMANEJO}">`+
                    `<td>${data.DATAMANEJO}</td>`+
                    `<td>${data.TIPOMANEJO}</td>`+
                    `<td><a href="#" onClick="excluirManejo(${data.IDMANEJO})"><img src="${URI}resource/imagens/icons/trash.png" style="width:25px;" alt="Excluir Manejo"></a></td>`+
                    `<\\tr>`;
    //Popular tabela
    $('#corpoTabelaManejos').append(linha);
}

function listarManejos(idEspecime)
{
    //Limpar tabela
    $('#corpoTabelaManejos').html("<tr><td colspan='3'>Carregando...</td></tr>");

    $('#btnCadManejo').attr('data-especime', idEspecime);
    var url = `${URI}manejo/listar/`;
    var urlId = url + idEspecime;
    
    $.ajax({
        // Busca atributo
        url: urlId,
        type: 'POST',
        dataType: "JSON",
        success: function(result){
            if(result.length == 0)
            {
                $('#corpoTabelaManejos').html("<tr><td colspan='3'>Nenhum manejo cadastrado</td></tr>");
                return;
            }
            $('#corpoTabelaManejos').html("");
            $(result).each(function (index, data)
            {
                escreveManejo(data);
            });
        }
    });
}

//Modal de Manejos
$('#ModalManejo').on('show.bs.modal', function (event) {
    if($(event.relatedTarget).data('status') == "inativo")
        $('#btnCadManejo').hide();
    else
        $('#btnCadManejo').show();

    if($(event.relatedTarget).data('especime') !== undefined)
        listarManejos($(event.relatedTarget).data('especime'));
});

//Coloca valores dos data attributes nos inputs
$('#ModalCadManejo').on('show.bs.modal', function (event) {
    var id = $(event.relatedTarget).data('especime');
    $(this).find('#inputEspecime').val(id);
});

//Cadastrar manejo
$('#formCadManejo').on('submit', function (event) {
    
    event.preventDefault();

    var idEspecime = $('#inputEspecime').val();
    var dataManejo = $('#inputDataManejo').val();
    var tipoManejo = $('#inputTipoManejo').val();

    $.ajax({
        url: `${URI}manejo/cadastrar`,
        type: 'POST',
        dataType: "JSON",
        data: {
            inputEspecime: idEspecime,
            inputDataManejo: dataManejo,
            inputTipoManejo: tipoManejo
        },
        success: function(result){
            if(result)
            {
                $('#ModalCadManejo').modal('hide');
                $('#ModalManejo').modal('show');
                listarManejos(idEspecime);
                $('#formCadManejo')[0].reset();
            }
        },
        error: function(xhr, status, error) {
            console.error("Erro ao cadastrar manejo:", error);
        }
    });
});

function excluirManejo(id)
{
    if(confirm("Tem certeza que deseja excluir este manejo?"))
    {
        $.ajax({
            url: `${URI}manejo/excluir/${id}`,
            type: 'POST',
            dataType: "JSON",
            success: function(result){
                if(result)
                {
                    $('#manejo_'+id).remove();
                }
            },
            error: function(xhr, status, error) {
                console.error("Erro ao excluir manejo:", error);
            }
        });
    }
}