<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AuthorRepository")
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="FIO", columns={"last_name", "first_name", "patronymic"})})
 */
class Author
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @var string
     * @ORM\Column(type="string", length=30)
     */
    private $last_name = '';

    /**
     * @var string
     * @ORM\Column(type="string", length=20)
     */
    private $first_name = '';

    /**
     * @var string
     * @ORM\Column(type="string", length=23)
     */
    private $patronymic = '';

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     */
    public function setLastName(string $last_name): void
    {
        $this->last_name = $last_name;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     */
    public function setFirstName(string $first_name): void
    {
        $this->first_name = $first_name;
    }

    /**
     * @return string
     */
    public function getPatronymic(): string
    {
        return $this->patronymic;
    }

    /**
     * @param string $patronymic
     */
    public function setPatronymic(string $patronymic): void
    {
        $this->patronymic = $patronymic;
    }

    public function shortName() {
        return $this->last_name . ' ' . $this->first_name[0] . '.' . $this->patronymic[0] . '.';
    }
}
