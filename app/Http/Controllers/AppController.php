<?php

namespace App\Http\Controllers;

use App\Models\PhotoCategory;
use App\Models\QuoteCategory;
use App\Models\TermCategory;
use App\Models\VideoCategory;
use App\Support\Helpers\Helper;
use Illuminate\Http\Request;
use Kalnoy\Nestedset\Collection;

class AppController extends Controller
{
    public function home()
    {
        $categories = $this->getAllCategoriesTree();

        return view('pages.home', compact('categories'));
    }

    public function policy()
    {
        return view('pages.policy');
    }

    public function termsOfUse()
    {
        return view('pages.terms-of-use');
    }

    public function contacts()
    {
        return view('pages.contacts');
    }

    private function getAllCategoriesTree()
    {
        // Join all categories
        $categories = new Collection();
        $categories = $categories->concat(QuoteCategory::getItemsTree());
        $categories = $categories->concat(TermCategory::getItemsTree());
        $categories = $categories->concat(VideoCategory::getItemsTree());
        $categories = $categories->unique('name');

        // Add supported types
        $categories->each(function ($category) {
            $category->supportedTypeLinks = $this->getCategorySupportedLinks($category);

            foreach($category->children as $child) {
                $child->supportedTypeLinks = $this->getCategorySupportedLinks($child);
            }
        });

        return $categories;
    }

    private function getCategorySupportedLinks($category)
    {
        $links = array();

        if (QuoteCategory::where('name', $category->name)->first()) {
            array_push($links, [
                'label' => 'Цитаты и Афоризмы',
                'href' => route('quotes.index') . '?category_id=' . $category->id
            ]);
        }

        if (TermCategory::where('name', $category->name)->first()) {
            array_push($links, [
                'label' => 'Термины',
                'href' => route('terms.index') . '?category_id=' . $category->id
            ]);
        }

        if (VideoCategory::where('name', $category->name)->first()) {
            array_push($links, [
                'label' => 'Видео',
                'href' => route('videos.index') . '?category_id=' . $category->id
            ]);
        }

        if (TermCategory::where('name', $category->name)->first()) {
            array_push($links, [
                'label' => 'Словарь',
                'href' => route('vocabulary.index') . '?category_id=' . $category->id
            ]);
        }

        return $links;
    }
}
