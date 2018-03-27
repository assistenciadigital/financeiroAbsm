<?php 
include("config.php"); 
include("datas.php"); 
include("funcoes.php"); 
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
  <script language=JavaScript type=text/javascript src='<?php echo BASEURL; ?>js/form.js'></script>
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
 <script src="<?php echo BASEURL; ?>js/valida_cns.js"></script><!-- onblur="return validacpf(this.value)" --> <!-- onBlur="validar(this)" -->
 <script src="<?php echo BASEURL; ?>js/valida_cns_provisorio.js"></script><!-- onblur="return validacpf(this.value)" --> <!-- onBlur="validar(this)" -->
 <script src="<?php echo BASEURL; ?>js/valida_cpf.js"></script><!-- onblur="return validacpf(this.value)" --> <!-- onBlur="validar(this)" -->
 <script src="<?php echo BASEURL; ?>js/valida_cpf_cnpj.js"></script><!-- onBlur="validar(this)" --> <!-- onBlur="validar(this)" -->
 
 <script>
	jQuery(function($){
		   $("#telefone").mask("(99)9999-9999");
		   $("#fixo").mask("(99)9999-9999");
		   $("#fax").mask("(99)9999-9999");
		   $("#celular").mask("(99)99999-9999");
		   $("#cep").mask("99.999-999");
		   $("#cpf").mask("999.999.999-99");
		   $("#cnpj").mask("99.999.999/9999-99");
	});
 </script>
 
<script language="javascript">

