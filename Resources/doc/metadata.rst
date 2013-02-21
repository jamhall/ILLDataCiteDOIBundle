Metadata
========

Introduction
------------

Please refer to the documentation for Metadata schema 2.2 which can be found [here](http://schema.datacite.org/meta/kernel-2.2/index.html)

When uploading metadata to the DataCite API, there are *5* required properties:

* Identifier (with type attribute)
* Creator (with name identifier attributes)
* Title (with optional type attribute)
* Publisher
* PublicationYear

The rest of the properties outlined in the documentation are optional.

In order to upload metadata to the API, it needs to be in an XML format which conforms to the [XSD schema](http://schema.datacite.org/meta/kernel-2.2/metadata.xsd).

This bundle works by serializing your POPOs (plain old php objects) into XML for the API and deserializes XML returned from the API into POPOs.

To upload some metadata which conforms to the minimum requirements, we can do the following:

```php
    // get the metadata manager from the service container
    $metadataManager = $this->container->get("ill_datacite_doi_metadata_manager");
    
    // create an instance of the metadata model and set the required attributes
    $metadata = new Metadata();
    // the identifier must start with "10."
    $metadata->setIdentifier("10.000/MYDATA")
              // the resource can have many creators
             ->addCreator(new Creator()->setName("Jamie Hall"))
             // the resource can have many titles
             ->addTitle(new Title()->setTitle("My new resource"))
             ->setPublisher("My company")
             ->setPublicationYear("2013);

    // create the metadata
    $metadataManager->create($metadata);
```
