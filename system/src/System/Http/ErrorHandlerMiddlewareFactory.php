<?php

declare(strict_types=1);

namespace Mobicms\System\Http;

use Devanych\Di\FactoryInterface;
use HttpSoft\Basis\ErrorHandler\LogErrorListener;
use HttpSoft\ErrorHandler\ErrorHandlerMiddleware;
use Psr\Container\{
    ContainerExceptionInterface,
    ContainerInterface,
    NotFoundExceptionInterface
};
use Psr\Log\LoggerInterface;

final class ErrorHandlerMiddlewareFactory implements FactoryInterface
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function create(ContainerInterface $container): ErrorHandlerMiddleware
    {
        $errorHandler = new ErrorHandlerMiddleware(new WhoopsErrorResponseGenerator());
        /** @var LoggerInterface $logger */
        $logger = $container->get(LoggerInterface::class);
        $errorHandler->addListener(new LogErrorListener($logger));

        return $errorHandler;
    }
}
