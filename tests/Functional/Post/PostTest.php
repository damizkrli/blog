<?php

namespace App\Tests\Functional\Post;

use App\Entity\Post\Post;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostTest extends WebTestCase
{
    public function testPagesWorks(): void
    {
        $client = static::createClient();

        /** @var $urlGeneratorInterface */
        $urlGeneratorInterface = $client->getContainer()->get('router');

        /** @var $entityManagerInterface */
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

        /** @var $postRepository */
        $postRepository = $entityManager->getRepository(Post::class);

        /** @var $post */
        $post = $postRepository->findOneBy([]);

        $client->request(
            Request::METHOD_GET,
            $urlGeneratorInterface->generate('post.show', ['slug' => $post->getSlug()])
        );

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->assertSelectorExists('h1');
        $this->assertSelectorTextContains('h1', ucfirst($post->getTitle()));
    }

    public function  testReturnToBlogWork(): void
    {
        $client = static::createClient();

        /** @var $urlGeneratorInterface */
        $urlGeneratorInterface = $client->getContainer()->get('router');

        /** @var $entityManagerInterface */
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

        /** @var $postRepository */
        $postRepository = $entityManager->getRepository(Post::class);

        /** @var $post */
        $post = $postRepository->findOneBy([]);

        $crawler = $client->request(
            Request::METHOD_GET,
            $urlGeneratorInterface->generate('post.show', ['slug' => $post->getSlug()])
        );

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $link = $crawler->selectLink('Retourner au blog')->link()->getUri();

        $crawler = $client->request(Request::METHOD_GET, $link);
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertRouteSame('post.index');

    }
}