# dev-debugger
==============

## Installation
It is recommended to only require the package for development.
```cmd
composer require vietstars/dev-debugger --dev
```
## Laravel without auto-discovery:

If you don't use auto-discovery, add the ServiceProvider to the providers array in config/app.php
```php
Vietstars\DevDebugger\ServiceProvider::class,
```

If you want to use the facade to log messages, add this to your facades in app.php:
```php
'Debug' => Vietstars\DevDebugger\Facades\DevDebugger::class,
```

## Copy the package config to your local config with the publish command:
```cmd
php artisan vendor:publish --provider="Vietstars\DevDebugger\ServiceProvider"
```

## Usage
You can now add messages using the Facade (when added), using the PSR-3 levels (debug, info, notice, warning, error, critical, alert, emergency):

```php
Debug::info($object);
Debug::error('Error!');
Debug::warning('Watch out…');
Debug::addMessage('Another message', 'mylabel');
```

And start/stop timing:

```php
Debug::startMeasure('render','Time for rendering');
Debug::stopMeasure('render');
Debug::addMeasure('now', LARAVEL_START, microtime(true));
Debug::measure('My long operation', function() {
    // Do something…
});
```

Or log exceptions:

```php
try {
    throw new Exception('foobar');
} catch (Exception $e) {
    Debug::addThrowable($e);
}
```

There are also helper functions available for the most common calls:

```php
// All arguments will be dumped as a debug message
debug($var1, $someString, $intValue, $object);

// `$collection->debug()` will return the collection and dump it as a debug message. Like `$collection->dump()`
collect([$var1, $someString])->debug();

start_measure('render','Time for rendering');
stop_measure('render');
add_measure('now', LARAVEL_START, microtime(true));
measure('My long operation', function() {
    // Do something…
});
```

If you want you can add your own DataCollectors, through the Container or the Facade:

```php
Debug::addCollector(new DebugBar\DataCollector\MessagesCollector('my_messages'));
//Or via the App container:
$debug = App::make('debugbar');
$debug->addCollector(new DebugBar\DataCollector\MessagesCollector('my_messages'));
```

By default, the Debugbar is injected just before `</body>`. If you want to inject the Debugbar yourself,
set the config option 'inject' to false and use the renderer yourself and follow http://phpdebugbar.com/docs/rendering.html

```php
$renderer = Debug::getJavascriptRenderer();
```

Note: Not using the auto-inject, will disable the Request information, because that is added After the response.
You can add the default_request datacollector in the config as alternative.

## Enabling/Disabling on run time
You can enable or disable the debugbar during run time.

```php
Debug::enable();
Debug::disable();
```
Once enabled, the collectors are added (and could produce extra overhead), so if you want to use the debugbar in production, disable in the config and only enable when needed.
