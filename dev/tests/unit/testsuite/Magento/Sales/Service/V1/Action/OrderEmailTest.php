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

namespace Magento\Sales\Service\V1\Action;

/**
 * Test Class OrderEmailTest for Order Service
 */
class OrderEmailTest extends \PHPUnit_Framework_TestCase
{
    public function testInvoke()
    {
        $orderId = 1;
        $objectManager = new \Magento\TestFramework\Helper\ObjectManager($this);
        $orderRepository = $this->getMock('\Magento\Sales\Model\OrderRepository', ['get'], [], '', false);
        $notifier = $this->getMock('\Magento\Sales\Model\OrderNotifier', ['notify', '__wakeup'], [], '', false);
        $order = $this->getMock(
            '\Magento\Sales\Model\Order',
            ['__wakeup', 'sendNewOrderEmail', 'getEmailSent'],
            [],
            '',
            false
        );

        $service = $objectManager->getObject(
            'Magento\Sales\Service\V1\Action\OrderEmail',
            [
                'orderRepository' => $orderRepository,
                'notifier' => $notifier
            ]
        );
        $orderRepository->expects($this->once())
            ->method('get')
            ->with($orderId)
            ->will($this->returnValue($order));
        $notifier->expects($this->any())
            ->method('notify')
            ->with($order)
            ->will($this->returnValue(true));
        $this->assertTrue($service->invoke($orderId));
    }
}
 