# MediaWiki-GitViewer

Based on [Klaus Silveira](http://www.klaussilveira.com)'s [GitList](http://gitlist.org/),
this extension provides a web interface for interacting with multiple git repositories.
It allows you to browse repositories using your favorite browser, viewing files under different revisions, commit history, diffs.

## Features
* Multiple repository support
* Multiple branch support
* Multiple tag support
* Commit history, blame, diff
* Syntax highlighting
* Repository statistics

## Development
GitList uses [Composer](http://getcomposer.org/) to manage dependencies and [Ant](http://ant.apache.org/) to build the project. In order to run all the targets in the build script, you will need [PHPUnit](http://www.phpunit.de/), [phpcpd](https://github.com/sebastianbergmann/phpcpd), [phploc](https://github.com/sebastianbergmann/phploc), [PHPMD](http://phpmd.org/) and [PHP_Depend](http://pdepend.org).

If you just want to get the project dependencies, instead of building everything:

```
git clone https://github.com/klaussilveira/gitlist.git
curl -s http://getcomposer.org/installer | php
php composer.phar install
```

## License
[BSD-2-Clause](http://www.opensource.org/licenses/bsd-license.php)
