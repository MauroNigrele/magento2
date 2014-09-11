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
 * @copyright   Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Magento\Bundle\Service\V1\Data\Product\Link;

use Magento\Framework\Service\Data\AbstractExtensibleObjectBuilder;

/**
 * @codeCoverageIgnore
 */
class MetadataBuilder extends AbstractExtensibleObjectBuilder
{
    /**
     * @param string $value
     * @return $this
     */
    public function setSku($value)
    {
        return $this->_set(Metadata::SKU, $value);
    }

    /**
     * @param float $value
     * @return $this
     */
    public function setQty($value)
    {
        return $this->_set(Metadata::QTY, $value);
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setPosition($value)
    {
        return $this->_set(Metadata::POSITION, $value);
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setOptionId($value)
    {
        return $this->_set(Metadata::OPTION_ID, $value);
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function setDefined($value)
    {
        return $this->_set(Metadata::DEFINED, (bool)$value);
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function setDefault($value)
    {
        return $this->_set(Metadata::IS_DEFAULT, (bool)$value);
    }

    /**
     * @param float $value
     * @return $this
     */
    public function setPrice($value)
    {
        return $this->_set(Metadata::PRICE, $value);
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setPriceType($value)
    {
        return $this->_set(Metadata::PRICE_TYPE, $value);
    }
}
