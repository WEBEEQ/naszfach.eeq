<?php
// src/AppBundle/Repository/CategoryRepository.php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository
{
    public function getCategoryTitle($category)
    {
        $categoryTitle = '';

        if ($category >= 2) {
            $query = $this->getEntityManager()->createQuery(
                'SELECT c.name FROM AppBundle:Category c WHERE c.active = 1 AND c.id = :category'
            );
            $query->setParameter('category', $category);
            try {
                $categoryTitle = $query->getSingleScalarResult();
            } catch (\Doctrine\ORM\NoResultException $e) {
                $categoryTitle = '';
            }
        }

        return $categoryTitle;
    }

    public function getCategorySidebarList($category)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT c FROM AppBundle:Category c WHERE c.active = 1 AND c.category = :category ORDER BY c.name ASC'
        );
        $query->setParameter('category', $category);
        $result = $query->getResult();
        if (!$result) {
            $query = $this->getEntityManager()->createQuery(
                'SELECT c FROM AppBundle:Category c
                WHERE c.active = 1 AND c.category = (
                    SELECT (c2.category) FROM AppBundle:Category c2
                    WHERE c2.active = 1 AND c2.id = :category
                )
                ORDER BY c.name ASC'
            );
            $query->setParameter('category', $category);
            $result = $query->getResult();
        }

        return $result;
    }

    public function categoryNavigator($url, $category, $province, $city)
    {
        $categoryNavigator = '';
        $categoryNavigationList = array();

        while ($category >= 2) {
            $query = $this->getEntityManager()->createQuery(
                'SELECT c FROM AppBundle:Category c WHERE c.active = 1 AND c.id = :category'
            );
            $query->setParameter('category', $category);
            $result = $query->getOneOrNullResult();
            if ($result) {
                $categoryNavigationList[$result->getId()]['name'] = $result->getName();
                $category = $result->getCategory()->getId();
            } else {
                $category = 0;
            }
        }
        foreach (array_reverse($categoryNavigationList, true) as $key => $value) {
            $categoryNavigator .= ' &gt; <a href="' . $url . '/kategoria,' . $key
                . ',miejsce,' . $province . ',' . $city . '">' . $value['name'] . '</a>';
        }

        return $categoryNavigator;
    }
}
