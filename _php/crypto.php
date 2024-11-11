<?php
class Crypto{

    private $senha;
    private $metodo;

    function __construct(){
        $this->senha = '';
        $this->metodo = 'camellia-192-cfb8';
    }
    function cript($mensagem) {
        $criptografado = openssl_encrypt($mensagem, $this->metodo, $this->senha, false, $iv = '74502364jf0f34b1');
        return $criptografado;
    }

    function decript($mensagem, $senha_de) {
        $criptografado = openssl_decrypt($mensagem, $this->metodo, $senha_de, false, $iv = '74502364jf0f34b1');
        return $criptografado;
    }
}
?>
