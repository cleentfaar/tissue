# Tissue [![License](https://poser.pugx.org/cleentfaar/tissue/license.svg)](https://packagist.org/packages/cleentfaar/tissue)

A PHP library that scans your files for viruses. It does this by providing adapters for various virus-scanning software.
Currently, the only adapter available is the `ClamAvAdapter` which, obviously, integrates the ClamAV scanner into your projects.

**NOTE:** If your project is built on top of the Symfony Framework, you are much better off using the [TissueBundle](https://github.com/cleentfaar/CLTissueBundle)
that was specially made for it.

[![Build Status](https://secure.travis-ci.org/cleentfaar/tissue.svg)](http://travis-ci.org/cleentfaar/tissue)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/cleentfaar/tissue/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/cleentfaar/tissue/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/cleentfaar/tissue/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/cleentfaar/tissue/?branch=master)<br/>
[![Latest Stable Version](https://poser.pugx.org/cleentfaar/tissue/v/stable.svg)](https://packagist.org/packages/cleentfaar/tissue)
[![Total Downloads](https://poser.pugx.org/cleentfaar/tissue/downloads.svg)](https://packagist.org/packages/cleentfaar/tissue)
[![Latest Unstable Version](https://poser.pugx.org/cleentfaar/tissue/v/unstable.svg)](https://packagist.org/packages/cleentfaar/tissue)


### Documentation

- [Installation](Resources/doc/installation.md)
- [Usage](Resources/doc/usage.md)
- [Contributing](Resources/doc/contributing.md)


### Important

**I highly recommend you to research the security issues involved before using any of these packages on a production server!**

Although following the steps described in the documentation should be enough to keep most evil-doers from uploading infected
files to your application, I can never give any 100% guarantee! You should take care in keeping your virus-scanner's signature
database up-to-date, otherwise new viruses may get through. You should also keep in mind that there are many more ways to
abuse uploads than just uploading an infected file!

**Make sure your application cannot be manipulated to execute any of the uploaded files! Not even those deemed 'clean'!**

For instance, if you were to keep files available on your web-directory after they have been uploaded, you better
make sure that there is **NO CHANCE** that the file may get executed by your application in one way or another.

A malicious user could simply upload a piece of PHP-code (no virus!) that will open your application up to a huge range
of leaks. Again, that's just one of the reasons that you should not solely rely on this package protecting your site!

Read up on this subject before opening up your application to possible security leaks! **I am not responsible for
any damage done to your server or application while using this package!**


### FAQ

**Q:** Why is there no adapter for [virusscanner here] yet?

**A:** I don't always have the time to make new stuff so if you would like to contribute adapters feel free to submit
an issue or an PR for it! Take a look at the [contributing guide](Resources/doc/contributing.md) for instructions, thanks!
