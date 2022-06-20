<?php

namespace Database\Factories;

use App\Enums\Storage as StorageDisks;
use App\Models\Resource;
use App\Models\ResourceType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resource>
 */
class ResourceFactory extends Factory
{
    protected $model = Resource::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $resourceType = $this->faker->randomElement(ResourceType::all());

        if ($resourceType->name === \App\Enums\ResourceType::PDF) {
            $resource = $this->pdf($resourceType);
        } else if ($resourceType->name === \App\Enums\ResourceType::HTML) {
            $resource = $this->html($resourceType);
        } else if ($resourceType->name === \App\Enums\ResourceType::LINK) {
            $resource = $this->link($resourceType);
        }

        return $resource;
    }

    private function pdf($resourceType)
    {
        $fileName = microtime().'.pdf';
        $file = UploadedFile::fake()->create($fileName, 4, 'application/pdf');
        $file->storePubliclyAs('', $fileName, ['disk' => StorageDisks::ADMIN_UPLOADED_STORAGE]);

        return [
            'resource_type_id' => $resourceType->id,
            'title' => $this->faker->sentence(),
            'url' => $fileName,
        ];
    }

    private function html($resourceType)
    {
        return [
            'resource_type_id' => $resourceType->id,
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'code_snippet' => $this->faker->randomHtml(),
        ];
    }

    private function link($resourceType)
    {
        return [
            'resource_type_id' => $resourceType->id,
            'title' => $this->faker->sentence(),
            'url' => $this->faker->url(),
            'open_in_new_tab' => $this->faker->boolean()
        ];
    }
}
