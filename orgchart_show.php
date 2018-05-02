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

//global $g_tbl_praefix;
//$tablename=$g_tbl_praefix.'_organizations';

require_once(substr(__FILE__, 0,strpos(__FILE__, 'adm_plugins')-1).'/adm_program/system/common.php');



$page = new HtmlPage('Organisations Chart');
$headline = 'Test';
//Begin der Seite
// Update Hilfstabelle
$sql2 ='INSERT INTO adm_organizations_settings (org_id) select adm_organizations.org_id as org_id_1 FROM adm_organizations left join adm_organizations_settings on adm_organizations.org_id = adm_organizations_settings.org_id where adm_organizations_settings.org_id is null';
$query2=$gDb->query($sql2);

// create module menu
$listsMenu = new HtmlNavbar('menu_lists_list', $headline, $page);

	// show link to pluginpreferences 
	$listsMenu->addItem('admMenuItemPreferencesLists', substr(__DIR__ ). '/adm_plugins/orgchart/preferences.php', 
                        'Einstellungen', 'options.png', 'right');          
	$listsMenu->addItem('admMenua', substr(__DIR__ ). '/adm_plugins/orgchart/orgchart_list.php', 
                        'Organisationsliste', 'application_view_list.png', 'right');    
	$listsMenu->addItem('admMenub', substr(__DIR__ ). '/adm_plugins/orgchart/orgchart_own.php', 
                        'Eigene Organisation', 'application_view_list.png', 'right');    
        
// show module menu
$page->addHtml($listsMenu->show(false));

//*********************************** addJavascript
$page->addJavascriptFile(substr(__DIR__ ). '/adm_plugins/orgchart/Script/orgchart.js');

$page->addJavascript('function openAsPng(id){window.open(document.getElementById(id).toDataURL("image/png"));}');
$page->addJavascript('function saveAsPng(id){ ');
$page->addJavascript('var img = document.getElementById(id).toDataURL("image/png"); ');
$page->addJavascript('document.location.href = img.replace("image/png", "image/octet-stream");} ');

//*******************************************

//$page->addHtml('<a href = "javascript:openAsPng(\'canvas1\');">klick</a><BR>');
//$page->addHtml('<a href = "javascript:saveAsPng(\'canvas1\');">klick</a><BR>');


$page->addHtml('<h1>Organisations-Chart</h1>');
/********************************************
* Parameterwerte
*
*
********************************************/
$Gr_x = 200;
$Gr_y = 50;
$Sp_x = 20;
$Sp_y = 20;
$Of_x = 30;

$R_o = 30;
$R_u = 5;
$S_w = 3;

/********************************************
* Berechnung Anzeigebereich
********************************************/
global $g_tbl_praefix;

$tablename=$g_tbl_praefix.'_organizations';

$sql1='SELECT * from '.$tablename;

$query1=$gDb->query($sql1);
$orgcharts1=array();
	while($row1=$gDb->fetch_array($query1))
	{	
		$orgcharts1[]=$row1;
	}
$lines = 0;
foreach($orgcharts1 as $row1)

{
$lines = $lines + $Gr_y + 20 + $Sp_y;
}//end while

$lines = $lines + $S_w;

/********************************************
* Anlegen Anzeigebereich
********************************************/
$page->addHtml('<canvas id="canvas1" width="800" height="'.$lines.'"></canvas>');

$page->addHtml('<script type="text/javascript">');
$page->addHtml('var o = new orgChart();');

$Sp_y = $Sp_y +20;

$page->addHtml('o.setSize('.$Gr_x.', '.$Gr_y.', '.$Sp_x.', '.$Sp_y.', '.$Of_x.');');
$page->addHtml('o.setNodeStyle('.$R_o.', '.$R_u.', '.$S_w.');');


/********************************/
//global $g_tbl_praefix;
//$tablename=$g_tbl_praefix.'_organizations';

$sql='SELECT adm_organizations.*, org_allign, org_frame_color, org_fill_color, org_text_color, org_image_orientation, org_no_link from adm_organizations_settings RIGHT JOIN adm_organizations ON adm_organizations_settings.org_id = adm_organizations.org_id';

$query=$gDb->query($sql);

	

$orgcharts=array();
	while($row=$gDb->fetch_array($query))
	{	
		$orgcharts[]=$row;
	}

foreach($orgcharts as $row)

{
    if ($row['org_allign'] == null)
    {
        $org_allignv = 'r';
    } else {
        $org_allignv = $row['org_allign'];
    }
   
    if ($row['org_fill_color'] == null)
    {
        $org_fillcolor = '';
    } else {
        $org_fillcolor = $row['org_fill_color'];
    }

    if ($row['org_frame_color'] == null)
    {
        $org_framecolor = '';
    } else {
        $org_framecolor = $row['org_frame_color'];
    }

    if ($row['org_text_color'] == null)
    {
        $org_textcolor = '';
    } else {
        $org_textcolor = $row['org_text_color'];
    }


$org_imagelink = 'orgchart_photo_show.php?org_id='.$row['org_id'];


    if ($row['org_image_orientation'] == null)
    {
        $org_imageorientation = 'lm';
    } else {
        $org_imageorientation = $row['org_image_orientation'];
    }

    if ($row['org_no_link'] == true)
    {
        $org_link = '';
    } else {
        $org_link = $row['org_homepage'];
    }

	
	$org_name = $row['org_longname'];

    if ($row['org_id'] == $gCurrentOrganization->getValue('org_id'))
    {
        $org_framecolor = '#00FF00';
        $org_fillcolor = '#00FF00';
    } else {
       // $org_imageorientation = $row['org_image_orientation'];
    }

	

$page->addHtml('o.addNode(\''.$row['org_id'].'\', \''.$row['org_org_id_parent'].'\', \''.$org_allignv.'\', \''. $org_name.'\', \'0\', \''.$org_link.'\',\''.$org_framecolor.'\',\''.$org_fillcolor.'\',\''.$org_textcolor.'\',\''.$org_imagelink.'\',\''.$org_imageorientation.'\');');
}//end while

//Ende Datenbereich
/********************************/




$page->addHtml('o.drawChart(\'canvas1\');');
$page->addHtml('</script>');
$page->show();
?>
