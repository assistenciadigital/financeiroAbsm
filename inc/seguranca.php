<?php
include("config.php");

//  Configurações do Script
// ==============================
$_SG['conectaServidor'] = true;    // Abre uma conexão com o servidor MySQL?
$_SG['abreSessao'] = true;         // Inicia a sessão com um session_start()?

$_SG['caseSensitive'] = false;     // Usar case-sensitive? Onde 'thiago' é diferente de 'THIAGO'

$_SG['validaSempre'] = true;       // Deseja validar o usuário e a senha a cada carregamento de página?
// Evita que, ao mudar os dados do usuário no banco de dado o mesmo contiue logado.

$_SG['sistema'] = 'AD - Assistência Digital';    // Nome sistema

$_SG['servidor'] = 'localhost';    // Servidor MySQL
$_SG['usuario'] = 'root';          // Usuário MySQL
$_SG['senha'] = '';                // Senha MySQL
$_SG['banco'] = 'crud';            // Banco de dados MySQL

$_SG['paginaLogin'] = BASEURL.'index.php'; // Página de login

$_SG['tabela'] = 'usuario';       // Nome da tabela onde os usuários são salvos
// ==============================

// ======================================
//   ~ Não edite a partir deste ponto ~
// ======================================

// Verifica se precisa fazer a conexão com o MySQL
if ($_SG['conectaServidor'] == true) {
  $_SG['link'] = mysql_connect($_SG['servidor'], $_SG['usuario'], $_SG['senha']) or die("MySQL: Não foi possível conectar-se ao servidor [".$_SG['servidor']."].");
  mysql_select_db($_SG['banco'], $_SG['link']) or die("MySQL: Não foi possível conectar-se ao banco de dados [".$_SG['banco']."].");
}

// Verifica se precisa iniciar a sessão
if ($_SG['abreSessao'] == true)
  session_start();

/**
* Função que valida um usuário e senha
*
* @param string $usuario - O usuário a ser validado
* @param string $senha - A senha a ser validada
*
* @return bool - Se o usuário foi validado ou não (true/false)
*/
function validaUsuario($usuario, $senha) {
  global $_SG;

  $cS = ($_SG['caseSensitive']) ? 'BINARY' : '';

  // Usa a função addslashes para escapar as aspas
  $nusuario = addslashes($usuario);
  $nsenha = addslashes($senha);

  // Monta uma consulta SQL (query) para procurar um usuário
  $sql = "SELECT * FROM `".$_SG['tabela']."` WHERE ".$cS." `usuario_login` = '".$nusuario."' AND ".$cS." `usuario_senha` = '".$nsenha."' LIMIT 1";
  $query = mysql_query($sql);
  $resultado = mysql_fetch_assoc($query);

  // Verifica se encontrou algum registro
  if (empty($resultado)) {
	 // Nenhum registro foi encontrado => o usuário é inválido
	 return false;
  }  else {
	 //Grava informacao de acesso
	 @mysql_query("UPDATE usuario SET usuario_ultimo_acesso = '".date('Y-m-d H:i:s')."' WHERE usuario_login = '".$nusuario."' and usuario_senha = '".$senha."' limit 1");	 
	 
  // Definimos dois valores na sessão com os dados do usuário
    $_SESSION['usuarioLogin'] = $resultado['usuario_login'];  // Pega o valor da coluna 'login' do registro encontrado no MySQL
	$_SESSION['usuarioNome']  = $resultado['usuario_nome'];   // Pega o valor da coluna 'nome' do registro encontrado no MySQL
	$_SESSION['usuarioNivel'] = $resultado['usuario_nivel'];  // Pega o valor da coluna 'nivel' do registro encontrado no MySQL
    $_SESSION['usuarioAtivo'] = $resultado['usuario_ativo'];  // Pega o valor da coluna 'ativo' do registro encontrado no MySQL
    $_SESSION['usuarioExcluido'] = $resultado['usuario_excluido'];  // Pega o valor da coluna 'excluido' do registro encontrado no MySQL
	$_SESSION['usuarioUltimoAcesso'] = $resultado['usuario_ultimo_acesso'];  // Pega o valor da coluna 'ultimo acesso' do registro encontrado no MySQL

      
    // Menus de acesso
      
      $_SESSION['usuarioCadastro'] = $resultado['usuario_cadastro'];
      $_SESSION['usuarioCompras'] = $resultado['usuario_compras'];
      $_SESSION['usuarioConvenio'] = $resultado['usuario_convenio'];
      $_SESSION['usuarioEstoque'] = $resultado['usuario_estoque'];
      $_SESSION['usuarioFinanceiro'] = $resultado['usuario_financeiro'];
      $_SESSION['usuarioHospital'] = $resultado['usuario_hospital'];
      $_SESSION['usuarioLaboratorio'] = $resultado['usuario_laboratorio'];
      $_SESSION['usuarioPainel'] = $resultado['usuario_painel'];
      $_SESSION['usuarioTabelas'] = $resultado['usuario_tabelas'];
      $_SESSION['usuarioAdmin'] = $resultado['usuario_admin'];
      $_SESSION['usuarioAdminPainel'] = $resultado['usuario_adminpainel'];
      
    // Fim Menus de acesso  
      
      
    // Verifica a opção se sempre validar o login
    if ($_SG['validaSempre'] == true) {
      // Definimos dois valores na sessão com os dados do login
	  $_SESSION['usuarioLogin'] = $usuario;
      $_SESSION['usuarioSenha'] = $senha;
    }

    return true;
  }
}



/**
* Função que protege uma página
*/
function protegePagina() {
  global $_SG;

  if ($_SESSION['usuarioAtivo']<>'S'){ expulsaVisitante();} // Se Ativado diferente de S,  manda pra tela de login
  if ($_SESSION['usuarioExcluido']<>'N'){ expulsaVisitante();} // Se Excluido diferente de S,  manda pra tela de login
    
  if (!isset($_SESSION['usuarioLogin']) OR !isset($_SESSION['usuarioNome'])) {
    // Não há usuário logado, manda pra página de login
    expulsaVisitante();
  } else if (!isset($_SESSION['usuarioLogin']) OR !isset($_SESSION['usuarioNome'])) {
    // Há usuário logado, verifica se precisa validar o login novamente
    if ($_SG['validaSempre'] == true) {
      // Verifica se os dados salvos na sessão batem com os dados do banco de dados
      if (!validaUsuario($_SESSION['usuarioLogin'], $_SESSION['usuarioSenha'])) {
        // Os dados não batem, manda pra tela de login
        expulsaVisitante();
      }
    }
  }
}

/**
* Função para expulsar um visitante
*/
function expulsaVisitante() {
  global $_SG;

  // Remove as variáveis da sessão (caso elas existam)
  unset($_SESSION['usuarioLogin'], $_SESSION['usuarioNome'], $_SESSION['usuarioLogin'], $_SESSION['usuarioSenha']);

  // Manda pra tela de login
  header("Location: ".$_SG['paginaLogin']);
}
?>

