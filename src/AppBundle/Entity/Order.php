<?php
// src/AppBundle/Entity/Order.php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     name="`order`",
 *     indexes={
 *         @ORM\Index(name="active", columns={"active"}),
 *         @ORM\Index(name="recommendation", columns={"recommendation"}),
 *         @ORM\Index(name="date_added", columns={"date_added"})
 *     }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrderRepository")
 */
class Order
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
     * @ORM\Column(type="bigint", options={"unsigned":true, "default":0})
     */
    protected $recommendation;

    /**
     * @ORM\Column(type="string", length=50, options={"default":""})
     */
    protected $name;

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
     * @ORM\Column(type="string", length=15, options={"default":""})
     */
    protected $ipUpdated;

    /**
     * @ORM\Column(type="datetime", options={"default":"0000-00-00 00:00:00"})
     */
    protected $dateUpdated;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="orders")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Firm", inversedBy="orders")
     * @ORM\JoinColumn(name="firm_id", referencedColumnName="id")
     */
    protected $firm;

    /**
     * @ORM\ManyToOne(targetEntity="OrderType", inversedBy="orders")
     * @ORM\JoinColumn(name="order_type_id", referencedColumnName="id")
     */
    protected $orderType;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="order")
     */
    protected $comments;

    /**
     * @ORM\OneToMany(targetEntity="Mark", mappedBy="order")
     */
    protected $marks;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->marks = new ArrayCollection();
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
     * Set active
     *
     * @param boolean $active
     *
     * @return Order
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
     * Set recommendation
     *
     * @param integer $recommendation
     *
     * @return Order
     */
    public function setRecommendation($recommendation)
    {
        $this->recommendation = $recommendation;

        return $this;
    }

    /**
     * Get recommendation
     *
     * @return integer
     */
    public function getRecommendation()
    {
        return $this->recommendation;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Order
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
     * Set text
     *
     * @param string $text
     *
     * @return Order
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
     * @return Order
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
     * @return Order
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
     * Set ipUpdated
     *
     * @param string $ipUpdated
     *
     * @return Order
     */
    public function setIpUpdated($ipUpdated)
    {
        $this->ipUpdated = $ipUpdated;

        return $this;
    }

    /**
     * Get ipUpdated
     *
     * @return string
     */
    public function getIpUpdated()
    {
        return $this->ipUpdated;
    }

    /**
     * Set dateUpdated
     *
     * @param \DateTime $dateUpdated
     *
     * @return Order
     */
    public function setDateUpdated($dateUpdated)
    {
        $this->dateUpdated = $dateUpdated;

        return $this;
    }

    /**
     * Get dateUpdated
     *
     * @return \DateTime
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Order
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
     * @return Order
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
     * Set orderType
     *
     * @param \AppBundle\Entity\OrderType $orderType
     *
     * @return Order
     */
    public function setOrderType(\AppBundle\Entity\OrderType $orderType = null)
    {
        $this->orderType = $orderType;

        return $this;
    }

    /**
     * Get orderType
     *
     * @return \AppBundle\Entity\OrderType
     */
    public function getOrderType()
    {
        return $this->orderType;
    }

    /**
     * Add comment
     *
     * @param \AppBundle\Entity\Comment $comment
     *
     * @return Order
     */
    public function addComment(\AppBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \AppBundle\Entity\Comment $comment
     */
    public function removeComment(\AppBundle\Entity\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Add mark
     *
     * @param \AppBundle\Entity\Mark $mark
     *
     * @return Order
     */
    public function addMark(\AppBundle\Entity\Mark $mark)
    {
        $this->marks[] = $mark;

        return $this;
    }

    /**
     * Remove mark
     *
     * @param \AppBundle\Entity\Mark $mark
     */
    public function removeMark(\AppBundle\Entity\Mark $mark)
    {
        $this->marks->removeElement($mark);
    }

    /**
     * Get marks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMarks()
    {
        return $this->marks;
    }
}
