<?php

namespace ILL\DataCiteDOIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DOI
 *
 * @ORM\Table(name="DOI")
 * @ORM\Entity(repositoryClass="ILL\DataCiteDOIBundle\Repository\DOIRepository")
 */
class DOI
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="DOI", type="string", length=150)
     */
    private $doi;

    /**
     * @var string
     *
     * @ORM\Column(name="OBJ_ID", type="string", length=10)
     */
    private $objectId;

    /**
     * @var string
     *
     * @ORM\Column(name="TYPE", type="string", length=150)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="CREATION_DATE", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="LAST_UPDATE", type="datetime")
     */
    private $updated;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set DOI
     *
     * @param  string $doi
     * @return doi
     */
    public function setDoi($doi)
    {
        $this->doi = $doi;

        return $this;
    }

    /**
     * Get DOI
     *
     * @return string
     */
    public function getDoi()
    {
        return $this->doi;
    }

    /**
     * Set objectId
     *
     * @param  string $objectId
     * @return DOI
     */
    public function setObjectId($objectId)
    {
        $this->objectId = $objectId;

        return $this;
    }

    /**
     * Get objectId
     *
     * @return string
     */
    public function getObjectId()
    {
        return $this->objectId;
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
