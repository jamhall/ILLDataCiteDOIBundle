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
    private $language;
    private $version;
    private $rights;
    private $publisher;
    private $publicationYear;

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
        $this->publicationYear = $publicationYear;

        return $this;
    }

    public function getPublicationYear()
    {
        return $this->publicationYear;
    }

}
