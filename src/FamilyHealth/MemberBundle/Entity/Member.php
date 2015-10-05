<?php

namespace FamilyHealth\MemberBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Member
 *
 * @ORM\Table(name="fhn_members")
 * @ORM\Entity(repositoryClass="FamilyHealth\MemberBundle\Entity\MemberRepository")
 */
class Member
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
     * @Assert\NotBlank()
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="age", type="integer", nullable=true)
     */
    private $age;

    /**
     * @var \Date
     *
     * @Assert\Date()
     * @ORM\Column(name="birth_date", type="date", nullable=true)
     */
    private $dob;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=10, nullable=true)
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=50, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile", type="string", length=50, nullable=true)
     */
    private $mobile;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="member_id", type="string", length=100, nullable=true)
     */
    private $memberId;

    /**
     * @var string
     *
     * @ORM\Column(name="blood_group", type="string", length=10, nullable=true)
     */
    private $bloodGroup;

    /**
     * @ORM\OneToMany(targetEntity="FamilyHealth\MemberBundle\Entity\Member", mappedBy="parent")
     */
    private $relations;

    /**
     * @ORM\ManyToOne(targetEntity="FamilyHealth\MemberBundle\Entity\Member", inversedBy="relations")
     */
    private $parent;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="text", nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="relation", type="string", length=50, nullable=true)
     */
    private $relation;

    /**
     * @var \Date
     *
     * @Assert\Date()
     * @ORM\Column(name="joined_date", type="date", nullable=true)
     */
    private $joinedDate;


    /**
     * @ORM\Column(name="is_premium", type="boolean")
     */
    private $isPremiumMember = FALSE;

    /**
     * @ORM\Column(name="premium_expiry_date", type="datetime", nullable=true)
     */
    private $premiumExpiryDate;

    /**
     * @ORM\Column(name="has_surgery", type="boolean")
     */
    private $hasSurgery = FALSE;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;

    /**
     * @Assert\File(
     *      maxSize="2M",
     *      mimeTypes = {"image/jpg", "image/jpeg", "image/gif", "image/png"},
     *      mimeTypesMessage = "Please upload a valid PDF"
     * )
     */
    private $file;

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/members';
    }

    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and then the
        // target filename to move to
        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->getFile()->getClientOriginalName()
        );

        // set the path property to the filename where you've saved the file
        $this->path = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }


    public function __construct(){
        $this->relations = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Member
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
     * Set age
     *
     * @param integer $age
     *
     * @return Member
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set dob
     *
     * @param \DateTime $dob
     *
     * @return Member
     */
    public function setDob($dob)
    {
        $this->dob = $dob;

        return $this;
    }

    /**
     * Get dob
     *
     * @return \DateTime
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * Set sex
     *
     * @param string $gender
     *
     * @return Member
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set phone
     *
     * @param integer $phone
     *
     * @return Member
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return integer
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set mobile
     *
     * @param integer $mobile
     *
     * @return Member
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile
     *
     * @return integer
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set email
     *
     * @param integer $email
     *
     * @return Member
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return integer
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Member
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set joinedDate
     *
     * @param \DateTime $joinedDate
     *
     * @return Member
     */
    public function setJoinedDate($joinedDate)
    {
        $this->joinedDate = $joinedDate;

        return $this;
    }

    /**
     * Get joinedDate
     *
     * @return \DateTime
     */
    public function getJoinedDate()
    {
        return $this->joinedDate;
    }

    /**
     * Set bloodGroup
     *
     * @param bloodGroup
     *
     * @return Member
     */
    public function setBloodGroup($bloodGroup)
    {
        $this->bloodGroup = $bloodGroup;

        return $this;
    }

    /**
     * Get bloodGroup
     *
     * @return string
     */
    public function getBloodGroup()
    {
        return $this->bloodGroup;
    }


    /**
     * Set joinedDate
     *
     * @param \DateTime $joinedDate
     *
     * @return Member
     */
    public function setMemberId($memberId)
    {
        $this->memberId = $memberId;

        return $this;
    }

    /**
     * Get memberId
     *
     * @return string
     */
    public function getMemberId()
    {
        return $this->memberId;
    }


    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setRelation($relation)
    {
        $this->relation = $relation;

        return $this;
    }

    public function getRelation()
    {
        return $this->relation;
    }


    public function addRelation($relation)
    {
        $this->relations->add($relation);

        return $this;
    }

    public function removeRelation($relation)
    {
        $this->relations->removeElement($relation);

        return $this;
    }

    public function resetRelations()
    {
        $this->relations = new ArrayCollection();

        return $this;
    }

    public function getRelations()
    {
        return $this->relations;
    }

    public function isPremiumMember()
    {
        return $this->isPremiumMember;
    }

    public function markAsPremiumMember()
    {
        $this->isPremiumMember = TRUE;

        return $this;
    }

    public function setIsPremiumMember($bool)
    {
        $this->isPremiumMember = $bool;

        return $this;
    }

    public function unmarkAsPremiumMember()
    {
        $this->isPremiumMember = FALSE;

        return $this;
    }

    public function getPremiumExpiryDate()
    {
        return $this->premiumExpiryDate;
    }

    public function setPremiumExpiryDate($date)
    {
        $this->premiumExpiryDate = $date;

        return $this;
    }

    public function hasSurgery()
    {
        return $this->hasSurgery;
    }

    public function setHasSurgery($hasSurgery)
    {
        $this->hasSurgery = $hasSurgery;

        return $this;
    }

    public function getHasSurgery()
    {
        return $this->hasSurgery;
    }



}

