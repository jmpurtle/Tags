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
}