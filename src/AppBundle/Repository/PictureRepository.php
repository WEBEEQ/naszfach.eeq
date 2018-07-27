<?php
// src/AppBundle/Repository/PictureRepository.php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PictureRepository extends EntityRepository
{
    public function getPictureList($firm)
    {
        $pictureList = array();
        $i = 0;

        $query = $this->getEntityManager()->createQuery(
            'SELECT p FROM AppBundle:Picture p
            INNER JOIN AppBundle:Firm f WITH p.firm = f.id
            WHERE p.active = 1 AND f.active = 1 AND f.visible = 1 AND p.firm = :firm
            ORDER BY p.dateAdded ASC'
        );
        $query->setParameter('firm', $firm);
        $result = $query->getResult();
        foreach ($result as $item) {
            $pictureList[$i]['id'] = $item->getId();
            $pictureList[$i]['name'] = $item->getName();
            $pictureList[$i]['file'] = $item->getFile();
            $pictureList[$i]['width'] = $item->getWidth();
            $pictureList[$i]['height'] = $item->getHeight();
            $i++;
        }

        return $pictureList;
    }
}
