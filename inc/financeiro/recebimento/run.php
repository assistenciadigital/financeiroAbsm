<?php
require_once '../../config.php';
require_once(HEADERBASIC_TEMPLATE);
include("../../log.php");
include("../../valores.php");


if (!isset($_SESSION)) session_start();

$menu = $_SESSION['usuarioFinanceiro'];

$tabela = 'financeiro_recebimento';

//  Conecta-se ao banco de dados MySQL
    $mysqli = new mysqli($_SG['servidor'], $_SG['usuario'], $_SG['senha'], $_SG['banco']);

//  Caso algo tenha dado errado, exibe uma mensagem de erro
    if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());
                
    //$result = $mysqli->query("SELECT * FROM {$tabela} WHERE titular = '".$_GET['titular']."'");
    //for ($set = array (); $row = $result->fetch_assoc(); $set[] = $row); $anterior = print_r($set, true);
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
							echo "<script language='javascript'> window.location.href = 'lista.php?id=".$_GET['id']."&titular=".$_GET['titular']."' </script>";
                            }else{
                            echo "<script language='javascript' TYPE='text/javascript'>alert ('Acesso Negado. Sem Permissao de Exclusao!')</script>";
                            echo "<script language='javascript'> window.location.href=javascript:history.back()</script>";
                        }
                    }			  
                    
                    $sql = $mysqli->query("SELECT id FROM {$tabela} WHERE titular='".$_POST['titular']."' and recebimento='".$_POST['recebimento']."' and valor='".$_POST['valor']."' and vencimento='".$_POST['evento']."'"); // CONSULTA DUPLICIDADE
                
                    if (!$sql->num_rows){ //VALIDA DUPLICIDADE
                        if (isset($_GET['id']) and $_GET['acao'] == 'edicao'){ // SE FOR EDICAO
						if (($menu >= 1) AND ($menu <= 3)){ // NIVEL EDICAO
                        
                        $sql = "UPDATE {$tabela} SET titular = '".$_GET['titular']."', competencia = '".$_POST['competencia']."', valor = '".moeda($_POST['valor'])."', vencimento = '".$_POST['vencimento']."', data = '".date('Y-m-d H:i:s')."', usuario_login = '".$_SESSION['usuarioLogin']."'  WHERE id = '".$_GET['id']."'";
                        
                        $query = $mysqli->query($sql);
			                
                        if ($query) $resultado = "Registro: ".$_GET['id'].", Alterado com Sucesso!"; else $resultado = "Erro ao Alterar o Registro: ".$_GET['id']."."; 
						echo "<script language='javascript' TYPE='text/javascript'>alert ('$resultado')</script>";
						echo "<script language='javascript'> window.location.href = 'lista.php?id=".$_GET['id']."&titular=".$_GET['titular']."' </script>";
						}else{
								echo "<script language='javascript' TYPE='text/javascript'>alert ('Acesso Negado. Sem Permissao de Edicao!')</script>";
								echo "<script language='javascript'> window.location.href=javascript:history.back()</script>";										
							}
                             
                        }else if ($_GET['id'] and $_GET['titular'] and $_GET['acao'] == 'recebimento'){ // SE FOR INCLUSAO
						if (($menu >= 1) AND ($menu <= 3)){ // NIVEL INCLUSAO
								
                                $sql = "INSERT INTO {$tabela} (mensalidade, valor, recebimento, evento, usuario_login, data) VALUES ('".$_GET['id']."', '".moeda($_POST['valor'])."', '".($_POST['recebimento'])."', '".($_POST['evento'])."', '".$_SESSION['usuarioLogin']."', '".date('Y-m-d H:i:s')."')";
                                
                                $query = $mysqli->query($sql);
                                $newrecord = $mysqli->insert_id;
                            
                                if ($query) $resultado = "Registro: ".$newrecord.", Incluido com Sucesso!"; else $resultado = "Erro ao Incluir Registro: ".$_GET['id']."."; 
								echo "<script language='javascript' TYPE='text/javascript'>alert ('$resultado')</script>";      
								echo "<script language='javascript'> window.location.href = '../mensalidade/lista.php?titular=".$_GET['titular']."&titular=".$_GET['titular']."' </script>";
								}else{
									echo "<script language='javascript' TYPE='text/javascript'>alert ('Acesso Negado. Sem Permissao de Inclusao!')</script>";
									echo "<script language='javascript'> window.location.href=javascript:history.back()</script>";										
								}	
                        }
                        }else{ echo "<script language='javascript' TYPE='text/javascript'>alert ('Impossivel Progessguir. Registro Duplicidado!')</script>";
                    }

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
    ?>