<?php

namespace App\Models;

use App\Models\Traits\LaravelVueDatatableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory, LaravelVueDatatableTrait;

    protected $fillable = ['resource_type_id', 'title', 'url', 'description', 'code_snippet', 'open_in_new_tab'];
    protected $with = ['resourceType'];

    protected $dataTableColumns = [
        'id' => [
            'searchable' => true,
        ],
        'title' => [
            'searchable' => true,
        ]
    ];

    protected $dataTableRelationships = [
        'belongsTo' => [
            'resource_type' => [
                'model' => ResourceType::class,
                'foreign_key' => 'resource_type_id',
                'columns' => [
                    'name' => [
                        'searchable' => true,
                        'orderable' => true,
                    ]
                ]
            ]
        ]
    ];

    public function resourceType()
    {
        return $this->belongsTo(ResourceType::class);
    }

    /**
     * This is used for laravel-vue-datatable and nothing else! Conventionally resourceType is more correct name.
     * So most cases we will use resourceType and only for datatable search resource_type will be used.
     */
    public function resource_type()
    {
        return $this->belongsTo(ResourceType::class);
    }
}
