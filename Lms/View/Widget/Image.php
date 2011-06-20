<?php
/**
 * Виджет изображения (<IMG>)
 * 
 *
 * @copyright 2006-2010 LanMediaService, Ltd.
 * @license    http://www.lms.by/license/1_0.txt
 * @author Ilya Spesivtsev
 * @version $Id: Image.php 291 2009-12-28 12:55:20Z macondos $
 * @package Lms_View_Widget
 */
 
/**
 * @package Lms_View_Widget
 */

class Lms_View_Widget_Image extends Lms_View_Widget_Abstract
{
    
    public function __construct($src = null)
    {
        $attributes = array();
        if ($src) {
            $attributes['src'] = $src;
        }
        return parent::__construct('img', $attributes);
    }
}