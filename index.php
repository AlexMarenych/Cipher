<?php

include 'db.php';
include 'ip.php';
function file_force_download($file) {
  if (file_exists($file)) {
    // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
    // если этого не сделать файл будет читаться в память полностью!
    if (ob_get_level()) {
      ob_end_clean();
    }
    // заставляем браузер показать окно сохранения файла
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    // читаем файл и отправляем его пользователю
    readfile($file);
    exit;
  }
}
$config = array(
    "digest_alg" => 'sha512',
        "private_key_bits" => 2048,
    "private_key_type" => OPENSSL_KEYTYPE_RSA
);
$keyPair = openssl_pkey_new($config);
$privateKey = NULL;
openssl_pkey_export($keyPair, $privateKey);
$keyDetails = openssl_pkey_get_details($keyPair);
$publicKey = $keyDetails['key'];
$a=ip2long($real_ip);
if(isset($_POST['generate_key']))
{
  $ip=password_hash($a,PASSWORD_DEFAULT);
  if (mysqli_num_rows(mysqli_query($connection,"SELECT * FROM `key111` WHERE `ip` = '$a'"))==0){
  $insert_public_key= mysqli_query($connection,"INSERT INTO key111 (ip,public_key) VALUES ('$ip','$publicKey')");
  echo 'Ваш новый открытый ключ сохранен в базе!';
}else{echo 'Вы уже есть в базе!';}

}
if(isset($_POST['download_key_private']))
{
          $file=fopen("privatekey.txt","w");
          fwrite($file, $_POST['private']);
          fclose($file);
          $private='privatekey.txt';
           file_force_download($private);
}
if(isset($_POST['download_key_public']))
{
 $file1=fopen("publickey.txt","w");
          fwrite($file1, $_POST['public']);
          fclose($file1);
          $public='publickey.txt';
          file_force_download($public);
}


         


?>

<!DOCTYPE html>
<html>
<head>
  <title>CIPHER</title>
  <base id="basetag" href="/jsencrypt/">

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="bin/jsencrypt.js"></script>
  <link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet" type="text/css">
</head>
<body style="background: url('/fon.jpg'); background-size: 100% auto; background-size: cover; font-family: monospace;">
<?php include 'head.php'; ?>

<div class="container" style="opacity: 0.8;">
  <div class="row">
  <div class="panel panel-default">
    <div class="panel-heading"><h1 style="text-align: center; font-size: 70px;"><strong>CIPHER</strong></h1> <span class="input-group-addon"">Ваш ip-адрес: <?php echo $real_ip; ?></span></div>
    <div class="panel-body">
      <div class="col-lg-12">
        <div class="row">
          <div style="text-align: center;"> <h1 style="font-family: monospace;"><strong>CIPHER - новый ресурс для безопасного общения</strong></h1></div>
          <div class="col-lg-6">



            <h2 style="text-align: justify; line-height: 1.5;"> <p>- Мы использовали один из самых надежных алгоритмов шифрования 2048-битный RSA</p> <p>- На сервере хранится только Ваш IP-адрес и открытый ключ </p> <p>- Доступна загрузка секретного ключа в формате txt</p></h2>
          </div>


              <div class="col-lg-6" style="opacity: 1;">
            <form method="LINK" action="/generate.php">
              <h2><input class="btn btn-primary" type="submit" value="Генерация ключей" style="opacity: 1; font-size: 35px; margin-left: 20%;"></h2>
            </form>
            <br>
             <form method="LINK" action="/encrypt.php">
              <h2><input class="btn btn-primary" type="submit" value="Шифрование" style="opacity: 1; font-size: 35px; margin-left: 20%;width: 330px;"></h2>
            </form>
            <br>
             <form method="LINK" action="/decrypt.php">
              <h2><input class="btn btn-primary" type="submit" value="Дешифрование" style="opacity: 1; font-size: 35px; margin-left: 20%; width: 330px;"></h2>
            </form>
          </div>

        </div>
      </div>
    </form>

    </div>
    <?php include 'footer.php'; ?>
  </div>
</div>

</body>
</html>
