<?php

if (is_dir($vendor = __DIR__ . '/../vendor')) {
    require_once($vendor . '/autoload.php');
} elseif (is_dir($vendor = __DIR__ . '/../../../vendor')) {
    require_once($vendor . '/autoload.php');
} elseif (is_dir($vendor = __DIR__ . '/vendor')) {
    require_once($vendor . '/autoload.php');
} else {
    die(
        'You must set up the project dependencies, run the following commands:' . PHP_EOL .
        'curl -s http://getcomposer.org/installer | php' . PHP_EOL .
        'php composer.phar install' . PHP_EOL
    );
}

use PHPSpec2\Formatter\Presenter\TaggedPresenter;
use PHPSpec2\Formatter\Presenter\Differ\Differ;
use PHPSpec2\Initializer\DefaultMatchersInitializer;
use PHPSpec2\Initializer\CustomMatchersInitializer;
use PHPSpec2\Loader\Node\Specification;
use PHPSpec2\Matcher\MatchersCollection;
use PHPSpec2\Wrapper\ArgumentsUnwrapper;

require_once "Bossa/PHPSpec2/Expect/ObjectProphet.php";

if (!function_exists('expect')) {
    function expect($sus)
    {
        $presenter   = new TaggedPresenter(new Differ);
        $unwrapper   = new ArgumentsUnwrapper;
        $matchers    = new MatchersCollection($presenter);
        $initializer = new DefaultMatchersInitializer($presenter, $unwrapper);

        $initializer->initialize(new Specification('stdClass', new \ReflectionClass('stdClass')), $matchers);

        $trace = debug_backtrace();
        if (array_key_exists('class', $trace[1])) {
            $class = $trace[1]['class'];
            if (method_exists($class, 'getMatchers')) {
                $customMatchersInitializer = new CustomMatchersInitializer();
                $customMatchersInitializer->initialize(new Specification($class, new \ReflectionClass($class)), $matchers);
            }
        }

        return new Bossa\PHPSpec2\Expect\ObjectProphet($sus, $matchers, $unwrapper, $presenter);
    }
}
