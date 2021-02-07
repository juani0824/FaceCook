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
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
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


        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('nomDocument', 'Titre'),
            DateTimeField::new('created_at', 'Date de création'),
            UrlField::new('fileDocument', 'PDF'),
            TextField::new('users', 'Publié par')
            
        ];
    }
     
      
    public function configureActions(Actions $actions): Actions
    {
        return $actions
        ->disable(Action::NEW)
        ->remove(Crud::PAGE_INDEX, Action::EDIT)   
        //->disable(Action::EDIT)       
        ;
    }
}
