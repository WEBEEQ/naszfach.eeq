<?php
// src/AppBundle/Entity/ContactForm.php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class ContactForm
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max = 100, maxMessage = "E-mail może zawierać maksymalnie {{ limit }} znaków.")
     * @Assert\Email(message = "E-mail musi mieć format zapisu: nazwisko@domena.pl")
     */
    protected $email;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max = 100, maxMessage = "Temat może zawierać maksymalnie {{ limit }} znaków.")
     */
    protected $subject;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max = 10000, maxMessage = "Wiadomość może zawierać maksymalnie {{ limit }} znaków.")
     */
    protected $message;

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }
}
