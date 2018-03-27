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

    $tabela = 'financeiro_recebimento';

//  Coleta dados da tabela
    $sql = "SELECT * FROM {$tabela} where id = '".$_GET['id']."'";
    $query = $mysqli->query($sql);
    if ($query->num_rows){
        while ($dados = $query->fetch_array()) {  

?>
<header>
	<div class="row">
		<div class="col-sm-12 h4">
			<?php if ($_GET['id']){echo 'Tabela: Recebimento - Editar Registro: ID [ '.$_GET['id'].' ]';}?>
			<?php 	$mensalidade = @mysql_fetch_assoc(mysql_query("SELECT * FROM financeiro_mensalidade WHERE id = '".$_GET['mensalidade']."'"));
					$titular = @mysql_fetch_assoc(mysql_query("SELECT cliente, nome, datanascimento FROM cliente WHERE cliente = '".$mensalidade['titular']."'"));
					echo '<br/>[Titular: '.$titular['cliente'].' - '.$titular['nome'].']';
					echo '<br/>[Mensalidade: '.$_GET['id'].' - Competencia: '.date_data($mensalidade['competencia']).' - R$ '.number_format($mensalidade['valor'], 2, ',', '.').' - Vencimento: '.date_data($mensalidade['vencimento']).']';
			?>
		</div>

	</div>
</header>
  <form data-toggle="validator" action="run.php?<?php echo 'id='.$_GET['id'].'&titular='.$_GET['titular'];?>&acao=recebimento" method="post">
    <div class="row">
      <div class="col-sm-12 text-right h2">
        <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar Registro</button>
		<a class="btn btn-default" href="../mensalidade/edit.php?<?php echo 'id='.$_GET['id'].'&titular='.$titular['cliente']?>"><i class="fa fa-ban" aria-hidden="true"></i> Voltar</a>
	  </div>
     </div>
      
	<div class="row alert alert-success" role="alert">
		<div class="form-group col-md-2">
		  <label >ID Mensalidade</label>
		  <input type="text" readonly="true" class="form-control" id="id" name="id" placeholder="ID" value="<?php if (isset($_GET['id'])) echo $_GET['id']; else echo 'Registro Novo';?>">
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
		
	    <div class="form-group col-md-2">
  	     <label>Data Competencia</label>
  	  	  <input type="date" disabled class="form-control" id="competencia" name="competencia" value="<?php echo $mensalidade['competencia']?>" placeholder="Competencia" required>
  	    </div> 	
			
	
	    <div class="form-group col-md-2">
  	     <label>Valor Mensalidade R$</label>
  	  	   <input disabled type="text" name="valor" id="valor" class="form-control" size="18" maxlength="13" value="<?php echo number_format($mensalidade['valor'], 2, ',', '.')?>" onblur="javascript:formataValorDigitado(this);" onkeyup="javascript:formataValorDigitado(this);">
  	    </div> 	
		
	    <div class="form-group col-md-2">
  	     <label>Data Vencimento</label>
  	  	  <input disabled type="date" class="form-control" id="vencimento" name="vencimento" value="<?php echo $mensalidade['vencimento']?>" placeholder="Vencimento" required>
  	    </div> 	
       
       <div class="form-group col-md-2">
  	     <label>Atualizado em</label>
  	  	  <input type="text" disabled class="form-control" id="datamensalidade" name="datamensalidade" placeholder="Atualizado em" value="<?php echo datetime_datatempo($mensalidade['data'])?>">
  	    </div>  
         
        <div class="form-group col-md-2">
  	     <label>Por</label>
  	  	  <input type="text" disabled class="form-control" id="usuario_loginmensalidade" name="usuario_loginmensalidade" placeholder="Usuario" value="<?php echo $mensalidade['usuario_login']?>">
  	    </div>           
     </div>	
		
    <div class="row">  
	
	    <div class="form-group col-md-2">
  	     <label>Valor Recebimento R$</label>
  	  	   <input type="text" name="valor" class="form-control" size="18" maxlength="13" onblur="javascript:formataValorDigitado(this);" onkeyup="javascript:formataValorDigitado(this);" value="<?php echo number_format($dados['valor'], 2, ',', '.')?>" required autofocus>
  	    </div> 	
		
	    <div class="form-group col-md-2">
  	     <label>Data Recebimento</label>
		 <input type="date" class="form-control" id="recebimento" name="recebimento" value="<?php echo $dados['recebimento'];?>" required>
  	    </div> 	
		
		<div class="form-group col-md-4">
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
  	  	  <input type="text" disabled class="form-control" id="data" name="data" placeholder="<?php echo date('d/m/Y H:i');?>" value="<?php echo datetime_datatempo($dados['data'])?>">
  	    </div>  
         
        <div class="form-group col-md-2">
  	     <label>Por</label>
  	  	  <input type="text" disabled class="form-control" id="usuario_login" name="usuario_login" placeholder="Usuario" value="<?php echo $dados['usuario_login'];?>">
  	    </div>          
       
     </div>

      
    </form>
	    <?php
        }
        }
        // Finaliza aconexao com o banco de dados
        mysqli_close($mysqli); 
    ?>