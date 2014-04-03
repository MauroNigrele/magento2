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
namespace Magento\DesignEditor\Model;

class AreaEmulatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $_objectManager;

    /**
     * @var AreaEmulator
     */
    protected $_model;

    protected function setUp()
    {
        $this->_objectManager = $this->getMock('Magento\ObjectManager');
        $this->_model = new AreaEmulator($this->_objectManager);
    }

    public function testEmulateLayoutArea()
    {
        $configuration = array(
            'Magento\Core\Model\Layout' => array(
                'arguments' => array(
                    'area' => array(
                        \Magento\ObjectManager\Config\Reader\Dom::TYPE_ATTRIBUTE => 'string',
                        'value' => 'test_area'
                    )
                )
            )
        );
        $this->_objectManager->expects($this->once())->method('configure')->with($configuration);
        $this->_model->emulateLayoutArea('test_area');
    }
}
