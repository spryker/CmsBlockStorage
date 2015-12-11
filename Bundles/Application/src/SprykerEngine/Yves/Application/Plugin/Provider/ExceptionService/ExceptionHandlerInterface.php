<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace SprykerEngine\Yves\Application\Plugin\Provider\ExceptionService;

use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Response;

interface ExceptionHandlerInterface
{

    /**
     * @param FlattenException $exception
     *
     * @return Response
     */
    public function handleException(FlattenException $exception);

}