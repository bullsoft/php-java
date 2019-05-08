<?php
namespace PHPJava\Packages\java\lang\invoke;

use PHPJava\Exceptions\NotImplementedException;
use PHPJava\Packages\java\lang\invoke\CallSite;

/**
 * The `MutableCallSite` class was auto generated.
 *
 * @parent \PHPJava\Packages\java\lang\_Object
 * @parent \PHPJava\Packages\java\lang\invoke\CallSite
 */
class MutableCallSite extends CallSite
{

    /**
     * Returns the target method of the call site, which behaves like a normal field of the MutableCallSite.
     *
     * @param mixed $a
     * @return mixed
     * @throws NotImplementedException
     * @see https://docs.oracle.com/en/java/javase/11/docs/api/java.base/java/lang/invoke/package-summary.html#getTarget
     */
    public function getTarget($a = null)
    {
        throw new NotImplementedException(__METHOD__);
    }

    /**
     * Updates the target method of this call site, as a normal variable.
     *
     * @param mixed $a
     * @return mixed
     * @throws NotImplementedException
     * @see https://docs.oracle.com/en/java/javase/11/docs/api/java.base/java/lang/invoke/package-summary.html#setTarget
     */
    public function setTarget($a = null)
    {
        throw new NotImplementedException(__METHOD__);
    }

    /**
     * Performs a synchronization operation on each call site in the given array, forcing all other threads to throw away any cached values previously loaded from the target of any of the call sites.
     *
     * @param mixed $a
     * @return mixed
     * @throws NotImplementedException
     * @see https://docs.oracle.com/en/java/javase/11/docs/api/java.base/java/lang/invoke/package-summary.html#syncAll
     */
    public static function syncAll($a = null)
    {
        throw new NotImplementedException(__METHOD__);
    }
}