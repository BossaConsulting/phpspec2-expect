<?php

if (is_dir($vendor = __DIR__ . '/../vendor')) {
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

use PHPSpec2\Wrapper\ArgumentsUnwrapper,
    PHPSpec2\Matcher\MatchersCollection;

require_once "Bossa/PHPSpec2/Expect/ObjectProphet.php";

function expect($sus) {
    return new Bossa\PHPSpec2\Expect\ObjectProphet($sus, new MatchersCollection, new ArgumentsUnwrapper);
}    






