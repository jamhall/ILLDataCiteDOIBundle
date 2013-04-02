ILLDataCiteDOIBundle
====================

At the moment this bundle is not stable. It is being actively developed.

[![knpbundles.com](http://knpbundles.com/ILLGrenoble/ILLDataCiteDOIBundle/badge-short)](http://knpbundles.com/ILLGrenoble/ILLDataCiteDOIBundle)


A symfony 2 bundle for communicating with the [mds.datacite.org](https://mds.datacite.org/) API to mint DOIs and register associated metadata.

**Note** 

In order to use the API, it requires organisations to first register for an account with a [DataCite member](http://www.datacite.org/members).

This bundle has only been **tested with Symfony 2.1**. If you would like it to work with a **Symfony 2.0** project then please fork the repository and modify the code.

## Documentation

The bulk of the documentation is stored in the [Resources/doc/index.md](Resources/doc/index.md)

## Installation

Installation is a quick (I promise!) three step process:

1. Download ILLDataCiteDOIBundle using composer
2. Enable the Bundle
3. Configure your application's config.yml

### Step 1: Download ILLDataCiteDOIBundle using composer

Add FOSUserBundle in your composer.json:

```js
{
    "require": {
        "illgrenoble/datacite-doi-bundle": "*"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update illgrenoble/datacite-doi-bundle
```

Composer will install the bundle to your project's `vendor/illgrenoble` directory.

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new ILL\DataCiteDOIBundle\ILLDataCiteDOIBundle(),
    );
}
```
### Step 2: Configure your application's config.yml
``` yaml
ill_data_cite_doi:
   username: DataCiteMDSUsername
   password: DataCiteMDSPassword
   prefix:   YourFacilityPrefix
   proxy: ~
   # Entity class representating your DOI database table
   doi_class: ILL\DateCiteDOITestBundle\Entity\DOI
   # valid domains for registering a DOI to an URL
   domains: "/^(.*)\.ill\.fr/"
   # identifier types patterns that a DOI must match
   identifier_types:
        - { type: ARTICLE, pattern: "/^ILL-ARTICLE-[A-Za-z0-9\-.\_]+/" }
        - { type: BOOK, pattern: "/^ILL-BOOK-[A-Za-z0-9\-.\_]+/" }
        - { type: REPORT, pattern: "/^ILL-ARTICLE-[A-Za-z0-9\-.\_]+/" }
        - { type: DATA, pattern: "/^ILL-DATA-\d+-\d+-\d+)/" }
        - { type: PROCEEDINGS, pattern: "/^ILL-PROCEEDINGS-[A-Za-z0-9\-.\_]+/" }
twig:
    globals:
        logo : http://example.com/images/logo.gif
```

License
-------

This bundle is under the MIT license. The license is stored in [Resources/meta/LICENSE](Resources/meta/LICENSE)

Authors
-------

Mr. Jamie Hall - Technical Projects group at Institut Laue-Langevin.
