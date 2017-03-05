<?php 
	
	function pagination($controler) {
		if ($controler->start > 0) { 
			echo "<a href=\"{$controler->firstUrl}\">|&lt;</a>";
			echo "<a href=\"{$controler->previousUrl}\">&lt;</a>";
		}  
		echo "{$controler->start} bis {$controler->end} von {$controler->reccount}";
		if ($controler->end < $controler->reccount) { 
			echo "<a href=\"{$controler->nextUrl}\">&gt;</a>";
			echo "<a href=\"{$controler->lastUrl}\">&gt;|</a>";	
		} 
	}
	
	function suchformular($controler) {
		echo <<<EOT
			<form action="liste.php" method="GET" >
				<div class="row">				
					<div class="col-lg-5">
						<p>							
							<select name="asp">
								{$controler->suchaspekte}
							</select>
							<input type="text" name="trm" value="{$controler->trm}" />								
						</p>						
					</div>					
				</div>				
				<div class="row">				
					<div class="col-lg-12">
						<input type="submit" value="Suchen"/>
					</div>
				</div>
			</form>
EOT;
	}
	
	function liste($controler, $fields) {
		echo "<table>";
			foreach ($controler->records as $record) { 
				echo "<tr>";
					echo "<td style=\"padding: 5px;\"><a href=\"formular.php?id={$record['id']}\">{$record['id']}</a></td>";
					foreach ($fields as $field) {
						echo "<td style=\"padding: 5px;\">{$record[$field]}</td>";
					}				
				echo "</tr>";
			} 
		echo "</table>";
	}
	
	
?>