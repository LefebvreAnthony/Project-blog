<?php

namespace App\Controller\Admin;

use App\Entity\Menu;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use Symfony\Component\HttpFoundation\RequestStack;

class MenuCrudController extends AbstractCrudController
{
    const MENU_PAGES = 0;
    const MENU_ARTICLES = 1;
    const MENU_LINKS = 2;
    const MENU_CATEGORIES = 3;

    public function __construct(private RequestStack $requestStack)
    {
    }
    public static function getEntityFqcn(): string
    {
        return Menu::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $SubMenuIndex = $this->getSubMenuIndex();
        $entityLabelInSingular = 'One menu';

        $entityLabelInPlurial = match ($SubMenuIndex) {
            self::MENU_ARTICLES => 'Articles',
            self::MENU_CATEGORIES => 'Categories',
            self::MENU_LINKS => 'Links',
            default => 'Pages'
        };

        return $crud
            ->setEntityLabelInSingular($entityLabelInSingular)
            ->setEntityLabelInPlural($entityLabelInPlurial);
    }

    public function configureFields(string $pageName): iterable
    {
        $SubMenuIndex = $this->getSubMenuIndex();

        yield TextField::new('name', 'Title of navigation');
        yield NumberField::new('menuOrder', 'Order');
        yield $this->getFieldFromSubMenuIndex($SubMenuIndex)->setRequired(true);
        yield BooleanField::new('isVisible', 'Visible');
        yield AssociationField::new('subMenus', 'Subelement');
    }

    private function getFieldFromSubMenuIndex($SubMenuIndex)
    {
        $fieldName = match ($SubMenuIndex) {
            self::MENU_ARTICLES => 'article',
            self::MENU_CATEGORIES => 'categorie',
            self::MENU_LINKS => 'link',
            default => 'page'
        };

        return ($fieldName == 'link') ? TextField::new($fieldName) : AssociationField::new($fieldName);
    }

    private function getSubMenuIndex(): int
    {
        return $this->requestStack->getMainRequest()->query->getInt('submenuIndex');
    }
}
