# Change variables according to your project

After you copy the skeleton run the `prefill.php` file,
answer the questions, it will change all variable names.
Remove the file after using it.

```shell
php prefill.php
rm prefill.php
```


# github

Create an empty repository with your account eclipxe13 named SatCatalogosPopulate

**do not include files `prefill.php` or `FIRST_STEPS.md`**

Create your git structure and add the github repository

```shell
git init
git remote add origin git@github.com:phpcfdi/sat-catalogos-populate.git
```


# travis

Access to your travis account on https://travis-ci.org/profile/eclipxe13
and enable the repository


# scrutinizer

Access to your scrutinizer account on https://scrutinizer-ci.com/
and add your repository


# insight.sensiolabs

Access to your insight account on https://insight.sensiolabs.com/
and add your project, this will create a UUID that you must use to replace
the string :INSIGHT_UUID inside README.md


# packagist

Access to your packagist account on https://packagist.org/profile/
and get your API token.

Then access to https://packagist.org/packages/submit and submit your
package https://github.com/phpcfdi/sat-catalogos-populate.git

Then access to github project, settings, integration and services, add services,
set your packagist username and token.


# next steps

- run `composer validate` to check for errors in `composer.json`
- edit `composer.json` tags
- run `composer install` to get initial project dependences
- open your favorite IDE and start working on!


# about

This skeleton was created for my personal use (Carlos C Soto), the file `prefill.php`
was taken from The PHP League Skeleton project.
https://raw.githubusercontent.com/thephpleague/skeleton/master/prefill.php

Happy coding! :smile:
