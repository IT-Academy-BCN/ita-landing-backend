<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Astrotomic\Translatable\Locales;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class FaqController extends Controller
{
    //------INDEX------//

    public function index()
    {
        return response()->json(['faqs' => Faq::all()], 200);
    }

    //------SHOW------//

    public function show(Request $request, $id)
    {
        try {
            $language = $request->query('language');

            $availableLocales = app('translatable.locales')->all();

            $request->validate([
                'language' => ['sometimes', 'required', 'string', 'max:2', Rule::in($availableLocales)],
            ]);

            $faq = Faq::find($id);

            if (! $faq) {
                return response()->json(['error' => __('api.faq_not_found')], 404);
            }
            if ($language && ! $faq->hasTranslation($language)) {
                return response()->json(['error' => __('api.translation_not_found')], 406);
            }
            $faq = $language ? $faq->translate($language) : $faq;

            return response()->json(['faq' => $faq], 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    //------STORE------//

    public function store(Request $request)
    {
        try {
            $language = $request->query('language');

            $availableLocales = app('translatable.locales')->all();

            $rules = ([
                'language' => ['required', 'string', 'max:2', Rule::in($availableLocales)],
                'title' => ['required', 'string', 'max:255', 'unique:faq_translations,title'],
                'description' => ['required_with:title', 'string'],
            ]);
            $validatedData = $request->validate($rules);
            $dataWithLocaleKey = [$language => $validatedData];

            $faq = Faq::create($dataWithLocaleKey)->setDefaultLocale($language);

            return response()->json(['faq' => $faq], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    //------UPDATE------//

    public function update(Request $request, $id)
    {
        try {
            $language = $request->query('language');

            $faq = Faq::find($id);

            if (! $faq) {
                return response()->json(['error' => __('api.faq_not_found')], 404);
            }
            $availableLocales = app('translatable.locales')->all();

            $rules = ([
                'language' => ['required', 'string', 'max:2', Rule::in($availableLocales)],
                'title' => ['required', 'string', 'max:255', 'unique:faq_translations,title'],
                'description' => ['required_with:title', 'string'],
            ]);

            $validatedData = $request->validate($rules);
            $dataWithLocaleKey = [$language => $validatedData];

            $faq->update($dataWithLocaleKey);

            return response()->json(['message' => __('api.faq_translation_updated'), 'faq' => $faq], 200);

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    //------DESTROY------//

    public function destroy(Request $request, $id)
    {
        $language = $request->query('language');

        // Check if this language is admited in the application
        $availableLocales = app('translatable.locales')->all();
        if ($language && (! app(Locales::class)->has($language) || ! in_array($language, $availableLocales))) {
            return response()->json(['error' => __('api.translation_key_not_available')], 422);
        }

        $faq = Faq::find($id);

        if (! $faq) {
            return response()->json(['error' => __('api.faq_not_found')], 404);
        }
        if ($language) {
            if (! $faq->hasTranslation($language)) {
                return response()->json(['error' => __('api.translation_not_found')], 406);
            }
            $faq->deleteTranslations($language);
            // if that was the last translation, delete the whole FAQ
            $translations = $faq->translations->all();
            if (! $translations) {
                $faq->delete();
            }
        } else {
            $faq->delete();
        }

        return response()->json([
            'message' => isset($translations)
                ? __('api.faq_translation_deleted')
                : __('api.faq_deleted'),
        ], 200);
    }
}
