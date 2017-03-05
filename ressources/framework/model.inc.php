<?php

	abstract class ItemModel {
		
		public $properties = array();
		public $suchaspekte = array();
		public $filter = array();
		
		public $table = '';
		
		private static $instance;

		protected function __construct() {
			$this->addProperty(new HiddenProperty('modified','Bearbeitet'));
			$this->addProperty(new HiddenProperty('modifier','Bearbeiter'));
		}

		public static function getInstance() {
			if ( is_null( self::$instance ) ) {
			  self::$instance = static::createInstance();
			}
			return self::$instance;
		}

		protected static abstract function createInstance();
		
		protected function addProperty($property) {
			$this->properties[$property->name] = $property;
		}
		
		protected function addSuchaspekt($property) {
			$this->suchaspekte[$property->name] = $property;
		}
		
		protected function addFilter($property) {
			$this->filter[$property->name] = $property;
		}
				
		public function labels() {
			return array_map(function($property) {return $property->label;}, $this->properties);
		}
		
		public function names() {
			return array_map(function($property) {return $property->name;}, $this->properties);
		}		
		
		
		public function createRecord() {
			$record = array();
			$record['id'] = 0;
			foreach ($this->properties as $property) { $record[$property->name] = $property->default; }
			return $record;
		}
		
		public function createFromPost($post) {
			$record = array();
			$record['id'] = $post['id'];
			foreach ($this->properties as $property) { $record[$property->name] = $property->fromPost($post); }
			return $record;
		}

		public function createFromRow($row) {
			$record = array();
			$record['id'] = $row['id'];
			foreach ($this->properties as $property) { $record[$property->name] = $property->fromRow($row); }
			return $record;
		}

		public function bindPropertiesToStmt($record, $stmt) {
			foreach ($this->properties as $property) { $property->bindValueToStmt($record, $stmt); }
		} 		
		
		public $errors = array();
		public function isValid($record) {
			return count($this->errors) < 1;
		}		

		public function getUpdatestmt() {
			$updateProperties = array_map(function($property) { return $property->name . ' = :' . $property->name; }, $this->properties);
			return 'UPDATE ' . $this->table . ' SET ' . implode(', ', $updateProperties) . ' WHERE id = :id';
		}
		
		public function getInsertstmt() {
			return 'INSERT INTO  ' . $this->table . '(' . implode(', ', $this->names()) . ') VALUES (:' . implode(', :', $this->names()) . ')';
		}		
		
		public function getDeleteStmt() {
			return 'DELETE FROM ' . $this->table . ' WHERE id = :id';
		}
				
		public function renderInputWidgets() {  
			foreach ($this->properties as $property) { $property->renderInputWidget(); }
		}
		
		#public static abstract function sqlKriterium($get);
		#
		#public static function sucheToSqlKriterium($get, $line) {
		#	return empty($get[('trm'.$line)]) ? '' : ' ' . $get[('op'.$line)] . ' ' . $get[('asp'.$line)] . ' like \'%' . self::toSql($get[('trm'.$line)]) . '%\'';
		#}
		#
		#public static function filterToSqlKriterium($get, $name) {
		#	return empty($get[$name]) ? '' : ' and ' . $name . ' = \'' . self::toSql($get[$name]) . "'"; 
		#}
		#
		#private static function toSql($src) {
		#	return str_replace("'","\'",utf8_decode($src));
		#}
	}	
	
	
	
	
	
	abstract class NodeModel extends ItemModel {
		
		protected function __construct() {
			parent::__construct();
			$this->addProperty(new HiddenProperty('parent','Parent'));
			$this->addProperty(new HiddenProperty('pos','Pos'));
			$this->addProperty(new HiddenProperty('type','Typ'));
		}
				
	}
	
	
	
	
	
	abstract class Property {
		public $name;
		public $label;
		public $error;
		public $style;
		public $default = '';
		
		public function __construct($name, $label, $default='') {
			$this->name = $name;
			$this->label = $label;
			$this->default = $default;
		}
		
		public function fromRow($row) {
			return $row[$this->name];
		}
		
		public function fromPost($post) {
			return $post[$this->name];
		}
		
		abstract public function bindValueToStmt($record, $stmt);
		
		public function renderInputWidget($value, $style = '') {
			$this->style = ($style != '')?" style=\"$style\" ":"";
			echo $this->labelWidget() . "<br>";
			echo $this->inputWidget($value);
			echo $this->errorWidget();
		}
		
		abstract public function inputWidget($value);
		
		protected function labelWidget() {
			return "<label for=\"$this->name\">$this->label</label>";
		}
		
		protected function errorWidget() {
			return isset($this->error)?"<br><span class=\"error\">$this->error</span>":"";
		}		
	}
	
	
	
	
	
	class HiddenProperty extends Property {		
			
		public function bindValueToStmt($record, $stmt) {
			$stmt->bindParam(':' . $this->name, $record[$this->name], PDO::PARAM_INT); 
		}
				
		public function inputWidget($value) {
			return "<input type=\"hidden\" id=\"$this->name\" name=\"$this->name\" " .
			"value=\"$value\" >";
		}
		
	}
	
	
	
	
	
	class NumberProperty extends Property {
		
		public function __construct($name, $label, $default=0) {
			$this->name = $name;
			$this->label = $label;
			$this->default = $default;
		}
		
		public function bindValueToStmt($record, $stmt) {
			$stmt->bindParam(':' . $this->name, $record[$this->name], PDO::PARAM_INT); 
		}
				
		public function inputWidget($value) {
			return "<input type=\"text\" id=\"$this->name\" name=\"$this->name\" value=\"$value\"$this->style />";
		}
		
	}
	
	
	
	
	
	class SpinnerProperty extends NumberProperty {
		
		public function __construct($name, $label, $min = 0, $max = 1000) {			
			parent::_construct($name, $label);
			$this->min = $min;
			$this->max = $max;
		}		
		
		public function inputWidget($value) {
			$this->style = $this->style != '' ? $this->style : ' style="width: 80px;"';
			return "<input type=\"number\" id=\"$this->name\" name=\"$this->name\" " .
			"value=\"$value\" min=\"$this->min\" max=\"$this->max\"$this->style />";
		}
	}
	
	
	
	
	
	class TextProperty extends Property {
		
		public function fromRow($row) {
			return utf8_encode($row[$this->name]);
		}
		
		public function bindValueToStmt($record, $stmt) {
			$stmt->bindParam(':' . $this->name, utf8_decode($record[$this->name]), PDO::PARAM_STR); 
		}
		
		public function inputWidget($value) {
			return "<input type=\"text\" id=\"$this->name\" name=\"$this->name\" value=\"$value\"$this->style />";
		}		
	}
	
	
	
	
	
	
	class TextareaProperty extends TextProperty {
		
		public function inputWidget($value) {
			return "<textarea id=\"$this->name\" name=\"$this->name\" cols=\"80\" rows=\"4\"$this->style >$value</textarea>";			
		}		
	}
	
	
	
	
	
	
	class SelectProperty extends TextProperty {
		
		public $options;
		
		public function __construct($name, $label, &$options, $default = '') {
			parent::__construct($name, $label, $default);
			$this->options = $options;
		}

		public function inputWidget($value) {
			$result = "<select id=\"{$this->name}\" name=\"{$this->name}\" >\n";
			$result .= $this->option("", "_", $value);
			foreach ($this->options as $option => $label) {				
				$result .= $this->option($option, $label, $value);
			}
			$result .= "</select>";
			return $result;
		}

		private function option($option, $label, $value) {
			return "<option value=\"{$option}\" " . ($value == $option ? "selected " : "") . ">{$label}</option>\n";			
		}
	}
	
	
	
	
	
	
	class CheckBoxProperty extends Property {
		
		public function bindValueToStmt($record, $stmt) {
			$stmt->bindParam(':' . $this->name, $record[$this->name], PDO::PARAM_BOOL);
		}
		
		public function fromPost($post) {
			return isset($post[$this->name]);
		}
		
		public function inputWidget($record) {}
		
		public function renderInputWidget($value, $style = '') {
			echo "<input type=\"checkbox\" id=\"{$this->name}\" name=\"{$this->name}\" ";
			if ($value) {
				echo "checked ";
			} 
			echo " />&nbsp;&nbsp;";
			echo $this->labelWidget();
		}		
	}
		
?>