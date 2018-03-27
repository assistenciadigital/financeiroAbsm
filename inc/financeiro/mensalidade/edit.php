<?php
require_once '../../config.php';
require_once(HEADER_TEMPLATE);

if (!isset($_SESSION)) session_start();

$menu = $_SESSION['usuarioFinanceiro'];

if ((!$menu >= 1) AND (!$menu <= 3)){
    echo "<script language='javascript' TYPE='text/javascript'>alert ('Acesso Negado. Sem Permissao de Acesso ao Modulo!')</script>";
    echo "<script language='javascript'> window.location.href=javascript:history.back()</script>";
}

//  Conecta-se ao banco de dados MySQL
    $mysqli = new mysqli($_SG['servidor'], $_SG['usuario'], $_SG['senha'], $_SG['banco']);

//  Caso algo tenha dado errado, exibe uma mensagem de erro
    if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());

    $tabela = 'financeiro_mensalidade';

//  Coleta dados da tabela
    $sql = "SELECT * FROM {$tabela} where id = '".$_GET['id']."'";
    $query = $mysqli->query($sql);
    if ($query->num_rows){
        while ($dados = $query->fetch_array()) {  

?>
<header>
	<div class="row">
		<div class="col-sm-12 h4">
			<?php if ($_GET['id']){echo 'Tabela: Mensalidade - Editar Registro: ID [ '.$_GET['id'].' ]';}?>
			<?php $titular = @mysql_fetch_assoc(mysql_query("SELECT nome, datanascimento FROM cliente WHERE cliente = '".$_GET['titular']."'"));  echo '<br/>[Titular: '.$_GET['titular'].' - '.$titular['nome'].']'?>
		</div>
	</div>
</header>
  <form data-toggle="validator" action="run.php?acao=edicao&id=<?php echo $_GET['id'].'&titular='.$_GET['titular'];?>" method="post">
    <div class="row">
      <div class="col-sm-12 text-right h6">
        <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar Registro</button>
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
  	  	  <input type="text" disabled class="form-control" id="titular" name="titular" placeholder="Titular" value="<?php echo $_GET['titular'];?>" required>
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
  	  	  <input type="date" class="form-control" id="competencia" name="competencia" value="<?php echo $dados['competencia']?>" placeholder="Competencia" required autofocus>
  	    </div> 	
			
	
	    <div class="form-group col-md-2">
  	     <label>Valor Mensalidade R$</label>
  	  	   <input requ type="text" name="valor" id="valor" class="form-control" size="18" maxlength="13" value="<?php echo number_format($dados['valor'], 2, ',', '.')?>" onblur="javascript:formataValorDigitado(this);" onkeyup="javascript:formataValorDigitado(this);">
  	    </div> 	
		
	    <div class="form-group col-md-2">
  	     <label>Data Vencimento</label>
  	  	  <input type="date" class="form-control" id="vencimento" name="vencimento" value="<?php echo $dados['vencimento']?>" placeholder="Vencimento" required>
  	    </div> 	
		
		<div class="form-group col-md-2">
		<label>Evento</label>
		    <select class="form-control" name="evento" required>
              <option value="">Evento</option>
              <?php
                $select = mysql_query ("SELECT id, descricao FROM financeiro_evento ORDER BY descricao");
                if (mysql_num_rows ($select)) {
                while ($row = mysql_fetch_assoc($select)) {
                ?>
                <option value="<?php echo $row['id']?>"<?php if($dados['evento'] == $row['id']) echo "selected"?>><?php echo $row['descricao']?></option>
              <?php }}?> 
            </select>
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
	<header>
	<div class="row">
		<div class="col-sm-1 h4">
		Recebimentos:
		</div>
	</div>
	</header>
	<form data-toggle="validator" action="run.php?acao=edicao&id=<?php echo $_GET['id'].'&titular='.$_GET['titular'];?>" method="post">
   
	<table class="table table-hover table-layout: fixed table-condensed h6">
	<thead>
	<tr vertical-align: middle;>
		<th width="5%">ID</th>
		<th width="10%" class="text-right">R$ Recebido</th>
		<th width="10%" class="text-center">Recebimento</th>
		<th width="50%">Evento</th>
		<th width="10%">Em / por</th>
		<th width="15%" class="text-right">Opções:</th>
	</tr>
	</thead>
    <?php
	// Monta outra consulta MySQL, agora a que fará a busca com paginação
    $sql = ("select r.id as id, r.mensalidade as mensalidade, r.valor as valor, r.recebimento as recebimento, r.usuario_login as usuario_login, r.data as data, e.descricao as evento from financeiro_recebimento as r left join financeiro_evento as e on r.evento = e.id where r.mensalidade = '".$_GET['id']."'");
        
	// Executa a consulta
    $query = $mysqli->query($sql) or die($msyqli->error) ;
    while ($dados = $query->fetch_array()) {  
	$somarecebido = $somarecebido + $dados['valor'];
    ?>
	<tbody>
	<tr>
		<td><?php echo $dados['id']; ?></td>
		<td class="text-right"><?php echo number_format($dados['valor'], 2, ',', '.'); ?></td>
		<td class="text-center"><?php echo date_data($dados['recebimento']); ?></td>
		<td><?php echo $dados['evento']; ?></td>
		<td><?php echo datetime_datatempo($dados['data']).'<br/>'.$dados['usuario_login']; ?></td>
		<td class="actions text-right">
			<a href="<?php if (($menu >= 1) AND ($menu <= 3)) echo '../recebimento/edit.php?id='.$dados['id'].'&mensalidade='.$dados['mensalidade'].'?titular='.$_GET['titular']; ?>" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-pencil"></i></a>
			<a href="<?php if (($menu >= 1) AND ($menu <= 2)) echo 'run.php?acao=exclusao&id='.$dados['mensalidade'].'&titular='.$dados['titular']; ?>" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
		</td>
	</tr>
	<?php } ?>
	</tbody>
	</table> 
	<div class="row alert alert-success" role="alert"><?php echo 'Total Recebido R$ '.number_format($somarecebido, 2, ',', '.');?></div>
    </form>

    <?php
        }
        }
        // Finaliza aconexao com o banco de dados
        mysqli_close($mysqli); 
    ?>