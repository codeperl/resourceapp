<?php

namespace Database\Factories;

use App\Models\ResourceType;
use App\Repositories\ResourceTypeRepository;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ResourceType>
 *
 * Currently, Factory is not needed to run. Resource type is already added with pre decided values via migration.
 */
class ResourceTypeFactory extends Factory
{
    protected $model = ResourceType::class;

    private $resourceTypeRepository;

    public function __construct($count = null, Collection $states = null, Collection $has = null, Collection $for = null, Collection $afterMaking = null, Collection $afterCreating = null, $connection = null, ResourceTypeRepository $resourceTypeRepository)
    {
        parent::__construct($count, $states, $has, $for, $afterMaking, $afterCreating, $connection);

        $this->resourceTypeRepository = $resourceTypeRepository;
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = $this->uniqueRandomElement();

        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }

    public function uniqueRandomElement()
    {
        do {
            $randomElement = $this->faker->randomElement([
                \App\Enums\ResourceType::PDF,
                \App\Enums\ResourceType::HTML,
                \App\Enums\ResourceType::LINK
            ]);

        } while($this->resourceTypeRepository->isExists($randomElement));

        return $randomElement;
    }
}
