<div class="text-white mt-auto fixed-bottom">
    <div class="align-content-center bg-verde text-center justify-content-center m-0 p-4">
        <h3 class="d-flex d-flex-row text-center justify-content-center">
            Termo de Política de Privacidade​​
        </h3>
        <p class="mt-3"> 
            Ao acessar e utilizar este sistema, você concorda com os termos e condições estabelecidos nesta Política de Privacidade.<br/>
            Coletamos informações pessoais, como nome, e-mail e dados de uso, para melhorar sua experiência no sistema.<br/>
            Utilizamos cookies para personalizar o conteúdo e analisar o tráfego do site.
        </p>
        <button id="btnTermos" class="btn btn-success">Concordo com os termos</button>
    </div>
</div>
<script>
    document.getElementById("btnTermos").addEventListener("click", function(){
        console.log("Termos aceitos.");
        // Definir cookie por 30 dias
        document.cookie = "aceitouTermosDeUso=true; max-age=" + 30*24*60*60 + "; path=/";

        this.parentElement.style.display = "none";
    });
</script>