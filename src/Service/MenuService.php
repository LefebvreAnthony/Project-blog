<?php

namespace App\Service;

use App\Entity\Menu;
use App\Repository\MenuRepository;

class MenuService
{
    public function __construct(private MenuRepository $menuRepo)
    {
    }

    /**
     * @return Menu[]
     */
    public function findAll()
    {
        return $this->menuRepo->findAllForTwig();
    }
}
