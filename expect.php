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

use PhpSpec\Formatter\Presenter\TaggedPresenter;
use PhpSpec\Formatter\Presenter\Differ\Differ;
use PhpSpec\Wrapper\Unwrapper;
use PhpSpec\Runner\MatcherManager;
use Bossa\PhpSpec\Expect\Subject;
use PhpSpec\Matcher\IdentityMatcher;
use PhpSpec\Matcher\ComparisonMatcher;
use PhpSpec\Matcher\ThrowMatcher;
use PhpSpec\Matcher\TypeMatcher;
use PhpSpec\Matcher\ObjectStateMatcher;
use PhpSpec\Matcher\ScalarMatcher;
use PhpSpec\Matcher\ArrayCountMatcher;
use PhpSpec\Matcher\ArrayKeyMatcher;
use PhpSpec\Matcher\ArrayContainMatcher;
use PhpSpec\Matcher\StringStartMatcher;
use PhpSpec\Matcher\StringEndMatcher;
use PhpSpec\Matcher\StringRegexMatcher;

require_once 'Bossa/PhpSpec/Expect/Subject.php';

if (!function_exists('expect')) {
    function expect($sus)
    {
        $presenter = new TaggedPresenter(new Differ);
        $unwrapper = new Unwrapper;
        $matchers = new MatcherManager($presenter);
        $matchers->add(new IdentityMatcher($presenter));
        $matchers->add(new ComparisonMatcher($presenter));
        $matchers->add(new ThrowMatcher($unwrapper, $presenter));
        $matchers->add(new TypeMatcher($presenter));
        $matchers->add(new ObjectStateMatcher($presenter));
        $matchers->add(new ScalarMatcher($presenter));
        $matchers->add(new ArrayCountMatcher($presenter));
        $matchers->add(new ArrayKeyMatcher($presenter));
        $matchers->add(new ArrayContainMatcher($presenter));
        $matchers->add(new StringStartMatcher($presenter));
        $matchers->add(new StringEndMatcher($presenter));
        $matchers->add(new StringRegexMatcher($presenter));

        return new Subject($sus, $matchers, $unwrapper, $presenter);
    }
}
