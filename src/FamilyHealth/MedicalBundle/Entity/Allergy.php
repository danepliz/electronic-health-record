<?php

namespace FamilyHealth\MedicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Allergy
 *
 * @ORM\Table(name="fhn_allergies")
 * @ORM\Entity
 */
class Allergy
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="precautions", type="text")
     */
    private $precautions;

    /**
     * @var string
     *
     * @ORM\Column(name="probableAreas", type="text")
     */
    private $probableAreas;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;


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
     * Set name
     *
     * @param string $name
     *
     * @return Allergy
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Allergy
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set precautions
     *
     * @param string $precautions
     *
     * @return Allergy
     */
    public function setPrecautions($precautions)
    {
        $this->precautions = $precautions;

        return $this;
    }

    /**
     * Get precautions
     *
     * @return string
     */
    public function getPrecautions()
    {
        return $this->precautions;
    }

    /**
     * Set probableAreas
     *
     * @param string $probableAreas
     *
     * @return Allergy
     */
    public function setProbableAreas($probableAreas)
    {
        $this->probableAreas = $probableAreas;

        return $this;
    }

    /**
     * Get probableAreas
     *
     * @return string
     */
    public function getProbableAreas()
    {
        return $this->probableAreas;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Allergy
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }
}

