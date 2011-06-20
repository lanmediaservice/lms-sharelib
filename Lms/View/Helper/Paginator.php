<?php
/**
 * View-хелпер для отображения постраничной разбивки
 * 
 *
 * @copyright 2006-2010 LanMediaService, Ltd.
 * @license    http://www.lms.by/license/1_0.txt
 * @author Ilya Spesivtsev
 * @version $Id: Paginator.php 291 2009-12-28 12:55:20Z macondos $
 * @category   Lms
 * @package    Zend_View
 * @subpackage Helper
 */
 
/**
 * @category   Lms
 * @package    Zend_View
 * @subpackage Helper
 */
class Lms_View_Helper_Paginator extends Zend_View_Helper_Abstract
{
    public function paginator($paginator, $partial)
    {
        $pages = $paginator->getPages();
        return $this->view->partial($partial, $pages);
    }
    
}
