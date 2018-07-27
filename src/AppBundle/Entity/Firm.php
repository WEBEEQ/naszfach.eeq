<?php
// src/AppBundle/Entity/Firm.php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     name="firm",
 *     indexes={
 *         @ORM\Index(name="active", columns={"active"}),
 *         @ORM\Index(name="visible", columns={"visible"}),
 *         @ORM\Index(name="order", columns={"order"}),
 *         @ORM\Index(name="name", columns={"name"}),
 *         @ORM\Index(name="street", columns={"street"}),
 *         @ORM\Index(name="postcode", columns={"postcode"}),
 *         @ORM\Index(name="mark_precision", columns={"mark_precision"}),
 *         @ORM\Index(name="mark_contact", columns={"mark_contact"}),
 *         @ORM\Index(name="mark_time", columns={"mark_time"}),
 *         @ORM\Index(name="mark_price", columns={"mark_price"}),
 *         @ORM\Index(name="comment_number", columns={"comment_number"}),
 *         @ORM\Index(name="date_added", columns={"date_added"})
 *     }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FirmRepository")
 */
class Firm
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
    protected $visible;

    /**
     * @ORM\Column(name="`order`", type="boolean", options={"default":1})
     */
    protected $order;

    /**
     * @ORM\Column(type="string", length=100, options={"default":""})
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=100, options={"default":""})
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=100, options={"default":""})
     */
    protected $url;

    /**
     * @ORM\Column(type="string", length=12, options={"default":""})
     */
    protected $phone;

    /**
     * @ORM\Column(type="string", length=30, options={"default":""})
     */
    protected $street;

    /**
     * @ORM\Column(type="string", length=6, options={"default":""})
     */
    protected $postcode;

    /**
     * @ORM\Column(type="text", length=65535)
     */
    protected $description;

    /**
     * @ORM\Column(type="decimal", precision=3, scale=2, options={"unsigned":true, "default":"0.00"})
     */
    protected $markPrecision;

    /**
     * @ORM\Column(type="decimal", precision=3, scale=2, options={"unsigned":true, "default":"0.00"})
     */
    protected $markContact;

    /**
     * @ORM\Column(type="decimal", precision=3, scale=2, options={"unsigned":true, "default":"0.00"})
     */
    protected $markTime;

    /**
     * @ORM\Column(type="decimal", precision=3, scale=2, options={"unsigned":true, "default":"0.00"})
     */
    protected $markPrice;

    /**
     * @ORM\Column(type="integer", options={"unsigned":true, "default":0})
     */
    protected $commentNumber;

    /**
     * @ORM\Column(name="comment_positive_7_days", type="integer", options={"unsigned":true, "default":0})
     */
    protected $commentPositive7Days;

    /**
     * @ORM\Column(name="comment_neutral_7_days", type="integer", options={"unsigned":true, "default":0})
     */
    protected $commentNeutral7Days;

    /**
     * @ORM\Column(name="comment_negative_7_days", type="integer", options={"unsigned":true, "default":0})
     */
    protected $commentNegative7Days;

    /**
     * @ORM\Column(name="comment_positive_30_days", type="integer", options={"unsigned":true, "default":0})
     */
    protected $commentPositive30Days;

    /**
     * @ORM\Column(name="comment_neutral_30_days", type="integer", options={"unsigned":true, "default":0})
     */
    protected $commentNeutral30Days;

    /**
     * @ORM\Column(name="comment_negative_30_days", type="integer", options={"unsigned":true, "default":0})
     */
    protected $commentNegative30Days;

    /**
     * @ORM\Column(name="comment_positive_all_days", type="integer", options={"unsigned":true, "default":0})
     */
    protected $commentPositiveAllDays;

    /**
     * @ORM\Column(name="comment_neutral_all_days", type="integer", options={"unsigned":true, "default":0})
     */
    protected $commentNeutralAllDays;

    /**
     * @ORM\Column(name="comment_negative_all_days", type="integer", options={"unsigned":true, "default":0})
     */
    protected $commentNegativeAllDays;

    /**
     * @ORM\Column(type="datetime", options={"default":"0000-00-00 00:00:00"})
     */
    protected $commentDate;

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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="firms")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Province", inversedBy="firms")
     * @ORM\JoinColumn(name="province_id", referencedColumnName="id")
     */
    protected $province;

    /**
     * @ORM\ManyToOne(targetEntity="City", inversedBy="firms")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     */
    protected $city;

    /**
     * @ORM\OneToMany(targetEntity="FirmCategory", mappedBy="firm")
     */
    protected $firmCategories;

    /**
     * @ORM\OneToMany(targetEntity="Picture", mappedBy="firm")
     */
    protected $pictures;

    /**
     * @ORM\OneToMany(targetEntity="Order", mappedBy="firm")
     */
    protected $orders;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="firm")
     */
    protected $comments;

    /**
     * @ORM\OneToMany(targetEntity="Mark", mappedBy="firm")
     */
    protected $marks;

    public function __construct()
    {
        $this->firmCategories = new ArrayCollection();
        $this->pictures = new ArrayCollection();
        $this->orders = new ArrayCollection();
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
     * @return Firm
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
     * Set visible
     *
     * @param boolean $visible
     *
     * @return Firm
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get visible
     *
     * @return boolean
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * Set order
     *
     * @param boolean $order
     *
     * @return Firm
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return boolean
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Firm
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
     * Set email
     *
     * @param string $email
     *
     * @return Firm
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Firm
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Firm
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set street
     *
     * @param string $street
     *
     * @return Firm
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set postcode
     *
     * @param string $postcode
     *
     * @return Firm
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * Get postcode
     *
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Firm
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
     * Set markPrecision
     *
     * @param string $markPrecision
     *
     * @return Firm
     */
    public function setMarkPrecision($markPrecision)
    {
        $this->markPrecision = $markPrecision;

        return $this;
    }

    /**
     * Get markPrecision
     *
     * @return string
     */
    public function getMarkPrecision()
    {
        return $this->markPrecision;
    }

    /**
     * Set markContact
     *
     * @param string $markContact
     *
     * @return Firm
     */
    public function setMarkContact($markContact)
    {
        $this->markContact = $markContact;

        return $this;
    }

    /**
     * Get markContact
     *
     * @return string
     */
    public function getMarkContact()
    {
        return $this->markContact;
    }

    /**
     * Set markTime
     *
     * @param string $markTime
     *
     * @return Firm
     */
    public function setMarkTime($markTime)
    {
        $this->markTime = $markTime;

        return $this;
    }

    /**
     * Get markTime
     *
     * @return string
     */
    public function getMarkTime()
    {
        return $this->markTime;
    }

    /**
     * Set markPrice
     *
     * @param string $markPrice
     *
     * @return Firm
     */
    public function setMarkPrice($markPrice)
    {
        $this->markPrice = $markPrice;

        return $this;
    }

    /**
     * Get markPrice
     *
     * @return string
     */
    public function getMarkPrice()
    {
        return $this->markPrice;
    }

    /**
     * Set commentNumber
     *
     * @param integer $commentNumber
     *
     * @return Firm
     */
    public function setCommentNumber($commentNumber)
    {
        $this->commentNumber = $commentNumber;

        return $this;
    }

    /**
     * Get commentNumber
     *
     * @return integer
     */
    public function getCommentNumber()
    {
        return $this->commentNumber;
    }

    /**
     * Set commentPositive7Days
     *
     * @param integer $commentPositive7Days
     *
     * @return Firm
     */
    public function setCommentPositive7Days($commentPositive7Days)
    {
        $this->commentPositive7Days = $commentPositive7Days;

        return $this;
    }

    /**
     * Get commentPositive7Days
     *
     * @return integer
     */
    public function getCommentPositive7Days()
    {
        return $this->commentPositive7Days;
    }

    /**
     * Set commentNeutral7Days
     *
     * @param integer $commentNeutral7Days
     *
     * @return Firm
     */
    public function setCommentNeutral7Days($commentNeutral7Days)
    {
        $this->commentNeutral7Days = $commentNeutral7Days;

        return $this;
    }

    /**
     * Get commentNeutral7Days
     *
     * @return integer
     */
    public function getCommentNeutral7Days()
    {
        return $this->commentNeutral7Days;
    }

    /**
     * Set commentNegative7Days
     *
     * @param integer $commentNegative7Days
     *
     * @return Firm
     */
    public function setCommentNegative7Days($commentNegative7Days)
    {
        $this->commentNegative7Days = $commentNegative7Days;

        return $this;
    }

    /**
     * Get commentNegative7Days
     *
     * @return integer
     */
    public function getCommentNegative7Days()
    {
        return $this->commentNegative7Days;
    }

    /**
     * Set commentPositive30Days
     *
     * @param integer $commentPositive30Days
     *
     * @return Firm
     */
    public function setCommentPositive30Days($commentPositive30Days)
    {
        $this->commentPositive30Days = $commentPositive30Days;

        return $this;
    }

    /**
     * Get commentPositive30Days
     *
     * @return integer
     */
    public function getCommentPositive30Days()
    {
        return $this->commentPositive30Days;
    }

    /**
     * Set commentNeutral30Days
     *
     * @param integer $commentNeutral30Days
     *
     * @return Firm
     */
    public function setCommentNeutral30Days($commentNeutral30Days)
    {
        $this->commentNeutral30Days = $commentNeutral30Days;

        return $this;
    }

    /**
     * Get commentNeutral30Days
     *
     * @return integer
     */
    public function getCommentNeutral30Days()
    {
        return $this->commentNeutral30Days;
    }

    /**
     * Set commentNegative30Days
     *
     * @param integer $commentNegative30Days
     *
     * @return Firm
     */
    public function setCommentNegative30Days($commentNegative30Days)
    {
        $this->commentNegative30Days = $commentNegative30Days;

        return $this;
    }

    /**
     * Get commentNegative30Days
     *
     * @return integer
     */
    public function getCommentNegative30Days()
    {
        return $this->commentNegative30Days;
    }

    /**
     * Set commentPositiveAllDays
     *
     * @param integer $commentPositiveAllDays
     *
     * @return Firm
     */
    public function setCommentPositiveAllDays($commentPositiveAllDays)
    {
        $this->commentPositiveAllDays = $commentPositiveAllDays;

        return $this;
    }

    /**
     * Get commentPositiveAllDays
     *
     * @return integer
     */
    public function getCommentPositiveAllDays()
    {
        return $this->commentPositiveAllDays;
    }

    /**
     * Set commentNeutralAllDays
     *
     * @param integer $commentNeutralAllDays
     *
     * @return Firm
     */
    public function setCommentNeutralAllDays($commentNeutralAllDays)
    {
        $this->commentNeutralAllDays = $commentNeutralAllDays;

        return $this;
    }

    /**
     * Get commentNeutralAllDays
     *
     * @return integer
     */
    public function getCommentNeutralAllDays()
    {
        return $this->commentNeutralAllDays;
    }

    /**
     * Set commentNegativeAllDays
     *
     * @param integer $commentNegativeAllDays
     *
     * @return Firm
     */
    public function setCommentNegativeAllDays($commentNegativeAllDays)
    {
        $this->commentNegativeAllDays = $commentNegativeAllDays;

        return $this;
    }

    /**
     * Get commentNegativeAllDays
     *
     * @return integer
     */
    public function getCommentNegativeAllDays()
    {
        return $this->commentNegativeAllDays;
    }

    /**
     * Set commentDate
     *
     * @param \DateTime $commentDate
     *
     * @return Firm
     */
    public function setCommentDate($commentDate)
    {
        $this->commentDate = $commentDate;

        return $this;
    }

    /**
     * Get commentDate
     *
     * @return \DateTime
     */
    public function getCommentDate()
    {
        return $this->commentDate;
    }

    /**
     * Set ipAdded
     *
     * @param string $ipAdded
     *
     * @return Firm
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
     * @return Firm
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
     * @return Firm
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
     * @return Firm
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
     * @return Firm
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
     * Set province
     *
     * @param \AppBundle\Entity\Province $province
     *
     * @return Firm
     */
    public function setProvince(\AppBundle\Entity\Province $province = null)
    {
        $this->province = $province;

        return $this;
    }

    /**
     * Get province
     *
     * @return \AppBundle\Entity\Province
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * Set city
     *
     * @param \AppBundle\Entity\City $city
     *
     * @return Firm
     */
    public function setCity(\AppBundle\Entity\City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \AppBundle\Entity\City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Add firmCategory
     *
     * @param \AppBundle\Entity\FirmCategory $firmCategory
     *
     * @return Firm
     */
    public function addFirmCategory(\AppBundle\Entity\FirmCategory $firmCategory)
    {
        $this->firmCategories[] = $firmCategory;

        return $this;
    }

    /**
     * Remove firmCategory
     *
     * @param \AppBundle\Entity\FirmCategory $firmCategory
     */
    public function removeFirmCategory(\AppBundle\Entity\FirmCategory $firmCategory)
    {
        $this->firmCategories->removeElement($firmCategory);
    }

    /**
     * Get firmCategories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFirmCategories()
    {
        return $this->firmCategories;
    }

    /**
     * Add picture
     *
     * @param \AppBundle\Entity\Picture $picture
     *
     * @return Firm
     */
    public function addPicture(\AppBundle\Entity\Picture $picture)
    {
        $this->pictures[] = $picture;

        return $this;
    }

    /**
     * Remove picture
     *
     * @param \AppBundle\Entity\Picture $picture
     */
    public function removePicture(\AppBundle\Entity\Picture $picture)
    {
        $this->pictures->removeElement($picture);
    }

    /**
     * Get pictures
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPictures()
    {
        return $this->pictures;
    }

    /**
     * Add order
     *
     * @param \AppBundle\Entity\Order $order
     *
     * @return Firm
     */
    public function addOrder(\AppBundle\Entity\Order $order)
    {
        $this->orders[] = $order;

        return $this;
    }

    /**
     * Remove order
     *
     * @param \AppBundle\Entity\Order $order
     */
    public function removeOrder(\AppBundle\Entity\Order $order)
    {
        $this->orders->removeElement($order);
    }

    /**
     * Get orders
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * Add comment
     *
     * @param \AppBundle\Entity\Comment $comment
     *
     * @return Firm
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
     * @return Firm
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
