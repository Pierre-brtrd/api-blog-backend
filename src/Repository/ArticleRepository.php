<?php

namespace App\Repository;

use App\Dto\Article\ArticleFilterDto;
use App\Entity\Article;
use App\Entity\User;
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
            ->setMaxResults($filterDto->getLimit());

        if ($filterDto->getSort() && $filterDto->getOrder()) {
            $query->orderBy('a.' . $filterDto->getSort(), $filterDto->getOrder());
        } else {
            $query->orderBy('a.createdAt', 'DESC');
        }

        if ($filterDto->getSearch()) {
            $query->andWhere('a.title LIKE :search OR a.content LIKE :search')
                ->setParameter('search', '%' . $filterDto->getSearch() . '%');
        }

        if (!$includeDisabled) {
            $query->andWhere('a.enabled = :enabled')
                ->setParameter('enabled', true);
        }

        $query = $query
            ->getQuery()
            ->getResult();

        $total = $filterDto->getSearch() ? count($query) : $this->countAll($includeDisabled);

        return [
            'items' => $query,
            'meta' => [
                'page' => $filterDto->getPage(),
                'limit' => $filterDto->getLimit(),
                'total' => $total,
                'pages' => ceil($total / $filterDto->getLimit()),
            ],
        ];
    }

    public function findPaginateByUser(ArticleFilterDto $filterDto, User $user, bool $includeDisabled = true): array
    {
        $query = $this->createQueryBuilder('a')
            ->setFirstResult(($filterDto->getPage() - 1) * $filterDto->getLimit())
            ->setMaxResults($filterDto->getLimit())
            ->join('a.user', 'u', 'WITH', 'u.id = :userId')
            ->setParameter('userId', $user->getId());

        if ($filterDto->getSort() && $filterDto->getOrder()) {
            $query->orderBy('a.' . $filterDto->getSort(), $filterDto->getOrder());
        } else {
            $query->orderBy('a.createdAt', 'DESC');
        }

        if ($filterDto->getSearch()) {
            $query->andWhere('a.title LIKE :search OR a.content LIKE :search')
                ->setParameter('search', '%' . $filterDto->getSearch() . '%');
        }

        if (!$includeDisabled) {
            $query->andWhere('a.enabled = :enabled')
                ->setParameter('enabled', true);
        }

        $query = $query
            ->getQuery()
            ->getResult();

        $total = count($query);

        return [
            'items' => $query,
            'meta' => [
                'page' => $filterDto->getPage(),
                'limit' => $filterDto->getLimit(),
                'total' => $total,
                'pages' => ceil($total / $filterDto->getLimit()),
            ],
        ];
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
