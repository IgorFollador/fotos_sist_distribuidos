<?php 
  require 'vendor/autoload.php';
  include('config.php');

  use Aws\S3\S3Client;
  #ini_set('display_errors',1);
  #ini_set('display_startup_erros',1);
  #error_reporting(E_ALL);
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

  <?php
    $s3 = new S3Client([
      'version' => 'latest',
      'region' => 'us-east-1',
      'credentials' => [
          'key' => ACCESS_KEY,
          'secret' => SECRET_KEY,
      ],
    ]);

    $contents = $s3->listObjectsV2([
      'Bucket' => BUCKET_NAME,
    ]);

    try {
      $contents = $s3->listObjectsV2([
          'Bucket' => BUCKET_NAME,
      ]);

      if ($contents && isset($contents['Contents'])) {
        foreach ($contents['Contents'] as $contents) {
            $imageUrl = $s3->getObjectUrl(BUCKET_NAME, $contents['Key']);
            echo "<img src='$imageUrl' alt='Imagem'><br>";
        }
      } else {
          echo "Nenhum objeto encontrado no bucket.";
      }
    
    } catch (Exception $exception) {
        echo "Failed to list objects in  with error: " . $exception->getMessage();
        exit("Please fix error with listing objects before continuing.");
    }
  ?>

  <form action="upload.php" method="POST" enctype="multipart/form-data">
      <input type="text" name="description" />
      <input type="file" name="file" />
      <input type="submit" value="Enviar"/>
  </form>
</body>
</html>