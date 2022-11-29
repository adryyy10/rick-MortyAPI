<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $title;

    public function __construct(string $title) {
        $this->title = $title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    private function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    private function validateBusinessLogic(string $title)
    {
        if (empty($title) || strlen($title) < 3) {
            throw new InvalidArgumentException("Invalid Title");
        }
    }

    /**
     * 
     * This method creates/updates category and fills it with data
     * 
     * This method is static because it's trying to follow a more DDD approach where the Entity 
     * is rich in business logic instead of being anemic and the setters are private.
     * 
     * @param ?Category $category
     * @param string $title
     * 
     * @return Category
     * 
     */
    public static function addOrUpdate(?Category $category, string $title): self
    {
        /** If $category not exists, create a new one */
        if (empty($category)) {
            $category = new self($title);
        }

        /** Validate business entity */
        $category->validateBusinessLogic($title);

        $category->setTitle($title);

        return $category;
    }
}
