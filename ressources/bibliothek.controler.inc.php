<?php

	require "framework/controler.inc.php";
	require "bibliothek.inc.php";	
	
	class BibliothekControler extends ItemControler {
		
		public $bibliotheken;
		
		function __construct() {
			parent::__construct(BibliothekModel::getInstance());
		}
	
		function doGet($get) {		
			if (isset($get['land'])) {
				$sql = "SELECT * FROM bibliotheken WHERE land = '{$get['land']}' ORDER BY ort, name";
			} elseif (isset($get['ort'])) {
				$sql = "SELECT * FROM bibliotheken WHERE ort = '{$get['ort']}' ORDER BY name";
			} else {
				$sql = "SELECT * FROM bibliotheken ORDER BY land, ort, name";
			}
			$this->bibliotheken = $this->dataSource->retrieveAllItems($sql);			
		}						
	}
?>