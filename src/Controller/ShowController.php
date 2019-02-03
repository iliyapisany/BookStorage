<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ShowController extends AbstractController
{
    /**
     * @Route("/", name="Index")
     */
    public function index()
    {
        return $this->render('show/index.html.twig', [
            'controller_name' => 'MainController',
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
