<?php

	require "framework/controler.inc.php";
	require "journal.inc.php";	
	
	class JournalControler extends NodeControler {
		
		public $root;
		private $id;
		private $parentIds;
		
		function __construct() {
			parent::__construct(JournalModel::getInstance());
		}
	
		function doGet($get) {		
			$journal = isset($get['journal'])?$get['journal'] : 0;
			$this->id = isset($get['id'])?$get['id'] : $journal;
			$this->root = $this->dataSource->retrieveItem($journal);
			$this->parentIds = $this->retrieveParentIds($this->id);
			$this->parentIds[] = $this->id;
		}
		
		function retrieveParentIds($id) {
			$parentId = $this->dataSource->retrieveParentId($id);
			if ($parentId > 0) {
				$parentIds = $this->retrieveParentIds($parentId);
			} else {
				$parentIds = array();
			}
			$parentIds[] = $parentId;
			return $parentIds;
		}
		
		function renderChildren($item) {		
			$children = $this->dataSource->retrieveChildren($item['id']);
			if (count($children) > 0) {
				echo '<ul>';
				foreach ($children as $child) {
					if (in_array($child['id'], $this->parentIds)) {
						echo "<li><a href=\"?journal={$this->root['id']}&id={$child['parent']}\">{$child['label']}</a></li>";
						$this->renderChildren($child);
					} else {
						if ($child['type'] == 'booklet') {
							echo "<li><a href=\"http://www.bodenseebibliotheken.de/viewer.html?id=mont.03.03.01&view=single\" target=\"_blank\">{$child['label']}</a></li>";
						} else {
							echo "<li><a href=\"?journal={$this->root['id']}&id={$child['id']}\">{$child['label']}</a></li>";
						}
					}
				}
				echo '</ul>';
			}						
		}
	}

?>