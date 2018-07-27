<?php
// src/AppBundle/Controller/FirmController.php
namespace AppBundle\Controller;

use AppBundle\Bundle\Config;
use AppBundle\Bundle\CookieLogin;
use AppBundle\Bundle\Menu;
use AppBundle\Bundle\QuickForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class FirmController extends Controller
{
    /**
     * @Route("/firma,{activeFirm}", requirements={"activeFirm": "\d+"})
     */
    public function firmAction(Request $request, $activeFirm)
    {
        $config = new Config();
        $session = $request->getSession();
        $cookieLogin = new CookieLogin($em = $this->getDoctrine()->getManager());
        $cookieLogin->setCookieLogin($session);
        $quickForm = new QuickForm($this, $request);

        $this->updateFirm($activeFirm);
        $firm = $em->getRepository('AppBundle:Firm')->getFirmData($activeFirm);
        $firmCategories = $em->getRepository('AppBundle:Firm')->getCategoryList($activeFirm);
        $firmPictures = $em->getRepository('AppBundle:Firm')->getPictureList($activeFirm);
        $firmCommentTypes = $em->getRepository('AppBundle:Firm')->getCommentTypeList();
        $firmComments = $em->getRepository('AppBundle:Firm')->getCommentList($activeFirm, 0, 1, 30);
        $firmCommentNavigator = $em->getRepository('AppBundle:Firm')->commentListNavigator(
            $config->getUrl(),
            $activeFirm,
            0,
            1,
            30
        );

        $menu = new Menu($em, 1, 0);

        return $this->render('firm/firm.html.twig', array(
            'session' => $session->get('user'),
            'quickForm' => $quickForm->createView(),
            'activeCategory' => 1,
            'activeProvince' => 0,
            'activeCity' => 0,
            'activeFirm' => $activeFirm,
            'activeType' => 0,
            'activeLevel' => 1,
            'categories' => $menu->getCategories(),
            'places' => $menu->getPlaces(),
            'isProvince' => $menu->isProvince(),
            'firm' => $firm,
            'firmCategories' => $firmCategories,
            'firmPictures' => $firmPictures,
            'firmCommentTypes' => $firmCommentTypes,
            'firmComments' => $firmComments,
            'firmCommentNavigator' => $firmCommentNavigator
        ));
    }

    /**
     * @Route("/firma,{activeFirm},typ,{activeType}", requirements={"activeFirm": "\d+", "activeType": "\d+"})
     */
    public function firmTypeAction(Request $request, $activeFirm, $activeType)
    {
        $config = new Config();
        $session = $request->getSession();
        $cookieLogin = new CookieLogin($em = $this->getDoctrine()->getManager());
        $cookieLogin->setCookieLogin($session);
        $quickForm = new QuickForm($this, $request);

        $this->updateFirm($activeFirm);
        $firm = $em->getRepository('AppBundle:Firm')->getFirmData($activeFirm);
        $firmCategories = $em->getRepository('AppBundle:Firm')->getCategoryList($activeFirm);
        $firmPictures = $em->getRepository('AppBundle:Firm')->getPictureList($activeFirm);
        $firmCommentTypes = $em->getRepository('AppBundle:Firm')->getCommentTypeList();
        $firmComments = $em->getRepository('AppBundle:Firm')->getCommentList($activeFirm, $activeType, 1, 30);
        $firmCommentNavigator = $em->getRepository('AppBundle:Firm')->commentListNavigator(
            $config->getUrl(),
            $activeFirm,
            $activeType,
            1,
            30
        );

        $menu = new Menu($em, 1, 0);

        return $this->render('firm/firm.html.twig', array(
            'session' => $session->get('user'),
            'quickForm' => $quickForm->createView(),
            'activeCategory' => 1,
            'activeProvince' => 0,
            'activeCity' => 0,
            'activeFirm' => $activeFirm,
            'activeType' => $activeType,
            'activeLevel' => 1,
            'categories' => $menu->getCategories(),
            'places' => $menu->getPlaces(),
            'isProvince' => $menu->isProvince(),
            'firm' => $firm,
            'firmCategories' => $firmCategories,
            'firmPictures' => $firmPictures,
            'firmCommentTypes' => $firmCommentTypes,
            'firmComments' => $firmComments,
            'firmCommentNavigator' => $firmCommentNavigator
        ));
    }

    /**
     * @Route(
     *     "/firma,{activeFirm},typ,{activeType},strona,{activeLevel}",
     *     requirements={"activeFirm": "\d+", "activeType": "\d+", "activeLevel": "\d+"}
     * )
     */
    public function firmTypeLevelAction(Request $request, $activeFirm, $activeType, $activeLevel)
    {
        $config = new Config();
        $session = $request->getSession();
        $cookieLogin = new CookieLogin($em = $this->getDoctrine()->getManager());
        $cookieLogin->setCookieLogin($session);
        $quickForm = new QuickForm($this, $request);

        $this->updateFirm($activeFirm);
        $firm = $em->getRepository('AppBundle:Firm')->getFirmData($activeFirm);
        $firmCategories = $em->getRepository('AppBundle:Firm')->getCategoryList($activeFirm);
        $firmPictures = $em->getRepository('AppBundle:Firm')->getPictureList($activeFirm);
        $firmCommentTypes = $em->getRepository('AppBundle:Firm')->getCommentTypeList();
        $firmComments = $em->getRepository('AppBundle:Firm')->getCommentList(
            $activeFirm,
            $activeType,
            $activeLevel,
            30
        );
        $firmCommentNavigator = $em->getRepository('AppBundle:Firm')->commentListNavigator(
            $config->getUrl(),
            $activeFirm,
            $activeType,
            $activeLevel,
            30
        );

        $menu = new Menu($em, 1, 0);

        return $this->render('firm/firm.html.twig', array(
            'session' => $session->get('user'),
            'quickForm' => $quickForm->createView(),
            'activeCategory' => 1,
            'activeProvince' => 0,
            'activeCity' => 0,
            'activeFirm' => $activeFirm,
            'activeType' => $activeType,
            'activeLevel' => $activeLevel,
            'categories' => $menu->getCategories(),
            'places' => $menu->getPlaces(),
            'isProvince' => $menu->isProvince(),
            'firm' => $firm,
            'firmCategories' => $firmCategories,
            'firmPictures' => $firmPictures,
            'firmCommentTypes' => $firmCommentTypes,
            'firmComments' => $firmComments,
            'firmCommentNavigator' => $firmCommentNavigator
        ));
    }

    /**
     * @Route("/firma,{activeFirm},zlecenie", requirements={"activeFirm": "\d+"})
     */
    public function firmOrderAction(Request $request, $activeFirm)
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

        return $this->render('firm/order.html.twig', array(
            'session' => $session->get('user'),
            'quickForm' => $quickForm->createView(),
            'activeCategory' => 1,
            'activeProvince' => 0,
            'activeCity' => 0,
            'activeFirm' => $activeFirm,
            'categories' => $menu->getCategories(),
            'places' => $menu->getPlaces(),
            'isProvince' => $menu->isProvince()
        ));
    }

    /**
     * @Route(
     *     "/firma,{activeFirm},obrazek,{activePicture}",
     *     requirements={"activeFirm": "\d+", "activePicture": "\d+"}
     * )
     */
    public function firmPictureAction($activeFirm, $activePicture)
    {
        $session = new Session();
        $cookieLogin = new CookieLogin($em = $this->getDoctrine()->getManager());
        $cookieLogin->setCookieLogin($session);

        $pictures = $em->getRepository('AppBundle:Picture')->getPictureList($activeFirm);

        for ($i = 0; $i < count($pictures); $i++) {
            if ($pictures[$i]['id'] == $activePicture) {
                break;
            }
        }
        $minusI = $i - 1;
        $plusI = $i + 1;

        return $this->render('firm/picture.html.twig', array(
            'session' => $session->get('user'),
            'activeFirm' => $activeFirm,
            'activePicture' => $activePicture,
            'pictures' => $pictures,
            'i' => $i,
            'minusI' => $minusI,
            'plusI' => $plusI,
            'edit' => 0
        ));
    }

    protected function updateFirm($activeFirm)
    {
        $firm = $this->getDoctrine()->getRepository('AppBundle:Firm')->find($activeFirm);
        $dateCondition = strtotime($firm->getCommentDate()->format('Y-m-d H:i:s')) <= time() - 1 * 24 * 60 * 60;
        if ($firm && $firm->getUser()->getActive() && $firm->getActive() && $firm->getVisible() && $dateCondition) {
            $date = date('Y-m-d H:i:s');
            $date7Days = date('Y-m-d H:i:s', time() - 7 * 24 * 60 * 60);
            $date30Days = date('Y-m-d H:i:s', time() - 30 * 24 * 60 * 60);
            $update = $this->getDoctrine()->getRepository('AppBundle:Firm')->updateFirmComment(
                $activeFirm,
                $date7Days,
                $date30Days,
                $date
            );

            return $update;
        }

        return false;
    }
}
