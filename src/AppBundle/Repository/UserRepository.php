<?php
// src/AppBundle/Repository/UserRepository.php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function generatePassword()
    {
        $password = '';

        for ($i = 0; $i < 8; $i++) {
            if (rand(0, 2) != 0) {
                $j = rand(0, 25);
                $password .= substr('abcdefghijklmnopqrstuvwxyz', $j, 1);
            } else {
                $password .= rand(0, 9);
            }
        }

        return $password;
    }

    public function isUserLogin($login)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT u FROM AppBundle:User u WHERE u.login = :login'
        );
        $query->setParameter('login', $login);
        $result = $query->getOneOrNullResult();

        return $result;
    }

    public function setUserPassword($id, $password, $ip, $date)
    {
        $query = $this->getEntityManager()->createQuery(
            'UPDATE AppBundle:User u
            SET u.password = :password, u.key = :key, u.ipUpdated = :ip, u.dateUpdated = :date
            WHERE u.id = :id'
        );
        $query->setParameter('id', $id);
        $query->setParameter('password', md5($password));
        $query->setParameter('key', md5(date('Y-m-d H:i:s') . $password));
        $query->setParameter('ip', $ip);
        $query->setParameter('date', $date);
        $result = $query->getOneOrNullResult();

        return $result;
    }

    public function isUserPassword($login, $password)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT u FROM AppBundle:User u WHERE u.login = :login AND u.password = :password'
        );
        $query->setParameter('login', $login);
        $query->setParameter('password', md5($password));
        $result = $query->getOneOrNullResult();

        return $result;
    }

    public function setUserActive($id)
    {
        $query = $this->getEntityManager()->createQuery(
            'UPDATE AppBundle:User u SET u.active = 1 WHERE u.id = :id'
        );
        $query->setParameter('id', $id);
        $result = $query->getOneOrNullResult();

        return $result;
    }

    public function setUserLoged($id, $ip, $date)
    {
        $query = $this->getEntityManager()->createQuery(
            'UPDATE AppBundle:User u SET u.ipLoged = :ip, u.dateLoged = :date WHERE u.id = :id'
        );
        $query->setParameter('id', $id);
        $query->setParameter('ip', $ip);
        $query->setParameter('date', $date);
        $result = $query->getOneOrNullResult();

        return $result;
    }
}
