<div class="wrap">
	<h1>UPL Reparatie</h1>
	<ul style="display: flex; gap: 10px;">
		<li><a class="button-primary" href="<?php echo admin_url('admin.php?page=upl-correcte-items') ?>">Juist ingestelde items</a></li>
		<li><a class="button-secondary" href="<?php echo admin_url('admin.php?page=upl-foutieve-items') ?>">Verkeerd ingestelde items</a></li>
	</ul>
	<?php if (! empty($correctItems) && is_array($correctItems)) : ?>
		<table>
			<tr>
				<th style="text-align:left">Item</th>
				<th style="text-align:left">UPL-naam</th>
				<th style="text-align:left">Actie</th>
			</tr>
			<?php
            foreach ($correctItems as $item) {
                echo '<tr><td>' . $item['title'] . '</td><td>' . $item['uplName'] . '</td><td><a href="' . $item['editLink'] . '" class="button-primary">Bekijken</a></td></tr>';
            }
	    ?>
		</table>
	<?php else : ?>
		<p>
			Er zijn geen items gevonden.
		</p>
	<?php endif; ?>
</div>
