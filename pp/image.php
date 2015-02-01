<?php
if(strpos(strtolower($_GET['i']),".jpg")>0)
header('content-type: image/jpeg');
else if (strpos(strtolower($_GET['i']),".png")>0)
header('content-type: image/png');
else if(strpos(strtolower($_GET['i']),".gif")>0)
header('content-type: image/jpeg');
$img = preg_replace('/[^0-9a-z\.-_]/', '_', $_GET['i']);
readfile('http://celtest1.lnu.se:3030'.$img);
?>