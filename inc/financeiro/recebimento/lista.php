<?php
require_once '../../config.php';
require_once(HEADER_TEMPLATE);

if (!isset($_SESSION)) session_start();

$menu = $_SESSION['usuarioFinanceiro'];

if ((!$menu >= 1) AND (!$menu <= 6)){
    echo "<script language='javascript' TYPE='text/javascript'>alert ('Acesso Negado. Sem Permissao de Acesso ao Modulo!')</script>";
    echo "<script language='javascript'> window.location.href = '".VOLTAMENU."'</script>";
}

//  Conecta-se ao banco de dados MySQL
    $mysqli = new mysqli($_SG['servidor'], $_SG['usuario'], $_SG['senha'], $_SG['banco']);

//  Caso algo tenha dado errado, exibe uma mensagem de erro
    if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());
	
//  Ano
    $por_ano = (isset($_GET['porano'])) ? $_GET['porano'] : 'ano';
	
//  Pesquisar por
    $pesquisar_por = (isset($_GET['pesquisarpor'])) ? $_GET['pesquisarpor'] : 'm.id';

//  Ordenar por
    $ordenar_por = (isset($_GET['pesquisarpor'])) ? $_GET['pesquisarpor'] : 'm.id';

//  Parametro Consulta
    //if ($pesquisar_por == $_GET['pesquisarpor']) $parametro = ' = '.$_GET['consulta']; else $parametro = " like '%".$_GET['consulta']."%'";
        
