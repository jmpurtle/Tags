<?php
namespace Magnus\Tags {
	
	class Fragment {

		public $name;
		public $data;
		public $logicProps;
		public $kwargs;

		public function __construct($name = null, Array $data = array(), Array $logicProps = array(), Array $kwargs = array()) {
			$this->name = $name;
			$this->data = $data;
			$this->logicProps = $logicProps;
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
			$this->data = array();
			$this->logicProps = array();
			$this->kwargs = array();
		}

		public function __get($name) {

			if (array_key_exists($name, $this->kwargs)){
				return $this->kwargs[$name];
			}

			if (array_key_exists($name, $this->logicProps)) {
				return $this->logicProps[$name];
			}

			return null;
			
		}

	}

	class Tag extends Fragment {

		public function __invoke(Array $logicProps = array(), Array $kwargs = array()) {

			$this->logicProps = array_merge($this->logicProps, $logicProps);
			$this->kwargs = array_merge($this->kwargs, $kwargs);

			return $this;

		}

		protected function tagIterator() {

			if (!$this->strip) {
				if ($this->prefix) { yield $this->prefix; }
				yield <<<TEMPLATE
					<{$this->name}{$this->buildAttrString($this->kwargs)}
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
					</{$this->name}>
TEMPLATE;
			}

		}

		public function render() {

			$template = '';
			$tagIterator = $this->tagIterator();
			foreach ($tagIterator as $chunk) { $template .= trim($chunk); }

			return $template;

		}

	}

}