<?php

namespace App\Repository;

use App\Dto\Media\MediaFilterDto;
use App\Entity\Media;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Media>
 */
class MediaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Media::class);
    }

    public function countAll(): int
    {
        return $this->createQueryBuilder('m')
            ->select('COUNT(m.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findPaginate(MediaFilterDto $filter): array
    {
        $query = $this->createQueryBuilder('m')
            ->setFirstResult(($filter->getPage() - 1) * $filter->getLimit())
            ->setMaxResults($filter->getLimit())
            ->orderBy('m.createdAt', 'DESC')
            ->getQuery()
            ->getResult();

        return [
            'items' => $query,
            'meta' => [
                'limit' => $filter->getLimit(),
                'total' => $this->countAll(),
                'page' => $filter->getPage(),
                'pages' => ceil($this->countAll() / $filter->getLimit()),
            ],
        ];
    }

    //    /**
//     * @return Media[] Returns an array of Media objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    //    public function findOneBySomeField($value): ?Media
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
