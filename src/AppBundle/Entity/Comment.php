<?php
// src/AppBundle/Entity/Comment.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     name="`comment`",
 *     indexes={
 *         @ORM\Index(name="active", columns={"active"}),
 *         @ORM\Index(name="user_comment", columns={"user_comment"}),
 *         @ORM\Index(name="date_added", columns={"date_added"})
 *     }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @ORM\Column(type="bigint", options={"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="boolean", options={"default":1})
     */
    protected $active;

    /**
     * @ORM\Column(type="boolean", options={"default":1})
     */
    protected $userComment;

    /**
     * @ORM\Column(name="`text`", type="text", length=65535)
     */
    protected $text;

    /**
     * @ORM\Column(type="string", length=15, options={"default":""})
     */
    protected $ipAdded;

    /**
     * @ORM\Column(type="datetime", options={"default":"0000-00-00 00:00:00"})
     */
    protected $dateAdded;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="comments")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Firm", inversedBy="comments")
     * @ORM\JoinColumn(name="firm_id", referencedColumnName="id")
     */
    protected $firm;

    /**
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="comments")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     */
    protected $order;

    /**
     * @ORM\ManyToOne(targetEntity="CommentType", inversedBy="comments")
     * @ORM\JoinColumn(name="comment_type_id", referencedColumnName="id")
     */
    protected $commentType;

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
     * Set active
     *
     * @param boolean $active
     *
     * @return Comment
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
     * Set userComment
     *
     * @param boolean $userComment
     *
     * @return Comment
     */
    public function setUserComment($userComment)
    {
        $this->userComment = $userComment;

        return $this;
    }

    /**
     * Get userComment
     *
     * @return boolean
     */
    public function getUserComment()
    {
        return $this->userComment;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return Comment
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set ipAdded
     *
     * @param string $ipAdded
     *
     * @return Comment
     */
    public function setIpAdded($ipAdded)
    {
        $this->ipAdded = $ipAdded;

        return $this;
    }

    /**
     * Get ipAdded
     *
     * @return string
     */
    public function getIpAdded()
    {
        return $this->ipAdded;
    }

    /**
     * Set dateAdded
     *
     * @param \DateTime $dateAdded
     *
     * @return Comment
     */
    public function setDateAdded($dateAdded)
    {
        $this->dateAdded = $dateAdded;

        return $this;
    }

    /**
     * Get dateAdded
     *
     * @return \DateTime
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Comment
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set firm
     *
     * @param \AppBundle\Entity\Firm $firm
     *
     * @return Comment
     */
    public function setFirm(\AppBundle\Entity\Firm $firm = null)
    {
        $this->firm = $firm;

        return $this;
    }

    /**
     * Get firm
     *
     * @return \AppBundle\Entity\Firm
     */
    public function getFirm()
    {
        return $this->firm;
    }

    /**
     * Set order
     *
     * @param \AppBundle\Entity\Order $order
     *
     * @return Comment
     */
    public function setOrder(\AppBundle\Entity\Order $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \AppBundle\Entity\Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set commentType
     *
     * @param \AppBundle\Entity\CommentType $commentType
     *
     * @return Comment
     */
    public function setCommentType(\AppBundle\Entity\CommentType $commentType = null)
    {
        $this->commentType = $commentType;

        return $this;
    }

    /**
     * Get commentType
     *
     * @return \AppBundle\Entity\CommentType
     */
    public function getCommentType()
    {
        return $this->commentType;
    }
}
