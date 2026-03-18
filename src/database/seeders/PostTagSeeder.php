<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use App\Models\Tag;

class PostTagSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo tags
        $tags = [
            ['name' => 'Laravel', 'slug' => 'laravel'],
            ['name' => 'PHP', 'slug' => 'php'],
            ['name' => 'Backend', 'slug' => 'backend'],
            ['name' => 'API', 'slug' => 'api'],
            ['name' => 'Database', 'slug' => 'database'],
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(
                ['slug' => $tag['slug']],
                ['name' => $tag['name']]
            );
        }

        // Tạo posts
        $posts = Post::factory()->count(10)->create();

        $tagIds = Tag::pluck('id');

        // Gắn tag vào post
        foreach ($posts as $post) {

            $randomTags = $tagIds->random(rand(2,4));

            $attachData = [];

            foreach ($randomTags as $index => $tagId) {
                $attachData[$tagId] = [
                    'order' => $index
                ];
            }

            $post->tags()->attach($attachData);
        }
    }
}