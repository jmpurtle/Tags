<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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


Scenario: Getting the value of a widget

	Given a widget with data in it corresponding to this widget:
	<?php $widget = new T\Widget('foo', null, null, array('foo' => 'bar')); ?>

	<?= printEval($widget->value() == 'bar') ?>

Scenario: Getting a value that does not exist on a widget

	Given a widget with data in it corresponding to this widget:
	<?php $widget = new T\Widget('foo', null, null, array('baz' => 'bar')); ?>

	<?= printEval($widget->value() == null) ?>

<?= "\n\n" ?>