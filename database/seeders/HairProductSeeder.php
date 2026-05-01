<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class HairProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🌱 Starting hair product seeding...');

        // Create Categories
        $categories = [
            [
                'name' => 'Wigs',
                'slug' => 'wigs',
                'description' => 'Premium quality wigs for every occasion',
                'is_active' => true,
                'subcategories' => [
                    ['name' => 'Lace Front Wigs', 'slug' => 'lace-front-wigs'],
                    ['name' => 'Full Lace Wigs', 'slug' => 'full-lace-wigs'],
                    ['name' => 'HD Lace Wigs', 'slug' => 'hd-lace-wigs'],
                    ['name' => 'Closure Wigs', 'slug' => 'closure-wigs'],
                ]
            ],
            [
                'name' => 'Weaves',
                'slug' => 'weaves',
                'description' => '100% human hair bundles',
                'is_active' => true,
                'subcategories' => [
                    ['name' => 'Brazilian Hair', 'slug' => 'brazilian-hair'],
                    ['name' => 'Peruvian Hair', 'slug' => 'peruvian-hair'],
                    ['name' => 'Malaysian Hair', 'slug' => 'malaysian-hair'],
                ]
            ],
            [
                'name' => 'Closures',
                'slug' => 'closures',
                'description' => 'Lace closures and frontals',
                'is_active' => true,
                'subcategories' => [
                    ['name' => '4x4 Closures', 'slug' => '4x4-closures'],
                    ['name' => '5x5 Closures', 'slug' => '5x5-closures'],
                    ['name' => '13x4 Frontals', 'slug' => '13x4-frontals'],
                ]
            ],
            [
                'name' => 'Extensions',
                'slug' => 'extensions',
                'description' => 'Clip-in and tape extensions',
                'is_active' => true,
                'subcategories' => []
            ],
        ];

        $categoryModels = [];
        foreach ($categories as $categoryData) {
            $category = Category::create([
                'name' => $categoryData['name'],
                'slug' => $categoryData['slug'],
                'description' => $categoryData['description'],
                'is_active' => $categoryData['is_active'],
            ]);
            $categoryModels[$categoryData['slug']] = $category;

            // Create subcategories
            foreach ($categoryData['subcategories'] as $subcat) {
                Category::create([
                    'name' => $subcat['name'],
                    'slug' => $subcat['slug'],
                    'parent_id' => $category->id,
                    'is_active' => true,
                ]);
            }
        }

        $this->command->info('✅ Created ' . count($categories) . ' categories');

        // Product data with image keywords
        $products = [
            // WIGS
            ['name' => 'Luxury Brazilian Straight Lace Front Wig', 'category' => 'wigs', 'description' => 'Premium quality Brazilian straight hair lace front wig. Natural hairline, pre-plucked with baby hair.', 'details' => '<p>Features:</p><ul><li>100% Virgin Human Hair</li><li>Pre-plucked hairline</li><li>Natural baby hair</li><li>Adjustable straps</li><li>Can be dyed and styled</li></ul>', 'base_price' => 45000, 'compare_at_price' => 60000, 'is_featured' => true, 'image_keywords' => 'straight'],
            ['name' => 'HD Lace Body Wave Wig', 'category' => 'wigs', 'description' => 'Invisible HD lace wig with beautiful body wave texture. Melts into your skin perfectly.', 'details' => '<p>Premium HD lace for invisible hairline. Perfect for special occasions.</p>', 'base_price' => 55000, 'compare_at_price' => 75000, 'is_featured' => true, 'image_keywords' => 'wavy'],
            ['name' => 'Curly Full Lace Wig', 'category' => 'wigs', 'description' => 'Gorgeous curly full lace wig. Can be styled in any direction with natural bounce.', 'details' => '<p>Full lace construction allows for versatile styling options.</p>', 'base_price' => 65000, 'compare_at_price' => 85000, 'is_featured' => false, 'image_keywords' => 'curly'],
            ['name' => 'Kinky Straight Closure Wig', 'category' => 'wigs', 'description' => 'Natural kinky straight texture perfect for African hair. Blends seamlessly.', 'details' => '<p>Yaki texture that mimics relaxed African hair.</p>', 'base_price' => 40000, 'compare_at_price' => null, 'is_featured' => false, 'image_keywords' => 'straight'],
            ['name' => 'Blonde Wavy Lace Front Wig', 'category' => 'wigs', 'description' => 'Stunning blonde wavy wig. Pre-colored and ready to wear.', 'details' => '<p>Color: #613 Blonde. Can be toned to your preference.</p>', 'base_price' => 70000, 'compare_at_price' => 90000, 'is_featured' => true, 'image_keywords' => 'blonde'],
            // WEAVES
            ['name' => 'Brazilian Straight Hair Bundle', 'category' => 'weaves', 'description' => 'Premium Brazilian straight hair. Soft, silky, and tangle-free.', 'details' => '<p>Grade: 10A. Can last 1-2 years with proper care.</p>', 'base_price' => 15000, 'compare_at_price' => 20000, 'is_featured' => true, 'image_keywords' => 'straight'],
            ['name' => 'Peruvian Body Wave Bundle', 'category' => 'weaves', 'description' => 'Luxurious Peruvian body wave. Natural shine and bounce.', 'details' => '<p>Perfect for a glamorous look. Holds curl well.</p>', 'base_price' => 18000, 'compare_at_price' => null, 'is_featured' => false, 'image_keywords' => 'wavy'],
            ['name' => 'Malaysian Curly Hair Bundle', 'category' => 'weaves', 'description' => 'Beautiful Malaysian curly hair. Defined curls that last.', 'details' => '<p>Low maintenance curls. Minimal shedding.</p>', 'base_price' => 20000, 'compare_at_price' => 25000, 'is_featured' => true, 'image_keywords' => 'curly'],
            ['name' => 'Deep Wave Hair Bundle', 'category' => 'weaves', 'description' => 'Gorgeous deep wave pattern. Full and voluminous.', 'details' => '<p>Creates a dramatic, glamorous look.</p>', 'base_price' => 22000, 'compare_at_price' => null, 'is_featured' => false, 'image_keywords' => 'wavy'],
            ['name' => 'Kinky Curly Hair Bundle', 'category' => 'weaves', 'description' => 'Natural kinky curly texture. Perfect for a natural look.', 'details' => '<p>Blends well with natural African hair texture.</p>', 'base_price' => 25000, 'compare_at_price' => 30000, 'is_featured' => false, 'image_keywords' => 'curly'],
            // CLOSURES
            ['name' => '4x4 Lace Closure Straight', 'category' => 'closures', 'description' => '4x4 lace closure in straight texture. Natural parting.', 'details' => '<p>Free part, middle part, or side part options.</p>', 'base_price' => 12000, 'compare_at_price' => 15000, 'is_featured' => false, 'image_keywords' => 'straight'],
            ['name' => '5x5 HD Lace Closure Body Wave', 'category' => 'closures', 'description' => 'Larger 5x5 HD lace closure with body wave texture.', 'details' => '<p>More parting space for versatile styling.</p>', 'base_price' => 18000, 'compare_at_price' => null, 'is_featured' => true, 'image_keywords' => 'wavy'],
            ['name' => '13x4 Lace Frontal Curly', 'category' => 'closures', 'description' => 'Ear to ear lace frontal with curly texture.', 'details' => '<p>Covers entire hairline for a natural look.</p>', 'base_price' => 25000, 'compare_at_price' => 32000, 'is_featured' => true, 'image_keywords' => 'curly'],
            // EXTENSIONS
            ['name' => 'Clip-In Hair Extensions Straight', 'category' => 'extensions', 'description' => 'Easy clip-in extensions. Instant length and volume.', 'details' => '<p>7 pieces set. Easy to install and remove.</p>', 'base_price' => 20000, 'compare_at_price' => null, 'is_featured' => false, 'image_keywords' => 'straight'],
            ['name' => 'Tape-In Extensions Wavy', 'category' => 'extensions', 'description' => 'Seamless tape-in extensions with wavy texture.', 'details' => '<p>20 pieces. Lasts 6-8 weeks.</p>', 'base_price' => 30000, 'compare_at_price' => 38000, 'is_featured' => false, 'image_keywords' => 'wavy'],
        ];

        $lengths = ['10"', '12"', '14"', '16"', '18"', '20"', '22"', '24"', '26"', '28"', '30"'];

        $this->command->info('📦 Creating products and variants...');

        foreach ($products as $productData) {
            $product = Product::create([
                'name' => $productData['name'],
                'slug' => Str::slug($productData['name']),
                'description' => $productData['description'],
                'details' => $productData['details'],
                'category_id' => $categoryModels[$productData['category']]->id,
                'base_price' => $productData['base_price'],
                'compare_at_price' => $productData['compare_at_price'],
                'is_active' => true,
                'is_featured' => $productData['is_featured'],
            ]);

            // Add images
            $this->addProductImages($product, $productData['image_keywords']);

            // Determine textures
            $productTextures = [];
            if (str_contains(strtolower($product->name), 'straight')) $productTextures = ['straight'];
            elseif (str_contains(strtolower($product->name), 'wavy') || str_contains(strtolower($product->name), 'wave')) $productTextures = ['wavy'];
            elseif (str_contains(strtolower($product->name), 'curly')) $productTextures = ['curly'];
            elseif (str_contains(strtolower($product->name), 'kinky')) $productTextures = ['kinky'];
            else $productTextures = ['straight', 'wavy'];

            // Determine colors
            $productColors = str_contains(strtolower($product->name), 'blonde') ? ['blonde', 'ombre'] : ['natural black', '1B'];

            // Create variants
            $variantLengths = $productData['category'] === 'closures' ? ['10"', '12"', '14"', '16"', '18"'] : ['14"', '16"', '18"', '20"', '22"', '24"', '26"', '28"'];

            foreach ($variantLengths as $length) {
                foreach ($productTextures as $texture) {
                    foreach ($productColors as $color) {
                        $lengthMultiplier = 1 + (array_search($length, $lengths) * 0.05);
                        $variantPrice = round($product->base_price * $lengthMultiplier, -2);

                        ProductVariant::create([
                            'product_id' => $product->id,
                            'sku' => strtoupper(Str::random(8)),
                            'length' => $length,
                            'texture' => $texture,
                            'color' => $color,
                            'price' => $variantPrice,
                            'stock_quantity' => rand(5, 50),
                        ]);
                    }
                }
            }

            $this->command->info('  ✓ Created: ' . $product->name);
        }

        $this->command->info('');
        $this->command->info('🎉 Seeding completed successfully!');
        $this->command->info('✅ Created ' . count($categories) . ' categories');
        $this->command->info('✅ Created ' . count($products) . ' products');
        $this->command->info('✅ Created ' . ProductVariant::count() . ' product variants');
        $this->command->info('✅ Created ' . ProductImage::count() . ' product images');
    }

    private function addProductImages(Product $product, string $keywords): void
    {
        // Select images based on keywords
        if (str_contains($keywords, 'straight')) {
            $selectedUrls = [
                "https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=800&h=800&fit=crop",
                "https://images.unsplash.com/photo-1487412947147-5cebf100ffc2?w=800&h=800&fit=crop",
            ];
        } elseif (str_contains($keywords, 'wavy') || str_contains($keywords, 'wave')) {
            $selectedUrls = [
                "https://images.unsplash.com/photo-1595475884562-073c30d45670?w=800&h=800&fit=crop",
                "https://images.unsplash.com/photo-1519699047748-de8e457a634e?w=800&h=800&fit=crop",
            ];
        } elseif (str_contains($keywords, 'curly')) {
            $selectedUrls = [
                "https://images.unsplash.com/photo-1560869713-7d0a29430803?w=800&h=800&fit=crop",
                "https://images.unsplash.com/photo-1531891437562-4301cf35b7e4?w=800&h=800&fit=crop",
            ];
        } elseif (str_contains($keywords, 'blonde')) {
            $selectedUrls = [
                "https://images.unsplash.com/photo-1594744803329-e58b31de8bf5?w=800&h=800&fit=crop",
                "https://images.unsplash.com/photo-1526047932273-341f2a7631f9?w=800&h=800&fit=crop",
            ];
        } else {
            $selectedUrls = [
                "https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=800&h=800&fit=crop",
                "https://images.unsplash.com/photo-1595475884562-073c30d45670?w=800&h=800&fit=crop",
            ];
        }

        // Create product images (store URLs directly)
        foreach ($selectedUrls as $index => $url) {
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $url,
                'alt_text' => $product->name,
                'is_primary' => $index === 0,
                'sort_order' => $index + 1,
            ]);
        }
    }
}
