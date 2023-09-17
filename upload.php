<?php
    require "vendor/autoload.php";
    include('config.php');

    use Aws\S3\S3Client;

    try {       

        if (!isset($_FILES['file'])) {
            throw new Exception("File not uploaded", 1);
        }

        $s3 = new S3Client([
            'version' => 'latest',
            'region' => 'us-east-1',
            'credentials' => [
                'key' => ACCESS_KEY,
                'secret' => SECRET_KEY,
            ],
        ]);

        $response = $s3->putObject(array(
            'Bucket' => BUCKET_NAME,
            'Key'    => $_FILES['file']['name'],
            'SourceFile' => $_FILES['file']['tmp_name'],
            'ACL' => 'public-read',
        ));

        $_SESSION['msg'] = "Objeto postado com sucesso, endereco <a href='{$response['ObjectURL']}'>{$response['ObjectURL']}</a>";

        header("location: index.php");

    } catch(Exception $e) {
        echo "Erro > {$e->getMessage()}";
    }

?>