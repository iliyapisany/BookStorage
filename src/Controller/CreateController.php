<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CreateController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/book/create", name="CreateBook")
     */
    public function CreateBook() {
        return $this->render('edit/book.html.twig', [

        ]);
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/author/create", name="CreateAuthor")
     */
    public function CreateAuthor() {
        return $this->render('edit/author.html.twig', [

        ]);
    }
}
