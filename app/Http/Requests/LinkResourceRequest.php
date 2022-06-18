<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class LinkResourceRequest extends FormRequest
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
            'url' => ['required', 'min:10', 'url'],
            'open_in_new_tab' => ['nullable', 'boolean'],
        ];

        if ($this->isMethod(Request::METHOD_PUT) || $this->isMethod(Request::METHOD_PATCH) ) {
            $rules = array_merge($rules, [
                'title' => ['required', 'min:3', 'max:191', 'unique:App\Models\Resource,title'.$this->resource->id],
            ]);
        }

        return $rules;
    }
}
