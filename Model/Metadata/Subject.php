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
 * Subject, keywords, classification codes, or key phrases describing the resource.
 * Please see http://schema.datacite.org/meta/kernel-2.0/metadata.xsd for more detail.
 */
class Subject
{
    private $subject;
    private $scheme;

    public function setSubject($subject)
    {
        if (null === $subject) {
            throw new \Exception("Subject cannot be empty");
        } else {
            $this->subject= $subject;;

            return $this;
        }
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setScheme($scheme)
    {
        return $this->scheme;
    }

    public function getScheme()
    {
        return $this->scheme;
    }
}
