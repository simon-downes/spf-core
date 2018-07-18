# SPF Core

The lightweight core of SPF (Si's PHP Framework).
Provides error and exception handling and commonly used helper functions.

## Requirements

This library requires only PHP 7.2 or later and the SPF Contracts package (`simon-downes/spf-contracts`).

## Installation

It is installable and autoloadable via Composer as `simon-downes/spf-core`.

Alternatively, download a release or clone this repository, and add the `\spf` namespace to an autoloader.

## License

SPF Core is open-sourced software licensed under the MIT license. See LICENSE.md for details.

## Quick Start

SPF Core provides a basic exception and error handling wrapper for blocks of code, be they command-line scripts,
complete web apps or simple functions.

Running code with SPF is a simple as calling the static `run()` method with a `callable` parameter.

```php
use spf\SPF;

// Using a closure
SPF::run(function() {
  echo "Hello World";
});

// Using a function name
function hello() {
  echo "Hello World";
}
SPF::run('hello');

// Using an object...
class Foo {
  public static function hello() {
    echo "Hello World";
  }
  public function helloWorld() {
    echo "Hello World";
  }
  public function __invoke() {
    $this->helloWorld();
  }
}

// ...static callback
SPF::run(['Foo', 'hello']);

// ...instance callback
$o = new Foo();
SPF::run([$o, 'helloWorld']);

// ...invokable object
SPF::run($o);
```

## Error and Exception Handling

SPF Core provides default error and exception handlers:
* Errors are converted to `ErrorException`s and passed to the exception handler if the error matches the current `error_reporting` level.
* Exceptions are handled by the specified exception handler or a default one if none is specified.

You can specify a custom exception handler by passing a callable to the appropriate method:
```php
use spf\SPF;

SPF::setExceptionHandler($callback);
```

## Debug Flag

SPF provides a debug flag accessible via:

```php
use spf\SPF;

// enable/disable debug flag
SPF::setDebug(true);

// Return current setting of debug flag
SPF::isDebug();
```

Usage of the debug flag is left almost entirely to clients. The only uses within the framework are:
* to determine whether to display a detailed error page (if debug flag is set) or a simple static error page
* calls to the `d()` and `dd()` dump functions are ignored if the debug flag is not set

The default simple static error page can be overriden: by passing the path and file name to the ```
```php
use spf\SPF;

SPF::setErrorPage($path_to_file);
```

## Variable Dumping

SPF provides an enhanced `var_dump()` implementation that can output detailed variable information in plain text.

```php
use spf\SPF;

SPF:dump($var);
```

SPF also defines two shortcut functions for accessing the variable dumping functionality:
* `d()` - calls `SPF::dump()` for each passed argument
* `dd()` - same as `d()` but will call `die()` once the arguments have been dumped

These shortcut methods do nothing if the debug flag is not set.

## Helpers

SPF provides a variety of helper functions and more can be easily added. Helper functions are implemented as static
class methods and registered either by passing the class name to the `SPF::registerHelper()` method (registers all
public static methods) or by passing a class and method name to the `SPF::addHelperMethod()` (registers a single method).
Once registered helper functions can be called via static method call to `SPF`.

```php
use spf\SPF;

class MyHelper {
  public static function foo() {
    echo 'foo';
  }
  public static function bar() {
    echo 'bar';
  }
}

SPF::registerHelper('\\MyHelper');

SPF::foo();
SPF::bar();
```

### General Helpers

* `isCLI()` - determines if the script is running in a CLI environment

### Array Helpers

* `uniqueIntegers()` - return an array of unique integers
* `isTraversable()` - determines if a variable can be interated over using `foreach`
* `isAssoc()` - determine if an array is associative or not
* `filterObjects()` - filter an array to instances of a specific class
* `get()` - return an item from an array or object or a default value if the item doesn't exist
* `getNullItems()` - filter an array to items that are null
* `pluck()` - extract a single field from an array of arrays of objects
* `sum()` - calculate the sum of the specified item from an array of arrays or objects
* `min()` - calculate the min of the specified item from an array of arrays or objects
* `max()` - calculate the max of the specified item from an array of arrays or objects
* `implodeAssoc()` - implode an associative array into an array of key/value pairs
* `makeComparer()` - create a comparison function for sorting multi-dimensional arrays

### Date/Time Helpers

* `makeTimestamp` - convert a value into a timestamp
* `seconds()` - convert a string representation containing one or more of hours, minutes and seconds into a total number of seconds

### String Helpers

* `parseURL()` - parse a url into an array of it's components
* `randomHex()` - generate a random hex string of a specific length
* `randomString()` - generate a random string of a specific length
* `uncamelise()` - convert a camel-cased string to lower case with underscores
* `slugify()` - convert a string into a form suitable for urls
* `removeAccents()` - convert accented characters to their regular counterparts
* `latin1()` - convert a UTF-8 string into Latin1 (ISO-8859-1)
* `utf8()` - convert a Latin1 (ISO-8859-1) into UTF-8
* `ordinal()` - return the ordinal suffix (st, nd, rd, th) of a number
* `sizeFormat()` - convert a number of bytes to a human-friendly string using the largest suitable unit

* `xssClean()` - remove XSS vulnerabilities from a string
* `stripControlChars()` - remove control characters from a string

### Inflection Helpers

* `pluralise()` - Determine the plural form of a word (English only)
* `singularise()` - Determine the single form of a word (English only)
