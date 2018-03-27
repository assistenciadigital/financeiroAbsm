<?php
require_once '../../config.php';
require_once(HEADER_TEMPLATE);

if (!isset($_SESSION)) session_start();

$menu = $_SESSION['usuarioAdmin'];

if ((!$menu >= 1) AND (!$menu <= 4)){
    echo "<script language='javascript' TYPE='text/javascript'>alert ('Acesso Negado. Sem Permissao de Acesso ao Modulo!')</script>";
    echo "<script language='javascript'> window.location.href=javascript:history.back()</script>";
}

?>

<script type="text/javascript" src="../../../js/autocomplete/lib/jquery.js"></script>
<script type="text/javascript" src="../../../js/autocomplete/lib/jquery.bgiframe.min.js"></script>
<script type="text/javascript" src="../../../js/autocomplete/lib/jquery.ajaxQueue.js"></script>
<script type="text/javascript" src="../../../js/autocomplete/lib/thickbox-compressed.js"></script>
<script type="text/javascript" src="../../../js/autocomplete/jquery.autocomplete.js"></script>
<!--css -->
<link rel="stylesheet" type="text/css" href="../../../js/autocomplete/jquery.autocomplete.css"/>
<link rel="stylesheet" type="text/css" href="../../../js/autocomplete/lib/thickbox.css"/>
 
 <script type="text/javascript">
 	$(document).ready(function(){
		$("#menu").autocomplete("ac.php", {
			width: 200,
			selectFirst: false
		});
	});
 </script>
 
<header>
	<div class="row">
		<div class="col-sm-12 h2">
			Tabela: Menu - Inserir Registro: Novo
		</div>

	</div>
</header>
  <form data-toggle="validator" action="run.php?acao=inclusao" method="post">
    <div class="row">
      <div class="col-sm-12 text-right h2">
        <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar Registro</button>
		<a class="btn btn-default" href="lista.php"><i class="fa fa-ban" aria-hidden="true"></i> Cancelar</a>
	  </div>
     </div>
      
  	<div class="row">
        <div class="form-group col-md-2">
  	  	  <label >ID</label>
  	  	  <input type="text" disabled class="form-control" id="id" name="id" placeholder="ID" value="<?php if (isset($_GET['id'])) echo $_GET['id']; else echo 'Registro Novo';?>">
  	    </div>
        
	    <div class="form-group col-md-3">
  	     <label>Menu</label>
  	  	  <input type="text" class="form-control" id="menu" name="menu" placeholder="Menu" required autofocus>
  	    </div>
        
	    <div class="form-group col-md-3">
  	     <label>Sub-Menu</label>
  	  	  <input type="text" class="form-control" id="submenu" name="submenu" placeholder="Sub-Menu" required>
  	    </div>
        
	    <div class="form-group col-md-4">
  	     <label>Descrição</label>
  	  	  <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Descricao" required>
  	    </div>   
       
     </div>
      
     <div class="row">
     
	    <div class="form-group col-md-2">
  	     <label>Arquivo</label>
  	  	  <input type="text" class="form-control" id="arquivo" name="arquivo" placeholder="Exemplo: lista.php" value="<?php echo "lista.php"?>"required>
  	    </div>         

        <div class="form-group col-md-4">
  	     <label>Link</label>
  	  	  <input type="text" class="form-control" id="link" name="link" placeholder="Exemplo: administrador/menu" required>
  	    </div>          
         
        <div class="form-group col-md-2">
  	     <label>Atualizado em</label>
  	  	  <input type="text" disabled class="form-control" id="data" name="data" placeholder="<?php echo date('d/m/Y H:i');?>" value="<?php echo datetime_datatempo($dados['data'])?>">
  	    </div>  
         
        <div class="form-group col-md-2">
  	     <label>Por</label>
  	  	  <input type="text" disabled class="form-control" id="usuario_login" name="usuario_login" placeholder="Usuario" value="<?php echo $_SESSION['usuarioLogin'];?>">
  	    </div>           
     </div>
      
    </form>