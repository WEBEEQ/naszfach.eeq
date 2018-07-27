<?php
// src/AppBundle/Controller/LoginController.php
namespace AppBundle\Controller;

use AppBundle\Bundle\Config;
use AppBundle\Bundle\CookieLogin;
use AppBundle\Bundle\Email;
use AppBundle\Bundle\Menu;
use AppBundle\Bundle\QuickForm;
use AppBundle\Entity\LoginForm;
use AppBundle\Form\Type\LoginFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends Controller
{
    /**
     * @Route("/logowanie", name="loginpage")
     */
    public function loginAction(Request $request)
    {
        $config = new Config();
        $session = $request->getSession();
        $cookieLogin = new CookieLogin($em = $this->getDoctrine()->getManager());
        $cookieLogin->setCookieLogin($session);
        $quickForm = new QuickForm($this, $request);
        $email = new Email($this);

        $messageString = '';
        $messageClass = 'bad';

        $loginForm = new LoginForm();
        $form = $this->createForm(LoginFormType::class, $loginForm);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $validator = $this->get('validator');
            $errors = $validator->validate($loginForm);
            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    $messageString .= $error->getMessage() . '<br />';
                }
            } else {
                if ($loginForm->getForget()) {
                    if ($loginForm->getLogin() == '') {
                        $messageString .= 'Podaj login twojego konta.<br />';
                    } else {
                        $userLogin = $this->getDoctrine()
                            ->getRepository('AppBundle:User')
                            ->isUserLogin($loginForm->getLogin());
                        if ($userLogin) {
                            if ($userLogin->getActive()) {
                                if ($this->sendPasswordChangeEmail($config, $email, $loginForm, $userLogin)) {
                                    $messageString .= 'Sprawdź pocztę w celu poznania dalszych instrukcji.<br />';
                                    $messageClass = 'ok';
                                    unset($loginForm);
                                    unset($form);
                                    $loginForm = new LoginForm();
                                    $form = $this->createForm(LoginFormType::class, $loginForm);
                                } else {
                                    $messageString .= "Wysłanie e-mail'a z dalszymi instrukcjami"
                                        . ' nie powiodło się.<br />';
                                }
                            } else {
                                $messageString .= 'Konto o podanym loginie nie jest aktywne.<br />';
                                if ($this->sendActivationEmail($config, $email, $loginForm, $userLogin)) {
                                    $messageString .= 'Sprawdź pocztę w celu aktywacji konta.<br />';
                                } else {
                                    $messageString .= "Wysłanie e-mail'a aktywacyjnego nie powiodło się.<br />";
                                }
                            }
                        } else {
                            $messageString .= 'Konto o podanym loginie nie istnieje.<br />';
                        }
                    }
                } else {
                    if ($loginForm->getLogin() == '' || $loginForm->getPassword() == '') {
                        $messageString .= 'Podaj login i hasło twojego konta.<br />';
                    } else {
                        $userPassword = $this->getDoctrine()
                            ->getRepository('AppBundle:User')
                            ->isUserPassword($loginForm->getLogin(), $loginForm->getPassword());
                        if ($userPassword) {
                            if ($userPassword->getActive()) {
                                $this->getDoctrine()->getRepository('AppBundle:User')->setUserLoged(
                                    $userPassword->getId(),
                                    $config->getRemoteAddress(),
                                    $config->getDateTimeNow()
                                );
                                $session->set('id', $userPassword->getId());
                                $session->set('user', $loginForm->getLogin());
                                if ($loginForm->getRemember()) {
                                    setcookie(
                                        'login',
                                        $loginForm->getLogin() . ';' . $userPassword->getPassword(),
                                        time() + 365 * 24 * 60 * 60, '/'
                                    );
                                }
                                header('Location: ' . $config->getUrl() . '/konto');
                                exit;
                            } else {
                                $messageString .= 'Konto o podanym loginie i haśle nie jest aktywne.<br />';
                                if ($this->sendActivationEmail($config, $email, $loginForm, $userPassword)) {
                                    $messageString .= 'Sprawdź pocztę w celu aktywacji konta.<br />';
                                } else {
                                    $messageString .= "Wysłanie e-mail'a aktywacyjnego nie powiodło się.<br />";
                                }
                            }
                        } else {
                            $messageString .= 'Konto o podanym loginie i haśle nie istnieje.<br />';
                        }
                    }
                }
            }
        }

        $menu = new Menu($em, 1, 0);

        return $this->render('login/login.html.twig', array(
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
     * @Route("/logowanie,{user},{code}")
     */
    public function emailAction(Request $request, $user, $code)
    {
        $config = new Config();
        $session = $request->getSession();
        $cookieLogin = new CookieLogin($em = $this->getDoctrine()->getManager());
        $cookieLogin->setCookieLogin($session);
        $quickForm = new QuickForm($this, $request);
        $email = new Email($this);

        $messageString = '';
        $messageClass = 'bad';

        $loginForm = new LoginForm();
        $form = $this->createForm(LoginFormType::class, $loginForm);

        $userLogin = $this->getDoctrine()->getRepository('AppBundle:User')->isUserLogin($user);
        if ($userLogin && $code == $userLogin->getKey()) {
            if (!$userLogin->getActive()) {
                $messageString .= 'Konto użytkownika nie jest aktywne.<br />';
            } else {
                $userPassword = $this->getDoctrine()->getRepository('AppBundle:User')->setUserPassword(
                    $userLogin->getId(),
                    $password = $this->getDoctrine()->getRepository('AppBundle:User')->generatePassword(),
                    $config->getRemoteAddress(),
                    $config->getDateTimeNow()
                );
                if ($userPassword) {
                    $messageString .= 'Hasło konta użytkownika zostało zmienione.<br />';
                    $messageClass = 'ok';
                    if ($this->sendNewPasswordEmail($config, $email, $userLogin, $password)) {
                        $messageString .= 'Sprawdź pocztę w celu zapoznania z hasłem.<br />';
                    } else {
                        $messageString .= "Wysłanie e-mail'a z hasłem nie powiodło się.<br />";
                        $messageClass = 'bad';
                    }
                    unset($loginForm);
                    unset($form);
                    $loginForm = new LoginForm();
                    $form = $this->createForm(LoginFormType::class, $loginForm);
                } else {
                    $messageString .= 'Zmiana hasła konta użytkownika nie powiodła się.<br />';
                }
            }
        } else {
            $messageString .= 'Podany kod zmiany hasła jest niepoprawny.<br />';
        }

        $menu = new Menu($em, 1, 0);

        return $this->render('login/login.html.twig', array(
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

    private function sendActivationEmail($config, $email, $loginForm, $user)
    {
        return $email->sendEmail(
            $config->getAdminEmail(),
            $user->getEmail(),
            'Aktywacja konta ' . $loginForm->getLogin() . ' w serwisie '
                . $config->getServerDomain(),
            'Aby aktywować konto, otwórz w oknie przeglądarki url poniżej.'
                . "\r\n\r\n" . 'http://' . $config->getServerName()
                . '/rejestracja,' . $user->getLogin() . ',' . $user->getKey()
                . "\r\n\r\n" . '--' . "\r\n" . $config->getAdminEmail()
        );
    }

    private function sendPasswordChangeEmail($config, $email, $loginForm, $user)
    {
        return $email->sendEmail(
            $config->getAdminEmail(),
            $user->getEmail(),
            'Zmiana hasła konta ' . $loginForm->getLogin() . ' w serwisie '
                . $config->getServerDomain(),
            'Aby zmienić hasło konta, otwórz w oknie przeglądarki url poniżej.'
                . "\r\n\r\n" . 'http://' . $config->getServerName()
                . '/logowanie,' . $user->getLogin() . ',' . $user->getKey()
                . "\r\n\r\n" . '--' . "\r\n" . $config->getAdminEmail()
        );
    }

    private function sendNewPasswordEmail($config, $email, $user, $password)
    {
        return $email->sendEmail(
            $config->getAdminEmail(),
            $user->getEmail(),
            'Nowe hasło konta ' . $user->getLogin() . ' w serwisie '
                . $config->getServerDomain(),
            'Nowe hasło konta: ' . $password . "\r\n\r\n" . '--' . "\r\n"
                . $config->getAdminEmail()
        );
    }
}
