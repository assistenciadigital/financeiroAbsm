<?php 
include("config.php"); 
include("datas.php"); 
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
include("contadorVisitas.php");

//  Conecta-se ao banco de dados MySQL
    $mysqli = new mysqli($_SG['servidor'], $_SG['usuario'], $_SG['senha'], $_SG['banco']);

//  Caso algo tenha dado errado, exibe uma mensagem de erro
    if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo TITLE; ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php echo BASEURL; ?>maxcdn/bootstrap.min.css">
  <script src="<?php echo BASEURL; ?>maxcdn/jquery.min.js"></script>
  <script src="<?php echo BASEURL; ?>maxcdn/bootstrap.min.js"></script>
  <style>
        body {
            padding-top: 50px;
            padding-bottom: 50px;
  }
  </style>
  <link rel="stylesheet" href="<?php echo BASEURL; ?>css/style.css">
    
  <!-- CSS font-awesome
  ================================================== -->
  <link rel="stylesheet" href="<?php echo BASEURL; ?>font-awesome/css/font-awesome.min.css">  
    
</head>
    
 <script src="<?php echo BASEURL; ?>js/jquery.js"></script>
 <script src="<?php echo BASEURL; ?>js/jquery.maskedinput.min.js"></script>
 <script src="<?php echo BASEURL; ?>js/bootstrap.min.js"></script>
 <script src="<?php echo BASEURL; ?>js/validator.min.js"></script>
 <script>
	jQuery(function($){
		   $("#telefone").mask("(65)99999-9999");
		   $("#celular").mask("(65)99999-9999");
	});
 </script>
    
<script language="javascript">

// Exclui Registro
function exclui(exclui_id){
	if(confirm ('Confirma a exclusão do registro: ' + exclui_id + '?')) {
		location = 'run.php?acao=exclusao&id=' + exclui_id;
	}
}

// Atualiza form
function atualiza(){
 document.getElementById("frm").submit();	
}
</script>
    
<script>
	function move() {
	  var elem = document.getElementById("myBar");   
	  var width = 10;
	  var id = setInterval(frame, 10);
	  function frame() {
		if (width >= 100) {
		  clearInterval(id);
		} else {
		  width++; 
		  elem.style.width = width + '%'; 
		  document.getElementById("label").innerHTML = width * 1  + '%';
		}
	  }
	}
</script>      
    
<body>
<nav class="navbar navbar-inverse navbar-fixed-top col-xs-12 col-sm-12 col-md-12 col-lg-12" role="navigation" >
  <div class="container-fluid">
           
    <!-- MENU INICIO / HOME -->
    <div class="navbar-header">
      <a class="navbar-brand" href="<?php echo BASEMENU; ?>menu.php"><span class="glyphicon glyphicon-home"></span> Início</a>
    </div>
    <!-- FIM MENU INICIO / HOME -->
    
    <!-- MENU SAIR / LOGOUT -->
    <ul class="nav navbar-nav navbar-right">
      <li><a href="<?php echo BASEMENU; ?>logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
    </ul>
    <!-- FIM MENU SAIR / LOGOUT -->  
          
  </div>
</nav>

    <main class="container">