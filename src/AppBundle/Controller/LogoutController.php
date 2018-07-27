<?php
// src/AppBundle/Controller/LogoutController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

class LogoutController extends Controller
{
    /**
     * @Route("/wylogowanie")
     */
    public function logoutAction()
    {
        $session = new Session();
        $session->invalidate();
        setcookie('login', '', 0, '/');

        return $this->redirectToRoute('loginpage');
    }
}
