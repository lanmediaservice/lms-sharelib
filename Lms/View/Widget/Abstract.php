<?php
/**
 * Абстрактный класс виджета
 * 
 *
 * @copyright 2006-2010 LanMediaService, Ltd.
 * @license    http://www.lms.by/license/1_0.txt
 * @author Ilya Spesivtsev
 * @version $Id: Abstract.php 291 2009-12-28 12:55:20Z macondos $
 * @package Lms_View_Widget
 */
 
/**
 * @package Lms_View_Widget
 */
class Lms_View_Widget_Abstract
{

    protected static $_domDocument;
    
    protected $_node;
    
    public function __construct($tagName = null, $attributes = array())
    {
        if ($tagName) {
            $this->initNode($tagName, $attributes);
        }
        return $this;
    }

    public function getDomDocument()
    {
        if (!isset(self::$_domDocument)) {
            self::$_domDocument = new DOMDocument('1.0', 'UTF-8');
        }
        return self::$_domDocument;
    }
    
    
    public function getNode()
    {
        return $this->_node;
    }

    public function initNode($tagName, $attributes)
    {
        $this->_node = $this->getDomDocument()->createElement($tagName);
        foreach ($attributes as $key => $value) {
            $this->_node->setAttribute($key, $value);
        }
        $this->getDomDocument()->appendChild($this->_node);
    }
    
    public function render()
    {
        $this->_cleanup();
        return $this->getDomDocument()->saveXML($this->_node);
    }
    
    private function _isMethod($prefix, $fullMethodName, &$shortMethodName)
    {
        $regExp = '{^' . $prefix . '(.*?)$}i';
        if (preg_match($regExp, $fullMethodName, $matches)) {
            $shortMethodName = strtolower($matches[1]);
            return true;
        } else {
            return false;
        }
    }
    
    public function __call($method, $arguments = null)
    {      
        $method = strtolower($method);
        switch (true) {
            case $this->_isMethod('set', $method, $subject):
                $this->_node->setAttribute($subject, $arguments[0]);
                break;
            case $this->_isMethod('get', $method, $subject):
                return $this->_node->getAttribute($subject);
                break;
            case $this->_isMethod('remove', $method, $subject):
                $this->_node->removeAttribute($subject);
                break;
            default:
                $className = 'Lms_View_Decorator_' . ucfirst($method);
                if (class_exists($className, true)) {
                    array_unshift($arguments, $this);
                    return call_user_func_array(
                        array($className, $method),
                        $arguments
                    );
                } else {
                    throw new Lms_Exception(
                        "Decorator class $className not found"
                    );
                }
                break;
        }
        return $this;
    }
    
    public function __toString()
    {
        return $this->render();
    }
    
    public function setValue($value)
    {
        switch ($this->_node->nodeName) {
            case 'input':
                $this->_node->setAttribute('value', $value);
                break;
            case 'select':
                $this->_node->setAttribute('value', $value);
                $options = $this->_node->childNodes;
                for ($i=0; $i<$options->length; $i++) {
                    if ($value == $options->item($i)->getAttribute('value')) {
                        $options->item($i)->setAttribute(
                            'selected', 'selected'
                        );
                    }
                }
                break;
            default:
                $text = $this->getDomDocument()->createTextNode($value);
                $this->_node->appendChild($text);
                break;
        }
        return $this;
    }
    
    public function getValue()
    {
        //TODO: input/select
       return $this->_node->nodeValue; 
    }
    
    private function _cleanup()
    {
        //приведение к валидному коду;
    }
    
    protected function addWidget(Lms_View_Widget_Abstract $widget)
    {
        if ($widget instanceof Lms_View_Widget_NullWrapper) {
            foreach ($widget->getNode()->childNodes as $node) {
                $this->_node->appendChild($node);
            }
        } else {
            $this->_node->appendChild($widget->getNode());
        }
    }
}