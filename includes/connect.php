<?php
$linkdb=mysqli_connect("localhost","tp1", "1337master");
mysqli_select_db($linkdb,"mddTP1") or die ("Base Introuvable");
mysqli_query($linkdb,"SET NAMES UTF8");
?>