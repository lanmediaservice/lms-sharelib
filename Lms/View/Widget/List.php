<?php
/**
 * Виджет списка
 * 
 *
 * @copyright 2006-2010 LanMediaService, Ltd.
 * @license    http://www.lms.by/license/1_0.txt
 * @author Ilya Spesivtsev
 * @version $Id: List.php 291 2009-12-28 12:55:20Z macondos $
 * @package Lms_View_Widget
 */
 
/**
 * @package Lms_View_Widget
 */
class Lms_View_Widget_List extends Lms_View_Widget_Abstract
{
    
    private $_defaultItemWrapper = 'div';
    
    public function setDefaultItemWrapper($defaultItemWrapper)
    {
        $this->_defaultItemWrapper = $defaultItemWrapper;
    }
    
    public function addItem(
        Lms_View_Widget_Abstract $listItem,
        Lms_View_Widget_Abstract $editButton = null,
        Lms_View_Widget_Abstract $removeButton = null,
        $inverseAdd = false)
    {
        $itemWrapper = new Lms_View_Widget($this->_defaultItemWrapper);
        
        foreach (array(1, 2) as $step) {
            if (($inverseAdd && 1==$step) || (!$inverseAdd && 2==$step)) {
                if ($removeButton) {
                    $itemWrapper->addWidget($removeButton);
                }
                if ($editButton) {
                    $itemWrapper->addWidget($editButton);
                }
            }
            if (1==$step) {
                $itemWrapper->addWidget($listItem);
            }
        }
        $this->addWidget($itemWrapper);
    }
}