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

use Symfony\Component\Validator\Constraints as Assert;
/*
 * This class represents a DOI
 * @author Jamie Hall <hall@ill.eu>
 */
class DOI
{
    /**
     * The identifier
     *
     * @var string
     * @Assert\Regex(pattern="/^[-_a-zA-Z0-9.:\+\\]+$/", message="The following characters are only allowed in a DOI name: 0-9, a-z, A-Z, dash, dot, underscore, plus, colon and slash")
     */
    protected $id;

    /**
     * The URL for the DOI
     *
     * @var string
     * @Assert\Url()
     */
    protected $url;

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets the id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
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
}
