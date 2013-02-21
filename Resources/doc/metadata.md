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

To create the same data as defined in the example above, we can do the following (there is a PHP 5.4 example furtherdown)
``` php
// create an instance of the metadata model and set the required attributes
$metadata = new Metadata();
// the identifier must start with "10."
$metadata->setIdentifier("10.1594/WDCC/CCSRNIES_SRES_B2")
         ->setPublisher("World Data Center for Climate (WDCC)")
         ->setPublicationYear("2004");

// create a creator
$creator = new Creator();
$creator->setName("Miller, John");
$metadata->addCreator($creator);

// create another creator with a name identifier
$creator = new Creator();
$creator->setName("Smith, Jane");
$nameIdentifier = new NameIdentifier();
$nameIdentifier->setScheme("ISNI")
               ->setIdentifier("1422 4586 3573 0476");
$creator->addNameIdentifier($nameIdentifier);
$metadata->addCreator($creator);

// create a title
$title = new Title();
$title->setTitle("National Institute for Environmental Studies and Center for Climate System Research Japan");
$metadata->addTitle($title);

// create another title with a type
$title = new Title();
$title->setTitle("A survey");
$title->setType("Subtitle");
$metadata->addTitle($title);

// create a subject
$subject = new Subject();
$subject->setSubject("Earth sciences and geology");
$metadata->addSubject($subject);

// create a subject with a scheme
$subject = new Subject();
$subject->setSubject("551 Geology, hydrology, meteorology")
        ->setScheme("DDC");
$metadata->addSubject($subject);

// create a contributor
$contributor = new Contributor();
$contributor->setType("DataManager")
            ->setName("PANGEA");
$metadata->addContributor($contributor);

// create a contributor with a name identifier
$contributor = new Contributor();
$contributor->setType("ContactPerson")
            ->setName("Doe, John");
$nameIdentifier = new NameIdentifier();
$nameIdentifier->setScheme("ORCID")
               ->setIdentifier("xyz789");
$contributor->addNameIdentifier($nameIdentifier);
$metadata->addContributor($contributor);

// create a date
$date = new Date();
$date->setType("Valid")
     ->setDate("2005-04-05");
$metadata->addDate($date);

// create another date
$date = new Date();
$date->setType("Accepted")
     ->setDate("2005-01-01");
$metadata->addDate($date);

// create a resource type
$resourceType = new ResourceType();
$resourceType->setResourceType("Image")
             ->setType("Animation");
$metadata->setResourceType($resourceType);

// create an alternate identifier
$alternateIdentifier = new AlternateIdentifier();
$alternateIdentifier->setType("ISBN")
                    ->setIdentifier("937-0-1234-56789-X");
$metadata->addAlternateIdentifier($alternateIdentifier);

// create a related identifier
$relatedIdentifier = new RelatedIdentifier();
$relatedIdentifier->setRelatedIdentifierType("DOI")
                    ->setRelationType("IsCitedBy")
                    ->setIdentifier("10.1234/testpub");
$metadata->addRelatedIdentifier($relatedIdentifier);

// create another related identifier
$relatedIdentifier = new RelatedIdentifier();
$relatedIdentifier->setRelatedIdentifierType("URN")
                    ->setRelationType("Cites")
                    ->setIdentifier("http://testing.ts/testpub");
$metadata->addRelatedIdentifier($relatedIdentifier);

// add sizes
$metadata->addSize(new Size("285 kb"));
$metadata->addSize(new Size("100 pages"));

// add a format
$metadata->addFormat(new Format("text/plain"));

// set version
$metadata->setVersion("1.0");

// set rights
$metadata->setRights("Open Database License [ODbL]");

// add a description
$description = new Description();
$description->setType("Other")
            ->setDescription('The current xml-example for a DataCite record is the official example from the documentation.<br/>Please look on datacite.org to find the newest versions of sample data and schemas.');
$metadata->addDescription($description);
```

PHP 5.4 now supports class member access on instantiation. We can achive exactly same outcome with less code:

```php
        $metadata = new Metadata();
        $metadata->setIdentifier("10.1594/WDCC/CCSRNIES_SRES_B2")
                 ->setPublisher("World Data Center for Climate (WDCC)")
                 ->setPublicationYear("2004")
                 ->addCreator((new Creator)->setName("Miller, John"))
                 ->addCreator((new Creator)->setName("Smith, Jane")
                                           ->addNameIdentifier((new NameIdentifier)->setScheme("ISNI")
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
                                                   ->addNameIdentifier((new NameIdentifier)->setScheme("ORCID")
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
                 ->addDescription((new Description)->setType("Other")
                                                   ->setDescription('The current xml-example for a DataCite record is the official example from the documentation.<br/>Please look on datacite.org to find the newest versions of sample data and schemas.'));
```
