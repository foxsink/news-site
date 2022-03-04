<?php


namespace App\Repository;


use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

class CategoryRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry, string $entityClass = Category::class)
    {
        parent::__construct($registry, $entityClass);
    }

    /**
     * @return Category[]
     */
    public function getCategoriesWithPosts(): array
    {
        $qb = $this->createQueryBuilder('c');
        $qb
            ->distinct()
            ->leftJoin('c.posts', 'p')
            ->where('p.isActive = true')
            ->orderBy('c.id', 'ASC')
        ;
        return $qb->getQuery()->getResult();
    }
}