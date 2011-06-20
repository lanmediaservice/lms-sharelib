<?php
/**
 *  Thumbnail-декоратор виджета
 * 
 *
 * @copyright 2006-2010 LanMediaService, Ltd.
 * @license    http://www.lms.by/license/1_0.txt
 * @author Ilya Spesivtsev
 * @version $Id: Thumbnail.php 407 2010-04-15 21:07:59Z macondos $
 * @package Lms_View_Widget
 */
 
/**
 * @package Lms_View_Widget
 */
class Lms_View_Decorator_Thumbnail
{
    
    function thumbnail($domImage, $width=0, $height=0, $tolerance = 0.00, $zoom = true, $force = false)
    {
        $imagePath = $domImage->getSrc();
        $thumbnailPath = Lms_Thumbnail::thumbnail($imagePath, $width, $height, $tolerance, $zoom, $force);
        $domImage->setSrc($thumbnailPath);
        if ($width) {
            $domImage->setWidth($width);
        }
        if ($height) {
            $domImage->setHeight($height);
        }
        return $domImage;
    }
}