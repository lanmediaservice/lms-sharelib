<?php
/**
 * View-хелпер для показа миниатюры изображения
 * 
 *
 * @copyright 2006-2010 LanMediaService, Ltd.
 * @license    http://www.lms.by/license/1_0.txt
 * @author Ilya Spesivtsev
 * @version $Id: Thumbnail.php 407 2010-04-15 21:07:59Z macondos $
 * @category   Lms
 * @package    Zend_View
 * @subpackage Helper
 */
 
/**
 * @category   Lms
 * @package    Zend_View
 * @subpackage Helper
 */
class Lms_View_Helper_Thumbnail extends Zend_View_Helper_Abstract
{
    
    function thumbnail($imagePath, $width=0, $height=0, $tolerance = 0.00, $zoom = true, $force = false)
    {
        $image = new Lms_View_Widget_Image($imagePath);
        return $image->thumbnail($width, $height, $tolerance, $zoom, $force);
    }
}
