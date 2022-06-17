<?php

namespace App\Models;

use App\Models\Traits\LaravelVueDatatableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory, LaravelVueDatatableTrait;

    protected $fillable = ['resource_type_id', 'title', 'url', 'description', 'code_snippet', 'open_in_new_tab'];

    protected $dataTableColumns = [
        'id' => [
            'searchable' => true,
        ],
        'title' => [
            'searchable' => true,
        ]
    ];

    public function resourceType()
    {
        return $this->belongsTo(ResourceType::class);
    }
}
