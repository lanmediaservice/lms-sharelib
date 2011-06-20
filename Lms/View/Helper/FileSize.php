<?php
/**
 * Zym
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 *
 * @author     Martin Hujer
 * @copyright  Copyright (c) 2008 Zym. (http://www.zym-project.com/)
 * @license    http://www.zym-project.com/license    New BSD License
 */


/**
 * @author     Martin Hujer
 * @copyright  Copyright (c) 2008 Zym. (http://www.zym-project.com/)
 * @license    http://www.zym-project.com/license    New BSD License
 */
class Lms_View_Helper_FileSize
{
    /**
     * Array of units available
     * 
     * @var array
     */
    protected $_units;

    /**
     * Construct
     *
     */
    public function __construct()
    {
        /**
         * @see Zend_Measure_Binary
         */
        $m = new Zend_Measure_Binary(0);
        $this->_units = $units = $m->getConversionList();
    }

    /**
     * Formats filesize with specified precision
     *
     * @param integer $fileSize Filesize in bytes
     * @param integer $precision Precision
     * @param string $norm Which norm use - 'traditional' (1 KB = 2^10 B), 'si' (1 KB = 10^3 B), 'iec' (1 KiB = 2^10 B)
     * @param string $type Defined export type
     */
    public function fileSize($fileSize, $precision = 0, $norm = 'traditional', $type = null)
    {
        try {
            $locale = Zend_Registry::get('Zend_Locale');
            if (!$locale instanceof Zend_Locale) {
                throw new Zend_Exception('Locale is not set correctly.');
            }
            $isLocaleSet = true;
        } catch (Zend_Exception $e) {
            $isLocaleSet = false;
            $locale = null;
        }
        
        
        $fileSize = floatval($fileSize);
        $m = new Zend_Measure_Binary($fileSize, null, $locale);
        
        //$m->setType('BYTE');
        
        if (null === $norm) {
            $norm = 'traditional';
        }
        
        if (isset($type)) {
            $m->setType($type);
        } elseif ($norm === 'traditional') {
            if ($fileSize >= $this->_getUnitSize('TERABYTE')) {
                $m->setType(Zend_Measure_Binary::TERABYTE);
            } else if ($fileSize >= $this->_getUnitSize('GIGABYTE')) {
                $m->setType(Zend_Measure_Binary::GIGABYTE);
            } else if ($fileSize >= $this->_getUnitSize('MEGABYTE')) {
                $m->setType(Zend_Measure_Binary::MEGABYTE);
            } else if ($fileSize >= $this->_getUnitSize('KILOBYTE')) {
                $m->setType(Zend_Measure_Binary::KILOBYTE);
            }
        } elseif ($norm === 'si') {
            if ($fileSize >= $this->_getUnitSize('TERABYTE_SI')) {
                $m->setType(Zend_Measure_Binary::TERABYTE_SI);
            } else if ($fileSize >= $this->_getUnitSize('GIGABYTE_SI')) {
                $m->setType(Zend_Measure_Binary::GIGABYTE_SI);
            } else if ($fileSize >= $this->_getUnitSize('MEGABYTE_SI')) {
                $m->setType(Zend_Measure_Binary::MEGABYTE_SI);
            } else if ($fileSize >= $this->_getUnitSize('KILOBYTE_SI')) {
                $m->setType(Zend_Measure_Binary::KILOBYTE_SI);
            }
        }  elseif ($norm === 'iec') {
            if ($fileSize >= $this->_getUnitSize('TEBIBYTE')) {
                $m->setType(Zend_Measure_Binary::TEBIBYTE);
            } else if ($fileSize >= $this->_getUnitSize('GIBIBYTE')) {
                $m->setType(Zend_Measure_Binary::GIBIBYTE);
            } else if ($fileSize >= $this->_getUnitSize('MEBIBYTE')) {
                $m->setType(Zend_Measure_Binary::MEBIBYTE);
            } else if ($fileSize >= $this->_getUnitSize('KIBIBYTE')) {
                $m->setType(Zend_Measure_Binary::KIBIBYTE);
            }
        }
        
        return $m->toString($precision);
    }

    /**
     * Get size of $unit in bytes
     * 
     * @param string $unit
     */
    protected function _getUnitSize($unit)
    {
        if (array_key_exists($unit, $this->_units)) {
            return $this->_units[$unit][0];
        }
        return 0;
    }
}