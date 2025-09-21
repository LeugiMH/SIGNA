//Mostra estrelas
function executeRating(avaliacao) {
    const starClassActive = "rating__star star-a star me-2";
    const starClassInactive = "rating__star star-i star me-2";
    const stars = [...document.getElementsByClassName("rating__star")];
    const starsLength = stars.length;
    let i=0;

    stars.map((star) => {
        document.getElementById("rating").value = stars.indexOf(star)+1;
        for (i; i <= avaliacao-1; ++i) stars[i].className = starClassActive;
    });
}

//Modal de Feedbacks
$('#RespFeedback').on('show.bs.modal', function (event) {
    var id = $(event.relatedTarget).data('selector');
    var avaliacao = $(event.relatedTarget).data('content');
    $(this).find('#inputIdFeedback').val(id);
    var url = `${URI}buscaFeedback/`;
    var urlId = url + id;

    executeRating(avaliacao);
    $.ajax({
        // Busca atributo
        url: urlId,
        type: 'POST',
        dataType: "JSON",
        success: function(result){
            $(result).each(function (index, data)
            {
                escreveFeedback(data);
            });
        }
    });
});

function escreveFeedback(data){
    var email = data.EMAIL;
    var assunto = data.DESCRICAO;
    var texto = data.TEXTO;
    var coment = data.COMENT_ADMIN;

    if(data.IDESPECIME != null)
    {
        $('#EspecimeFeedback').parent().parent().show();
        $('#EspecimeFeedback').html(data.IDESPECIME);
        $('#EspecimeFeedback').parent().prop("href",`${URI}especimes/altera/${data.IDESPECIME}`);
    }
    else
    {
        $('#EspecimeFeedback').parent().parent().hide();
    }
    $('#inputEmail').val(email);
    $('#inputAssunto').val(assunto);
    $('#inputMessage').val(texto);
    $('#inputResposta').val(coment);
}