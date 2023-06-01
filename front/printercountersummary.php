<?php

//include ("../../../inc/includes.php");

Html::header(__("Printer Counter Summary", "printercountersummary"), $_SERVER['PHP_SELF'], "plugins",
             "printercountersummary", "printercountersummary");

echo '<div class="center">';
echo '<h2>' . __('Welcome to the Printer Counter Summary plugin!', 'printercountersummary') . '</h2>';
echo '</div>';

Html::footer();
