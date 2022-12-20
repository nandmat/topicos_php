<?php 

include('conexao.php');

if(isset($_FILES['arquivo'])){
    $arquivo = $_FILES['arquivo'];

    if($arquivo['error']){
        die("Falha ao enviar arquivo");
    }

    if($arquivo['size'] > 2097152)
        die("O Tamanho do arquivo não pode ultrapssar 2MB");

    $pasta = "arquivos/";
    $nomeDoArquivo = $arquivo['name'];
    $novoNomeArquivo = uniqid();
    $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));

    if($extensao != 'jpg' && $extensao != 'png')
        die("Tipo de arquivo não aceito. Tipos permitidos: jpg e png");

    $path = $pasta . $novoNomeArquivo . "." . $extensao;
    $deu_certo = move_uploaded_file($arquivo['tmp_name'], $path);

    if($deu_certo){
        $mysqli->query("INSERT INTO arquivos (nome, path, data_upload) VALUES ('$nomeDoArquivo', '$path', NOW())") or die($mysqli->error);
        echo "<p>
                Arquivo enviado com sucesso! Para acessá- lo, 
                <a target=\"_blank\" href=\"arquivos/$novoNomeArquivo.$extensao\">
                clique aqui.
                </a>
            </p>";
    } else {
        echo "<p>Falha ao enviar arquivo</p>";
    }
    
}

$sql_query = $mysqli->query("SELECT * FROM arquivos") or die($mysqli->error);

//1024 bytes = 1KB
//1024 KB = 1MB

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de arquivos PHP</title>
</head>
<body>
    <form action="" enctype="multipart/form-data" method="POST">
        <p>
            <label for="">Selecione o arquivo: </label>
            <input type="file" name="arquivo">
        </p>
        <button type="submit">Enviar</button>
    </form>

    <ul>
        <?php 
            while($arquivo = $sql_query->fetch_assoc()){
                ?>
                <li style="border: 3px solid black; margin: 3px;"><img height="50" src="<?php echo $arquivo['path']; ?>" alt=""></li>
                <li style="border: 3px solid black;">Arquivo:<?php echo $arquivo['nome']; ?> </li>
                <li style="border: 3px solid black;">Data Envio:<?php echo date("d/m/Y", strtotime($arquivo['data_upload'])); ?> </li>
                <?php
                }
                ?>
    </ul>
</body>
</html>