<?php
// src/AppBundle/Entity/LoginForm.php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class LoginForm
{
    /**
     * @Assert\Length(max = 20, maxMessage = "Login może zawierać maksymalnie {{ limit }} znaków.")
     */
    protected $login;

    /**
     * @Assert\Length(max = 30, maxMessage = "Hasło może zawierać maksymalnie {{ limit }} znaków.")
     */
    protected $password;

    protected $forget;
    protected $remember;

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

    public function setForget($forget)
    {
        $this->forget = $forget;
    }

    public function getForget()
    {
        return $this->forget;
    }

    public function setRemember($remember)
    {
        $this->remember = $remember;
    }

    public function getRemember()
    {
        return $this->remember;
    }
}
