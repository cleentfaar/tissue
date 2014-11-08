# Creating your own adapter

## Orientation

If there is no adapter yet for the virus-scanner you want to use, or if there are license issues that keep you from using
any of the available adapters, you may want to think of creating an adapter for it.

A good starting point for this is to simply take a look at how the existing [ClamAV adapter](https://github.com/cleentfaar/tissue-clamav-adapter)
was made. It's code could be copied almost entirely, and just refactor it to something that fits your virus-scanner's requirements.


## Getting started

To get you started on the right track, here's what you need:

1. Create a class that implements `AdapterInterface`
2. Implement the `scan(...)` method, consisting of:
  1. Running your virus-scanner's detection engine (targeting the files given with the `$paths` argument)
  2. Catch the output from your virus-scanner's result
  3. Converting the output into an instance of `ScanResult`
