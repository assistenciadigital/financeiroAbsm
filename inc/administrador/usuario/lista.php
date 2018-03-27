<?php
require_once '../../config.php';
require_once(HEADER_TEMPLATE);

if (!isset($_SESSION)) session_start();

$menu = $_SESSION['usuarioAdmin'];

if ((!$menu >= 1) AND (!$menu <= 6)){
    echo "<script language='javascript' TYPE='text/javascript'>alert ('Acesso Negado. Sem Permissao de Acesso ao Modulo!')</script>";
    echo "<script language='javascript'> window.location.href = '".VOLTAMENU."'</script>";
}

//  Conecta-se ao banco de dados MySQL
    $mysqli = new mysqli($_SG['servidor'], $_SG['usuario'], $_SG['senha'], $_SG['banco']);

//  Caso algo tenha dado errado, exibe uma mensagem de erro
    if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());

//  Tabela
    $tabela = 'usuario';

//  Pesquisar por
    $pesquisar_por = (isset($_GET['pesquisarpor'])) ? $_GET['pesquisarpor'] : 'usuario_login';

//  Ordenar por
    $ordenar_por = (isset($_GET['pesquisarpor'])) ? $_GET['pesquisarpor'] : 'usuario_login';

//  Parametro Consulta
    //if ($pesquisar_por == 'id') $parametro = ' = '.$_GET['consulta']; else $parametro = " like '%".$_GET['consulta']."%'";
  
//  Registros por página
    $por_pagina = (isset($_GET['porpagina'])) ? $_GET['porpagina'] : 5;

    $sql = $mysqli->query("SELECT * FROM {$tabela} WHERE {$pesquisar_por} like '%".$_GET['consulta']."%'");

    $total = $sql->num_rows;

    if ($total == 0){
		// build js 
		echo "<script language=\"javascript\">";
		echo "var question=confirm(\"PESQUISA INVALIDA! Clique em OK para Adicionar Novo Registro ou Cancelar para Retornar.\");"; 
		echo "if(question){ window.location.href = 'add.php'; }";
		echo "</script>";

        //echo "<script language='javascript' TYPE='text/javascript'>alert ('Sem Registro, Favor Adicionar Novo Registro!')</script>";
        //echo "<script language='javascript'> window.location.href = 'add.php'</script>"; 
    }

//  Calcula o máximo de paginas
    $paginas =  (($total % $por_pagina) > 0) ? (int)($total / $por_pagina) + 1 : ($total / $por_pagina);
    
   if (isset($_GET['pagina'])) {
          $pagina = (int)$_GET['pagina'];
        } else {
          $pagina = 1;
    }
    $pagina = max(min($paginas, $pagina), 1);
    $offset = ($pagina - 1) * $por_pagina;
    
// Monta outra consulta MySQL, agora a que fará a busca com paginação
   $sql = "SELECT * FROM {$tabela} WHERE {$pesquisar_por}  like '%".$_GET['consulta']."%' order by {$ordenar_por}, usuario_nome LIMIT {$offset}, {$por_pagina}";
        
// Executa a consulta
   $query = $mysqli->query($sql) or die($msyqli->error) ;
    
?>
<form method="get" name="frm" id="frm" action="lista.php">
<header>
	<div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="col-sm-2"> 
            <h2>Usuario</h2>
        </div>
    </div>
</header>        
            
