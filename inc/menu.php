<?php
require_once 'config.php';
require_once(HEADER_TEMPLATE);

//  Conecta-se ao banco de dados MySQL
    $mysqli = new mysqli($_SG['servidor'], $_SG['usuario'], $_SG['senha'], $_SG['banco']);

//  Caso algo tenha dado errado, exibe uma mensagem de erro
    if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());

if (!isset($_SESSION)) session_start();

$nivel_necessario = 2;

?>

<h1>Painel Principal</h1>

<hr />

<div class="row-fluid">
    
    <!-- <div class="btn-group">
      <a class="navbar-brand" href="<?php echo BASEMENU; ?>inc/menu.php"><span class="glyphicon glyphicon-home"></span> Início</a>
    </div> -->
    
    <div class="btn-group">
      <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">Cadastro<span class="caret"></span>
      </a>
      <ul class="dropdown-menu">
        <!-- Links de menu dropdown -->
            <!-- Coleta dados da tabela menu -->
            <?php
                $sql = "SELECT * FROM menu where menu like '%cadastro%' order by descricao";
                $query = $mysqli->query($sql);
                while ($dados = $query->fetch_array()) {  
                    echo '<li><a href="'.$dados['link'].'/'.$dados['arquivo'].'">'.$dados['descricao'].'</a></li>';
                }
            ?>
       </ul>
    </div>
    
    <div class="btn-group">
      <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">Compras<span class="caret"></span>
      </a>
      <ul class="dropdown-menu">
        <!-- Links de menu dropdown -->
            <!-- Coleta dados da tabela menu -->
            <?php
                $sql = "SELECT * FROM menu where menu like '%compras%' order by descricao";
                $query = $mysqli->query($sql);
                while ($dados = $query->fetch_array()) {  
                    echo '<li><a href="'.$dados['link'].'/'.$dados['arquivo'].'">'.$dados['descricao'].'</a></li>';
                }
            ?>
       </ul>
    </div>
    
    <div class="btn-group">
      <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">Convenio<span class="caret"></span>
      </a>
      <ul class="dropdown-menu">
        <!-- Links de menu dropdown -->
            <!-- Coleta dados da tabela menu -->
            <?php
                $sql = "SELECT * FROM menu where menu like '%convenio%' order by descricao";
                $query = $mysqli->query($sql);
                while ($dados = $query->fetch_array()) {  
                    echo '<li><a href="'.$dados['link'].'/'.$dados['arquivo'].'">'.$dados['descricao'].'</a></li>';
                }
            ?>
       </ul>
    </div>
    
    <div class="btn-group">
      <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">Estoque<span class="caret"></span>
      </a>
      <ul class="dropdown-menu">
        <!-- Links de menu dropdown -->
            <!-- Coleta dados da tabela menu -->
            <?php
                $sql = "SELECT * FROM menu where menu like '%estoque%' order by descricao";
                $query = $mysqli->query($sql);
                while ($dados = $query->fetch_array()) {  
                    echo '<li><a href="'.$dados['link'].'/'.$dados['arquivo'].'">'.$dados['descricao'].'</a></li>';
                }
            ?>
       </ul>
    </div>
    
    <div class="btn-group">
      <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">Financeiro<span class="caret"></span>
      </a>
      <ul class="dropdown-menu">
        <!-- Links de menu dropdown -->
            <!-- Coleta dados da tabela menu -->
            <?php
                $sql = "SELECT * FROM menu where menu like '%financeiro%' order by descricao";
                $query = $mysqli->query($sql);
                while ($dados = $query->fetch_array()) {  
                    echo '<li><a href="'.$dados['link'].'/'.$dados['arquivo'].'">'.$dados['descricao'].'</a></li>';
                }
            ?>
       </ul>
    </div>
    
    <div class="btn-group">
      <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">Hospital<span class="caret"></span>
      </a>
      <ul class="dropdown-menu">
        <!-- Links de menu dropdown -->
            <!-- Coleta dados da tabela menu -->
            <?php
                $sql = "SELECT * FROM menu where menu like '%hospital%' order by descricao";
                $query = $mysqli->query($sql);
                while ($dados = $query->fetch_array()) {  
                    echo '<li><a href="'.$dados['link'].'/'.$dados['arquivo'].'">'.$dados['descricao'].'</a></li>';
                }
            ?>
       </ul>
    </div>
    
    <div class="btn-group">
      <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">Laboratorio<span class="caret"></span>
      </a>
      <ul class="dropdown-menu">
        <!-- Links de menu dropdown -->
            <!-- Coleta dados da tabela menu -->
            <?php
                $sql = "SELECT * FROM menu where menu like '%laboratorio%' order by descricao";
                $query = $mysqli->query($sql);
                while ($dados = $query->fetch_array()) {  
                    echo '<li><a href="'.$dados['link'].'/'.$dados['arquivo'].'">'.$dados['descricao'].'</a></li>';
                }
            ?>
       </ul>
    </div>    
    
    <div class="btn-group">
      <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">Painel<span class="caret"></span>
      </a>
      <ul class="dropdown-menu">
        <!-- Links de menu dropdown -->
            <!-- Coleta dados da tabela menu -->
            <?php
                $sql = "SELECT * FROM menu where menu like '%painel%' order by descricao";
                $query = $mysqli->query($sql);
                while ($dados = $query->fetch_array()) {  
                    echo '<li><a href="'.$dados['link'].'/'.$dados['arquivo'].'">'.$dados['descricao'].'</a></li>';
                }
            ?>
       </ul>
    </div>
    
    <div class="btn-group">
      <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">Tabelas<span class="caret"></span>
      </a>
      <ul class="dropdown-menu">
        <!-- Links de menu dropdown -->
            <!-- Coleta dados da tabela menu -->
            <?php
                $sql = "SELECT * FROM menu where menu like '%tabelas%' order by descricao";
                $query = $mysqli->query($sql);
                while ($dados = $query->fetch_array()) {  
                    echo '<li><a href="'.$dados['link'].'/'.$dados['arquivo'].'">'.$dados['descricao'].'</a></li>';
                }
            ?>
       </ul>
    </div>
    
    <div class="btn-group">
      <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">Administrador<span class="caret"></span>
      </a>
      <ul class="dropdown-menu">
        <!-- Links de menu dropdown -->
            <!-- Coleta dados da tabela menu -->
            <?php
                $sql = "SELECT * FROM menu where menu like '%administrador%' order by descricao";
                $query = $mysqli->query($sql);
                while ($dados = $query->fetch_array()) {  
                    echo '<li><a href="'.$dados['link'].'/'.$dados['arquivo'].'">'.$dados['descricao'].'</a></li>';
                }
            ?>
       </ul>
    </div>
    
    <div class="btn-group">
      <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">Ajuda<span class="caret"></span>
      </a>
      <ul class="dropdown-menu">
        <!-- Links de menu dropdown -->
            <!-- Coleta dados da tabela menu -->
            <?php
                $sql = "SELECT * FROM menu where menu like '%ajuda%' order by descricao";
                $query = $mysqli->query($sql);
                while ($dados = $query->fetch_array()) {  
                    echo '<li><a href="'.$dados['link'].'/'.$dados['arquivo'].'">'.$dados['descricao'].'</a></li>';
                }
                // Finaliza a conexao com o banco de dados

                mysqli_close($mysqli);
            ?>
       </ul>
    </div>    
    
    <!-- <div class="btn-group">
      <a class="navbar-brand" href="<?php echo BASEURL; ?>inc/logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
    </div> -->
    
</div>

<?php require_once(FOOTER_TEMPLATE); ?>