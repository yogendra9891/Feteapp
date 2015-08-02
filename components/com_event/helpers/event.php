<?php
/**
 * @version     1.0.0
 * @package     com_event
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      yogendra9891 <yogendra.singh@daffodilsw.com> - http://
 */

defined('_JEXEC') or die;
define('IMG_UPLOAD_DIR_PATH', 'media/com_event/event/original/');
define('IMG_THUMB_UPLOAD_DIR_PATH', 'media/com_event/event/thumb/');

abstract class EventHelper
{
	public static function myFunction()
	{
		$result = 'Something';
		return $result;
	}
	/**
	 * gets a list of options for country.
	 *
	 * @return	option array
	 */

	public static function getCountryOptions()
		{
			// Initialize variables.
			$options = array();
	
			$db		= JFactory::getDbo();
			$query	= $db->getQuery(true);
	
			$query->select('a.ccode As value, a.country As text');
			$query->from('#__countries AS a');
			$query->order('a.country');
			// Get the options.
			$db->setQuery($query);
	
			$options = $db->loadObjectList();
	        
			// Check for a database error.
			if ($db->getErrorNum()) {
				JError::raiseWarning(500, $db->getErrorMsg());
			}
	
			// Merge any additional options in the XML definition.
			//$options = array_merge(parent::getOptions(), $options);
	
			array_unshift($options, JHtml::_('select.option', '0', JText::_('Select Country')));
	
			return $options;
		}
	/**
	 * gets a list of options for Eventtype.
	 *
	 * @return	option array
	 */

	public static function getEventtypeOptions()
		{
			// Initialize variables.
			$options = array();
	
			$db		= JFactory::getDbo();
			$query	= $db->getQuery(true);
	
			$query->select('a.id As value, a.name As text');
			$query->from('#__eventtypes AS a');
			$query->order('a.name');
			// Get the options.
			$db->setQuery($query);
	
			$options = $db->loadObjectList();
	        
			// Check for a database error.
			if ($db->getErrorNum()) {
				JError::raiseWarning(500, $db->getErrorMsg());
			}
	
			// Merge any additional options in the XML definition.
			//$options = array_merge(parent::getOptions(), $options);
	
			array_unshift($options, JHtml::_('select.option', '0', JText::_('Select Eventtype')));
	
			return $options;
		}
	/**
	 * gets a list of options for Dresscode.
	 *
	 * @return	option array
	 */

	public static function getDresscodeOptions()
		{
			// Initialize variables.
			$options = array();
	
			$db		= JFactory::getDbo();
			$query	= $db->getQuery(true);
	
			$query->select('a.id As value, a.name As text');
			$query->from('#__dresscodes AS a');
			$query->order('a.name');
			// Get the options.
			$db->setQuery($query);
	
			$options = $db->loadObjectList(); 
	        
			// Check for a database error.
			if ($db->getErrorNum()) {
				JError::raiseWarning(500, $db->getErrorMsg());
			}
	
			// Merge any additional options in the XML definition.
			//$options = array_merge(parent::getOptions(), $options);
	
			array_unshift($options, JHtml::_('select.option', '0', JText::_('Select Dresscode')));
	
			return $options;
		}
		/*
		 * get the time hours getMinutesOptions
		 */
	public static function getHoursOptions(){
			// Initialize variables.
			$options = array();
			for($i=0; $i<24; $i++){
				if($i < 9){
					$options[$i]->value = ('0'.($i+1));
					$options[$i]->text = ('0'.($i+1));
				}
				else{
					$options[$i]->value = $i+1;
					$options[$i]->text = $i+1;
				}
			} 
			// Merge any additional options in the XML definition.
			// $options = array_merge(parent::getOptions(), $options);
			array_unshift($options, JHtml::_('select.option'));
			return $options;
	}	
		/*
		 * get the time getSecondsOptions
		 */
	public static function getSecondsOptions(){
			// Initialize variables.
			$options2 = array();
			for($i=0; $i<59; $i++){
				if($i < 9){
					$options2[$i]->value = ('0'.($i));
					$options2[$i]->text = ('0'.($i));
				}
				else{
					$options2[$i]->value = $i+1;
					$options2[$i]->text = $i+1;
				}
			} 
			// Merge any additional options in the XML definition.
			// $options = array_merge(parent::getOptions(), $options);
			array_unshift($options2, JHtml::_('select.option'));
			return $options2;
	}	
	
