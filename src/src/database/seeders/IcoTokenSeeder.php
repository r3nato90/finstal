<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class IcoTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tokens = [
            [
                'name' => 'TechCoin',
                'symbol' => 'TECH',
                'total_supply' => '1000000.000000000000000000',
                'price' => '0.500000000000000000',
                'current_price' => '0.500000000000000000',
                'description' => 'A revolutionary blockchain technology token designed for the future of decentralized applications and smart contracts.',
                'price_updated_at' => Carbon::now(),
                'tokens_sold' => 0,
                'sale_start_date' => Carbon::now()->subDays(30)->format('Y-m-d'),
                'sale_end_date' => Carbon::now()->addDays(60)->format('Y-m-d'),
                'is_featured' => true,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'GreenEnergy Token',
                'symbol' => 'GREEN',
                'total_supply' => '2000000.000000000000000000',
                'price' => '0.250000000000000000',
                'current_price' => '0.280000000000000000',
                'description' => 'Supporting renewable energy projects worldwide through blockchain technology and sustainable investment opportunities.',
                'price_updated_at' => Carbon::now()->subHours(6),
                'tokens_sold' => 0,
                'sale_start_date' => Carbon::now()->subDays(45)->format('Y-m-d'),
                'sale_end_date' => Carbon::now()->addDays(45)->format('Y-m-d'),
                'is_featured' => true,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'MetaVerse Coin',
                'symbol' => 'META',
                'total_supply' => '5000000.000000000000000000',
                'price' => '0.100000000000000000',
                'current_price' => '0.120000000000000000',
                'description' => 'The native token for next-generation virtual reality platforms and metaverse experiences.',
                'price_updated_at' => Carbon::now()->subHours(12),
                'tokens_sold' => 0,
                'sale_start_date' => Carbon::now()->subDays(60)->format('Y-m-d'),
                'sale_end_date' => Carbon::now()->addDays(30)->format('Y-m-d'),
                'is_featured' => false,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'HealthChain Token',
                'symbol' => 'HEALTH',
                'total_supply' => '800000.000000000000000000',
                'price' => '1.500000000000000000',
                'current_price' => '1.500000000000000000',
                'description' => 'Revolutionizing healthcare data management and medical research through secure blockchain solutions.',
                'price_updated_at' => Carbon::now()->subDays(1),
                'tokens_sold' => 0,
                'sale_start_date' => Carbon::now()->subDays(15)->format('Y-m-d'),
                'sale_end_date' => Carbon::now()->addDays(75)->format('Y-m-d'),
                'is_featured' => false,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'GameFi Token',
                'symbol' => 'GAME',
                'total_supply' => '10000000.000000000000000000',
                'price' => '0.050000000000000000',
                'current_price' => '0.065000000000000000',
                'description' => 'Powering the next generation of play-to-earn games and NFT gaming ecosystems.',
                'price_updated_at' => Carbon::now()->subHours(3),
                'tokens_sold' => 0,
                'sale_start_date' => Carbon::now()->subDays(90)->format('Y-m-d'),
                'sale_end_date' => Carbon::now()->addDays(10)->format('Y-m-d'),
                'is_featured' => true,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'AI Analytics Token',
                'symbol' => 'AINA',
                'total_supply' => '1500000.000000000000000000',
                'price' => '2.000000000000000000',
                'current_price' => '2.000000000000000000',
                'description' => 'Leveraging artificial intelligence for advanced data analytics and machine learning applications.',
                'price_updated_at' => Carbon::now()->subHours(8),
                'tokens_sold' => 0,
                'sale_start_date' => Carbon::now()->subDays(10)->format('Y-m-d'),
                'sale_end_date' => Carbon::now()->addDays(80)->format('Y-m-d'),
                'is_featured' => true,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('tokens')->insert($tokens);
    }
}
