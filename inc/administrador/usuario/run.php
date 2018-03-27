<?php
require_once '../../config.php';
require_once(HEADERBASIC_TEMPLATE);
include("../../log.php");

if (!isset($_SESSION)) session_start();

$menu = $_SESSION['usuarioAdmin'];

$tabela = 'usuario';

//  Conecta-se ao banco de dados MySQL
    $mysqli = new mysqli($_SG['servidor'], $_SG['usuario'], $_SG['senha'], $_SG['banco']);

//  Caso algo tenha dado errado, exibe uma mensagem de erro
    if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());
                
    $result = $mysqli->query("SELECT * FROM {$tabela} WHERE usuario_login = '".$_GET['usuario_login']."'");
    for ($set = array (); $row = $result->fetch_assoc(); $set[] = $row); $anterior = print_r($set, true);
?>
<header>
<div class="row">
    <div class="col-sm-12">
        <h1 class="display-3">Aguarde, Processando...
              <?php
            
                    if (isset($_GET['usuario_login']) and $_GET['acao'] == 'key'){ // ALTERAR SENHA
                        if (($menu >= 1) AND ($menu <= 2)){ // NIVEL EXCLUSAO					
							$sql = "UPDATE {$tabela} SET usuario_senha = '".md5($_POST['senha'])."' WHERE usuario_ativo = 'S' AND usuario_excluido = 'N' AND usuario_login = '".$_GET['usuario_login']."'";
							$query = $mysqli->query($sql);
							if ($query) $resultado = "Registro: ".$_GET['usuario_login'].", Senha Usuario Alterada com Sucesso!"; else $resultado = "Erro ao Alterar Senha Usuario Registro: ".$_GET['usuario_login'].".";
							echo "<script language='javascript' TYPE='text/javascript'>alert ('$resultado')</script>";
                            }else{
                            echo "<script language='javascript' TYPE='text/javascript'>alert ('Acesso Negado. Sem Permissao de Exclusao!')</script>";
                            echo "<script language='javascript'> window.location.href=javascript:history.back()</script>";
                        }							
                    }
            
					if (($menu >= 1) AND ($menu <= 2)){ // NIVEL ATIVACAO / DESATIVACAO
                    if (isset($_GET['usuario_login']) and $_GET['acao'] == 'inativa'){ // SE FOR INATIVACAO
					
                        $sql = "UPDATE {$tabela} SET usuario_ativo = 'N' WHERE usuario_ativo = 'S' AND usuario_login = '".$_GET['usuario_login']."'";
                        
                        $query = $mysqli->query($sql);
			                
                        if ($query) $resultado = "Registro: ".$_GET['usuario_login'].", Inativado com Sucesso!"; else $resultado = "Erro ao Alterar Inativacao do Registro: ".$_GET['usuario_login'].".";
                        
                        echo "<script language='javascript' TYPE='text/javascript'>alert ('$resultado')</script>";
						} else if (isset($_GET['usuario_login']) and $_GET['acao'] == 'ativa'){ // SE FOR ATIVACAO
                        $sql = "UPDATE {$tabela} SET usuario_ativo = 'S' WHERE usuario_ativo = 'N' AND usuario_login = '".$_GET['usuario_login']."'";
                        
                        $query = $mysqli->query($sql);
			                
                        if ($query) $resultado = "Registro: ".$_GET['usuario_login'].", Ativado com Sucesso!"; else $resultado = "Erro ao Alterar Ativacao do Registro: ".$_GET['usuario_login'].".";
                        
                        echo "<script language='javascript' TYPE='text/javascript'>alert ('$resultado')</script>";
                    }
					}else{
					echo "<script language='javascript' TYPE='text/javascript'>alert ('Acesso Negado. Sem Permissao de Ativacao e Desativacao!')</script>";
					echo "<script language='javascript'> window.location.href=javascript:history.back()</script>";										
					}	
					
					if (($menu >= 1) AND ($menu <= 2)){ // NIVEL ATIVACAO / DESATIVACAO
                    if (isset($_GET['usuario_login']) and $_GET['acao'] == 'desabilita'){ // SE FOR EXCLUSAO
                        $sql = "UPDATE {$tabela} SET usuario_excluido = 'N' WHERE usuario_excluido = 'S' AND usuario_login = '".$_GET['usuario_login']."'";
                        
                        $query = $mysqli->query($sql);
			                
                        if ($query) $resultado = "Registro: ".$_GET['usuario_login'].", Excluido com Sucesso!"; else $resultado = "Erro ao Alterar Exclusao do Registro: ".$_GET['usuario_login'].".";
                        
                        echo "<script language='javascript' TYPE='text/javascript'>alert ('$resultado')</script>";
                    } else if (isset($_GET['usuario_login']) and $_GET['acao'] == 'habilita'){ // SE FOR EXCLUSAO
                        $sql = "UPDATE {$tabela} SET usuario_excluido = 'S' WHERE usuario_excluido = 'N' AND usuario_login = '".$_GET['usuario_login']."'";
                        
                        $query = $mysqli->query($sql);
			                
                        if ($query) $resultado = "Registro: ".$_GET['usuario_login'].", Ativado com Sucesso!"; else $resultado = "Erro ao Alterar Ativacao do Registro: ".$_GET['usuario_login'].".";
                        
                        echo "<script language='javascript' TYPE='text/javascript'>alert ('$resultado')</script>";
                    }   

					}else{
					echo "<script language='javascript' TYPE='text/javascript'>alert ('Acesso Negado. Sem Permissao de Habilitacao e Desabilitacao!')</script>";
					echo "<script language='javascript'> window.location.href=javascript:history.back()</script>";										
					}					
                    
                    $sql = $mysqli->query("SELECT usuario_login FROM {$tabela} WHERE NAO_VERIFICA='".$_GET['usuario_login']."'"); // CONSULTA DUPLICIDADE
                
                    if (!$sql->num_rows){ //VALIDA DUPLICIDADE
                        if (isset($_GET['usuario_login']) and $_GET['acao'] == 'edicao'){ // SE FOR EDICAO
						if (($menu >= 1) AND ($menu <= 3)){ // NIVEL EDICAO
                        
                        $sql = "UPDATE {$tabela} SET usuario_nome = '".trim(addslashes(htmlentities(ucwords($_POST['nome']))))."', usuario_nascimento = '".($_POST['nascimento'])."', usuario_sexo = '".$_POST['sexo']."', usuario_nivel = '".$_POST['nivel']."', usuario_email = '".$_POST['email']."', usuario_telefone = '".$_POST['telefone']."', usuario_celular = '".$_POST['celular']."', usuario_msg = '".$_POST['mensagem']."', usuario_ativo = '".$_POST['ativo']."', usuario_excluido = '".$_POST['excluido']."', usuario_admin = '".$_POST['admin']."', usuario_adminpainel = '".$_POST['adminpainel']."', usuario_cadastro = '".$_POST['cadastro']."', usuario_compras = '".$_POST['compras']."', usuario_convenio = '".$_POST['convenio']."', usuario_estoque = '".$_POST['estoque']."', usuario_financeiro = '".$_POST['financeiro']."', usuario_hospital = '".$_POST['hospital']."', usuario_laboratorio = '".$_POST['laboratorio']."', usuario_painel = '".$_POST['painel']."', usuario_tabelas = '".$_POST['tabelas']."', data = '".date('Y-m-d H:i:s')."', usuario_logado = '".$_SESSION['usuarioLogin']."'  WHERE usuario_login = '".$_GET['usuario_login']."'";
                        
                        $query = $mysqli->query($sql);
			                
                        if ($query) $resultado = "Registro: ".$_GET['usuario_login'].", Alterado com Sucesso!"; else $resultado = "Erro ao Alterar o Registro: ".$_GET['usuario_login'].".";
                        
                        echo "<script language='javascript' TYPE='text/javascript'>alert ('$resultado')</script>";
						}else{
								echo "<script language='javascript' TYPE='text/javascript'>alert ('Acesso Negado. Sem Permissao de Edicao!')</script>";
								echo "<script language='javascript'> window.location.href=javascript:history.back()</script>";										
							}
                             
                        }else if ($_GET['acao'] == 'inclusao'){ // SE FOR INCLUSAO
						if (($menu >= 1) AND ($menu <= 4)){ // NIVEL INCLUSAO
                                $sql = "INSERT INTO {$tabela} (usuario_login, usuario_nome, usuario_nascimento, usuario_sexo, usuario_nivel, usuario_email, usuario_celular, usuario_telefone, usuario_ativo, usuario_msg, usuario_excluido, usuario_admin, usuario_adminpainel, usuario_cadastro, usuario_compras, usuario_convenio, usuario_estoque, usuario_financeiro, usuario_hospital, usuario_laboratorio, usuario_painel, usuario_tabelas, data, usuario_logado) VALUES ('".trim(addslashes(htmlentities($_POST['usuario_login'])))."', '".trim(addslashes(htmlentities($_POST['nome'])))."', '".$_POST['nascimento']."', '".$_POST['sexo']."', '".$_POST['nivel']."', '".$_POST['email']."', '".$_POST['celular']."', '".$_POST['telefone']."', '".$_POST['ativo']."', '".$_POST['mensagem']."', '".$_POST['excluido']."', '".$_POST['admin']."', '".$_POST['adminpainel']."', '".$_POST['cadastro']."', '".$_POST['compras']."', '".$_POST['convenio']."', '".$_POST['estoque']."', '".$_POST['financeiro']."', '".$_POST['hospital']."', '".$_POST['laboratorio']."', '".$_POST['painel']."', '".$_POST['tabelas']."', '".date('Y-m-d H:i:s')."', '".$_SESSION['usuarioLogin']."')";
                                
                                $query = $mysqli->query($sql);
                                $newrecord = $_GET['usuario_login'];//$mysqli->insert_id;
                            
                                if ($query) $resultado = "Registro: ".$newrecord.", Incluido com Sucesso!"; else $resultado = "Erro ao Incluir Registro: ".$_GET['id'].".";
                            
                                echo "<script language='javascript' TYPE='text/javascript'>alert ('$resultado')</script>";      
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
        echo "<script language='javascript'> window.location.href = 'lista.php' </script>";
    ?>