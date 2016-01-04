<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Client\Collector;

use Spryker\Client\Cart\CartDependencyProvider;
use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\Collector\KeyBuilder\UrlKeyBuilder;
use Spryker\Client\Collector\Matcher\UrlMatcher;
use Spryker\Client\Kernel\Exception\Container\ContainerKeyNotFoundException;
use Spryker\Client\Storage\StorageClient;

class CollectorFactory extends AbstractFactory
{

    /**
     * @return UrlMatcher
     */
    public function createUrlMatcher()
    {
        return new UrlMatcher(
            $this->createUrlKeyBuilder(),
            $this->getStorageClient()
        );
    }

    /**
     * @return UrlKeyBuilder
     */
    protected function createUrlKeyBuilder()
    {
        $urlKeyBuilder = new UrlKeyBuilder();

        return $urlKeyBuilder;
    }

    /**
     * @throws ContainerKeyNotFoundException
     * @return StorageClient
     */
    protected function getStorageClient()
    {
        return $this->getProvidedDependency(CollectorDependencyProvider::CLIENT_KV_STORAGE);
    }

}