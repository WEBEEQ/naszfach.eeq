<?php
// src/AppBundle/Bundle/CookieLogin.php
namespace AppBundle\Bundle;

use Doctrine\ORM\EntityManager;

class CookieLogin
{
    protected $em = null;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function setCookieLogin(&$session)
    {
        if (!$session->get('user') && !empty($_COOKIE['login'])) {
            $this->setSessionLogin($session);
        }
    }

    protected function setSessionLogin(&$session)
    {
        $login = explode(';', $_COOKIE['login']);

        if ($user = $this->isUserPassword($login[0], $login[1])) {
            if ($user->getActive()) {
                $user->setIpLoged($_SERVER['REMOTE_ADDR']);
                $user->setDateLoged(new \DateTime('now'));
                $this->em->flush();
                $session->set('id', $user->getId());
                $session->set('user', $login[0]);
            }
        }
    }

    private function isUserPassword($login, $password)
    {
        $repository = $this->em->getRepository('AppBundle:User');
        $query = $repository->createQueryBuilder('u')
            ->select('u')
            ->where('u.login = :login')
            ->andWhere('u.password = :password')
            ->setParameters(array('login' => $login, 'password' => $password))
            ->getQuery();
        $result = $query->getOneOrNullResult();

        return $result;
    }
}
