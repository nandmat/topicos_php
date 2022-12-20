<?php 

    function limpar_texto($str)
    {
        return preg_replace("/[^0-9]/", "", $str);
    }

if(!empty($_POST['click'])) {
    if(count($_POST) > 0)
    {
        include('conexao.php');

        $erro = false;
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];
        $nascimento = $_POST['nascimento'];

        if(empty($nome)) {
            $erro = 'Preencha o nome';
        }
        if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
            $erro = 'Preencha o email';
        }

        if(!empty($nascimento)) {
            $pedacos = explode('/', $nascimento);
            if(count($pedacos) == 3) {
                $nascimento = implode('-', array_reverse($pedacos));
            } else {
                $erro = "A DATA DE NASCIMENTO DEVE SEGUIR O PADRÃO DIA/MES/ANO";
            }
            
        }

        if(empty($telefone)) {
            $telefone = limpar_texto($telefone);
            if(strlen($telefone) != 11) {
                $erro = "O telefone deve ser preenchido no padrão: (11) 98888-8888";
            }
        }

        if ($erro) {
            echo "<p><b>ERRO: $erro</b></p>";
        } else {
            $sql_code = "INSERT INTO clientes (nome, email, telefone, nascimento, data)
            VALUES ('$nome', '$email', '$telefone', '$nascimento', NOW())";
            $input_db = $mysqli->query($sql_code) or die($mysqli->error);

            if($input_db) {
                echo "<p><b>Cliente cadastrado com sucesso!</b></p>";
                unset($_POST);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Cliente</title>
</head>

<body>
    <a href="/clientes.php">Voltar para a lista</a>
    <form action="" method="POST">
        <p>
            <label>Nome:</label>
            <input  value="<?php if(isset($_POST['nome'])) echo $_POST['nome']; ?>" type="text" name="nome"><br>
        </p>
        <p>
            <label>Email:</label>
            <input value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" type="text" name="email"><br>
        </p>
        <p>
            <label>Telefone</label>
            <input value="<?php if(isset($_POST['telefone'])) echo $_POST['telefone']; ?>" placeholder="(11) 98888-8888" type="text" name="telefone"><br>
        </p>
        <p>
            <label>Data de nascimento:</label>
            <input value="<?php if(isset($_POST['nascimento'])) echo $_POST['nascimento']; ?>" type="text" name="nascimento"><br>
        </p>
        <p>
            <button type="submit" name="click">Cadastrar Cliente</button>
        </p>
    </form>
</body>

</html>