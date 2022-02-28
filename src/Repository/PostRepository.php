<?php


namespace App\Repository;


use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, string $entityClass = Post::class)
    {
        parent::__construct($registry, $entityClass);
    }

    public function getPostsPagination(int $page, int $maxResults = 3):Paginator
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->setFirstResult($page * $maxResults)
            ->setMaxResults($maxResults)
        ;
        return new Paginator($qb->getQuery());
    }
}