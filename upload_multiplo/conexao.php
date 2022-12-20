<?php 

$host = 'localhost';
$dbname = 'upload';
$user = 'root';
$pass = '';

$mysqli = new mysqli($host, $user, $pass, $dbname);
if($mysqli->connect_errno)
{
    die('Falha na conexão cm o banco de dados');
}

// function formatar_data($data){
//     return implode('/', array_reverse(explode('-', $data)));
// }

?>