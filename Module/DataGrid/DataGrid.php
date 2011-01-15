<?php
/**
 *	@class   	DataGrid
 *      @package       DataGrid
 * 	@author 	Angelo Rodrigues
 *	@http		http://wheremy.feethavebeen.com/projects/datagrid
 *	@version	2.1
 *  
 *	The DataGrid class provides an easy interface to create
 *	tables using multi-dimensional arrays - most likely gathered
 *	from a database.
 *
 *	-Latest Update-
 *          Added insert before/after columns with {hash} references
 *              - please read website or documentation for full explanation
 *
 *	THIS CLASS IS PROVIDED FREE OF CHARGE. IF YOU HAVE PAID FOR IT, PLEASE
 * 	NOTIFY ME AT xangelo@gmail.com
 *
 *      5 rows, 39-base + 1 cols, norename colums, mysql.user @9.4641E-6 s-approx 10,000 iterations
 *	500 rows, 6-base + 1 cols, fullrename columns, mysql.help_topic @50s-approx 1,000 iterations
 *
 */
class DataGrid {
	private $dataSource;
	private $displayFields;
	private $displaySource;

	public function __construct($dataSource = '') {
		if($dataSource != '' && is_array($dataSource)) {
			$this->source($dataSource);
		}
	}

	public function Source($array) {
		$this->dataSource = $array;
		$this->displaySource = array();
		$this->displayFields = array();
	}

	public function Fields($arrayFields) {
		$this->displayFields = $arrayFields;
		foreach($this->dataSource as $i => $row) {
			foreach($arrayFields as $aField=>$aValue) {
				foreach($row as $field=>$value) {
					if($field == $aField) {
						$tmpArray[$field] = $value;
					}
				}
			}
			if(count($tmpArray) > 0) {
				$this->displaySource[] = $tmpArray;
			}
		}
	}

	public function AddField($fieldName,$safeName,$value,$location) {
		$this->buildDisplayFields();
		if(array_key_exists('after',$location)) {
			$this->addFieldAfter($fieldName,$safeName,$value,$location);
			$this->addDisplayField($safeName,$fieldName,$location);
		}
		else if(array_key_exists('before',$location)) {
			$this->addFieldBefore($fieldName,$safeName,$value,$location);
			$this->addDisplayField($safeName,$fieldName,$location);
		}
		else {
			echo 'Failed, location does not exist';
		}
	}

	private function AddFieldAfter($fieldName,$safeName,$value,$location) {
		foreach($this->displaySource as $i => $row) {
			if(array_key_exists($location['after'],$row)) {
				$tmp = array();
				preg_match_all('/{.*?}/',$value,$out); // Check to see if we need to do the { } match
				foreach($row as $field=>$val) {
					if($location['after'] == $field) {
						$tmp[$field] = $val;

						// Loop to replace any { } items
						if(count($out[0]) > 0) {
							if($nVal == '') $nVal = $value;
							// We have a { } to work with.
							foreach($out[0] as $x => $match) {
								$key = substr(substr($match,0,-1),1);
								$nVal = str_replace($out[0][$x],$this->dataSource[$i][$key],$nVal);
							}
						}

						$tmp[$safeName] = $nVal;	// New field
						$nVal = '';
					}
					else {
						$tmp[$field] = $val;
					}
				}
				$this->displaySource[$i] = $tmp;
			}
		}
	}

	private function AddFieldBefore($fieldName,$safeName,$value,$location) {
		foreach($this->displaySource as $i => $row) {
			if(array_key_exists($location['before'],$row)) {
				$tmp = array();
				preg_match_all('/{.*?}/',$value,$out); // Check to see if we need to do the { } match
				foreach($row as $field=>$val) {
					if($location['before'] == $field) {
						// Loop to replace any { } items
						if(count($out[0]) > 0) {
							if($nVal == '') $nVal = $value;
							// We have a { } to work with.
							foreach($out[0] as $x => $match) {
								$key = substr(substr($match,0,-1),1);
								$nVal = str_replace($out[0][$x],$this->dataSource[$i][$key],$nVal);
							}
						}

						$tmp[$safeName] = $nVal;	// New field
						$nVal = '';

						$tmp[$field] = $val;
					}
					else {
						$tmp[$field] = $val;
					}
				}
				$this->displaySource[$i] = $tmp;
			}
		}
	}

	private function AddDisplayField ($safeName,$fieldName,$location) {
		if(array_key_exists('after',$location)) {
			$tmp = array();
			foreach($this->displayFields as $safe=>$actual) {
				if($safe == $location['after']) {
					$tmp[$safe] = $actual;
					$tmp[$safeName] = $fieldName;
				}
				else {
					$tmp[$safe] = $actual;
				}
			}
			$this->displayFields = $tmp;
		}
		else if(array_key_exists('before',$location)) {
			$tmp = array();
			foreach($this->displayFields as $safe=>$actual) {
				if($safe == $location['before']) {
					$tmp[$safeName] = $fieldName;
					$tmp[$safe] = $actual;
				}
				else {
					$tmp[$safe] = $actual;
				}
			}
			$this->displayFields = $tmp;
		}
		else {
			echo $location .' is not a valid location';
		}
	}

	private function BuildDisplayFields() {
		if(count($this->displayFields) < 1) {
			$row = $this->dataSource[0];
			foreach($row as $field=>$value) {
				$this->displayFields[$field] = $field;
			}
			$this->displaySource = $this->dataSource;
		}
	}

	public function Render() {
		echo $this->build();
	}

	public function Build() {
		$this->buildDisplayFields();
		$tmp = '<table class="datagrid" cellspacing="0">';
		$tmp .= $this->createTableHeaders();
		foreach($this->displaySource as $i => $row) {
			$class = 'odd';
			if($i%2 == 0) {
				$class = 'even';
			}
			$tmp .= $this->addRowToTable($row,$class);
		}
		$tmp .= '</table>';
		return $tmp;
	}

	private function CreateTableHeaders() {
		$tmp = '<tr>';
		foreach($this->displayFields as $safe=>$actual) {
			$tmp .= '<th>'.$actual.'</th>';
		}
		$tmp .= '</tr>';
		return $tmp;
	}

	private function AddRowToTable($row,$class) {
		$tmp = '<tr>';
		foreach($row as $field=>$val) {
			// Check to see if $val contains #string#.
			// If it does, look through all dataSource to
			// see if #string# exists. If it does, replace
			// #string# with the equivalent rows value
			$tmp .= '<td class="'.$class.'">'.$val.'</td>';
		}
		$tmp .= '</tr>';
		return $tmp;
	}
}