<?php
/**
 * View-хелпер для возможности добвалять inline-скрипты с заданной позицией 
 * 
 *
 * @copyright 2006-2010 LanMediaService, Ltd.
 * @license    http://www.lms.by/license/1_0.txt
 * @author Ilya Spesivtsev
 * @version $Id: HeadScriptOffsetCapture.php 291 2009-12-28 12:55:20Z macondos $
 * @category   Lms
 * @package    Zend_View
 * @subpackage Helper
 */
 
/**
 * @category   Lms
 * @package    Zend_View
 * @subpackage Helper
 */
class Lms_View_Helper_HeadScriptOffsetCapture extends Zend_View_Helper_Abstract
{
    private $_captureLock;
    private $_offset;
    
    public function headScriptOffsetCapture()
    {
        return $this;
    }
    
    public function captureStart($offset)
    {
        if ($this->_captureLock) {
            throw new Zend_View_Helper_Placeholder_Container_Exception(
                'Cannot nest headScript captures'
            );
        }
        $this->_offset = $offset;
        $this->_captureLock = true;
        ob_start();
    }
    public function captureEnd()
    {
        $content = ob_get_clean();
        $this->_captureLock = false;
        $this->view->headScript()->offsetSetScript($this->_offset, $content);
    }
}
