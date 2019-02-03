<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CreateController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/book/create", name="CreateBook")
     */
    public function CreateBook(Request $request) {
        $Book = new Book();

        $form = $this->createForm(BookType::class, $Book);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $db = $this->getDoctrine()->getManager();
            $db->persist($Book);
            $db->flush();

            return $this->redirectToRoute('Books');
        }

        return $this->render('edit/base_create_form.html.twig', [
            'form' => $form->createView(),
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
