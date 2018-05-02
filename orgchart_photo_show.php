<?php
/**
 ***********************************************************************************************
 * Show current profile photo or uploaded session photo
 *
 * @copyright 2004-2017 The Admidio Team
 * @see https://www.admidio.org/
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2.0 only
 *
 * Parameters:
 *
 * org_id    : id of user whose photo should be changed
 * new_photo : false - show current stored user photo
 *             true  - show uploaded photo of current session
 ***********************************************************************************************
 */
$plugin_folder_pos = strpos(__FILE__, 'adm_plugins') + 11;
$plugin_file_pos   = strpos(__FILE__, basename(__FILE__));
$plugin_path       = substr(__FILE__, 0, $plugin_folder_pos);
$plugin_folder     = substr(__FILE__, $plugin_folder_pos+1, $plugin_file_pos-$plugin_folder_pos-2);        

function resize_image($file, $w, $h, $crop=FALSE) {
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width-($width*abs($r-$w/$h)));
        } else {
            $height = ceil($height-($height*abs($r-$w/$h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
    }
    $src = imagecreatefromjpeg($file);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    return $dst;
}


require_once(substr(__FILE__, 0,strpos(__FILE__, 'adm_plugins')-1).'/adm_program/system/common.php');

// Initialize and check the parameters
$getOrgId   = admFuncVariableIsValid($_GET, 'org_id',    'int', array('requireValue' => true));
$getNewPhoto = admFuncVariableIsValid($_GET, 'new_photo', 'bool');
$getHigh = admFuncVariableIsValid($_GET, 'px_x', 'intl');

// lokale Variablen der Uebergabevariablen initialisieren
$image   = null;
$picPath = THEME_ADMIDIO_PATH. '/images/no_profile_pic.png';

// read user data and show error if user doesn't exists


// if user has no right to view profile then show dummy photo

    // show photo from folder adm_my_files
   $file = ADMIDIO_PATH . FOLDER_DATA . '/org_profile_image/' . $getOrgId . '.jpg';

	

   if(file_exists($file))
        {
            $picPath = $file;
        }
  

$image = new Image($picPath);
    
    // show photo from database
   
// $image = resize_image($picPath, 300, 130);

header('Content-Type: '. $image->getMimeType());
$image->copyToBrowser();
$image->delete();
