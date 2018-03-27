<?php
require_once '../../config.php';
require_once(HEADER_TEMPLATE);

if (!isset($_SESSION)) session_start();

$menu = $_SESSION['usuarioAdmin'];

if ((!$menu >= 1) AND (!$menu <= 5)){
    echo "<script language='javascript' TYPE='text/javascript'>alert ('Acesso Negado. Sem Permissao de Acesso ao Modulo!')</script>";
    echo "<script language='javascript'> window.location.href=javascript:history.back()</script>";
}
 
//  Conecta-se ao banco de dados MySQL
    $mysqli = new mysqli($_SG['servidor'], $_SG['usuario'], $_SG['senha'], $_SG['banco']);

//  Caso algo tenha dado errado, exibe uma mensagem de erro
    if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());

//  Coleta dados da tabela menu
    $sql = "SELECT * FROM empresa where id = '".$_GET['id']."'";
    $query = $mysqli->query($sql);
    if ($query->num_rows){
        while ($dados = $query->fetch_array()) {  

?>
<header>
	<div class="row">
		<div class="col-sm-12 h2">
			<?php if ($_GET['id']){echo 'Tabela: Empresa - Visualizar Registro: ID [ '.$_GET['id'].' ]';}?>
		</div>

	</div>
</header>
  <form action="edit.php?id=<?php echo $_GET['id'];?>" method="post">
    <div class="row">
      <div class="col-sm-12 text-right h2">
        <button type="submit" class="btn btn-warning"><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i> Editar Registro</button>
		<a class="btn btn-default" href="javascript:history.back()"><i class="fa fa-ban" aria-hidden="true"></i> Cancelar</a>
	  </div>
     </div>
      
  	<div class="row">
        <div class="form-group col-md-2">
  	  	  <label >ID</label>
  	  	  <input type="text" disabled class="form-control" id="id" name="id" placeholder="ID" value="<?php if (isset($_GET['id'])) echo $_GET['id']; else echo 'Registro Novo';?>">
  	    </div>
        
	    <div class="form-group col-md-5">
  	     <label>Nome Fantasia</label>
  	  	  <input type="text" disabled class="form-control" id="fantasia" name="fantasia" placeholder="Nome Fantasia" value="<?php echo $dados['fantasia'];?>" required  autofocus>
  	    </div>
        
	    <div class="form-group col-md-5">
  	     <label>Razao Social</label>
  	  	  <input type="text" disabled class="form-control" id="razao" name="razao" placeholder="Razao Social" value="<?php echo $dados['razao'];?>" required>
  	    </div>
	</div>

  	<div class="row">        
	    <div class="form-group col-md-2">
  	     <label>CPF/CNPJ</label>
  	  	  <input type="text" disabled maxlength="18" class="form-control" id="cpf_cnpj" name="cpf_cnpj" onBlur="validar(this)" onkeypress="return (soNums(event))"  placeholder="CPF / CNPJ" value="<?php echo $dados['cpf_cnpj'];?>" required>
  	    </div>   
       
        <div class="form-group col-md-2">
  	     <label>Inscricao Estadual</label>
  	  	  <input type="text" disabled maxlength="18"  class="form-control" id="ie" name="ie" placeholder="IE" value="<?php echo $dados['ie'];?>" required>
  	    </div>         

        <div class="form-group col-md-2">
  	     <label>Inscricao Municipal</label>
  	  	  <input type="text" disabled maxlength="18"  class="form-control" id="im" name="im" placeholder="IM" value="<?php echo $dados['im'];?>" required>
  	    </div>  
		
        <div class="form-group col-md-2">
  	     <label>Principal?</label>
            <select class="form-control" disabled name="principal" id="principal" required>
              <option value="">Selecione</option>
              <option value="S"<?php  if($dados['principal'] == 'S')  echo "selected"?>>Sim</option>
              <option value="N"<?php  if($dados['principal'] == 'N')  echo "selected"?>>Não</option>
            </select>
  	    </div>  

        <div class="form-group col-md-2">
  	     <label>Telefone Fixo</label>
  	  	  <input type="text" disabled maxlength="16"  class="form-control" id="fixo" name="fixo" placeholder="Fixo" value="<?php echo $dados['fixo'];?>" required>
  	    </div>  

        <div class="form-group col-md-2">
  	     <label>Telefone Celular</label>
  	  	  <input type="text" disabled maxlength="16"  class="form-control" id="celular" name="celular" placeholder="Celular" value="<?php echo $dados['celular'];?>"  required>
  	    </div>  		
	</div>	
	
	<div class="row">   

		<div class="form-group col-md-2">
  	     <label>CEP</label>
  	  	  <input type="text" disabled maxlength="11"  class="form-control" name="cep" id="cep" placeholder="CEP" value="<?php echo $dados['cep'];?>"  required>
  	    </div>  	

		<div class="form-group col-md-1">
  	     <label>UF</label>
		    <select class="form-control" disabled name="uf" id="uf" required>
              <option value="">UF</option>
              <?php
                $select = mysql_query ("SELECT distinct uf FROM cidade ORDER BY uf");
                if (mysql_num_rows ($select)) {
                while ($row = mysql_fetch_assoc($select)) {
                ?>
                <option value="<?php echo $row['uf']?>"<?php if($dados['uf'] == $row['uf']) echo "selected"?>><?php echo $row['uf']?></option>
              <?php }}?> 
            </select>
  	    </div>  		

	    <div class="form-group col-md-2">
  	     <label>Cidade</label>
		    <select class="form-control" disabled name="cidade" id="cidade" required>
              <?php
                $select = mysql_query ("SELECT descricao FROM cidade where uf = '".$dados['uf']."' ORDER BY descricao");
                if (mysql_num_rows ($select)) {
                while ($row = mysql_fetch_assoc($select)) {
                ?>
                <option value="<?php echo $row['descricao']?>"<?php if($dados['cidade'] == $row['descricao']) echo "selected"?>><?php echo $row['descricao']?></option>
              <?php }}?> 
			</select>
  	    </div>  	

	    <div class="form-group col-md-2">
  	     <label>Bairro</label>
  	  	  	<input type="text" disabled class="form-control" id="bairro" name="bairro" placeholder="Bairro" value="<?php echo $dados['bairro'];?>" required>
  	    </div>

	    <div class="form-group col-md-5">
  	     <label>Endereco</label>
  	  	  <input type="text" disabled class="form-control" id="endereco" name="endereco" placeholder="Endereco" value="<?php echo $dados['endereco'];?>" required>
  	    </div>  		
	</div>
	
  	<div class="row">  
	    <div class="form-group col-md-3">
  	     <label>Responsavel</label>
  	  	  <input type="text" disabled class="form-control" id="responsavel" name="responsavel" placeholder="Responsavel" value="<?php echo $dados['responsavel'];?>" required>
  	    </div>

	    <div class="form-group col-md-2">
  	     <label>Funcao</label>
  	  	  <input type="text" disabled class="form-control" id="funcao" name="funcao" placeholder="Funcao" value="<?php echo $dados['funcao'];?>" required>
  	    </div> 

	    <div class="form-group col-md-2">
  	     <label>Setor</label>
  	  	  <input type="text" disabled class="form-control" id="setor" name="setor" placeholder="Setor" value="<?php echo $dados['setor'];?>" required>
  	    </div> 

	    <div class="form-group col-md-5">
  	     <label>E-mail</label>
  	  	  <input type="email" disabled class="form-control" id="email" name="email" placeholder="E-mail" value="<?php echo $dados['email'];?>" required>
  	    </div> 
		
	</div>
	
  	<div class="row">   
             
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

    <?php
        }
        }
        // Finaliza aconexao com o banco de dados
        mysqli_close($mysqli); 
    ?>