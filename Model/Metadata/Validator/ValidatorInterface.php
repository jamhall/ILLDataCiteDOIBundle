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

interface ValidatorInterface
{
    // checks if an attributes value is valid
    public static function isValid($attributeName, $value);
}
