<?php
require_once '../../config.php';
require_once(HEADER_TEMPLATE);

if (!isset($_SESSION)) session_start();

$menu = $_SESSION['usuarioTabelas'];

if ((!$menu >= 1) AND (!$menu <= 4)){
    echo "<script language='javascript' TYPE='text/javascript'>alert ('Acesso Negado. Sem Permissao de Acesso ao Modulo!')</script>";
    echo "<script language='javascript'> window.location.href=javascript:history.back()</script>";
}

?>
<header>
	<div class="row">
		<div class="col-sm-12 h2">
			Tabela: Cidade - Inserir Registro: Novo
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
        <div class="form-group col-md-1">
  	  	  <label >ID</label>
  	  	  <input type="text" disabled class="form-control" id="id" name="id" placeholder="ID" value="<?php if (isset($_GET['id'])) echo $_GET['id']; else echo 'Registro Novo';?>">
  	    </div>
        
        <div class="form-group col-md-1">
            <label>UF</label>
            <select class="form-control" name="uf" id="uf" required autofocus>
              <option value="">Selecione</option>
              <?php
                $select_uf = mysql_query ("SELECT DISTINCT uf FROM cidade ORDER BY uf");
                if (mysql_num_rows ($select_uf)) {
                while ($row_uf = mysql_fetch_assoc($select_uf)) {
                ?>
                <option value="<?php echo $row_uf['uf']?>"<?php if($dados['uf'] == $row_uf['uf']) echo "selected"?>><?php echo $row_uf['uf']?></option>
              <?php }}?> 
            </select>
         </div>            
        
	    <div class="form-group col-md-6">
  	     <label>Descrição</label>
  	  	  <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Descricao" required>
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