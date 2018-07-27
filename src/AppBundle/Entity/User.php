<?php
// src/AppBundle/Entity/User.php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     name="`user`",
 *     indexes={@ORM\Index(name="active", columns={"active"}), @ORM\Index(name="password", columns={"password"})}
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User
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
     * @ORM\Column(type="string", length=20, options={"default":""})
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=30, options={"default":""})
     */
    protected $surname;

    /**
     * @ORM\Column(type="string", length=20, unique=true, options={"default":""})
     */
    protected $login;

    /**
     * @ORM\Column(name="`password`", type="string", length=41, options={"default":""})
     */
    protected $password;

    /**
     * @ORM\Column(name="`key`", type="string", length=32, options={"default":""})
     */
    protected $key;

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
     * @ORM\Column(type="string", length=15, options={"default":""})
     */
    protected $ipLoged;

    /**
     * @ORM\Column(type="datetime", options={"default":"0000-00-00 00:00:00"})
     */
    protected $dateLoged;

    /**
     * @ORM\ManyToOne(targetEntity="Province", inversedBy="users")
     * @ORM\JoinColumn(name="province_id", referencedColumnName="id")
     */
    protected $province;

    /**
     * @ORM\ManyToOne(targetEntity="City", inversedBy="users")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     */
    protected $city;

    /**
     * @ORM\OneToMany(targetEntity="Firm", mappedBy="user")
     */
    protected $firms;

    /**
     * @ORM\OneToMany(targetEntity="Order", mappedBy="user")
     */
    protected $orders;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="user")
     */
    protected $comments;

    /**
     * @ORM\OneToMany(targetEntity="Mark", mappedBy="user")
     */
    protected $marks;

    public function __construct()
    {
        $this->firms = new ArrayCollection();
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
     * @return User
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
     * Set name
     *
     * @param string $name
     *
     * @return User
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
     * Set surname
     *
     * @param string $surname
     *
     * @return User
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set login
     *
     * @param string $login
     *
     * @return User
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set key
     *
     * @param string $key
     *
     * @return User
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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
     * Set commentNumber
     *
     * @param integer $commentNumber
     *
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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
     * Set ipLoged
     *
     * @param string $ipLoged
     *
     * @return User
     */
    public function setIpLoged($ipLoged)
    {
        $this->ipLoged = $ipLoged;

        return $this;
    }

    /**
     * Get ipLoged
     *
     * @return string
     */
    public function getIpLoged()
    {
        return $this->ipLoged;
    }

    /**
     * Set dateLoged
     *
     * @param \DateTime $dateLoged
     *
     * @return User
     */
    public function setDateLoged($dateLoged)
    {
        $this->dateLoged = $dateLoged;

        return $this;
    }

    /**
     * Get dateLoged
     *
     * @return \DateTime
     */
    public function getDateLoged()
    {
        return $this->dateLoged;
    }

    /**
     * Set province
     *
     * @param \AppBundle\Entity\Province $province
     *
     * @return User
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
     * @return User
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
     * Add firm
     *
     * @param \AppBundle\Entity\Firm $firm
     *
     * @return User
     */
    public function addFirm(\AppBundle\Entity\Firm $firm)
    {
        $this->firms[] = $firm;

        return $this;
    }

    /**
     * Remove firm
     *
     * @param \AppBundle\Entity\Firm $firm
     */
    public function removeFirm(\AppBundle\Entity\Firm $firm)
    {
        $this->firms->removeElement($firm);
    }

    /**
     * Get firms
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFirms()
    {
        return $this->firms;
    }

    /**
     * Add order
     *
     * @param \AppBundle\Entity\Order $order
     *
     * @return User
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
     * @return User
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
     * @return User
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
