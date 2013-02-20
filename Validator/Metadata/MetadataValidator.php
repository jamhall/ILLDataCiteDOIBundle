<?php
/*
* This file is part of the ILLDataCiteDOIBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*
* @License  MIT License
*/

namespace ILL\DataCiteDOIBundle\Validator\Metadata;

use ILL\DataCiteDOIBundle\Model\Metadata;

/**
 * This class validates if a metadata model object is valid before it is created or updated
 * via the DataCite api
 * @author Jamie Hall <hall@ill.eu>
 */
class MetadataValidator
{
    /**
     * Check that minimum parameters are set
     * If the object does not fulfill the requirements then throw an exception
     * @param  Metadata $metadata
     * @return boolean
     */
    public static function isValid(Metadata $metadata)
    {

    }
}
