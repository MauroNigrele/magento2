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
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Magento\Catalog\Model\Indexer;

class FlatTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var int
     */
    protected static $categoryOne;

    /**
     * @var int
     */
    protected static $categoryTwo;

    /**
     * List of attribute codes
     *
     * @var string[]
     */
    protected static $attributeCodes = array();

    /**
     * List of attribute values
     * Data loaded from EAV
     *
     * @var string[]
     */
    protected static $attributeValues = array();

    /**
     * List of attributes to exclude
     *
     * @var string[]
     */
    protected static $attributesToExclude = array('url_path', 'display_mode');

    /**
     * @var int
     */
    protected static $totalBefore = 0;

    public static function setUpBeforeClass()
    {
        $category = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(
            'Magento\Catalog\Model\Category'
        )->load(
            2
        );

        self::loadAttributeCodes();
        self::loadAttributeValues($category);
    }

    public function testEntityItemsBefore()
    {
        /** @var \Magento\Catalog\Model\Category $category */
        $category = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(
            'Magento\Catalog\Model\Category'
        );

        $result = $category->getCollection()->getAllIds();
        $this->assertNotEmpty($result);
        $this->assertTrue(is_array($result));

        self::$totalBefore = count($result);
    }

    /**
     * Reindex All
     *
     * @magentoConfigFixture current_store catalog/frontend/flat_catalog_category true
     * @magentoAppArea frontend
     */
    public function testReindexAll()
    {
        /** @var  $indexer \Magento\Indexer\Model\IndexerInterface */
        $indexer = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(
            'Magento\Indexer\Model\Indexer'
        );
        $indexer->load('catalog_category_flat');
        $indexer->reindexAll();
        $this->assertTrue($indexer->isValid());

        /** @var \Magento\Catalog\Model\Category $category */
        $category = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(
            'Magento\Catalog\Model\Category'
        )->load(
            2
        );
        $this->assertInstanceOf('Magento\Catalog\Model\Resource\Category\Flat', $category->getResource());
        $this->checkCategoryData($category);
    }

    /**
     * @magentoConfigFixture current_store catalog/frontend/flat_catalog_category true
     * @magentoAppArea frontend
     */
    public function testFlatItemsBefore()
    {
        /** @var \Magento\Catalog\Model\Category $category */
        $category = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(
            'Magento\Catalog\Model\Category'
        )->load(
            2
        );

        $this->assertInstanceOf('Magento\Catalog\Model\Resource\Category\Flat', $category->getResource());

        $result = $category->getAllChildren(true);
        $this->assertNotEmpty($result);
        $this->assertCount(1, $result);
    }

    /**
     * Populate EAV category data
     *
     * @magentoConfigFixture current_store catalog/frontend/flat_catalog_category true
     */
    public function testCreateCategory()
    {
        /** @var \Magento\Catalog\Model\Category $category */
        $category = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(
            'Magento\Catalog\Model\Category'
        );
        $category->load(2);

        /** @var \Magento\Catalog\Model\Category $categoryOne */
        $categoryOne = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(
            'Magento\Catalog\Model\Category'
        );
        $categoryOne->setName('Category One')->setPath($category->getPath())->setIsActive(true)->save();
        self::loadAttributeValues($categoryOne);

        self::$categoryOne = $categoryOne->getId();

        /** @var \Magento\Catalog\Model\Category $categoryTwo */
        $categoryTwo = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(
            'Magento\Catalog\Model\Category'
        );

        $categoryTwo->setName('Category Two')->setPath($categoryOne->getPath())->setIsActive(true)->save();

        self::loadAttributeValues($categoryTwo);

        self::$categoryTwo = $categoryTwo->getId();

        $result = $category->getCollection()->getItems();
        $this->assertTrue(is_array($result));

        $this->assertEquals($category->getId(), $result[self::$categoryOne]->getParentId());
        $this->assertEquals(self::$categoryOne, $result[self::$categoryTwo]->getParentId());
    }

    /**
     * Test for reindex row action
     * Check that category data created at testCreateCategory() were syncing to flat structure
     *
     * @magentoConfigFixture current_store catalog/frontend/flat_catalog_category true
     * @magentoAppArea frontend
     *
     * @depends testCreateCategory
     */
    public function testFlatAfterCreate()
    {
        /** @var \Magento\Catalog\Model\Category $category */
        $category = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(
            'Magento\Catalog\Model\Category'
        )->load(
            2
        );

        $this->assertInstanceOf('Magento\Catalog\Model\Resource\Category\Flat', $category->getResource());

        $result = $category->getAllChildren(true);
        $this->assertNotEmpty($result);
        $this->assertCount(3, $result);
        $this->assertContains(self::$categoryOne, $result);

        /** @var \Magento\Catalog\Model\Category $categoryOne */
        $categoryOne = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(
            'Magento\Catalog\Model\Category'
        )->load(
            self::$categoryOne
        );

        $this->assertInstanceOf('Magento\Catalog\Model\Resource\Category\Flat', $categoryOne->getResource());

        $result = $categoryOne->getAllChildren(true);
        $this->assertNotEmpty($result);
        $this->assertCount(2, $result);
        $this->assertContains(self::$categoryTwo, $result);
        $this->checkCategoryData($categoryOne);

        /** @var \Magento\Catalog\Model\Category $categoryTwo */
        $categoryTwo = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(
            'Magento\Catalog\Model\Category'
        )->load(
            self::$categoryTwo
        );

        $this->assertInstanceOf('Magento\Catalog\Model\Resource\Category\Flat', $categoryTwo->getResource());

        $this->assertEquals(self::$categoryOne, $categoryTwo->getParentId());
        $this->checkCategoryData($categoryTwo);
    }

    /**
     * Move category and populate EAV category data
     *
     * @magentoConfigFixture current_store catalog/frontend/flat_catalog_category true
     */
    public function testMoveCategory()
    {
        /** @var \Magento\Catalog\Model\Category $categoryTwo */
        $categoryTwo = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(
            'Magento\Catalog\Model\Category'
        )->load(
            self::$categoryTwo
        );

        $this->assertEquals($categoryTwo->getData('parent_id'), self::$categoryOne);

        $categoryTwo->move(2, self::$categoryOne);
        self::loadAttributeValues($categoryTwo);

        $category = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(
            'Magento\Catalog\Model\Category'
        )->load(
            2
        );

        self::loadAttributeValues($category);

        $categoryOne = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(
            'Magento\Catalog\Model\Category'
        )->load(
            self::$categoryOne
        );
        self::loadAttributeValues($categoryOne);

        $this->assertEquals($categoryTwo->getData('parent_id'), 2);
    }

    /**
     * Test for reindex list action
     * Check that category data created at testMoveCategory() were syncing to flat structure
     *
     * @magentoConfigFixture current_store catalog/frontend/flat_catalog_category true
     * @magentoAppArea frontend
     *
     * @depends testMoveCategory
     */
    public function testFlatAfterMove()
    {
        /** @var \Magento\Catalog\Model\Category $category */
        $category = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(
            'Magento\Catalog\Model\Category'
        )->load(
            2
        );

        $this->assertInstanceOf('Magento\Catalog\Model\Resource\Category\Flat', $category->getResource());

        $this->checkCategoryData($category);

        $result = $category->getAllChildren(true);
        $this->assertNotEmpty($result);
        $this->assertCount(3, $result);

        /** @var \Magento\Catalog\Model\Category $categoryTwo */
        $categoryTwo = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(
            'Magento\Catalog\Model\Category'
        )->load(
            self::$categoryTwo
        );
        $this->checkCategoryData($categoryTwo);

        /** @var \Magento\Catalog\Model\Category $categoryOne */
        $categoryOne = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(
            'Magento\Catalog\Model\Category'
        )->load(
            self::$categoryOne
        );
        $this->checkCategoryData($categoryOne);
    }

    /**
     * Delete created categories at testCreateCategory()
     *
     * @magentoConfigFixture current_store catalog/frontend/flat_catalog_category true
     * @magentoAppArea adminhtml
     */
    public function testDeleteCategory()
    {
        /** @var \Magento\Catalog\Model\Category $category */
        $category = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(
            'Magento\Catalog\Model\Category'
        );

        $category->load(self::$categoryTwo);
        $category->delete();

        $category->load(self::$categoryOne);
        $category->delete();

        $result = $category->getCollection()->getAllIds();
        $this->assertNotEmpty($result);
        $this->assertTrue(is_array($result));
        $this->assertCount(self::$totalBefore, $result);
    }

    /**
     * Test for reindex row action
     * Check that category data deleted at testDeleteCategory() were syncing to flat structure
     *
     * @magentoConfigFixture current_store catalog/frontend/flat_catalog_category true
     * @magentoAppArea frontend
     *
     * @depends testDeleteCategory
     */
    public function testFlatAfterDeleted()
    {
        /** @var \Magento\Catalog\Model\Category $category */
        $category = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(
            'Magento\Catalog\Model\Category'
        )->load(
            2
        );

        $this->assertInstanceOf('Magento\Catalog\Model\Resource\Category\Flat', $category->getResource());

        $result = $category->getAllChildren(true);
        $this->assertNotEmpty($result);
        $this->assertCount(1, $result);
    }

    /**
     * Populate attribute values from category
     * Data loaded from EAV
     *
     * @param \Magento\Catalog\Model\Category $category
     */
    protected static function loadAttributeValues(\Magento\Catalog\Model\Category $category)
    {
        foreach (self::$attributeCodes as $attributeCode) {
            self::$attributeValues[$category->getId()][$attributeCode] = $category->getData($attributeCode);
        }
    }

    /**
     * Populate attribute codes for category entity
     * Data loaded from EAV
     *
     */
    protected static function loadAttributeCodes()
    {
        /** @var \Magento\Catalog\Model\Config $catalogConfig */
        $catalogConfig = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(
            'Magento\Catalog\Model\Config'
        );
        $attributeCodes = $catalogConfig->getEntityAttributeCodes(\Magento\Catalog\Model\Category::ENTITY);

        foreach ($attributeCodes as $attributeCode) {
            if (in_array($attributeCode, self::$attributesToExclude)) {
                continue;
            }
            self::$attributeCodes[] = $attributeCode;
        }
    }

    /**
     * Check EAV and flat data
     *
     * @param \Magento\Catalog\Model\Category $category
     */
    protected function checkCategoryData(\Magento\Catalog\Model\Category $category)
    {
        foreach (self::$attributeCodes as $attributeCode) {
            $this->assertEquals(
                self::$attributeValues[$category->getId()][$attributeCode],
                $category->getData($attributeCode),
                "Data for {$category->getId()} attribute code [{$attributeCode}] is wrong"
            );
        }
    }
}
