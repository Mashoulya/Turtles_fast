<?php

namespace App\Entity;

use App\Repository\QuestionsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionsRepository::class)]
class Questions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $question = null;

    #[ORM\Column(length: 255)]
    private ?string $answer = null;

    #[ORM\Column(length: 255)]
    private ?string $false_answer1 = null;

    #[ORM\Column(length: 255)]
    private ?string $false_answer2 = null;

    #[ORM\Column(length: 255)]
    private ?string $false_answer3 = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): static
    {
        $this->question = $question;

        return $this;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): static
    {
        $this->answer = $answer;

        return $this;
    }

    public function getFalseAnswer1(): ?string
    {
        return $this->false_answer1;
    }

    public function setFalseAnswer1(string $false_answer1): static
    {
        $this->false_answer1 = $false_answer1;

        return $this;
    }

    public function getFalseAnswer2(): ?string
    {
        return $this->false_answer2;
    }

    public function setFalseAnswer2(string $false_answer2): static
    {
        $this->false_answer2 = $false_answer2;

        return $this;
    }

    public function getFalseAnswer3(): ?string
    {
        return $this->false_answer3;
    }

    public function setFalseAnswer3(string $false_answer3): static
    {
        $this->false_answer3 = $false_answer3;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
