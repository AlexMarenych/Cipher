<?php
$config_db=array(
  'title'=>'CIPHER',
  'db'=>array(
    'server'=>'localhost',
    'username'=>'root',
    'password'=>'',
    'name'=>'diplom'
  )

);
$connection=mysqli_connect(
  $config_db['db']['server'],
  $config_db['db']['username'],
  $config_db['db']['password'],
  $config_db['db']['name']
);

?>