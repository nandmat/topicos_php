<?php 

include('conexao.php');

if(!isset($_SESSION))
    session_start();

if(!isset($_SESSION['usuario']))
    die('Você não está logado. <a href="login.php">Clique aqui</a> para logar.');

if(isset($_POST['email'])){

    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $mysqli->query("INSERT INTO senhas (email, senha) VALUES ('$email', '$senha')");


}

$id = $_SESSION['usuario'];
$sql_query = $mysqli->query("SELECT * FROM senhas WHERE id = '$id'") or die($mysqli->error);
$usuario = $sql_query->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>Bem vindo, <?php echo $usuario['nome']; ?></p>
    <h1>Cadastro de Usuários</h1>
    <form action="" method="post">
        <p>
            <label for="">Email</label>
            <input type="text" name="email">
        </p>
        <p>
            <label for="">Senha</label>
            <input type="text" name="senha">
        </p>
        <button type="submit">Cadastrar senha</button>
    </form>
    <p>
        <a href="logout.php">Sair</a>
    </p>
</body>
</html>