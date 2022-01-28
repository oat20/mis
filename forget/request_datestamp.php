<?php
date_default_timezone_set('Asia/Bangkok');

$myfile = fopen("request_datestamp.csv", "a+") or die("Unable to open file!");
$txt = "Mickey Mouse,".date('Y-m-d H:i:s')."\n";
fwrite($myfile, $txt);
$txt = "Minnie Mouse,".date('Y-m-d H:i:s')."\n";
fwrite($myfile, $txt);
fclose($myfile);

/*$list = array (
  array("Peter@mail.com", date('Y-m-d H:i:s')),
  array("Glenn@mail.com", date('Y-m-d H:i:s'))
);

$file = fopen("request_datestamp.csv","a+");

foreach ($list as $line) {
  fputcsv($file, $line, ',');
}

fclose($file);*/
?>