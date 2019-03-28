<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$packageRoot = dirname(__DIR__);
require_once $packageRoot . '/autoload.php';

// Test Helpers
function printEval($condition) {
	// Just throw your conditional statement in there and it'll auto-var_export, just to make it look nicer
	return var_export($condition, true);
}
?>
Feature: Magnus Tags
		 As a developer
		 I want to write DSL
		 So I can avoid writing lots of HTML and logic markup


Scenario: Creating a Fragment

	Given an initialized Fragment with no arguments:
	<?php $fragment = new Magnus\Tags\Fragment(); ?>

	The initialization should succeed, providing a blank Fragment:
	<?=  printEval(
		   ($fragment->name == null)
		&& ($fragment->data == array())
		&& ($fragment->logicProps == array())
		&& ($fragment->kwargs == array())
	); ?>


Scenario: Creating a Fragment with data

	Given an initialized Fragment with arguments:
	<?php $fragment = new Magnus\Tags\Fragment('thud', array('foo'), array('wibble' => 'wobble'), array('baz' => 'qux')); ?>

	The initialization should succeed, providing a Fragment with a set data property:
	<?= printEval($fragment->data == array('foo')) ?>

	And a set logicProps property:
	<?= printEval($fragment->logicProps == array('wibble' => 'wobble')) ?>

	And a set kwargs property:
	<?= printEval($fragment->kwargs == array('baz' => 'qux')) ?>

	And a name of thud:
	<?= printEval($fragment->name == 'thud') ?>


Scenario: Printing out a Fragment with data

	Given an initialized Fragment with arguments:
	<?php $fragment = new Magnus\Tags\Fragment('thud', array('foo'), array('wibble' => 'wobble'), array('baz' => 'qux')); ?>

	The initialization should succeed and printing out the Fragment should give a starting tag:
	<?php
	echo printEval((string) $fragment == '<thud baz="qux">');
	?>


Scenario: Clearing out an initialized Fragment with data
	
	Given an initialized Fragment with arguments:
	<?php $fragment = new Magnus\Tags\Fragment('thud', array('foo'), array('wibble' => 'wobble'), array('baz' => 'qux')); ?>

	When cleared:
	<?php $fragment->clear(); ?>

	The call should succeed and return a fragment with only the name remaining intact:
	<?= printEval((string) $fragment == '<thud>'); ?>


Scenario: Extracting subclass keys

	Given an initialized Fragment with arguments:
	<?php $fragment = new Magnus\Tags\Fragment('thud', array('foo'), array('wibble' => 'wobble'), array('baz' => 'qux')); ?>

	When a kwargs key is requested:
	<?php $kwargsElement = $fragment->baz; ?>

	The call should succeed and return the value of baz:
	<?= printEval($kwargsElement == 'qux'); ?>

	And when a LogicProps key is requested:
	<?php $logicProp = $fragment->wibble; ?>

	The call should succeed and return the value of wibble:
	<?= printEval($logicProp == 'wobble'); ?>


Scenario: Extracting default subclass key value

	Given an initialized Fragment with arguments:
	<?php $fragment = new Magnus\Tags\Fragment('thud', array('foo'), array('wibble' => 'wobble'), array('baz' => 'qux')); ?>

	When a kwargs key that does not exist is requested:
	<?php $kwargsElement = $fragment->quux; ?>

	The call should succeed and return null:
	<?= printEval($kwargsElement === null); ?>

	And when a LogicProps key that does not exist is requested:
	<?php $logicProp = $fragment->womble; ?>

	The call should succeed and return null:
	<?= printEval($logicProp === null); ?>


Scenario: Creating a tag

	Given an initialized Tag with only a name:
	<?php $tag = new Magnus\Tags\Tag('thud'); ?>

	The initialization should succeed and printing out the Tag should give a starting tag:
	<?php
	echo printEval((string) $tag == '<thud>');
	?>


Scenario: Overriding initialization time values

	Given an initialized Tag with arguments:
	<?php $tag = new Magnus\Tags\Tag('thud', array('foo'), array('wibble' => 'wobble'), array('baz' => 'qux')); ?>

	When invoked with new values:
	<?php $newTag = $tag(array('wibble' => 'wobble'), array('baz' => 'wibble')); ?>

	The invocation should succeed, returning a tag with the updated values:
	<?= printEval((string) $newTag == '<thud baz="wibble">'); ?>
	

Scenario: Working with child elements

	Given an initialized Tag with arguments including text children:
	<?php $tag = new Magnus\Tags\Tag('p', array('foo')) ?>

	When rendered:
	<?php $tagRendered = $tag->render(); ?>

	The call should succeed, returning a paragraph element with foo in it:
	<?= printEval($tagRendered == '<p>foo</p>'); ?>


Scenario: Nested Tags

	Given an initialized Tag with children:
	<?php
	$layout = new Magnus\Tags\Tag('div', array(
		new Magnus\Tags\Tag('span', array('bar'))
	));
	?>

	When rendered:
	<?php $layoutRendered = $layout->render(); ?>

	The call should succeed, returning a div and span with content:
	<?= printEval($layoutRendered == '<div><span>bar</span></div>'); ?>


Scenario: Mixed nested Tags

	Given an initialized Tag with mixed children:
	<?php
	$layout = new Magnus\Tags\Tag('div', array(
		'foo',
		new Magnus\Tags\Tag('span', array('bar'))
	));
	?>

	When rendered:
	<?php $layoutRendered = $layout->render(); ?>

	The call should succeed, returning a div, text and span with content:
	<?= printEval($layoutRendered == '<div>foo<span>bar</span></div>'); ?>


Scenario: Mixed nested Tags with voids

	Given an initialized Tag with mixed children:
	<?php
	$layout = new Magnus\Tags\Tag('fieldset', array(
		new Magnus\Tags\Tag('label', array('foo')),
		new Magnus\Tags\Tag('input', array('bar'), array('void' => true))
	));
	?>

	When rendered:
	<?php $layoutRendered = $layout->render(); ?>

	The call should succeed, returning a fieldset, label and input:
	<?= printEval($layoutRendered == '<fieldset><label>foo</label><input/></fieldset>'); ?>


Scenario: Creating a void element:

	Given an initialized Tag intended to be void:
	<?php $tag = new Magnus\Tags\Tag('input', array('foo'), array('void' => true)) ?>

	When rendered:
	<?php $tagRendered = $tag->render(); ?>

	The call should succeed, returning an input element with no content and self-closed tag:
	<?= printEval($tagRendered == '<input/>'); ?>

<?= "\n\n" ?>