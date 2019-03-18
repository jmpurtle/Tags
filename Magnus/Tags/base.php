<?php
namespace Magnus\Tags {
	
	class Fragment {

		public $name;
		public $data;
		public $kwargs;

		public function __construct($name = null, Array $data = array(), Array $kwargs = array()) {
			$this->name = $name;
			$this->data = $data;
			$this->kwargs = $kwargs;
		}

		public function __toString() {
			return '<' . $this->name . $this->buildAttrString($this->kwargs) . '>';
		}

		protected function buildAttrString(Array $kwargs = array()) {

			$attrString = '';

			foreach ($kwargs as $key => $value) {
				$attrString .= ' ' . $key;

				if ($value !== null) {
					if (is_array($value)) { $value = json_encode($value); }
					$attrString .= '="' . $value . '"';
				}
			}

			return $attrString;
		}

		public function clear() {
			$this->kwargs = array();
			$this->data = array();
		}

	}

}