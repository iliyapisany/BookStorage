<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ShowController extends AbstractController
{
    /**
     * @Route("/", name="Index")
     */
    public function index()
    {
        $BookRepository = $this->getDoctrine()->getRepository(Book::class);
        $AuthorRepository = $this->getDoctrine()->getRepository(Author::class);

        $Books = $BookRepository->findAll();
        $Authors = $AuthorRepository->findAll();

        return $this->render('show/index.html.twig', [
            'Books' => $Books,
            'Authors' => $Authors,
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/books", name="Books")
     */
    public function books() {
        return $this->render('show/books.html.twig', [

        ]);
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/authors", name="Authors");
     */
    public function authors() {
        return $this->render('show/authors.html.twig', [

        ]);
    }
}
