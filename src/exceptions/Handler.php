<?php declare(strict_types=1);
/* 
 * This file is part of the spf-core package which is distributed under the MIT License.
 * See LICENSE.md or go to https://github.com/simon-downes/spf-core for full license details.
 */
namespace spf\exceptions;

use Throwable, InvalidArgumentException;

use spf\SPF;
use spf\contracts\exceptions\Handler as ExceptionHandler;

class Handler implements ExceptionHandler {

    protected $error_page;

    public function __construct( string $error_page = '' ) {

        if( empty($error_page) ) {
            $error_page = __DIR__. '/error.php';
        }

        if( !file_exists($error_page) ) {
            throw new InvalidArgumentException("Invalid error page: {$error_page}");
        }

        $this->error_page = $error_page;

    }

    public function handle( Throwable $error ) {

        if( SPF::isCLI() ) {
            SPF::dump($error);
        }
        // debug error page
        elseif( SPF::isDebug() ) {
            require __DIR__. '/error.debug.php';
        }
        // production error page
        else {
            require $this->error_page;
        }

    }

}
