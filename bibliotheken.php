<?php

	require "includes/database.inc.php";
	require "bibliothek.inc.php";
	
	$itemClass = 'Bibliothek';
	
	if (isset($_GET['land'])) {
		$where = "land = '" . $_GET['land'] . "'";
	} elseif (isset($_GET['ort'])) {
		$where = "ort = '" . $_GET['ort'] . "'";
	} else {
		$where = '1';
	}
	
	function retrieveBibliotheken($where) {
		$sql = "SELECT * FROM bibliotheken WHERE " . $where . " ORDER BY land, ort, name";
		return createItemListFromRecords($sql, 'Bibliothek');
	}
	
	$land = '';
	$ort = '';
			
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="style/euregio.css" media="screen">
		<title>Bibliotheken der Regio Bodensee</title>
	</head>
	<body>
	
		<?php include("includes/head.inc.php"); ?> 
		
		<div id="container1">     
			
			<?php include("includes/left.inc.php"); ?>

			<div id="logo"></div>
			
			<div id="content1">
			
				<div id="spalte1">
					<table>
						<?php foreach (retrieveBibliotheken($where) as $item) { 
						if ($land != $item->properties['land']->value) { ?>
							<tr><td colspan="2"><?php echo Bibliothek::$laender[$item->properties['land']->value]; ?></td></tr>
						<?php $land = $item->properties['land']->value; } ?>						
						<tr>
							<td>
							<?php if ($ort != $item->properties['ort']->value) {
								echo $item->properties['ort']->value;
								$ort = $item->properties['ort']->value; } ?>
							</td>
							<td style="padding: 5px;"><a href="bibliothek.php?id=<?php echo $item->id ?>"><?php echo $item->properties['name']->value ?></a></td>
						</tr>
						<?php } ?>
					</table>
				</div>
		</div>
	</body>
</html>
