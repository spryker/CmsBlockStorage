<?php

/**
 * Copyright © 2017-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Queue\Business\Model\Task;

use Generated\Shared\Transfer\QueueMessageTransfer;
use Generated\Shared\Transfer\QueueOptionTransfer;
use Spryker\Client\Queue\QueueClientInterface;
use Spryker\Zed\Queue\Business\Exception\MissingQueueOptionException;
use Spryker\Zed\Queue\Dependency\Plugin\QueueMessageProcessorInterface;
use Spryker\Zed\Queue\QueueConfig;

class Task implements TaskInterface
{

    const DEFAULT_CONSUMER_CONFIG_QUEUE_NAME = 'default';

    /**
     * @var QueueClientInterface
     */
    protected $client;

    /**
     * @var QueueConfig
     */
    protected $queueConfig;

    /**
     * @var QueueMessageProcessorInterface[]
     */
    protected $messageProcessorPlugins;

    /**
     * @param QueueClientInterface $client
     * @param QueueConfig $queueConfig
     * @param QueueMessageProcessorInterface[] $messageProcessorPlugins
     */
    public function __construct(QueueClientInterface $client, QueueConfig $queueConfig, array $messageProcessorPlugins)
    {
        $this->client = $client;
        $this->queueConfig = $queueConfig;
        $this->messageProcessorPlugins = $messageProcessorPlugins;
    }

    /**
     * @return void
     */
    public function run()
    {
        $startTime = time();
        $passedSeconds = 0;

        while ($passedSeconds < 55) {
            $this->startReceiving();
            sleep(5);
            $passedSeconds = time() - $startTime;
        }
    }

    /**
     * @return void
     */
    protected function startReceiving()
    {
        foreach ($this->messageProcessorPlugins as $queueName => $processorPlugin) {
            $queueOptionTransfer = $this->getQueueReceiverOptionTransfer($queueName, $processorPlugin->getChunkSize());
            $messages = $this->receiveMessages($queueOptionTransfer);

            if ($messages !== null) {
                $processedMessages = $processorPlugin->processMessages($messages);
                $this->postProcessMessages($processedMessages);
            }
        }
    }

    /**
     * @param QueueOptionTransfer $queueOptionTransfer
     *
     * @return QueueMessageTransfer[]
     */
    protected function receiveMessages(QueueOptionTransfer $queueOptionTransfer)
    {
        return $this->client->receiveMessages($queueOptionTransfer);
    }

    /**
     * @param QueueMessageTransfer[] $processedMessages
     *
     * @return void
     */
    protected function postProcessMessages(array $processedMessages)
    {
        foreach ($processedMessages as $processedMessage) {
            if ($processedMessage->getAcknowledge()) {
                $this->client->acknowledge($processedMessage);

                continue;
            }

            if ($processedMessage->getHasError()) {
                $this->client->handleErrorMessage($processedMessage);
            }
        }
    }

    /**
     * @param string $queueName
     * @param int $chunkSize
     *
     * @throws MissingQueueOptionException
     * @return QueueOptionTransfer
     */
    protected function getQueueReceiverOptionTransfer($queueName, $chunkSize)
    {
        $queueOptionTransfer = $this->queueConfig->getReceiverConfig($queueName);
        if ($queueOptionTransfer === null) {
            throw new MissingQueueOptionException(sprintf(
                'No queue configuration was found for this queue: %s', $queueName
            ));
        }

        $queueOptionTransfer->setChunkSize($chunkSize);
        if ($queueOptionTransfer->getQueueName() === self::DEFAULT_CONSUMER_CONFIG_QUEUE_NAME) {
            $queueOptionTransfer->setQueueName($queueName);
        }

        return $queueOptionTransfer;
    }
}
