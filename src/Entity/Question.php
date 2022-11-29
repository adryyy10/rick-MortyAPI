<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;

/**
 * @ORM\Entity(repositoryClass=QuestionRepository::class)
 */
class Question
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $statement;

    /**
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=Answer::class, mappedBy="question", cascade={"persist", "remove"})
     */
    private $answers;

    public function __construct(string $statement, int $type)
    {
        $this->statement    = $statement;
        $this->type         = $type;
        $this->answers      = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatement(): ?string
    {
        return $this->statement;
    }

    private function setStatement(string $statement): self
    {
        $this->statement = $statement;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    private function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, Answer>
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    private function validateBusinessLogic(string $statement,int $type)
    {
        if (empty($statement) || strlen($statement) < 3) {
            throw new InvalidArgumentException("Invalid Statement");
        }

        if ($type <= 0) {
            throw new InvalidArgumentException("Invalid Category type");
        }
    }

    /**
     * 
     * This method creates a new questions and fills it with data
     * 
     * This method is static because it's trying to follow a more DDD approach where the Entity 
     * is rich in business logic instead of being anemic and the setters are private.
     * 
     * @param ?Question $question
     * @param string $statement
     * @param int $type
     * 
     * @return Question
     * 
     */
    public static function addOrUpdate(
        ?Question $question, 
        string $statement,
        int $type
    ): self {
        if (empty($question)) {
            $question = new self($statement, $type);
        }

        /** Validate business entity */
        $question->validateBusinessLogic($statement, $type);

        $question->setStatement($statement);
        $question->setType($type);

        return $question;
    }

    /*public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers[] = $answer;
            $answer->setQuestion($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->removeElement($answer)) {
            // set the owning side to null (unless already changed)
            if ($answer->getQuestion() === $this) {
                $answer->setQuestion(null);
            }
        }

        return $this;
    }*/
}
