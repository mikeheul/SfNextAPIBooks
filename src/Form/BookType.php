<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $authors = $options['authors'];

        $builder
            ->add('title', TextType::class, [
                'label' => 'Title',
            ])
            ->add('publishedDate', NumberType::class, [
                'label' => 'Published Date',
            ])
            ->add('pages', NumberType::class, [
                'label' => 'Pages count',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
            ])
            // Ajouter un champ "author" avec une liste déroulante des auteurs existants
            ->add('author', ChoiceType::class, [
                'label' => 'Author',
                'choices' => $this->getAuthorsChoices($authors),
                'placeholder' => 'Select an author',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'authors' => [],
        ]);
    }

    private function getAuthorsChoices(array $authors): array
    {
        // Créer un tableau clé => valeur pour le champ select
        $choices = [];
        foreach ($authors as $author) {
            $choices[$author['firstname'] . ' ' . $author['lastname']] = $author['id'];
        }

        return $choices;
    }
}
