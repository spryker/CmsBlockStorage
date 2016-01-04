<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Client\Newsletter;

use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;

class NewsletterDependencyProvider extends AbstractDependencyProvider
{

    const SERVICE_ZED = 'zed service';

    /**
     * @param Container $container
     *
     * @return Container
     */
    public function provideServiceLayerDependencies(Container $container)
    {
        $container[self::SERVICE_ZED] = function (Container $container) {
            return $container->getLocator()->zedRequest()->client();
        };

        return $container;
    }

}