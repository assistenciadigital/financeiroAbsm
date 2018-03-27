<?php
require_once '../../config.php';
require_once(HEADER_TEMPLATE);

if (!isset($_SESSION)) session_start();

$menu = $_SESSION['usuarioFinanceiro'];

if ((!$menu >= 1) AND (!$menu <= 5)){
    echo "<script language='javascript' TYPE='text/javascript'>alert ('Acesso Negado. Sem Permissao de Acesso ao Modulo!')</script>";
    echo "<script language='javascript'> window.location.href=javascript:history.back()</script>";
}
 
//  Conecta-se ao banco de dados MySQL
    $mysqli = new mysqli($_SG['servidor'], $_SG['usuario'], $_SG['senha'], $_SG['banco']);

//  Caso algo tenha dado errado, exibe uma mensagem de erro
    if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());

    $tabela = 'financeiro_mensalidade';

//  Coleta dados da tabela menu
    $sql = "SELECT * FROM {$tabela} where id = '".$_GET['id']."'";
    $query = $mysqli->query($sql);
    if ($query->num_rows){
        while ($dados = $query->fetch_array()) {  

?>
<header>
	<div class="row">
		<div class="col-sm-12 h2">
			<?php if ($_GET['id']){echo 'Tabela: Mensalidade - Visualizar Registro: ID [ '.$_GET['id'].' ]';}?>
			<?php $titular = @mysql_fetch_assoc(mysql_query("SELECT nome, datanascimento FROM cliente WHERE cliente = '".$_GET['titular']."'"));  echo '<br/>[Titular: '.$_GET['titular'].' - '.$titular['nome'].']'?>
		</div>

	</div>
</header>
  <form action="edit.php?id=<?php echo $_GET['id'].'&titular='.$_GET['titular'];?>" method="post">
    <div class="row">
      <div class="col-sm-12 text-right h2">
        <button type="submit" class="btn btn-warning"><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i> Editar Registro</button>
		<a class="btn btn-default" href="lista.php<?php echo '?titular='.$_GET['titular']?>"><i class="fa fa-ban" aria-hidden="true"></i> Voltar</a>
	  </div>
     </div>
      
<div class="row">
        <div class="form-group col-md-2">
  	  	  <label >ID</label>
  	  	  <input type="text" disabled class="form-control" id="id" name="id" placeholder="ID" value="<?php if (isset($_GET['id'])) echo $_GET['id']; else echo 'Registro Novo';?>">
  	    </div>
        
	    <div class="form-group col-md-2">
  	     <label>Titular</label>
  	  	  <input type="text" readonly="true" class="form-control" id="titular" name="titular" placeholder="Titular" value="<?php echo $_GET['titular'];?>" required>
  	    </div>   
		
	    <div class="form-group col-md-6">
  	     <label>Nome Titular</label>
  	  	  <input type="text" disabled class="form-control" id="nome" name="nome" placeholder="Nome" value="<?php echo $titular['nome'];?>" required>
  	    </div> 

	    <div class="form-group col-md-2">
  	     <label>Nascimento</label>
  	  	  <input type="date" disabled class="form-control" id="nascimento" name="nascimento" placeholder="Nascimento" value="<?php echo $titular['datanascimento'];?>" required>
  	    </div> 			
	</div>
      
  	<div class="row">
	    <div class="form-group col-md-2">
  	     <label>Data Competencia</label>
  	  	  <input type="date" disabled class="form-control" id="competencia" name="competencia" value="<?php echo $dados['competencia']?>" placeholder="Competencia" required autofocus>
  	    </div> 	
			
	
	    <div class="form-group col-md-2">
  	     <label>Valor Mensalidade R$</label>
  	  	   <input disabled type="text" name="valor" id="valor" class="form-control" size="18" maxlength="13" value="<?php echo number_format($dados['valor'], 2, ',', '.')?>" onblur="javascript:formataValorDigitado(this);" onkeyup="javascript:formataValorDigitado(this);">
  	    </div> 	
		
	    <div class="form-group col-md-2">
  	     <label>Data Vencimento</label>
  	  	  <input disabled type="date" class="form-control" id="vencimento" name="vencimento" value="<?php echo $dados['vencimento']?>" placeholder="Vencimento" required>
  	    </div> 	
       
       <div class="form-group col-md-2">
  	     <label>Atualizado em</label>
  	  	  <input type="text" disabled class="form-control" id="data" name="data" placeholder="Atualizado em" value="<?php echo datetime_datatempo($dados['data'])?>">
  	    </div>  
         
        <div class="form-group col-md-2">
  	     <label>Por</label>
  	  	  <input type="text" disabled class="form-control" id="usuario_login" name="usuario_login" placeholder="Usuario" value="<?php echo $dados['usuario_login']?>">
  	    </div>           
     </div>
      
    </form>

    <?php
        }
        }
        // Finaliza aconexao com o banco de dados
        mysqli_close($mysqli); 
    ?>