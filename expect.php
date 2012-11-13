<?php

use PHPSpec2\Prophet\ObjectProphet as BaseObjectProphet,
    PHPSpec2\Wrapper\ArgumentsUnwrapper,
    PHPSpec2\Matcher\MatchersCollection;

namespace Bossa\PHPSpec2\Expect {
    class ObjectProphet extends BaseObjectProphet
    {
        public function __call($method, array $arguments = array())
        {
            if user calls function with should prefix - call matcher
                if (preg_match('/^(to|notTo)(.+)$/', $method, $matches)) {
                    $matcherName = lcfirst($matches[2]);
                    if ('to' === $matches[1]) {
                        return $this->should($matcherName, $arguments);
                    }

                    return $this->shouldNot($matcherName, $arguments);
                }

            return $this->callOnProphetSubject($method, $arguments);
        }
    }
}

function expect($sus) {
    return new Bossa\PHPSpec2\Expect\ObjectProphet($sus, new MatchersCollection, new ArgumentsUnwrapper);
}


