<?php


namespace App\Repository;


use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

class PostRepository extends ServiceEntityRepository
{
    const POST_ORDER_DESC = 'DESC';
    const POST_ORDER_ASC = 'ASC';

    const POST_ORDER_ARRAY = [
        self::POST_ORDER_DESC,
        self::POST_ORDER_ASC,
    ];

    public function __construct(ManagerRegistry $registry, string $entityClass = Post::class)
    {
        parent::__construct($registry, $entityClass);
    }

    public function getPostsPagination(int $page, int $maxResults, string $order = self::POST_ORDER_ASC):Paginator
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->where('p.isActive = true')
            ->orderBy('p.id', $order)
            ->setFirstResult($page * $maxResults)
            ->setMaxResults($maxResults)
        ;
        return new Paginator($qb->getQuery());
    }
}