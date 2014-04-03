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
namespace Magento\GoogleShopping\Model\Resource;

class Setup extends \Magento\Core\Model\Resource\Setup
{
    /**
     * @var \Magento\GoogleShopping\Helper\Data
     */
    protected $_googleShoppingData;

    /**
     * @var \Magento\GoogleShopping\Model\ConfigFactory
     */
    protected $_configFactory;

    /**
     * @param \Magento\Core\Model\Resource\Setup\Context $context
     * @param string $resourceName
     * @param \Magento\GoogleShopping\Model\ConfigFactory $configFactory
     * @param \Magento\GoogleShopping\Helper\Data $googleShoppingData
     * @param string $moduleName
     * @param string $connectionName
     */
    public function __construct(
        \Magento\Core\Model\Resource\Setup\Context $context,
        $resourceName,
        \Magento\GoogleShopping\Model\ConfigFactory $configFactory,
        \Magento\GoogleShopping\Helper\Data $googleShoppingData,
        $moduleName = 'Magento_GoogleShopping',
        $connectionName = ''
    ) {
        $this->_configFactory = $configFactory;
        $this->_googleShoppingData = $googleShoppingData;
        parent::__construct($context, $resourceName, $moduleName, $connectionName);
    }

    /**
     * @return \Magento\GoogleShopping\Helper\Data
     */
    public function getGoogleShoppingData()
    {
        return $this->_googleShoppingData;
    }
}
