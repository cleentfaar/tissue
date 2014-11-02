## Contributing


### Coding standards

Your code should follow [Symfony's coding standards](http://symfony.com/doc/current/contributing/code/standards.html) as close as possible.


### Conventions

Your code should follow [Symfony's code conventions](http://symfony.com/doc/current/contributing/code/conventions.html) as close as possible.


### Testing your code locally

Please make sure the unit tests run without failures before - and after - contributing. To do this, simply run your tests
using the phpunit version bundled with the library, like this:

    $ ./bin/phpunit


### New adapters

If you want to add a new adapter to the existing ones, you can get started by taking a look at how the [Clam AV adapter](https://github.com/cleentfaar/tissue-clamav-adapter)
was made, and base your adapter off that.
