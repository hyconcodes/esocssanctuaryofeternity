<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\Testimony;

class TestimonySeeder extends Seeder
{
    public function run(): void
    {
        $photos = collect(Storage::disk('public')->files('testimonies'))
            ->filter(function ($path) {
                return preg_match('/\.(jpg|jpeg|png|webp)$/i', $path);
            })
            ->values();

        $samples = [
            [
                'title' => 'Healed from long-term illness',
                'description' => 'After prayers, I received my healing and strength returned.',
                'category' => 'healing',
                'author' => 'John Doe',
                'rank' => 'Deacon',
                'country' => 'Nigeria',
            ],
            [
                'title' => 'Breakthrough in my business',
                'description' => 'God opened doors for contracts beyond expectation.',
                'category' => 'breakthrough',
                'author' => 'Mary Amos',
                'rank' => 'Choir Member',
                'country' => 'Ghana',
            ],
            [
                'title' => 'Family reconciled',
                'description' => 'Our home found peace and reconciliation after months.',
                'category' => 'family-reconciliation',
                'author' => 'Samuel Peter',
                'rank' => 'Elder',
                'country' => 'Nigeria',
            ],
        ];

        foreach ($samples as $i => $s) {
            $payload = array_merge($s, [
                'is_featured' => $i === 0,
            ]);
            if ($photos->get($i)) {
                $payload['author_photo_path'] = $photos->get($i); // e.g., testimonies/abc.jpg
            }
            Testimony::create($payload);
        }
    }
}
