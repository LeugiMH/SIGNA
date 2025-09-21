//Coloca valores dos data attributes nos inputs
$('#CadAssuntos').on('show.bs.modal', function (event) {
    
    var title = $(event.relatedTarget).data('title');
    var assunto = $(event.relatedTarget).data('content');
    var id = $(event.relatedTarget).data('selector');
    $(this).find('.modal-title').html(title);
    $(this).find('#inputIdAssunto').val(id);
    $(this).find('#inputDescricao').val(assunto);

    if (title.match(/^Cadastrar.*$/)) {
        $(this).find('#inputIdAssunto').attr('disabled', 'disabled');
        $(this).find('#inputIdAssunto').attr('hidden', 'hidden');
        $(this).find('label[for="inputIdAssunto"]').attr('hidden', 'hidden');
    }else{
        $(this).find('#inputIdAssunto').removeAttr('disabled', 'disabled');
        $(this).find('#inputIdAssunto').removeAttr('hidden', 'hidden');
        $(this).find('label[for="inputIdAssunto"]').removeAttr('hidden', 'hidden');
    }
});