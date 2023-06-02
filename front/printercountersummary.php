<?php
// glpi page for the plugin
// Path: front\printercountersummary.php
include ('../../../inc/includes.php');

// include the header of the page
Html::header(__('Printer Counter Summary', 'printercountersummary'), $_SERVER['PHP_SELF'], "tools", "PluginPrinterCounterSummary", "menu");

// include a title for the page in order to test the plugin
echo '<div class="center">';
echo '<h2>'.__('Welcome to the Printer Counter Summary plugin!', 'printercountersummary').'</h2>';
echo '</div>';

// include the footer of the page
Html::footer();
