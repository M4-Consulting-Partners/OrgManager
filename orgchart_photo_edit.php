<?php
/**
 ***********************************************************************************************
 * Upload and save new user photo
 *
 * @copyright 2004-2017 The Admidio Team
 * @see https://www.admidio.org/
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2.0 only
 *
 * Parameters:
 *
 * org_id           : id of user whose photo should be changed
 * mode - choose    : default mode to choose the photo file you want to upload
 *        save      : save new photo in user recordset
 *        dont_save : delete photo in session and show message
 *        upload    : save new photo in session and show dialog with old and new photo
 *        delete    : delete current photo in database
 ***********************************************************************************************
 */

$plugin_folder_pos = strpos(__FILE__, 'adm_plugins') + 11;
$plugin_file_pos   = strpos(__FILE__, basename(__FILE__));
$plugin_path       = substr(__FILE__, 0, $plugin_folder_pos);
$plugin_folder     = substr(__FILE__, $plugin_folder_pos+1, $plugin_file_pos-$plugin_folder_pos-2);        



require_once(substr(__FILE__, 0,strpos(__FILE__, 'adm_plugins')-1).'/adm_program/system/common.php');
require_once(substr(__FILE__, 0,strpos(__FILE__, 'adm_plugins')-1).'/adm_program/system/login_valid.php');

// Initialize and check the parameters
$getOrgId = admFuncVariableIsValid($_GET, 'org_id', 'int',    array('requireValue' => true));
$getMode   = admFuncVariableIsValid($_GET, 'mode',   'string', array('defaultValue' => 'choose', 'validValues' => array('choose', 'save', 'dont_save', 'upload', 'delete')));

