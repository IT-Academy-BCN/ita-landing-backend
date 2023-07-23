<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;
use App\Http\Controllers\translatable;
class TranslateController extends Controller
{

public function index()
{
    $faqs = Faq::all();

    $translatedFaqs = $faqs->map(function ($faqs) {
        return [
            'name' => translatable($faqs, 'name'),
            'description' => translatable($faqs, 'description'),
        ];
    });

    return response()->json($translatedFaqs);
}
}
