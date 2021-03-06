<?php
namespace PHPJava\Core\JVM\Invoker\Extended;

trait SpecialMethodCallable
{
    /**
     * @param $name
     * @param mixed ...$arguments
     */
    public function callSpecial(string $name, ...$arguments)
    {
        return $this->call($name, ...$arguments);
    }
}
