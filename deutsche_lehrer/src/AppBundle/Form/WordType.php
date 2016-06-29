<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WordType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pL')
            ->add('dE')
            ->add('partOfSpeech','choice',array('choices'=>array("noun"=>1, "verb"=>2, "adjective"=>3, "pronoun"=>4, "numeral"=>5, "other"=>6),'choices_as_values' => true))
            ->add('gender','choice', array('choices'=>array("masculine"=>1, "feminine"=>2, "neuter"=>0),'choices_as_values' => true))
            ->add('grammNumber','choice',array('choices'=>array("singular"=>1, "plural"=>2),'choices_as_values' => true))
            ->add('deck')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Word'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_word';
    }
}
