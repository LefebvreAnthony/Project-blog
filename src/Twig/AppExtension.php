<?php

namespace App\Twig;

use App\Entity\Menu;
use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function __construct(private RouterInterface $router)
    {
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('menuLink', [$this, 'menuLink']),
        ];
    }

    public function getFunctions()
    {
        return [
            new TwigFilter('menuLink', [$this, 'menuLink']),
        ];
    }

    public function menuLink(Menu $menu)
    {
        $article = $menu->getArticle();
        $category = $menu->getCategory();
        $page = $menu->getPage();

        $url = $menu->getLink() ?: '#';

        if ($url != '#') return $url;

        if ($article) {
            $name = 'article_show';
            $slug = $article->getSlug();
        }
        if ($category) {
            $name = 'category_show';
            $slug = $category->getSlug();
        }
        if ($page) {
            $name = 'page_show';
            $slug = $page->getSlug();
        }

        // if (isset($name, $slug)) return $url;

        return $this->router->generate($name, [
            'slug' => $slug,
        ]);
    }
}
