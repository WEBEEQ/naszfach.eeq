<?php
// src/AppBundle/Repository/FirmRepository.php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class FirmRepository extends EntityRepository
{
    public function getFirmTopList($comment, $listLimit)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT f FROM AppBundle:Firm f
            INNER JOIN AppBundle:User u WITH f.user = u.id
            WHERE u.active = 1 AND f.active = 1 AND f.visible = 1 AND f.order = 1 AND f.commentNumber >= :comment
            ORDER BY f.markPrecision DESC, f.commentNumber DESC, f.dateAdded DESC'
        );
        $query->setParameter('comment', $comment);
        $query->setFirstResult(0);
        $query->setMaxResults($listLimit);
        $result = $query->getResult();

        return $result;
    }

    public function getFirmNewList($listLimit)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT f FROM AppBundle:Firm f
            INNER JOIN AppBundle:User u WITH f.user = u.id
            WHERE u.active = 1 AND f.active = 1 AND f.visible = 1
            ORDER BY f.dateAdded DESC'
        );
        $query->setFirstResult(0);
        $query->setMaxResults($listLimit);
        $result = $query->getResult();

        return $result;
    }

    public function getFirmList(
        $category,
        $province,
        $city,
        $sort,
        $descend,
        $order,
        $comment,
        $level,
        $listLimit
    ) {
        $categoryJoin = ($category < 2) ? '' : 'INNER JOIN AppBundle:FirmCategory fc WITH f.id = fc.firm
                                               INNER JOIN AppBundle:Category c WITH fc.category = c.id ';
        $provinceJoin = ($province < 1) ? '' : 'INNER JOIN AppBundle:Province p WITH f.province = p.id ';
        $cityJoin = ($city < 1) ? '' : 'INNER JOIN AppBundle:City ci WITH f.city = ci.id ';
        $categoryActive = ($category < 2) ? '' : 'fc.active = 1 AND c.active = 1 AND ';
        $provinceActive = ($province < 1) ? '' : 'p.active = 1 AND ';
        $cityActive = ($city < 1) ? '' : 'ci.active = 1 AND ';
        $categoryId = ($category >= 2) ? ' AND c.id = :category' : ' AND :category = :category';
        $provinceId = ($province >= 1) ? ' AND p.id = :province' : ' AND :province = :province';
        $cityId = ($city >= 1) ? ' AND ci.id = :city' : ' AND :city = :city';
        $descend = ($descend == 0) ? 'ASC' : 'DESC';
        $orderBy = ($sort == 0) ? 'f.name ' . $descend . ', ' : '';
        $orderBy = ($sort == 1) ? 'f.markPrecision ' . $descend . ', ' : $orderBy;
        $orderBy = ($sort == 2) ? 'f.markContact ' . $descend . ', ' : $orderBy;
        $orderBy = ($sort == 3) ? 'f.markTime ' . $descend . ', ' : $orderBy;
        $orderBy = ($sort == 4) ? 'f.markPrice ' . $descend . ', ' : $orderBy;

        $query = $this->getEntityManager()->createQuery(
            'SELECT f FROM AppBundle:Firm f
            INNER JOIN AppBundle:User u WITH f.user = u.id ' . $categoryJoin . $provinceJoin . $cityJoin .
            'WHERE u.active = 1 AND ' . $categoryActive . $provinceActive . $cityActive . 'f.active = 1
                AND f.visible = 1 AND f.order = :order AND f.commentNumber >= :comment'
                . $categoryId . $provinceId . $cityId .
            ' ORDER BY ' . $orderBy . 'f.commentNumber ' . $descend . ', f.dateAdded ' . $descend
        );
        $query->setParameter('category', $category);
        $query->setParameter('province', $province);
        $query->setParameter('city', $city);
        $query->setParameter('order', $order);
        $query->setParameter('comment', $comment);
        $query->setFirstResult(($level - 1) * $listLimit);
        $query->setMaxResults($listLimit);
        $result = $query->getResult();

        return $result;
    }

    public function pageNavigator(
        $url,
        $category,
        $province,
        $city,
        $sort,
        $descend,
        $order,
        $comment,
        $level,
        $listLimit
    ) {
        $pageNavigator = '';
        $levelLimit = 5;
        $count = false;
        $categoryJoin = ($category < 2) ? '' : 'INNER JOIN AppBundle:FirmCategory fc WITH f.id = fc.firm
                                               INNER JOIN AppBundle:Category c WITH fc.category = c.id ';
        $provinceJoin = ($province < 1) ? '' : 'INNER JOIN AppBundle:Province p WITH f.province = p.id ';
        $cityJoin = ($city < 1) ? '' : 'INNER JOIN AppBundle:City ci WITH f.city = ci.id ';
        $categoryActive = ($category < 2) ? '' : 'fc.active = 1 AND c.active = 1 AND ';
        $provinceActive = ($province < 1) ? '' : 'p.active = 1 AND ';
        $cityActive = ($city < 1) ? '' : 'ci.active = 1 AND ';
        $categoryId = ($category >= 2) ? ' AND c.id = :category' : ' AND :category = :category';
        $provinceId = ($province >= 1) ? ' AND p.id = :province' : ' AND :province = :province';
        $cityId = ($city >= 1) ? ' AND ci.id = :city' : ' AND :city = :city';

        $query = $this->getEntityManager()->createQuery(
            'SELECT COUNT(f.id) AS total FROM AppBundle:Firm f
            INNER JOIN AppBundle:User u WITH f.user = u.id ' . $categoryJoin . $provinceJoin . $cityJoin .
            'WHERE u.active = 1 AND ' . $categoryActive . $provinceActive . $cityActive . 'f.active = 1
                AND f.visible = 1 AND f.order = :order AND f.commentNumber >= :comment'
                . $categoryId . $provinceId . $cityId
        );
        $query->setParameter('category', $category);
        $query->setParameter('province', $province);
        $query->setParameter('city', $city);
        $query->setParameter('order', $order);
        $query->setParameter('comment', $comment);
        try {
            $count = $query->getSingleScalarResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            $count = false;
        }

        if (is_numeric($count) && $count > $listLimit) {
            $minLevel = 1;
            $maxLevel = number_format($count / $listLimit, 0, '.', '');
            $levelCondition = number_format($count / $listLimit, 2, '.', '') > $maxLevel;
            $maxLevel = ($levelCondition) ? $maxLevel + 1 : $maxLevel;
            $fromLevel = ($level - $levelLimit < $minLevel) ? $minLevel : $level - $levelLimit;
            $toLevel = ($level + $levelLimit > $maxLevel) ? $maxLevel : $level + $levelLimit;
            $previousLevel = $level - 1;
            $nextLevel = $level + 1;
            if ($maxLevel > $levelLimit) {
                $pageNavigator .= ($level > $minLevel) ? '<a href="' . $url . '/kategoria,'
                    . $category . ',miejsce,' . $province . ',' . $city . ',sortowanie,'
                    . $sort . ',' . $descend . ',zlecenia,' . $order . ',komentarze,'
                    . $comment . ',strona,' . $minLevel . '">...</a>' : '';
            }
            $pageNavigator .= ($level > $minLevel) ? '<a href="' . $url . '/kategoria,'
                . $category . ',miejsce,' . $province . ',' . $city . ',sortowanie,'
                . $sort . ',' . $descend . ',zlecenia,' . $order . ',komentarze,'
                . $comment . ',strona,' . $previousLevel . '">&nbsp;&laquo&nbsp;</a>' : '';
            for ($i = $fromLevel; $i <= $toLevel; $i++) {
                $pageNavigator .= ($i != $level) ? '<a href="' . $url . '/kategoria,'
                    . $category . ',miejsce,' . $province . ',' . $city . ',sortowanie,'
                    . $sort . ',' . $descend . ',zlecenia,' . $order . ',komentarze,'
                    . $comment . ',strona,' . $i . '">&nbsp;' . $i . '&nbsp;</a>' : '[' . $i . ']';
            }
            $pageNavigator .= ($level < $maxLevel) ? '<a href="' . $url . '/kategoria,'
                . $category . ',miejsce,' . $province . ',' . $city . ',sortowanie,'
                . $sort . ',' . $descend . ',zlecenia,' . $order . ',komentarze,'
                . $comment . ',strona,' . $nextLevel . '">&nbsp;&raquo;&nbsp;</a>' : '';
            if ($maxLevel > $levelLimit) {
                $pageNavigator .= ($level < $maxLevel) ? '<a href="' . $url . '/kategoria,'
                    . $category . ',miejsce,' . $province . ',' . $city . ',sortowanie,'
                    . $sort . ',' . $descend . ',zlecenia,' . $order . ',komentarze,'
                    . $comment . ',strona,' . $maxLevel . '">...</a>' : '';
            }
        }

        return $pageNavigator;
    }

    public function updateFirmComment($firm, $date7Days, $date30Days, $date)
    {
        $query = $this->getEntityManager()->createQuery(
            'UPDATE AppBundle:Firm f
            SET f.markPrecision = (
                    SELECT COALESCE(AVG(m.value),0) FROM AppBundle:Mark m
                    WHERE m.active = 1 AND m.markType = 1 AND m.firm = :firm
                ),
                f.markContact = (
                    SELECT COALESCE(AVG(m2.value),0) FROM AppBundle:Mark m2
                    WHERE m2.active = 1 AND m2.markType = 2 AND m2.firm = :firm
                ),
                f.markTime = (
                    SELECT COALESCE(AVG(m3.value),0) FROM AppBundle:Mark m3
                    WHERE m3.active = 1 AND m3.markType = 3 AND m3.firm = :firm
                ),
                f.markPrice = (
                    SELECT COALESCE(AVG(m4.value),0) FROM AppBundle:Mark m4
                    WHERE m4.active = 1 AND m4.markType = 4 AND m4.firm = :firm
                ),
                f.commentNumber = (
                    SELECT COUNT(c.id) FROM AppBundle:Comment c
                    WHERE c.active = 1 AND c.userComment = 1 AND c.firm = :firm
                ),
                f.commentPositive7Days = (
                    SELECT COUNT(c2.id) FROM AppBundle:Comment c2
                    WHERE c2.active = 1 AND c2.userComment = 1 AND c2.dateAdded >= :date7Days
                        AND c2.commentType = 1 AND c2.firm = :firm
                ),
                f.commentNeutral7Days = (
                    SELECT COUNT(c3.id) FROM AppBundle:Comment c3
                    WHERE c3.active = 1 AND c3.userComment = 1 AND c3.dateAdded >= :date7Days
                        AND c3.commentType = 2 AND c3.firm = :firm
                ),
                f.commentNegative7Days = (
                    SELECT COUNT(c4.id) FROM AppBundle:Comment c4
                    WHERE c4.active = 1 AND c4.userComment = 1 AND c4.dateAdded >= :date7Days
                        AND c4.commentType = 3 AND c4.firm = :firm
                ),
                f.commentPositive30Days = (
                    SELECT COUNT(c5.id) FROM AppBundle:Comment c5
                    WHERE c5.active = 1 AND c5.userComment = 1 AND c5.dateAdded >= :date30Days
                        AND c5.commentType = 1 AND c5.firm = :firm
                ),
                f.commentNeutral30Days = (
                    SELECT COUNT(c6.id) FROM AppBundle:Comment c6
                    WHERE c6.active = 1 AND c6.userComment = 1 AND c6.dateAdded >= :date30Days
                        AND c6.commentType = 2 AND c6.firm = :firm
                ),
                f.commentNegative30Days = (
                    SELECT COUNT(c7.id) FROM AppBundle:Comment c7
                    WHERE c7.active = 1 AND c7.userComment = 1 AND c7.dateAdded >= :date30Days
                        AND c7.commentType = 3 AND c7.firm = :firm
                ),
                f.commentPositiveAllDays = (
                    SELECT COUNT(c8.id) FROM AppBundle:Comment c8
                    WHERE c8.active = 1 AND c8.userComment = 1 AND c8.commentType = 1 AND c8.firm = :firm
                ),
                f.commentNeutralAllDays = (
                    SELECT COUNT(c9.id) FROM AppBundle:Comment c9
                    WHERE c9.active = 1 AND c9.userComment = 1 AND c9.commentType = 2 AND c9.firm = :firm
                ),
                f.commentNegativeAllDays = (
                    SELECT COUNT(c10.id) FROM AppBundle:Comment c10
                    WHERE c10.active = 1 AND c10.userComment = 1 AND c10.commentType = 3 AND c10.firm = :firm
                ),
                f.commentDate = :date
            WHERE f.active = 1 AND f.visible = 1 AND f.id = :firm'
        );
        $query->setParameter('firm', $firm);
        $query->setParameter('date7Days', $date7Days);
        $query->setParameter('date30Days', $date30Days);
        $query->setParameter('date', $date);
        $result = $query->getOneOrNullResult();

        return $result;
    }

    public function getFirmData($firm)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT p.id AS provinceId, p.name AS provinceName, c.id AS cityId,
                c.name AS cityName, f.id, f.order, f.name, f.email, f.url, f.phone,
                f.street, f.postcode, f.description, f.markPrecision, f.markContact,
                f.markTime, f.markPrice, f.commentPositive7Days, f.commentNeutral7Days,
                f.commentNegative7Days, f.commentPositive30Days, f.commentNeutral30Days,
                f.commentNegative30Days, f.commentPositiveAllDays, f.commentNeutralAllDays,
                f.commentNegativeAllDays, f.commentDate
            FROM AppBundle:Firm f
            LEFT JOIN AppBundle:Province p WITH f.province = p.id
            LEFT JOIN AppBundle:City c WITH f.city = c.id
            WHERE f.active = 1 AND f.visible = 1 AND f.id = :firm'
        );
        $query->setParameter('firm', $firm);
        try {
            $result = $query->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            $result = array(
                'provinceId' => 0,
                'provinceName' => '',
                'cityId' => 0,
                'cityName' => '',
                'id' => 0,
                'order' => 0,
                'name' => '',
                'email' => '',
                'url' => '',
                'phone' => '',
                'street' => '',
                'postcode' => '',
                'description' => '',
                'markPrecision' => 0,
                'markContact' => 0,
                'markTime' => 0,
                'markPrice' => 0,
                'commentPositive7Days' => 0,
                'commentNeutral7Days' => 0,
                'commentNegative7Days' => 0,
                'commentPositive30Days' => 0,
                'commentNeutral30Days' => 0,
                'commentNegative30Days' => 0,
                'commentPositiveAllDays' => 0,
                'commentNeutralAllDays' => 0,
                'commentNegativeAllDays' => 0,
                'commentDate' => ''
            );
        }

        return $result;
    }

    public function getCategoryList($firm)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT c FROM AppBundle:Category c
            INNER JOIN AppBundle:FirmCategory fc WITH c.id = fc.category
            INNER JOIN AppBundle:Firm f WITH fc.firm = f.id
            WHERE fc.active = 1 AND f.active = 1 AND f.visible = 1 AND fc.firm = :firm
            ORDER BY c.name ASC'
        );
        $query->setParameter('firm', $firm);
        $result = $query->getResult();

        return $result;
    }

    public function getPictureList($firm)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT p FROM AppBundle:Picture p
            INNER JOIN AppBundle:Firm f WITH p.firm = f.id
            WHERE p.active = 1 AND f.active = 1 AND f.visible = 1 AND p.firm = :firm
            ORDER BY p.dateAdded ASC'
        );
        $query->setParameter('firm', $firm);
        $result = $query->getResult();

        return $result;
    }

    public function getCommentTypeList()
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT ct FROM AppBundle:CommentType ct WHERE ct.active = 1 ORDER BY ct.id ASC'
        );
        $result = $query->getResult();

        return $result;
    }

    public function getCommentList($firm, $type, $level, $listLimit)
    {
        $commentTypeId = ($type >= 1) ? ' AND c.commentType = :type' : ' AND :type = :type';

        $query = $this->getEntityManager()->createQuery(
            'SELECT c.id AS commentId, c.text AS commentText, c.dateAdded AS commentDateAdded,
                ct.id AS commentTypeId, ct.name AS commentTypeName, u.name AS userName,
                u.surname AS userSurname, u.commentNumber AS userCommentNumber, (c.order) AS orderId
            FROM AppBundle:Comment c
            INNER JOIN AppBundle:CommentType ct WITH c.commentType = ct.id
            INNER JOIN AppBundle:User u WITH c.user = u.id
            INNER JOIN AppBundle:Firm f WITH c.firm = f.id
            WHERE c.active = 1 AND c.userComment = 1 AND f.active = 1 AND f.visible = 1
                AND c.firm = :firm' . $commentTypeId .
            ' ORDER BY c.dateAdded DESC'
        );
        $query->setParameter('firm', $firm);
        $query->setParameter('type', $type);
        $query->setFirstResult(($level - 1) * $listLimit);
        $query->setMaxResults($listLimit);
        $result = $query->getResult();

        return $result;
    }

    public function commentListNavigator($url, $firm, $type, $level, $listLimit)
    {
        $pageNavigator = '';
        $levelLimit = 5;
        $count = false;
        $commentTypeId = ($type >= 1) ? ' AND c.commentType = :type' : ' AND :type = :type';

        $query = $this->getEntityManager()->createQuery(
            'SELECT COUNT(c.id) AS total FROM AppBundle:Comment c
            INNER JOIN AppBundle:CommentType ct WITH c.commentType = ct.id
            INNER JOIN AppBundle:User u WITH c.user = u.id
            INNER JOIN AppBundle:Firm f WITH c.firm = f.id
            WHERE c.active = 1 AND c.userComment = 1 AND f.active = 1 AND f.visible = 1
                AND c.firm = :firm' . $commentTypeId
        );
        $query->setParameter('firm', $firm);
        $query->setParameter('type', $type);
        try {
            $count = $query->getSingleScalarResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            $count = false;
        }

        if (is_numeric($count) && $count > $listLimit) {
            $minLevel = 1;
            $maxLevel = number_format($count / $listLimit, 0, '.', '');
            $levelCondition = number_format($count / $listLimit, 2, '.', '') > $maxLevel;
            $maxLevel = ($levelCondition) ? $maxLevel + 1 : $maxLevel;
            $fromLevel = ($level - $levelLimit < $minLevel) ? $minLevel : $level - $levelLimit;
            $toLevel = ($level + $levelLimit > $maxLevel) ? $maxLevel : $level + $levelLimit;
            $previousLevel = $level - 1;
            $nextLevel = $level + 1;
            if ($maxLevel > $levelLimit) {
                $pageNavigator .= ($level > $minLevel) ? '<a href="' . $url . '/firma,'
                    . $firm . ',typ,' . $type . ',strona,' . $minLevel . '">...</a>' : '';
            }
            $pageNavigator .= ($level > $minLevel) ? '<a href="' . $url . '/firma,'
                . $firm . ',typ,' . $type . ',strona,' . $previousLevel . '">&nbsp;&laquo&nbsp;</a>' : '';
            for ($i = $fromLevel; $i <= $toLevel; $i++) {
                $pageNavigator .= ($i != $level) ? '<a href="' . $url . '/firma,'
                    . $firm . ',typ,' . $type . ',strona,' . $i . '">&nbsp;' . $i . '&nbsp;</a>' : '[' . $i . ']';
            }
            $pageNavigator .= ($level < $maxLevel) ? '<a href="' . $url . '/firma,'
                . $firm . ',typ,' . $type . ',strona,' . $nextLevel . '">&nbsp;&raquo;&nbsp;</a>' : '';
            if ($maxLevel > $levelLimit) {
                $pageNavigator .= ($level < $maxLevel) ? '<a href="' . $url . '/firma,'
                    . $firm . ',typ,' . $type . ',strona,' . $maxLevel . '">...</a>' : '';
            }
        }

        return $pageNavigator;
    }

    public function getCommentData($order)
    {
        if ($order >= 1) {
            $query = $this->getEntityManager()->createQuery(
                'SELECT c.text AS commentText, c.dateAdded AS commentDateAdded, ct.name AS commentTypeName
                FROM AppBundle:Comment c
                INNER JOIN AppBundle:CommentType ct WITH c.commentType = ct.id
                WHERE c.active = 1 AND c.userComment = 0 AND c.order = :order'
            );
            $query->setParameter('order', $order);
            $result = $query->getOneOrNullResult();

            return $result;
        }

        return null;
    }

    public function getSearchList(
        $name,
        $street,
        $postcode,
        $province,
        $city,
        $sort,
        $descend,
        $order,
        $comment,
        $level,
        $listLimit
    ) {
        $provinceJoin = ($province < 1) ? '' : 'INNER JOIN AppBundle:Province p WITH f.province = p.id ';
        $cityJoin = ($city < 1) ? '' : 'INNER JOIN AppBundle:City ci WITH f.city = ci.id ';
        $provinceActive = ($province < 1) ? '' : 'p.active = 1 AND ';
        $cityActive = ($city < 1) ? '' : 'ci.active = 1 AND ';
        $provinceId = ($province >= 1) ? ' AND p.id = :province' : ' AND :province = :province';
        $cityId = ($city >= 1) ? ' AND ci.id = :city' : ' AND :city = :city';
        $firmName = ($name != '') ? ' AND f.name LIKE :name' : ' AND :name = :name';
        $firmStreet = ($street != '') ? ' AND f.street LIKE :street' : ' AND :street = :street';
        $firmPostcode = ($postcode != '') ? ' AND f.postcode LIKE :postcode' : ' AND :postcode = :postcode';
        $descend = ($descend == 0) ? 'ASC' : 'DESC';
        $orderBy = ($sort == 0) ? 'f.name ' . $descend . ', ' : '';
        $orderBy = ($sort == 1) ? 'f.markPrecision ' . $descend . ', ' : $orderBy;
        $orderBy = ($sort == 2) ? 'f.markContact ' . $descend . ', ' : $orderBy;
        $orderBy = ($sort == 3) ? 'f.markTime ' . $descend . ', ' : $orderBy;
        $orderBy = ($sort == 4) ? 'f.markPrice ' . $descend . ', ' : $orderBy;

        $query = $this->getEntityManager()->createQuery(
            'SELECT f FROM AppBundle:Firm f
            INNER JOIN AppBundle:User u WITH f.user = u.id ' . $provinceJoin . $cityJoin . 
            'WHERE u.active = 1 AND ' . $provinceActive . $cityActive . 'f.active = 1 AND f.visible = 1
                AND f.order = :order AND f.commentNumber >= :comment' . $provinceId . $cityId
                . $firmName . $firmStreet . $firmPostcode .
            ' ORDER BY ' . $orderBy . 'f.commentNumber ' . $descend . ', f.dateAdded ' . $descend
        );
        $query->setParameter('name', "%$name%");
        $query->setParameter('street', "%$street%");
        $query->setParameter('postcode', "%$postcode%");
        $query->setParameter('province', $province);
        $query->setParameter('city', $city);
        $query->setParameter('order', $order);
        $query->setParameter('comment', $comment);
        $query->setFirstResult(($level - 1) * $listLimit);
        $query->setMaxResults($listLimit);
        $result = $query->getResult();

        return $result;
    }

    public function searchNavigator(
        $url,
        $name,
        $street,
        $postcode,
        $province,
        $city,
        $sort,
        $descend,
        $order,
        $comment,
        $level,
        $listLimit
    ) {
        $pageNavigator = '';
        $levelLimit = 5;
        $count = false;
        $provinceJoin = ($province < 1) ? '' : 'INNER JOIN AppBundle:Province p WITH f.province = p.id ';
        $cityJoin = ($city < 1) ? '' : 'INNER JOIN AppBundle:City ci WITH f.city = ci.id ';
        $provinceActive = ($province < 1) ? '' : 'p.active = 1 AND ';
        $cityActive = ($city < 1) ? '' : 'ci.active = 1 AND ';
        $provinceId = ($province >= 1) ? ' AND p.id = :province' : ' AND :province = :province';
        $cityId = ($city >= 1) ? ' AND ci.id = :city' : ' AND :city = :city';
        $firmName = ($name != '') ? ' AND f.name LIKE :name' : ' AND :name = :name';
        $firmStreet = ($street != '') ? ' AND f.street LIKE :street' : ' AND :street = :street';
        $firmPostcode = ($postcode != '') ? ' AND f.postcode LIKE :postcode' : ' AND :postcode = :postcode';

        $query = $this->getEntityManager()->createQuery(
            'SELECT COUNT(f.id) AS total FROM AppBundle:Firm f
            INNER JOIN AppBundle:User u WITH f.user = u.id ' . $provinceJoin . $cityJoin .
            'WHERE u.active = 1 AND ' . $provinceActive . $cityActive . 'f.active = 1 AND f.visible = 1
                AND f.order = :order AND f.commentNumber >= :comment' . $provinceId . $cityId
                . $firmName . $firmStreet . $firmPostcode
        );
        $query->setParameter('name', "%$name%");
        $query->setParameter('street', "%$street%");
        $query->setParameter('postcode', "%$postcode%");
        $query->setParameter('province', $province);
        $query->setParameter('city', $city);
        $query->setParameter('order', $order);
        $query->setParameter('comment', $comment);
        try {
            $count = $query->getSingleScalarResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            $count = false;
        }

        if (is_numeric($count) && $count > $listLimit) {
            $minLevel = 1;
            $maxLevel = number_format($count / $listLimit, 0, '.', '');
            $levelCondition = number_format($count / $listLimit, 2, '.', '') > $maxLevel;
            $maxLevel = ($levelCondition) ? $maxLevel + 1 : $maxLevel;
            $fromLevel = ($level - $levelLimit < $minLevel) ? $minLevel : $level - $levelLimit;
            $toLevel = ($level + $levelLimit > $maxLevel) ? $maxLevel : $level + $levelLimit;
            $previousLevel = $level - 1;
            $nextLevel = $level + 1;
            if ($maxLevel > $levelLimit) {
                $pageNavigator .= ($level > $minLevel) ? '<a href="' . $url . '/szukanie,1,firma,'
                    . $name . ',ulica,' . $street . ',kod,' . $postcode . ',miejsce,' . $province
                    . ',' . $city . ',sortowanie,' . $sort . ',' . $descend . ',zlecenia,'
                    . $order . ',komentarze,' . $comment . ',strona,' . $minLevel . '">...</a>' : '';
            }
            $pageNavigator .= ($level > $minLevel) ? '<a href="' . $url . '/szukanie,1,firma,'
                . $name . ',ulica,' . $street . ',kod,' . $postcode . ',miejsce,' . $province
                . ',' . $city . ',sortowanie,' . $sort . ',' . $descend . ',zlecenia,'
                . $order . ',komentarze,' . $comment . ',strona,' . $previousLevel . '">&nbsp;&laquo&nbsp;</a>' : '';
            for ($i = $fromLevel; $i <= $toLevel; $i++) {
                $pageNavigator .= ($i != $level) ? '<a href="' . $url . '/szukanie,1,firma,'
                    . $name . ',ulica,' . $street . ',kod,' . $postcode . ',miejsce,' . $province
                    . ',' . $city . ',sortowanie,' . $sort . ',' . $descend . ',zlecenia,'
                    . $order . ',komentarze,' . $comment . ',strona,' . $i . '">&nbsp;'
                    . $i . '&nbsp;</a>' : '[' . $i . ']';
            }
            $pageNavigator .= ($level < $maxLevel) ? '<a href="' . $url . '/szukanie,1,firma,'
                . $name . ',ulica,' . $street . ',kod,' . $postcode . ',miejsce,' . $province
                . ',' . $city . ',sortowanie,' . $sort . ',' . $descend . ',zlecenia,'
                . $order . ',komentarze,' . $comment . ',strona,' . $nextLevel . '">&nbsp;&raquo;&nbsp;</a>' : '';
            if ($maxLevel > $levelLimit) {
                $pageNavigator .= ($level < $maxLevel) ? '<a href="' . $url . '/szukanie,1,firma,'
                    . $name . ',ulica,' . $street . ',kod,' . $postcode . ',miejsce,' . $province
                    . ',' . $city . ',sortowanie,' . $sort . ',' . $descend . ',zlecenia,'
                    . $order . ',komentarze,' . $comment . ',strona,' . $maxLevel . '">...</a>' : '';
            }
        }

        return $pageNavigator;
    }
}
