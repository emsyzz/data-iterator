<?php
header('Content-Type: text/html; charset=utf-8');

include('/class/mysql.php');
include('/class/data.php');
include('/class/data_iterator.php');
include('/class/response.php');

$start = microtime();

mysqlObj::gi()->newConnection()->setDatabase('test_source');

$query = 'SELECT * FROM data';
	var_dump($query);

$res = mysqlObj::multipleRows($query);
echo 'Returned '. $res->count() .' rows<hr />';
foreach($res as $pk => $row) {
	var_dump($pk,$row);
	echo 'echo $row->title; '.$row->title;
}

echo '<hr />'. round(microtime() - $start,3);