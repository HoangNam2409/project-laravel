<?php

namespace App\Rules;

use App\Models\PostCatalogue;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckPostCatalogueChildrenRule implements ValidationRule
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $flag = PostCatalogue::isNodeCheck($this->id);

        if ($flag) {
            $fail('Không thể xoá vì vẫn còn danh mục con');
        }
    }
}
