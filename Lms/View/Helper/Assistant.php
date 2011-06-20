<?php
/**
 * View-хелпер для подсказок
 * 
 *
 * @copyright 2006-2010 LanMediaService, Ltd.
 * @license    http://www.lms.by/license/1_0.txt
 * @author Ilya Spesivtsev
 * @version $Id: Assistant.php 291 2009-12-28 12:55:20Z macondos $
 * @category   Lms
 * @package    Zend_View
 * @subpackage Helper
 */
 
/**
 * @category   Lms
 * @package    Zend_View
 * @subpackage Helper
 */
class Lms_View_Helper_Assistant extends Zend_View_Helper_Abstract
{
    private $_text = '';
    private $_arrow;
    private $_captureLock;
    
    public function assistant($text = null, $arrow = 'left')
    {
        if (!$this->_captureLock) {
            $this->_text = $text;
            $this->_arrow = $arrow;
        }
        return $this;
    }
    
    public function captureStart()
    {
        if ($this->_captureLock) {
            throw new Zend_View_Helper_Placeholder_Container_Exception(
                'Cannot nest headScript captures'
            );
        }
        $this->_captureLock = true;
        ob_start();
        return $this;
    }
    public function captureEnd()
    {
        $this->_text .= ob_get_clean();
        $this->_captureLock = false;
        return $this;
    }
    
    public function __toString()
    {
        $output = <<<TEXT
            <div class="corner-box">
                <div class="corner tl"></div>
                <div class="corner tr"></div>
                <div class="corner bl"></div>
                <div class="corner br"></div>
                <div class="corner-box-inner">
                    {$this->_text}
                </div>
            </div>
TEXT;
        switch ($this->_arrow) {
            case 'left':
        $output = <<<TEXT
<table class="assistant">
    <tr>
        <td class="arrow left"></td>
        <td class="text ">
            $output
        </td>
    </tr>
</table>
TEXT;
                break;
            case 'right':
                break;
            case 'top':
                break;
            case 'bottom':
                break;
            default:
            case 'left':
        $output = <<<TEXT
<table class="assistant">
    <tr>
        <td class="text ">
            $output
        </td>
    </tr>
</table>
TEXT;
                break;
        }
        return $output;
    }
}
