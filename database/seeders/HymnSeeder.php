<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hymn;

class HymnSeeder extends Seeder
{
    public function run(): void
    {
        $samples = [
            [
                'number' => 1,
                'title' => 'Orin Iyin',
                'content_md' => "# Iyin Oluwa\n\nOluwa ni Oluwa wa, a yin O.\n\n**Iyin** ni fun Oruko Re,\n\nAyin, ayin, ayin ni fun Jesu.\n\n[Ka wolẹ](/)",
            ],
            [
                'number' => 3,
                'title' => 'Orin Adura',
                'content_md' => "# Adura\n\nJesu Olugbala, gbọ adura wa;\n\nIwọ ni a gbẹkẹle, ki o dahun wa.\n\n**Amin**.",
            ],
            [
                'number' => 7,
                'title' => 'Orin Irapada',
                'content_md' => "# Irapada\n\nEmi ni Oluwa, mo gba mi la;\n\nẸjẹ Re mọ wa, o ṣe wa dọgba.\n\n*Iyin ni fun Ẹjẹ Jesu*.",
            ],
            [
                'number' => 12,
                'title' => 'Orin Oore-Oluwa',
                'content_md' => "# Oore Oluwa\n\nOore Re pọ ju, ko le ka;\n\nAyo ati alafia ni Re mu wa.\n\n**Oore** Re la ma yin titi.",
            ],
            [
                'number' => 20,
                'title' => 'Orin Imole',
                'content_md' => "# Imole\n\nJesu ni Imole aye, o tan laye mi;\n\nKo si okunkun mo, nítorí Imole Re.\n\n*Imole* Re ma tan titi.",
            ],
            [
                'number' => 45,
                'title' => 'Orin Ayọ',
                'content_md' => "# Ayọ ninu Oluwa\n\nAyọ wa ninu Oluwa;\n\nA ma korin, a ma jo;\n\n**Ayọ** ni fun Olugbala wa.",
            ],
        ];

        foreach ($samples as $s) {
            Hymn::updateOrCreate(
                ['number' => $s['number']],
                [
                    'title' => $s['title'],
                    'content_md' => $s['content_md'],
                    'is_published' => true,
                ]
            );
        }
    }
}

