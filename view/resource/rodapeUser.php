<?php $feedback = new FeedbackController(); ?>
<footer class="rodape text-white mt-auto">
    <div class="bg-verde text-center justify-content-center row m-0 p-3">
        <a type="button" data-bs-toggle="modal" data-bs-target="#feedback">
            Enviar um Feedback
        </a>
    </div>
    <div class="align-content-center bg-dark text-center justify-content-center m-0 p-3">
        <div class="d-flex d-flex-row text-center justify-content-center">
            <a href="https://www.facebook.com/fatecfrancodarocha/?locale=pt_BR" class="me-3">
                <img src="<?php echo URL.'resource/imagens/icons/facebook.png'?>" alt="Facebook icon">
            </a>
            <a href="https://www.instagram.com/fatecfrancodarocha/" class="me-3">
                <img src="<?php echo URL.'resource/imagens/icons/instagram.png'?>" alt="Instragram logo">
            </a>
            <a href="https://www.linkedin.com/in/fatec-franco-da-rocha-152720231/?originalSubdomain=br" class="me-3">
              <img src="<?php echo URL.'resource/imagens/icons/linkedin.png'?>" alt="Linkedin logo">
            </a>
        </div>
        

        <p class="mt-3"> Siga a Fatec Franco da Rocha nas redes sociais! </p>
    </div>

    

<!-- Modal -->
<div class="modal fade" id="feedback" tabindex="-1" aria-labelledby="FeedBack PopUp page" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-verde">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Enviar Feedback</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="POST">
            <?php
                //Exibindo mensagem de erro
                if(isset($_COOKIE["msg"]))
                {echo $_COOKIE['msg'];}
            ?>
            <div class="mb-3">
                <label for="inputEmail" class="form-label">Endereço de Email</label>
                <input type="email" value="" class="form-control" id="inputEmail" name="inputEmail" aria-label="Digite o email (opcional)" placeholder="Digite o email (opcional)" maxlength="256">
            </div>
            <div class="mb-3">
                <label for="rating" class="form-label">Avaliação</label>
                <div class="rating" aria-label="Insira qual a sua avaliação em estrelas (máximo 5)" >
                    <img class="rating__star star-i star me-2" aria-label="1 estrela" ></img>
                    <img class="rating__star star-i star me-2" aria-label="2 estrelas"></img>
                    <img class="rating__star star-i star me-2" aria-label="3 estrelas"></img>
                    <img class="rating__star star-i star me-2" aria-label="4 estrelas"></img>
                    <img class="rating__star star-i star me-2" aria-label="5 estrelas"></img>
              </div>
              <input type="hidden" value="" class="form-control" id="rating" name="rating">
            </div>
            <div class="mb-3">
              <label for="inputEmail" class="form-label">Assunto</label>
              <select name="inputAssunto" id="inputAssunto" class="form-select" aria-label="Selecione um assunto para enviar o feedback" required>
                <option disabled selected>Selecione um Assunto</option> 
                <?php
                  foreach ($assuntos as $assunto)
                  {
                    echo"<option value='$assunto->IDASSUNTO'>$assunto->DESCRICAO</option>";
                  }
                ?>
              </select>
            </div>
            <div class="mb-3">
                <label for="inputMessage" class="form-label">Mensagem</label>
                <textarea class="form-control" name="inputMessage" id="inputMessage" rows="5" aria-label="Insira sua mensagem de feedback"></textarea>
            </div>
            <input type="hidden" value="<?php "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}" ?>" class="form-control" id="url" name="url">
            <button type="submit" class="btn btn-success" name="envFeedback">Enviar Feedback</button>
            
        </form>
      </div>
      <div class="modal-footer d-flex justify-content-center">
            
      </div>
    </div>
  </div>
</div>
</footer>

<script>
  const ratingStars = [...document.getElementsByClassName("rating__star")];

  function executeRating(stars) {
    const starClassActive = "rating__star star-a star me-2";
    const starClassInactive = "rating__star star-i star me-2";
    const starsLength = stars.length;
    let i;
    stars.map((star) => {
      star.onclick = () => {
        document.getElementById("rating").value = stars.indexOf(star)+1;
        i = stars.indexOf(star);

        if (star.className===starClassInactive) {
          for (i; i >= 0; --i) stars[i].className = starClassActive;
        } else {
          for (i; i < starsLength; ++i) stars[i].className = starClassInactive;
        }
      };
    });
  }

  executeRating(ratingStars);
</script>