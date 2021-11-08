<div class="wrap">
    <h1>Items met correcte UPL-namen</h1>
    <?php if (!empty($correctItems) && is_array($correctItems)) : ?>
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