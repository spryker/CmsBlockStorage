<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Unit\Spryker\Zed\StateMachine\Mocks;

use Propel\Runtime\Connection\ConnectionInterface;
use Spryker\Zed\StateMachine\Business\Lock\ItemLockInterface;
use Spryker\Zed\StateMachine\Business\Logger\TransitionLogInterface;
use Spryker\Zed\StateMachine\Business\Process\ProcessInterface;
use Spryker\Zed\StateMachine\Business\StateMachine\BuilderInterface;
use Spryker\Zed\StateMachine\Business\StateMachine\ConditionInterface;
use Spryker\Zed\StateMachine\Business\StateMachine\FinderInterface;
use Spryker\Zed\StateMachine\Business\StateMachine\HandlerResolverInterface;
use Spryker\Zed\StateMachine\Business\StateMachine\PersistenceInterface;
use Spryker\Zed\StateMachine\Business\StateMachine\StateUpdaterInterface;
use Spryker\Zed\StateMachine\Business\StateMachine\TimeoutInterface;
use Spryker\Zed\StateMachine\Business\StateMachine\TriggerInterface;
use Spryker\Zed\StateMachine\Dependency\Plugin\CommandPluginInterface;
use Spryker\Zed\StateMachine\Dependency\Plugin\ConditionPluginInterface;
use Spryker\Zed\StateMachine\Dependency\Plugin\StateMachineHandlerInterface;
use Spryker\Zed\StateMachine\Persistence\StateMachineQueryContainerInterface;
use Spryker\Zed\StateMachine\StateMachineConfig;

class StateMachineMocks extends \PHPUnit_Framework_TestCase
{

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Spryker\Zed\StateMachine\Business\Logger\TransitionLog
     */
    protected function createTransitionLogMock()
    {
        $transitionLogMock = $this->getMock(TransitionLogInterface::class);

        return $transitionLogMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Spryker\Zed\StateMachine\Business\StateMachine\FinderInterface
     */
    protected function createFinderMock()
    {
        $finderMock = $this->getMock(FinderInterface::class);

        return $finderMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Spryker\Zed\StateMachine\Business\StateMachine\HandlerResolverInterface
     */
    protected function createHandlerResolverMock()
    {
        $handlerResolverMock = $this->getMock(HandlerResolverInterface::class);

        return $handlerResolverMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Spryker\Zed\StateMachine\Dependency\Plugin\StateMachineHandlerInterface
     */
    protected function createStateMachineHandlerMock()
    {
        $stateMachineHandlerMock = $this->getMock(StateMachineHandlerInterface::class);

        return $stateMachineHandlerMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Spryker\Zed\StateMachine\Business\StateMachine\PersistenceInterface
     */
    protected function createPersistenceMock()
    {
        $persistenceMock = $this->getMock(PersistenceInterface::class);

        return $persistenceMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Spryker\Zed\StateMachine\Business\StateMachine\StateUpdaterInterface
     */
    protected function createStateUpdaterMock()
    {
        $stateUpdaterMock = $this->getMock(StateUpdaterInterface::class);

        return $stateUpdaterMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Spryker\Zed\StateMachine\Dependency\Plugin\ConditionPluginInterface
     */
    protected function createConditionPluginMock()
    {
        $conditionPluginMock = $this->getMock(ConditionPluginInterface::class);

        return $conditionPluginMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Spryker\Zed\StateMachine\Business\StateMachine\BuilderInterface
     */
    public function createBuilderMock()
    {
        $builderMock = $this->getMock(BuilderInterface::class);

        return $builderMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Spryker\Zed\StateMachine\Persistence\StateMachineQueryContainerInterface
     */
    protected function createStateMachineQueryContainerMock()
    {
        $builderMock = $this->getMock(StateMachineQueryContainerInterface::class);

        return $builderMock;
    }


    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Spryker\Zed\StateMachine\Business\Process\ProcessInterface
     */
    protected function createProcessMock()
    {
        $processMock = $this->getMock(ProcessInterface::class);

        return $processMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Spryker\Zed\StateMachine\Business\StateMachine\TimeoutInterface
     */
    protected function createTimeoutMock()
    {
        $timeoutMock = $this->getMock(TimeoutInterface::class);

        return $timeoutMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Spryker\Zed\StateMachine\Business\StateMachine\PersistenceInterface
     */
    protected function createStateMachinePersitenceMock()
    {
        $persistenceMock = $this->getMock(PersistenceInterface::class);

        return $persistenceMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Propel\Runtime\Connection\ConnectionInterface
     */
    protected function createPropelConnectionMock()
    {
        $propelConnectionMock = $this->getMock(ConnectionInterface::class);

        return $propelConnectionMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Spryker\Zed\StateMachine\Business\StateMachine\ConditionInterface
     */
    protected function createConditionMock()
    {
        $conditionMock = $this->getMock(ConditionInterface::class);

        return $conditionMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Spryker\Zed\StateMachine\Dependency\Plugin\CommandPluginInterface
     */
    protected function createCommandMock()
    {
        $commandMock = $this->getMock(CommandPluginInterface::class);

        return $commandMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Spryker\Zed\StateMachine\StateMachineConfig
     */
    protected function createStateMachineConfigMock()
    {
        $stateMachineConfigMock = $this->getMock(StateMachineConfig::class);

        return $stateMachineConfigMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Spryker\Zed\StateMachine\Business\StateMachine\TriggerInterface
     */
    protected function createTriggerMock()
    {
        $triggerLockMock = $this->getMock(TriggerInterface::class);

        return $triggerLockMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Spryker\Zed\StateMachine\Business\Lock\ItemLockInterface
     */
    protected function createItemLockMock()
    {
        $itemLockMock = $this->getMock(ItemLockInterface::class);

        return $itemLockMock;
    }

}