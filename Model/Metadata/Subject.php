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
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Subject, keywords, classification codes, or key phrases describing the resource.
 * Please see http://schema.datacite.org/meta/kernel-2.2/metadata.xsd for more detail.
 * @author Jamie Hall <hall@ill.eu>
 */
class Subject
{
    /**
     * @Type("string")
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
    private $subject;

    /**
     * @Type("string")
     */
    private $scheme;

    public function setSubject($subject)
    {
        $this->subject= $subject;;

        return $this;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setScheme($scheme)
    {
        $this->scheme = $scheme;

        return $this;
    }

    public function getScheme()
    {
        return $this->scheme;
    }
}
