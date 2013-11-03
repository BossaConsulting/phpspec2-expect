<?php

namespace Bossa\PhpSpec\Expect;

use PhpSpec\Wrapper\Subject as BaseSubject;

class Subject extends BaseSubject
{
    public function __call($method, array $arguments = array())
    {
        if (preg_match('/^(to|notTo)(.+)$/', $method, $matches)) {
            $method = 'should'.$matches[2];

            if ('notTo' === $matches[1]) {
                $method = 'shouldNot'.$matches[2];
            }
        }

        return parent::__call($method, $arguments);
    }
}

