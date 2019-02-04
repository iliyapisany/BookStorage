<?php

namespace App\Form;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    private $AuthorRepository;

    public function __construct(AuthorRepository $authorRepository)
    {
        $this->AuthorRepository = $authorRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('publicated_year', DateType::class)
            ->add('ISBN', TextType::class, ['label'=>'ISBN'])
            ->add('pageNum', NumberType::class)
            ->add('authors', ChoiceType::class, [
                'choices' => $this->AuthorRepository->findAll(),
                'choice_label' => function($author, $key, $index) {
                    /** @var Author $author */
                    return $author->shortName();
                },
                'choice_value' => function($author) {
                    /** @var Author $author */
                    return $author->getId();
                },
                'multiple' => true,
            ])
            ->add('Save', SubmitType::class)
        ;

        $builder->get('authors')
            ->addModelTransformer(new CallbackTransformer(
                function ($data) {return $data;},
                function ($data) {
                    $SelectedEntities = [];
                    foreach ($data as $selectedEntity) {
                        $SelectedEntities[] = $this->AuthorRepository->find($selectedEntity);
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
