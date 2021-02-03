<?php

namespace App\Controller\Admin;

use App\Entity\Document;
use App\Entity\Publication;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class DocumentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Document::class;
    }

    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
                ->setPageTitle(Crud::PAGE_INDEX, 'Liste de Documents')
        ;
          
    }
    
    public function configureFields(string $pageName): iterable
    {

        ImageField::new('fileDocument', 'Document PDF')->setFormType(FileType::class)
        ->setBasePath('docs');

        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('nomDocument', 'Titre'),
            DateTimeField::new('created_at', 'Date de création'),
            TextField::new('fileDocument', 'Document PDF')                       
            ->hideOnIndex()
            ->setFormType(FileType::class, [
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger un document PDF valide',
                    ])
                ],
            ]),

            
        ];
    }
     
      
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
}
