<?php 

include('conexao.php');

if(isset($_GET['deletar'])){
    $id = intval($_GET['deletar']);
    $sql_query = $mysqli->query("SELECT * FROM arquivos WHERE id = '$id'") or die($mysqli->error);
    $arquivo = $sql_query->fetch_assoc();

    if(unlink($arquivo['path'])){
        $deu_certo = $mysqli->query("DELETE FROM arquivos WHERE id = '$id'") or die($mysqli->error);
        if($deu_certo){
            echo "<p>Arquivo exluído com sucesso!</p>";
        }
    }
}

function enviarArquivo($error, $size, $name, $tmp_name){

    include('conexao.php');
    
    if($error){
        die("Falha ao enviar arquivo");
    }

    if($size > 2097152)
        die("O Tamanho do arquivo não pode ultrapssar 2MB");

    $pasta = "arquivos/";
    $nomeDoArquivo = $name;
    $novoNomeArquivo = uniqid();
    $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));

    if($extensao != 'jpg' && $extensao != 'png')
        die("Tipo de arquivo não aceito. Tipos permitidos: jpg e png");

    $path = $pasta . $novoNomeArquivo . "." . $extensao;
    $deu_certo = move_uploaded_file($tmp_name, $path);

    if($deu_certo){
        $mysqli->query("INSERT INTO arquivos (nome, path, data_upload) VALUES ('$nomeDoArquivo', '$path', NOW())") or die($mysqli->error);
        return true;
    } else {
        return false;
    }
}

if(isset($_FILES['arquivos'])){
    $arquivos = $_FILES['arquivos'];
    $tudo_certo = true;
    foreach($arquivos['name'] as $index =>$arq){
        $deu_certo = enviarArquivo($arquivos['error'][$index], $arquivos['size'][$index], $arquivos['name'][$index], $arquivos['tmp_name'][$index]);
        if(!$deu_certo){
            $tudo_certo = false;
        }
    }
    if($tudo_certo){
        echo '<p>Todos os arquivos foram enviados com sucesso!</p>';
    } else {
        echo '<p>Falha ao enviar um ou mais arquivos!</p>';
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
    <title>Upload de múltiplos arquivos PHP</title>
</head>
<body>
    <h1>Upload de Múltiplos Arquivos</h1>
    <form action="" enctype="multipart/form-data" method="POST">
        <p>
            <label for="">Selecione o arquivo: </label>
            <input multiple type="file" name="arquivos[]">
        </p>
        <button type="submit">Enviar</button>
    </form>
        <?php 
            while($arquivo = $sql_query->fetch_assoc()){
                ?>
                <ul style="border: 3px solid black; margin: 30px; padding:10px; list-style-type: none;">
                    <li><img height="50" src="<?php echo $arquivo['path']; ?>" alt=""></li>
                    <li>ID: <?php echo $arquivo['id']; ?></li>
                    <li>Arquivo: <?php echo $arquivo['nome']; ?> </li>
                    <li>Data Envio: <?php echo date("d/m/Y", strtotime($arquivo['data_upload'])); ?> </li>
                    <li><a href="index.php?deletar=<?php echo $arquivo['id']; ?>">Deletar</a></li>
                </ul>
                <?php
                }
                ?>
</body>
</html>