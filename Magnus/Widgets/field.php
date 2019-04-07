<?php
namespace Magnus\Tags {
	
	class TextField extends Input {
		public $type = 'text';
	}

	class HiddenField extends Input {
		public $type = 'hidden';
	}

	class SearchField extends Input {
		public $type = 'search';
	}

	class URLField extends Input {
		public $type = 'url';
	}

	class PhoneField extends Input {
		public $type = 'tel';
	}

	class EmailField extends Input {
		public $type = 'email';
	}

	class PasswordField extends Input {
		public $type = 'password';
	}

	class DateTimeField extends Input {
		public $transform = 'DateTimeTransform';
		public $type = 'datetime';
	}

	class DateField extends Input {
		public $type = 'date';
	}

	class MonthField extends Input {
		public $type = 'month';
	}

	class WeekField extends Input {
		public $type = 'week';
	}

	class TimeField extends Input {
		public $type = 'time';
	}

	class DateTimeLocalField extends Input {
		public $type = 'datetimelocal';
	}

	class NumberField extends Input {
		public $transform = 'IntegerTransform';
		public $type = 'number';
	}

	class FloatField extends NumberField {
		public $transform = 'FloatTransform';
	}

	class RangeField extends Input {
		public $transform = 'IntegerTransform';
		public $type = 'range';
	}

	class FloatRangeField extends RangeField {
		public $transform = 'FloatTransform';
	}

	class ColorField extends Input {
		public $type = 'color';
	}

	class FileField extends Input {
		public $type = 'file';
	}

	class RadioField extends BooleanInput {
		public $type = 'radio';
	}

	class CheckboxField extends BooleanInput {

		public $transform = 'BooleanTransform';
		public $type = 'checkbox';

		public function template() {
			$t = new Tag();

			$hidAttrs = array(
				'type'    => 'hidden',
				'name'    => $this->name,
				'id'      => $this->name . '-hidden',
				'value'   => $this->value,
				'void'    => 'true'
			);

			$inputAttrs = array(
				'type'    => $this->type,
				'name'    => $this->name,
				'id'      => $this->name . '-field',
				'checked' => $this->value,
				'void'    => 'true'
			);

			$attrs = array_merge($inputAttrs, $this->kwargs);

			$template = $t->div(array(
				$t->input(array(), $hidAttrs),
				$t->input(array(), $inputAttrs)
			), array());

			return $template->render();
		}
	}

	class TextArea extends Input {

		public function template() {
			$t = new Tag();

			$attrs = array(
				'name' => $this->name,
				'id'   => $this->name . '-field'
			);

			$attrs = array_merge($attrs, $this->kwargs);

			$value = $this->value;
			unset($attrs[$this->name]);

			$template = $t->textarea(array($value), $attrs);
			return $template->render();
		}
	}

	class SelectField extends Input {
		public $values = array();
	}
}