<?php
namespace Magnus\Tags {
	
	class Widget {

		public $name;
		public $title;
		public $data;
		public $kwargs;
		public $default;

		public function __construct($name = null, $title = null, $default = null, Array $data = array(), Array $kwargs = array()) {

			$this->name = $name;
			$this->title = $title;
			$this->default = $default;
			$this->data = $data;
			$this->kwargs = $kwargs;
		}

	}

}