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
namespace Magento\Index\Model\Indexer\Config;

class SchemaLocatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Magento\Index\Model\Indexer\Config\SchemaLocator
     */
    protected $_model;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $_modulesReaderMock;

    protected function setUp()
    {
        $this->_modulesReaderMock = $this->getMock('Magento\Module\Dir\Reader', array(), array(), '', false);

        $this->_modulesReaderMock->expects(
            $this->any()
        )->method(
            'getModuleDir'
        )->with(
            'etc',
            'Magento_Index'
        )->will(
            $this->returnValue('some_path')
        );

        $this->_model = new \Magento\Index\Model\Indexer\Config\SchemaLocator($this->_modulesReaderMock);
    }

    /**
     * @covers \Magento\Index\Model\Indexer\Config\SchemaLocator::getSchema
     */
    public function testGetSchema()
    {
        $expectedSchema = 'some_path/indexers_merged.xsd';
        $this->assertEquals($expectedSchema, $this->_model->getSchema());
    }

    /**
     * @covers \Magento\Index\Model\Indexer\Config\SchemaLocator::getPerFileSchema
     */
    public function testGetPerFileSchema()
    {
        $expectedSchema = 'some_path/indexers.xsd';
        $this->assertEquals($expectedSchema, $this->_model->getPerFileSchema());
    }
}
