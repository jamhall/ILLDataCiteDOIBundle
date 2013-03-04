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
 * This class represents a media object for a DOI
 * With Media you can register different representation of your dataset or metadata,
 * e.g. you could register image/jpeg if you have an image representation.
 * @author Mr. Jamie Hall <hall@ill.eu>
 */
class Media
{
    /**
     * The mimetype
     *
     * @var string
     */
    protected $mimeType;

    /**
     * The URL
     *
     * @var string
     */
    protected $url;

    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Gets the mimetype
     *
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Gets the URL
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}
