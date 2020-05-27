<?php 
namespace App\Form\TypeExtension;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface as FormFormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeExtensionInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TextareaSizeExtension implements FormTypeExtensionInterface{

    public function buildForm(FormFormBuilderInterface $builder, array $options){

    }

    public function buildView(FormView $view, FormInterface $form, array $options){
        $view->vars['attr']['rows'] = 10;
    }

    public function finishView(FormView $view, FormInterface $form, array $options){

    }

    public function configureOptions(OptionsResolver $resolver){

    }

    public function getExtendedType(){
        return TextareaType::class;
    }

    public function getExtendedTypes(){
        return [TextareaType::class];
    }


}