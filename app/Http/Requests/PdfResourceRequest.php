<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class PdfResourceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'resource_type_id' => ['required', 'exists:App\Models\ResourceType,id'],
            'title' => ['required', 'min:3', 'max:191', 'unique:App\Models\Resource,title'],
            'url' => ['required', 'file', 'mimes:pdf', 'max:2048'],
        ];

        return $rules;
    }
}
