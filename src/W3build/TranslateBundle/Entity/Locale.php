<?php

namespace W3build\TranslateBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Locale
 *
 * @ORM\Table(name="locale")
 * @ORM\Entity(repositoryClass="W3build\TranslateBundle\Entity\LocaleRepository")
 */
class Locale
{

    const CZ = 1;
    const EN = 2;
    const DE = 3;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", options={"unsigned":true})
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=2, unique=true)
     */
    private $code;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active = 1;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="boolean")
     */
    private $deleted = 0;

    /**
     * @ORM\OneToMany(targetEntity="MsgStr", mappedBy="locale")
     */
    private $translations;


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
     * @param integer $id
     * @return $this
     */
    public function setId($id){
        $this->id = $id;

        return $this;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return Locale
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Locale
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return Locale
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean 
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Add translations
     *
     * @param MsgStr $translations
     * @return Locale
     */
    public function addTranslation(MsgStr $translations)
    {
        $this->translations[] = $translations;

        return $this;
    }

    /**
     * Remove translations
     *
     * @param MsgStr $translations
     */
    public function removeTranslation(MsgStr $translations)
    {
        $this->translations->removeElement($translations);
    }

    /**
     * Get translations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTranslations()
    {
        return $this->translations;
    }
}
