<?php

namespace App\Controller\Blog;

use App\Repository\Post\PostRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\Paginator;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/', name: 'post.index', methods: ['GET'])]
    public function index(
        PostRepository $postRepository,
        PaginatorInterface $pagination,
        Request $request
    ): Response
    {
        $data = $postRepository->findPublished();
        $post = $pagination->paginate(
            $data,
            $request->query->getInt('page', 1),
            9
        );

        return $this->render('pages/blog/index.html.twig', [
            'posts' => $post
        ]);
    }    
}