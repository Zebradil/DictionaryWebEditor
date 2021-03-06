<?php
declare(strict_types=1);

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleRepository extends EntityRepository
{
    /**
     * Find articles by their name's part.
     *
     * @param string $q Query string
     * @return array The articles
     */
    public function findLikeTitle(string $q)
    {
        return $this->createQueryBuilder('o')
            ->where('LOWER(o.title) LIKE LOWER(:q)')
            ->setParameter('q', "$q%")
            ->getQuery()
            ->getResult();
    }
}
