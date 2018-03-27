<?php
include("../../seguranca.php");

// Conecta-se ao banco de dados MySQL
   $mysqli = new mysqli($_SG['servidor'], $_SG['usuario'], $_SG['senha'], $_SG['banco']);

// Caso algo tenha dado errado, exibe uma mensagem de erro
   if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());

// Monta outra consulta MySQL, agora a que fará a busca com paginação
   $sql = "SELECT descricao FROM cidade WHERE uf = '".$_POST['uf']."' order by descricao";

// Executa a consulta
   $query = $mysqli->query($sql) or die($msyqli->error) ;
   echo '<option value="">Cidades: '.$_POST['uf'].'</option>';
		while ($dados = $query->fetch_array()) {  
			echo '<option value="'.$dados['descricao'].'">'.$dados['descricao'].'</option>';		
		}
	
?>