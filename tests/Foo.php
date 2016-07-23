<?php

/**
 * Test fixture used in ExpectTest
 */
class Foo implements Countable
{
    function isFoo()
    {
        return true;
    }
    public function count()
    {
        return 1;
    }
    public function getString()
    {
        return 'string';
    }
    public function getArray()
    {
        return [];
    }
    public function throwException()
    {
        throw new InvalidArgumentException;
    }
}
