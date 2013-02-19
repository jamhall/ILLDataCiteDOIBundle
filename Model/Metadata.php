<?php
/*
* This file is part of the ILLDataCiteDOIBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*
* @License  MIT License
*/

namespace ILL\DataCiteDOIBundle\Model;

class Metadata
{
    private $identifier;
    /**
     * Register a new DOI (or primary identifier) when the version of the resource changes to enable the citation of the exact version of a research dataset (or other resource).
     * May be used in conjunction with properties 11 and 12 (AlternateIdentifier and RelatedIdentifier)
     * to indicate various information updates.
     */
    private $version;
    private $rights;
    private $publisher;
    private $publicationYear;
    private $language;

    public function __construct($identifier = null)
    {
        if (null !== $identifier) {
            $this->setIdentifier($identifier);
        }
    }

    public function setIdentifier($identifier)
    {
        // check if a valid year
        if (true === preg_match("[1][0][/.].*" , $identifier)) {
            $this->identifier = $identifier;

            return $this;
        }
        throw new \InvalidArgumentException("Not a valid identifier. DOI must start with '10.'");
    }

    pulic function getIdentifier()
    {
        return $this->identifier;
    }

    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setRights($rights)
    {
        $this->rights = $rights;

        return $this;
    }

    public function getRights()
    {
        return $this->rights;
    }

    public function setPublisher($publisher)
    {
        $this->publisher = $publisher;

        return $this;
    }

    public function getPublisher()
    {
        return $this->publisher;
    }

    public function setPublicationYear($publicationYear)
    {
        // check if a valid year
        if (true === preg_match("^\d{4}$" , $publicationYear)) {
            $this->publicationYear = $publicationYear;

            return $this;
        }
        throw new \InvalidArgumentException("Not a valid year. It must be of the format: YYYY");
    }

    public function getPublicationYear()
    {
        return $this->publicationYear;
    }

}
