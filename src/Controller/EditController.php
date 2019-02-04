<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use App\Form\AuthorType;
use App\Form\BookEditType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EditController extends AbstractController
{
    /**
     * @param $id
     * @param $request Request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/book/{id<\d+>}", name="EditBook")
     */
    public function Book($id, Request $request) {
        /** @var BookRepository $AuthorRepository */
        $BookRepository = $this->getDoctrine()->getRepository(Book::class);

        /** @var Book $Book */
        $Book = $BookRepository->find($id);

        if($Book == null) {
            return $this->redirectToRoute('CreateBook');
        }


        $form = $this->createForm(BookEditType::class, $Book);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $db = $this->getDoctrine()->getManager();

            /** @var File $File */
            $File = $Book->getImage();

            $Filename = md5(uniqid()) . '.' . $File->guessExtension();

            $File->move($this->getParameter('book_wrapper_directory'), $Filename);

            $Book->setImage($Filename);

            $db->persist($Book);
            $db->flush();
        }

        return $this->render('edit/base_create_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @param $id
     * @param $request Request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/author/{id<\d+>}", name="EditAuthor")
     */
    public function Author($id, Request $request) {
        /** @var BookRepository $AuthorRepository */
        $AuthorRepository = $this->getDoctrine()->getRepository(Author::class);

        /** @var Book $Author */
        $Author = $AuthorRepository->find($id);

        if($Author == null) {
            return $this->redirectToRoute('CreateAuthor');
        }


        $form = $this->createForm(AuthorType::class, $Author);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $db = $this->getDoctrine()->getManager();
            $db->persist($Author);
            $db->flush();

            return $this->redirectToRoute('EditAuthor', ['id' => $id]);
        }

        return $this->render('edit/base_create_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