<div class"container">
    <div class="row">
        
        <div class="col-md-4 text-left h5">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="<?php echo 'Pesquisar por: '.ucfirst($pesquisar_por)?>" name="consulta" id="consulta" value="<?php echo $_GET['consulta']?>">
              <span class="input-group-btn">
                  <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-search"></span></button>
              </span>
            </div>
        </div>  

    
        <div class="col-md-8 text-right h5">
            Pesquisar Por:
            <select class="selectpicker" name="pesquisarpor" id="pesquisarpor" onchange="atualiza()">
                  <option selected value="usuario_login"<?php  if($_GET['pesquisarpor'] == 'usuario_login')  echo "selected"?>>Login</option>
                  <option value="usuario_nome"<?php  if($_GET['pesquisarpor'] == 'usuario_nome')  echo "selected"?>>Nome</option>
                  <option value="usuario_nivel"<?php  if($_GET['pesquisarpor'] == 'usuario_nivel')  echo "selected"?>>Nivel</option>
                  <option value="usuario_ativo"<?php  if($_GET['pesquisarpor'] == 'usuario_ativo')  echo "selected"?>>Ativo</option>
                  <option value="usuario_excluido"<?php  if($_GET['pesquisarpor'] == 'usuario_excluido')  echo "selected"?>>Excluido</option>
            </select>
             Registros por página:
            <select class="selectpicker" name="porpagina" id="porpagina" onchange="atualiza()">
                  <option selected value="5"<?php  if($_GET['porpagina'] == 5)  echo "selected"?>>5</option>
                  <option value="10"<?php  if($_GET['porpagina'] == 10)  echo "selected"?>>10</option>
                  <option value="20"<?php  if($_GET['porpagina'] == 20)  echo "selected"?>>20</option>
                  <option value="40"<?php  if($_GET['porpagina'] == 40)  echo "selected"?>>40</option>
                  <option value="60"<?php  if($_GET['porpagina'] == 60)  echo "selected"?>>60</option>
                  <option value="80"<?php  if($_GET['porpagina'] == 80)  echo "selected"?>>80</option>
                  <option value="100"<?php if($_GET['porpagina'] == 100) echo "selected"?>>100</option>
            </select>
            <a onclick="" class="btn btn-info" <?php if (($menu >= 1) AND ($menu <= 5)){?>href="report _niveis.php?pesquisarpor=<?php if ($_GET['pesquisarpor']) echo $_GET['pesquisarpor']; else echo $pesquisar_por?>&consulta=<?php echo $_GET['consulta']?>" target="_blank"><?php }?><i class="fa fa-file-pdf-o"></i> Nivel User</a>
            <a onclick="" class="btn btn-info" <?php if (($menu >= 1) AND ($menu <= 5)){?>href="report.php?pesquisarpor=<?php if ($_GET['pesquisarpor']) echo $_GET['pesquisarpor']; else echo $pesquisar_por?>&consulta=<?php echo $_GET['consulta']?>" target="_blank"<?php } ?>><i class="fa fa-file-pdf-o"></i> Lista User</a>
	    	<a class="btn btn-primary" href="<?php if (($menu >= 1) AND ($menu <= 4)) echo 'add.php'?>"><i class="glyphicon glyphicon-plus"></i></a>
            <button type="button" class="btn btn-default" onclick="atualiza()"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button>
        </div>
        
    </div>
</div>
<table class="table table-hover table-layout: fixed table-condensed h6">
<thead>
	<tr vertical-align: middle;>
		<th width="10%">Login</th>
		<th width="20%">Nome</th>
		<th width="10%">Nivel</th>
        <th width="5%">Ativo</th>
        <th width="5%">Excluido</th>
        <th width="10%">Telefone</th>
        <th width="10%">Ultimo acesso</th>
		<th width="15%">Atualizado / Por</th>
		<th width="15%" class="text-right">Opções</th>
	</tr>
