<?php 

namespace App\Models\Traits\Mutators;

use App\Traits\Translations;
trait faqsMutators
{
    use Translations;
    public function getTitleAttribute($value)
    {
        return $this->translation('title', $value);
    }

    public function getDescriptionAttribute($value)
    {
        return $this->translation('description', $value);
    }
}