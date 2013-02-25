Metadata
========

Please refer to the documentation for Metadata schema 2.2 which can be found [here](http://schema.datacite.org/meta/kernel-2.2/index.html)

When uploading metadata to the DataCite API, there are *5* required properties:

* Identifier (with type attribute)
* Creator (with name identifier attributes)
* Title (with optional type attribute)
* Publisher
* PublicationYear

The rest of the properties outlined in the documentation are optional.

In order to upload metadata to the API, it needs to be in an XML format which conforms to the [XSD schema](http://schema.datacite.org/meta/kernel-2.2/metadata.xsd)

This bundle works by serializing your POPOs (plain old php objects) into XML for the API and deserializes XML returned from the API into POPOs.

To create some metadata, we need to instantiate a`Metadata` model object I'll use this [example](http://schema.datacite.org/meta/kernel-2.2/example/datacite-metadata-sample-v2.2.xml) as it uses every attribute outlined in the schema.

To create the same data as defined in the example above, we can do the following (this is using PHP 5.4 because we are using class member access on instantiation. If you are using PHP 5.4 then please assign the class instantiation to a variable)
``` php
$metadata = new Metadata();
$metadata->setIdentifier("10.1594/WDCC/CCSRNIES_SRES_B2")
         ->setPublisher("World Data Center for Climate (WDCC)")
         ->setPublicationYear("2004")
         ->addCreator((new Creator)->setName("Miller, John"))
         ->addCreator((new Creator)->setName("Smith, Jane")
                                   ->setNameIdentifier((new NameIdentifier)->setScheme("ISNI")
                                                                           ->setIdentifier("1422 4586 3573 0476")))
         ->addTitle((new Title)->setTitle("National Institute for Environmental Studies and Center for Climate System Research Japan"))
         ->addTitle((new Title)->setTitle("A survey")
                               ->setType("Subtitle"))
         ->addSubject((new Subject)->setSubject("Earth sciences and geology"))
         ->addSubject((new Subject)->setSubject("551 Geology, hydrology, meteorology")
                                   ->setScheme("DDC"))
         ->addContributor((new Contributor)->setType("DataManager")
                                           ->setName("PANGEA"))
         ->addContributor((new Contributor)->setType("ContactPerson")
                                           ->setName("Doe, John")
                                           ->setNameIdentifier((new NameIdentifier)->setScheme("ORCID")
                                                                                   ->setIdentifier("xyz780")))
         ->addDate((new Date)->setType("Valid")
                             ->setDate("2005-04-05"))
         ->addDate((new Date)->setType("Accepted")
                             ->setDate("2005-01-01"))
         ->setResourceType((new ResourceType)->setResourceType("Image")
                                             ->setType("Animation"))
         ->addAlternateIdentifier((new AlternateIdentifier)->setType("ISBN")
                                                           ->setIdentifier("937-0-1234-56789-X"))
         ->addRelatedIdentifier((new RelatedIdentifier)->setRelatedIdentifierType("DOI")
                                                       ->setRelationType("IsCitedBy")
                                                       ->setIdentifier("10.1234/testpub"))
         ->addRelatedIdentifier((new RelatedIdentifier)->setRelatedIdentifierType("DOI")
                                                       ->setRelationType("IsCitedBy")
                                                       ->setIdentifier("10.1234/testpub"))
         ->addSize(new Size("285 kb"))
         ->addSize(new Size("100 pages"))
         ->addFormat(new Format("text/plain"))
         ->setRights("Open Database License [ODbL]")
         ->setVersion("1.0")
         ->setLanguage("eng")
         ->addDescription((new Description)->setType("Other")
                                           ->setDescription('The current xml-example for a DataCite record is the official example from the documentation.<br/>Please look on datacite.org to find the newest versions of sample data and schemas.'));
```

To create the metadata:

``` php
$mdm = $container->get("ill_data_cite_doi.metadata_manager");
$mdm->create($metadata);
```

To update the metadata using the same object(the version is updated automatically by the API):

``` php
$mdm = $container->get("ill_data_cite_doi.metadata_manager");
$mdm->update($metadata);
```

To find metadata for a DOI and update it:

```php
$mdm = $container->get("ill_data_cite_doi.metadata_manager");
$metadata = $mdm->find("IDENTIFIER");
if($metadata) {
    $metadata->addCreator((new Creator)->setName("Bloggs, Joe"));
    $mdm->update($metadata);
}
```