//  Registros por página
    $por_pagina = (isset($_GET['porpagina'])) ? $_GET['porpagina'] : 5;


    $sql = $mysqli->query("select  m.id as mensalidade, m.titular as titular, m.competencia as competencia, m.valor as valor_mensalidade, m.vencimento as vencimento, m.usuario_login as usuario_mensalidade, m.data as data_mensalidade, r.valor as valor_recebimento, r.recebimento as recebimento, r.usuario_login as usuario_recebimento, r.data as data_recebimento, e.descricao as evento from (financeiro_mensalidade as m LEFT JOIN financeiro_recebimento as r ON r.mensalidade = m.id) left join financeiro_evento as e on m.evento = e.id WHERE m.titular = '".$_GET['titular']."'"); 
	
	$total = $sql->num_rows;

    if ($total == 0){
        //echo "<script language='javascript' TYPE='text/javascript'>alert ('Sem Registro, Favor Adicionar Novo Registro!')</script>";
        //echo "<script language='javascript'> window.location.href = 'add.php?titular=".$_GET['titular']."'</script>"; 
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
   $sql = ("select  m.id as mensalidade, m.titular as titular, m.competencia as competencia, m.valor as valor_mensalidade, m.vencimento as vencimento, m.usuario_login as usuario_mensalidade, m.data as data_mensalidade, r.valor as valor_recebimento, r.recebimento as recebimento, r.usuario_login as usuario_recebimento, r.data as data_recebimento, e.descricao as evento from (financeiro_mensalidade as m LEFT JOIN financeiro_recebimento as r ON r.mensalidade = m.id) left join financeiro_evento as e on m.evento = e.id WHERE m.titular = '".$_GET['titular']."'  AND {$pesquisar_por}  like '%".$_GET['consulta']."%' order by {$ordenar_por} LIMIT {$offset}, {$por_pagina}");
        
// Executa a consulta
   $query = $mysqli->query($sql) or die($msyqli->error) ;
    
?>
<form method="get" name="frm" id="frm" action="lista.php">
<header>
	   	<div class="row">
		<div class="form-group col-md-2">
			<h2>Recebimento:<?php $titular = @mysql_fetch_assoc(mysql_query("SELECT cliente, nome, datanascimento FROM cliente WHERE cliente = '".$_GET['titular']."'"));?></h2>	
		</div>
				<div class="form-group col-md-2">
				 <label>Titular</label>
				  <input type="text" readonly="true" class="form-control" id="titular" name="titular" placeholder="Titular" value="<?php echo $titular['cliente'];?>" required>
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
</header>        
            
<div class"container">
    <div class="row">
        
        <div class="col-md-4 text-left h5">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="<?php echo 'Pesquisar por: '.$pesquisar_por?>" name="consulta" id="consulta" value="<?php echo $_GET['consulta']?>" autofocus>
              <span class="input-group-btn">
                  <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-search"></span></button>
              </span>
            </div>
        </div>  

    
        <div class="col-md-8 text-right h5">
            Por:
            <select class="selectpicker" name="pesquisarpor" id="pesquisarpor" onchange="atualiza()">
                  <option selected value="m.id"<?php  if($_GET['pesquisarpor'] == 'm.id')  echo "selected"?>>Id</option>
                  <option value="m.competencia"<?php  if($_GET['pesquisarpor'] == 'm.competencia')  echo "selected"?>>Competencia</option>
				  <option value="m.valor"<?php  if($_GET['pesquisarpor'] == 'm.valor')  echo "selected"?>>R$ Mensal</option>
				  <option value="m.vencimento"<?php  if($_GET['pesquisarpor'] == 'm.vencimento')  echo "selected"?>>Vencimento</option>
				  <option value="r.recebimento"<?php  if($_GET['pesquisarpor'] == 'r.recebimento')  echo "selected"?>>Recebimento</option>
				  <option value="r.valor"<?php  if($_GET['pesquisarpor'] == 'r.valor')  echo "selected"?>>R$ Recebido</option>
				  <option value="m.evento"<?php  if($_GET['pesquisarpor'] == 'm.evento')  echo "selected"?>>Evento</option>
            </select>
             Registros:
            <select class="selectpicker" name="porpagina" id="porpagina" onchange="atualiza()">
                  <option selected value="5"<?php  if($_GET['porpagina'] == 5)  echo "selected"?>>5</option>
                  <option value="10"<?php  if($_GET['porpagina'] == 10)  echo "selected"?>>10</option>
                  <option value="20"<?php  if($_GET['porpagina'] == 20)  echo "selected"?>>20</option>
                  <option value="40"<?php  if($_GET['porpagina'] == 40)  echo "selected"?>>40</option>
                  <option value="60"<?php  if($_GET['porpagina'] == 60)  echo "selected"?>>60</option>
                  <option value="80"<?php  if($_GET['porpagina'] == 80)  echo "selected"?>>80</option>
                  <option value="100"<?php if($_GET['porpagina'] == 100) echo "selected"?>>100</option>
            </select>
			
            <select class="selectpicker" name="porano" id="porano" onchange="atualiza()">
              <option value="">Ano</option>
              <?php
                $select_ano = mysql_query ("SELECT DISTINCT YEAR(competencia) as ano FROM financeiro_mensalidade WHERE titular = '".$_GET['titular']."' ORDER BY ano");
                if (mysql_num_rows ($select_ano)) {
                while ($row_ano = mysql_fetch_assoc($select_ano)) {
                ?>
                <option value="<?php echo $row_ano['ano']?>"<?php if($_GET['porano'] == $row_ano['ano']) echo "selected"?>><?php echo $row_ano['ano']?></option>
              <?php }}?> 
            </select>
			<?php if ($_GET['porano']){?>
			<a class="btn btn-info" <?php if (($menu >= 1) AND ($menu <= 5)){?>href="<?php if ($_GET['porano']) echo 'certidao.php?titular='.$_GET['titular'].'&porano='.$_GET['porano']?>" target="_blank"<?php }?>><i class="fa fa-file-pdf-o"></i> Certidao</a>
			<a class="btn btn-info" <?php if (($menu >= 1) AND ($menu <= 5)){?>href="<?php if ($_GET['porano']) echo 'report.php?titular='.$_GET['titular'].'&porano='.$_GET['porano']?>" target="_blank"<?php }?>><i class="fa fa-file-pdf-o"></i> Relatorio</a>
            <?php }else{ }?>           
            
	    	<a class="btn btn-primary" href="<?php if (($menu >= 1) AND ($menu <= 4)) echo "add.php?titular=".$_GET['titular']?>"><i class="glyphicon glyphicon-plus"></i></a>
            <button type="button" class="btn btn-default" onclick="atualiza()"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button>
			<a class="btn btn-default" href="titular.php"><i class="fa fa-ban" aria-hidden="true"></i> Voltar</a>
        </div>
        
    </div>
</div>
<table class="table table-hover table-layout: fixed table-condensed h6">
<thead>
	<tr vertical-align: middle;>
		<th width="5%">ID</th>
		<th width="10%" class="text-center">Competencia</th>
		<th width="10%" class="text-right">R$ Mensal</th>
		<th width="10%" class="text-center">Vencimento</th>
		<th width="10%">Em / por</th>		
		<th width="10%" class="text-center">Recebimento</th>
		<th width="10%" class="text-right">R$ Recebido</th>
		<th width="10%">Evento</th>
		<th width="10%">Em / por</th>
		<th width="15%" class="text-right">Opções:</th>
	</tr>
</thead>
    <?php
            while ($dados = $query->fetch_array()) {  
    ?>
<tbody>
	<tr <?php if ($dados['recebimento'] and $dados['valor_recebimento'] and $dados['evento']) echo "bgcolor=success"; else echo "bgcolor=danger";?>>
		<td class="text-center"><?php echo $dados['mensalidade']; ?></td>
		<td class="text-center"><?php echo date_data($dados['competencia']); ?></td>
		<td class="text-right"><?php echo number_format($dados['valor_mensalidade'], 2, ',', '.'); ?></td>
		<td class="text-center"><?php echo date_data($dados['vencimento']); ?></td>
		<td><?php echo datetime_datatempo($dados['data_mensalidade']).'<br/>'.$dados['usuario_mensalidade']; ?></td>		
		<td class="text-center"><?php echo date_data($dados['recebimento']); ?></td>
		<td class="text-right"><?php echo number_format($dados['valor_recebimento'], 2, ',', '.'); ?></td>
		<td><?php echo $dados['evento']; ?></td>
		<td><?php echo datetime_datatempo($dados['data_recebimento']).'<br/>'.$dados['usuario_recebimento']; ?></td>
		<td class="actions text-right">
			<!--<a href="<?php if (($menu >= 1) AND ($menu <= 5)) echo '../recebimento/recebimento.php?id='.$dados['mensalidade'].'&titular='.$dados['titular']; ?>" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-usd"></i></a>-->
			<a href="<?php if (($menu >= 1) AND ($menu <= 5)) echo 'view.php?id='.$dados['mensalidade'].'&titular='.$dados['titular']; ?>" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-eye-open"></i></a>
			<a href="<?php if (($menu >= 1) AND ($menu <= 3)) echo 'edit.php?id='.$dados['mensalidade'].'&titular='.$dados['titular']; ?>" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-pencil"></i></a>
			<a href="<?php if (($menu >= 1) AND ($menu <= 2)) echo 'run.php?acao=exclusao&id='.$dados['mensalidade'].'&titular='.$dados['titular']; ?>" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
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
                <a href="lista.php<?php echo "?consulta=".$_GET['consulta']."&titular=".$_GET['titular']; if ($_GET['pesquisarpor']) echo "&pesquisarpor=".$_GET['pesquisarpor']; else echo "&pesquisarpor=".$pesquisar_por;?>&pagina=1&porpagina=<?php if ($por_pagina) echo $por_pagina; else echo $_GET['porpagina']."&titular=".$_GET['titular']?>" rel="Registro Primeiro"><span class="glyphicon glyphicon-step-backward" aria-hidden="true"></span>Primeiro</a>

                <a href="lista.php<?php echo "?consulta=".$_GET['consulta']."&titular=".$_GET['titular']; if ($_GET['pesquisarpor']) echo "&pesquisarpor=".$_GET['pesquisarpor']; else echo "&pesquisarpor=".$pesquisar_por;?>&pagina=<?php if ($anterior == 0){$anterior = 1;} echo $anterior?>&porpagina=<?php if ($por_pagina) echo $por_pagina; else echo $_GET['porpagina']?>" rel="Registro Anterior"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>Anterior</a>

                <a href="lista.php<?php echo "?consulta=".$_GET['consulta']."&titular=".$_GET['titular']; if ($_GET['pesquisarpor']) echo "&pesquisarpor=".$_GET['pesquisarpor']; else echo "&pesquisarpor=".$pesquisar_por;?>&pagina=<?php if ($proximo > $paginas){echo $paginas; }else{echo $proximo;}?>&porpagina=<?php if ($por_pagina) echo $por_pagina; else echo $_GET['porpagina']?>" rel="Registro Próximo">Próximo<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a>

                <a href="lista.php<?php echo "?consulta=".$_GET['consulta']."&titular=".$_GET['titular']; if ($_GET['pesquisarpor']) echo "&pesquisarpor=".$_GET['pesquisarpor']; else echo "&pesquisarpor=".$pesquisar_por; ?>&pagina=<?php echo $paginas?>&porpagina=<?php if ($por_pagina) echo $por_pagina; else echo $_GET['porpagina']?>" rel="Registro Último">Último<span class="glyphicon glyphicon-step-forward" aria-hidden="true"></span></a>
                
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
            <span class="label label-success"><i class="glyphicon glyphicon-eye-open"></i></span> Visualizar
            <span class="label label-warning"><i class="glyphicon glyphicon-pencil"></i></span> Editar
            <span class="label label-danger"><i class="glyphicon glyphicon-trash"></i></span> Excluir
        </div>
    </div>
</div>