			/*
		 * get the time  MinutesOptions
		 */
	public static function getMinutesOptions(){
			// Initialize variables.
			$options1 = array();
			for($i=0; $i<59; $i++){
				if($i < 9){
					$options1[$i]->value = ('0'.($i));
					$options1[$i]->text = ('0'.($i));
				}
				else{
					$options1[$i]->value = $i+1;
					$options1[$i]->text = $i+1;
				}
			} 
			// Merge any additional options in the XML definition.
			// $options = array_merge(parent::getOptions(), $options);
			array_unshift($options1, JHtml::_('select.option'));
			return $options1;
	}	
	/*
     * function for checking the usertype(Promotors OR Regular member)
     */
    public static function chkusertype(){
    	$user		= JFactory::getUser();
        $userId		= $user->get('id');
		// Create a new query object.
		$db = JFactory::getdbo();
		$query = $db->getQuery(true);
		$query->select('b.usertype, a.id as userid');
		$query->from('#__users as a');
		$query->join('INNER', $db->quoteName('#__feteappusers').' AS b ON a.id = b.userid');
		$query->where('a.id = '.$userId);
		$db->setQuery($query); 
		$result = $db->loadObject();
		return $result;
    }
	/*
	 * function for finding the promotor name
	 */
    public static function promotorname(){
    	$user		= JFactory::getUser();
        $userId		= $user->get('id');
        // Create a new query object.
		$db = JFactory::getdbo();
		$query = $db->getQuery(true);
		$query->select('b.promotorname, a.id as userid');
		$query->from('#__users as a');
		$query->join('INNER', $db->quoteName('#__feteappusers').' AS b ON a.id = b.userid');
		$query->where('a.id = '.$userId);
		$db->setQuery($query); 
		$result = $db->loadObject();
		return $result;
    }
        /*
     * function for uplaoding a event picture.....
     */

	public static function ImageUpload($file){ 
		$response = array();
		$response['error'] = false;
		$response['msg'] = '';
		$response['src'] = '';
		// Make the file name safe.
		jimport('joomla.filesystem.file');
		$user = JFactory::getUser();
		$filename = $file['name'] = time().self::clean(JFile::makeSafe(strtolower($file['name'])));

		// Move the uploaded file into a permanent location.
		if (isset( $file['tmp_name'] )) {  
			// Make sure that the full file path is safe.
			$filepath = JPath::clean( IMG_UPLOAD_DIR_PATH.strtolower( $file['name'] ) );
			// Move the uploaded file.
			if(JFile::upload( $file['tmp_name'], $filepath )){
			 // if orignal file uploaded then create thumb..
			 	EventHelper::createThumbnail($filename);
			}else{
				$response['error'] = true;
				$response['msg'] = JText::_('COM_EVENT_UPLOAD_FAILED'); 
			}
		}   
		return $filename;
	}

	/*
	 * creating a thumb of the profile image... 
	 * reading the file from orignal folder and create its thumbs..
	 */
	public static function createThumbnail($filename) {   
        $path_to_thumbs_directory = IMG_THUMB_UPLOAD_DIR_PATH; 
    	$path_to_image_directory =  JURI::root().IMG_UPLOAD_DIR_PATH; 
    	$final_width_of_image = 150;  
   
        if(preg_match('/[.](jpg)$/', $filename)) {  
            $im = imagecreatefromjpeg($path_to_image_directory . $filename);  
        } else if (preg_match('/[.](jpeg)$/', $filename)) {  
            $im = imagecreatefromjpeg($path_to_image_directory . $filename);  
        } else if (preg_match('/[.](gif)$/', $filename)) {  
            $im = imagecreatefromgif($path_to_image_directory . $filename);  
        } else if (preg_match('/[.](png)$/', $filename)) {  
            $im = imagecreatefrompng($path_to_image_directory . $filename);  
        }  
        $ox = imagesx($im);  
        $oy = imagesy($im);  
        $ratio = $ox / $oy;
		$nx = $ny = min($final_width_of_image, max($ox, $oy));
		if ($ratio < 1) {
 		   $nx = $ny * $ratio;
		} else {
           $ny = $nx / $ratio;
		}
		
        $nm = imagecreatetruecolor($nx, $ny);  
        imagecopyresized($nm, $im, 0,0,0,0,$nx,$ny,$ox,$oy);  
        if(!file_exists($path_to_thumbs_directory)) {  
          if(!mkdir($path_to_thumbs_directory)) {  
               die("There was a problem. Please try again!");  
          }  
           }
        imagejpeg($nm, $path_to_thumbs_directory . $filename);   
		return true;
	}  
	/**
	 * Method to remove space from the string
	 * @param unknown_type $string
	 */
	public function clean($string){
		return JString::str_ireplace(' ', '', $string);
	}
	
}

