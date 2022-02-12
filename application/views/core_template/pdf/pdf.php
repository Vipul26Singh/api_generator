<style type="text/css">
	* {
		font-size: 10px; 
	}
	table tbody tr td, table thead tr th{
		border-collapse: collapse;
		padding: 2px;
	}
	table thead tr th {
		background: #858585;
		color: #fff;
	}
</style>
<page>

<p><h2><?= ucfirst(str_replace('_', ' ', $title)); ?> PDF</h2></p>

<?php
	$width_p = 100 / count($fields);
?>
	<table style="width: 750px; border-collapse: collapse;" border="1">
		<thead>
			<tr>
			<?php foreach ($fields as $field): ?>
				<th style="width: <?= $width_p ?>%"><?= ucwords(str_replace(['_', '-'], ' ', $field)); ?></th>
			<?php endforeach; ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach($results as $row): ?>
			<tr>
				<?php foreach ($fields as $field){ ?>
					<td style="width: <?= $width_p ?>%"><?= $row->{$field}; ?></td>
				<?php } ?>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<code></code>

  <page_footer>
    [[page_cu]]/[[page_nb]]
  </page_footer>
</page>
