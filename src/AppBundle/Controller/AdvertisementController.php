<?php
// src/AppBundle/Controller/AdvertisementController.php
namespace AppBundle\Controller;

use AppBundle\Bundle\CookieLogin;
use AppBundle\Bundle\Menu;
use AppBundle\Bundle\QuickForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdvertisementController extends Controller
{
    /**
     * @Route("/reklama")
     */
    public function advertisementAction(Request $request)
    {
        $session = $request->getSession();
        $cookieLogin = new CookieLogin($em = $this->getDoctrine()->getManager());
        $cookieLogin->setCookieLogin($session);
        $quickForm = new QuickForm($this, $request);

        $menu = new Menu($em, 1, 0);

        return $this->render('advertisement/advertisement.html.twig', array(
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
