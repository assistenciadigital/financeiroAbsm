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
		$("#bairro").autocomplete("ac_bairro.php", {
			width: 200,
			selectFirst: false
		});
	});

	$(document).ready(function(){
        // Evento change no campo uf  
         $("select[name=uf]").change(function(){
            // Exibimos no campo cidade antes de concluirmos
			$("select[name=cidade]").html('<option value="">Carregando Cidade</option>');
            $.post("filtra_cidade.php",
                  {uf:$(this).val()},
                  // Carregamos o resultado acima para o campo cidade
				  function(valor){
                     $("select[name=cidade]").html(valor);
                  }
                  )
         })	
	})
</script>
 
<header>
	<div class="row">
		<div class="col-sm-12 h2">
			Tabela: Empresa - Inserir Registro: Novo
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
        
	    <div class="form-group col-md-5">
  	     <label>Nome Fantasia</label>
  	  	  <input type="text" class="form-control" id="fantasia" name="fantasia" placeholder="Nome Fantasia" required  autofocus>
  	    </div>
        
	    <div class="form-group col-md-5">
  	     <label>Razao Social</label>
  	  	  <input type="text" class="form-control" id="razao" name="razao" placeholder="Razao Social" required>
  	    </div>
	</div>

  	<div class="row">        
	    <div class="form-group col-md-3">
  	     <label>CPF/CNPJ</label>
  	  	  <input type="text" maxlength="18" class="form-control" id="cpf_cnpj" name="cpf_cnpj" onBlur="validar(this)" onkeypress="return (soNums(event))"  placeholder="CPF / CNPJ" required>
  	    </div>   
       
        <div class="form-group col-md-2">
  	     <label>Inscricao Estadual</label>
  	  	  <input type="text" maxlength="18"  class="form-control" id="ie" name="ie" placeholder="IE" required>
  	    </div>         

        <div class="form-group col-md-2">
  	     <label>Inscricao Municipal</label>
  	  	  <input type="text" maxlength="18"  class="form-control" id="im" name="im" placeholder="IM" required>
  	    </div>  
		
        <div class="form-group col-md-1">
  	     <label>Principal?</label>
            <select class="form-control" name="principal" id="principal" required>
              <option value="">Selecione</option>
              <option value="S">Sim</option>
              <option value="N">Não</option>
            </select>
  	    </div>  

        <div class="form-group col-md-2">
  	     <label>Telefone Fixo</label>
  	  	  <input type="text" maxlength="16"  class="form-control" id="fixo" name="fixo" placeholder="Fixo" required>
  	    </div>  

        <div class="form-group col-md-2">
  	     <label>Telefone Celular</label>
  	  	  <input type="text" maxlength="16"  class="form-control" id="celular" name="celular" placeholder="Celular" required>
  	    </div>  		
	</div>	
	
	<div class="row">   

		<div class="form-group col-md-2">
  	     <label>CEP</label>
  	  	  <input type="text" maxlength="11"  class="form-control" name="cep" id="cep" placeholder="CEP" required>
  	    </div>  	

		<div class="form-group col-md-1">
  	     <label>UF</label>
		    <select class="form-control" name="uf" id="uf" required>
              <option value="">UF</option>
              <?php
                $select = mysql_query ("SELECT distinct uf FROM cidade ORDER BY uf");
                if (mysql_num_rows ($select)) {
                while ($row = mysql_fetch_assoc($select)) {
                ?>
                <option value="<?php echo $row['uf']?>"<?php if($_GET['uf'] == $row['uf']) echo "selected"?>><?php echo $row['uf']?></option>
              <?php }}?> 
            </select>
  	    </div>  		

	    <div class="form-group col-md-2">
  	     <label>Cidade</label>
		    <select class="form-control" name="cidade" id="cidade" required></select>
  	    </div>  	

	    <div class="form-group col-md-2">
  	     <label>Bairro</label>
  	  	  	<input type="text" class="form-control" id="bairro" name="bairro" placeholder="Bairro" required>
  	    </div>

	    <div class="form-group col-md-5">
  	     <label>Endereco</label>
  	  	  <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Endereco" required>
  	    </div>  		
	</div>
	
  	<div class="row">  
	    <div class="form-group col-md-3">
  	     <label>Responsavel</label>
  	  	  <input type="text" class="form-control" id="responsavel" name="responsavel" placeholder="Responsavel" required>
  	    </div>

	    <div class="form-group col-md-2">
  	     <label>Funcao</label>
  	  	  <input type="text" class="form-control" id="funcao" name="funcao" placeholder="Funcao" required>
  	    </div> 

	    <div class="form-group col-md-2">
  	     <label>Setor</label>
  	  	  <input type="text" class="form-control" id="setor" name="setor" placeholder="Setor" required>
  	    </div> 

	    <div class="form-group col-md-5">
  	     <label>E-mail</label>
  	  	  <input type="email" class="form-control" id="email" name="email" placeholder="E-mail" required>
  	    </div> 
		
	</div>
	
  	<div class="row">          
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