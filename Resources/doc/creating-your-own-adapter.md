# Creating your own adapter

## Orientation

If there is no adapter yet for the virus-scanner you want to use, or if there are license issues that keep you from using
any of the available adapters, you may want to think of creating an adapter for it.

A good starting point for this is to simply take a look at how the existing [ClamAV adapter](https://github.com/cleentfaar/tissue/Adapter/ClamAVAdapter)
was made. It's code could be copied almost entirely, and just refactored to something that fits your virus-scanner's requirements.

I will go through the basic procedures you need to follow below.


## Getting started

To get you started on the right track, here's what you need:

Method a) If your scanner only supports a single file/dir to be scanned at the same time:

  1. Have your class extend `AbstractAdapter` and implement the `detect()` method, cases where multiple paths need to
     be scanned will be handled for you automatically.

Method b) If your scanner supports scanning of multiple files:

  1. Create a class that extends `AdapterInterface`
  2. Implement the `scan(...)` method, making sure to:
    1. Run your virus-scanner's detection engine (targeting the files given with the `$paths` argument)
    2. Catch the output from your virus-scanner's result
    3. Converting the output into an instance of `ScanResult`


## Write a test case

Every adapter should have at least one test-case which extends `AbstractAdapterTestCase`.
For most adapters, it's enough to simply return your adapter instance with the `createAdapter()` method:
```php
<?php
//...
class AcmeAdapterTestCase extends AbstractAdapterTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function createAdapter()
    {
        return AcmeAdapter();
    }
}
//...
```