/*****************************Foto hochladen*************************************/
if($getMode === 'choose')
{   // create html page object
    $page = new HtmlPage($headline);

    // add back link to module menu
    $profilePhotoMenu = $page->getMenu();
    $profilePhotoMenu->addItem('menu_item_back', $gNavigation->getPreviousUrl(), '<--', 'back.png');
    $page->addHtml('<H1>Organisationsname</H1>');
    $form = new HtmlForm('upload_files_form', ADMIDIO_URL.FOLDER_PLUGINS.'/orgchart/orgchart_photo_edit.php?mode=upload&amp;org_id='.$getOrgId, $page, array('enableFileUpload' => true));
    $form->addCustomContent('Derzeitiges Organisationsbild', '<img class="imageFrame" src="orgchart_photo_show.php?org_id='.$getOrgId.'" alt="leer" />');
    $form->addFileUpload('foto_upload_file', $gL10n->get('PRO_CHOOSE_PHOTO'), array('allowedMimeTypes' => array('image/jpeg', 'image/png'), 'helpTextIdLabel' => 'profile_photo_up_help'));
    $form->addSubmitButton('btn_upload', $gL10n->get('PRO_UPLOAD_PHOTO'), array('icon' => THEME_URL.'/icons/photo_upload.png', 'class' => ' col-sm-offset-3'));


    $page->addHtml($form->show(false));
    $page->show();
} elseif($getMode === 'upload')
{

    /*****************************Foto zwischenspeichern bestaetigen***********************************/

    // File size
    if ($_FILES['userfile']['error'][0] === UPLOAD_ERR_INI_SIZE)
    {
        $gMessage->show($gL10n->get('PRO_PHOTO_FILE_TO_LARGE', round(admFuncMaxUploadSize()/pow(1024, 2))));
        // => EXIT
    }

    // Kontrolle ob Fotos ausgewaehlt wurden
    if(!is_file($_FILES['userfile']['tmp_name'][0]))
    {
        $gMessage->show($gL10n->get('PRO_PHOTO_NOT_CHOOSEN'));
        // => EXIT
    }

    // File ending
    $imageProperties = getimagesize($_FILES['userfile']['tmp_name'][0]);
    if ($imageProperties['mime'] !== 'image/jpeg' && $imageProperties['mime'] !== 'image/png')
    {
        $gMessage->show($gL10n->get('PRO_PHOTO_FORMAT_INVALID'));
        // => EXIT
    }

    // Auflösungskontrolle
    $imageDimensions = $imageProperties[0] * $imageProperties[1];
    if($imageDimensions > admFuncProcessableImageSize())
    {
        $gMessage->show($gL10n->get('PRO_PHOTO_RESOLUTION_TO_LARGE', round(admFuncProcessableImageSize()/1000000, 2)));
        // => EXIT
    }

    // Foto auf entsprechende Groesse anpassen
    $userImage = new Image($_FILES['userfile']['tmp_name'][0]);
    $userImage->setImageType('jpeg');
    $userImage->scale(130, 170);

    // Ordnerspeicherung
    $userImage->copyToFile(null, ADMIDIO_PATH . FOLDER_DATA . '/org_profile_image/' . $getOrgId . '_new.jpg');

    // create html page object
    $page = new HtmlPage($headline);
    $page->addJavascript('$("#btn_cancel").click(function() {
        self.location.href=\''.ADMIDIO_URL.FOLDER_PLUGINS.'/orgchart/orgchart_photo_edit.php?mode=dont_save&org_id='.$getOrgId.'\';
    });', true);

    // show form									
    $form = new HtmlForm('show_new_profile_picture_form', ADMIDIO_URL.FOLDER_PLUGINS.'/orgchart/orgchart_photo_edit.php?mode=save&amp;org_id='.$getOrgId, $page);
    $form->addCustomContent($gL10n->get('PRO_CURRENT_PICTURE'), '<img class="imageFrame" src="orgchart_photo_show.php?org_id='.$getOrgId.'" alt="'.$gL10n->get('PRO_CURRENT_PICTURE').'" />');
    $form->addCustomContent($gL10n->get('PRO_NEW_PICTURE'), '<img class="imageFrame" src="orgchart_photo_show_new.php?org_id='.$getOrgId.'" alt="'.$gL10n->get('PRO_NEW_PICTURE').'" />');
    $form->addLine();
    $form->addSubmitButton('btn_update', $gL10n->get('SYS_APPLY'), array('icon' => THEME_URL.'/icons/database_in.png'));
    $form->addButton('btn_cancel', $gL10n->get('SYS_ABORT'), array('icon' => THEME_URL.'/icons/error.png'));

    // add form to html page and show page
    $page->addHtml($form->show(false));
    $page->show();

    

}

if($getMode === 'save')
{
    /*****************************Foto speichern*************************************/

            // Foto im Dateisystem speichern

        // Nachsehen ob fuer den User ein Photo gespeichert war
        $fileOld = ADMIDIO_PATH . FOLDER_DATA . '/org_profile_image/' . $getOrgId . '_new.jpg';
        if(is_file($fileOld))
        {
            $fileNew = ADMIDIO_PATH . FOLDER_DATA . '/org_profile_image/' . $getOrgId . '.jpg';
            if(is_file($fileNew))
            {
                unlink($fileNew);
            }

            rename($fileOld, $fileNew);
        }

	    // zur Ausgangsseite zurueck
    	$gNavigation->deleteLastUrl();
	admRedirect(ADMIDIO_URL . FOLDER_PLUGINS.'/orgchart/orgchart_list.php');
    	// => EXIT
} elseif($getMode === 'dont_save')
{
    /*****************************Foto nicht speichern*************************************/
    // Ordnerspeicherung
    
        $file = ADMIDIO_PATH . FOLDER_DATA . '/org_profile_image/' . $getOrgId . '_new.jpg';
        if(is_file($file))
        {
            unlink($file);
        }

	    // zur Ausgangsseite zurueck
    	$gNavigation->deleteLastUrl();
	admRedirect(ADMIDIO_URL . FOLDER_PLUGINS.'/orgchart/orgchart_list.php');
    	// => EXIT
}


