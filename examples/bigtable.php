<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Magnus\Tags as T;

$packageRoot = dirname(__DIR__);
require_once $packageRoot . '/autoload.php';

function bigtable() {
	$t = new T\Tag();

	return $t->table(array_fill(0, 10,
		$t->tr(array_fill(0, 10,
			$t->td(array('x'))
		))
	));
}

$bigTable = bigtable();
echo $bigTable->render();
