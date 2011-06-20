<?php
/**
 * View-хелпер для поиска файлов в public
 * директории по путям сохраненным в переменной
 * view->publicTemplates
 * 
 *
 * @copyright 2006-2010 LanMediaService, Ltd.
 * @license    http://www.lms.by/license/1_0.txt
 * @author Ilya Spesivtsev
 * @version $Id: FindPath.php 291 2009-12-28 12:55:20Z macondos $
 * @category   Lms
 * @package    Zend_View
 * @subpackage Helper
 */
 
/**
 * @category   Lms
 * @package    Zend_View
 * @subpackage Helper
 */
class Lms_View_Helper_FindPath extends Zend_View_Helper_Abstract
{
    function findPath($path)
    {
        if (!$this->view->publicTemplates
            || !is_array($this->view->publicTemplates)
        ) {
            throw new Lms_Exception(
                'Template paths must be defined in "publicTemplates" variable'
            );
        }
        foreach ($this->view->publicTemplates as $publicTemplate) {
            if (file_exists($publicTemplate['path'] . '/' . $path)) {
                return $publicTemplate['url'] . '/' . $path;
            }
        }
        return $this->view->rootUrl . '/' . $path;
    }
}
