<?php


namespace App\Admin;


use App\Entity\Category;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CategoryAdmin extends AbstractAdmin
{
    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('name')
            ->add('parentCategory.name')
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
            ->add('name', TextType::class)
            ->add('parentCategory', EntityType::class, [
                'class'         => Category::class,
                'choice_label'  => 'name',
                'required'      => false,
                'query_builder' => function (EntityRepository $er) use ($subject) {
                    $qb = $er->createQueryBuilder('c');
                    if ($subject->getId()) {
                        $qb
                            ->andWhere('c != (:subject)')
                            ->setParameter('subject', $subject->getId())
                        ;
                    }
                    return $qb;
                },

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