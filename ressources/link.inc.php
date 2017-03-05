<?php

	require 'framework/model.inc.php';

	class LinkModel extends NodeModel {
		
		public $table = 'links';	
		
		function __construct() {
			parent::__construct();
			$this->addProperty(new TextProperty('titel','Titel'));
			$this->addProperty(new TextProperty('beschreibung','Beschreibung'));
			$this->addProperty(new TextProperty('url','Url'));
		}
		
		protected static function createInstance() { return new LinkModel(); } 
		
	}
?>