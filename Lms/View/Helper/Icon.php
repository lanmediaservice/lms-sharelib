<?php
/**
 * View-хелпер для отображения иконок
 * 
 *
 * @copyright 2006-2010 LanMediaService, Ltd.
 * @license    http://www.lms.by/license/1_0.txt
 * @author Ilya Spesivtsev
 * @version $Id: Icon.php 291 2009-12-28 12:55:20Z macondos $
 * @category   Lms
 * @package    Zend_View
 * @subpackage Helper
 */
 
/**
 * @category   Lms
 * @package    Zend_View
 * @subpackage Helper
 */
class Lms_View_Helper_Icon extends Zend_View_Helper_Abstract
{
    public function icon($name, $size)
    {
        if (!preg_match('{\.(gif|jpe?g|png)$}i', $name)) {
            $path = $this->view->findPath("img/$size/$name.png");
        } else {
            $path = $this->view->findPath("img/$size/$name");
        }
        $image = new Lms_View_Widget_Image($path);
        $image->setClass("icon");
        return $image;
    }
    
}
