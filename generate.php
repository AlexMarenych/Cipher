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
  if (mysqli_num_rows(mysqli_query($connection,"SELECT * FROM `key111` WHERE `ip` = '$a'"))==0){
  $insert_public_key= mysqli_query($connection,"INSERT INTO key111 (ip,public_key) VALUES ('$a','$publicKey')");
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

<div class="container">
  <div class="row">
  <div class="panel panel-default">
    <div class="panel-heading"><h1 style="text-align: center;">Генератор ключей RSA</h1> <span class="input-group-addon"">Ваш ip-адрес: 188.243.173.111 <!--<?php echo $real_ip; ?>--></span></div>
    <div class="panel-body">
      <div class="col-lg-2">
        <div class="btn-group">
          <div class="input-group">
            <form method="POST" enctype="multipart/form-data">

          </div>
        </div>
        

      </div>
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-5">
            <label for="privkey">Открытый ключ</label><br/>
            <small>
              <textarea id="privkey" rows="15" style="width:100%" readonly="readonly" name="public"> <?php
          if(isset($_POST['generate_key']))
          {
          echo $publicKey;
          } ?> </textarea>
            </small>
          </div>
           <div class="col-lg-2" style="margin-top: 120px; margin-right: -30px;">
                      <button id="generate" class="btn btn-primary" name="generate_key">Генерация</button>
                    </div>
          <div class="col-lg-5">
            <label for="pubkey">Закрытый ключ</label><br/>
            <small><textarea id="pubkey" rows="15" style="width:100%" readonly="readonly" name="private"><?php
          if(isset($_POST['generate_key']))
          {
          echo $privateKey;
          } ?> </textarea></small>

          </div>
          </div>
      </div>
      <div class="col-lg-10">
        <div class="row">
          <div style="float: left; margin-left: 150px;">
           <input class="btn btn-primary"  type="submit" name="download_key_public" value="Загрузить открытый ключ">
         </div>
         <div style="float: right;">
            <input class="btn btn-primary"  type="submit" name="download_key_private" value="Загрузить закрытый ключ">
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
