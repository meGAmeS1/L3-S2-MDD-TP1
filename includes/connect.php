<?php
$linkdb=mysqli_connect($host, $account, $password);
mysqli_select_db($linkdb,$dbname) or die ("Base Introuvable");
mysqli_query($linkdb,"SET NAMES UTF8");
?>