## Usage

By now you probably understood that this library provides adapter-classes that can implement various virus-scanner engines.

Since each adapter can have very different configuration requirements, exactly what arguments you will need to construct an
adapter's-class is something you need to check out in the respective adapter's documentation.

For instance, the ClamAVAdapter's documentation can be found [here](https://github.com/cleentfaar/tissue-clamav-adapter/Resources/doc/usage.md).

**NOTE: Like the `clamav` adapter, every adapter has a `Resources/doc/usage.md` document that will give you more details about what is needed for it to work.**

Having been constructed, all adapters work the same way: they scan a given path(s) and return an instance of `ScanResult`.

To give you a general idea of how each adapter works, here's an example of an imaginative AcmeScannerAdapter.
To be sure, you still need to check out your specific adapter's documentation for instructions on how to set it up.

```php
<?php
# path/to/your/app/scanner.php

$adapter = new AcmeScannerAdapter('...');
$result = $adapter->scan('/path/to/scary/file');

// do we have a virus?
$result->hasVirus(); // returns either true or false

// what was scanned?
$result->getFiles(); // returns all the files that were scanned during the operation, as an array of strings (absolute paths)

// what whas detected then?
$result->getDetections(); // returns an array of `Detection` instances if one or more viruses were detected
```
