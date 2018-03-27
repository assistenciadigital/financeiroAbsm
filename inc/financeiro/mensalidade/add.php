<?php
require_once '../../config.php';
require_once(HEADER_TEMPLATE);

if (!isset($_SESSION)) session_start();

$menu = $_SESSION['usuarioFinanceiro'];

if ((!$menu >= 1) AND (!$menu <= 4)){
    echo "<script language='javascript' TYPE='text/javascript'>alert ('Acesso Negado. Sem Permissao de Acesso ao Modulo!')</script>";
    echo "<script language='javascript'> window.location.href=javascript:history.back()</script>";
}

?>
<header>
	<div class="row">
		<div class="col-sm-12 h2">
			Tabela: Mensalidade - Inserir Registro: Novo
			<?php $titular = @mysql_fetch_assoc(mysql_query("SELECT nome, datanascimento FROM cliente WHERE cliente = '".$_GET['titular']."'"));  echo '<br/>[Titular: '.$_GET['titular'].' - '.$titular['nome'].']'?>
		</div>

	</div>
</header>
  <form data-toggle="validator" action="run.php?titular=<?php echo $_GET['titular'] ?>&acao=inclusao" method="post">
    <div class="row">
      <div class="col-sm-12 text-right h2">
	    <a class="btn btn-default" href="add_multiplo.php<?php echo '?titular='.$_GET['titular']?>"><i class="glyphicon glyphicon-plus" aria-hidden="true"></i> Adicionar Multiplos Registros</a>
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
  	  	  <input type="date" class="form-control" id="competencia" name="competencia" value="<?php echo date('Y-m-d');?>" required autofocus>
  	    </div> 	
			
	
	    <div class="form-group col-md-2">
  	     <label>Valor Mensalidade R$</label>
  	  	   <input type="text" name="valor" class="form-control" size="18" maxlength="13" onblur="javascript:formataValorDigitado(this);" onkeyup="javascript:formataValorDigitado(this);" required>
  	    </div> 	
		
	    <div class="form-group col-md-2">
  	     <label>Data Vencimento</label>
		 <input type="date" class="form-control" id="vencimento" name="vencimento" value="<?php echo date('Y-m-d', strtotime('+30 days'));?>" required>
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
                <option value="<?php echo $row['id']?>"<?php if($_GET['evento'] == $row['descricao']) echo "selected"?>><?php echo $row['descricao']?></option>
              <?php }}?> 
            </select>
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