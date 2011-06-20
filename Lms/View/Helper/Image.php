<?php
/**
 * View-хелпер для отображения картинок
 * 
 *
 * @copyright 2006-2010 LanMediaService, Ltd.
 * @license    http://www.lms.by/license/1_0.txt
 * @author Ilya Spesivtsev
 * @version $Id: Image.php 291 2009-12-28 12:55:20Z macondos $
 * @category   Lms
 * @package    Zend_View
 * @subpackage Helper
 */
 
/**
 * @category   Lms
 * @package    Zend_View
 * @subpackage Helper
 */
class Lms_View_Helper_Image extends Zend_View_Helper_Abstract
{
    function image($relativePath)
    {
        $path = $this->view->findPath($relativePath);
        $image = new Lms_View_Widget_Image($path);
        return $image;
    }
    
}
