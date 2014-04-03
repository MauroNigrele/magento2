<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Magento
 * @package     Magento_Catalog
 * @copyright   Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Magento\Catalog\Model\Config\Source;

/**
 * Catalog products per page on Grid mode source
 *
 * @category   Magento
 * @package    Magento_Catalog
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class GridPerPage implements \Magento\Option\ArrayInterface
{
    /**
     * Options
     *
     * @var array
     */
    protected $_options;

    /**
     * Constructor
     *
     * @param string $perPageValues
     */
    public function __construct($perPageValues)
    {
        $this->_options = explode(',', $perPageValues);
    }

    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        $result = array();
        foreach ($this->_options as $option) {
            $result[] = array('value' => $option, 'label' => $option);
        }
        return $result;
    }
}