// Atualiza form
function atualiza(){
 document.getElementById("frm").submit();	
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
    
    <!-- INICIA MENU DROPDOWN -->
    <ul class="nav navbar-nav">
      
      <!-- MENU CADASTRO -->
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Cadastro<span class="caret"></span></a>
        <ul class="dropdown-menu">
        <!-- Coleta dados da tabela menu -->
        <?php
            $sql = "SELECT * FROM menu where menu like '%cadastro%' order by descricao";
            $query = $mysqli->query($sql);
            while ($dados = $query->fetch_array()) {  
                echo '<li><a href="'.BASEMENU.$dados['link'].'/'.$dados['arquivo'].'">'.$dados['descricao'].'</a></li>';
            }
        ?>
        </ul>
      </li>
      <!-- FIM MENU CADASTRO -->
      
      <!-- MENU COMPRAS -->    
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Compras<span class="caret"></span></a>
        <ul class="dropdown-menu">
        <!-- Coleta dados da tabela menu -->
        <?php
            $sql = "SELECT * FROM menu where menu like '%compras%' order by descricao";
            $query = $mysqli->query($sql);
            while ($dados = $query->fetch_array()) {  
                echo '<li><a href="'.BASEMENU.$dados['link'].'/'.$dados['arquivo'].'">'.$dados['descricao'].'</a></li>';
            }
        ?>
        </ul>
      </li>
      <!-- FIM MENU COMPRAS -->
     
      <!-- MENU CONVENIO -->        
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Convênio<span class="caret"></span></a>
        <ul class="dropdown-menu">
        <!-- Coleta dados da tabela menu -->
        <?php
            $sql = "SELECT * FROM menu where menu like '%convenio%' order by descricao";
            $query = $mysqli->query($sql);
            while ($dados = $query->fetch_array()) {  
                echo '<li><a href="'.BASEMENU.$dados['link'].'/'.$dados['arquivo'].'">'.$dados['descricao'].'</a></li>';
            }
        ?>
        </ul>
      </li>  
      <!-- FIM MENU CONVENIO -->    

      <!-- ESTOQUE -->        
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Estoque<span class="caret"></span></a>
        <ul class="dropdown-menu">
        <!-- Coleta dados da tabela menu -->
        <?php
            $sql = "SELECT * FROM menu where menu like '%estoque%' order by descricao";
            $query = $mysqli->query($sql);
            while ($dados = $query->fetch_array()) {  
                echo '<li><a href="'.BASEMENU.$dados['link'].'/'.$dados['arquivo'].'">'.$dados['descricao'].'</a></li>';
            }
        ?>
        </ul>
      </li>
      <!-- FIM MENU ESTOQUE -->    
        
      <!-- MENU FINANCEIRO -->        
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Financeiro<span class="caret"></span></a>
        <ul class="dropdown-menu">
        <!-- Coleta dados da tabela menu -->
        <?php
            $sql = "SELECT * FROM menu where menu like '%financeiro%' order by descricao";
            $query = $mysqli->query($sql);
            while ($dados = $query->fetch_array()) {  
                echo '<li><a href="'.BASEMENU.$dados['link'].'/'.$dados['arquivo'].'">'.$dados['descricao'].'</a></li>';
            }
        ?>
        </ul>
      </li>  
      <!-- FIM MENU FINANCEIRO -->
        
      <!-- MENU HOSPITAL -->        
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Hospital<span class="caret"></span></a>
        <ul class="dropdown-menu">
        <!-- Coleta dados da tabela menu -->
        <?php
            $sql = "SELECT * FROM menu where menu like '%hospital%' order by descricao";
            $query = $mysqli->query($sql);
            while ($dados = $query->fetch_array()) {  
                echo '<li><a href="'.BASEMENU.$dados['link'].'/'.$dados['arquivo'].'">'.$dados['descricao'].'</a></li>';
            }
        ?>
        </ul>
      </li> 
      <!-- FIM MENU HOSPITAL --> 
        
      <!-- MENU LABORATORIO -->        
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Laboratorio<span class="caret"></span></a>
        <ul class="dropdown-menu">
        <!-- Coleta dados da tabela menu -->
        <?php
            $sql = "SELECT * FROM menu where menu like '%laboratorio%' order by descricao";
            $query = $mysqli->query($sql);
            while ($dados = $query->fetch_array()) {  
                echo '<li><a href="'.BASEMENU.$dados['link'].'/'.$dados['arquivo'].'">'.$dados['descricao'].'</a></li>';
            }
        ?>
        </ul>
      </li> 
      <!-- FIM MENU LABORATORIO -->           
        
      <!-- MENU PAINEL -->        
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Painel<span class="caret"></span></a>
        <ul class="dropdown-menu">
        <!-- Coleta dados da tabela menu -->
        <?php
            $sql = "SELECT * FROM menu where menu like '%painel%' order by descricao";
            $query = $mysqli->query($sql);
            while ($dados = $query->fetch_array()) {  
                echo '<li><a href="'.BASEMENU.$dados['link'].'/'.$dados['arquivo'].'">'.$dados['descricao'].'</a></li>';
            }
        ?>
        </ul>
      </li>
      <!-- FIM MENU PAINEL -->    
        
      <!-- TABELAS DO SISTEMA -->        
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Tabelas<span class="caret"></span></a>
        <ul class="dropdown-menu">
        <!-- Coleta dados da tabela menu -->
        <?php
            $sql = "SELECT * FROM menu where menu like '%tabelas%' order by descricao";
            $query = $mysqli->query($sql);
            while ($dados = $query->fetch_array()) {  
                echo '<li><a href="'.BASEMENU.$dados['link'].'/'.$dados['arquivo'].'">'.$dados['descricao'].'</a></li>';
            }
        ?>
        </ul>
      </li>  
      <!-- FIM MENU TABELAS DO SISTEMA -->    
        
      <!-- MENU ADMINISTRADOR -->        
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Administrador<span class="caret"></span></a>
        <ul class="dropdown-menu">
        <!-- Coleta dados da tabela menu -->
        <?php
            $sql = "SELECT * FROM menu where menu like '%administrador%' order by descricao";
            $query = $mysqli->query($sql);
            while ($dados = $query->fetch_array()) {  
                echo '<li><a href="'.BASEMENU.$dados['link'].'/'.$dados['arquivo'].'">'.$dados['descricao'].'</a></li>';
            }
        ?>
        </ul>
      </li>
      <!-- FIM MENU ADMINISTRADOR -->
        
      <!-- MENU AJUDA -->        
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Ajuda<span class="caret"></span></a>
        <ul class="dropdown-menu">
        <!-- Coleta dados da tabela menu -->
        <?php
            $sql = "SELECT * FROM menu where menu like '%ajuda%' order by descricao";
            $query = $mysqli->query($sql);
            while ($dados = $query->fetch_array()) {  
                echo '<li><a href="'.BASEMENU.$dados['link'].'/'.$dados['arquivo'].'">'.$dados['descricao'].'</a></li>';
            }
            
            // Finaliza a conexao com o banco de dados
            mysqli_close($mysqli);
        ?>
        </ul>
      </li>
      <!-- FIM MENU AJUDA -->        

    </ul>
    <!-- FIM MENU DROPDOWN -->

    <!-- MENU SAIR / LOGOUT -->
    <ul class="nav navbar-nav navbar-right">
      <li><a href="<?php echo BASEMENU; ?>logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
    </ul>
    <!-- FIM MENU SAIR / LOGOUT -->  
          
  </div>
</nav>

    <main class="container">