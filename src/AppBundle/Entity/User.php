<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\Timestampable;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="users", uniqueConstraints={@ORM\UniqueConstraint(name="email_UNIQUE", columns={"email"}), @ORM\UniqueConstraint(name="confirmation_token_UNIQUE", columns={"email_confirmation_token"}), @ORM\UniqueConstraint(name="phone_confirmation_token_UNIQUE", columns={"phone_confirmation_token"})})
 * @ORM\Entity
 */
class User
{
    use Timestampable;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

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
     * @ORM\Column(name="role", type="string", length=180, nullable=false)
     */
    private $role;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar_url", type="string", length=512, nullable=true)
     */
    private $avatarUrl;

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
     * @param string $role
     *
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
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
}