<?php

include 'db.php';
include 'ip.php';

if(isset($_POST['decrypt_massege']))
{
  $pk  = openssl_get_privatekey($_POST['privatekey']);
  openssl_private_decrypt(base64_decode($_POST['text']), $out, $pk);
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
    <div class="panel-heading"><h1 style="text-align: center;">Расшифровать сообщение</h1>  <span class="input-group-addon"">Ваш ip-адрес: 217.66.152.223 <!--<?php echo $real_ip; ?>--></span></div>
    <div class="panel-body">
      <div class="col-lg-2" style="height: 1000px;">
        <div class="btn-group">
          <div class="input-group">
            <form method="POST" enctype="multipart/form-data">
             
          </div>
        </div>
        <br>&nbsp;<br>
        <button id="generate" class="btn btn-primary" name="decrypt_massege">Расшифровать</button>
        <br>&nbsp;<br>

        <br>&nbsp;<br>
      </div>
      <div class="col-lg-10">
        <div class="row">
          <!--<div class="col-lg-6">
            
            <label for="privkey">Закрытый ключ</label><br/>
            <small>
               <textarea id="privkey" rows="15" style="width:100%" name="privatekey">


               </textarea>
            </small>
          </div>-->
          <div class="col-lg-6">
            <label for="pubkey">Зашифрованное сообщение</label><br/>
            <small>
              <textarea id="pubkey" rows="15" style="width:100%" name="text">
              

            </textarea></small>
               Выберите закрытый ключ:
        <input type="file">
          </div>
          <div class="col-lg-6">
            <label for="pubkey">Истинное сообщение</label><br/>
            <small>
              <textarea id="pubkey" rows="15" style="width:100%">
              <?php
                echo $out;
              ?>
            </textarea></small>
          </div>
        </div>
      </div>
    </div>
  </form>
     <?php include 'footer.php'; ?>
  </div>
</div>

</body>
</html>
