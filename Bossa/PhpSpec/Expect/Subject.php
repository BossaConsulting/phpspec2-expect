<?php

namespace Bossa\PhpSpec\Expect;

use PhpSpec\Wrapper\Subject as BaseSubject;

class Subject extends BaseSubject
{
    public function __call($method, array $arguments = array())
    {
        if (preg_match('/^(to|notTo)(.+)$/', $method, $matches)) {
            $matcherName = lcfirst($matches[2]);
            if ('to' === $matches[1]) {
                return $this->should($matcherName, $arguments);
            }

            return $this->shouldNot($matcherName, $arguments);
        }

        return $this->callOnWrappedObject($method, $arguments);
    }
}

