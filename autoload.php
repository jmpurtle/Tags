<?php
namespace Magnus {
	spl_autoload_register(function ($className) {

		$packageDirectory = __DIR__;

		$packageClassMap = array(
			'Magnus\\Tags\\Fragment' => '/Magnus/Tags/base.php'
		);

		if (isset($packageClassMap[$className])) {
			require_once $packageDirectory . $packageClassMap[$className];
		} 
		
	});
}