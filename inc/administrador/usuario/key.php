<?php
require_once '../../config.php';
require_once(HEADER_TEMPLATE);

if (!isset($_SESSION)) session_start();

$menu = $_SESSION['usuarioAdmin'];

if (($menu <> 1)){
    echo "<script language='javascript' TYPE='text/javascript'>alert ('Acesso Negado. Sem Permissao de Acesso ao Modulo!')</script>";
    echo "<script language='javascript'> window.location.href=javascript:history.back()</script>";
}
 
//  Conecta-se ao banco de dados MySQL
    $mysqli = new mysqli($_SG['servidor'], $_SG['usuario'], $_SG['senha'], $_SG['banco']);

//  Caso algo tenha dado errado, exibe uma mensagem de erro
    if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());

    $tabela = 'usuario';

//  Coleta dados da tabela menu
    $sql = "SELECT * FROM {$tabela} where usuario_login = '".$_GET['usuario_login']."'";
    $query = $mysqli->query($sql);
    if ($query->num_rows){
        while ($dados = $query->fetch_array()) {  

?>
<header>
	<div class="row">
		<div class="col-sm-12 h2">
			<?php if ($_GET['usuario_login']){echo 'Tabela: Usuario - Editar Senha Registro: ID [ '.$_GET['usuario_login'].' ]';}?>
		</div>

	</div>
</header>
  <form data-toggle="validator" action="run.php?acao=key&usuario_login=<?php echo $_GET['usuario_login'];?>" method="post">
    <div class="row">
      <div class="col-sm-12 text-right h2">
        <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar Registro</button>
		<a class="btn btn-default" href="javascript:history.back()"><i class="fa fa-ban" aria-hidden="true"></i> Cancelar</a>
	  </div>
     </div>
      
  	<div class="row">
        <div class="form-group col-md-3">
  	  	  <label >ID / Login</label>
  	  	  <input type="text" disabled class="form-control" id="id" name="id" placeholder="ID" value="<?php if (isset($_GET['usuario_login'])) echo $_GET['usuario_login']; else echo 'Registro Novo';?>">
  	    </div>
        
	    <div class="form-group col-md-5">
  	     <label>Nome</label>
  	  	  <input type="text" disabled class="form-control" id="nome" name="nome" placeholder="Nome" value="<?php echo $dados['usuario_nome']?>" required>
  	    </div>
        
	    <div class="form-group col-md-2">
  	     <label>Data Nascimento</label>
  	  	  <input type="date" disabled class="form-control" id="nascimento" name="nascimento" placeholder="Data Nascimento" value="<?php echo $dados['usuario_nascimento']?>" required>
  	    </div>
        
	    <div class="form-group col-md-2">
          <label>Sexo</label>
            <input type="text" disabled class="form-control" id="sexo" name="sexo" placeholder="Sexo" value="<?php if ($dados['usuario_sexo']=='M') echo 'Masculino'; else 'Feminino'?>" required>
        </div>
   
     </div>
      
     <div class="row">
           
         <div class="form-group col-md-3">
            <label for="inputPassword" class="control-label">Senha</label>
            <input type="password" class="form-control" name="senha" id="senha" placeholder="Senha Mínimo 6 dígitos" data-minlength="6" required autofocus>
            <span class="help-block">Senha Mínimo de seis (6) digitos</span>	
            	
          </div>
          <div class="form-group col-md-3">
            <label for="inputConfirm" class="control-label">Confirma Senha</label>
            <input type="password" class="form-control" name="confirmasenha" id="confirmasenha" placeholder="Confirma Senha" data-match="#senha" data-match-error="Atenção! Senhas Diferentes." required>
            <span class="help-block">Confirma Mínimo de seis (6) digitos</span>
            <div class="help-block with-errors"></div>	
          </div>         
           
        <div class="form-group col-md-2">
  	     <label>Ultimo acesso em</label>
  	  	  <input type="text" disabled class="form-control" id="data" name="ulimoacesso" placeholder="Ultimo acesso em" value="<?php echo datetime_datatempo($dados['usuario_ultimo_acesso'])?>">
  	    </div>  
           
        <div class="form-group col-md-2">
  	     <label>Atualizado em</label>
  	  	  <input type="text" disabled class="form-control" id="data" name="data" placeholder="Atualizado em" value="<?php echo datetime_datatempo($dados['data'])?>">
  	    </div>  
         
        <div class="form-group col-md-2">
  	     <label>Por</label>
  	  	  <input type="text" disabled class="form-control" id="usuario_login" name="usuario_login" placeholder="Usuario" value="<?php echo $dados['usuario_logado']?>">
  	    </div>           
     </div>
      
    </form>

    <?php
        }
        }
        // Finaliza aconexao com o banco de dados
        mysqli_close($mysqli); 
    ?>