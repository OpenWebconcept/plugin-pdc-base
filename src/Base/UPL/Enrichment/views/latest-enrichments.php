<div class="dashboard_owc_latest_enrichments">
    <div class="overview">
        <?php if (empty($posts)) : ?>
            Er zijn op dit moment geen verrijkte  PDC-items.
        <?php else : ?>
            <table>
                <tr>
                    <th style="text-align:left">Item</th>
                    <th style="text-align:left">Actie</th>
                </tr>
            <?php 
                foreach($posts as $post){
                    echo '<tr>';
                        echo $post->getTitleRow();
                        echo $post->getEditLinkRow();
                    echo '</tr>';
                }
            ?>
            </table>
        <?php endif; ?>
    </div>
    <div class="explanation">
        Deze PDC-items zijn recent verrijkt door de SDG. 
        De SDG verzorgt op basis van de gekoppelde UPL-naam standaard teksten.
    </div>
</div>