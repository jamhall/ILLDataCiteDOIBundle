ILLDataCiteDOIBundle
=================

A symfony 2 bundle for communicating with the [mds.datacite.org](https://mds.datacite.org/) API to mint DOIs and register associated metadata.

*Note:* In order to use the API, it requires organisations to first register for an account with a [DataCite member](http://www.datacite.org/members)

Documentation
-------------

The bulk of the documentation is stored in the `Resources/doc/index.md`


Installation
------------

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
   username: YourDataCiteUsername
   password: YourDataCiteUsername
   identifier:   YourDataCiteIdentifier
   // enable for testing the creation of DOIs and metadata using a special test prefix(They will not be exposed by upcoming services like search and OAI)
   test: true
   // configure a proxy (if you're going through one for curl requests)
   proxy:
      host: example.com
      port: 8080
```

License
-------

This bundle is under the MIT license. See the complete license in the bundle:

    Resources/meta/LICENSE
