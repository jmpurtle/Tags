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
	<?= printEval($renderedWidget == '<form name="test" id="test-form"><input type name="field1" id="field1-field"/></form>'); ?>


Scenario: Rendering a fieldset widget

	Given a fieldset widget:
	<?php $widget = new T\FieldSet('test', null, null, array(), array(), array(
		new T\Input('field1')
	)); ?>

	When rendered:
	<?php $renderedWidget = $widget->template(); ?>

	The call should succeed and return fieldset markup:
	<?= printEval($renderedWidget == '<fieldset id="test-set"><input type name="field1" id="field1-field"/></fieldset>'); ?>


Scenario: Creating label widget

	Given a label widget:
	<?php $widget = new T\Label('input1', 'My Fancy Input', null, array(), array('for' => 'input1')); ?>

	When rendered:
	<?php $renderedWidget = $widget->template(); ?>

	The call should succeed and return a label tag:
	<?= printEval($renderedWidget == '<label for="input1-field">My Fancy Input</label>') ?>


Scenario: Creating a boolean input widget

	Given a boolean input widget:
	<?php $widget = new T\BooleanInput('bool1', 'A neat bool input', null, array(), array('checked' => true)); ?>

	When rendered:
	<?php $renderedWidget = $widget->template(); ?>

	The call should succeed and return a label tag:
	<?= printEval($renderedWidget == '<div><input type name="bool1" id="bool1-field" checked="1"></input><label for="bool1-field">A neat bool input</label></div>') ?>


Scenario: Creating a link widget

	Given a link widget:
	<?php $widget = new T\Link('awesome', 'An awesome link'); ?>

	When rendered:
	<?php $renderedWidget = $widget->template(); ?>

	The call should succeed and return a link tag:
	<?= printEval($renderedWidget == '<a id="awesome-link">An awesome link</a>'); ?>


Scenario: Creating a checkbox widget
	
	Given a checkbox widget:
	<?php $widget = new T\CheckboxField('test'); ?>

	When rendered:
	<?php $renderedWidget = $widget->template(); ?>

	The call should succeed and return a complete checkbox set:
	<?= printEval($renderedWidget == '<div><input type="hidden" name="test" id="test-hidden" value/><input type="checkbox" name="test" id="test-field" checked/></div>') ?>


Scenario: Creating a textarea widget

	Given a textarea widget:
	<?php $widget = new T\TextArea('test', null, null, array(), array('test' => 'textarea content')); ?>

	When rendered:
	<?php $renderedWidget = $widget->template(); ?>

	The call should succeed and return a textarea containing content:
	<?= printEval($renderedWidget == '<textarea name="test" id="test-field">textarea content</textarea>') ?>

<?= "\n\n" ?>