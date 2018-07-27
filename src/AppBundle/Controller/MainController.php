<?php
// src/AppBundle/Controller/MainController.php
namespace AppBundle\Controller;

use AppBundle\Bundle\Config;
use AppBundle\Bundle\CookieLogin;
use AppBundle\Bundle\Menu;
use AppBundle\Bundle\QuickForm;
use AppBundle\Entity\MainForm;
use AppBundle\Form\Type\MainFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    /**
     * @Route("/", name="mainpage")
     */
    public function mainAction(Request $request)
    {
        $session = $request->getSession();
        $cookieLogin = new CookieLogin($em = $this->getDoctrine()->getManager());
        $cookieLogin->setCookieLogin($session);
        $quickForm = new QuickForm($this, $request);

        $topFirms = $em->getRepository('AppBundle:Firm')->getFirmTopList(1, 10);
        $newFirms = $em->getRepository('AppBundle:Firm')->getFirmNewList(100);

        $menu = new Menu($em, 1, 0);

        return $this->render('main/main.html.twig', array(
            'session' => $session->get('user'),
            'quickForm' => $quickForm->createView(),
            'activeCategory' => 1,
            'activeProvince' => 0,
            'activeCity' => 0,
            'categories' => $menu->getCategories(),
            'places' => $menu->getPlaces(),
            'isProvince' => $menu->isProvince(),
            'topFirms' => $topFirms,
            'newFirms' => $newFirms
        ));
    }

    /**
     * @Route(
     *     "/kategoria,{activeCategory},miejsce,{activeProvince},{activeCity}",
     *     requirements={"activeCategory": "\d+", "activeProvince": "\d+", "activeCity": "\d+"}
     * )
     */
    public function listAction(Request $request, $activeCategory, $activeProvince, $activeCity)
    {
        $config = new Config();
        $session = $request->getSession();
        $cookieLogin = new CookieLogin($em = $this->getDoctrine()->getManager());
        $cookieLogin->setCookieLogin($session);
        $quickForm = new QuickForm($this, $request);

        $mainForm = new MainForm();
        $mainForm->setComment(0);
        $form = $this->createForm(MainFormType::class, $mainForm);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $activeComment = $mainForm->getComment();
        } else {
            $activeComment = 0;
        }

        $title = $this->getTitle($activeCategory, $activeProvince, $activeCity);
        $firms = $em->getRepository('AppBundle:Firm')->getFirmList(
            $activeCategory,
            $activeProvince,
            $activeCity,
            1,
            1,
            1,
            $activeComment,
            1,
            100
        );
        $pageNavigator = $em->getRepository('AppBundle:Firm')->pageNavigator(
            $config->getUrl(),
            $activeCategory,
            $activeProvince,
            $activeCity,
            1,
            1,
            1,
            $activeComment,
            1,
            100
        );
        $categoryNavigator = $em->getRepository('AppBundle:Category')->categoryNavigator(
            $config->getUrl(),
            $activeCategory,
            $activeProvince,
            $activeCity
        );

        $menu = new Menu($em, $activeCategory, $activeProvince);

        return $this->render('main/list.html.twig', array(
            'session' => $session->get('user'),
            'quickForm' => $quickForm->createView(),
            'form' => $form->createView(),
            'title' => $title,
            'activeCategory' => $activeCategory,
            'activeProvince' => $activeProvince,
            'activeCity' => $activeCity,
            'activeSort' => 1,
            'activeDescend' => 1,
            'activeOrder' => 1,
            'activeComment' => $activeComment,
            'activeLevel' => 1,
            'categories' => $menu->getCategories(),
            'places' => $menu->getPlaces(),
            'isProvince' => $menu->isProvince(),
            'firms' => $firms,
            'pageNavigator' => $pageNavigator,
            'categoryNavigator' => $categoryNavigator
        ));
    }

    /**
     * @Route(
     *     "/kategoria,{activeCategory},miejsce,{activeProvince},{activeCity},sortowanie,{activeSort},{activeDescend},zlecenia,{activeOrder},komentarze,{activeComment},strona,{activeLevel}",
     *     requirements={
     *         "activeCategory": "\d+",
     *         "activeProvince": "\d+",
     *         "activeCity": "\d+",
     *         "activeSort": "\d+",
     *         "activeDescend": "\d+",
     *         "activeOrder": "\d+",
     *         "activeComment": "\d+",
     *         "activeLevel": "\d+"
     *     }
     * )
     */
    public function fullListAction(
        Request $request,
        $activeCategory,
        $activeProvince,
        $activeCity,
        $activeSort,
        $activeDescend,
        $activeOrder,
        $activeComment,
        $activeLevel
    ) {
        $config = new Config();
        $session = $request->getSession();
        $cookieLogin = new CookieLogin($em = $this->getDoctrine()->getManager());
        $cookieLogin->setCookieLogin($session);
        $quickForm = new QuickForm($this, $request);

        $mainForm = new MainForm();
        $mainForm->setComment($activeComment);
        $form = $this->createForm(MainFormType::class, $mainForm);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $activeComment = $mainForm->getComment();
            header(
                'Location: ' . $config->getUrl() . '/kategoria,' . $activeCategory
                    . ',miejsce,' . $activeProvince . ',' . $activeCity . ',sortowanie,'
                    . $activeSort . ',' . $activeDescend . ',zlecenia,' . $activeOrder
                    . ',komentarze,' . $activeComment . ',strona,1'
            );
            exit;
        }

        $title = $this->getTitle($activeCategory, $activeProvince, $activeCity);
        $firms = $em->getRepository('AppBundle:Firm')->getFirmList(
            $activeCategory,
            $activeProvince,
            $activeCity,
            $activeSort,
            $activeDescend,
            $activeOrder,
            $activeComment,
            $activeLevel,
            100
        );
        $pageNavigator = $em->getRepository('AppBundle:Firm')->pageNavigator(
            $config->getUrl(),
            $activeCategory,
            $activeProvince,
            $activeCity,
            $activeSort,
            $activeDescend,
            $activeOrder,
            $activeComment,
            $activeLevel,
            100
        );
        $categoryNavigator = $em->getRepository('AppBundle:Category')->categoryNavigator(
            $config->getUrl(),
            $activeCategory,
            $activeProvince,
            $activeCity
        );
        if (!$firms && $activeLevel > 1) {
            header(
                'Location: ' . $config->getUrl() . '/kategoria,' . $activeCategory
                    . ',miejsce,' . $activeProvince . ',' . $activeCity . ',sortowanie,'
                    . $activeSort . ',' . $activeDescend . ',zlecenia,' . $activeOrder
                    . ',komentarze,' . $activeComment . ',strona,1'
            );
            exit;
        }

        $menu = new Menu($em, $activeCategory, $activeProvince);

        return $this->render('main/list.html.twig', array(
            'session' => $session->get('user'),
            'quickForm' => $quickForm->createView(),
            'form' => $form->createView(),
            'title' => $title,
            'activeCategory' => $activeCategory,
            'activeProvince' => $activeProvince,
            'activeCity' => $activeCity,
            'activeSort' => $activeSort,
            'activeDescend' => $activeDescend,
            'activeOrder' => $activeOrder,
            'activeComment' => $activeComment,
            'activeLevel' => $activeLevel,
            'categories' => $menu->getCategories(),
            'places' => $menu->getPlaces(),
            'isProvince' => $menu->isProvince(),
            'firms' => $firms,
            'pageNavigator' => $pageNavigator,
            'categoryNavigator' => $categoryNavigator
        ));
    }

    protected function getTitle($activeCategory, $activeProvince, $activeCity)
    {
        $em = $this->getDoctrine()->getManager();
        $categoryTitle = $em->getRepository('AppBundle:Category')->getCategoryTitle($activeCategory);
        $placeTitle = $em->getRepository('AppBundle:Province')->getPlaceTitle($activeProvince, $activeCity);
        $categoryTitle = ($categoryTitle != '') ? ' | ' . $categoryTitle : '';
        $placeTitle = ($placeTitle != '') ? ' | ' . $placeTitle : '';
        $title = $categoryTitle . $placeTitle;

        return $title;
    }
}
