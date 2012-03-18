# Symfony2 Graylog2 Error Logger

## What is it?

This is the Symfony2 version of my PHP Graylog2 Exception/ErrorHandler. It automatically logs unhandled errors to a graylog2 server of your choosing.

_Note_ Symfony2 has its own error handler in debug mode, and AFAIK there is no easy way of turning it off. This means that your dev/debug errors *won't* be logged to graylog.

## Usage

### Vendor bundle installation

Add the following code to your _deps_ file

    [NimLoggerBundle]
        git=git://github.com/Nimlhug/NimLoggerBundle.git
        target=/bundles/Nim/LoggerBundle
        version=v0.2

The update/install your dependencies, using the Symfony bin/vendors script.

    php bin/vendors install
    

### Configuration

Register the bundle in AppKernel.php

    $bundles[] = new Nim\SF2\LoggerBundle\NimLoggerBundle();
    

Configure autoload.php's registerNamespaces

    'Nim' => __DIR__.'/../vendor/bundles'
    
    
Configure your graylog server in config.yml

_Note:_ I strongly recommend you use an IP address and not a hostname.

    nim_logger:
        graylog_host: "123.123.123.123"

All done!

## TODO

 * More documentation
 * Some cleanup
 * Dust off the unit tests and add them to the SF2 code

## Questions?

Drop me a line!
