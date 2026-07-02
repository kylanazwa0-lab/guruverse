<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Panduan Praktis Kurikulum Merdeka 2026',
                'author' => 'Guruverse Press',
                'type' => 'e-book',
                'price' => 50000,
                'member_price' => 0,
                'payment_link' => 'https://guruverseid.myr.id/ebook/fun-learning-system/',
                'image' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?q=80&w=400&auto=format&fit=crop',
                'badge' => 'Gratis untuk Member',
                'badge_color' => 'rgba(16, 185, 129, 0.9)'
            ],
            [
                'name' => 'Webinar Interaktif: Strategi Mengajar dengan AI',
                'author' => 'Tim Edukator',
                'type' => 'pelatihan',
                'price' => 150000,
                'member_price' => 100000,
                'image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=400&auto=format&fit=crop',
                'badge' => 'Pelatihan',
                'badge_color' => 'rgba(245, 158, 11, 0.9)'
            ],
            [
                'name' => 'Tote Bag Kanvas Premium "Guru Inspiratif"',
                'author' => 'Guruverse Store',
                'type' => 'merchandise',
                'price' => 85000,
                'member_price' => 75000,
                'image' => null,
                'badge' => 'Merchandise',
                'badge_color' => 'rgba(124, 58, 237, 0.9)'
            ],
            [
                'name' => 'Psikologi Pendidikan: Memahami Generasi Alpha',
                'author' => 'Dr. Setiawan',
                'type' => 'e-book',
                'price' => 75000,
                'member_price' => 0,
                'image' => 'https://images.unsplash.com/photo-1553877522-43269d4ea984?q=80&w=400&auto=format&fit=crop',
                'badge' => 'Gratis untuk Member',
                'badge_color' => 'rgba(16, 185, 129, 0.9)'
            ]
        ];

        foreach ($products as $p) {
            \App\Models\Product::create($p);
        }
    }
}
