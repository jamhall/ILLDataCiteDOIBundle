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

/*
 * This class represents a DOI
 * @author Mr. Jamie Hall <hall@ill.eu>
 */
class DOI
{
    /**
     * The identifier
     *
     * @var string
     * Assert\Regex(pattern="/^[-_a-zA-Z0-9.:\+\\]+$/", message="The following characters are only allowed in a DOI name: 0-9, a-z, A-Z, dash, dot, underscore, plus, colon and slash")
     */
    protected $identifier;

    protected $metadata;
    protected $metadataReference;
    /**
     * The URL for the DOI
     *
     * @var string
     * @Assert\Url()
     */
    protected $url;

    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Gets the id
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Gets the URL for the DOI
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get the metadata of the DOI
     * @return object Metadata
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

}
