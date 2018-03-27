<?php
include("../../seguranca.php");

$q=strtolower ($_GET["q"]);

// Conecta-se ao banco de dados MySQL
   $mysqli = new mysqli($_SG['servidor'], $_SG['usuario'], $_SG['senha'], $_SG['banco']);

// Caso algo tenha dado errado, exibe uma mensagem de erro
   if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());
	
// Monta outra consulta MySQL, agora a que farс a busca com paginaчуo
   $sql = "SELECT distinct uf FROM cidade WHERE uf like '%".$q."%'";
        
// Executa a consulta
   $query = $mysqli->query($sql) or die($msyqli->error) ;
	
   while ($dados = $query->fetch_array()) {  	
		echo $dados["uf"]."|".$dados["uf"]."\n";
   }
?>