<?php

include 'db.php';
include 'ip.php';
  $a=ip2long($real_ip);
if(isset($_POST['encrypt_massege']))
{
  $public=mysqli_query($connection,"SELECT * FROM `key111` WHERE `ip`=$a");
  $publicKey=mysqli_fetch_assoc($public);
  $pk  = openssl_get_publickey($publicKey['public_key']);
  openssl_public_encrypt($_POST['text'], $encrypted, $pk);
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
  <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="/jquery.input-ip-address-control.js"></script>
<script>
    $(function(){
        $('#ipv4').ipAddress();
    });
  </script>
  <link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet" type="text/css">
</head>
<body style="background: url('/fon.jpg'); background-size: 100% auto; background-size: cover; font-family: monospace;">
<?php include 'head.php'; ?>

<div class="container">
  <div class="row">
  <div class="panel panel-default">
    <div class="panel-heading"><h1 style="text-align: center;">Зашифровать сообщение</h1>       <span class="input-group-addon"">Ваш ip-адрес: 188.243.173.111 <!--<?php echo $real_ip; ?>--></span></div>
    <div class="panel-body" >
      <div class="col-lg-2" style="height: 1000px;">
        <div class="btn-group" >
          <div class="input-group">
            <form method="POST" enctype="multipart/form-data">
        
              Введите IP-адрес: <input type="text" name="ip" id="ipv4" class="form-control">
              <br>


          </div>
        </div>
        <br>&nbsp;<br>
        <button id="generate" class="btn btn-primary" name="encrypt_massege">Зашифровать</button>
        <br>&nbsp;<br>
      </div>
      <div class="col-lg-10">
        <div class="row">
          <div class="col-lg-6">
            <label for="privkey">Истинное сообщение</label><br/>
            <small>
               <textarea id="privkey" rows="15" style="width:100%" name="text"> </textarea>
            </small>    
          </div>
          <div class="col-lg-6">
            <label for="pubkey">Зашифрованное сообщение</label><br/>
            <small><textarea id="pubkey" rows="15" style="width:100%" readonly="readonly"><?php
        echo chunk_split(base64_encode($encrypted)); ?> </textarea></small>
          </div>
        </div>
      </div>
    </div>
  </form>
  </div>
</div>

</body>
</html>
