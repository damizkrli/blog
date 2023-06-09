<?php

namespace App\Controller\Blog;

use App\Entity\Post\Post;
use App\Repository\Post\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/', name: 'post.index', methods: ['GET'])]
    public function index(
        PostRepository $postRepository,
        Request $request
    ): Response
    {
        return $this->render('pages/blog/index.html.twig', [
            'posts' => $post = $postRepository->findPublished($request->query->getInt('page', 1)),
        ]);
    }

    #[Route('/article/{slug}', name: 'post.show', methods: ['GET'])]
    public function show(Post $post, PostRepository $postRepository): Response
    {
        return $this->render('pages/blog/show.html.twig', [
            'post' => $post,
        ]);
    }
}