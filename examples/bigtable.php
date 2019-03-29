<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Magnus\Tags as T;

$packageRoot = dirname(__DIR__);
require_once $packageRoot . '/autoload.php';

/* Big disclaimer, this is only as convoluted as it is due to generating values
 * on the fly instead of reading out from existing record information with
 * known keys. Ordinarily, you would have an associative array with the columns
 * labelled appropriately. PHP lacks the syntax to do inline for ... in loops.
 */

function bigtable() {
	$t = new T\Tag();

	$x = $y = 'a';
	$tableRows = array();
	for ($i=0; $i < 10; $i++) {
		$row = array();
		for ($j=0; $j < 10; $j++) { 
			$row[] = $t->td(array($x . $y));
			$y++;
		}
		$tableRows[] = $t->tr($row);
		$x++;
	}

	return $t->table($tableRows);
}

//$bigTable = bigtable();
//echo $bigTable->render();

function realistictable($tableData) {
	$t = new T\Tag();
	$tableRows = array();

	foreach ($tableData as $row) {
		$tableRows[] = $t->tr(array(
			$t->td(array((string) $row['a'])),
			$t->td(array((string) $row['b'])),
			$t->td(array((string) $row['c'])),
			$t->td(array((string) $row['d'])),
			$t->td(array((string) $row['e'])),
			$t->td(array((string) $row['f'])),
			$t->td(array((string) $row['g'])),
			$t->td(array((string) $row['h'])),
			$t->td(array((string) $row['i'])),
			$t->td(array((string) $row['j']))
		));
	}

	return $t->table($tableRows);

}

$tableData = array_fill(0, 10, array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5, 'f' => 6, 'g' => 7, 'h' => 8, 'i' => 9, 'j' => 10));

$realisticTable = realistictable($tableData);
echo $realisticTable->render();