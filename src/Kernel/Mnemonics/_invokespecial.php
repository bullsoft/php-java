<?php
namespace PHPJava\Kernel\Mnemonics;

use PHPJava\Core\JavaClass;
use PHPJava\Core\JavaClassInterface;
use PHPJava\Kernel\Filters\Normalizer;
use PHPJava\Kernel\Resolvers\MethodNameResolver;
use PHPJava\Utilities\CompareTool;
use PHPJava\Utilities\Formatter;

final class _invokespecial implements OperationInterface
{
    use \PHPJava\Kernel\Core\Accumulator;
    use \PHPJava\Kernel\Core\ConstantPool;
    use \PHPJava\Kernel\Core\DependencyInjector;
    use \PHPJava\Kernel\Core\ExceptionTableInspectable;

    public function execute(): void
    {
        $cpInfo = $this->getConstantPool();
        $cp = $cpInfo[$this->readUnsignedShort()];
        $nameAndTypeIndex = $cpInfo[$cp->getNameAndTypeIndex()];
        $className = $cpInfo[$cpInfo[$cp->getClassIndex()]->getClassIndex()]->getString();
        $methodName = $cpInfo[$nameAndTypeIndex->getNameIndex()]->getString();
        $signature = $cpInfo[$nameAndTypeIndex->getDescriptorIndex()]->getString();
        $parsedSignature = Formatter::parseSignature($signature);

        // POP with right-to-left (objectref + arguments)
        $arguments = array_fill(0, $parsedSignature['arguments_count'], null);
        for ($i = count($arguments) - 1; $i >= 0; $i--) {
            $arguments[$i] = $this->popFromOperandStack();
        }

        /**
         * @var JavaClassInterface $objectref
         */
        $objectref = $newObject = $this->popFromOperandStack();
        try {
            $methodName = $cpInfo[$nameAndTypeIndex->getNameIndex()]->getString();

            // load a class dynamically if not match class name and objectref class
            if (!CompareTool::compareClassName($className, $objectref->getClassName())) {
                $newObject = JavaClass::load(
                    $className,
                    $this->javaClass->getOptions()
                );
            }

            /**
             * @var JavaClassInterface $newObject
             */
            $result = $newObject->getInvoker()->getDynamic()->getMethods()->call(
                $methodName,
                ...$arguments
            );

            // Call special method (e.g., <init>, <clinit> and soon)
            if (MethodNameResolver::isConstructorMethod($methodName)) {
                $result = $objectref;

                // Set initialized parent parameters

                // Static field is written below.
                $existFieldList = array_keys($objectref->getInvoker()->getStatic()->getFields()->getList());
                foreach ($newObject->getInvoker()->getStatic()->getFields()->getList() as $fieldName => $value) {
                    if (in_array($fieldName, $existFieldList, true)) {
                        continue;
                    }
                    $objectref
                        ->getInvoker()
                        ->getStatic()
                        ->getFields()
                        ->set(
                            $fieldName,
                            $value
                        );
                }

                // Dynamic field is written below.
                $existFieldList = array_keys($objectref->getInvoker()->getDynamic()->getFields()->getList());
                foreach ($newObject->getInvoker()->getDynamic()->getFields()->getList() as $fieldName => $value) {
                    if (in_array($fieldName, $existFieldList, true)) {
                        continue;
                    }
                    $objectref
                        ->getInvoker()
                        ->getDynamic()
                        ->getFields()
                        ->set(
                            $fieldName,
                            $value
                        );
                }
            }
        } catch (\Exception $e) {
            $this->inspectExceptionTable($e);
            return;
        }

        if ($parsedSignature[0]['type'] !== 'void') {
            $this->pushToOperandStack(
                Normalizer::normalizeReturnValue(
                    $result,
                    $parsedSignature[0]
                )
            );
        }
    }
}
