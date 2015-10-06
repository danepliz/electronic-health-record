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
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $middleName;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

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
     * @ORM\OneToMany(targetEntity="FamilyHealth\MemberBundle\Entity\FamilyMember", mappedBy="member")
     */
    private $relations;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $permanentAddressHouseNumber;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $permanentAddressTole;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $permanentAddressWard;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $permanentAddressVDC;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $permanentAddressDistrict;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $permanentAddressPhone;


    /**
     * @var string
     *
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $temporaryAddressHouseNumber;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $temporaryAddressTole;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $temporaryAddressWard;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $temporaryAddressVDC;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $temporaryAddressDistrict;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $temporaryAddressPhone;

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
    private $isPremiumMember = TRUE;

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


    public function __construct()
    {
        $this->relations = new ArrayCollection();
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;

        return $this;
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

    /**
     * @param int $age
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param string $bloodGroup
     */
    public function setBloodGroup($bloodGroup)
    {
        $this->bloodGroup = $bloodGroup;

        return $this;
    }

    /**
     * @return string
     */
    public function getBloodGroup()
    {
        return $this->bloodGroup;
    }

    /**
     * @param \Date $dob
     */
    public function setDob($dob)
    {
        $this->dob = $dob;

        return $this;
    }

    /**
     * @return \Date
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $hasSurgery
     */
    public function setHasSurgery($hasSurgery)
    {
        $this->hasSurgery = $hasSurgery;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHasSurgery()
    {
        return $this->hasSurgery;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $isPremiumMember
     */
    public function setIsPremiumMember($isPremiumMember)
    {
        $this->isPremiumMember = $isPremiumMember;
    }

    /**
     * @return mixed
     */
    public function getIsPremiumMember()
    {
        return $this->isPremiumMember;
    }

    /**
     * @param \Date $joinedDate
     */
    public function setJoinedDate($joinedDate)
    {
        $this->joinedDate = $joinedDate;

        return $this;
    }

    /**
     * @return \Date
     */
    public function getJoinedDate()
    {
        return $this->joinedDate;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $memberId
     */
    public function setMemberId($memberId)
    {
        $this->memberId = $memberId;

        return $this;
    }

    /**
     * @return string
     */
    public function getMemberId()
    {
        return $this->memberId;
    }

    /**
     * @param mixed $members
     */
    public function setRelations($members)
    {
        $this->relations = $members;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRelations()
    {
        return $this->relations;
    }

    /**
     * @param string $middleName
     */
    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;

        return $this;
    }

    /**
     * @return string
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * @param string $mobile
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $permanentAddressDistrict
     */
    public function setPermanentAddressDistrict($permanentAddressDistrict)
    {
        $this->permanentAddressDistrict = $permanentAddressDistrict;
    }

    /**
     * @return string
     */
    public function getPermanentAddressDistrict()
    {
        return $this->permanentAddressDistrict;
    }

    /**
     * @param string $permanentAddressHouseNumber
     */
    public function setPermanentAddressHouseNumber($permanentAddressHouseNumber)
    {
        $this->permanentAddressHouseNumber = $permanentAddressHouseNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getPermanentAddressHouseNumber()
    {
        return $this->permanentAddressHouseNumber;
    }

    /**
     * @param string $permanentAddressTole
     */
    public function setPermanentAddressTole($permanentAddressTole)
    {
        $this->permanentAddressTole = $permanentAddressTole;

        return $this;
    }

    /**
     * @return string
     */
    public function getPermanentAddressTole()
    {
        return $this->permanentAddressTole;
    }

    /**
     * @param string $permanentAddressVDC
     */
    public function setPermanentAddressVDC($permanentAddressVDC)
    {
        $this->permanentAddressVDC = $permanentAddressVDC;

        return $this;
    }

    /**
     * @return string
     */
    public function getPermanentAddressVDC()
    {
        return $this->permanentAddressVDC;
    }

    /**
     * @param string $permanentAddressWard
     */
    public function setPermanentAddressWard($permanentAddressWard)
    {
        $this->permanentAddressWard = $permanentAddressWard;

        return $this;
    }

    /**
     * @return string
     */
    public function getPermanentAddressWard()
    {
        return $this->permanentAddressWard;
    }

    /**
     * @param mixed $premiumExpiryDate
     */
    public function setPremiumExpiryDate($premiumExpiryDate)
    {
        $this->premiumExpiryDate = $premiumExpiryDate;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPremiumExpiryDate()
    {
        return $this->premiumExpiryDate;
    }

    /**
     * @param string $temporaryAddressDistrict
     */
    public function setTemporaryAddressDistrict($temporaryAddressDistrict)
    {
        $this->temporaryAddressDistrict = $temporaryAddressDistrict;

        return $this;
    }

    /**
     * @return string
     */
    public function getTemporaryAddressDistrict()
    {
        return $this->temporaryAddressDistrict;
    }

    /**
     * @param string $temporaryAddressHouseNumber
     */
    public function setTemporaryAddressHouseNumber($temporaryAddressHouseNumber)
    {
        $this->temporaryAddressHouseNumber = $temporaryAddressHouseNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getTemporaryAddressHouseNumber()
    {
        return $this->temporaryAddressHouseNumber;
    }

    /**
     * @param string $temporaryAddressPhone
     */
    public function setTemporaryAddressPhone($temporaryAddressPhone)
    {
        $this->temporaryAddressPhone = $temporaryAddressPhone;

        return $this;
    }

    /**
     * @return string
     */
    public function getTemporaryAddressPhone()
    {
        return $this->temporaryAddressPhone;
    }

    /**
     * @param string $permanentAddressPhone
     */
    public function setPermanentAddressPhone($permanentAddressPhone)
    {
        $this->permanentAddressPhone = $permanentAddressPhone;

        return $this;
    }

    /**
     * @return string
     */
    public function getPermanentAddressPhone()
    {
        return $this->permanentAddressPhone;
    }

    /**
     * @param string $temporaryAddressTole
     */
    public function setTemporaryAddressTole($temporaryAddressTole)
    {
        $this->temporaryAddressTole = $temporaryAddressTole;

        return $this;
    }

    /**
     * @return string
     */
    public function getTemporaryAddressTole()
    {
        return $this->temporaryAddressTole;
    }

    /**
     * @param string $temporaryAddressVDC
     */
    public function setTemporaryAddressVDC($temporaryAddressVDC)
    {
        $this->temporaryAddressVDC = $temporaryAddressVDC;

        return $this;
    }

    /**
     * @return string
     */
    public function getTemporaryAddressVDC()
    {
        return $this->temporaryAddressVDC;
    }

    /**
     * @param string $temporaryAddressWard
     */
    public function setTemporaryAddressWard($temporaryAddressWard)
    {
        $this->temporaryAddressWard = $temporaryAddressWard;

        return $this;
    }

    /**
     * @return string
     */
    public function getTemporaryAddressWard()
    {
        return $this->temporaryAddressWard;
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

    public function isPremiumMember()
    {
        return $this->isPremiumMember;
    }

    public function hasSurgery()
    {
        return $this->hasSurgery;
    }


    public function getName()
    {
        $name = $this->firstName.' '.$this->middleName.' '.$this->lastName;

        return str_replace('  ', ' ', $name);
    }


}

