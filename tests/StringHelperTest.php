<?php declare(strict_types=1);
/* 
 * This file is part of the spf-contracts package which is distributed under the MIT License.
 * See LICENSE.md or go to https://github.com/simon-downes/spf-contracts for full license details.
 */

use PHPUnit\Framework\TestCase;

use Exception as HelperException;

use spf\SPF;
use spf\helpers\StringHelper;

final class StringHelperTest extends TestCase {

    public function testRandomHex(): void {

        for( $i = 0; $i < 10; $i++ ) {

            $length  = rand(10, 100);

            if( ($length % 2) == 1 ) {
                $length++;
            }

            $hex = StringHelper::randomHex($length);
            
            $this->assertRegExp("/[\da-f]+/i", $hex);
            $this->assertEquals($length, strlen($hex));

        }

    }

    public function testRandomString(): void {

        for( $i = 0; $i < 5; $i++ ) {

            $length  = rand(10, 100);

            $str = StringHelper::randomString($length);
            
            $this->assertRegExp("/[\da-z]+/i", $str);
            $this->assertEquals($length, strlen($str));

        }

        $length = rand(10, 100);
        $str    = StringHelper::randomString($length, 'abcdef');
        $this->assertRegExp("/[a-f]+/i", $str);
        $this->assertEquals($length, strlen($str));

        $length = rand(10, 100);
        $str    = StringHelper::randomString($length, '!"<>%^&*({[]})');
        $this->assertRegExp("/[!\"<>\$%^&*({\[\]})]+/i", $str);
        $this->assertEquals($length, strlen($str));

    }

    public function testUncamelise(): void {
        
        $this->assertEquals(
            'foo_bar_baz',
            StringHelper::uncamelise('FooBarBaz')
        );

        $this->assertEquals(
            'foo_bar_baz',
            StringHelper::uncamelise('fooBarBaz')
        );

        $this->assertEquals(
            'foo',
            StringHelper::uncamelise('FOO')
        );

    }

    public function testSlugify(): void {

        $this->assertEquals(
            'foo-sa-gbp-usd-eur-and-bar',
            StringHelper::slugify('foo--şÅ-£-$-€-&-bar')
        );

    }

}
