<?php 
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página

//  Conecta-se ao banco de dados MySQL
    $mysqli = new mysqli($_SG['servidor'], $_SG['usuario'], $_SG['senha'], $_SG['banco']);

//  Caso algo tenha dado errado, exibe uma mensagem de erro
    if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());

// Monta outra consulta MySQL, agora a que fará a busca com paginação
   $sql = ("select 	r.id as id_recebimento, r.mensalidade as id_recebimento, r.valor as valor_recebimento, r.recebimento as recebimento, r.evento as evento, r.usuario_login as usuario_recebimento, r.data as data_recebimento, m.id as id_mensalidade, m.titular as titular, m.competencia as competencia, m.valor as valor_mensalidade, m.vencimento as vencimento, m.usuario_login as usuario_mensalidade, m.data as data_mensalidade from financeiro_mensalidade as m inner join financeiro_recebimento as r on r.mensalidade = m.id ORDER BY r.id");
        
// Executa a consulta
   $query = $mysqli->query($sql) or die($msyqli->error) ;
   while ($dados = $query->fetch_array()) { 
	
	echo $dados['id_recebimento'].' - '.$dados['id_mensalidade'].' - '.$dados['recebimento'].'<br/>';
   
   
   }
?>