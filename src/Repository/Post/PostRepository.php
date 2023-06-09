<?php

namespace App\Repository\Post;

use App\Entity\Post\Category;
use App\Entity\Post\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Post>
 *
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private readonly PaginatorInterface $paginator)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * Get published posts
     *
     * @param int $page
     * @param Category|null $category
     * @return PaginationInterface
     */
    public function findPublished(int $page, ?Category $category = null): PaginationInterface
    {
        $data = $this->createQueryBuilder('p')
            ->join('p.categories', 'c')
            ->where('p.state LIKE :state')
            ->setParameter('state', '%STATE_PUBLISHED%')
            ->addOrderBy('p.createdAt', 'DESC');

        if (isset($category)) {
            $data = $data
                ->andWhere(':category IN (c)')
                ->setParameter('category', $category);
        }

        $data->getQuery()->getResult();

        return $this->paginator->paginate($data, $page, 9);
    }
}