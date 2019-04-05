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

		public function template() {
			throw new Exception("Template is not implemented", 1);
			
		}

	}

	class NestedWidget extends Widget {

		public $children;

		public function __construct($name = null, $title = null, $default = null, Array $data = array(), Array $kwargs = array(), Array $children = array()) {
			$this->children = $children;
			parent::__construct($name, $title, $default, $data, $kwargs);
		}

		public function renderInterior() {
			$interior = array();
			
			foreach ($this->children as $child) {
				$interior[] = $child->template($this->data);
			}

			return $interior;
		}

	}

	class Form extends NestedWidget {

		public $method = 'post';

		public function template() {
			$t = new Tag();

			$attrs = array(
				'name' => $this->name,
				'id'   => $this->name . '-form'
			);

			$attrs = array_merge($attrs, $this->kwargs);

			$template = $t->form($this->renderInterior(), $attrs);
			return $template->render();
		}
	}

	class FieldSet extends NestedWidget {

		public $layout = null;

		public function template() {
			$t = new Tag();

			$attrs = array(
				'id' => $this->name . '-set'
			);

			$attrs = array_merge($attrs, $this->kwargs);

			$template = $t->fieldset($this->renderInterior(), $attrs);
			return $template->render();
		}
	}

	class Label extends Widget {

		public $for = null;

		public function template() {
			$t = new Tag();

			$attrs = array();
			if ($this->for) { $attrs['for'] = $this->for . '-field'; }

			$attrs = array_merge($attrs, $this->kwargs);

			$template = $t->label(array($this->title), $attrs);
			return $template->render();
		}
	}

	class Layout extends NestedWidget {
		public $label = null;
	}

	class Input extends Widget {
		public $type = null;

		public function template() {
			$t = new Tag();

			$attrs = array(
				'type' => $this->type,
				'void' => true,
				'name' => $this->name,
				'id'   => $this->name . '-field'
			);

			$attrs = array_merge($attrs, $this->kwargs);

			$template = $t->input(array(), $attrs);
			return $template->render();
		}
	}

	class BooleanInput extends Input {
		public $transform = 'BooleanTransform';
	}

	class Link extends Widget {}

}