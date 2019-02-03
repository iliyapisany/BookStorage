<?php

namespace App\Controller;

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
}
