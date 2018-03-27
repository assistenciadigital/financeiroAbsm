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
<script language=javascript>

$(function () {
					
			var currentTime = new Date()
			var month = currentTime.getMonth() + 1;
			var day = currentTime.getDate();
			var year = currentTime.getFullYear();
			
			var date = month + "/" + day + "/" + year;
			
			$('[name=anocompetencia]').val(year);

})

function MarcaDesmarca(){
	for (var i = 0; i < document.form.elements.length; i++) {
		 var x = document.form.elements[i];
		 if (x.name == 'mescompetencia[]') { 
		 	 x.checked = document.form.marcadesmarca.checked;
		 } 
	} 
}

function Calcular() {
	var input = document.getElementsByName("mescompetencia[]");
    var valor = (document.getElementById("valor").value); 
	var total = 0;
	
    for (var i = 0; i < input.length; i++) {
		 if (input[i].checked) {
             total += parseFloat(1);//parseFloat(input[i].value);
         }
     }
	 
	 document.getElementById("total").value = parseFloat(valor * total); 
}

function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}
function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}

function mvalor(v){
    v=v.replace(/\D/g,"");//Remove tudo o que não é dígito
    v=v.replace(/(\d)(\d{8})$/,"$1$2");//coloca o ponto dos milhões
    v=v.replace(/(\d)(\d{5})$/,"$1$2");//coloca o ponto dos milhares
        
    v=v.replace(/(\d)(\d{2})$/,"$1.$2");//coloca a virgula antes dos 2 últimos dígitos
    return v;
}

</script>
<header>
	<div class="row">
		<div class="col-sm-12 h2">
			Tabela: Mensalidade - Inserir Registro: Novo
			1<?php $titular = @mysql_fetch_assoc(mysql_query("SELECT nome, datanascimento FROM cliente WHERE cliente = '".$_GET['titular']."'"));  echo '<br/>[Titular: '.$_GET['titular'].' - '.$titular['nome'].']'?>
		</div>

	</div>
</header>
  <form name="form" data-toggle="validator" action="run_multiplo.php?titular=<?php echo $_GET['titular'] ?>&acao=inclusao" method="post">
    <div class="row">
      <div class="col-sm-12 text-right h2">
        <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar Registro</button>
		<a class="btn btn-default" href="lista.php<?php echo '?titular='.$_GET['titular']?>"><i class="fa fa-ban" aria-hidden="true"></i> Voltar</a>
	  </div>
     </div>
      
  	<div  class="form-group row">
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
		
    <div  class="form-group row">  
	
	    <div class="form-group col-md-2">
  	     <label>Valor Mensalidade R$</label>
  	  	   <input type="text" name="valor" id="valor" class="form-control" size="18" maxlength="14" onblur="mascara( this, mvalor ); Calcular()" onkeyup="mascara( this, mvalor ); Calcular()" required autofocus>
  	    </div> 

	    <div class="form-group col-md-2">
  	     <label>Valor Total R$</label>
  	  	   <input type="text" readonly name="total" id="total" class="form-control" size="18" maxlength="14" required autofocus>
  	    </div> 	

	    <div class="form-group col-md-1">
  	     <label>Competencia</label>
  	  	  <input type="text" class="form-control" name="anocompetencia" maxlength="4" required autofocus>
  	    </div> 	
		
		<div class="form-group col-md-1">
  	     <label>Dia</label>
  	  	  <input type="text" class="form-control" name="diacompetencia" maxlength="2" value="1" required autofocus>
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
	<div class="form-group row">
	    <div class="form-group  col-md-8">
  	     <label style="cursor: pointer">Competencia: &nbsp;Clique para Selecionar Todos os Meses.<br/>&nbsp;Dia da competencia todo (01) primeiro  do mes<br/>
		 &nbsp;<input type="checkbox" data-toggle="toggle" name="marcadesmarca" onClick="MarcaDesmarca(); Calcular()">
 	     </label>
  	    </div>  
		
	</div>
	<div  class="form-group row"> 	
	    <div class="form-group col-md-1"><label><input type=checkbox name="mescompetencia[]" value="1" onclick="Calcular()">&nbsp;JAN</label></div>
		<div class="form-group col-md-1"><label><input type=checkbox name="mescompetencia[]" value="2" onclick="Calcular()">&nbsp;FEV</label></div> 	
		<div class="form-group col-md-1"><label><input type=checkbox name="mescompetencia[]" value="3" onclick="Calcular()">&nbsp;MAR</label></div> 	
		<div class="form-group col-md-1"><label><input type=checkbox name="mescompetencia[]" value="4" onclick="Calcular()">&nbsp;ABR</label></div> 	
		<div class="form-group col-md-1"><label><input type=checkbox name="mescompetencia[]" value="5" onclick="Calcular()">&nbsp;MAI</label></div> 	
		<div class="form-group col-md-1"><label><input type=checkbox name="mescompetencia[]" value="6" onclick="Calcular()">&nbsp;JUN</label></div> 	
		<div class="form-group col-md-1"><label><input type=checkbox name="mescompetencia[]" value="7" onclick="Calcular()">&nbsp;JUL</label></div> 		
		<div class="form-group col-md-1"><label><input type=checkbox name="mescompetencia[]" value="8" onclick="Calcular()">&nbsp;AGO</label></div> 	
		<div class="form-group col-md-1"><label><input type=checkbox name="mescompetencia[]" value="9" onclick="Calcular()">&nbsp;SET</label></div> 	
		<div class="form-group col-md-1"><label><input type=checkbox name="mescompetencia[]" value="10" onclick="Calcular()">&nbsp;OUT</label></div> 	
		<div class="form-group col-md-1"><label><input type=checkbox name="mescompetencia[]" value="11" onclick="Calcular()">&nbsp;NOV</label></div> 	
		<div class="form-group col-md-1"><label><input type=checkbox name="mescompetencia[]" value="12" onclick="Calcular()">&nbsp;DEZ</label></div> 	
	</div>
     
    </form>