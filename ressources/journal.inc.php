<?php

	require 'framework/model.inc.php';

	class JournalModel extends NodeModel {
		
		public $table = 'journale';	
		
		function __construct() {
			parent::__construct();
			$this->addProperty(new TextProperty('type','Typ'));
			$this->addProperty(new TextProperty('label','Label'));
			$this->addProperty(new TextareaProperty('portrait','Portrait'));
			$this->addProperty(new TextProperty('autor','Autor'));
			$this->addProperty(new TextProperty('anfang','Anfang'));
			$this->addProperty(new TextProperty('ende','Ende'));
			$this->addProperty(new TextProperty('jahr','Jahr'));
			$this->addProperty(new TextProperty('band','Band'));
			$this->addProperty(new TextProperty('url','Url'));
		}
		
		protected static function createInstance() { return new JournalModel(); } 
		
	}
?>