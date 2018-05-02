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


$page = new HtmlPage('Organisations Chart');
$headline = 'Test';
//Begin der Seite

// create module menu
$listsMenu = new HtmlNavbar('menu_lists_list', $headline, $page);

	// show link to pluginpreferences          
$listsMenu->addItem('menu_item_back', substr(__DIR__ ). '/adm_plugins/orgchart/orgchart_show.php', $gL10n->get('SYS_BACK'), 'back.png');
        
// show module menu
$page->addHtml($listsMenu->show(false));
$page->addHtml('<h1>Parameter</h1>');
$page->addHtml('<h2>o.setFont(\'arial\', 10, \'#000000\', 1);</h2>');
$page->addHtml('<li>Font');
$page->addHtml('<li>Pixel');
$page->addHtml('<li>Color #000000');
$page->addHtml('<li>Ausrichtung 0 = oben, 1 = center)');
$page->addHtml('<h2>o.setColor ()</h2>');
$page->addHtml('<li>Rahmen');
$page->addHtml('<li>Innenfarbe');
$page->addHtml('<li>Textfarbe');
$page->addHtml('<li>Verbindungslinie');
$page->addHtml('<h2>o.addNode ()</h2>');
$page->addHtml('<li>ID');
$page->addHtml('<li>ID-Parent');
$page->addHtml('<li>Ausrichtung u-l-r');
$page->addHtml('<li>Text');
$page->addHtml('<li>Linienstaerke');
$page->addHtml('<li>Link');
$page->addHtml('<li>Rahmenfarbe');
$page->addHtml('<li>Innenfarbe');
$page->addHtml('<li>Textfarbe');
$page->addHtml('<li>Bildlink');
$page->addHtml('<li>Ausrichtung (lt ct rt; lm cm rm; lb cb rb');
$page->addHtml('<h2>o.setSize()  ()</h2>');
$page->addHtml('<li>1.	Width of the nodes in pixels. ');
$page->addHtml('<li>2.	Height of the nodes in pixels. ');
$page->addHtml('<li>3.	Horizontal space between u-nodes. ');
$page->addHtml('<li>4.	Vertical space between nodes. ');
$page->addHtml('<li>5.	Horizontal offset of the l- and r-nodes. ');
$page->addHtml('<h2>o.setNodeStyle() ()</h2>');
$page->addHtml('<li>1.	The radius of the top corners. The default value is 5. ');
$page->addHtml('<li>2.	The radius of the bottom corners. The default value is 5. ');
$page->addHtml('<li>3.	The offset of the node shadow. The default value is 3. ');
$page->show();
?>
