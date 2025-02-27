<?php
protected class Ambiente
  {
    //Parâmetros
    public $server = "https://signa.eco.br";
    protected $database = "signae21_SIGNA";
    //Método get
    function __get($atributo)
    {
        return $this->$atributo;
    }

    protected class Producao
    {
        //Parâmetros
        protected $user = "signae21_prod";
        protected $password = "Qw@h(2p6Hofp(an8lA&C";
    }
  }
?>
