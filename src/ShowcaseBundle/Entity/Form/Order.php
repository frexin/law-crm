<?php

namespace ShowcaseBundle\Entity\Form;

use AppBundle\Entity\ServiceModification;
use Symfony\Component\Validator\Constraints as Assert;

// todo добавить загрузку файлов

class Order
{
    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min = 2,
     *     max = 180,
     * )
     */
    private $secondName;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min = 2,
     *     max = 180,
     * )
     */
    private $firstName;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min = 2,
     *     max = 180,
     * )
     */
    private $middleName;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min = 10,
     *     max = 20,
     * )
     */
    private $phone;

    /**
     * @var string
     */
    private $otherContacts;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *     max = 155,
     * )
     */
    private $question;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @var ServiceModification
     *
     * @Assert\NotBlank()
     */
    private $serviceModification;

    /**
     * @Assert\Type("array")
     */
    private $uploadedFiles;

    /**
     * @var bool
     * @Assert\Type("bool")
     * @Assert\IsTrue(message="Вы должны согласиться с условиями.")
     */
    private $isAgree;

    /**
     * @return string
     */
    public function getSecondName()
    {
        return $this->secondName;
    }

    /**
     * @param string $secondName
     */
    public function setSecondName(string $secondName)
    {
        $this->secondName = $secondName;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * @param string $middleName
     */
    public function setMiddleName(string $middleName)
    {
        $this->middleName = $middleName;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getOtherContacts()
    {
        return $this->otherContacts;
    }

    /**
     * @param string $otherContacts
     */
    public function setOtherContacts(string $otherContacts)
    {
        $this->otherContacts = $otherContacts;
    }

    /**
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param string $question
     */
    public function setQuestion(string $question)
    {
        $this->question = $question;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getServiceModification()
    {
        return $this->serviceModification;
    }

    /**
     * @param ServiceModification $serviceModification
     */
    public function setServiceModification(ServiceModification $serviceModification)
    {
        $this->serviceModification = $serviceModification;
    }

    /**
     * @return boolean
     */
    public function isIsAgree()
    {
        return $this->isAgree;
    }

    /**
     * @param boolean $isAgree
     */
    public function setIsAgree(bool $isAgree)
    {
        $this->isAgree = $isAgree;
    }

    /**
     * @return mixed
     */
    public function getUploadedFiles()
    {
        return $this->uploadedFiles;
    }

    /**
     * @param mixed $uploadedFiles
     */
    public function setUploadedFiles($uploadedFiles)
    {
        $this->uploadedFiles = $uploadedFiles;
    }
}