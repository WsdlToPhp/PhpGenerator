# PhpGenerator, a Real PHP source code generator

> PhpGenerator helps to generate PHP source code

[![License](https://poser.pugx.org/wsdltophp/phpgenerator/license)](https://packagist.org/packages/wsdltophp/phpgenerator)
[![Latest Stable Version](https://poser.pugx.org/wsdltophp/phpgenerator/version.png)](https://packagist.org/packages/wsdltophp/phpgenerator)
[![TeamCity build status](https://teamcity.mikael-delsol.fr/app/rest/builds/buildType:id:PhpGenerator_Build/statusIcon.svg)](https://github.com/WsdlToPhp/PhpGenerator)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/WsdlToPhp/PhpGenerator/badges/quality-score.png)](https://scrutinizer-ci.com/g/WsdlToPhp/PhpGenerator/)
[![Code Coverage](https://scrutinizer-ci.com/g/WsdlToPhp/PhpGenerator/badges/coverage.png)](https://scrutinizer-ci.com/g/WsdlToPhp/PhpGenerator/)
[![Total Downloads](https://poser.pugx.org/wsdltophp/phpgenerator/downloads)](https://packagist.org/packages/wsdltophp/phpgenerator)
[![StyleCI](https://styleci.io/repos/36832375/shield)](https://styleci.io/repos/36832375)
[![SymfonyInsight](https://insight.symfony.com/projects/a384481c-01ba-4c20-a8c6-a4d852ee7985/mini.svg)](https://insight.symfony.com/projects/a384481c-01ba-4c20-a8c6-a4d852ee7985)

Even if this project is yet another PHP source code generator, its main goal is to provide a consistent PHP source code generator for the [PackageGenerator](https://github.com/WsdlToPhp/PackageGenerator) project. Nevertheless, it also aims to be used for any PHP source code generation process as it generates standard PHP code.

Rest assured that it is not tweaked for the purpose of the [PackageGenerator](https://github.com/WsdlToPhp/PackageGenerator) project.

## Main features
This project contains two main features:

- [Element](src/Element/README.md): generate basic elements
- [Component](src/Component/README.md): generate structured complex elements

## Testing using [Docker](https://www.docker.com/)
Thanks to the [Docker image](https://hub.docker.com/r/splitbrain/phpfarm) of [phpfarm](https://github.com/fpoirotte/phpfarm), tests can be run locally under *any* PHP version using the cli:
- php-7.4

First of all, you need to create your container which you can do using [docker-compose](https://docs.docker.com/compose/) by running the below command line from the root directory of the project:
```bash
$ docker-compose up -d --build
```

You then have a container named `php_generator` in which you can run `composer` commands and `php cli` commands such as:
```bash
# install deps in container (using update ensure it does use the composer.lock file if there is any)
$ docker exec -it php_generator php-7.4 /usr/bin/composer update
# run tests in container
$ docker exec -it php_generator php-7.4 -dmemory_limit=-1 vendor/bin/phpunit
```

## FAQ

If you have a question, feel free to [create an issue](https://github.com/WsdlToPhp/PhpGenerator/issues/new).

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
