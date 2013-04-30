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
     * The prefix for the DOI
     *
     * @var string
     * @Assert\NotNull()
     */
    protected $prefix;

    /**
     * The suffix for the DOI
     *
     * @var string
     * @Assert\NotNull()
     */
    protected $suffix;

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
     * Get identifier of a DOI by concatenating the prefix and suffix
     *
     * @return integer
     */
    public function getIdentifier()
    {
        return sprintf("%s/%s", $this->prefix, $this->suffix);
    }

    /**
     * Sets the URL
     */
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
     * Sets the prefix
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Gets the prefix for the DOI
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Sets the suffix
     */
    public function setSuffix($suffix)
    {
        $this->suffix = $suffix;

        return $this;
    }

    /**
     * Gets the suffix for the DOI
     *
     * @return string
     */
    public function getSuffix()
    {
        return $this->suffix;
    }
}
