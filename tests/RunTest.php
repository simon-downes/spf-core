<?php declare(strict_types=1);
/* 
 * This file is part of the spf-contracts package which is distributed under the MIT License.
 * See LICENSE.md or go to https://github.com/simon-downes/spf-contracts for full license details.
 */

use PHPUnit\Framework\TestCase;

use spf\SPF;

final class RunTest extends TestCase {

    public function testClosure(): void {

        $result = SPF::run(function( $arg1, $arg2 ) {
            return $arg1. $arg2;
        }, 'foo', 'bar');

        $this->assertEquals('foobar', $result);

    }

    public function testInstanceMethod(): void {

        $runner = new Runner();

        $result = SPF::run([$runner, 'instanceMethod'], 'foo', 'bar');

        $this->assertEquals('foobar', $result);

    }

    public function testStaticMethod(): void {

        $result = SPF::run([Runner::class, 'staticMethod'], 'foo', 'bar');

        $this->assertEquals('foobar', $result);

    }

    public function testInvokable(): void {

        $runner = new Runner();

        $result = SPF::run($runner, 'foo', 'bar');

        $this->assertEquals('foobar', $result);

    }

}

final class Runner {

    public static function staticMethod( $arg1, $arg2 ) {
        return $arg1. $arg2;
    }

    public function instanceMethod( $arg1, $arg2 ) {
        return $arg1. $arg2;
    }

    public function __invoke( $arg1, $arg2 ) {
        return $arg1. $arg2;
    }

}