</thead>
    <?php
            while ($dados = $query->fetch_array()) {  
    ?>
<tbody>
	<tr>
		<td><?php echo $dados['usuario_login']; ?></td>
		<td><?php echo $dados['usuario_nome']; ?></td>
        <td><?php if ($dados['usuario_nivel']==1) echo '1-All'; if ($dados['usuario_nivel']==2) echo '2-View, PDF, Add, Edit, Del'; if ($dados['usuario_nivel']==3) echo '3-View, PDF, Add, Edit'; if ($dados['usuario_nivel']==4) echo '4-View, PDF, Add'; if ($dados['usuario_nivel']==5) echo '5-View, PDF'; if ($dados['usuario_nivel']==6) echo '6-View';?></td>
		<td><?php if (($menu >= 1) AND ($menu <= 2)) if($dados['usuario_ativo']=='S') echo '<a href="run.php?usuario_login='.$dados['usuario_login'].'&acao=inativa"><button type="button" class="btn btn-success btn-xs">Sim <span class="fa fa-unlock"></span></button></a>'; else echo '<a href="run.php?usuario_login='.$dados['usuario_login'].'&acao=ativa"><button type="button" class="btn btn-danger btn-xs">Nao <span class="fa fa-lock"></span></button></a>';?></td>
		<td><?php if (($menu >= 1) AND ($menu <= 2)) if($dados['usuario_excluido']=='S') echo '<a href="run.php?usuario_login='.$dados['usuario_login'].'&acao=desabilita"><button type="button" class="btn btn-success btn-xs">Sim <span class="glyphicon glyphicon-ok"></span></button></a>'; else echo '<a href="run.php?usuario_login='.$dados['usuario_login'].'&acao=habilita"><button type="button" class="btn btn-danger btn-xs">Nao <span class="glyphicon glyphicon-remove"></span></button></a>';?></td>
        <td><?php echo $dados['usuario_celular'].'<br/>'.$dados['usuario_telefone']; ?></td>
        <td><?php echo datetime_datatempo($dados['usuario_ultimo_acesso']); ?></td>
        <td><?php echo datetime_datatempo($dados['data']).'<br/>'.$dados['usuario_login']; ?></td>
		<td class="actions text-right">
			<a href="<?php if ($menu == 1) echo 'key.php?usuario_login='.$dados['usuario_login']; ?>" class="btn btn-sm btn-primary"><i class="fa fa-key" aria-hidden="true"></i></a>
			<a href="<?php if (($menu >= 1) AND ($menu <= 5)) echo 'view.php?usuario_login='.$dados['usuario_login']?>" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-eye-open"></i></a>
			<a href="<?php if (($menu >= 1) AND ($menu <= 3)) echo 'edit.php?usuario_login='.$dados['usuario_login']?>" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-pencil"></i></a>
		</td>
	</tr>
<?php } ?>
</tbody>
</table> 
</form>
<div class="row h6">
        <div class="col-sm-4">
            <div class="alert alert-success text-center" role="alert">
                <!-- /# PAGINACAO -->    
                <?php 
                // Links de paginação
                // Começa a exibição dos paginadores
                if ($total > 0) {
                    for ($n = 1; $n <= $paginas; $n++) {
                    }
                    $anterior = $pagina -1;
                    $proximo = $pagina +1; 
                ?>
                <a href="lista.php?consulta=<?php echo $_GET['consulta']?>&pesquisarpor=<?php if ($_GET['pesquisarpor']) echo $_GET['pesquisarpor']; else echo $pesquisar_por;?>&<?php echo $_GET['consulta']?>&pagina=1&porpagina=<?php if ($por_pagina) echo $por_pagina; else echo $_GET['porpagina']?>" rel="Registro Primeiro"><span class="glyphicon glyphicon-step-backward" aria-hidden="true"></span>Primeiro</a>

                <a href="lista.php?consulta=<?php echo $_GET['consulta']?>&pesquisarpor=<?php if ($_GET['pesquisarpor']) echo $_GET['pesquisarpor']; else echo $pesquisar_por;?>&<?php echo $_GET['consulta']?>&pagina=<?php if ($anterior == 0){$anterior = 1;} echo $anterior?>&porpagina=<?php if ($por_pagina) echo $por_pagina; else echo $_GET['porpagina']?>" rel="Registro Anterior"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>Anterior</a>

                <a href="lista.php?consulta=<?php echo $_GET['consulta']?>&pesquisarpor=<?php if ($_GET['pesquisarpor']) echo $_GET['pesquisarpor']; else echo $pesquisar_por;?>&<?php echo $_GET['consulta']?>&pagina=<?php if ($proximo > $paginas){echo $paginas; }else{echo $proximo;}?>&porpagina=<?php if ($por_pagina) echo $por_pagina; else echo $_GET['porpagina']?>" rel="Registro Próximo">Próximo<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a>

                <a href="lista.php?consulta=<?php echo $_GET['consulta']?>&pesquisarpor=<?php if ($_GET['pesquisarpor']) echo $_GET['pesquisarpor']; else echo $pesquisar_por;?>&<?php echo $_GET['consulta']?>&pagina=<?php echo $paginas?>&porpagina=<?php if ($por_pagina) echo $por_pagina; else echo $_GET['porpagina']?>" rel="Registro Último">Último<span class="glyphicon glyphicon-step-forward" aria-hidden="true"></span></a>
                
            <?php
            // Finaliza aconexao com o banco de dados
            mysqli_close($mysqli);
            ?>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="alert alert-success text-center" role="alert">
                <?php if (!isset($_GET['pagina'])){echo "Página:  1 de: ".number_format(($paginas), 0, ',', '.');}else{ echo "Página: ".number_format(($_GET['pagina']), 0, ',', '.')." de: ".number_format(($paginas), 0, ',', '.');} }?>
            </div>
        </div>
    
    
        <div class="col-sm-6">
        <div class="alert alert-success text-right" role="alert">
            <?php echo " Registro: [ ".min($total, ($offset + 1))." à ".min($total, ($offset + $por_pagina))." ] Total de: [  ".number_format(($total), 0, ',', '.')." ] Registros encontrados para: [ ".$_GET['pesquisarpor']." = ".$_GET['consulta']." ]";?>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="alert alert-success text-center" role="alert">
            <span class="label label-primary"><i class="glyphicon glyphicon-search" aria-hidden="true"></i></span> Consultar
            <span class="label label-info"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></span> Relatorio - PDF
            <span class="label label-primary"><i class="glyphicon glyphicon-plus" aria-hidden="true"></i></span> Novo Registro
            <span class="label label-default"><i class="glyphicon glyphicon-refresh" aria-hidden="true"></i></span> Atualizar
            <span class="label label-primary"><i class="fa fa-key"></i></span> Senha
            <span class="label label-success"><i class="glyphicon glyphicon-eye-open"></i></span> Visualizar
            <span class="label label-warning"><i class="glyphicon glyphicon-pencil"></i></span> Editar
            <span class="label label-danger"><i class="glyphicon glyphicon-trash"></i></span> Excluir
        </div>
    </div>
</div>