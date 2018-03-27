<?php
include("config.php");
include("log.php");

// Inclui o arquivo com o sistema de segurança
require_once("seguranca.php");

// Verifica se um formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Salva duas variáveis com o que foi digitado no formulário
  // Detalhe: faz uma verificação com isset() pra saber se o campo foi preenchido
  $usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
  $senha = (isset($_POST['senha'])) ? md5($_POST['senha']) : '';

  // Utiliza uma função criada no seguranca.php pra validar os dados digitados
  if (validaUsuario($usuario, $senha) == true) {
		// Salva LOG no Banco de Dados
		$mensagem= "Log In";
		salvaLog($mensagem, $usuario);
		// Fim Salva LOG
		
		// Visitantes Online
		include("visitante_online.php");
					
    // O usuário e a senha digitados foram validados, manda pra página interna
    header("Location: menu.php");
  } else {
    // O usuário e/ou a senha são inválidos, manda de volta pro form de login
    // Para alterar o endereço da página de login, verifique o arquivo seguranca.php
    expulsaVisitante();
  }
}
?>