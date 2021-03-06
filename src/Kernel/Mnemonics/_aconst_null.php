<?php
namespace PHPJava\Kernel\Mnemonics;

final class _aconst_null implements OperationInterface
{
    use \PHPJava\Kernel\Core\Accumulator;
    use \PHPJava\Kernel\Core\ConstantPool;

    /**
     * store into a reference in an array.
     */
    public function execute(): void
    {
        $this->pushToOperandStack(null);
    }
}
