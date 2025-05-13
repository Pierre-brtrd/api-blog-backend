<?php

namespace App\Repository;

use App\Dto\Article\ArticleFilterDto;
use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function countAll(bool $includeDisabled = true): int
    {
        $query = $this->createQueryBuilder('a');

        if (!$includeDisabled) {
            $query->andWhere('a.enabled = :enabled')
                ->setParameter('enabled', true);
        }

        return (int) $query
            ->select('COUNT(a.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findPaginate(ArticleFilterDto $filterDto, bool $includeDisabled = true): array
    {
        $query = $this->createQueryBuilder('a')
            ->setFirstResult(($filterDto->getPage() - 1) * $filterDto->getLimit())
            ->setMaxResults($filterDto->getLimit())
            ->orderBy('a.createdAt', 'DESC');

        if (!$includeDisabled) {
            $query->andWhere('a.enabled = :enabled')
                ->setParameter('enabled', true);
        }

        return $query
            ->getQuery()
            ->getResult();
    }

    //    /**
//     * @return Article[] Returns an array of Article objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    //    public function findOneBySomeField($value): ?Article
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
