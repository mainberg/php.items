<?php 

	include("datasource.inc.php");
	
	define("RECS", 10);
		
	class ItemControler {
		
		protected $itemModel;
		protected $dataSource;
		public $records;
		public $start;
		public $end;
		public $reccount;		
		public $firstUrl;
		public $previousUrl;
		public $nextUrl;
		public $lastUrl;
		public $trm;
		public $asp;
		public $suchaspekte;		

		function __construct($itemModel) {
			$this->itemModel = $itemModel;
			$this->dataSource = new ItemDataSource($itemModel);
		}	
		
		function doGet($get) {				
			
			$suchbedingung = '';
			$suchparameter = '';
			if (! empty($this->itemModel->suchaspekte)) {
				$this->asp = isset($get['asp']) ? $get['asp'] : array_keys($this->itemModel->suchaspekte)[0];
				$this->trm = isset($get['trm']) ? $get['trm'] : '';
				$suchparameter = empty($this->trm)?'':"&asp={$this->asp}&trm={$this->trm}";
				$suchbedingung = empty($this->trm)?'':" AND {$this->asp} LIKE '%{$this->trm}%'";
				$this->suchaspekte = implode('',$this->renderSuchaspekte($this->asp));
			}
			
			$filterparameter = implode('', array_map(
				function($property) {return "&{$property->name}={$get[$property->name]}"; }, 
					array_filter($this->itemModel->filter, function($property) {empty($get[$property->name]);})));
			$filterbedingung = implode('', array_map(
				function($property) {return " AND {$property->name} = '{$get[$property->name]}'"; }, 
					array_filter($this->itemModel->filter, function($property) {empty($get[$property->name]);})));

			$this->start = isset($get['start']) ? $get['start'] : 0;			
			$this->records = $this->retrieveRecords($suchbedingung.$filterbedingung, $this->start, RECS);
			$this->reccount = $this->retrieveReccount($suchbedingung.$filterbedingung);
			$this->end = min($this->start + RECS, $this->reccount);
			
			$previousPage = max(0, $this->start - RECS);
			$nextPage = min($this->start + RECS, $this->reccount - RECS);
			$lastPage = max($this->reccount-RECS, 0);
			
			$this->firstUrl = "liste.php?start=0{$suchparameter}{$filterparameter}";
			$this->previousUrl  = "liste.php?start={$previousPage}{$suchparameter}{$filterparameter}";
			$this->nextUrl  = "liste.php?start={$nextPage}{$suchparameter}{$filterparameter}";
			$this->lastUrl  = "liste.php?start={$lastPage}{$suchparameter}{$filterparameter}";			
		}				
		
		function doPost($post) {			
			if (isset($post['save'])) {
				$record = $this->itemModel->createFromPost($post);
				$this->validateAndSave($record);
			} else if (isset($post['delete'])) {
				$this->dataSource->removeItem($post['id']);								
			}		
		}	

		protected function retrieveRecords($bedingungen, $start, $len) {
			return $this->dataSource->retrieveItems('1'.$bedingungen, $this->start, RECS);
		}
		
		protected function retrieveReccount($bedingungen) {
			return $this->dataSource->recountItems('1'.$bedingungen);
		}
		
		protected function validateAndSave($record) {
			if ($this->itemModel->isValid($record)) {
				$record['modifier'] = $_SERVER['PHP_AUTH_USER'];
				$record['modified'] = date("Y-m-d H:i:s");
				$this->updateOrInsert($record);
			}			
		}	
		
		protected function updateOrInsert($record) {
			if ($record['id'] > 0) {					
				$this->dataSource->updateItem($record);
			} else {
				$this->dataSource->insertItem($record);
			}
		}	
		
		function paramToValue($name, $default = '') {
			return isset($_GET[$name]) ? $_GET[$name] : $default;
		}	
		
		function renderSuchaspekte($asp) {
			return array_map(
				function($name, $label) use ($asp) {
					$selected = ($name != $asp) ? '' : 'selected'; 
					return "<option value=\"{$name}\" {$selected} >{$label}</option>";
				},
				array_keys($this->itemModel->suchaspekte),
				array_values($this->itemModel->suchaspekte));			
		}
		
	}	
	
	class NodeControler extends ItemControler {
		
		public $record = array();
		public $breadcrumbs = array();
		private $id;
		
		function __construct($nodeModel) {
			$this->itemModel = $nodeModel;
			$this->dataSource = new NodeDataSource($nodeModel);
		}
		
		function doGet($get) {
			$this->id = isset($get['id'])?$get['id'] : 1;
			parent::doGet($get);			
			$this->record = $this->dataSource->retrieveItem($this->id);	
			$this->breadcrumbs = $this->breadcrumbs($this->record['parent']);
		}
		
		protected function retrieveRecords($bedingungen, $start, $len) {
			return $this->dataSource->retrieveItems("parent = {$this->id}".$bedingungen, $this->start, RECS);
		}
		
		protected function retrieveReccount($bedingungen) {
			return $this->dataSource->recountItems("parent = {$this->id}".$bedingungen);
		}
				
		protected function updateOrInsert($record) {
			if ($record['id'] > 0) {					
				$this->dataSource->updateItem($record);
			} else {
				$record['pos'] = $this->dataSource->nextPos($record['parent']);
				$this->dataSource->insertItem($record);
			}
		}

		function breadcrumbs($parentId) {
			if ($parentId > -1) {
				$parentRecord = $this->dataSource->retrieveItem($parentId);
				$result = $this->breadcrumbs($parentRecord['parent']);
				$result[] = $parentRecord;
				return $result;
			} else {
				return array();
			}
		}		
	}




	class FormularControler {
		
		public $record = array();
		
		function __construct($itemModel) {
			$this->itemModel = $itemModel;
			$this->dataSource = new ItemDataSource($itemModel);
		}
		
		function doGet($get) {
			if (isset($_GET['id'])) {
				$this->record = $this->dataSource->retrieveItem($_GET['id']);
			} else {
				$this->record = $this->itemModel->createRecord();
			}
		}
		
		function input($field, $style = '') {
			$this->itemModel->properties[$field]->renderInputWidget($this->record[$field], $style);
		}
		
	}
?>