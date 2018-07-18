<?php declare(strict_types=1);
/* 
 * This file is part of the spf-contracts package which is distributed under the MIT License.
 * See LICENSE.md or go to https://github.com/simon-downes/spf-contracts for full license details.
 */

use PHPUnit\Framework\TestCase;

use spf\SPF;

final class DebugTest extends TestCase {

    public function testDebug(): void {

        SPF::setDebug(true);

        $this->assertTrue(SPF::isDebug());

        SPF::setDebug(false);

        $this->assertFalse(SPF::isDebug());

    }

    public function testDump(): void {

        $this->assertFalse(function_exists('d'));

        SPF::init();

        $this->assertTrue(function_exists('d'));
        $this->assertTrue(function_exists('dd'));

    }

}
