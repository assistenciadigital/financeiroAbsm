<?php
require_once '../../config.php';
require_once(HEADERBASIC_TEMPLATE);
include("../../log.php");

$imagem = $_FILES["logomarca"];
if($imagem != NULL) { 
//echo "<script language='javascript' TYPE='text/javascript'>alert ('$imagem')</script>";
	$nomeFinal = $_GET['id']._.$time().'.png';
	if (move_uploaded_file($imagem['tmp_name'], $nomeFinal)) {
		$tamanhoImg = filesize($nomeFinal); 
		$mysqlImg = addslashes(fread(fopen($nomeFinal, "r"), $tamanhoImg)); 
	}
}

if (!isset($_SESSION)) session_start();

$menu = $_SESSION['usuarioAdmin'];

$tabela = 'empresa';

//  Conecta-se ao banco de dados MySQL
    $mysqli = new mysqli($_SG['servidor'], $_SG['usuario'], $_SG['senha'], $_SG['banco']);

//  Caso algo tenha dado errado, exibe uma mensagem de erro
    if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());
                
    $result = $mysqli->query("SELECT * FROM {$tabela} WHERE id = '".$_GET['id']."'");
    for ($set = array (); $row = $result->fetch_assoc(); $set[] = $row); $anterior = print_r($set, true);
 ?>
