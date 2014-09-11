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

namespace Magento\UrlRewrite\Test\Repository;

use Mtf\Repository\AbstractRepository;

/**
 * Class UrlRewrite
 * Data for creation url rewrite
 */
class UrlRewrite extends AbstractRepository
{
    /**
     * @param array $defaultConfig
     * @param array $defaultData
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __construct(array $defaultConfig = [], array $defaultData = [])
    {
        $this->_data['default'] = [
            'request_path' => 'test-test-test%isolation%.html',
            'target_path' => 'http://www.ebayinc.com/',
            'options' => 'Temporary (302)',
            'store_id' => 'Main Website/Main Website Store/Default Store View',
            'id_path' =>  ["test%isolation%"]
        ];

        $this->_data['default_without_target'] = [
            'request_path' => 'test-test-test%isolation%.html',
            'options' => 'Temporary (302)',
            'store_id' => 'Main Website/Main Website Store/Default Store View',
        ];

        $this->_data['custom_rewrite_wishlist'] = [
            'store_id' => 'Main Website/Main Website Store/Default Store View',
            'request_path' => 'wishlist/%isolation%',
            'target_path' => 'http://google.com',
            'options' => 'Temporary (302)',
            'description' => 'test description',
            'id_path' => ['entity' => "wishlist/%catalogProductSimple::100_dollar_product%"]
        ];
    }
}
