<?php
namespace Magnus\Tags {
	
	class Fragment {

		public $tagName;
		public $data;
		public $kwargs;

		public function __construct($tagName = null, Array $data = array(), Array $kwargs = array()) {
			$this->tagName = $tagName;
			$this->data = $data;
			$this->kwargs = $kwargs;

			$this->loadProps();
		}

		public function __toString() {
			return '<' . $this->tagName . $this->buildAttrString($this->kwargs) . '>';
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
			$this->data = array();
			$this->kwargs = array();
		}

		public function __get($name) {

			if (array_key_exists($name, $this->kwargs)){
				return $this->kwargs[$name];
			}

			return null;
			
		}

		public function loadProps() {
			
			$objVars = array_keys(get_object_vars($this));

			foreach ($objVars as $objProps) {
				if (isset($this->kwargs[$objProps])) {
					$this->$objProps = $this->kwargs[$objProps];
					unset($this->kwargs[$objProps]);
				}
			}

		}

	}

	class Tag extends Fragment {

		public $void = false;

		public function __invoke(Array $kwargs = array()) {

			$this->kwargs = array_merge($this->kwargs, $kwargs);

			return $this;

		}

		protected function tagIterator() {

			if (!$this->strip) {
				if ($this->prefix) { yield $this->prefix; }
				yield <<<TEMPLATE
					<{$this->tagName}{$this->buildAttrString($this->kwargs)}
TEMPLATE;

				if ($this->void) { yield ' />'; return; }
				yield '>';
			}

			if ($this->simple) { return; }

			foreach ($this->data as $child) {
				if (is_object($child) && method_exists($child, 'tagIterator')) {
					foreach ($child->tagIterator() as $element) {
						if (is_string($element)) {
							yield $element;
							continue;
						}
					}

					continue;
				}

				yield $child;
			}

			if (!$this->void) {
				yield <<<TEMPLATE
					</{$this->tagName}>
TEMPLATE;
			}

		}

		public function render() {

			$template = '';
			$tagIterator = $this->tagIterator();
			foreach ($tagIterator as $chunk) { $template .= trim($chunk); }

			return $template;

		}

		public function __clone() {
			$this->clear();
		}

		public function __call($name, $args) {
			$argCount = count($args);
			for ($argCount; $argCount < 2; $argCount++) { 
				$args[] = array();
			}

			$tag = clone $this;
			$tag->tagName = $name;
			$tag->data = $args[0];
			$tag->kwargs = $args[1];

			$tag->loadProps();
			return $tag;
		}

	}

}