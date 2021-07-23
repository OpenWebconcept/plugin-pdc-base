<div class="wrap">
    <h1>Items met foutieve UPL-namen</h1>
    <?php if (!empty($incorrectItems) && is_array($incorrectItems)) : ?>
        <p>De items in de tabel hieronder zijn gekoppeld aan foutive UPL-namen. Gelieve deze aan te passen.</p>
        <table>
            <tr>
                <th style="text-align:left">Item</th>
                <th style="text-align:left">UPL-naam</th>
                <th style="text-align:left">Actie</th>
            </tr>
            <?php
            foreach ($incorrectItems as $item) {
                echo '<tr><td>' . $item['title'] . '</td><td>' . $item['uplName'] . '</td><td><a href="' . $item['editLink'] . '" class="button-primary">Wijzigen</a></td></tr>';
            }
            ?>
        </table>
    <?php else : ?>
        <p>
            Er zijn geen items gevonden.
        </p>
    <?php endif; ?>
</div>