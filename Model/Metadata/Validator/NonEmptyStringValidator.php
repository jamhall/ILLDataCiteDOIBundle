<?php
/*
* This file is part of the ILLDataCiteDOIBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*
* @License  MIT License
*/

namespace ILL\DataCiteDOIBundle\Model\Metadata\Validator;
use ILL\DataCiteDOIBundle\Model\Metadata\Validator\ValidatorInterface;

/**
 * A validator to check that a string has the minimum length of 1 character
 * This validator is defined in the metadata xsd file.
 * Please see http://schema.datacite.org/meta/kernel-2.0/metadata.xsd for more detail.
 */
class NonEmptyString implements ValidatorInterface
{
    public static function isValid($attributeName, $value)
    {
        if (1 < strlen($name)) {
            throw new \InvalidArgumentException(sprintf("%s must have a minimum length of 1 character"), $attributeName);
        }

        return true;
    }
}
