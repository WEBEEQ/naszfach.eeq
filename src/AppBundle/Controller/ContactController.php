<?php
// src/AppBundle/Controller/ContactController.php
namespace AppBundle\Controller;

use AppBundle\Bundle\Config;
use AppBundle\Bundle\CookieLogin;
use AppBundle\Bundle\Email;
use AppBundle\Bundle\Menu;
use AppBundle\Bundle\QuickForm;
use AppBundle\Entity\ContactForm;
use AppBundle\Form\Type\ContactFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    /**
     * @Route("/kontakt")
     */
    public function contactAction(Request $request)
    {
        $config = new Config();
        $session = $request->getSession();
        $cookieLogin = new CookieLogin($em = $this->getDoctrine()->getManager());
        $cookieLogin->setCookieLogin($session);
        $quickForm = new QuickForm($this, $request);
        $email = new Email($this);

        $messageString = '';
        $messageClass = 'bad';

        $contactForm = new ContactForm();
        $form = $this->createForm(ContactFormType::class, $contactForm);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $validator = $this->get('validator');
            $errors = $validator->validate($contactForm);
            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    $messageString .= $error->getMessage() . '<br />';
                }
            } else {
                $sendEmail = $email->sendEmail(
                    $contactForm->getEmail(),
                    $config->getAdminEmail(),
                    $contactForm->getSubject(),
                    $contactForm->getMessage()
                );
                if ($sendEmail) {
                    $messageString .= 'Wiadomość została wysłana.<br />';
                    $messageClass = 'ok';
                    unset($contactForm);
                    unset($form);
                    $contactForm = new ContactForm();
                    $form = $this->createForm(ContactFormType::class, $contactForm);
                } else {
                    $messageString .= 'Wysłanie wiadomości nie powiodło się.<br />';
                }
            }
        }

        $menu = new Menu($em, 1, 0);

        return $this->render('contact/contact.html.twig', array(
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
}
