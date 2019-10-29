<?php

class MigrationModel {
	public $conn = null;
	public $dbConfig = null;
	public $steps = [];

	public function __construct() {
		$this->dbConfig['dbname'] = 'dbmigration';
		$this->dbConfig['username'] = 'root';
		$this->dbConfig['password'] = '';
		$this->dbConfig['host'] = 'localhost';
	}

	public function createDB() {
		$this->conn = new mysqli($this->dbConfig['host'], $this->dbConfig['username'], $this->dbConfig['password']);
		if ($this->conn->connect_error) {
			die("Connection failed: " . $this->conn->connect_error);
		}

		$dropDBQuery ="DROP DATABASE " . $this->dbConfig['dbname'];
		if($this->conn->query($dropDBQuery) === TRUE) {
			$this->steps[] = 'Database <strong>' . $this->dbConfig['dbname'] . '</strong> dropped';
		}
		$dbQuery = "CREATE DATABASE " . $this->dbConfig['dbname'];
		if ($this->conn->query($dbQuery) === TRUE) {
			$this->steps[] = '<strong>' . $this->dbConfig['dbname'] . '</strong> Database created successfully';
		} else {
			$this->steps[] = 'Error creating database: ' . $this->conn->error;
		}
		

		$this->conn = new mysqli($this->dbConfig['host'], $this->dbConfig['username'], $this->dbConfig['password'], $this->dbConfig['dbname']);
		if ($this->conn->connect_error) {
			die("Connection failed: " . $this->conn->connect_error);
		}
	}

	public function processMigration() {
		$this->createDB();
		$cols_divide_config['member_table'] = ['Ref No.', 'Member Name', 'Member No', 'Member Company'];
		$cols_divide_config['transaction_table'] = ['Member No', 'Member Pay Type', 'Renewal Year', 'subtotal', 'totaltax', 'total'];
		$cols_divide_config['transaction_details_table'] = ['Member No', 'Batch No', 'Cheque No', 'Payment By', 'Payment Description'];


		foreach($cols_divide_config as $table_name => $cols) {
			$tableQuery = "CREATE TABLE " . $table_name . "(id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,";
			$tableCols = [];
			$tableColsWithoutSpace = [];
			foreach($cols as $col) {
				$col = strtolower(str_replace(' ', '_', str_replace('.', '', $col)));
				$tableColsWithoutSpace[] = $col;
				$tableCols[] = $col . " TEXT";
			}
			$tableQuery = $tableQuery . implode(',', $tableCols) . ')';
			if($this->conn->query($tableQuery) === TRUE) {
				$this->steps[] = 'Table <strong>' . $table_name . '</strong> created with following columns (<i>' . implode(',', $tableColsWithoutSpace) . '</i>)';
			} else {
				$this->steps[] = 'Error Creating Table <strong>' . $table_name . '</strong> ' . $this->conn->error . '';
			}
		}

		//strtolower(str_replace(' ', '_', $data[$c]))
	
		$field_data = [];
		$headers = [];

		if(isset($_FILES['uploader-file']['tmp_name'])) {
			$filename = 'uploader-file-db.csv';
			if(move_uploaded_file($_FILES['uploader-file']['tmp_name'], $filename)) {
				$row = 1;
				if (($handle = fopen($filename, "r")) !== FALSE) {
				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
					$num = count($data);
					//echo "<p> $num fields in line $row: <br /></p>\n";
					
					if($row == 1) {
						$query = array();
						for ($c=0; $c < $num; $c++) {
							$headers[] = $data[$c];
						}
					} else {
						foreach($cols_divide_config as $table_name => $cols) {
						for ($c=0; $c < $num; $c++) {
							if(in_array($headers[$c], $cols)) {
							$cols_fields[$table_name][$row][] = array(strtolower(str_replace(' ', '_', str_replace('.', '', $headers[$c]))) =>  $data[$c]);
							}
						}

						}  
					}
					$row++;
				}
				fclose($handle);
				}
			} else {
				echo 'FILE NOT UPLOADED';
			}
		}

		$queryList = [];
		foreach($cols_fields as $table_name => $rows) {
			foreach($rows as $row) {
				$fields = [];
				$values = [];
				foreach($row as $invidual_row) {
				foreach($invidual_row as $field_name => $col_val) {
					$fields[] = $field_name;
					$values[] = "'" . $col_val . "'";
				}
				}
				$queryList[$table_name]['fields'] = '(' . implode(',', $fields) . ')';
				$queryList[$table_name]['sql'][] = '(' . implode(',', $values) . ')';
			}
		}

		foreach($queryList as $table_name => $category) {
			$query = "insert into " . $table_name . " " . $category['fields'] . ' values ' . implode(',', $category['sql']);
			if($this->conn->query($query) === FALSE) {
				$this->steps[] = 'Row creation failed on table <strong>' . $table_name . '</strong>';
			} else {
				$this->steps[] = 'Table <strong>' . $table_name . '</strong> has been populated with <strong>' . count($category['sql']) . '</strong> records';
			}
		}

		return $this->steps;
	}
}