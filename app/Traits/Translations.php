<?php

namespace App\Traits;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
trait Translations
{
    public function translation($column, $default = '')
    {
        $locale = App::getLocale();

        if ($this->locale == $locale) {
            return $default;
        }

        $translation = DB::table('translations')
            ->where('table', $this->table)
            ->where('column', $column)
            ->where('row_id', $this->id)
            ->where('locale', $locale)
            ->first();

        if ($translation) {
            return $translation->translation;
        }else {
            return $default;
        }
    }

    
}