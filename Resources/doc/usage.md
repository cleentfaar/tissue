## Usage

By now you probably understood that this library provides adapter-classes that can implement various virus-scanner engines.
By default, the `ClamAV` engine is the default adapter, but you could easily create your own adapters for the engine of your choice.

```php
<?php
$adapter = new ClamAVAdapter('...');
$result = $adapter->scan(['/path/to/scary/file', '/path/to/scary/dir']);

// do we have a virus?
$result->hasVirus(); // returns either true or false

// what was scanned?
$result->getFiles(); // returns all the files that were scanned during the operation, as an array of strings (absolute paths)

// what whas detected then?
$result->getDetections(); // returns an array of `Detection` instances if one or more viruses were detected
```


### Real world example

If you want to see an adapter for a real virus-scanner, check out the [ClamAv](https://github.com/cleentfaar/tissue-clamav-adapter) adapter.
