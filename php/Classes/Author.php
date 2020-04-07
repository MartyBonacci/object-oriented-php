<?php
namespace MartyBonacci\ObjectOrientedPhp;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * This is the Author class
 * @author Marty Bonacci <mbonacci@cnm.edu>
 */
class Author implements \JsonSerializable{






    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
    }
}