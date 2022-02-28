<?php


namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Timestampable;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ORM\Table(name:'posts')]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'post', targetEntity: Comment::class)]
    private Collection $comments;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'posts')]
    #[ORM\JoinColumn(name: 'category_id')]
    private ?Category $category = null;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private ?string $title = null;

    #[ORM\Column(type: 'text')]
    private ?string $text = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $announce = null;

    #[ORM\Column(type: 'boolean')]
    private bool $isActive = false;

    #[ORM\Column(type: 'datetime')]
    #[Timestampable(on: 'create')]
    private ?\DateTimeInterface $createdAt = null;

    #[Pure] public function __construct()
    {
        $this->comments = new ArrayCollection();
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
     * @return Post
     */
    public function setId(?int $id): Post
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return ArrayCollection|Collection
     */
    public function getComments(): ArrayCollection|Collection
    {
        return $this->comments;
    }

    /**
     * @param ArrayCollection|Collection $comments
     * @return Post
     */
    public function setComments(ArrayCollection|Collection $comments): Post
    {
        $this->comments = $comments;
        return $this;
    }

    /**
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * @param Category|null $category
     * @return Post
     */
    public function setCategory(?Category $category): Post
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return Post
     */
    public function setTitle(?string $title): Post
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string|null $text
     * @return Post
     */
    public function setText(?string $text): Post
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAnnounce(): ?string
    {
        return $this->announce;
    }

    /**
     * @param string|null $announce
     * @return Post
     */
    public function setAnnounce(?string $announce): Post
    {
        $this->announce = $announce;
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     * @return Post
     */
    public function setIsActive(bool $isActive): Post
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface|null $createdAt
     * @return Post
     */
    public function setCreatedAt(?\DateTimeInterface $createdAt): Post
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}