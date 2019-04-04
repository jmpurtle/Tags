<?php
namespace Magnus {
	spl_autoload_register(function ($className) {

		$packageDirectory = __DIR__;

		$packageClassMap = array(
			'Magnus\\Tags\\Fragment'             => '/Magnus/Tags/base.php',
			'Magnus\\Tags\\Tag'                  => '/Magnus/Tags/base.php',

			'Magnus\\Tags\\Widget'               => '/Magnus/Widgets/base.php',
			'Magnus\\Tags\\NestedWidget'         => '/Magnus/Widgets/base.php',
			'Magnus\\Tags\\Form'                 => '/Magnus/Widgets/base.php',
			'Magnus\\Tags\\FieldSet'             => '/Magnus/Widgets/base.php',
			'Magnus\\Tags\\Label'                => '/Magnus/Widgets/base.php',
			'Magnus\\Tags\\Layout'               => '/Magnus/Widgets/base.php',
			'Magnus\\Tags\\Input'                => '/Magnus/Widgets/base.php',
			'Magnus\\Tags\\BooleanInput'         => '/Magnus/Widgets/base.php',
			'Magnus\\Tags\\Link'                 => '/Magnus/Widgets/base.php',

			'Magnus\\Tags\\TextField'            => '/Magnus/Widgets/field.php',
			'Magnus\\Tags\\HiddenField'          => '/Magnus/Widgets/field.php',
			'Magnus\\Tags\\SearchField'          => '/Magnus/Widgets/field.php',
			'Magnus\\Tags\\URLField'             => '/Magnus/Widgets/field.php',
			'Magnus\\Tags\\PhoneField'           => '/Magnus/Widgets/field.php',
			'Magnus\\Tags\\EmailField'           => '/Magnus/Widgets/field.php',
			'Magnus\\Tags\\PasswordField'        => '/Magnus/Widgets/field.php',
			'Magnus\\Tags\\DateTimeField'        => '/Magnus/Widgets/field.php',
			'Magnus\\Tags\\DateField'            => '/Magnus/Widgets/field.php',
			'Magnus\\Tags\\MonthField'           => '/Magnus/Widgets/field.php',
			'Magnus\\Tags\\WeekField'            => '/Magnus/Widgets/field.php',
			'Magnus\\Tags\\TimeField'            => '/Magnus/Widgets/field.php',
			'Magnus\\Tags\\DateTimeLocalField'   => '/Magnus/Widgets/field.php',
			'Magnus\\Tags\\NumberField'          => '/Magnus/Widgets/field.php',
			'Magnus\\Tags\\FloatField'           => '/Magnus/Widgets/field.php',
			'Magnus\\Tags\\RangeField'           => '/Magnus/Widgets/field.php',
			'Magnus\\Tags\\FloatRangeField'      => '/Magnus/Widgets/field.php',
			'Magnus\\Tags\\ColorField'           => '/Magnus/Widgets/field.php',
			'Magnus\\Tags\\FileField'            => '/Magnus/Widgets/field.php',
			'Magnus\\Tags\\RadioField'           => '/Magnus/Widgets/field.php',
			'Magnus\\Tags\\CheckboxField'        => '/Magnus/Widgets/field.php',
			'Magnus\\Tags\\TextArea'             => '/Magnus/Widgets/field.php',
			'Magnus\\Tags\\SelectField'          => '/Magnus/Widgets/field.php',

			'Magnus\\Tags\\DefinitionListLayout' => '/Magnus/Widgets/layout.php',
			'Magnus\\Tags\\TableLayout'          => '/Magnus/Widgets/layout.php',
			'Magnus\\Tags\\SubmitFooter'         => '/Magnus/Widgets/layout.php'
		);

		if (isset($packageClassMap[$className])) {
			require_once $packageDirectory . $packageClassMap[$className];
		} 
		
	});
}