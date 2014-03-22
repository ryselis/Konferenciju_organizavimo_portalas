<?php
class RowBuilder {
	public function __construct($rows, $first_col_href) {
		$this -> rows = $rows;
		$this -> first_col_href = $first_col_href;
	}

	public function build() {
		$this -> resulting_row = "";
		$first_row = true;
		foreach ($this->rows as $row) {
			if ($first_row) {
				$first_row = false;
				$data = '<div><a href="' . $this -> first_col_href . '">' . $row . '</div>';
			} else {
				$data = '<div>' . $row . '</div>';
			}
			$this -> resulting_row .= '<td>' . $data . '</td>';
		}
		return $this->resulting_row;
	}

}
?>