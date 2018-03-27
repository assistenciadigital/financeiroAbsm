<?php
require_once '../../config.php';
require_once(HEADER_TEMPLATE);

if (!isset($_SESSION)) session_start();

$menu = $_SESSION['usuarioTabelas'];

if ((!$menu >= 1) AND (!$menu <= 5)){
    echo "<script language='javascript' TYPE='text/javascript'>alert ('Acesso Negado. Sem Permissao de Acesso ao Modulo!')</script>";
    echo "<script language='javascript'> window.location.href=javascript:history.back()</script>";
}

//  Conecta-se ao banco de dados MySQL
    $mysqli = new mysqli($_SG['servidor'], $_SG['usuario'], $_SG['senha'], $_SG['banco']);

//  Caso algo tenha dado errado, exibe uma mensagem de erro
    if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());

    $tabela = 'cidade';

//  Coleta dados da tabela menu
    $sql = "SELECT * FROM {$tabela} where id = '".$_GET['id']."'";
    $query = $mysqli->query($sql);
    if ($query->num_rows){
        while ($dados = $query->fetch_array()) {  

?>
<header>
	<div class="row">
		<div class="col-sm-12 h2">
			<?php if ($_GET['id']){echo 'Tabela: Cidade - Visualizar Registro: ID [ '.$_GET['id'].' ]';}?>
		</div>

	</div>
</header>
  <form action="edit.php?id=<?php echo $_GET['id'];?>" method="post">
    <div class="row">
      <div class="col-sm-12 text-right h2">
        <button type="submit" class="btn btn-warning"><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i> Editar Registro</button>
		<a class="btn btn-default" href="javascript:history.back()"><i class="fa fa-ban" aria-hidden="true"></i> Cancelar</a>
	  </div>
     </div>
      
  	<div class="row">
        <div class="form-group col-md-1">
  	  	  <label >ID</label>
  	  	  <input type="text" disabled class="form-control" id="id" name="id" placeholder="ID" value="<?php if (isset($_GET['id'])) echo $_GET['id']; else echo 'Registro Novo';?>">
  	    </div>
        
	    <div class="form-group col-md-1">
  	     <label>UF</label>
  	  	  <input type="text" disabled class="form-control" id="uf" name="uf" placeholder="UF" value="<?php echo $dados['uf']?>" required>
  	    </div>           
        
	    <div class="form-group col-md-6">
  	     <label>Descrição</label>
  	  	  <input type="text" disabled class="form-control" id="descricao" name="descricao" placeholder="Descricao" value="<?php echo $dados['descricao']?>" required>
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