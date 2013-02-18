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

/**
 * The main researchers involved working on the data, or the authors of the publication in
 * priority order. May be a corporate/institutional or personal name.
 * Please see http://schema.datacite.org/meta/kernel-2.0/metadata.xsd for more detail.
 */
class Creator
{
    private $name;
    private $nameIdentifier = array();

    public function setName($name)
    {
        if (null === $name) {
            throw new \Exception("Creator name cannot be null");
        }
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setNameIdentifier($scheme, $value)
    {
        $this->nameIdentifier = array("scheme"=$scheme, "value"=>$value);

        return $this;
    }

    public function getNameIdentifier()
    {
        return $this->nameIdentifier;
    }
}
