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

			$this->loadAttributes();
		}

		public function value() {

			$value = $this->default;
			if (array_key_exists($this->name, $this->data)) {
				$value = $this->data[$this->name];
			}

			if ($this->transform) {
				$value = $this->transform($value);
			}

			return $value;

		}

		public function __get($name) {

			if (array_key_exists($this->name, $this->kwargs)) {
				return $this->kwargs[$this->name];
			}

			return null;

		}

		public function loadAttributes() {
			
			$objVars = array_keys(get_object_vars($this));

			foreach ($objVars as $attr) {
				if (isset($this->kwargs[$attr])) {
					$this->$attr = $this->kwargs[$attr];
					unset($this->kwargs[$attr]);
				}
			}

		}

	}

	class NestedWidget extends Widget {

		public $children;

		public function __construct($name = null, $title = null, $default = null, Array $data = array(), Array $kwargs = array(), Array $children = array()) {
			$this->children = $children;
			parent::__construct($name, $title, $default, $data, $kwargs);
		}

	}

	class Form extends NestedWidget {

		public $method = 'post';

	}

}