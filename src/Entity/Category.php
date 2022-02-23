<?php


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity()]
#[ORM\Table(name:'categories')]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'parentCategory', targetEntity: Category::class)]
    private Collection $childCategories;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'childCategories')]
    #[ORM\JoinColumn(name: 'parent_id')]
    private ?Category $parentCategory = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Post::class)]
    private Collection $posts;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private ?string $name = null;

    #[Pure] public function __construct()
    {
        $this->childCategories = new ArrayCollection();
        $this->posts           = new ArrayCollection();
    }
}
