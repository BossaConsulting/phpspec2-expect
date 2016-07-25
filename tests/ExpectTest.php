<?php

include __DIR__ . '/Foo.php';

class ExpectTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider correctExpectations
     */
    function it_does_not_throw_when_expectation_is_met($expectation)
    {
        $expectation();
    }

    /**
     * @test
     * @dataProvider incorrectExpectations
     * @expectedException Exception
     */
    function it_throws_when_expectation_is_not_met($expectation)
    {
        $expectation();
    }

    /**
     * Cases that should evaluate without an exception
     */
    function correctExpectations()
    {
        return [
            [ function () {  expect(5)->toBe(5); } ],
            [ function () {  expect(5)->toBeLike('5'); } ],
            [ function () {  expect((new Foo()))->toHaveType('Foo'); } ],
            [ function () {  expect((new Foo()))->toHaveCount(1); } ],
            [ function () {  expect((new Foo()))->toBeFoo(); } ],
            [ function () {  expect((new Foo())->getArray())->toBeArray(); } ],
            [ function () {  expect((new Foo())->getString())->toBeString(); } ],
            [ function () {  expect(['foo'])->toContain('foo'); } ],
            [ function () {  expect(['foo' => 'bar'])->toHaveKey('foo'); } ],
            [ function () {  expect(['foo' => 'bar'])->toHaveKeyWithValue('foo','bar'); } ],
            [ function () {  expect('foo bar')->toContain('bar'); } ],
            [ function () {  expect('foo bar')->toStartWith('foo'); } ],
            [ function () {  expect('foo bar')->toEndWith('bar'); } ],
            [ function () {  expect('foo bar')->toMatch('/bar/'); } ],
            [ function () {  expect((new Foo()))->toThrow('InvalidArgumentException')->duringThrowException(); } ]
        ];
    }

    /**
     * Cases that should throw an exception when evaluated
     */
    function incorrectExpectations()
    {
        return [
            [ function () {  expect(6)->toBe(5); } ],
            [ function () {  expect(6)->toBeLike('5'); } ],
            [ function () {  expect((new Foo()))->toHaveType('Bar'); } ],
            [ function () {  expect((new Foo()))->toHaveCount(2); } ],
            [ function () {  expect((new Foo()))->toBeBar(); } ],
            [ function () {  expect((new Foo())->getString())->toBeArray(); } ],
            [ function () {  expect((new Foo())->getArray())->toBeString(); } ],
            [ function () {  expect(['foo'])->toContain('bar'); } ],
            [ function () {  expect(['foo' => 'bar'])->toHaveKey('bar'); } ],
            [ function () {  expect(['foo' => 'bar'])->toHaveKeyWithValue('foo','foo'); } ],
            [ function () {  expect('foo bar')->toContain('baz'); } ],
            [ function () {  expect('foo bar')->toStartWith('baz'); } ],
            [ function () {  expect('foo bar')->toEndWith('baz'); } ],
            [ function () {  expect('foo bar')->toMatch('/baz/'); } ],
            [ function () {  expect((new Foo()))->toThrow('AnotherException')->duringThrowException(); } ]
        ];
    }
}
