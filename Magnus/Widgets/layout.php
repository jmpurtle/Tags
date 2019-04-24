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

	class Pagination extends Widget {

		public function template() {

			$t = new Tag();

			$limit = $this->kwargs['data-limit'];

			$previousBtnState = null;
			if ($this->kwargs['data-page'] < 2) { $previousBtnState = 'disabled'; }

			$rowCount = $this->kwargs['data-rows'];
			$pages = ceil($rowCount / $limit);
			if ($pages === 0) { $pages = 1; }

			$nextBtnState = null;
			if ($this->kwargs['data-page'] === $pages) { $nextBtnState = 'disabled'; }

			$paginationForm = $t->form(array(
				$t->button(array('<<'), array('class' => 'page-first', $previousBtnState)),
				$t->button(array('<'), array('class' => 'page-prev', $previousBtnState)),
				$t->input(array(), array(
					'id'         => 'pageIndex',
					'value'      => $this->kwargs['data-page'],
					'class'      => 'pages',
					'data-pages' => $pages
				)),
				$t->button(array('>'), array('class' => 'page-next', $nextBtnState)),
				$t->button(array('>>'), array('class' => 'page-last', $nextBtnState)),
			));

			return $paginationForm->render();

		}

	}

}