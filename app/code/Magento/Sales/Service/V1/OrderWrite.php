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
namespace Magento\Sales\Service\V1;

use Magento\Sales\Service\V1\Action\OrderAddressUpdate;
use Magento\Sales\Service\V1\Action\OrderCancel;
use Magento\Sales\Service\V1\Action\OrderEmail;
use Magento\Sales\Service\V1\Action\OrderHold;
use Magento\Sales\Service\V1\Action\OrderUnHold;
use Magento\Sales\Service\V1\Action\OrderStatusHistoryAdd;
use Magento\Sales\Service\V1\Action\OrderCreate;
use Magento\Sales\Service\V1\Data\Order;
use Magento\Sales\Service\V1\Data\OrderAddress;
use Magento\Sales\Service\V1\Data\OrderStatusHistory;

/**
 * Class OrderWrite
 */
class OrderWrite implements OrderWriteInterface
{
    /**
     * @var OrderAddressUpdate
     */
    protected $orderAddressUpdate;

    /**
     * @var OrderCancel
     */
    protected $orderCancel;

    /**
     * @var OrderEmail
     */
    protected $orderEmail;

    /**
     * @var OrderHold
     */
    protected $orderHold;

    /**
     * @var OrderUnHold
     */
    protected $orderUnHold;

    /**
     * @var OrderStatusHistoryAdd
     */
    protected $orderStatusHistoryAdd;

    /**
     * @var OrderCreate
     */
    protected $orderCreate;

    /**
     * @param OrderAddressUpdate $orderAddressUpdate
     * @param OrderCancel $orderCancel
     * @param OrderEmail $orderEmail
     * @param OrderHold $orderHold
     * @param OrderUnHold $orderUnHold
     * @param OrderStatusHistoryAdd $orderStatusHistoryAdd
     * @param OrderCreate $orderCreate
     */
    public function __construct(
        OrderAddressUpdate $orderAddressUpdate,
        OrderCancel $orderCancel,
        OrderEmail $orderEmail,
        OrderHold $orderHold,
        OrderUnHold $orderUnHold,
        OrderStatusHistoryAdd $orderStatusHistoryAdd,
        OrderCreate $orderCreate
    ) {
        $this->orderAddressUpdate = $orderAddressUpdate;
        $this->orderCancel = $orderCancel;
        $this->orderEmail = $orderEmail;
        $this->orderHold = $orderHold;
        $this->orderUnHold = $orderUnHold;
        $this->orderStatusHistoryAdd = $orderStatusHistoryAdd;
        $this->orderCreate = $orderCreate;
    }

    /**
     * @param \Magento\Sales\Service\V1\Data\OrderAddress $orderAddress
     * @return bool
     */
    public function addressUpdate(OrderAddress $orderAddress)
    {
        return $this->orderAddressUpdate->invoke($orderAddress);
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function cancel($id)
    {
        return $this->orderCancel->invoke($id);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function email($id)
    {
        return $this->orderEmail->invoke($id);
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function hold($id)
    {
        return $this->orderHold->invoke($id);
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function unHold($id)
    {
        return $this->orderUnHold->invoke($id);
    }

    /**
     * @param int $id
     * @param \Magento\Sales\Service\V1\Data\OrderStatusHistory $statusHistory
     * @return bool
     */
    public function statusHistoryAdd($id, OrderStatusHistory $statusHistory)
    {
        return $this->orderStatusHistoryAdd->invoke($id, $statusHistory);
    }

    /**
     * Create an order
     *
     * @param Order $orderDataObject
     * @return bool
     * @throws \Exception
     */
    public function create(Order $orderDataObject)
    {
        return $this->orderCreate->invoke($orderDataObject);
    }
}
