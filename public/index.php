<?php

session_start();

require 'vendor/autoload.php';
include('config.php');
include('database.php');

use Aws\S3\S3Client;


// ini_set('display_errors', 1);
// error_reporting(E_ALL);


$s3 = new S3Client([
    'version' => 'latest',
    'region' => 'us-east-1',
    'credentials' => [
        'key' => ACCESS_KEY,
        'secret' => SECRET_KEY,
    ],
]);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aplicação de fotos</title>
</head>
<body>

  <?php
    if (isset($_SESSION['msg'])){
      echo $_SESSION['msg'];
    }
  ?>

  <h1>Fotos URI</h1>
  <div>
    <h2>Usuários:</h2>
    <ul>
    <?php
      try {
        $result = mysqli_query($conn, 'SELECT * FROM pessoa');
        if ($result) {
          foreach ($result as $data) {
            echo "<li>ID: {$data['id']} | NOME: {$data['nome']}</li>";
          }
        } else {
          echo "Erro na consulta ao banco de dados.";
        }
      } catch (\Throwable $th) {
        echo "Error: " . $th->getMessage();
      }
    ?>
    </ul>
  </div>

  <?php
    try {
      $contents = $s3->listObjectsV2(['Bucket' => BUCKET_NAME]);

      if ($contents && isset($contents['Contents'])) {
        foreach ($contents['Contents'] as $object) {
            $imageUrl = $s3->getObjectUrl(BUCKET_NAME, $object['Key']);
            echo "<img src='$imageUrl' alt='Imagem'><br>";
        }
      } else {
          echo "Nenhum objeto encontrado no bucket.";
      }
    } catch (Exception $exception) {
        echo "Falha ao listar objetos: " . $exception->getMessage();
    }
  ?>

  <form action="upload.php" method="POST" enctype="multipart/form-data">
      <input type="text" name="description" />
      <input type="file" name="file" />
      <input type="submit" value="Enviar"/>
  </form>
</body>
</html>