<?php
/**
 * View-хелпер для удобного создания шаблонов для trimpath
 * 
 *
 * @copyright 2006-2010 LanMediaService, Ltd.
 * @license    http://www.lms.by/license/1_0.txt
 * @author Ilya Spesivtsev
 * @version $Id: JsTemplate.php 291 2009-12-28 12:55:20Z macondos $
 * @category   Lms
 * @package    Zend_View
 * @subpackage Helper
 */
 
/**
 * @category   Lms
 * @package    Zend_View
 * @subpackage Helper
 */
class Lms_View_Helper_JsTemplate extends Zend_View_Helper_Abstract
{
    private $_captureLock;
    private $_templateName;
    
    public function jsTemplate()
    {
        return $this;
    }
    
    public function captureStart($templateName)
    {
        if ($this->_captureLock) {
            throw new Zend_View_Helper_Placeholder_Container_Exception(
                'Cannot nest headScript captures'
            );
        }
        $this->_templateName = $templateName;
        $this->_captureLock = true;
        ob_start();
    }
    public function captureEnd()
    {
        $content = ob_get_clean();
        $content = addslashes($content);
        $content = str_replace(array("\r","\n"), array("\\r","\\n"), $content);
        $this->_captureLock = false;
        $script = "TEMPLATES.{$this->_templateName} = '$content';";
        $this->view->headScript()->appendScript($script);
    }
}
