<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Filter
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */

/**
 * Localizes given normalized input
 *
 * @category   Zend
 * @package    Zend_Filter
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Filter_NormalizedToLocalized implements Zend_Filter_Interface
{
    /**
     * Set options
     */
    protected $_options = array(
        'locale'      => null,
        'date_format' => null,
        'precision'   => null
    );

    /**
     * Class constructor
     *
     * @param array|Zend_Config $options (Optional) Locale to set
     */
    public function __construct($options = null)
    {
        if ($options instanceof Zend_Config) {
            $options = $options->toArray();
        }

        if (null !== $options) {
            $this->setOptions($options);
        }
    }

    /**
     * Returns the set options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->_options;
    }

    /**
     * Sets options to use
     *
     * @param  array|null $options (Optional) Options to use
     * @return $this
     */
    public function setOptions(array|null $options = null)
    {
        $this->_options = $options + $this->_options;
        return $this;
    }

    /**
     * Defined by Zend_Filter_Interface
     *
     * Normalizes the given input
     *
     * @param  string|array $value Value to normalized
     * @return string|array The normalized value
     */
    public function filter($value)
    {
        if (is_array($value)) {
            $date = new Zend_Date($value, $this->_options['locale']);
            return $date->toString($this->_options['date_format']);
        } elseif ($this->_options['precision'] === 0) {
            return Zend_Locale_Format::toInteger($value, $this->_options);
        } elseif ($this->_options['precision'] === null) {
            return Zend_Locale_Format::toFloat($value, $this->_options);
        }

        return Zend_Locale_Format::toNumber($value, $this->_options);
    }
}
