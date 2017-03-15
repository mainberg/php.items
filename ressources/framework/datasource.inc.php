<?php

	$pdo = new PDO('mysql:host=rdbms.strato.de;dbname=DB2898920','U2898920','ho2fma2n');
	#$pdo = new PDO('mysql:host=localhost;dbname=kebweb','kebweb', 'pw_kebweb');	
	$pdo->query("SET NAMES 'utf-8'");	

	class ItemDataSource {
	
		protected $itemModel;
		
		function __construct($itemModel) {		
			$this->itemModel = $itemModel;		
		}			
	
		function retrieveItem($id) {
			global $pdo;
			$sql = "SELECT * FROM {$this->itemModel->table} WHERE id = {$id}";
			return $this->itemModel->createFromRow($pdo->query($sql)->fetch(PDO::FETCH_ASSOC));
		}
		
		function retrieveAllItems($sql) {
			return $this->createItemListFromQuery($sql);
		}
		
		function retrieveItems($where, $start, $len) {
			return $this->createItemListFromQuery("SELECT * FROM {$this->itemModel->table} WHERE {$where} LIMIT {$start}, {$len}");
		}		

		function recountItems($where) {
			global $pdo;
			$result = $pdo->query("SELECT count(*) AS cnt FROM {$this->itemModel->table} WHERE {$where}")->fetch(PDO::FETCH_ASSOC);
			return $result['cnt'];		
		}
				
		function insertItem($record) {
			global $pdo;
			$stmt = $pdo->prepare($this->itemModel->getInsertStmt());
			$this->itemModel->bindPropertiesToStmt($record, $stmt);
			$stmt->execute() or die("Error inserting item into db");
		}
		
		function updateItem($record) {
			global $pdo;		
			$stmt = $pdo->prepare($this->itemModel->getUpdatestmt());
			$stmt->bindParam(':id', $record['id'], PDO::PARAM_INT);	
			$this->itemModel->bindPropertiesToStmt($record, $stmt);
			$stmt->execute() or die("Error updating item into db");			
		}
				
		function removeItem($record) {
			global $pdo;
			if ($record['id'] > 0) { 
				$stmt = $pdo->prepare($this->itemModel->getDeleteStmt());
				$stmt->bindParam(':id', $record['id'], PDO::PARAM_INT);	
				$stmt->execute() or die("Error delete item into db");	
			}			
		}

		protected function createItemListFromQuery($sql) {
			global $pdo;
			$results = array();
			foreach ($pdo->query($sql) as $row) {
				$results[] = $this->itemModel->createFromRow($row);
			}
			return $results;
		}
				
	}
	
	
	
	
	class NodeDataSource extends ItemDataSource {
		
		function __construct($itemModel) {	
			parent::__construct($itemModel);		
		}
				
		function nextPos($id) {
			global $pdo;
			$result = $pdo->query("SELECT max(pos) AS maxpos FROM {$this->itemModel->table} WHERE parent = {$id}")->fetch(PDO::FETCH_ASSOC);		
			return $result['maxpos'] + 1;
		}	
		
		function retrieveChildren($parentId) {
			return $this->createItemListFromQuery("SELECT * FROM {$this->itemModel->table} WHERE parent = {$parentId}");
		}
		
		function retrieveParent($item) {
			global $pdo;
			$sql = "SELECT * FROM {$this->itemModel->table} WHERE id = {$item->parent}";
			return $this->itemModel->createFromRow($pdo->query($sql)->fetch(PDO::FETCH_ASSOC));
		}	

		function retrieveParentId($id) {
			global $pdo;
			$sql = "SELECT parent FROM {$this->itemModel->table} WHERE id = {$id}";
			$result = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
			return $result['parent'];
		}
	}
?>