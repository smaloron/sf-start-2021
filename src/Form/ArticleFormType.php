<?php

namespace App\Form;

use App\Entity\Article;


use App\Entity\Author;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ["label" => "Titre"])
            ->add('author', EntityType::class, [
                "label" => "Auteur",
                "class" => Author::class,
                "choice_label" => "fullName",
                "expanded" => true,
                "multiple" => false
            ])
            /*->add('createdAt', DateTimeType::class, [
                "label" => "Date de publication",
                "widget" => "single_text",
                "input" => "datetime_immutable"
            ])*/
            ->add('content', CKEditorType::class, [
                "label" => "Texte de l'article",
                //"attr" => ["rows" => "8", "class" => "texte"]
            ])
            ->add('genre')
            ->add('submit', SubmitType::class, [
                "label" => "Valider",
                "attr" => ["class" => "btn btn-primary mt-3 w-50"]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
