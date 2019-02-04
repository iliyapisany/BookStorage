<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

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
     * @var PersistentCollection
     * @ORM\ManyToMany(targetEntity="Book", mappedBy="authors")
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
