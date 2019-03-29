<?php

use Magnus\Tags as T;
$packageRoot = dirname(__DIR__);
require_once $packageRoot . '/autoload.php';

// Test Helpers
function printEval($condition) {
	// Just throw your conditional statement in there and it'll auto-var_export, just to make it look nicer
	return var_export($condition, true);
}
?>

Feature: Magnus Widgets
		 As a developer
		 I want to build reusable widgets
		 To create consistent and simplified markup

Scenario: Creating a widget

	Given a widget with no arguments:
	<?php $widget = new T\Widget(); ?>

	The initialization should succeed, returning an empty widget:
	<?=  printEval(
		   ($widget->name == null)
		&& ($widget->title == null)
		&& ($widget->data == array())
		&& ($widget->kwargs == array())
		&& ($widget->default == null)
	); ?>

<?= "\n\n" ?>