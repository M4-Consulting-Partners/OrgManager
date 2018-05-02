<?php
/******************************************************************************
 * Organisations Chart
 *
 * Version 0.0.1
 *
 * Datum        : 29.09.2014  
 *
 * Diese Plugin zeigt die Struktur der Organisation
 * 
 *                  
 *****************************************************************************/
// Pfad des Plugins ermitteln
// Pfad des Plugins ermitteln
$plugin_folder_pos = strpos(__FILE__, 'adm_plugins') + 11;
$plugin_file_pos   = strpos(__FILE__, basename(__FILE__));
$plugin_path       = substr(__FILE__, 0, $plugin_folder_pos);
$plugin_folder     = substr(__FILE__, $plugin_folder_pos+1, $plugin_file_pos-$plugin_folder_pos-2);        



require_once(substr(__FILE__, 0,strpos(__FILE__, 'adm_plugins')-1).'/adm_program/system/common.php');


$page = new HtmlPage('Eigene Organisation');
$headline = 'Test';
//Begin der Seite

// create module menu
$listsMenu = new HtmlNavbar('menu_lists_list', $headline, $page);

	// show link to pluginpreferences          
$listsMenu->addItem('menu_item_back', substr(__DIR__ ). '/adm_plugins/orgchart/orgchart_show.php', $gL10n->get('SYS_BACK'), 'back.png');
        
// show module menu
$page->addHtml($listsMenu->show(false));
$page->addHtml('<h1>Organisationen</h1>');
				$page->addHtml('
                                 <table>
					<colgroup>
						<col width="200"/>
						<col width="150"/>
						<col width="90"/>
						<col width="120"/>
						<col width="200"/>
						<col width="50"/>
					</colgroup>
                                </table>');


$page->show();


?>
