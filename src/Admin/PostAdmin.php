<?php


namespace App\Admin;


use App\Entity\Category;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PostAdmin extends AbstractAdmin
{
    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('category.name')
            ->add('title')
            ->add('announce')
            ->add('isActive')
            ->add('createdAt')
            ->add('_actions', null, [
                'actions' => [
                    'edit' => [],
                ],

            ])
        ;
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $subject = $this->getSubject();
        $form
            ->add('title')
            ->add('announce')
            ->add('isActive')
            ->add('category', EntityType::class, [
                'class'         => Category::class,
                'choice_label'  => 'name',
                'required'      => false,
            ])
            ;
    }

    public function toString(object $object): string
    {
        return $object instanceof Category
            ? $object->getName()
            : 'Category';
    }
}