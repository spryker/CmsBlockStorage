<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Acceptance\Sales\Order\Zed;

use Acceptance\Sales\Order\Zed\PageObject\SalesDetailPage;
use Acceptance\Sales\Order\Zed\Tester\SalesDetailPageTester;
use Acceptance\Sales\Order\Zed\Tester\SalesListTester;

/**
 * @group Acceptance
 * @group Sales
 * @group Order
 * @group Zed
 * @group SalesDetail
 */
class SalesDetailCest
{

    /**
     * @param \Acceptance\Sales\Order\Zed\Tester\SalesDetailPageTester $i
     * @param \Acceptance\Sales\Order\Zed\Tester\SalesListTester $salesListTester
     *
     * @return void
     */
    public function testThatOrderDetailPageIsVisibleWhenOrderExists(SalesDetailPageTester $i, SalesListTester $salesListTester)
    {
        $idSalesOrder = $i->createOrder();
        $i->createSalesOrderItemForOrder($idSalesOrder, []);

        $idSalesOrder = $salesListTester->grabLatestOrderId();
        $i->amOnPage(SalesDetailPage::getOrderDetailsPageUrl($idSalesOrder));
        $i->waitForElement('#items', 3);
        $i->seeElement(['xpath' => SalesDetailPage::getSalesOrderItemRowSelector(1)]);
    }

}