<header>
<div class="row">
    <div class="col-sm-12">
        <h1 class="display-3">Aguarde, Processando...
              <?php
                    if (isset($_GET['id']) and $_GET['acao'] == 'exclusao'){ // SE FOR EXCLUSAO
                        if (($menu >= 1) AND ($menu <= 2)){ // NIVEL EXCLUSAO					
							$sql = "DELETE FROM {$tabela} WHERE id = '".$_GET['id']."'";                        
							$query = $mysqli->query($sql);			                
							if ($query) $resultado = "Registro: ".$_GET['id'].", Excluido com Sucesso!"; else $resultado = "Erro ao Alterar o Registro: ".$_GET['id'].".";                        
							echo "<script language='javascript' TYPE='text/javascript'>alert ('$resultado')</script>";
                            }else{
                            echo "<script language='javascript' TYPE='text/javascript'>alert ('Acesso Negado. Sem Permissao de Exclusao!')</script>";
                            echo "<script language='javascript'> window.location.href=javascript:history.back()</script>";
                        }							
                    }
                    
                    $sql = $mysqli->query("SELECT id FROM {$tabela} WHERE cpf_cnpjAQUI = '".trim(addslashes(htmlentities($_POST['cpf_cnpj'])))."'"); // CONSULTA DUPLICIDADE
                
                    if (!$sql->num_rows){ //VALIDA DUPLICIDADE
                        if (isset($_GET['id']) and $_GET['acao'] == 'edicao'){ // SE FOR EDICAO
						if (($menu >= 1) AND ($menu <= 3)){ // NIVEL EDICAO
                            $sql = "UPDATE {$tabela} SET fantasia = '".trim(addslashes(htmlentities(strtoupper($_POST['fantasia']))))."', razao = '".trim(addslashes(htmlentities(strtoupper($_POST['razao']))))."', cpf_cnpj= '".trim(addslashes(htmlentities(($_POST['cpf_cnpj']))))."', ie = '".trim(addslashes(htmlentities(($_POST['ie']))))."', im = '".trim(addslashes(htmlentities(($_POST['im']))))."', cep = '".trim(addslashes(htmlentities(($_POST['cep']))))."', endereco = '".trim(addslashes(htmlentities(strtoupper($_POST['endereco']))))."', bairro = '".trim(addslashes(htmlentities(strtoupper($_POST['bairro']))))."', cidade = '".trim(addslashes(htmlentities(strtoupper($_POST['cidade']))))."', uf = '".trim(addslashes(htmlentities(strtoupper($_POST['uf']))))."', celular = '".trim(addslashes(htmlentities(($_POST['celular']))))."', fixo = '".trim(addslashes(htmlentities(($_POST['fixo']))))."', email = '".trim(addslashes(htmlentities(($_POST['email']))))."', responsavel = '".trim(addslashes(htmlentities(strtoupper($_POST['responsavel']))))."', funcao = '".trim(addslashes(htmlentities(strtoupper($_POST['funcao']))))."', setor = '".trim(addslashes(htmlentities(strtoupper($_POST['setor']))))."', principal = '".trim(addslashes(htmlentities(strtoupper($_POST['principal']))))."', logomarca = '".$mysqlImg."', data = '".date('Y-m-d H:i:s')."', usuario_login = '".$_SESSION['usuarioLogin']."'  WHERE id = '".$_GET['id']."'";
	                        $query = $mysqli->query($sql);
			                
                        if ($query) $resultado = "Registro: ".$_GET['id'].", Alterado com Sucesso!"; else $resultado = "Erro ao Alterar o Registro: ".$_GET['id']."."; echo "<script language='javascript' TYPE='text/javascript'>alert ('$resultado')</script>";
						}else{
								echo "<script language='javascript' TYPE='text/javascript'>alert ('Acesso Negado. Sem Permissao de Edicao!')</script>";
								echo "<script language='javascript'> window.location.href=javascript:history.back()</script>";										
						}		
                        }else if ($_GET['acao'] == 'inclusao'){ // SE FOR INCLUSAO
							if (($menu >= 1) AND ($menu <= 4)){ // NIVEL INCLUSAO
                                $sql = "INSERT INTO {$tabela} (fantasia, razao, cpf_cnpj, ie, im, cep, endereco, bairro, cidade, uf, celular, fixo, email, responsavel, funcao, setor, principal, logomarca, data, usuario_login) VALUES ('".trim(addslashes(htmlentities(strtoupper($_POST['fantasia']))))."', '".trim(addslashes(htmlentities(strtoupper($_POST['razao']))))."', '".trim(addslashes(htmlentities($_POST['cpf_cnpj'])))."', '".trim(addslashes(htmlentities(($_POST['ie']))))."', '".trim(addslashes(htmlentities(($_POST['im']))))."', '".trim(addslashes(htmlentities(($_POST['cep']))))."', '".trim(addslashes(htmlentities(strtoupper($_POST['endereco']))))."', '".trim(addslashes(htmlentities(strtoupper($_POST['bairro']))))."', '".trim(addslashes(htmlentities(strtoupper($_POST['cidade']))))."', '".trim(addslashes(htmlentities(strtoupper($_POST['uf']))))."', '".trim(addslashes(htmlentities(($_POST['celular']))))."', '".trim(addslashes(htmlentities(($_POST['fixo']))))."', '".trim(addslashes(htmlentities(strtolower($_POST['email']))))."', '".trim(addslashes(htmlentities(strtoupper($_POST['responsavel']))))."', '".trim(addslashes(htmlentities(strtoupper($_POST['funcao']))))."', '".trim(addslashes(htmlentities(strtoupper($_POST['setor']))))."', '".trim(addslashes(htmlentities(strtoupper($_POST['principal']))))."', '".trim(addslashes(htmlentities(($mysqlImg))))."', '".date('Y-m-d H:i:s')."', '".$_SESSION['usuarioLogin']."')";
                                
                                $query = $mysqli->query($sql);
                                $newrecord = $mysqli->insert_id;
                            
                                if ($query) $resultado = "Registro: ".$newrecord.", Incluido com Sucesso!"; else $resultado = "Erro ao Incluir Registro: ".$_GET['id']."."; echo "<script language='javascript' TYPE='text/javascript'>alert ('$resultado')</script>";      
								}else{
									echo "<script language='javascript' TYPE='text/javascript'>alert ('Acesso Negado. Sem Permissao de Inclusao!')</script>";
									echo "<script language='javascript'> window.location.href=javascript:history.back()</script>";										
								}	

						}
                        }else{ echo "<script language='javascript' TYPE='text/javascript'>alert ('Impossivel Progessguir. Registro Duplicidado!')</script>";
                    }
					unlink($nomeFinal);
        		   // Salva LOG no Banco de Dados
		              $mensagem = $tabela.': '.$resultado.' '.$anterior;
		              salvaLog($mensagem,$_SESSION['usuarioLogin']);
		          // Fim Salva LOG
                    ?>
            </h1>

          <hr class="m-y-2">
		</div>
	</div>
</header>

<?php



        // Finaliza aconexao com o banco de dados
        mysqli_close($mysqli); 
        require_once(FOOTER_TEMPLATE);
        echo "<script language='javascript'> window.location.href = 'lista.php' </script>";
    ?>