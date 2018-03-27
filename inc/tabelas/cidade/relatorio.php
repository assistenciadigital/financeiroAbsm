<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "crud";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$uf = "SELECT distinct uf from cidade order by uf";
$result_uf = $conn->query($uf);

if ($result_uf->num_rows > 0) {
    // output data of each row
    while($row_uf = $result_uf->fetch_assoc()) {
        echo 'UF: '. $row_uf['uf'].'<p>';
		
		$cidade = "SELECT descricao, uf from cidade where uf = '".$row_uf['uf']."' order by uf, descricao";
		$result_cidade = $conn->query($cidade);
		$i = 1;
		while($row_cidade = $result_cidade->fetch_assoc()) {
		if (strlen($i)==1){$s='00'.$i;}
		if (strlen($i)==2){$s='0'.$i;}
		if (strlen($i)==3){$s=''.$i;}
		
		echo $s.": " . $row_cidade["descricao"]. " - UF: " . $row_cidade["uf"]. "<br>";
		$i++;
		}
		echo '<p>Total ['.$row_uf['uf'].']: '.$result_cidade->num_rows.' Registros<p>';
	}
	echo 'UF: '.$result_uf->num_rows;
} else {
    echo "0 results";
}
$conn->close();
?>