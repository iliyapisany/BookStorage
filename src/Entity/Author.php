<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank()
     * @Assert\Type(type="string", message="Должно быть строкой")
     * @Assert\Length(max="30", maxMessage="Должно быть не длинее 30 символов", min="2", minMessage="Должно быть не короче 2 символов")
     */
    private $last_name = '';

    /**
     * @var string
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank()
     * @Assert\Type(type="string", message="Должно быть строкой")
     * @Assert\Length(max="20", maxMessage="Должно быть не длиннее 20 символов", min="2", minMessage="Должно быть не короче 2 симовлов")
     */
    private $first_name = '';

    /**
     * @var string
     * @ORM\Column(type="string", length=23)
     * @Assert\Type(type="string", message="Должне быть строкой")
     * @Assert\Length(max="23", maxMessage="Не должно быть длинее 23 символов")
     */
    private $patronymic = '';

    /**
     * @var PersistentCollection
     * @ORM\ManyToMany(targetEntity="Book", mappedBy="authors")
     * @Assert\Type(type="object", message="Множество написаных книг")
     */
    private $writed_books;

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

    /**
     * @return array
     */
    public function getWritedBooks(): array
    {
        return $this->writed_books->toArray();
    }

    /**
     * @param array $writed_books
     */
    public function setWritedBooks(array $writed_books): void
    {
        foreach ($this->writed_books->toArray() as $writedBook) {
            if(!array_search($writedBook, $writed_books)) {
                $this->writed_books->removeElement($writedBook);
                $writedBook->removeAuthor($this);
            }
        }
        foreach ($writed_books as $writed_book) {
            if(!$this->writed_books->contains($writed_book)) {
                $this->addBook($writed_book);
                $writed_book->addAuthor($this);
            }
        }

    }

    /**
     * @param Book $book
     */
    public function addBook(Book $book) {
        $this->writed_books[] = $book;
    }

    /**
     * @param Book $book
     */
    public function removeBook(Book $book) {
        $this->writed_books->removeElement($book);
    }

    public function shortName() {
        return $this->last_name . ' ' . $this->first_name[0] . '.' . $this->patronymic[0] . '.';
    }

    public function __construct()
    {
        $this->writed_books = new ArrayCollection();
    }
}
