<?php
/*
* This file is part of the ILLDataCiteDOIBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*
* @License  MIT License
*/

namespace ILL\DataCiteDOIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
/**
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 */
abstract class DOI
{
    /**
     * @var string
     *
     * @ORM\Column(name="DOI_SUFFIX", type="string", length=150)
     */
    private $suffix;

    /**
     * @var string
     *
     * @ORM\Column(name="DOI_PREFIX", type="string", length=7)
     */
    private $prefix;

    /**
     * @var string
     *
     * @ORM\Column(name="DOI_TYPE", type="string", length=100)
     */
    private $type;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="DOI_CREATED_AT", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="DOI_UPDATED_AT", type="datetime")
     */
    private $updated;

    /**
     * Set prefix
     *
     * @param  string $prefix
     * @return DOI
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Get prefix
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Set suffix
     *
     * @param  string $suffix
     * @return DOI
     */
    public function setSuffix($suffix)
    {
        $this->suffix = $suffix;

        return $this;
    }

    /**
     * Get suffix
     *
     * @return string
     */
    public function getSuffix()
    {
        return $this->suffix;
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
     * Set type
     *
     * @param  string $type
     * @return DOI
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set created
     *
     * @param  \DateTime $created
     * @return DOI
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param  \DateTime $updated
     * @return DOI
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }
}
