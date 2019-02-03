<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/books/{id<\d+>}/delete", name="DeleteBook")
     */
    public function DeleteBook($id) {
        $BookRepository = $this->getDoctrine()->getRepository(Book::class);

        $DeletedBook = $BookRepository->find($id);

        $db = $this->getDoctrine()->getManager();
        $db->remove($DeletedBook);
        $db->flush();

        return $this->redirectToRoute('Books');
    }


    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/authors/{id<\d+>}/delete", name="DeleteAuthor")
     */
    public function DeleteAuthor($id) {
        $AuthroRepository = $this->getDoctrine()->getRepository(Author::class);

        $DeletedAuthor = $AuthroRepository->find($id);

        $db = $this->getDoctrine()->getManager();
        $db->remove($DeletedAuthor);
        $db->flush();

        return $this->redirectToRoute('Authors');
    }
}
