-- ============================================
-- BOOK SHOP SEED DATA
-- ============================================

USE book_shop;


-- ============================================
-- 1. CATEGORY
-- ============================================

INSERT INTO category (id, category_name) VALUES
(1, 'Classical Literature / Drama'),
(2, 'Dystopian'),
(3, 'Adventure'),
(4, 'Romance'),
(5, 'Horror'),
(6, 'Psychological Thriller'),
(8, 'Jazz and Pop'),
(9, 'Fiction'),
(10, 'Visual Art');


-- ============================================
-- 2. PRODUCTS
-- ============================================

INSERT INTO products
(
    id,
    title,
    price,
    stock_quantity,
    category_id,
    popularity_product,
    description,
    img,
    weight_kg
)
VALUES
(
    1,
    '1984',
    40,
    7,
    2,
    7,
    'Big Brother is watching. In a world of lies and control, one man dares to rebel at a terrifying cost.',
    'assets/book1-1984.png',
    0.30
),
(
    2,
    'Brave New World',
    49,
    10,
    2,
    1,
    'Perfect happiness. Zero freedom. Would you sacrifice your soul for a painless life?',
    'assets/book2-brave-new-world.png',
    0.20
),
(
    3,
    'The Great Gatsby',
    55,
    5,
    1,
    10,
    'Behind the glittering parties lies a story of obsession, illusion, and a dream that can never be reclaimed.',
    'assets/book3-great-gatsby.png',
    0.30
),
(
    4,
    'To Kill a Mockingbird',
    45,
    2,
    1,
    3,
    'In a town divided by prejudice, one voice stands for justice—and changes everything.',
    'assets/book4-mockinggbird.png',
    0.50
),
(
    5,
    'The Catcher in the Rye',
    49,
    3,
    1,
    4,
    'Lost, angry, and searching for truth—one boy’s journey through a world that feels completely fake.',
    'assets/book5-catch.png',
    0.20
),
(
    6,
    'Pride and Prejudice',
    69,
    2,
    4,
    8,
    'Love ignites where pride stands in the way. Will first impressions destroy their chance at happiness?',
    'assets/book6-pride.png',
    0.20
),
(
    7,
    'Dracula',
    70,
    1,
    5,
    9,
    'From the shadows, he rises. A battle between darkness and light begins.',
    'assets/book7-dracula.png',
    0.10
),
(
    8,
    'Frankenstein',
    49,
    2,
    5,
    6,
    'He created life… but at what cost? A chilling tale of ambition, horror, and regret.',
    'assets/book8-frankin.png',
    1.10
),
(
    9,
    'Crime and Punishment',
    45,
    4,
    6,
    2,
    'One crime. Endless guilt. How far can a man run from his own conscience?',
    'assets/book9-crime-punishment.png',
    0.60
),
(
    10,
    'Moby-Dick',
    65,
    2,
    3,
    5,
    'One man. One whale. An obsession that will drag them all into the depths.',
    'assets/book10-mobydick.png',
    0.60
),
(
    11,
    'Fahrenheit 451',
    66,
    5,
    2,
    6,
    'Sixty years after its originally publication, Ray Bradbury’s internationally acclaimed novel Fahrenheit 451 stands as a classic of world literature set in a bleak, dystopian future. Today its message has grown more relevant than ever before.',
    'assets/book11-fahrenheit.png',
    0.70
),
(
    12,
    'Jazz Exercises, Minuets, Etudes & Pieces for Piano',
    45,
    4,
    8,
    8,
    'Legendary jazz pianist Oscar Peterson has long been devoted to the education of piano students. In this book he offers dozens of pieces designed to empower the student, whether novice or classically trained, with the technique needed to become an accomplished jazz pianist.',
    'assets/book12-jazz.png',
    0.10
),
(
    13,
    'Simone Best of Nina Simone - Original Keys for Singers',
    50,
    2,
    8,
    9,
    'One of the most powerful live performers of her time, Nina Simone mixed jazz, blues, soul, classical and more to create a genre all her own. This book features authentic transcriptions in the original keys of 23 Simone classics.',
    'assets/book13-simone.png',
    0.30
),
(
    14,
    'Jazz Blues - Jazz Piano Solos, Vol. 2',
    59,
    3,
    8,
    8,
    'This second edition features piano solo arrangements with chord names for 25 bluesy jazz classics.',
    'assets/book14-jazzblues.png',
    0.30
),
(
    15,
    'Peterson, Oscar - Omnibook for Piano',
    79,
    1,
    8,
    10,
    'This is the ultimate resource for studying the work of Oscar Peterson! Nearly 40 full piano transcriptions for the jazz piano master.',
    'assets/book15-peterson.png',
    0.30
),
(
    16,
    'Parable of the Sower',
    89,
    2,
    9,
    10,
    'This acclaimed post-apocalyptic novel of hope and terror from an award-winning author “pairs well with 1984 or The Handmaid’s Tale” and includes a foreword by N. K. Jemisin.',
    'assets/book16-parable.png',
    0.40
),
(
    17,
    'Dancing for Degas',
    99,
    3,
    9,
    10,
    'In the City of Lights, at the dawn of a new age, begins an unforgettable story of great love, great art—and the most painful choices of the heart.',
    'assets/book17-dancing.png',
    0.40
),
(
    18,
    'Van Gogh and Music: A Symphony in Blue and Yellow',
    69,
    2,
    10,
    10,
    '“Ah! . . . to make of painting what the music of Berlioz and Wagner has been before us . . . a consolatory art for distressed hearts!”—Vincent van Gogh.',
    'assets/book18-van-gogh.png',
    0.10
),
(
    19,
    'Designa',
    89,
    2,
    10,
    5,
    'Following the success of Quadrivium and Sciencia, a compendium of six titles on art and design in the acclaimed Wooden Books series appears here in one volume.',
    'assets/book19-designa.png',
    0.90
);


-- ============================================
-- 3. FREIGHT RULES
-- ============================================

INSERT INTO freight_rules
(
    zone_code,
    zone_name,
    base_fee,
    weight_modifier,
    free_shipping_threshold
)
VALUES
(
    'SE_ZON_1',
    'Götaland & Svealand (Södra/Mellersta Sverige)',
    79.00,
    4.50,
    999.00
),
(
    'SE_ZON_2',
    'Nedre Norrland (Kust & Inland)',
    119.00,
    6.00,
    1499.00
),
(
    'SE_ZON_3',
    'Övre Norrland & Glesbygd',
    159.00,
    9.50,
    2499.00
),
(
    'NO_DK_NORDIC',
    'Danmark & Norge (Grannländer)',
    249.00,
    15.00,
    3500.00
),
(
    'EU_ZON_1',
    'Europa Standard (Tyskland, Benelux, Frankrike)',
    299.00,
    22.50,
    5000.00
);