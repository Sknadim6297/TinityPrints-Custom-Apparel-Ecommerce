<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public static function defaults(): array
    {
        return [
            'promo_bar' => [
                'enabled' => true,
                'text' => 'Further reductions: enjoy an extra {discount} off our Sale and free home delivery',
                'discount' => '20',
            ],
            'hero_slides' => [
                [
                    'image_url' => 'https://assets.designhill.com/resize_img.php?atyp=st_page_file&pth=ad_bt_tbitlbbi_org||BT852244||three_bnr_info_two_link_btn_banner_image1_img&flp=1689746974-93380456064b77e1e722b10-73415040.png',
                    'subtitle' => 'Exclusive Collection',
                    'title_line_1' => 'Wear Your Story',
                    'title_line_2' => 'Express Yourself',
                    'button_text' => 'Shop Now',
                    'button_link' => '/shop',
                ],
                [
                    'image_url' => 'https://utkalvibes.com/wp-content/uploads/2025/10/Men-catagory-banner.webp',
                    'subtitle' => 'Limited Edition Drop',
                    'title_line_1' => 'Exclusive Designs',
                    'title_line_2' => 'Limited Quantities',
                    'button_text' => 'Shop Limited',
                    'button_link' => '/limited-edition',
                ],
                [
                    'image_url' => 'https://assets.designhill.com/resize_img.php?atyp=st_page_file&pth=ad_bt_tbitlbbi_org||BT852244||three_bnr_info_two_link_btn_banner_image1_img&flp=1689746974-93380456064b77e1e722b10-73415040.png',
                    'subtitle' => 'Custom Design Works',
                    'title_line_1' => 'Design Your Dream',
                    'title_line_2' => 'T-Shirt Today',
                    'button_text' => 'Upload Design',
                    'button_link' => '/custom-design',
                ],
                [
                    'image_url' => 'https://fashionsuggest.in/wp-content/uploads/2018/05/v-neck-t-shirts-banner-compressed-1.jpg',
                    'subtitle' => 'Premium Quality',
                    'title_line_1' => '100% Cotton Comfort',
                    'title_line_2' => 'Superior Durability',
                    'button_text' => 'Explore Now',
                    'button_link' => '/shop',
                ],
                [
                    'image_url' => 'https://api.cliftonclothing.com/files/de81ed5d5b20d294c1e4f80384aaf1da7af69304/07%20t-shirt%20marketing%20strategies%20for%20effective%20brand%20promotion%20(1).jpg',
                    'subtitle' => 'Join Our Community',
                    'title_line_1' => 'Express Yourself',
                    'title_line_2' => 'With Tinnity',
                    'button_text' => 'Get Started',
                    'button_link' => '/shop',
                ],
            ],
            'side_banners' => [
                [
                    'image_url' => 'https://static.aceomni.cmsaceturtle.com/prod/product-image/aceomni/Lee/Monobrand/LMTS005207/LMTS005207_1.jpg',
                    'title' => 'T-Shirts Collection',
                    'subtitle' => 'Premium quality comfort',
                    'button_text' => 'Shop Now',
                    'button_link' => '/shop/t-shirt',
                ],
                [
                    'image_url' => 'https://image.made-in-china.com/2f0j00yjbkIidYkhqW/Luxury-Style-Handbags-for-Lady-New-Design-Lady-Handbag-Top-Quality-Replica-Bag.webp',
                    'title' => 'Accessories',
                    'subtitle' => 'Complete your look',
                    'button_text' => 'Shop Now',
                    'button_link' => '/shop/accessories',
                ],
            ],
            'best_seller' => [
                'title' => 'Best Seller',
                'subtitle' => 'Handpicked and crafted for you',
                'view_all_text' => 'View All',
                'view_all_link' => '/shop',
                'product_limit' => 8,
            ],
            'brand_story' => [
                'image_url' => '/frontend/assets/img/banner/story.jpg',
                'title' => 'TINNITY STORY',
                'subtitle' => 'OUR STORY',
                'description' => "Tinnity isn't just a clothing brand - it's a statement. Inspired by creativity and individuality, we design unique streetwear that blends comfort with bold expression. Every piece tells a story and helps you express your identity.",
                'features' => [
                    ['icon' => 'fas fa-lightbulb', 'text' => 'Creative Expression'],
                    ['icon' => 'fas fa-heart', 'text' => 'Inclusivity'],
                    ['icon' => 'fas fa-award', 'text' => 'High Quality'],
                    ['icon' => 'fas fa-leaf', 'text' => 'Sustainability'],
                ],
            ],
            'limited_edition' => [
                'title' => 'Limited Edition',
                'subtitle' => 'Exclusive pieces crafted in limited quantities',
                'view_all_text' => 'View All',
                'view_all_link' => '/shop?limited_edition=1',
                'product_limit' => 4,
                'badge_text' => 'LIMITED',
            ],
            'limited_edition_page' => [
                'page_title' => 'Limited Edition',
                'hero_badge' => 'EXCLUSIVE COLLECTION',
                'hero_title' => 'Limited Edition Drops',
                'hero_image_url' => '',
                'hero_description' => 'Discover our exclusive limited edition collections featuring unique designs, premium materials, and special collaborations. Each piece is carefully crafted in limited quantities, making them true collector\'s items.',
                'feature_1' => 'Premium Quality',
                'feature_2' => 'Limited Time Only',
                'feature_3' => 'Exclusive Designs',
                'products_title' => 'Current Limited Edition Drops',
                'products_subtitle' => 'Get them before they\'re gone forever',
                'empty_title' => 'No Limited Edition Items Available',
                'empty_text' => 'Please check back soon for new exclusive drops.',
                'browse_text' => 'Browse Regular Collection',
                'browse_link' => '/shop',
            ],
            'collection_reels' => [
                'title' => 'Explore Our Collection',
                'cards' => [
                    [
                        'image_url' => 'https://i.etsystatic.com/42670952/r/il/339525/5953443531/il_fullxfull.5953443531_rtvw.jpg',
                        'text' => 'Styles For Every Mood',
                        'link' => '/shop',
                    ],
                    [
                        'image_url' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb',
                        'text' => 'Post Workout Look',
                        'link' => '/shop',
                    ],
                    [
                        'image_url' => 'https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e',
                        'text' => 'Premium Fabrics',
                        'link' => '/shop',
                    ],
                    [
                        'image_url' => 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c',
                        'text' => 'Behind The Scenes',
                        'link' => '/shop',
                    ],
                    [
                        'image_url' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9',
                        'text' => 'Obsessed With Quality',
                        'link' => '/shop',
                    ],
                ],
            ],
            'custom_design' => [
                'left_title' => 'DESIGN',
                'left_description' => 'Create your own custom T-shirt with your style and creativity.',
                'left_button_text' => 'Design Your Own',
                'left_button_link' => '/custom-design',
                'right_title' => 'SHOP',
                'right_description' => 'Explore our ready-made premium T-shirt collection.',
                'right_button_text' => 'Shop Collection',
                'right_button_link' => '/shop',
            ],
            'why_choose' => [
                'title' => 'Why Choose Tinnity',
                'subtitle' => 'Premium quality, unique designs and comfort that speaks your style.',
                'cards' => [
                    [
                        'icon' => 'fas fa-gem',
                        'title' => 'Premium Quality',
                        'description' => '100% premium cotton with long lasting comfort and durability.',
                    ],
                    [
                        'icon' => 'fas fa-tshirt',
                        'title' => 'Unique Designs',
                        'description' => 'Creative and limited edition designs that stand out.',
                    ],
                    [
                        'icon' => 'fas fa-shipping-fast',
                        'title' => 'Fast Delivery',
                        'description' => 'Quick and reliable delivery across India.',
                    ],
                    [
                        'icon' => 'fas fa-headset',
                        'title' => '24/7 Support',
                        'description' => 'Our team is always ready to help you anytime.',
                    ],
                ],
            ],
            'blog' => [
                'title' => 'Latest Newssss',
                'subtitle' => 'Hot off the press: All the latest news in fashion',
                'view_all_text' => 'View all posts',
                'view_all_link' => '/blog',
                'posts' => [
                    [
                        'date' => 'MARCH 07 2026',
                        'title' => 'Women\'s Day Gift Ideas 2026: Meaningful & Stylish Picks',
                        'description' => "Explore Women's Day gift ideas that feel personal and meaningful. From stylish everyday wear to thoughtful surprises.",
                        'image_url' => 'https://images.unsplash.com/photo-1520975922284-9f8e3b0b8d2f',
                        'link_text' => 'Read more',
                        'link' => '/blog',
                    ],
                    [
                        'date' => 'FEBRUARY 28 2026',
                        'title' => 'Bonkers Corner Future: Beyond the Tank & Towards an Empire',
                        'description' => 'From offline expansion to premium quality and collabs, here\'s what the pitch revealed next.',
                        'image_url' => 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c',
                        'link_text' => 'Read more',
                        'link' => '/blog',
                    ],
                    [
                        'date' => 'FEBRUARY 27 2026',
                        'title' => 'Beyond The Hype: How Bonkers Corner Is Building Streetwear',
                        'description' => 'Bonkers Corner turns its Shark Tank moment into sustainable streetwear growth and global ambition.',
                        'image_url' => 'https://images.unsplash.com/photo-1520975922284-9f8e3b0b8d2f',
                        'link_text' => 'Read more',
                        'link' => '/blog',
                    ],
                ],
            ],
            'instagram' => [
                'title' => '#TinnityStyle',
                'subtitle' => 'See how our customers rock their Tinnity tees',
                'follow_text' => 'Follow @tinnity_official',
                'follow_link' => '#',
                'items' => [
                    ['image_url' => 'https://thebanyantee.com/cdn/shop/files/Black-T-shirt.jpg?v=1768129516&width=1920'],
                    ['image_url' => 'https://static.yourprint.in/new-admin-ajax.php?action=resize_outer_image&cfcache=all&url=med-s3/d-i-o/Tshirts/Men/tshirt_hs_men_pat_d131_o.jpg&resizeTo=600'],
                    ['image_url' => 'https://mir-s3-cdn-cf.behance.net/projects/404/156a03202485905.Y3JvcCwxNDAwLDEwOTUsMCwxNTI.jpg'],
                    ['image_url' => 'https://hardtimesclothing.co.uk/cdn/shop/files/Destiny_sCrossroadsfbwm.webp?v=1754601122'],
                    ['image_url' => 'https://source.unsplash.com/404x400/?tshirt,clothing'],
                    ['image_url' => 'https://source.unsplash.com/405x400/?tshirt,style'],
                    ['image_url' => 'https://source.unsplash.com/406x400/?tshirt,street'],
                    ['image_url' => 'https://source.unsplash.com/407x400/?tshirt,brand'],
                ],
            ],
            'contact_cta' => [
                'title' => "Need Help? We're Here!",
                'description' => 'Have questions? Our support team is ready to assist you 24/7',
                'whatsapp_text' => 'WhatsApp Support',
                'whatsapp_link' => 'https://wa.me/1234567890',
                'email_text' => 'Email Us',
                'email_link' => 'mailto:support@tinnity.com',
            ],
            'feature_boxes' => [
                ['title' => 'Free Shipping', 'description' => 'On All Order Over $599'],
                ['title' => 'Easy Returns', 'description' => '30 Day Returns Policy'],
                ['title' => 'Secure Payment', 'description' => '100% Secure Guarantee'],
                ['title' => 'Special Support', 'description' => '24/7 Dedicated Support'],
            ],
        ];
    }

    public static function mergedData(?array $data): array
    {
        $data = $data ?? [];
        return array_replace_recursive(self::defaults(), $data);
    }

    public static function promoBarData(): array
    {
        $settings = self::first();
        $merged = self::mergedData($settings?->data);

        return $merged['promo_bar'] ?? self::defaults()['promo_bar'];
    }

    public static function promoBarHtml(?array $promoBar = null): string
    {
        $promoBar = $promoBar ?? self::promoBarData();
        $text = (string) ($promoBar['text'] ?? '');
        $discount = trim((string) ($promoBar['discount'] ?? '20'));

        if ($discount === '') {
            $discount = '20';
        }

        $discountHtml = '<span>' . e($discount) . '%</span>';

        if (str_contains($text, '{discount}')) {
            $parts = explode('{discount}', $text, 2);

            return e($parts[0]) . $discountHtml . e($parts[1] ?? '');
        }

        return e($text) . ' ' . $discountHtml;
    }
}
