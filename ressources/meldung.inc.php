<?php

	require 'framework/model.inc.php';

	class MeldungModel extends ItemModel {
		
		public $table = 'meldungen';
		public $suchaspekte = array(
				"id" => "Id",
				"titel" => "Titel",
				"ort" => "Ort"
			);		
		
		function __construct() {
			parent::__construct();
			$this->addProperty(new TextProperty('datum','Datum (nur zum Sortieren)'));
			$this->addProperty(new TextProperty('zeit','Zeit(raum)'));
			$this->addProperty(new TextProperty('ort','Ort'));
			$this->addProperty(new TextareaProperty('titel','Titel'));			
			$this->addProperty(new TextareaProperty('teaser','Teaser'));			
			$this->addProperty(new TextareaProperty('text','Beschreibung'));			
			$this->addProperty(new TextProperty('link','Url zu weiteren Infos'));
		}
				
		protected static function createInstance() { return new MeldungModel(); } 
			
	}
