<?php include('conexao.php'); 

$sql_clientes = "SELECT * FROM clientes";
$query_clientes = $mysqli->query($sql_clientes) or die($mysqli->error);
$num_clientes = $query_clientes->num_rows;

?>
<DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=h1, initial-scale=1.0">
    <title>Clientes</title>
</head>
<body>
    <h1>Lista de Clientes</h1>
    <p>Estes são os clientes cadastrados no sistema: </p>
    <table border="1" cellpadding="10">
        <thead>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Nascimento</th>
            <th>Data de Cadastro</th>
            <th>Ações</th>
        </thead>
        <tbody>
            <?php if($num_clientes == 0) { ?>
                <tr>
                    <td colspan="7">Nenhum cliente cadastrado</td>
                </tr>
            <?php } else { 
                while($cliente = $query_clientes->fetch_assoc()) {
                    
                    $telefone = "Não informado";
                    if (!empty($cliente['telefone'])) {
                        $telefone = telefone_form($cliente['telefone']);
                    }

                    $nascimento = "Não informado";
                    if(!empty($cliente['nascimento'])){
                    $nascimento = data_form($cliente['nascimento']);
                    }

                    $data_cadastro = date('d/m/Y:H:i', strtotime($cliente['data']));
                ?>
            <tr>
                <td><?php echo $cliente['id'] ?></td>
                <td><?php echo $cliente['nome'] ?></td>
                <td><?php echo $cliente['email'] ?></td>
                <td><?php echo $telefone ?></td>
                <td><?php echo $nascimento ?></td>
                <td><?php echo $data_cadastro ?></td>
                <td>
                    <a href="editar_cliente.php?id=<?php echo $cliente['id'] ?>">Editar</a>
                    <a href="deletar_cliente.php?id=<?php echo $cliente['id'] ?>">Deletar</a>
                </td>
            </tr>
            <?php }} ?>
        </tbody>
    </table>
</body>
</html>