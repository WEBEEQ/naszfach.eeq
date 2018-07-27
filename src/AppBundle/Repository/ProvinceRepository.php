<?php
// src/AppBundle/Repository/ProvinceRepository.php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ProvinceRepository extends EntityRepository
{
    public function getPlaceTitle($province, $city)
    {
        $placeTitle = '';

        if ($city >= 1) {
            $query = $this->getEntityManager()->createQuery(
                'SELECT c.name FROM AppBundle:City c
                INNER JOIN AppBundle:Province p WITH c.province = p.id
                WHERE c.active = 1 AND p.active = 1 AND c.id = :city AND p.id = :province'
            );
            $query->setParameter('province', $province);
            $query->setParameter('city', $city);
            try {
                $placeTitle = $query->getSingleScalarResult();
            } catch (\Doctrine\ORM\NoResultException $e) {
                $placeTitle = '';
            }
        } elseif ($province >= 1) {
            $query = $this->getEntityManager()->createQuery(
                'SELECT p.name FROM AppBundle:Province p WHERE p.active = 1 AND p.id = :province'
            );
            $query->setParameter('province', $province);
            try {
                $placeTitle = $query->getSingleScalarResult();
            } catch (\Doctrine\ORM\NoResultException $e) {
                $placeTitle = '';
            }
        }

        return $placeTitle;
    }

    public function getPlaceSidebarList($province, &$isProvince)
    {
        if ($province < 1) {
            $query = $this->getEntityManager()->createQuery(
                'SELECT p FROM AppBundle:Province p WHERE p.active = 1 ORDER BY p.name ASC'
            );
            $result = $query->getResult();
            $isProvince = true;
        } else {
            $query = $this->getEntityManager()->createQuery(
                'SELECT c FROM AppBundle:City c
                INNER JOIN AppBundle:Province p WITH c.province = p.id
                WHERE c.active = 1 AND p.active = 1 AND c.province = :province
                ORDER BY c.name ASC'
            );
            $query->setParameter('province', $province);
            $result = $query->getResult();
            $isProvince = false;
            if (!$result) {
                $query = $this->getEntityManager()->createQuery(
                    'SELECT p FROM AppBundle:Province p WHERE p.active = 1 ORDER BY p.name ASC'
                );
                $result = $query->getResult();
                $isProvince = true;
            }
        }

        return $result;
    }

    public function getProvinces()
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT p FROM AppBundle:Province p WHERE p.active = 1 ORDER BY p.name ASC'
        );
        $result = $query->getResult();

        return $result;
    }
}
