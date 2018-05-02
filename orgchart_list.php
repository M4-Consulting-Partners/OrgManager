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

$org_imagelink = substr(__DIR__ ). '/adm_plugins/orgchart/orgchart_photo_show.php?org_id=1';
        
// show module menu
$page->addHtml($listsMenu->show(false));
$page->addHtml('<h1>Organisationen</h1>');

// Daten

$sql='SELECT adm_organizations.*, org_allign, org_frame_color, org_fill_color, org_text_color, org_image_orientation, org_no_link from adm_organizations_settings RIGHT JOIN adm_organizations ON adm_organizations_settings.org_id = adm_organizations.org_id';

$query=$gDb->query($sql);

	

$orgcharts=array();
	while($row=$gDb->fetch_array($query))
	{	
		$orgcharts[]=$row;
	}

$page->addHtml('<table style="width: 100%;">
                <tbody>');
foreach($orgcharts as $row)

{



$page->addHtml('<tr><td style="text-align: center;" rowspan="3"><strong>'.$row['org_id'].'</strong></td>');
$page->addHtml('<td rowspan="3"><center><a href="'.substr(__DIR__ ). '/adm_plugins/orgchart/orgchart_photo_edit.php?org_id='.$row['org_id'].'"><img src="'.substr(__DIR__ ). '/adm_plugins/orgchart/orgchart_photo_show.php?org_id='.$row['org_id'].'" alt="alt" height="90" /></a></center></td>');
$page->addHtml('<td style="text-align: center;" colspan="3">'.$row['org_longname'].'</td>');
$page->addHtml('</tr>
<tr>
<td style="background-color: '.$row['org_fill_color'].' ;">Fill</td>
<td style="background-color: '.$row['org_frame_color'].' ;">Frame</td>
<td style="background-color: '.$row['org_text_color'].' ;">Text</td>
</tr>
<tr>
<td>'. $row['org_allign'].'</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>');


}
$page->addHtml('</tbody></table>');
/****
<tr>
<td style="text-align: center;" rowspan="3"><strong>4711&nbsp;&nbsp;</strong></td>
<td rowspan="3"><center><img src="'.substr(__DIR__ ). '/adm_plugins/orgchart/orgchart_photo_show.php?org_id=1'.'" alt="alt" height="90" /></center></td>
<td style="text-align: center;" colspan="3">Clavis Argetum i.: O.: Bremen</td>
</tr>
<tr>
<td style="background-color: #00ff00;">&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
****/




$page->show();


?>
