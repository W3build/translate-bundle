<?php

namespace W3build\TranslateBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MsgStr
 *
 * @ORM\Table(name="msg_str")
 * @ORM\Entity(repositoryClass="W3build\TranslateBundle\Entity\MsgStrRepository")
 */
class MsgStr
{

    /**
     * @var string
     *
     * @ORM\Column(name="msg_str", type="string", length=255)
     */
    private $msgStr;

    /**
     * @var integer
     *
     * @ORM\Column(name="count", type="integer", nullable=true)
     */
    private $count;

    /**
     * @var Locale
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Locale", inversedBy="translations")
     * @ORM\JoinColumn(name="locale_id", referencedColumnName="id", nullable=false)
     */
    private $locale;

    /**
     * @var MsgId
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="MsgId", inversedBy="msgStrings", fetch="EAGER")
     * @ORM\JoinColumn(name="msg_id", referencedColumnName="id", nullable=false)
     */
    private $msgId;

    public function __construct(MsgId $msgId, Locale $locale){
        $this->setMsgId($msgId)
             ->setLocale($locale);
    }

    /**
     * Set msgStr
     *
     * @param string $msgStr
     * @return MsgStr
     */
    public function setMsgStr($msgStr)
    {
        $this->msgStr = $msgStr;

        return $this;
    }

    /**
     * Get msgStr
     *
     * @return string 
     */
    public function getMsgStr()
    {
        return $this->msgStr;
    }

    /**
     * Set count
     *
     * @param integer $count
     * @return MsgStr
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get count
     *
     * @return integer 
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set locale
     *
     * @param \W3build\TranslateBundle\Entity\Locale $locale
     * @return MsgStr
     */
    public function setLocale(\W3build\TranslateBundle\Entity\Locale $locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get locale
     *
     * @return \W3build\TranslateBundle\Entity\Locale
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set msgId
     *
     * @param MsgId $msgId
     * @return MsgStr
     */
    public function setMsgId(MsgId $msgId)
    {
        $this->msgId = $msgId;

        return $this;
    }

    /**
     * Get msgId
     *
     * @return \W3build\TranslateBundle\Entity\MsgId
     */
    public function getMsgId()
    {
        return $this->msgId;
    }
}
