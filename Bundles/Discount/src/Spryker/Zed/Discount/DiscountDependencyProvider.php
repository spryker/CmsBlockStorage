<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Discount;

use Spryker\Shared\Kernel\Store;
use Spryker\Zed\Discount\Communication\Plugin\Calculator\Fixed;
use Spryker\Zed\Discount\Communication\Plugin\Calculator\Percentage;
use Spryker\Zed\Discount\Communication\Plugin\Collector\Item;
use Spryker\Zed\Discount\Communication\Plugin\Collector\ItemProductOption;
use Spryker\Zed\Discount\Communication\Plugin\Collector\OrderExpense;
use Spryker\Zed\Discount\Communication\Plugin\DecisionRule\MinimumCartSubtotal;
use Spryker\Zed\Discount\Communication\Plugin\DecisionRule\Voucher;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Discount\Dependency\Plugin\DiscountCalculatorPluginInterface;
use Spryker\Zed\Discount\Dependency\Plugin\DiscountCollectorPluginInterface;
use Spryker\Zed\Discount\Dependency\Plugin\DiscountDecisionRulePluginInterface;
use Spryker\Zed\Propel\Communication\Plugin\Connection;
use Spryker\Zed\Discount\Communication\Plugin\Collector\Aggregate;

class DiscountDependencyProvider extends AbstractBundleDependencyProvider
{

    const STORE_CONFIG = 'store_config';
    const FACADE_MESSENGER = 'messenger facade';

    const PLUGIN_PROPEL_CONNECTION = 'propel_connection_plugin';

    const PLUGIN_DECISION_RULE_VOUCHER = 'PLUGIN_DECISION_RULE_VOUCHER';
    const PLUGIN_DECISION_RULE_MINIMUM_CART_SUB_TOTAL = 'PLUGIN_DECISION_RULE_MINIMUM_CART_SUB_TOTAL';

    const PLUGIN_COLLECTOR_ITEM = 'PLUGIN_COLLECTOR_ITEM';
    const PLUGIN_COLLECTOR_ITEM_PRODUCT_OPTION = 'PLUGIN_COLLECTOR_ITEM_PRODUCT_OPTION';
    const PLUGIN_COLLECTOR_AGGREGATE = 'PLUGIN_COLLECTOR_AGGREGATE';
    const PLUGIN_COLLECTOR_ORDER_EXPENSE = 'PLUGIN_COLLECTOR_ORDER_EXPENSE';
    const PLUGIN_COLLECTOR_ITEM_EXPENSE = 'PLUGIN_COLLECTOR_ITEM_EXPENSE';

    const PLUGIN_CALCULATOR_PERCENTAGE = 'PLUGIN_CALCULATOR_PERCENTAGE';
    const PLUGIN_CALCULATOR_FIXED = 'PLUGIN_CALCULATOR_FIXED';

    const DECISION_RULE_PLUGINS = 'DECISION_RULE_PLUGINS';
    const CALCULATOR_PLUGINS = 'CALCULATOR_PLUGINS';
    const COLLECTOR_PLUGINS = 'COLLECTOR_PLUGINS';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        $container[self::STORE_CONFIG] = function (Container $container) {
            return Store::getInstance();
        };

        $container[self::FACADE_MESSENGER] = function (Container $container) {
            return $container->getLocator()->messenger()->facade();
        };

        $container[self::PLUGIN_PROPEL_CONNECTION] = function (Container $container) {
            return (new Connection())->get();
        };

        $container[self::DECISION_RULE_PLUGINS] = function (Container $container) {
            return $this->getAvailableDecisionRulePlugins($container);
        };

        $container[self::CALCULATOR_PLUGINS] = function (Container $container) {
            return $this->getAvailableCalculatorPlugins($container);
        };

        $container[self::COLLECTOR_PLUGINS] = function (Container $container) {
            return $this->getAvailableCollectorPlugins($container);
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container)
    {
        $container[self::STORE_CONFIG] = function (Container $container) {
            return Store::getInstance();
        };

        $container[self::DECISION_RULE_PLUGINS] = function (Container $container) {
            return $this->getAvailableDecisionRulePlugins($container);
        };

        $container[self::CALCULATOR_PLUGINS] = function (Container $container) {
            return $this->getAvailableCalculatorPlugins($container);
        };

        $container[self::COLLECTOR_PLUGINS] = function (Container $container) {
            return $this->getAvailableCollectorPlugins($container);
        };

        return $container;
    }

    /**
     * @return \Spryker\Zed\Discount\Dependency\Plugin\DiscountDecisionRulePluginInterface[]
     */
    public function getAvailableDecisionRulePlugins(Container $container)
    {
        return [
            self::PLUGIN_DECISION_RULE_VOUCHER => new Voucher(),
            self::PLUGIN_DECISION_RULE_MINIMUM_CART_SUB_TOTAL => new MinimumCartSubtotal(),
        ];
    }

    /**
     * @return \Spryker\Zed\Discount\Dependency\Plugin\DiscountCalculatorPluginInterface[]
     */
    public function getAvailableCalculatorPlugins(Container $container)
    {
        return [
            self::PLUGIN_CALCULATOR_PERCENTAGE => new Percentage(),
            self::PLUGIN_CALCULATOR_FIXED => new Fixed(),
        ];
    }

    /**
     * @return \Spryker\Zed\Discount\Dependency\Plugin\DiscountCollectorPluginInterface[]
     */
    public function getAvailableCollectorPlugins(Container $container)
    {
        return [
            self::PLUGIN_COLLECTOR_ITEM => new Item(),
            self::PLUGIN_COLLECTOR_ORDER_EXPENSE => new OrderExpense(),
            self::PLUGIN_COLLECTOR_ITEM_PRODUCT_OPTION => new ItemProductOption(),
            self::PLUGIN_COLLECTOR_AGGREGATE => new Aggregate(),
        ];
    }

}
