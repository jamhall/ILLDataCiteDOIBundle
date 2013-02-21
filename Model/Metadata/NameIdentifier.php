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

/**
 * The name identifier for a creator
 * Please see http://schema.datacite.org/meta/kernel-2.1/metadata.xsd for more detail.
 * @author Jamie Hall <hall@ill.eu>
 */
class NameIdentifier
{
    private $scheme = null;
    private $identifier;

    public function setIdentifier($identifier)
    {
        if (null === $this->scheme) {
            throw new \InvalidArgumentException("Please set the scheme before setting the identifier");
        } else {
            if (NonEmptyStringValidator::isValid("identifier", $identifier)) {
                $this->identifier = $identifier;
            }
        }

        return $this;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function setScheme($scheme)
    {
        if (NonEmptyStringValidator::isValid("scheme", $scheme)) {
            $this->scheme = $scheme;
        }

        return $this;
    }

    public function getScheme()
    {
        return $this->scheme;
    }
}
