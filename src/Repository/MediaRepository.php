<?php

namespace App\Repository;

use App\Entity\Media;
use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Common\Collections\Collection;

/**
 * @extends ServiceEntityRepository<Media>
 */
class MediaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Media::class);
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
public function findTendances(int $maxResults): array
{
    return $this->createQueryBuilder('m')
        ->leftJoin('m.watchHistories', 'wh')
        ->groupBy('m.id')
        ->orderBy('COUNT(wh)', 'DESC')
        ->setMaxResults($maxResults)
        ->getQuery()
        ->getResult();
}

public function findRecommandationBySerieAndScore(int $maxResults): array
{
    return $this->createQueryBuilder('m')
        ->where('m.score >= :score')  
        ->andWhere('m INSTANCE OF App\Entity\Serie') 
        ->setParameter('score', 7.0)  
        ->orderBy('m.score', 'DESC')  
        ->setMaxResults($maxResults)  
        ->getQuery()
        ->getResult();  
}
public function findRecommandationByMovieAndScore(int $maxResults): array
{
    return $this->createQueryBuilder('m')
        ->where('m.score >= :score')  
        ->andWhere('m INSTANCE OF App\Entity\Movie') 
        ->setParameter('score', 7.0)  
        ->orderBy('m.score', 'DESC')  
        ->setMaxResults($maxResults)  
        ->getQuery()
        ->getResult();  
}

public function findByCategory(Category $category): array
{
    return $this->createQueryBuilder('m')
        ->join('m.categories', 'c')  
        ->where('c = :category')    
        ->setParameter('category', $category)
        ->andWhere('m INSTANCE OF App\Entity\Movie')  
        ->orWhere('m INSTANCE OF App\Entity\Serie')  
        ->orderBy('m.id', 'ASC') 
        ->getQuery()
        ->getResult();
}



}