<?php $feedback = new FeedbackController(); ?>
<footer class="rodape text-white mt-auto">
    <div class="bg-verde text-center justify-content-center row m-0 p-3">
        <a href="#feedback" role="button" class="text-white text-decoration-none" data-bs-toggle="modal" data-bs-target="#feedback">
            Enviar um Feedback
        </a>
    </div>
    <div class="align-content-center bg-dark text-center justify-content-center m-0 p-3">
        <div class="d-flex d-flex-row text-center justify-content-center">
            <a href="https://www.facebook.com/fatecfrancodarocha/?locale=pt_BR" target="_blank" class="me-3">
                <img src="<?php echo URL.'resource/imagens/icons/facebook.png'?>" alt="Facebook icon" width="64px">
            </a>
            <a href="https://www.instagram.com/fatecfrancodarocha/" target="_blank" class="me-3">
                <img src="<?php echo URL.'resource/imagens/icons/instagram.png'?>" alt="Instragram logo" width="64px">
            </a>
            <a href="https://www.linkedin.com/in/fatec-franco-da-rocha-152720231/?originalSubdomain=br" target="_blank" class="me-3" >
                <img src="<?php echo URL.'resource/imagens/icons/linkedin.png'?>" alt="Linkedin logo" width="64px">
            </a>
            <a href="https://github.com/LeugiMH/SIGNA" target="_blank" class="me-3">
                <img src="<?php echo URL.'resource/imagens/icons/github.png'?>" alt="Github logo" width="64px">
            </a>
        </div>
        <p class="mt-3"> Siga a Fatec Franco da Rocha nas redes sociais! </p>
    </div>
</footer>

<!-- Modal -->
<div class="modal fade text-white" id="feedback" tabindex="-1" aria-labelledby="FeedBack PopUp page" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content bg-verde">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="exampleModalLabel">Enviar Feedback</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="<?php echo URL."envFeedback"?>" method="POST">
					<?php
					//Exibindo mensagem de erro
					if(isset($_COOKIE["msgF"]))
					{
					echo $_COOKIE['msgF'];
					}
					?>
					<div class="mb-3">
						<label for="inputEmail" class="form-label">Endereço de Email</label>
						<input type="email" value="" class="form-control" id="inputEmail" name="inputEmail"
							aria-label="Digite o email (opcional)" placeholder="Digite o email (opcional)"
							maxlength="256">
						<div class="form-text">Ao digitar email você terá o retorno do feedback.</div>
					</div>
					<div class="mb-3">
						<label for="rating" class="form-label">Satisfação</label>
						<div class="rating" aria-label="Insira qual a sua avaliação em estrelas (máximo 5)">
							<img class="rating__star star-i star me-2" tabindex="1" aria-label="1 estrela"></img>
							<img class="rating__star star-i star me-2" tabindex="1" aria-label="2 estrelas"></img>
							<img class="rating__star star-i star me-2" tabindex="1" aria-label="3 estrelas"></img>
							<img class="rating__star star-i star me-2" tabindex="1" aria-label="4 estrelas"></img>
							<img class="rating__star star-i star me-2" tabindex="1" aria-label="5 estrelas"></img>
						</div>
						<input type="hidden" value="0" class="form-control" id="rating" name="rating" required>
					</div>
					<div class="mb-3">
						<label for="inputEmail" class="form-label">Assunto</label>
						<select name="inputAssunto" id="inputAssunto" class="form-select"
							aria-label="Selecione um assunto para enviar o feedback" required>
							<option disabled selected value="">Selecione um Assunto</option>
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
						<input type="hidden" value="<?php echo isset($_GET['url']) ? $_GET['url'] : '' ?>" class="form-control" id="url" name="url">
						<textarea class="form-control" name="inputMessage" id="inputMessage" rows="5" aria-label="Insira sua mensagem de feedback" maxlength="256" required></textarea>
					</div>
					<button type="submit" class="btn btn-success">Enviar Feedback</button>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
const ratingStars = [...document.getElementsByClassName("rating__star")];

function executeRating(stars) {
    const starClassActive = "rating__star star-a star me-2";
    const starClassInactive = "rating__star star-i star me-2";
    const starsLength = stars.length;
    let i;
    stars.map((star) => {
        star.onclick = () => {
            document.getElementById("rating").value = stars.indexOf(star) + 1;
            i = stars.indexOf(star);

            if (star.className === starClassInactive) {
                for (i; i >= 0; --i) stars[i].className = starClassActive;
            } else {
                for (i; i < starsLength; ++i) stars[i].className = starClassInactive;
            }
        };
    });
}

executeRating(ratingStars);
</script>