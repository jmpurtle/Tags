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

		public function __get($name) {

			if (array_key_exists($name, $this->kwargs)){
				return $this->kwargs[$name];
			}

			return null;
			
		}

		public function __set($name, $value) {
			$this->kwargs[$name] = $value;
		}

	}

	class Tag extends Fragment {

		public function __invoke($strip = null, Array $kwargs = array()) {

			if ($strip !== null) { $this->strip = $strip; }
			$this->kwargs = array_merge($this->kwargs, $kwargs);

			return $this;

		}

	}

}