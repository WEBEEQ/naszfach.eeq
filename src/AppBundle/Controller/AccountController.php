<?php
// src/AppBundle/Controller/AccountController.php
namespace AppBundle\Controller;

use AppBundle\Bundle\Config;
use AppBundle\Bundle\CookieLogin;
use AppBundle\Bundle\Menu;
use AppBundle\Bundle\QuickForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AccountController extends Controller
{
    /**
     * @Route("/konto")
     */
    public function accountAction(Request $request)
    {
        $config = new Config();
        $session = $request->getSession();
        $cookieLogin = new CookieLogin($em = $this->getDoctrine()->getManager());
        $cookieLogin->setCookieLogin($session);
        if (!$session->get('user')) {
            header('Location: ' . $config->getUrl() . '/logowanie');
            exit;
        }
        $quickForm = new QuickForm($this, $request);

        $menu = new Menu($em, 1, 0);

        return $this->render('account/account.html.twig', array(
            'session' => $session->get('user'),
            'quickForm' => $quickForm->createView(),
            'activeCategory' => 1,
            'activeProvince' => 0,
            'activeCity' => 0,
            'categories' => $menu->getCategories(),
            'places' => $menu->getPlaces(),
            'isProvince' => $menu->isProvince()
        ));
    }
}
