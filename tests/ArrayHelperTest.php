<?php declare(strict_types=1);
/* 
 * This file is part of the spf-contracts package which is distributed under the MIT License.
 * See LICENSE.md or go to https://github.com/simon-downes/spf-contracts for full license details.
 */

use PHPUnit\Framework\TestCase;

use Exception as HelperException;

use spf\helpers\ArrayHelper;

final class HelperTest extends TestCase {

    public function testUniqueIntegers(): void {

        $this->assertEmpty(
            array_diff(
                [0, 1, 2, 3],
                ArrayHelper::uniqueIntegers([1, 1, 2, '1', 3, 'sfsdf', "3sdfsdf", 2.4, 1])
            )
        );

    }

    public function testIsAssoc(): void {

        $this->assertFalse(
            ArrayHelper::isAssoc([1, 1, 2, '1', 3, 'sfsdf', "3sdfsdf", 2.4, 1])
        );

        $this->assertTrue(
            ArrayHelper::isAssoc([
                'foo' => 'bar',
                'bar' => 'baz',
            ])
        );

        $this->assertTrue(
            ArrayHelper::isAssoc([
                'foobar',
                'foo' => 'bar',
                'bar' => 'baz',
            ])
        );

    }

    public function testGet(): void {

        $data = [
            'foo' => 'bar',
        ];

        // key that exists
        $this->assertEquals(
            'bar',
            ArrayHelper::get($data, 'foo')
        );

        // non-existent key with default
        $this->assertEquals(
            'baz',
            ArrayHelper::get($data, 'bar', 'baz')
        );

        // non-existent key no default
        $this->assertNull(
            ArrayHelper::get($data, 'baz')
        );

    }

    public function testGetNullItems(): void {

        $data = [
            'foo' => 'bar',
            'bar' => null,
            'baz' => 'foo',
            'abc' => null,
        ];

        $this->assertEmpty(
            array_diff(
                [
                    'abc' => null,
                    'bar' => null,
                ],
                ArrayHelper::getNullItems($data)
            )
        );

    }

    public function testPluck(): void {

        $data = [
            'foo' => ['name' => 'foo', 'size' => 3],
            'bar' => ['name' => 'bar', 'size' => 1],
            'baz' => ['name' => 'baz', 'size' => 2],
        ];

        $this->assertEmpty(
            array_diff(
                [
                    'baz' => 'baz',
                    'foo' => 'foo',
                    'bar' => 'bar',
                ],
                ArrayHelper::pluck($data, 'name')
            )
        );

        $this->assertEmpty(
            array_diff(
                ['baz', 'foo', 'bar',],
                ArrayHelper::pluck($data, 'name', false)
            )
        );

    }

    public function testSum(): void {

        $data = [
            'foo' => ['name' => 'foo', 'size' => 3],
            'bar' => ['name' => 'bar', 'size' => 1],
            'baz' => ['name' => 'baz', 'size' => 2],
            'abc' => ['name' => 'abc'],
        ];

        $this->assertEquals(
            6,
            ArrayHelper::sum($data, 'size')
        );

    }

    public function testMin(): void {

        $data = [
            'foo' => ['name' => 'foo', 'size' => 3],
            'bar' => ['name' => 'bar', 'size' => 1],
            'baz' => ['name' => 'baz', 'size' => 2],
            'abc' => ['name' => 'abc'],
        ];

        $this->assertNull(
            ArrayHelper::min($data, 'size')
        );

        unset($data['abc']);

        $this->assertEquals(
            1,
            ArrayHelper::min($data, 'size')
        );


    }

    public function testMax(): void {

        $data = [
            'foo' => ['name' => 'foo', 'size' => 3],
            'bar' => ['name' => 'bar', 'size' => 1],
            'baz' => ['name' => 'baz', 'size' => 2],
            'abc' => ['name' => 'abc'],
        ];

        $this->assertEquals(
            3,
            ArrayHelper::max($data, 'size')
        );

    }

    public function testImplodeAssoc(): void {

        $data = [
            'abc' => null,
            'foo' => 'foo',
            'bar' => 'bar',
            'baz' => 'baz',
            'def' => '',
        ];

        $this->assertEquals(
            'foo=foo,bar=bar,baz=baz',
            ArrayHelper::implodeAssoc($data)
        );

        $this->assertEquals(
            'foo:foo;bar:bar;baz:baz',
            ArrayHelper::implodeAssoc($data, ';', ':')
        );

        $this->assertEquals(
            'abc:;foo:foo;bar:bar;baz:baz;def:',
            ArrayHelper::implodeAssoc($data, ';', ':', false)
        );

    }

}
