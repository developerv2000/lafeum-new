<?php

namespace App\Http\Controllers;

use App\Models\Term;
use App\Models\TermCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class VocabularyController extends Controller
{
    public function index()
    {
        $categories = TermCategory::getItemsTree();
        $terms = Term::getVocabularyItemsSummarized();

        return view('vocabulary.index', compact('categories', 'terms'));
    }

    // Used in AJAX Requests
    public function getBody(Term $term)
    {
        return $term->body;
    }

    public function filter()
    {
        $terms = Term::getVocabularyItemsSummarized();

        return View::make('components.lists.vocabulary', compact('terms'))->render();
    }
}
