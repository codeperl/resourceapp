<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Models\Traits\LaravelVueDatatableTrait;

class ResourceType extends Model
{
    use HasFactory, Sluggable, LaravelVueDatatableTrait;

    public $timestamps = false;
    protected $fillable = ['name', 'slug'];
    protected $appends = ['text', 'value'];

    protected $dataTableColumns = [
        'id' => [
            'searchable' => true,
        ],
        'name' => [
            'searchable' => true,
        ],
        'slug' => [
            'searchable' => false,
        ]
    ];

    /**
     * @return mixed
     */
    public function getTextAttribute() {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getValueAttribute() {
        return $this->id;
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
