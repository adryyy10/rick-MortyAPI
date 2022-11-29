<?php

namespace App\Entity;

use App\Repository\AnswerRepository;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;

/**
 * @ORM\Entity(repositoryClass=AnswerRepository::class)
 */
class Answer
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
    private $title;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isCorrect;

    /**
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="answers")
     */
    private $question;

    public function __construct(
        string $title, 
        bool $isCorrect, 
        Question $question
    ) {
        $this->title        = $title;
        $this->isCorrect    = $isCorrect;
        $this->question     = $question;
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

    public function getIsCorrect(): ?bool
    {
        return $this->isCorrect;
    }

    private function setIsCorrect(bool $isCorrect): self
    {
        $this->isCorrect = $isCorrect;

        return $this;
    }

    public function getQuestion(): Question
    {
        return $this->question;
    }

    private function setQuestion(Question $question): self
    {
        $this->question = $question;

        return $this;
    }

    private function validateBusinessLogic(string $title, bool $isCorrect, Question $question) 
    {
        if (empty($title) || strlen($title) < 3) {
            throw new InvalidArgumentException("Invalid title");
        }

        if (is_null($isCorrect) ) {
            throw new InvalidArgumentException("Invalid isCorrect value");
        }

        if (empty($question) ) {
            throw new InvalidArgumentException("Invalid question");
        }
    }

    public static function addOrUpdate(
        ?Answer $answer,
        string $title,
        bool $isCorrect,
        Question $question
    ): self {
        if (empty($answer)) {
            $answer = new self(
                $title,
                $isCorrect,
                $question
            );
        }

        /** Validate business entity */
        $answer->validateBusinessLogic($title, $isCorrect, $question);

        $answer->setTitle($title);
        $answer->setIsCorrect($isCorrect);
        $answer->setQuestion($question);

        return $answer;
    }
}
