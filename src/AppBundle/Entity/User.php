<?php

namespace AppBundle\Entity;

use AppBundle\Enums\UserRoles;
use AppBundle\Traits\Timestampable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table(name="users", uniqueConstraints={@ORM\UniqueConstraint(name="email_UNIQUE", columns={"email"}), @ORM\UniqueConstraint(name="confirmation_token_UNIQUE", columns={"email_confirmation_token"}), @ORM\UniqueConstraint(name="phone_confirmation_token_UNIQUE", columns={"phone_confirmation_token"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface
{
    use Timestampable;

    /**
     * Unmapped property to handle file uploads
     */
    private $avatar;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     */
    private $plainPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=180, nullable=false)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="second_name", type="string", length=180, nullable=false)
     */
    private $secondName;

    /**
     * @var string
     *
     * @ORM\Column(name="middle_name", type="string", length=180, nullable=false)
     */
    private $middleName;

    /**
     * Это конкатенация имени, фамилии и отчества.
     * Это поле нужно для фильтрации в админке сразу по трем столбцам.
     * Не придумал ничего лучше, чем сделать это поле.
     *
     * @var string
     *
     * @ORM\Column(name="full_name", type="string", length=250, nullable=false)
     */
    private $fullName;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=180, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=20, nullable=false)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="other_contacts", type="text", length=65535, nullable=true)
     */
    private $otherContacts;

    /**
     * @var string
     *
     * @ORM\Column(name="email_confirmation_token", type="string", length=180, nullable=true)
     */
    private $emailConfirmationToken;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_confirmation_token", type="string", length=5, nullable=true)
     */
    private $phoneConfirmationToken;

    /**
     * @var string
     *
     * @ORM\Column(name="roles", type="json_array", nullable=false)
     */
    private $roles = [UserRoles::ROLE_CLIENT];

    /**
     * @var string
     *
     * @ORM\Column(name="avatar_url", type="string", length=512, nullable=true)
     */
    private $avatarUrl;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=false)
     */
    private $isActive = 1;

    /**
     * @ORM\OneToMany(targetEntity="ScheduleEvent", mappedBy="user")
     */
    private $events;

    public function __toString()
    {
        return (string) $this->getId();
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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set secondName
     *
     * @param string $secondName
     *
     * @return User
     */
    public function setSecondName($secondName)
    {
        $this->secondName = $secondName;

        return $this;
    }

    /**
     * Get secondName
     *
     * @return string
     */
    public function getSecondName()
    {
        return $this->secondName;
    }

    /**
     * Set middleName
     *
     * @param string $middleName
     *
     * @return User
     */
    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;

        return $this;
    }

    /**
     * Get middleName
     *
     * @return string
     */
    public function getMiddleName()
    {
        return $this->middleName;
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
     * Set otherContacts
     *
     * @param string $otherContacts
     *
     * @return User
     */
    public function setOtherContacts($otherContacts)
    {
        $this->otherContacts = $otherContacts;

        return $this;
    }

    /**
     * Get otherContacts
     *
     * @return string
     */
    public function getOtherContacts()
    {
        return $this->otherContacts;
    }

    /**
     * Set emailConfirmationToken
     *
     * @param string $emailConfirmationToken
     *
     * @return User
     */
    public function setEmailConfirmationToken($emailConfirmationToken)
    {
        $this->emailConfirmationToken = $emailConfirmationToken;

        return $this;
    }

    /**
     * Get emailConfirmationToken
     *
     * @return string
     */
    public function getEmailConfirmationToken()
    {
        return $this->emailConfirmationToken;
    }

    /**
     * Set phoneConfirmationToken
     *
     * @param string $phoneConfirmationToken
     *
     * @return User
     */
    public function setPhoneConfirmationToken($phoneConfirmationToken)
    {
        $this->phoneConfirmationToken = $phoneConfirmationToken;

        return $this;
    }

    /**
     * Get phoneConfirmationToken
     *
     * @return string
     */
    public function getPhoneConfirmationToken()
    {
        return $this->phoneConfirmationToken;
    }

    /**
     * Set role
     *
     * @param array $roles
     *
     * @return User
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get role
     *
     * @return array
     */
    public function getRoles()
    {
        $roles = $this->roles;

        return $roles;
    }

    public function getRolesString()
    {
        $roles = $this->getRoles();
        $list = array_flip(UserRoles::getValues());

        foreach ($roles as $key => $role) {
            $roles[$key] = $list[$role];
        }

        return trim(implode(', ', $roles), ', ');
    }

    public function hasRole($role)
    {
        return array_search($role, $this->roles) !== false ? true : false;
    }

    /**
     * Set avatarUrl
     *
     * @param string $avatarUrl
     *
     * @return User
     */
    public function setAvatarUrl($avatarUrl)
    {
        $this->avatarUrl = $avatarUrl;

        return $this;
    }

    /**
     * Get avatarUrl
     *
     * @return string
     */
    public function getAvatarUrl()
    {
        return $this->avatarUrl;
    }

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param mixed $plainPassword
     * @return $this
     */
    public function setPlainPassword($plainPassword = null)
    {
        if (!$plainPassword) {
            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            $plainPassword = substr(str_shuffle($chars), 0, 10);
        }

        $this->plainPassword = $plainPassword;

        // forces the object to look "dirty" to Doctrine. Avoids
        // Doctrine *not* saving this entity, if only plainPassword changes
        $this->password = null;

        return $this;
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setAvatar(UploadedFile $file = null)
    {
        $this->avatar = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setFullName()
    {
        $this->fullName = sprintf("%s %s %s", $this->getSecondName(), $this->getFirstName(), $this->getMiddleName());
    }

    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setCreatedAtValue()
    {
        $this->setFullName();
    }

    /**
     * @return boolean
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @param boolean $isActive
     */
    public function setIsActive(bool $isActive)
    {
        $this->isActive = $isActive;
    }

    /**
     * @return mixed
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param mixed $events
     */
    public function setEvents($events)
    {
        $this->events = $events;
    }
}
