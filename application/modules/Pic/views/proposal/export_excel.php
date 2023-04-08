<?php 
    // var_dump($proposal_header->result());
    // var_dump($proposal_item->result());
?>

<!DOCTYPE html>
<html>
<head>
	<title>Promotion Proposal <?=$proposal_header->row()->Number?></title>
</head>
<body>
	<style type="text/css">
	body{
		font-family: sans-serif;
	}
	table{
		margin: 20px auto;
		border-collapse: collapse;
	}
	table th,
	table td{
		border: 1px solid #3c3c3c;
		padding: 3px 8px;
 
	}
	a{
		background: blue;
		color: #fff;
		padding: 8px 10px;
		text-decoration: none;
		border-radius: 2px;
	}
	</style>
 
	<?php
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=proposal_".$proposal_header->row()->Number.".xls");
	?>
 
	<center>
		<h1>Proposal Promotion</h1>
	</center>
 
	<table border="1">
		<tr>
			<th>No</th>
			<th>Product Description</th>
			<th>Barcode</th>
			<th>Price</th>
            <th>Qty</th>
            <th>Target</th>
            <th>Promo</th>
            <th>Total Costing</th>
		</tr>
		<?php 
		$no = 1;
		foreach($proposal_item->result() as $item){
		?>
		<tr>
			<td><?=$no++?></td>
			<td><?=$item->ItemName?></td>
			<td><?=$item->Barcode?></td>
			<td><?=$item->Price?></td>
			<td><?=$item->Qty?></td>
			<td><?=$item->Target?></td>
			<td><?=$item->Promo?></td>
			<td><?=$item->Costing?></td>
		</tr>
		<?php 
		}
		?>
	</table>
</body>
</html>