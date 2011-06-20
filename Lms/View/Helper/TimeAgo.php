<?php
/**
 * View-хелпер для отображения дат откносительно другого времени
 * 
 *
 * @copyright 2006-2010 LanMediaService, Ltd.
 * @license    http://www.lms.by/license/1_0.txt
 * @author Ilya Spesivtsev
 * @version $Id: update.php 162 2009-11-17 10:55:13Z macondos $
 * @category   Lms
 * @package    Zend_View
 * @subpackage Helper
 */
 
/**
 * @category   Lms
 * @package    Zend_View
 * @subpackage Helper
 */
class Lms_View_Helper_TimeAgo extends Zend_View_Helper_Abstract
{
    function timeAgo($dateStr, $limitReturnChunks = 1, $units = Lms_Date::DEFAULT_UNITS, $precision = 0.5) {
        return Lms_Date::timeAgo($dateStr, $limitReturnChunks, $this->view->t, $this->view->lang, $units, $precision);
    }
}
