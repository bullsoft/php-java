<?php
namespace PHPJava\Kernel\Structures;

class IntegerInfo implements StructureInterface
{
    use \PHPJava\Kernel\Core\BinaryReader;
    use \PHPJava\Kernel\Core\ConstantPool;
    use \PHPJava\Kernel\Core\DebugTool;

    /**
     * @var int
     */
    private $bytes;

    public function execute(): void
    {
        $this->bytes = $this->readUnsignedInt();
    }

    public function getBytes(): int
    {
        return $this->bytes;
    }
}
