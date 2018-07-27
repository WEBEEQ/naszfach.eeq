<?php
// src/AppBundle/Entity/RegisterForm.php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class RegisterForm
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max = 20, maxMessage = "Imię może zawierać maksymalnie {{ limit }} znaków.")
     */
    protected $name;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max = 30, maxMessage = "Nazwisko może zawierać maksymalnie {{ limit }} znaków.")
     */
    protected $surname;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min = 3,
     *     max = 20,
     *     minMessage = "Login musi zawierać minimalnie {{ limit }} znaki.",
     *     maxMessage = "Login może zawierać maksymalnie {{ limit }} znaków."
     * )
     */
    protected $login;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min = 8,
     *     max = 30,
     *     minMessage = "Hasło musi zawierać minimalnie {{ limit }} znaków.",
     *     maxMessage = "Hasło może zawierać maksymalnie {{ limit }} znaków."
     * )
     */
    protected $password;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min = 8,
     *     max = 30,
     *     minMessage = "Powtórzone hasło musi zawierać minimalnie {{ limit }} znaków.",
     *     maxMessage = "Powtórzone hasło może zawierać maksymalnie {{ limit }} znaków."
     * )
     */
    protected $repeatPassword;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max = 100, maxMessage = "E-mail może zawierać maksymalnie {{ limit }} znaków.")
     * @Assert\Email(message = "E-mail musi mieć format zapisu: nazwisko@domena.pl")
     */
    protected $email;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max = 100, maxMessage = "Powtórzony e-mail może zawierać maksymalnie {{ limit }} znaków.")
     * @Assert\Email(message = "Powtórzony e-mail musi mieć format zapisu: nazwisko@domena.pl")
     */
    protected $repeatEmail;

    /**
     * @Assert\IsTrue(message = "Musisz zaakceptować regulamin serwisu.")
     */
    protected $accept;

    /**
     * @Assert\IsTrue(message = "Login może składać się tylko z liter i cyfr.")
     */
    public function isLoginValid()
    {
        return preg_match('/^([0-9A-Za-z]*)$/', $this->login);
    }

    /**
     * @Assert\IsTrue(message = "Hasło może składać się tylko z liter i cyfr.")
     */
    public function isPasswordValid()
    {
        return preg_match('/^([0-9A-Za-z]*)$/', $this->password);
    }

    /**
     * @Assert\IsTrue(message = "Hasło i powtórzone hasło nie są zgodne.")
     */
    public function isPasswordEqual()
    {
        return $this->password === $this->repeatPassword;
    }

    /**
     * @Assert\IsTrue(message = "E-mail i powtórzony e-mail nie są zgodne.")
     */
    public function isEmailEqual()
    {
        return $this->email === $this->repeatEmail;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setRepeatPassword($repeatPassword)
    {
        $this->repeatPassword = $repeatPassword;
    }

    public function getRepeatPassword()
    {
        return $this->repeatPassword;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setRepeatEmail($repeatEmail)
    {
        $this->repeatEmail = $repeatEmail;
    }

    public function getRepeatEmail()
    {
        return $this->repeatEmail;
    }

    public function setAccept($accept)
    {
        $this->accept = $accept;
    }

    public function getAccept()
    {
        return $this->accept;
    }
}
