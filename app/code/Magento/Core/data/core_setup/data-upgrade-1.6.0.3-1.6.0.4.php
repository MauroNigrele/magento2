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
 * @package     Magento_Core
 * @copyright   Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/** @var $installer \Magento\Core\Model\Resource\Setup\Migration */
$installer = $this->_migrationFactory->create(array('resourceName' => 'core_setup'));
$installer->startSetup();

$installer->appendClassAliasReplace(
    'core_config_data',
    'value',
    \Magento\Core\Model\Resource\Setup\Migration::ENTITY_TYPE_MODEL,
    \Magento\Core\Model\Resource\Setup\Migration::FIELD_CONTENT_TYPE_PLAIN,
    array('config_id')
);
$installer->appendClassAliasReplace(
    'core_layout_update',
    'xml',
    \Magento\Core\Model\Resource\Setup\Migration::ENTITY_TYPE_BLOCK,
    \Magento\Core\Model\Resource\Setup\Migration::FIELD_CONTENT_TYPE_XML,
    array('layout_update_id')
);
$installer->doUpdateClassAliases();

$installer->endSetup();
