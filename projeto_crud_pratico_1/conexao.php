<?php 

$host = 'localhost';
$db = 'crud_clientes';
$user = 'root';
$pass = '';

$mysqli = new mysqli($host, $user, $pass, $db);
if($mysqli->connect_errno)
{
    die('Falha na conexão cm o banco de dados');
}

function data_form($data) {
    return implode('/', array_reverse(explode('-', $data)));
}

function telefone_form($telefone) {

    if (!empty($telefone)) {
        $ddd = substr($telefone, 0, 2);
        $parte1 = substr($telefone, 2, 5);
        $parte2 = substr($telefone, 7);
        
        return "($ddd) $parte1-$parte2";
    }
}