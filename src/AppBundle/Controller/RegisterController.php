<?php
// src/AppBundle/Controller/RegisterController.php
namespace AppBundle\Controller;

use AppBundle\Bundle\Config;
use AppBundle\Bundle\CookieLogin;
use AppBundle\Bundle\Email;
use AppBundle\Bundle\Menu;
use AppBundle\Bundle\QuickForm;
use AppBundle\Entity\RegisterForm;
use AppBundle\Entity\User;
use AppBundle\Form\Type\RegisterFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RegisterController extends Controller
{
    /**
     * @Route("/rejestracja")
     */
    public function registerAction(Request $request)
    {
        $config = new Config();
        $session = $request->getSession();
        $cookieLogin = new CookieLogin($em = $this->getDoctrine()->getManager());
        $cookieLogin->setCookieLogin($session);
        $quickForm = new QuickForm($this, $request);
        $email = new Email($this);

        $messageString = '';
        $messageClass = 'bad';

        $registerForm = new RegisterForm();
        $form = $this->createForm(RegisterFormType::class, $registerForm);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $validator = $this->get('validator');
            $errors = $validator->validate($registerForm);
            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    $messageString .= $error->getMessage() . '<br />';
                }
            } else {
                if ($this->getDoctrine()->getRepository('AppBundle:User')->isUserLogin($registerForm->getLogin())) {
                    $messageString .= 'Konto o podanym loginie już istnieje.<br />';
                } else {
                    $user = new User();
                    $user->setProvince(NULL);
                    $user->setCity(NULL);
                    $user->setActive(0);
                    $user->setName($registerForm->getName());
                    $user->setSurname($registerForm->getSurname());
                    $user->setLogin($registerForm->getLogin());
                    $user->setPassword(md5($registerForm->getPassword()));
                    $user->setKey(md5(date('Y-m-d H:i:s') . $registerForm->getPassword()));
                    $user->setEmail($registerForm->getEmail());
                    $user->setUrl('');
                    $user->setPhone('');
                    $user->setStreet('');
                    $user->setPostcode('');
                    $user->setDescription('');
                    $user->setCommentNumber(0);
                    $user->setCommentPositive7Days(0);
                    $user->setCommentNeutral7Days(0);
                    $user->setCommentNegative7Days(0);
                    $user->setCommentPositive30Days(0);
                    $user->setCommentNeutral30Days(0);
                    $user->setCommentNegative30Days(0);
                    $user->setCommentPositiveAllDays(0);
                    $user->setCommentNeutralAllDays(0);
                    $user->setCommentNegativeAllDays(0);
                    $user->setCommentDate($dateTime = new \DateTime('now'));
                    $user->setIpAdded($config->getRemoteAddress());
                    $user->setDateAdded($dateTime);
                    $user->setIpUpdated('');
                    $user->setDateUpdated(new \DateTime('1970-01-01 00:00:00'));
                    $user->setIpLoged('');
                    $user->setDateLoged(new \DateTime('1970-01-01 00:00:00'));
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($user);
                    $em->flush();
                    $messageString .= 'Konto użytkownika zostało utworzone.<br />';
                    $messageClass = 'ok';
                    if ($this->sendActivationEmail($config, $email, $registerForm, $user)) {
                        $messageString .= 'Sprawdź pocztę w celu aktywacji konta.<br />';
                    } else {
                        $messageString .= "Wysłanie e-mail'a aktywacyjnego nie powiodło się.<br />";
                        $messageClass = 'bad';
                    }
                    unset($registerForm);
                    unset($form);
                    $registerForm = new RegisterForm();
                    $form = $this->createForm(RegisterFormType::class, $registerForm);
                }
            }
        }

        $menu = new Menu($em, 1, 0);

        return $this->render('register/register.html.twig', array(
            'session' => $session->get('user'),
            'quickForm' => $quickForm->createView(),
            'form' => $form->createView(),
            'messageString' => $messageString,
            'messageClass' => $messageClass,
            'activeCategory' => 1,
            'activeProvince' => 0,
            'activeCity' => 0,
            'categories' => $menu->getCategories(),
            'places' => $menu->getPlaces(),
            'isProvince' => $menu->isProvince()
        ));
    }

    /**
     * @Route("/rejestracja,{user},{code}")
     */
    public function emailAction(Request $request, $user, $code)
    {
        $session = $request->getSession();
        $cookieLogin = new CookieLogin($em = $this->getDoctrine()->getManager());
        $cookieLogin->setCookieLogin($session);
        $quickForm = new QuickForm($this, $request);

        $messageString = '';
        $messageClass = 'bad';

        $registerForm = new RegisterForm();
        $form = $this->createForm(RegisterFormType::class, $registerForm);

        $userLogin = $this->getDoctrine()->getRepository('AppBundle:User')->isUserLogin($user);
        if ($userLogin && $code == $userLogin->getKey()) {
            if ($userLogin->getActive()) {
                $messageString .= 'Konto użytkownika jest już aktywne.<br />';
            } elseif ($this->getDoctrine()->getRepository('AppBundle:User')->setUserActive($userLogin->getId())) {
                $messageString .= 'Konto użytkownika zostało aktywowane.<br />';
                $messageClass = 'ok';
            } else {
                $messageString .= 'Aktywacja konta użytkownika nie powiodła się.<br />';
            }
        } else {
            $messageString .= 'Podany kod aktywacyjny jest niepoprawny.<br />';
        }

        $menu = new Menu($em, 1, 0);

        return $this->render('register/register.html.twig', array(
            'session' => $session->get('user'),
            'quickForm' => $quickForm->createView(),
            'form' => $form->createView(),
            'messageString' => $messageString,
            'messageClass' => $messageClass,
            'activeCategory' => 1,
            'activeProvince' => 0,
            'activeCity' => 0,
            'categories' => $menu->getCategories(),
            'places' => $menu->getPlaces(),
            'isProvince' => $menu->isProvince()
        ));
    }

    private function sendActivationEmail($config, $email, $registerForm, $user)
    {
        return $email->sendEmail(
            $config->getAdminEmail(),
            $registerForm->getEmail(),
            'Aktywacja konta ' . $registerForm->getLogin() . ' w serwisie '
                . $config->getServerDomain(),
            'Aby aktywować konto, otwórz w oknie przeglądarki url poniżej.'
                . "\r\n\r\n" . 'http://' . $config->getServerName()
                . '/rejestracja,' . $user->getLogin() . ',' . $user->getKey()
                . "\r\n\r\n" . '--' . "\r\n" . $config->getAdminEmail()
        );
    }
}
