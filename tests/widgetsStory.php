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

	<?= printEval($widget->value() === null) ?>


Scenario: Creating a nested widget

	Given a widget with children:
	<?php $widget = new T\NestedWidget(null, null, null, array(), array(), array(
		new T\Widget()
	)); ?>

	The initialization should succeed, returning a nameless nested widget containing a widget:
	<?=  printEval(
		   ($widget->name == null)
		&& (get_class($widget->children[0]) == 'Magnus\Tags\Widget')
	); ?>


Scenario: Creating a form widget with default method

	Given a form widget with no arguments:
	<?php $widget = new T\Form(); ?>

	The initialization should succeed with method being 'post':
	<?= printEval($widget->method == 'post') ?>


Scenario: Creating a form widget with method override

	Given a form widget with no arguments:
	<?php $widget = new T\Form(null, null, null, array(), array('method' =>'patch')); ?>

	The initialization should succeed with method being 'patch':
	<?= printEval($widget->method == 'patch') ?>

	And kwargs should not contain the method:
	<?= printEval(isset($widget->kwargs['method']) === false) ?>


Scenario: Creating an input widget

	Given an input widget:
	<?php $widget = new T\Input('input1'); ?>

	When rendered:
	<?php $renderedWidget = $widget->template(); ?>

	The call should succeed and return an input tag:
	<?= printEval($renderedWidget == '<input type name="input1" id="input1-field"/>') ?>


Scenario: Creating an input widget with extra attributes

	Given an input widget:
	<?php $widget = new T\Input('input1', null, null, array(), array('data-track' => true)); ?>

	When rendered:
	<?php $renderedWidget = $widget->template(); ?>

	The call should succeed and return an input tag:
	<?= printEval($renderedWidget == '<input type name="input1" id="input1-field" data-track="1"/>') ?>


Scenario: Rendering a form widget

	Given a form widget:
	<?php $widget = new T\Form('test', null, null, array(), array(), array(
		new T\Input('field1')
	)); ?>

	When rendered:
	<?php $renderedWidget = $widget->template(); ?>

	The call should succeed and return form markup:
	<?= printEval($renderedWidget == '<form name="test" id="test-field"><input type name="field1" id="field1-field"/></form>'); ?>

<?= "\n\n" ?>