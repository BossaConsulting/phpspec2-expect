<?php

use Bossa\PhpSpec\Expect\Subject;
use Bossa\PhpSpec\Expect\Wrapper;
use PhpSpec\CodeAnalysis\MagicAwareAccessInspector;
use PhpSpec\CodeAnalysis\VisibilityAccessInspector;
use PhpSpec\Console\Assembler\PresenterAssembler;
use PhpSpec\Exception\ExceptionFactory;
use PhpSpec\Factory\ReflectionFactory;
use PhpSpec\Loader\Node\ExampleNode;
use PhpSpec\Matcher\ApproximatelyMatcher;
use PhpSpec\Matcher\ArrayContainMatcher;
use PhpSpec\Matcher\ArrayCountMatcher;
use PhpSpec\Matcher\ArrayKeyMatcher;
use PhpSpec\Matcher\ArrayKeyValueMatcher;
use PhpSpec\Matcher\CallbackMatcher;
use PhpSpec\Matcher\ComparisonMatcher;
use PhpSpec\Matcher\IdentityMatcher;
use PhpSpec\Matcher\IterateAsMatcher;
use PhpSpec\Matcher\Matcher;
use PhpSpec\Matcher\MatchersProvider;
use PhpSpec\Matcher\ObjectStateMatcher;
use PhpSpec\Matcher\ScalarMatcher;
use PhpSpec\Matcher\StringContainMatcher;
use PhpSpec\Matcher\StringEndMatcher;
use PhpSpec\Matcher\StringRegexMatcher;
use PhpSpec\Matcher\StringStartMatcher;
use PhpSpec\Matcher\ThrowMatcher;
use PhpSpec\Matcher\TriggerMatcher;
use PhpSpec\Matcher\TypeMatcher;
use PhpSpec\Runner\MatcherManager;
use PhpSpec\ServiceContainer\IndexedServiceContainer;
use PhpSpec\Wrapper\Subject\Caller;
use PhpSpec\Wrapper\Subject\ExpectationFactory;
use PhpSpec\Wrapper\Subject\SubjectWithArrayAccess;
use PhpSpec\Wrapper\Subject\WrappedObject;
use PhpSpec\Wrapper\Unwrapper;
use Symfony\Component\EventDispatcher\EventDispatcher;

$useExpect = true;

if (getenv('PHPSPEC_DISABLE_EXPECT') || (defined('PHPSPEC_DISABLE_EXPECT') && PHPSPEC_DISABLE_EXPECT)) {
    $useExpect = false;
}

if ($useExpect && !function_exists('expect')) {
    function expect($sus)
    {
        $container = new IndexedServiceContainer;
        (new PresenterAssembler)->assemble($container);
        $container->configure();

        $presenter = $container->get('formatter.presenter');

        $unwrapper = new Unwrapper;
        $eventDispatcher = new EventDispatcher;
        $accessInspector = new MagicAwareAccessInspector(new VisibilityAccessInspector);
        $reflectionFactory = new ReflectionFactory();
        $exampleNode = new ExampleNode('expect', new \ReflectionFunction(__FUNCTION__));

        $matchers  = new MatcherManager($presenter);
        $matchers->add(new IdentityMatcher($presenter));
        $matchers->add(new ComparisonMatcher($presenter));
        $matchers->add(new ThrowMatcher($unwrapper, $presenter, $reflectionFactory));
        $matchers->add(new TypeMatcher($presenter));
        $matchers->add(new ObjectStateMatcher($presenter));
        $matchers->add(new ScalarMatcher($presenter));
        $matchers->add(new ArrayCountMatcher($presenter));
        $matchers->add(new ArrayKeyMatcher($presenter));
        $matchers->add(new ArrayKeyValueMatcher($presenter));
        $matchers->add(new ArrayContainMatcher($presenter));
        $matchers->add(new StringStartMatcher($presenter));
        $matchers->add(new StringEndMatcher($presenter));
        $matchers->add(new StringRegexMatcher($presenter));
        $matchers->add(new StringContainMatcher($presenter));
        if (class_exists('TriggerMatcher')) {
            $matchers->add(new TriggerMatcher($unwrapper));
        }
        if (class_exists('IterateAsMatcher')) {
            $matchers->add(new IterateAsMatcher($presenter));
        }
        if (class_exists('ApproximatelyMatcher')) {
            $matchers->add(new ApproximatelyMatcher($presenter));
        }

        $trace = debug_backtrace();
        if (isset($trace[1]['object'])) {
            $object = $trace[1]['object'];

            if ($object instanceof MatchersProvider) {
                foreach ($object->getMatchers() as $name => $matcher) {
                    if ($matcher instanceof Matcher) {
                        $matchers->add($matcher);
                    } elseif(is_callable($matcher)) {
                        $matchers->add(new CallbackMatcher($name, $matcher, $presenter));
                    } else {
                        throw new \RuntimeException('Custom matcher has to implement "PhpSpec\Matcher\MatcherInterface" or be a callable');
                    }
                }
            }
        }

        $exceptionFactory = new ExceptionFactory($presenter);
        $wrapper = new Wrapper($matchers, $presenter, $eventDispatcher, $exampleNode, $accessInspector);
        $wrappedObject = new WrappedObject($sus, $presenter);
        $caller = new Caller($wrappedObject, $exampleNode, $eventDispatcher, $exceptionFactory, $wrapper, $accessInspector);
        $arrayAccess = new SubjectWithArrayAccess($caller, $presenter, $eventDispatcher);
        $expectationFactory = new ExpectationFactory($exampleNode, $eventDispatcher, $matchers);

        return new Subject($sus, $wrapper, $wrappedObject, $caller, $arrayAccess, $expectationFactory);
    }
}
