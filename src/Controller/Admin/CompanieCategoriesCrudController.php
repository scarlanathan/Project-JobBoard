<?php

namespace App\Controller\Admin;

use App\Entity\CompanieCategories;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CompanieCategoriesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CompanieCategories::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
