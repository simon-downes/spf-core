<?php declare(strict_types=1);
/* 
 * This file is part of the spf-contracts package which is distributed under the MIT License.
 * See LICENSE.md or go to https://github.com/simon-downes/spf-contracts for full license details.
 */

use PHPUnit\Framework\TestCase;

use Exception as HelperException;

use spf\SPF;

final class HelperTest extends TestCase {

    /**
     * Test adding a class of helper functions.
     */
    public function testRegisterHelperClass(): void {

        SPF::registerHelpers([HelperFoo::class]);

        $this->assertEquals('foobar', SPF::fooBar());

        // shouldn't be able to add another method with the same name from a different class
        $this->expectException(HelperException::class);

        SPF::registerHelpers([static::class]);

    }

    /**
     * Test adding a single helper method from a class.
     */
    public function testAddHelperMethod(): void {

        SPF::addHelperMethod(HelperBar::class, 'barBaz');

        $this->assertEquals('barbaz', SPF::barBaz());

        // shouldn't be able to add another method with the same name from a different class
        $this->expectException(HelperException::class);

        SPF::addHelperMethod(static::class, 'barBaz');

    }

    /**
     * Test not being permitted to override core
     */
    public function testNoOverride(): void {

        $this->expectException(HelperException::class);

        SPF::addHelperMethod(static::class, 'dump');

    }

    public static function dump( $var ): string {
        return (string) $var;
    }

    public static function fooBar(): string {
        return 'foobar';
    }

    public static function barBaz(): string {
        return 'barbaz';
    }

}

/**
 * Test stub.
 */
final class HelperFoo {
    public static function fooBar() {
        return 'foobar';
    }
}

/**
 * Test stub.
 */
final class HelperBar {
    public static function barBaz() {
        return 'barbaz';
    }
}
