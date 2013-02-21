<?php
/*
* This file is part of the ILLDataCiteDOIBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*
* @License  MIT License
*/

namespace ILL\DataCiteDOIBundle\Model\Metadata;
use ILL\DataCiteDOIBundle\Model\Metadata\Validator\NonEmptyStringValidator;
use ILL\DataCiteDOIBundle\Model\Metadata\NameIdentifier;
/**
 * The main researchers involved working on the data, or the authors of the publication in
 * priority order. May be a corporate/institutional or personal name.
 * Please see http://schema.datacite.org/meta/kernel-2.1/metadata.xsd for more detail.
 * @author Jamie Hall <hall@ill.eu>
 */
class Creator
{
    private $name;
    private $nameIdentifiers = array();

    static public function instantiate()
    {
        return new self();
    }

    public function setName($name)
    {
        if (NonEmptyStringValidator::isValid("name", $name)) {
            $this->name = $name;
        }

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function addNameIndentifier(NameIdentifier $nameIdentifier)
    {
        $this->nameIdentifiers[] = $nameIdentifier;

        return $this;
    }

    public function getNameIdentifiers()
    {
        return $this->nameIdentifiers;
    }
}
