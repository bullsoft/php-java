<?php
namespace PHPJava\Core\Extended;

use PHPJava\Core\JavaClassInterface;

trait ClassInvokable
{
    public function __invoke(...$arguments): JavaClassInterface
    {
        return $this
            ->getInvoker()
            ->construct(...$arguments)
            ->getJavaClass();
    }
}
