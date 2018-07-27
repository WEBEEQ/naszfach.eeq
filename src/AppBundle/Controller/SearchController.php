<?php
// src/AppBundle/Controller/SearchController.php
namespace AppBundle\Controller;

use AppBundle\Bundle\Config;
use AppBundle\Bundle\CookieLogin;
use AppBundle\Bundle\Menu;
use AppBundle\Bundle\QuickForm;
use AppBundle\Entity\MainForm;
use AppBundle\Entity\SearchForm;
use AppBundle\Form\Type\MainFormType;
use AppBundle\Form\Type\SearchFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends Controller
{
    /**
     * @Route("/szukanie")
     */
    public function searchAction()
    {
        return $this->redirectToRoute('searchpage');
    }

    /**
     * @Route(
     *     "/szukanie,{formSearch},firma,{formName},ulica,{formStreet},kod,{formPostcode},miejsce,{formProvince},{formCity},sortowanie,{formSort},{formDescend},zlecenia,{formOrder},komentarze,{formComment},strona,{formLevel}",
     *     name="searchpage",
     *     defaults={
     *         "formSearch" = 0,
     *         "formName" = "",
     *         "formStreet" = "",
     *         "formPostcode" = "",
     *         "formProvince" = 0,
     *         "formCity" = 0,
     *         "formSort" = 1,
     *         "formDescend" = 1,
     *         "formOrder" = 1,
     *         "formComment" = 0,
     *         "formLevel" = 1
     *     },
     *     requirements={
     *         "formSearch": "\d+",
     *         "formName": "[^/]*",
     *         "formStreet": "[^/]*",
     *         "formPostcode": "[^/]*",
     *         "formProvince": "\d+",
     *         "formCity": "\d+",
     *         "formSort": "\d+",
     *         "formDescend": "\d+",
     *         "formOrder": "\d+",
     *         "formComment": "\d+",
     *         "formLevel": "\d+"
     *     }
     * )
     */
    public function fullSearchAction(
        Request $request,
        $formSearch,
        $formName,
        $formStreet,
        $formPostcode,
        $formProvince,
        $formCity,
        $formSort,
        $formDescend,
        $formOrder,
        $formComment,
        $formLevel
    ) {
        $config = new Config();
        $session = $request->getSession();
        $cookieLogin = new CookieLogin($em = $this->getDoctrine()->getManager());
        $cookieLogin->setCookieLogin($session);
        $quickForm = new QuickForm($this, $request);

        $messageString = '';
        $messageClass = 'bad';
        $firms = null;
        $pageNavigator = null;

        if ($quickForm->getName()) {
            header(
                'Location: ' . $config->getUrl() . '/szukanie,1,firma,' . $quickForm->getName()
                    . ',ulica,' . $formStreet . ',kod,' . $formPostcode . ',miejsce,'
                    . $formProvince . ',' . $formCity . ',sortowanie,' . $formSort . ','
                    . $formDescend . ',zlecenia,' . $formOrder . ',komentarze,' . $formComment
                    . ',strona,' . $formLevel
            );
            exit;
        }

        $mainForm = new MainForm();
        $mainForm->setComment($formComment);
        $commentForm = $this->createForm(MainFormType::class, $mainForm);
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $formComment = $mainForm->getComment();
            header(
                'Location: ' . $config->getUrl() . '/szukanie,1,firma,' . $formName . ',ulica,'
                    . $formStreet . ',kod,' . $formPostcode . ',miejsce,' . $formProvince . ','
                    . $formCity . ',sortowanie,' . $formSort . ',' . $formDescend . ',zlecenia,'
                    . $formOrder . ',komentarze,' . $formComment . ',strona,1'
            );
            exit;
        }

        $searchForm = new SearchForm();
        $searchForm->setProvince($formProvince);
        $searchFormType = new SearchFormType($this, 0);
        $form = $this->createForm($searchFormType, $searchForm);
        $form->handleRequest($request);
        $selectedProvince = $searchForm->getProvince();
        unset($searchForm);
        unset($form);

        $searchForm = new SearchForm();
        $searchForm->setName($formName);
        $searchForm->setStreet($formStreet);
        $searchForm->setPostcode($formPostcode);
        $searchForm->setProvince($formProvince);
        $searchForm->setCity($formCity);
        $searchFormType = new SearchFormType($this, $selectedProvince);
        $form = $this->createForm($searchFormType, $searchForm);
        if ($quickForm->getName()) {
            $form->get('name')->setData($quickForm->getName());
            $quickForm->clearForm();
        } else {
            $form->handleRequest($request);
        }
        if ($form->isSubmitted()) {
            $validator = $this->get('validator');
            $errors = $validator->validate($searchForm);
            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    $messageString .= $error->getMessage() . '<br />';
                }
            } else {
                $formName = $searchForm->getName();
                $formStreet = $searchForm->getStreet();
                $formPostcode = $searchForm->getPostcode();
                $formProvince = $searchForm->getProvince();
                $formCity = $searchForm->getCity();
                header(
                    'Location: ' . $config->getUrl() . '/szukanie,1,firma,' . $formName . ',ulica,'
                        . $formStreet . ',kod,' . $formPostcode . ',miejsce,' . $formProvince . ','
                        . $formCity . ',sortowanie,' . $formSort . ',' . $formDescend . ',zlecenia,'
                        . $formOrder . ',komentarze,' . $formComment . ',strona,' . $formLevel
                );
                exit;
            }
        }

        if ($formSearch == 1) {
            $firms = $em->getRepository('AppBundle:Firm')->getSearchList(
                $formName,
                $formStreet,
                $formPostcode,
                $formProvince,
                $formCity,
                $formSort,
                $formDescend,
                $formOrder,
                $formComment,
                $formLevel,
                100
            );
            $pageNavigator = $em->getRepository('AppBundle:Firm')->searchNavigator(
                $config->getUrl(),
                $formName,
                $formStreet,
                $formPostcode,
                $formProvince,
                $formCity,
                $formSort,
                $formDescend,
                $formOrder,
                $formComment,
                $formLevel,
                100
            );
            if (!$firms && $formLevel > 1) {
                header(
                    'Location: ' . $config->getUrl() . '/szukanie,1,firma,' . $formName
                        . ',ulica,' . $formStreet . ',kod,' . $formPostcode . ',miejsce,'
                        . $formProvince . ',' . $formCity . ',sortowanie,' . $formSort
                        . ',' . $formDescend . ',zlecenia,' . $formOrder . ',komentarze,'
                        . $formComment . ',strona,1'
                );
                exit;
            }
        }

        $menu = new Menu($em, 1, 0);

        return $this->render('search/search.html.twig', array(
            'session' => $session->get('user'),
            'quickForm' => $quickForm->createView(),
            'commentForm' => $commentForm->createView(),
            'form' => $form->createView(),
            'messageString' => $messageString,
            'messageClass' => $messageClass,
            'selectedCity' => $searchForm->getCity(),
            'activeCategory' => 1,
            'activeProvince' => 0,
            'activeCity' => 0,
            'formName' => $formName,
            'formStreet' => $formStreet,
            'formPostcode' => $formPostcode,
            'formProvince' => $formProvince,
            'formCity' => $formCity,
            'formSort' => $formSort,
            'formDescend' => $formDescend,
            'formOrder' => $formOrder,
            'formComment' => $formComment,
            'formLevel' => $formLevel,
            'categories' => $menu->getCategories(),
            'places' => $menu->getPlaces(),
            'isProvince' => $menu->isProvince(),
            'firms' => $firms,
            'pageNavigator' => $pageNavigator
        ));
    }
}
