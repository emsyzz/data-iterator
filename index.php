<?php
header('Content-Type: text/html; charset=utf-8');

include('/class/mysql.php');
include('/class/data.php');
include('/class/dataIterator.php');
include('/responders/testResponse.php');

$start = microtime();

mysqlObj::gi()->newConnection()->setDatabase('test_source');

$query = 'SELECT * FROM data';
	var_dump($query);

$res = mysqlObj::multipleRows($query);
echo 'Returned '. $res->count() .' rows<hr />';
foreach($res->getInstance('test') as $pk => $row) {
    if(!$row->tags) $row->tags = array('SF');
    var_dump($row->tags);
	echo 'echo $row->title;<br />&nbsp;&nbsp;&nbsp;'. $row->title .'<br />';
	echo 'echo $row->title();<br />&nbsp;&nbsp;&nbsp;'. $row->title() .'<br />';
	echo 'echo $row->title(\'bold\');<br />&nbsp;&nbsp;'. $row->title('bold') .'<hr />';
}

echo round(microtime() - $start, 3);