<?php

namespace W3build\TranslateBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MsgId
 *
 * @ORM\Table(name="msg_id")
 * @ORM\Entity(repositoryClass="W3build\TranslateBundle\Entity\MsgIdRepository")
 */
class MsgId
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", options={"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="msg_id", type="string", length=255, unique=true)
     */
    private $msgId;

    /**
     * @ORM\OneToMany(targetEntity="MsgStr", mappedBy="msgId")
     */
    private $msgStrings;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->msgStrings = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set msgId
     *
     * @param string $msgId
     * @return MsgId
     */
    public function setMsgId($msgId)
    {
        $this->msgId = $msgId;

        return $this;
    }

    /**
     * Get msgId
     *
     * @return string 
     */
    public function getMsgId()
    {
        return $this->msgId;
    }

    /**
     * Add msgString
     *
     * @param MsgStr $msgString
     * @return MsgId
     */
    public function addMsgString(MsgStr $msgString)
    {
        $this->msgStrings[] = $msgString;

        return $this;
    }

    /**
     * Remove msgString
     *
     * @param MsgStr $msgString
     */
    public function removeMsgString(MsgStr $msgString)
    {
        $this->msgStrings->removeElement($msgString);
    }

    /**
     * Get msgStrings
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMsgStrings()
    {
        return $this->msgStrings;
    }
}
