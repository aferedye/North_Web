<?php
/**
 * Created by PhpStorm.
 * User: Admin stagiaire
 * Date: 02/08/2019
 * Time: 13:47
 */

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Utilisateur
{

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=50)
     */
    private $name;


    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=50)
     */
    private $lastname;


    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;


    /**
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/[0-9][10]/")
     */
    private $phone;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=10, max=200)
     */
    private $message;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }


}