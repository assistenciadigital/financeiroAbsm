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
<header>
	<div class="row">
		<div class="col-sm-12 h2">
			Tabela: Menu - Inserir Registro: Novo
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
        <div class="form-group col-md-3">
  	  	  <label >Login Usuario</label>
  	  	  <input type="text" class="form-control" id="usuario_login" name="usuario_login" placeholder="Login  Usuario" required autofocus>
  	    </div>
        
	    <div class="form-group col-md-5">
  	     <label>Nome</label>
  	  	  <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" required>
  	    </div>
        
	    <div class="form-group col-md-2">
  	     <label>Data Nascimento</label>
  	  	  <input type="date" class="form-control" id="nascimento" name="nascimento" placeholder="Data Nascimento" required>
  	    </div>
        
	    <div class="form-group col-md-2">
            <label>Sexo</label>
            <select class="form-control" name="sexo" id="sexo" required>
                  <option value="">Selecione</option>
                  <option value="F"<?php if($dados['usuario_sexo'] == 'F')  echo "selected"?>>Feminino</option>
                  <option value="M"<?php if($dados['usuario_sexo'] == 'M')  echo "selected"?>>Masculino</option>
            </select>
        </div>
   
     </div>
      
     <div class="row">
     
	    <div class="form-group col-md-4">
  	     <label>E-mail</label>
  	  	  <input type="email" class="form-control" id="email" name="email" placeholder="email" required>
  	    </div>         

        <div class="form-group col-md-2">
  	     <label>Telefone</label>
  	  	  <input type="tel" class="form-control" id="telefone" name="telefone" placeholder="Telefone" required>
  	    </div>    
         
        <div class="form-group col-md-2">
  	     <label>Celular</label>
  	  	  <input type="tel" class="form-control" id="celular" name="celular" placeholder="Celular" required>
  	    </div>  
     
        <div class="form-group col-md-2">
            <label>Ativo</label>
            <select class="form-control" name="ativo" id="ativo" required>
              <option value="">Selecione</option>
              <option value="S"<?php  if($dados['usuario_ativo'] == 'S')  echo "selected"?>>Sim</option>
              <option value="N"<?php  if($dados['usuario_ativo'] == 'N')  echo "selected"?>>Não</option>
            </select>
         </div>  
         
        <div class="form-group col-md-2">
            <label>Excluido</label>
            <select class="form-control" name="excluido" id="excluido" required>
              <option value="">Selecione</option>
              <option value="S"<?php  if($dados['usuario_excluido'] == 'S')  echo "selected"?>>Sim</option>
              <option value="N"<?php  if($dados['usuario_excluido'] == 'N')  echo "selected"?>>Não</option>
            </select>
         </div> 
      </div>

      <div class="row">
        
          <div class="form-group col-md-2">
            <label>Admin</label>
            <select class="form-control" name="admin" id="admin" required>
              <option value="">Selecione</option>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="6" <?php if ($dados['usuario_admin'] == 6) echo "selected" ?>>6-View</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="5" <?php if ($dados['usuario_admin'] == 5) echo "selected" ?>>5-View, PDF</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="4" <?php if ($dados['usuario_admin'] == 4) echo "selected" ?>>4-View, PDF, Add</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="3" <?php if ($dados['usuario_admin'] == 3) echo "selected" ?>>3-View, PDF, Add, Edit</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="2" <?php if ($dados['usuario_admin'] == 2) echo "selected" ?>>2-View, PDF, Add, Edit, Del</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="1" <?php if ($dados['usuario_admin'] == 1) echo "selected" ?>>1-All</option>
              <?php } ?>   
            </select>
         </div>           

          <div class="form-group col-md-2">
            <label>Admin Painel</label>
            <select class="form-control" name="adminpainel" id="adminpainel" required>
              <option value="">Selecione</option>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="6" <?php if ($dados['usuario_adminpainel'] == 6) echo "selected" ?>>6-View</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="5" <?php if ($dados['usuario_adminpainel'] == 5) echo "selected" ?>>5-View, PDF</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="4" <?php if ($dados['usuario_adminpainel'] == 4) echo "selected" ?>>4-View, PDF, Add</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="3" <?php if ($dados['usuario_adminpainel'] == 3) echo "selected" ?>>3-View, PDF, Add, Edit</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="2" <?php if ($dados['usuario_adminpainel'] == 2) echo "selected" ?>>2-View, PDF, Add, Edit, Del</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="1" <?php if ($dados['usuario_adminpainel'] == 1) echo "selected" ?>>1-All</option>
              <?php } ?>   
            </select>
         </div>    

          <div class="form-group col-md-2">
            <label>Cadastro</label>
            <select class="form-control" name="cadastro" id="cadastro" required>
              <option value="">Selecione</option>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="6" <?php if ($dados['usuario_cadastro'] == 6) echo "selected" ?>>6-View</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="5" <?php if ($dados['usuario_cadastro'] == 5) echo "selected" ?>>5-View, PDF</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="4" <?php if ($dados['usuario_cadastro'] == 4) echo "selected" ?>>4-View, PDF, Add</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="3" <?php if ($dados['usuario_cadastro'] == 3) echo "selected" ?>>3-View, PDF, Add, Edit</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="2" <?php if ($dados['usuario_cadastro'] == 2) echo "selected" ?>>2-View, PDF, Add, Edit, Del</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="1" <?php if ($dados['usuario_cadastro'] == 1) echo "selected" ?>>1-All</option>
              <?php } ?>   
            </select>
         </div>    
          
          <div class="form-group col-md-2">
            <label>Compras</label>
            <select class="form-control" name="compras" id="compras" required>
              <option value="">Selecione</option>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="6" <?php if ($dados['usuario_compras'] == 6) echo "selected" ?>>6-View</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="5" <?php if ($dados['usuario_compras'] == 5) echo "selected" ?>>5-View, PDF</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="4" <?php if ($dados['usuario_compras'] == 4) echo "selected" ?>>4-View, PDF, Add</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="3" <?php if ($dados['usuario_compras'] == 3) echo "selected" ?>>3-View, PDF, Add, Edit</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="2" <?php if ($dados['usuario_compras'] == 2) echo "selected" ?>>2-View, PDF, Add, Edit, Del</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="1" <?php if ($dados['usuario_compras'] == 1) echo "selected" ?>>1-All</option>
              <?php } ?>   
            </select>
         </div>              
  
          
          <div class="form-group col-md-2">
            <label>Convenio</label>
            <select class="form-control" name="convenio" id="convenio" required>
              <option value="">Selecione</option>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="6" <?php if ($dados['usuario_convenio'] == 6) echo "selected" ?>>6-View</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="5" <?php if ($dados['usuario_convenio'] == 5) echo "selected" ?>>5-View, PDF</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="4" <?php if ($dados['usuario_convenio'] == 4) echo "selected" ?>>4-View, PDF, Add</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="3" <?php if ($dados['usuario_convenio'] == 3) echo "selected" ?>>3-View, PDF, Add, Edit</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="2" <?php if ($dados['usuario_convenio'] == 2) echo "selected" ?>>2-View, PDF, Add, Edit, Del</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="1" <?php if ($dados['usuario_convenio'] == 1) echo "selected" ?>>1-All</option>
              <?php } ?>   
            </select>
         </div>              

          <div class="form-group col-md-2">
            <label>Estoque</label>
            <select class="form-control" name="estoque" id="estoque" required>
              <option value="">Selecione</option>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="6" <?php if ($dados['usuario_estoque'] == 6) echo "selected" ?>>6-View</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="5" <?php if ($dados['usuario_estoque'] == 5) echo "selected" ?>>5-View, PDF</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="4" <?php if ($dados['usuario_estoque'] == 4) echo "selected" ?>>4-View, PDF, Add</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="3" <?php if ($dados['usuario_estoque'] == 3) echo "selected" ?>>3-View, PDF, Add, Edit</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="2" <?php if ($dados['usuario_estoque'] == 2) echo "selected" ?>>2-View, PDF, Add, Edit, Del</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="1" <?php if ($dados['usuario_estoque'] == 1) echo "selected" ?>>1-All</option>
              <?php } ?>   
            </select>
         </div>      
          
       </div>
      
      <div class="row">          

          <div class="form-group col-md-2">
              <label>Financeiro</label>
            <select class="form-control" name="financeiro" id="financeiro" required>
              <option value="">Selecione</option>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="6" <?php if ($dados['usuario_financeiro'] == 6) echo "selected" ?>>6-View</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="5" <?php if ($dados['usuario_financeiro'] == 5) echo "selected" ?>>5-View, PDF</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="4" <?php if ($dados['usuario_financeiro'] == 4) echo "selected" ?>>4-View, PDF, Add</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="3" <?php if ($dados['usuario_financeiro'] == 3) echo "selected" ?>>3-View, PDF, Add, Edit</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="2" <?php if ($dados['usuario_financeiro'] == 2) echo "selected" ?>>2-View, PDF, Add, Edit, Del</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="1" <?php if ($dados['usuario_financeiro'] == 1) echo "selected" ?>>1-All</option>
              <?php } ?>   
            </select>
         </div>    

          <div class="form-group col-md-2">
            <label>Hospital</label>
            <select class="form-control" name="hospital" id="hospital" required>
              <option value="">Selecione</option>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="6" <?php if ($dados['usuario_hospital'] == 6) echo "selected" ?>>6-View</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="5" <?php if ($dados['usuario_hospital'] == 5) echo "selected" ?>>5-View, PDF</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="4" <?php if ($dados['usuario_hospital'] == 4) echo "selected" ?>>4-View, PDF, Add</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="3" <?php if ($dados['usuario_hospital'] == 3) echo "selected" ?>>3-View, PDF, Add, Edit</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="2" <?php if ($dados['usuario_hospital'] == 2) echo "selected" ?>>2-View, PDF, Add, Edit, Del</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="1" <?php if ($dados['usuario_hospital'] == 1) echo "selected" ?>>1-All</option>
              <?php } ?>   
            </select>
         </div>    
          
          <div class="form-group col-md-2">
            <label>Laboratorio</label>
            <select class="form-control" name="laboratorio" id="laboratorio" required>
              <option value="">Selecione</option>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="6" <?php if ($dados['usuario_laboratorio'] == 6) echo "selected" ?>>6-View</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="5" <?php if ($dados['usuario_laboratorio'] == 5) echo "selected" ?>>5-View, PDF</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="4" <?php if ($dados['usuario_laboratorio'] == 4) echo "selected" ?>>4-View, PDF, Add</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="3" <?php if ($dados['usuario_laboratorio'] == 3) echo "selected" ?>>3-View, PDF, Add, Edit</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="2" <?php if ($dados['usuario_laboratorio'] == 2) echo "selected" ?>>2-View, PDF, Add, Edit, Del</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="1" <?php if ($dados['usuario_laboratorio'] == 1) echo "selected" ?>>1-All</option>
              <?php } ?>   
            </select>
         </div>            
          
          <div class="form-group col-md-2">
            <label>Painel</label>
            <select class="form-control" name="painel" id="painel" required>
              <option value="">Selecione</option>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="6" <?php if ($dados['usuario_painel'] == 6) echo "selected" ?>>6-View</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="5" <?php if ($dados['usuario_painel'] == 5) echo "selected" ?>>5-View, PDF</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="4" <?php if ($dados['usuario_painel'] == 4) echo "selected" ?>>4-View, PDF, Add</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="3" <?php if ($dados['usuario_painel'] == 3) echo "selected" ?>>3-View, PDF, Add, Edit</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="2" <?php if ($dados['usuario_painel'] == 2) echo "selected" ?>>2-View, PDF, Add, Edit, Del</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="1" <?php if ($dados['usuario_painel'] == 1) echo "selected" ?>>1-All</option>
              <?php } ?>   
            </select>
         </div>    
          
          <div class="form-group col-md-2">
            <label>Tabelas</label>
            <select class="form-control" name="tabelas" id="tabelas" required>
              <option value="">Selecione</option>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="6" <?php if ($dados['usuario_tabelas'] == 6) echo "selected" ?>>6-View</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="5" <?php if ($dados['usuario_tabelas'] == 5) echo "selected" ?>>5-View, PDF</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="4" <?php if ($dados['usuario_tabelas'] == 4) echo "selected" ?>>4-View, PDF, Add</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="3" <?php if ($dados['usuario_tabelas'] == 3) echo "selected" ?>>3-View, PDF, Add, Edit</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="2" <?php if ($dados['usuario_tabelas'] == 2) echo "selected" ?>>2-View, PDF, Add, Edit, Del</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="1" <?php if ($dados['usuario_tabelas'] == 1) echo "selected" ?>>1-All</option>
              <?php } ?>   
            </select>
         </div>   
          
        <div class="form-group col-md-2">
            <label>Mensagem</label>
            <select class="form-control" name="mensagem" id="mensagem" required>
              <option value="">Selecione</option>
              <option value="S"<?php  if($dados['usuario_msg'] == 'S')  echo "selected"?>>Sim</option>
              <option value="N"<?php  if($dados['usuario_msg'] == 'N')  echo "selected"?>>Não</option>
            </select>
         </div> 
          
       </div>
      
         
       <div class="row">
           
        <div class="form-group col-md-2">
            <label>Nivel</label>
            <select class="form-control" name="nivel" id="nivel" required>
              <option value="">Selecione</option>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="6" <?php if ($dados['usuario_nivel'] == 6) echo "selected" ?>>6-View</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="5" <?php if ($dados['usuario_nivel'] == 5) echo "selected" ?>>5-View, PDF</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="4" <?php if ($dados['usuario_nivel'] == 4) echo "selected" ?>>4-View, PDF, Add</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="3" <?php if ($dados['usuario_nivel'] == 3) echo "selected" ?>>3-View, PDF, Add, Edit</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="2" <?php if ($dados['usuario_nivel'] == 2) echo "selected" ?>>2-View, PDF, Add, Edit, Del</option>
              <?php } ?>
              <?php if ($_SESSION['usuarioNivel'] >=1){ ?>
              <option value="1" <?php if ($dados['usuario_nivel'] == 1) echo "selected" ?>>1-All</option>
              <?php } ?>    
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