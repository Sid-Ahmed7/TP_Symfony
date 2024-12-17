<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Language;
use App\Entity\Media;
use App\Entity\Season;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('shortDescription')
            ->add('longDescription')
            ->add('releaseDate', null, [
                'widget' => 'single_text',
            ])
            ->add('coverImage')
            ->add('staff')
            ->add('casting')
            ->add('score')
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Série' => 'serie',
                    'Movie' => 'movie',
                ],
                'expanded' => true,  
                'multiple' => false, 
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true
            ])
            ->add('languages', EntityType::class, [
                'class' => Language::class,
                'choice_label' => 'code',
                'multiple' => true,
                'expanded' => true
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event): void {
                $data = $event->getData();
                $form = $event->getForm();

                if (isset($data['type']) && $data['type'] === 'serie') {
                    $form->add('seasons', EntityType::class, [
                        'class' => Season::class,
                        'choice_label' => 'number', 
                        'multiple' => true,
                        'expanded' => true,
                        'required' => true,
                    ])
                    ->add('episodes', EpisodeType::class, [
                        'required' => true,
                    ]);
                } else {
                    $form->remove('seasons');
                    $form->remove('episodes');
                }
            });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Media::class,
        ]);
    }
}
