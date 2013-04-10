<?php
/*
* This file is part of the ILLDataCiteDOIBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*
* @License  MIT License
*/

namespace ILL\DataCiteDOIBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @author Mr. Jamie Hall <hall@ill.eu>
 */
class MetadataIdentifier extends Constraint
{
    public $message = 'The identifier "%string%" contains an invalid character.';

    public $prefix = null;

    public function __construct($prefix)
    {
        $this->prefix = $prefix;
    }
}
