<?php
// src/AppBundle/Repository/CityRepository.php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CityRepository extends EntityRepository
{
    public function getCities($province)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT c FROM AppBundle:City c
            INNER JOIN AppBundle:Province p WITH c.province = p.id
            WHERE c.active = 1 AND p.active = 1 AND p.id = :province ORDER BY c.name ASC'
        );
        $query->setParameter('province', $province);
        $result = $query->getResult();

        return $result;
    }
}
