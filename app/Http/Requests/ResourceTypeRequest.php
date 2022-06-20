<?php

namespace App\Http\Requests;

use App\Models\ResourceType;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ResourceTypeRequest extends FormRequest
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
            'name' => ['required', 'min:2', 'max:100', Rule::in([\App\Enums\ResourceType::PDF,
                \App\Enums\ResourceType::HTML, \App\Enums\ResourceType::LINK]), 'unique:App\Models\ResourceType,name'],
            'slug' => ['nullable', 'min:2', 'max:191', 'unique:App\Models\ResourceType,slug'],
        ];

        if ($this->isMethod(Request::METHOD_PUT) || $this->isMethod(Request::METHOD_PATCH) ) {
            $rules = array_merge($rules, [
                'name' => ['required', 'min:2', 'max:100', Rule::in([\App\Enums\ResourceType::PDF,
                    \App\Enums\ResourceType::HTML, \App\Enums\ResourceType::LINK]),
                    'unique:App\Models\ResourceType,name,'.$this->resource_type->id],
                'slug' => ['nullable', 'min:2', 'max:191', 'unique:App\Models\ResourceType,slug,'.$this->resource_type->id],
            ]);
        }

        return $rules;
    }

    public function getParams(): array
    {
        if ($this->isMethod(Request::METHOD_POST) ) {
            return array_merge($this->post(), [
                'slug' => SlugService::createSlug(ResourceType::class, 'slug', $this->post('name')),
            ]);
        } else {
            if($this->post('name') !== $this->resource_type->name) {
                return array_merge($this->post(), [
                    'slug' => SlugService::createSlug(ResourceType::class, 'slug', $this->post('name')),
                ]);
            } else {
                return array_merge($this->post(), [
                    'slug' => !empty($this->post('slug')) ? $this->post('slug') : $this->resource_type->slug,
                ]);
            }
        }

        return $this->validated();
    }
}
