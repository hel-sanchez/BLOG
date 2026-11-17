<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'body' => $this->faker->paragraph(),
            'is_published' => $this->faker->boolean(),
            'image_path' => null,
            'user_id' => User::factory(),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Post $post) {

            // 60% chance of getting an image

            if (! fake()->boolean(60)) {
                return;
            }

            // Download a random image
            $response = Http::timeout(10)->get(
                'https://picsum.photos/640/480'
            );

            if ($response->successful()) {
                $path = 'posts/'.Str::uuid().'.jpg';

                Storage::disk('public')->put(
                    $path,
                    $response->body()
                );

                $post->update([
                    'image_path' => $path,
                ]);
            }
        });
    }
}
