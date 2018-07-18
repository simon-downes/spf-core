<?php declare(strict_types=1);
/* 
 * This file is part of the spf-contracts package which is distributed under the MIT License.
 * See LICENSE.md or go to https://github.com/simon-downes/spf-contracts for full license details.
 */

use spf\SPF;

defined('SPF_START_TIME') || define('SPF_START_TIME', microtime(true));
defined('SPF_START_MEM')  || define('SPF_START_MEM', memory_get_usage());

if( !function_exists('d') ) {
	function d( ...$vars ) {
		if( !SPF::isDebug() ) {
			return;
		}
		foreach( $vars as $var ) {
			SPF::dump($var);
		}
	}
	function dd( ...$vars ) {
		if( !SPF::isDebug() ) {
			return;
		}
		if( !SPF::isCLI() ) {
			headers_sent() || header('Content-type: text/plain; charset=UTF-8');
		}
		foreach( $vars as $var ) {
			SPF::dump($var);
		}
		die();
	}
}
