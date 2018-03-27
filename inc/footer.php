<?php

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}

?>
</main> <!-- /container -->

	<div class="alert alert-success h6" role="alert">
        <footer class="container">
            <?php
            
            if($_SESSION['usuarioAtivo']=='S') $status = ' Sim <span class="glyphicon glyphicon-ok"></span>'; else  $status =  ' Nao <span class="glyphicon glyphicon-remove"></span>';
            
            if($_SESSION['usuarioExcluido']=='S') $excluido = ' Sim <span class="glyphicon glyphicon-ok"></span>'; else $excluido =  ' Nao <span class="glyphicon glyphicon-remove"></span>';
            
            
            echo '<p>Usuário: <b><span class="glyphicon glyphicon-user"></span> '.$_SESSION['usuarioNome'].'</b> | Seu Último Acesso Foi Em: <span class="glyphicon glyphicon-calendar"></span><b> '.datetime_datatempo($_SESSION['usuarioUltimoAcesso']).'</b> | Status: [ Ativado = '.$status.' ] [ Excluido = '.$excluido.' ] Endereço IP: <b>'.$ip.'<p/>'?>
            <?php echo FOOTER; ?>
        </footer>
    </div>

	<script src="js/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>

    <script src="js/bootstrap.min.js"></script>

    <script src="js/main.js"></script>
</body>
</html>