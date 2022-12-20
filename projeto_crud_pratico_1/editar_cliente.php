<?php 

    include('conexao.php');
    $id = intval($_GET['id']);
    function limpar_texto($str)
    {
        return preg_replace("/[^0-9]/", "", $str);
    }

    
    if(count($_POST) > 0)
    {

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
            $sql_code = "UPDATE clientes SET
            nome = '$nome',
            email = '$email',
            telefone = '$telefone',
            nascimento = '$nascimento'
            WHERE id = '$id'";
            $input_db = $mysqli->query($sql_code) or die($mysqli->error);

            if($input_db) {
                echo "<p><b>Cliente atualizado com sucesso!</b></p>";
                unset($_POST);
            }
        }
    }

    $sql_cliente = "SELECT * FROM clientes WHERE id = '$id'";
    $query_cliente = $mysqli->query($sql_cliente) or die($mysqli->error);
    $cliente = $query_cliente->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Cliente</title>
</head>

<body>
    <a href="/clientes.php">Voltar para a lista</a>
    <form action="" method="POST">
        <p>
            <label>Nome:</label>
            <input  value="<?php echo $cliente['nome']; ?>" type="text" name="nome"><br>
        </p>
        <p>
            <label>Email:</label>
            <input value="<?php echo $cliente['email']; ?>" type="text" name="email"><br>
        </p>
        <p>
            <label>Telefone</label>
            <input value="<?php if(!empty($cliente['telefone'])) echo telefone_form($cliente['telefone']); ?>" placeholder="(11) 98888-8888" type="text" name="telefone"><br>
        </p>
        <p>
            <label>Data de nascimento:</label>
            <input value="<?php if(!empty($cliente['nascimento'])) echo data_form($cliente['nascimento']); ?>" type="text" name="nascimento"><br>
        </p>
        <p>
            <button type="submit">Alterar</button>
        </p>
    </form>
</body>

</html>