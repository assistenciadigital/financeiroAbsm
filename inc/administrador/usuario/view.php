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

    $tabela = 'usuario';

//  Coleta dados da tabela menu
    $sql = "SELECT * FROM {$tabela} where usuario_login = '".$_GET['usuario_login']."'";
    $query = $mysqli->query($sql);
    if ($query->num_rows){
        while ($dados = $query->fetch_array()) {  

?>
<header>
	<div class="row">
		<div class="col-sm-12 h2">
			<?php if ($_GET['usuario_login']){echo 'Tabela: Usuario - Visualizar Registro: ID [ '.$_GET['usuario_login'].' ]';}?>
		</div>

	</div>
</header>
  <form action="edit.php?usuario_login=<?php echo $_GET['usuario_login'];?>" method="post">
    <div class="row">
      <div class="col-sm-12 text-right h2">
        <button type="submit" class="btn btn-warning"><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i> Editar Registro</button>
		<a class="btn btn-default" href="javascript:history.back()"><i class="fa fa-ban" aria-hidden="true"></i> Cancelar</a>
	  </div>
     </div>
      
  	<div class="row">
        <div class="form-group col-md-3">
  	  	  <label >ID / Login</label>
  	  	  <input type="text" disabled class="form-control" id="id" name="id" placeholder="ID" value="<?php if (isset($_GET['usuario_login'])) echo $_GET['usuario_login']; else echo 'Registro Novo';?>">
  	    </div>
        
	    <div class="form-group col-md-5">
  	     <label>Nome</label>
  	  	  <input type="text" disabled class="form-control" id="menu" name="nome" placeholder="Nome" value="<?php echo $dados['usuario_nome']?>" required autofocus>
  	    </div>
        
	    <div class="form-group col-md-2">
  	     <label>Data Nascimento</label>
  	  	  <input type="text" disabled class="form-control" id="nascimento" name="nascimento" placeholder="Nascimento" value="<?php echo date_data($dados['usuario_nascimento'])?>" required>
  	    </div>
        
	    <div class="form-group col-md-2">
  	     <label>Sexo</label>
  	  	  <input type="text" disabled class="form-control" id="sexo" name="sexo" placeholder="Sexo" value="<?php if ($dados['usuario_sexo']=='M') echo 'Masculino'; else echo 'Feminino';?>" required>
  	    </div>   
       
     </div>
      
     <div class="row">
     
	    <div class="form-group col-md-4">
  	     <label>E-Mail</label>
  	  	  <input type="email" disabled class="form-control" id="email" name="email" placeholder="E-mail" value="<?php echo $dados['usuario_email']?>" required>
  	    </div>         

        <div class="form-group col-md-2">
  	     <label>Telefone</label>
  	  	  <input type="tel" disabled class="form-control" id="telefone" name="telefone" placeholder="Telefone" value="<?php echo $dados['usuario_telefone']?>" required>
  	    </div>          

        <div class="form-group col-md-2">
  	     <label>Celular</label>
  	  	  <input type="tel" disabled class="form-control" id="celular" name="celular" placeholder="Celular" value="<?php echo $dados['usuario_celular']?>" required>
  	    </div>   
         
        <div class="form-group col-md-2">
            <label>Ativo</label>
  	  	  <input type="text" disabled class="form-control" id="ativo" name="ativo" placeholder="Ativo" value="<?php if ($dados['usuario_ativo']=='S') echo 'Sim'; else echo 'Nao';?>" required>
         </div>  
         
        <div class="form-group col-md-2">
            <label>Excluido</label>
  	  	  <input type="text" disabled class="form-control" id="excluir" name="excluir" placeholder="Excluido" value="<?php if ($dados['usuario_excluido']=='S') echo 'Sim'; else echo 'Nao';?>" required>
         </div> 
      </div>

      <div class="row">
        
          <div class="form-group col-md-2">
            <label>Admin</label>
  	  	  <input type="text" disabled class="form-control" id="admin" name="admin" placeholder="Admin" value="<?php if ($dados['usuario_admin']==1) echo '1-All'; if ($dados['usuario_admin']==2) echo '2-View, PDF, Add, Edit, Del'; if ($dados['usuario_admin']==3) echo '3-View, PDF, Add, Edit'; if ($dados['usuario_admin']==4) echo '4-View, PDF, Add'; if ($dados['usuario_admin']==5) echo '5-View, PDF'; if ($dados['usuario_admin']==6) echo '6-View';?>" required>
         </div>           

          <div class="form-group col-md-2">
            <label>Admin Painel</label>
  	  	  <input type="text" disabled class="form-control" id="adminpainel" name="adminpainel" placeholder="Admin Painel" value="<?php if ($dados['usuario_adminpainel']==1) echo '1-All'; if ($dados['usuario_adminpainel']==2) echo '2-View, PDF, Add, Edit, Del'; if ($dados['usuario_adminpainel']==3) echo '3-View, PDF, Add, Edit'; if ($dados['usuario_adminpainel']==4) echo '4-View, PDF, Add'; if ($dados['usuario_adminpainel']==5) echo '5-View, PDF'; if ($dados['usuario_adminpainel']==6) echo '6-View';?>" required>
         </div>    

          <div class="form-group col-md-2">
            <label>Cadastro</label>
  	  	  <input type="text" disabled class="form-control" id="cadastro" name="cadastro" placeholder="Cadastro" value="<?php if ($dados['usuario_cadastro']==1) echo '1-All'; if ($dados['usuario_cadastro']==2) echo '2-View, PDF, Add, Edit, Del'; if ($dados['usuario_cadastro']==3) echo '3-View, PDF, Add, Edit'; if ($dados['usuario_cadastro']==4) echo '4-View, PDF, Add'; if ($dados['usuario_cadastro']==5) echo '5-View, PDF'; if ($dados['usuario_cadastro']==6) echo '6-View';?>" required>
         </div>    
          
          <div class="form-group col-md-2">
            <label>Compras</label>
  	  	  <input type="text" disabled class="form-control" id="compras" name="compras" placeholder="Compras" value="<?php if ($dados['usuario_compras']==1) echo '1-All'; if ($dados['usuario_compras']==2) echo '2-View, PDF, Add, Edit, Del'; if ($dados['usuario_compras']==3) echo '3-View, PDF, Add, Edit'; if ($dados['usuario_compras']==4) echo '4-View, PDF, Add'; if ($dados['usuario_compras']==5) echo '5-View, PDF'; if ($dados['usuario_compras']==6) echo '6-View';?>" required>
         </div>    
          
          <div class="form-group col-md-2">
            <label>Convenio</label>
  	  	  <input type="text" disabled class="form-control" id="convenio" name="convenio" placeholder="Convenio" value="<?php if ($dados['usuario_convenio']==1) echo '1-All'; if ($dados['usuario_convenio']==2) echo '2-View, PDF, Add, Edit, Del'; if ($dados['usuario_convenio']==3) echo '3-View, PDF, Add, Edit'; if ($dados['usuario_convenio']==4) echo '4-View, PDF, Add'; if ($dados['usuario_convenio']==5) echo '5-View, PDF'; if ($dados['usuario_convenio']==6) echo '6-View';?>" required>
         </div>              

          <div class="form-group col-md-2">
            <label>Estoque</label>
  	  	  <input type="text" disabled class="form-control" id="estoque" name="estoque" placeholder="Estoque" value="<?php if ($dados['usuario_estoque']==1) echo '1-All'; if ($dados['usuario_estoque']==2) echo '2-View, PDF, Add, Edit, Del'; if ($dados['usuario_estoque']==3) echo '3-View, PDF, Add, Edit'; if ($dados['usuario_estoque']==4) echo '4-View, PDF, Add'; if ($dados['usuario_estoque']==5) echo '5-View, PDF'; if ($dados['usuario_estoque']==6) echo '6-View';?>" required>
         </div>      
          
       </div>
      
      <div class="row">          

          <div class="form-group col-md-2">
              <label>Financeiro</label>
  	  	  <input type="text" disabled class="form-control" id="financeiro" name="financeiro" placeholder="Financeiro" value="<?php if ($dados['usuario_financeiro']==1) echo '1-All'; if ($dados['usuario_financeiro']==2) echo '2-View, PDF, Add, Edit, Del'; if ($dados['usuario_financeiro']==3) echo '3-View, PDF, Add, Edit'; if ($dados['usuario_financeiro']==4) echo '4-View, PDF, Add'; if ($dados['usuario_financeiro']==5) echo '5-View, PDF'; if ($dados['usuario_financeiro']==6) echo '6-View';?>" required>
         </div>    

          <div class="form-group col-md-2">
            <label>Hospital</label>
  	  	  <input type="text" disabled class="form-control" id="hospital" name="hospital" placeholder="Hospital" value="<?php if ($dados['usuario_hospital']==1) echo '1-All'; if ($dados['usuario_hospital']==2) echo '2-View, PDF, Add, Edit, Del'; if ($dados['usuario_hospital']==3) echo '3-View, PDF, Add, Edit'; if ($dados['usuario_hospital']==4) echo '4-View, PDF, Add'; if ($dados['usuario_hospital']==5) echo '5-View, PDF'; if ($dados['usuario_hospital']==6) echo '6-View';?>" required>
         </div>   
          
          <div class="form-group col-md-2">
            <label>Laboratorio</label>
  	  	  <input type="text" disabled class="form-control" id="laboratorio" name="laboratorio" placeholder="Laboratorio" value="<?php if ($dados['usuario_laboratorio']==1) echo '1-All'; if ($dados['usuario_laboratorio']==2) echo '2-View, PDF, Add, Edit, Del'; if ($dados['usuario_laboratorio']==3) echo '3-View, PDF, Add, Edit'; if ($dados['usuario_laboratorio']==4) echo '4-View, PDF, Add'; if ($dados['usuario_laboratorio']==5) echo '5-View, PDF'; if ($dados['usuario_laboratorio']==6) echo '6-View';?>" required>
         </div>              
          
          <div class="form-group col-md-2">
            <label>Painel</label>
  	  	  <input type="text" disabled class="form-control" id="painel" name="painel" placeholder="Painel" value="<?php if ($dados['usuario_painel']==1) echo '1-All'; if ($dados['usuario_painel']==2) echo '2-View, PDF, Add, Edit, Del'; if ($dados['usuario_painel']==3) echo '3-View, PDF, Add, Edit'; if ($dados['usuario_painel']==4) echo '4-View, PDF, Add'; if ($dados['usuario_painel']==5) echo '5-View, PDF'; if ($dados['usuario_painel']==6) echo '6-View';?>" required>
         </div>    
          
          <div class="form-group col-md-2">
            <label>Tabelas</label>
  	  	  <input type="text" disabled class="form-control" id="tabelas" name="tabelas" placeholder="Tabelas" value="<?php if ($dados['usuario_tabelas']==1) echo '1-All'; if ($dados['usuario_tabelas']==2) echo '2-View, PDF, Add, Edit, Del'; if ($dados['usuario_tabelas']==3) echo '3-View, PDF, Add, Edit'; if ($dados['usuario_tabelas']==4) echo '4-View, PDF, Add'; if ($dados['usuario_tabelas']==5) echo '5-View, PDF'; if ($dados['usuario_tabelas']==6) echo '6-View';?>" required>
         </div>   
          
        <div class="form-group col-md-2">
            <label>Mensagem</label>
  	  	  <input type="text" disabled class="form-control" id="mensagem" name="mensagem" placeholder="Mensagem" value="<?php if ($dados['usuario_msg']=='S') echo 'Sim'; else echo 'Nao';?>" required>
         </div>
                   

       </div>
      
         
       <div class="row">
           
        
        <div class="form-group col-md-2">
            <label>Nivel</label>
  	  	  <input type="text" disabled class="form-control" id="nivel" name="nivel" placeholder="Nivel" value="<?php if ($dados['usuario_nivel']==1) echo '1-All'; if ($dados['usuario_nivel']==2) echo '2-View, PDF, Add, Edit, Del'; if ($dados['usuario_nivel']==3) echo '3-View, PDF, Add, Edit'; if ($dados['usuario_nivel']==4) echo '4-View, PDF, Add'; if ($dados['usuario_nivel']==5) echo '5-View, PDF'; if ($dados['usuario_nivel']==6) echo '6-View';?>" required>
         </div>
            
        <div class="form-group col-md-2">
  	     <label>Ultimo acesso em</label>
  	  	  <input type="text" disabled class="form-control" id="data" name="ulimoacesso" placeholder="Ultimo acesso em" value="<?php echo datetime_datatempo($dados['usuario_ultimo_acesso'])?>">
  	    </div>  
           
        <div class="form-group col-md-2">
  	     <label>Atualizado em</label>
  	  	  <input type="text" disabled class="form-control" id="data" name="data" placeholder="Atualizado em" value="<?php echo datetime_datatempo($dados['data'])?>">
  	    </div>  
         
        <div class="form-group col-md-2">
  	     <label>Por</label>
  	  	  <input type="text" disabled class="form-control" id="usuario_login" name="usuario_login" placeholder="Usuario" value="<?php echo $dados['usuario_logado']?>">
  	    </div>        
     </div>
      
    </form>

    <?php
        }
        }
        // Finaliza aconexao com o banco de dados
        mysqli_close($mysqli); 
    ?>