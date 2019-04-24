<?php
namespace Magnus\Tags {

	class DefinitionListLayout extends Layout {}

	class TableLayout extends Layout {

		public function template() {

			$t = new Tag();
			$tableContent = '';
			$headerRow = null;

			foreach ($this->data as $row) {
				if (is_null($headerRow)) {
					$headerRow = '<tr><th>' . implode('</th><th>', array_keys($row)) . '</th></tr>';
				}

				$tableContent .= '<tr><td>' . implode('</td><td>', $row) . '</td></tr>';
			}

			return $t->table(array($headerRow, $tableContent), $this->kwargs)->render();
		}

	}

	class SubmitFooter extends Widget {}
}