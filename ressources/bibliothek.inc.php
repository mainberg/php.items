<?php

	require 'framework/model.inc.php';

	class BibliothekModel extends ItemModel {
		
		static $laender = [			
			'de' => 'Deutschland',
			'li' => 'Liechtenstein',
			'at' => 'Österreich',
			'ch' => 'Schweiz'	
		];
		
		public $table = 'bibliotheken';
		public $suchaspekte = array(
				"id" => "Id",
				"land" => "Land",
				"ort" => "Ort",
				"name" => "Name",
			);		
			
		public function __construct() {	
			parent::__construct();	
			$this->addProperty(new SelectProperty('land','Land', self::$laender));
			$this->addProperty(new TextProperty('ort','Ort'));
			$this->addProperty(new TextProperty('name','Name'));
			$this->addProperty(new TextareaProperty('portrait','Portrait'));			
			$this->addProperty(new TextareaProperty('anschrift','Anschrift'));			
			$this->addProperty(new TextareaProperty('oeffnung','Öffnungszeiten'));			
			$this->addProperty(new TextProperty('logo','Bildpfad für Logo'));			
			$this->addProperty(new TextProperty('lage','Bildpfad für Lage'));				
		}
		
		protected static function createInstance() { return new BibliothekModel(); } 		
		
	}
