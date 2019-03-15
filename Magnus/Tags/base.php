<?php
namespace Magnus\Tags {
	
	class Fragment {

		public $data;
		public $kwargs;

		public function __construct(Array $data = array(), Array $kwargs = array()) {
			$this->data = $data;
			$this->kwargs = $kwargs;
		}
	}
}