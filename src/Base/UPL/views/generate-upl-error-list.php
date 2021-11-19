<div class="wrap">
    <h1>Items met foutieve UPL-namen</h1>
    <?php if (!empty($incorrectItems) && is_array($incorrectItems)) : ?>
        <p>
            De items in de tabel hieronder zijn gekoppeld aan foutieve UPL-namen. Gelieve deze aan te passen.
            Als er een item in dit overzicht staat waarbij de 'upl naam' klopt dan is de 'resource url' foutief ingevuld.
            Sla het betreffende pdc-item nogmaals op. Na het opslaan wordt de 'resource url' automatisch goed neergezet.
        </p>
        <table>
            <tr>
                <th style="text-align:left">Item</th>
                <th style="text-align:left">UPL-naam</th>
                <th style="text-align:left">Doelgroepen</th>
                <th style="text-align:left">Actie</th>
            </tr>
            <?php
            foreach ($incorrectItems as $item) {
                echo '<tr><td>' . $item['title'] . '</td><td>' . $item['uplName'] . '</td><td>' . $item['doelgroepen'] . '</td><td><a href="' . $item['editLink'] . '" class="button-primary">Wijzigen</a></td></tr>';
            }
            ?>
        </table>
    <?php else : ?>
        <p>
            Er zijn geen items gevonden.
        </p>
    <?php endif; ?>
</div>