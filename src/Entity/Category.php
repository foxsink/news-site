<?php


namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\Persistence\Event\PreUpdateEventArgs;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\Table(name:'categories')]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
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

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Category
     */
    public function setId(?int $id): Category
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return ArrayCollection|Collection
     */
    public function getChildCategories(): ArrayCollection|Collection
    {
        return $this->childCategories;
    }

    /**
     * @param ArrayCollection|Collection $childCategories
     * @return Category
     */
    public function setChildCategories(ArrayCollection|Collection $childCategories): Category
    {
        $this->childCategories = $childCategories;
        return $this;
    }

    /**
     * @return Category|null
     */
    public function getParentCategory(): ?Category
    {
        return $this->parentCategory;
    }

    /**
     * @param Category|null $parentCategory
     * @return Category
     */
    public function setParentCategory(?Category $parentCategory): Category
    {
        $this->parentCategory = $parentCategory;
        return $this;
    }

    /**
     * @return ArrayCollection|Collection
     */
    public function getPosts(): ArrayCollection|Collection
    {
        return $this->posts;
    }

    /**
     * @param ArrayCollection|Collection $posts
     * @return Category
     */
    public function setPosts(ArrayCollection|Collection $posts): Category
    {
        $this->posts = $posts;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Category
     */
    public function setName(?string $name): Category
    {
        $this->name = $name;
        return $this;
    }

    public function preUpdate(PreUpdateEventArgs $event)
    {
        if ($event->hasChangedField('parentCategory')) {
            /** @var Category $obj */
            $obj = $event->getObject();
            $obj->setChildCategories(new ArrayCollection());
        }
    }
}
