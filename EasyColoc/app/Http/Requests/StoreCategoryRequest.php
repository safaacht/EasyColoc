<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $category    = $this->route('category');
        $categoryId  = $category?->id;
        $colocationId = $category
            ? $category->colocation_id
            : auth()->user()?->colocations()->wherePivot('type', 'owner')->first()?->id;

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('category', 'name')
                    ->where('colocation_id', $colocationId)
                    ->ignore($categoryId),
            ],
        ];
    }
}
