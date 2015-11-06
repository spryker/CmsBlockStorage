<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace SprykerFeature\Zed\Payone\Communication\Plugin\Command;

use SprykerEngine\Zed\Kernel\Communication\AbstractPlugin;
use SprykerFeature\Zed\Oms\Business\Util\ReadOnlyArrayObject;
use SprykerFeature\Zed\Oms\Communication\Plugin\Oms\Command\CommandByOrderInterface;
use SprykerFeature\Zed\Payone\Business\PayoneFacade;
use Orm\Zed\Payone\Persistence\SpyPaymentPayone;
use SprykerFeature\Zed\Payone\Communication\PayoneDependencyContainer;
use Orm\Zed\Sales\Persistence\SpySalesOrder;

/**
 * @method PayoneDependencyContainer getDependencyContainer()
 * @method PayoneFacade getFacade()
 */
class AuthorizePlugin extends AbstractPlugin implements CommandByOrderInterface
{

    /**
     * @param array $orderItems
     * @param SpySalesOrder $orderEntity
     * @param ReadOnlyArrayObject $data
     *
     * @return array $returnArray
     */
    public function run(array $orderItems, SpySalesOrder $orderEntity, ReadOnlyArrayObject $data)
    {
        /** @var SpyPaymentPayone $paymentEntity */
        $paymentEntity = $orderEntity->getSpyPaymentPayones()->getFirst();
        $this->getFacade()->authorizePayment($paymentEntity->getFkSalesOrder());

        return [];
    }

}