<?php

namespace App\Form;

use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuthorType extends AbstractType
{
    private $BookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->BookRepository = $bookRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('first_name', TextType::class)
            ->add('last_name', TextType::class)
            ->add('patronymic', TextType::class)
            ->add('writedBooks', ChoiceType::class, [
                'choices' => $this->BookRepository->findAll(),
                'choice_label' => function($book, $key, $index) {
                    /** @var Book $book */
                    return $book->getName();
                },
                'choice_value' => function($book) {
                    /** @var Book $book */
                    return $book ? $book->getId() : '';
                },
                'multiple' => true,
            ])
            ->add('Save', SubmitType::class);
        ;

        $builder->get('writedBooks')
            ->addModelTransformer(new CallbackTransformer(
                function ($data) {return $data;},
                function ($UserData) {
                    $SelectedEntities = [];
                    foreach($UserData as $entity) {
                        $SelectedEntities[] = $this->BookRepository->find($entity);
                    }
                    return $SelectedEntities;
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
