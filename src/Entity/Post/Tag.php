<?php

namespace App\Entity\Post;

use App\Repository\Post\TagRepository;
use App\Trait\CategoryTagTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: TagRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(
    'slug',
    message: 'Ce slug existe déjà.'
)]
class Tag
{
    use CategoryTagTrait;

    #[ORM\ManyToMany(targetEntity: Post::class, inversedBy: 'tags')]
    #[JoinTable(name: 'tag_posts')]
    private Collection $posts;

    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        $this->posts->removeElement($post);

        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->name;
    }
}
