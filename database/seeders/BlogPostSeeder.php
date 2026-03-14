<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\BlogPost;
use Illuminate\Database\Seeder;

class BlogPostSeeder extends Seeder
{
    /**
     * Seed dynamic blog posts used in frontend blog and homepage latest news.
     */
    public function run(): void
    {
        $adminId = Admin::query()->value('id');

        $posts = [
            [
                'title' => "Women's Day Gift Ideas 2026: Meaningful & Stylish Picks",
                'slug' => 'womens-day-gift-ideas-2026-meaningful-stylish-picks',
                'excerpt' => "Explore Women's Day gift ideas that feel personal and meaningful. From stylish everyday wear to thoughtful surprises.",
                'content' => "Women's Day is a chance to celebrate confidence, care, and individuality. This guide shares practical gift ideas that combine style with everyday use, so each pick feels meaningful and wearable. Choose pieces with quality fabrics, versatile cuts, and colors that match her personality.",
                'author_name' => 'Tinnity Team',
                'featured_image' => 'https://images.unsplash.com/photo-1520975922284-9f8e3b0b8d2f',
                'published_at' => '2026-03-07 10:00:00',
                'is_active' => true,
            ],
            [
                'title' => 'Bonkers Corner Future: Beyond the Tank & Towards an Empire',
                'slug' => 'bonkers-corner-future-beyond-the-tank-towards-an-empire',
                'excerpt' => "From offline expansion to premium quality and collabs, here's what the pitch revealed next.",
                'content' => "Streetwear brands are evolving quickly from online-first players into full lifestyle labels. This breakdown highlights growth signals like offline expansion, tighter quality control, and collaboration strategy that can build long-term brand value.",
                'author_name' => 'Tinnity Team',
                'featured_image' => 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c',
                'published_at' => '2026-02-28 10:00:00',
                'is_active' => true,
            ],
            [
                'title' => 'Beyond The Hype: How Bonkers Corner Is Building Streetwear',
                'slug' => 'beyond-the-hype-how-bonkers-corner-is-building-streetwear',
                'excerpt' => 'Bonkers Corner turns its Shark Tank moment into sustainable streetwear growth and global ambition.',
                'content' => "Momentum after media attention is difficult to sustain without strong operations. This article covers how product consistency, community storytelling, and category focus help turn hype into stable growth for modern fashion brands.",
                'author_name' => 'Tinnity Team',
                'featured_image' => 'https://images.unsplash.com/photo-1520975922284-9f8e3b0b8d2f',
                'published_at' => '2026-02-27 10:00:00',
                'is_active' => true,
            ],
        ];

        foreach ($posts as $postData) {
            BlogPost::query()->updateOrCreate(
                ['slug' => $postData['slug']],
                array_merge($postData, ['created_by' => $adminId])
            );
        }
    }
}
