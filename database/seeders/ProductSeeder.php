<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data =
            [
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2024/5/8/3a87cc3f-f2bb-41bc-a4b1-f686f2010f76.jpg',
                    'title' => 'SKINTIFIC Peeling Set 3pcs Exfoliating Barrier 5X Ceramide Moisturizer Latic Acid Exfoliating Serum Glycolic Acid Toner',
                    'category_id' => '4',
                    'price' => '342000',
                    'weight' => '300',
                    'description' => 'Set peeling kulit ini dirancang khusus untuk memberikan perawatan kulit yang komprehensif dan efektif, terdiri dari tiga produk utama => pelembap, serum pengelupas, dan toner pengelupas. Pelembap dalam set ini diperkaya dengan 5X Ceramide, yang berfungsi untuk mengunci kelembapan, memperkuat penghalang kulit, dan mencegah kehilangan air, sehingga kulit tetap terhidrasi dan kenyal. Serum pengelupas mengandung Lactic Acid, yang dikenal sebagai AHA (Alpha Hydroxy Acid) yang lembut namun efektif, membantu mengangkat sel-sel kulit mati, meratakan tekstur kulit, dan mencerahkan tampilan kulit. Sementara itu, toner pengelupas dengan Glycolic Acid, AHA yang lebih kuat, bekerja lebih dalam untuk membersihkan pori-pori, mengurangi tampilan garis halus, dan memperbaiki warna kulit yang tidak merata. Kombinasi ketiga produk ini tidak hanya membantu menghaluskan dan melembapkan kulit, tetapi juga memperbaiki penghalang kulit, menjadikannya lebih sehat, bercahaya, dan tampak lebih muda. ',
                ],
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2024/5/8/e10f6e50-d835-4dfb-8dc5-c01b17284fde.png',
                    'title' => 'SKINTIFIC Exfoliating Barrier 2PCS 5X Ceramide Moisturizer Latic Acid Exfoliating Serum',
                    'category_id' => '4',
                    'price' => '247000',
                    'weight' => '200',
                    'description' => 'Paket penghalus kulit ini dirancang khusus untuk memberikan perawatan kulit yang optimal melalui kombinasi dua produk unggulan => pelembap dengan kandungan 5X Ceramide dan serum pengelupas yang mengandung Lactic Acid. Pelembap dengan 5X Ceramide berfungsi untuk memperkuat lapisan pelindung kulit, menjaga kelembapan, dan mencegah kehilangan air, sehingga kulit Anda tetap terhidrasi sepanjang hari. Sementara itu, serum pengelupas dengan Lactic Acid bekerja secara efektif untuk mengangkat sel-sel kulit mati, mempercepat regenerasi sel, dan meningkatkan tekstur kulit, menjadikannya lebih halus dan bercahaya. Dengan penggunaan rutin dari kedua produk ini, Anda akan merasakan perubahan signifikan pada kulit Anda yang menjadi lebih lembut, kenyal, dan terhidrasi dengan baik, memberikan tampilan yang lebih sehat dan segar. ',
                ],
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2024/5/24/6d506ead-6022-4308-8344-f18b2911cd12.jpg',
                    'title' => 'SKINTIFIC 5pcs Paket Anti Acne Skincare Set Calming',
                    'category_id' => '6',
                    'price' => '539000',
                    'weight' => '500',
                    'description' => 'Paket perawatan kulit anti jerawat ini dirancang khusus untuk meredakan dan memperbaiki tekstur kulit yang bermasalah. Setiap produk dalam paket ini diformulasikan dengan bahan-bahan aktif yang bekerja sinergis untuk memberikan hasil yang menenangkan dan mengurangi kemerahan pada kulit. Mulai dari pembersih wajah yang lembut namun efektif mengangkat kotoran dan minyak berlebih, toner yang menyeimbangkan pH kulit dan menghidrasi, serum yang mengandung bahan anti-inflamasi untuk mengurangi peradangan, hingga pelembap yang ringan namun kaya akan nutrisi untuk memperbaiki dan memperkuat lapisan pelindung kulit. Dengan penggunaan rutin, paket ini tidak hanya membantu mengatasi jerawat, tetapi juga meningkatkan tekstur kulit, menjadikannya lebih halus, cerah, dan sehat. ',
                ],
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2024/5/24/955a036d-cc81-4f20-ad17-7523e78f1cfc.jpg',
                    'title' => 'SKINTIFIC 5pcs Paket 5X Ceramide Repair Skincare Set Glowing',
                    'category_id' => '7',
                    'price' => '549000',
                    'weight' => '500',
                    'description' => 'Paket perawatan kulit dengan 5X Ceramide ini dirancang khusus untuk memperbaiki dan memperkuat penghalang alami kulit, sekaligus memberikan kilau alami yang sehat. Setiap produk dalam paket ini mengandung formula 5X Ceramide yang kaya akan manfaat pelembap dan perbaikan kulit, membantu menjaga kelembapan, mengurangi kekeringan, dan mencegah iritasi. Dengan penggunaan rutin, produk-produk ini bekerja sinergis untuk memperbaiki tekstur kulit, membuatnya lebih halus, lembut, dan bercahaya. Selain itu, formula ini membantu mengurangi tanda-tanda penuaan dini dan melindungi kulit dari faktor-faktor eksternal yang merusak, sehingga kulit tampak lebih muda, sehat, dan bersinar secara alami. ',
                ],
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2024/5/24/9c2072c2-cc70-4784-a5ef-b710de516dd7.jpg',
                    'title' => 'SKINTIFIC 5pcs Paket Syswhite 377 Dark Spot Skincare Set Glowing',
                    'category_id' => '2',
                    'price' => '539000',
                    'weight' => '500',
                    'description' => 'Paket perawatan kulit dengan formula Syswhite 377 ini dirancang khusus untuk mengurangi bintik hitam dan memberikan kilau alami pada kulit. Setiap produk dalam paket ini diformulasikan dengan Syswhite 377, yang dikenal efektif dalam mengatasi masalah hiperpigmentasi dengan cara menghambat produksi melanin berlebih pada kulit. Penggunaan rutin produk-produk ini membantu memudarkan bintik-bintik hitam, meratakan warna kulit, dan mencerahkan area-area yang gelap. Selain itu, produk ini juga memberikan hidrasi mendalam, membuat kulit terasa lembut dan kenyal. Dengan bahan-bahan aktif yang bekerja sinergis, paket ini bertujuan untuk memberikan kulit yang lebih cerah, bercahaya, dan bebas dari noda, sehingga tampilan kulit menjadi lebih merata dan sehat secara keseluruhan. ',
                ],
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2024/5/24/793782e2-c5dc-4371-8938-c8b19f56ee3a.jpg',
                    'title' => 'SKINTIFIC 5pcs Paket MSH Niacinamide Skincare Set Glowing',
                    'category_id' => '2',
                    'price' => '539000',
                    'weight' => '500',
                    'description' => 'Paket perawatan kulit ini dirancang khusus dengan kandungan Niacinamide untuk membantu meratakan warna kulit dan memberikan kilau alami yang sehat. Setiap produk dalam paket ini diformulasikan dengan bahan-bahan berkualitas tinggi yang bekerja sinergis untuk mengatasi masalah kulit seperti hiperpigmentasi, noda hitam, dan tekstur kulit yang tidak merata. Niacinamide, sebagai bahan utama, dikenal karena kemampuannya untuk memperkuat lapisan pelindung kulit, mengurangi peradangan, dan meningkatkan elastisitas kulit. Selain itu, produk-produk ini juga diperkaya dengan antioksidan dan pelembap yang membantu menjaga kelembapan kulit sepanjang hari, sehingga kulit tampak lebih cerah, halus, dan bercahaya. Dengan penggunaan rutin, paket perawatan kulit ini tidak hanya memberikan hasil yang terlihat, tetapi juga meningkatkan kesehatan kulit secara keseluruhan, menjadikannya pilihan ideal bagi mereka yang menginginkan kulit yang tampak lebih muda dan bercahaya. ',
                ],
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2024/5/24/f11a60ac-77fd-4889-90b6-2e6f1a6b2bec.jpg',
                    'title' => 'SALE SKINTIFIC 3pcs Paket MSH Niacinamide Skincare Set Glowing',
                    'category_id' => '2',
                    'price' => '349000',
                    'weight' => '300',
                    'description' => 'Paket perawatan kulit dengan Niacinamide (Vitamin B3) ini menawarkan solusi komprehensif untuk mendapatkan kulit yang cerah dan bersinar dengan harga yang terjangkau. Setiap produk dalam paket ini dirancang secara khusus untuk mengatasi berbagai masalah kulit seperti hiperpigmentasi, jerawat, dan tanda-tanda penuaan. Niacinamide, sebagai bahan utama, dikenal karena kemampuannya untuk memperbaiki tekstur kulit, mengurangi peradangan, dan meningkatkan elastisitas kulit. Selain itu, produk-produk ini juga diperkaya dengan bahan-bahan alami lainnya yang bekerja sinergis untuk memberikan hidrasi optimal dan melindungi kulit dari kerusakan lingkungan. Dengan penawaran khusus ini, Anda tidak hanya mendapatkan manfaat dari perawatan kulit berkualitas tinggi, tetapi juga menghemat biaya, menjadikannya pilihan ideal bagi siapa saja yang ingin merawat kulit mereka tanpa harus mengeluarkan banyak uang. ',
                ],
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2024/5/24/15bcb63d-2be6-4deb-9029-e6684735eaf2.jpg',
                    'title' => 'SALE SKINTIFIC 3pcs Paket Syswhite 377 Dark Spot Skincare Set Glowing',
                    'category_id' => '2',
                    'price' => '349000',
                    'weight' => '300',
                    'description' => 'Paket perawatan kulit dengan formula Syswhite 377 ini ditawarkan dengan penawaran spesial untuk membantu mengurangi bintik hitam dan hiperpigmentasi dengan harga yang lebih terjangkau. Setiap produk dalam paket ini mengandung Syswhite 377, yang terbukti efektif dalam menghambat produksi melanin berlebih, sehingga bintik hitam memudar dan warna kulit menjadi lebih merata. Paket ini tidak hanya membantu mengatasi masalah hiperpigmentasi, tetapi juga memberikan hidrasi yang cukup, membuat kulit terasa lebih lembut dan kenyal. Dengan penggunaan rutin, kulit Anda akan tampak lebih cerah, bersinar, dan sehat. Manfaatkan penawaran spesial ini untuk mendapatkan kulit yang lebih bersih dan bercahaya tanpa harus merogoh kocek terlalu dalam. ',
                ],
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2024/5/24/22686ae0-69fc-4ef0-8935-24ec9583ac1e.jpg',
                    'title' => 'SALE SKINTIFIC 3pcs Paket 5X Ceramide Skincare Set',
                    'category_id' => '7',
                    'price' => '359000',
                    'weight' => '300',
                    'description' => 'Paket perawatan kulit eksklusif ini menawarkan formulasi unggulan dengan kandungan 5X Ceramide yang telah terbukti secara klinis untuk memperbaiki dan memperkuat penghalang kulit, serta memberikan kelembapan ekstra yang tahan lama. Setiap produk dalam paket ini dirancang khusus untuk mengatasi berbagai masalah kulit, mulai dari kekeringan, iritasi, hingga penuaan dini, dengan cara yang lembut namun efektif. Ceramide, sebagai komponen utama, bekerja sinergis dengan bahan-bahan aktif lainnya untuk mengunci kelembapan, memperbaiki tekstur kulit, dan meningkatkan elastisitas, sehingga kulit tampak lebih sehat, kenyal, dan bercahaya. Ditawarkan dengan harga diskon yang menarik, paket ini merupakan solusi ideal bagi mereka yang menginginkan perawatan kulit berkualitas tinggi tanpa harus mengeluarkan biaya yang besar. ',
                ],
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2024/5/20/9210e4ea-5eac-4156-b53b-636f1497cf20.jpg',
                    'title' => 'SKINTIFIC Niacinamide Brightening Cleanser 80ml Glowing',
                    'category_id' => '11',
                    'price' => '93000',
                    'weight' => '100',
                    'description' => 'Pembersih wajah ini diformulasikan dengan Niacinamide, bahan aktif yang dikenal efektif dalam mencerahkan kulit dan mengurangi tampilan noda hitam serta hiperpigmentasi. Selain membersihkan kotoran dan minyak berlebih, produk ini juga membantu memperbaiki tekstur kulit, menjadikannya lebih halus dan lembut. Dengan penggunaan rutin, pembersih wajah ini memberikan kilau alami pada kulit, membuatnya tampak lebih segar dan bercahaya. Kandungan Niacinamide juga berfungsi sebagai anti-inflamasi, membantu meredakan kemerahan dan iritasi, sehingga cocok untuk semua jenis kulit, termasuk kulit sensitif. Produk ini tidak hanya membersihkan, tetapi juga merawat kulit Anda, memberikan hasil yang optimal untuk kulit yang lebih sehat dan bercahaya. ',
                ],
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2024/3/21/f9ba50e6-9aba-482c-a34e-0ec1c5e20798.jpg',
                    'title' => 'SALE SKINTIFIC Mugwort Purifying Micellar Water 300ml',
                    'category_id' => '13',
                    'price' => '114000',
                    'weight' => '350',
                    'description' => 'Air micellar dengan kandungan mugwort ini dirancang khusus untuk membersihkan dan menyegarkan kulit secara menyeluruh. Mugwort, yang dikenal dengan sifat anti-inflamasi dan antioksidannya, membantu menenangkan kulit yang iritasi dan melindungi dari kerusakan akibat radikal bebas. Formula micellar bekerja dengan lembut namun efektif, mengangkat kotoran, minyak berlebih, dan sisa makeup tanpa perlu dibilas, sehingga kulit terasa bersih dan segar tanpa meninggalkan rasa kering atau ketat. Produk ini sangat cocok untuk semua jenis kulit, termasuk kulit sensitif, dan dapat digunakan sebagai langkah pertama dalam rutinitas perawatan kulit harian Anda untuk memastikan kulit tetap sehat dan bercahaya. ',
                ],
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2024/2/21/efabb0e1-1520-4fb7-9884-cb2c5feee208.jpg',
                    'title' => 'SALE SKINTIFIC 5X Ceramide Soothing Toner 80ml',
                    'category_id' => '12',
                    'price' => '115500',
                    'weight' => '100',
                    'description' => 'Toner dengan 5X Ceramide ini dirancang khusus untuk menenangkan dan melembapkan kulit secara mendalam. Formula canggihnya mengandung lima jenis ceramide yang berfungsi untuk memperkuat penghalang kulit, menjaga kelembapan, dan mencegah kehilangan air dari permukaan kulit. Toner ini membantu meredakan iritasi, mengurangi kemerahan, dan memberikan rasa nyaman pada kulit yang kering atau sensitif. Penggunaan rutin toner ini akan membuat kulit terasa lebih lembut, halus, dan kenyal, dengan tampilan yang lebih sehat dan bercahaya. Produk ini juga membantu mempersiapkan kulit untuk menerima manfaat maksimal dari produk perawatan kulit berikutnya. ',
                ],
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2024/2/27/a228b9ad-e2d6-44c9-bd7f-fe3127ee3cad.jpg',
                    'title' => 'SKINTIFIC Ice Sorbet Makeup Remover 100ml',
                    'category_id' => '13',
                    'price' => '89000',
                    'weight' => '120',
                    'description' => 'Pembersih makeup ini hadir dengan tekstur sorbet yang menyegarkan, memberikan sensasi dingin dan menenangkan saat diaplikasikan pada kulit. Dirancang khusus untuk membersihkan wajah dengan lembut, produk ini efektif mengangkat sisa-sisa makeup, kotoran, dan minyak berlebih tanpa membuat kulit terasa kering atau teriritasi. Kandungan bahan-bahan alami yang menutrisi kulit membantu menjaga kelembapan dan elastisitas, sehingga kulit tetap terasa halus dan kenyal setelah penggunaan. Dengan aroma yang lembut dan menenangkan, pembersih makeup ini tidak hanya membersihkan tetapi juga memberikan pengalaman perawatan kulit yang menyenangkan dan memanjakan. Cocok untuk semua jenis kulit, termasuk kulit sensitif, produk ini menjadi pilihan ideal untuk rutinitas pembersihan wajah sehari-hari. ',
                ],
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2024/2/21/90bbc1fc-1660-40f7-a2ad-96c7a566bbdf.jpg',
                    'title' => 'SKINTIFIC Aqua Light Daily Sunscreen SPF 35 PA+++',
                    'category_id' => '5',
                    'price' => '79000',
                    'weight' => '100',
                    'description' => 'Tabir surya harian ini hadir dengan SPF 35 dan perlindungan PA+++ yang dirancang khusus untuk melindungi kulit Anda dari paparan sinar matahari sehari-hari. Formulanya yang ringan dan tidak lengket membuatnya nyaman digunakan setiap hari, bahkan di bawah makeup. Dengan kandungan bahan-bahan berkualitas tinggi, tabir surya ini tidak hanya melindungi kulit dari sinar UVA dan UVB yang berbahaya, tetapi juga membantu mencegah penuaan dini dan kerusakan kulit akibat radikal bebas. Selain itu, produk ini juga mengandung bahan-bahan pelembap yang menjaga kulit tetap terhidrasi dan lembut sepanjang hari. Cocok untuk semua jenis kulit, termasuk kulit sensitif, tabir surya ini adalah pilihan ideal untuk rutinitas perawatan kulit harian Anda, memastikan kulit tetap sehat, cerah, dan terlindungi. ',
                ],
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2024/3/22/c5efde82-3765-4bc2-98a3-3b72c2520676.jpg',
                    'title' => 'SALE SKINTIFIC Sunscreen Spray Set 2pcs SPF 50+ PA++++',
                    'category_id' => '5',
                    'price' => '157100',
                    'weight' => '200',
                    'description' => 'Set spray tabir surya ini menawarkan perlindungan optimal dengan SPF 50+ dan PA++++, menjadikannya pilihan ideal untuk melindungi kulit dari sinar UVA dan UVB yang berbahaya. Formulanya yang ringan dan tidak lengket dirancang khusus untuk kenyamanan penggunaan sehari-hari, baik di bawah maupun di atas makeup, sehingga tidak mengganggu tampilan riasan Anda. Dengan kemasan praktis dan mudah dibawa, produk ini memungkinkan aplikasi ulang yang cepat dan efisien kapan saja dan di mana saja, memastikan kulit Anda tetap terlindungi sepanjang hari. Selain itu, kandungan bahan-bahan berkualitas tinggi dalam spray ini juga membantu menjaga kelembapan kulit, menjadikannya tetap sehat dan terhidrasi. ',
                ],
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2024/1/30/e39989b2-e6f9-47ce-934e-2d328e530e45.jpg',
                    'title' => 'SKINTIFIC Niacinamide Brightening Essence Toner 20ml Travel Size',
                    'category_id' => '12',
                    'price' => '39000',
                    'weight' => '30',
                    'description' => 'Toner essence ini mengandung Niacinamide, bahan aktif yang dikenal efektif dalam mencerahkan kulit, mengurangi tampilan pori-pori, dan mengontrol produksi minyak berlebih. Dikemas dalam ukuran travel yang praktis, produk ini sangat ideal untuk dibawa saat bepergian, memastikan kulit Anda tetap terawat dan segar di mana pun Anda berada. Formulanya yang ringan dan cepat meresap membuatnya cocok untuk digunakan pada berbagai jenis kulit, termasuk kulit sensitif. Selain itu, toner essence ini juga membantu menyeimbangkan pH kulit, memberikan hidrasi yang optimal, dan mempersiapkan kulit untuk penyerapan produk perawatan selanjutnya. Dengan kemasan yang ringkas dan mudah digunakan, toner essence ini menjadi pilihan sempurna bagi mereka yang menginginkan perawatan kulit berkualitas tanpa repot saat dalam perjalanan. ',
                ],
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2024/1/25/17755c59-5abf-482a-a0b2-4972e83a0c6a.jpg',
                    'title' => 'SALE SKINTIFIC MSH Niacinamide Brightening Moisture Gel 80g',
                    'category_id' => '2',
                    'price' => '259000',
                    'weight' => '100',
                    'description' => 'Gel pelembap ini mengandung Niacinamide, bahan aktif yang dikenal dengan kemampuannya untuk memberikan kelembapan intensif sekaligus mencerahkan kulit. Formulanya yang ringan dan cepat meresap membuatnya ideal untuk semua jenis kulit, termasuk kulit sensitif. Niacinamide bekerja dengan cara memperkuat lapisan pelindung kulit, mengurangi tampilan pori-pori besar, dan mengatasi hiperpigmentasi serta noda hitam. Selain itu, gel ini juga membantu mengontrol produksi minyak berlebih, sehingga kulit tampak lebih halus dan bercahaya. Dengan penggunaan rutin, kulit akan terasa lebih lembut, kenyal, dan tampak lebih merata. Produk ini bebas dari paraben, sulfat, dan pewarna buatan, sehingga aman digunakan setiap hari tanpa khawatir akan iritasi atau efek samping. ',
                ],
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2024/1/25/255529ca-080f-478f-a015-50e7db0cb211.jpg',
                    'title' => 'SALE SKINTIFIC 5X Ceramide Barrier Moisture Gel 80g Moisturizer',
                    'category_id' => '7',
                    'price' => '238280',
                    'weight' => '100',
                    'description' => 'Gel pelembap ini diformulasikan dengan kandungan 5X Ceramide yang berfungsi untuk memperkuat penghalang alami kulit, sehingga mampu melindungi kulit dari berbagai faktor eksternal yang merusak. Selain itu, gel ini memberikan kelembapan ekstra yang mendalam, menjadikannya ideal untuk kulit yang kering dan sensitif. Teksturnya yang ringan dan cepat meresap membuatnya nyaman digunakan sehari-hari tanpa meninggalkan rasa lengket. Dengan penggunaan rutin, gel pelembap ini membantu menjaga keseimbangan kelembapan kulit, mengurangi kekeringan, dan meningkatkan elastisitas kulit, sehingga kulit tampak lebih sehat, lembut, dan bercahaya. Produk ini juga bebas dari bahan-bahan berbahaya seperti paraben dan pewarna buatan, sehingga aman untuk semua jenis kulit, termasuk kulit sensitif. ',
                ],
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2024/3/12/28e3ea7c-0cd6-4d06-af46-37ca15be68a6.jpg',
                    'title' => 'SKINTIFIC Paket 2 PCS Alaska Volcano Pore Detox Clay Mask Stick 40g',
                    'category_id' => '2',
                    'price' => '170000',
                    'weight' => '100',
                    'description' => 'Paket ini terdiri dari 2 batang masker clay detoksifikasi yang terbuat dari lumpur gunung berapi Alaska. Masker ini efektif membersihkan pori-pori, mengangkat kotoran dan minyak berlebih, serta membantu menjaga kulit tetap bersih dan segar. Cocok untuk semua jenis kulit yang membutuhkan pembersihan mendalam dan detoksifikasi. ',
                ],
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2023/12/27/232cf124-8ac9-4620-b4e4-29d4fed867ee.jpg',
                    'title' => 'SKINTIFIC Paket 2 PCS 3% Tranexamic Acid Advanced Bright Serum',
                    'category_id' => '2',
                    'price' => '237000',
                    'weight' => '250',
                    'description' => 'Paket ini berisi 2 botol serum pencerah wajah dengan kandungan 3% Tranexamic Acid. Serum ini dirancang untuk memperbaiki dan mencerahkan kulit, mengurangi bintik-bintik gelap, dan meratakan warna kulit. Penggunaan rutin serum ini akan membantu Anda mendapatkan kulit yang lebih cerah, halus, dan bercahaya. ',
                ],
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2023/12/27/2edbbd3f-e789-4dea-9620-daab8168ca8a.jpg',
                    'title' => 'SKINTIFIC Paket 2pcs Mugwort Acne Clay Mask 55g',
                    'category_id' => '2',
                    'price' => '182000',
                    'weight' => '120',
                    'description' => 'Paket ini terdiri dari 2 batang masker clay mugwort, masing-masing berukuran 55g. Masker ini diformulasikan khusus untuk merawat kulit berjerawat, mengurangi peradangan, dan menenangkan kulit yang iritasi. Mugwort terkenal dengan sifat anti-inflamasi dan antibakterinya, menjadikan masker ini pilihan ideal untuk kulit yang rentan terhadap jerawat. ',
                ],
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2024/1/11/29e3cd11-a0e2-47a3-80ca-20a61c38307e.jpg',
                    'title' => 'SKINTIFIC 5X Ceramide Barrier Repair Serum 50ml X 2PCS',
                    'category_id' => '7',
                    'price' => '458000',
                    'weight' => '300',
                    'description' => 'Paket ini berisi 2 botol serum perbaikan penghalang kulit, masing-masing berukuran 50ml, dengan kandungan 5X Ceramide. Serum ini membantu memperbaiki dan memperkuat penghalang kulit, menjaga kelembapan, dan mencegah iritasi. Dengan penggunaan rutin, kulit akan terasa lebih lembut, halus, dan kenyal, serta tampak lebih sehat dan terlindungi. ',
                ],
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2023/12/22/1fe1fbc9-9104-4e02-ad5f-aaa736fde91f.jpg',
                    'title' => 'SKINTIFIC 5X Ceramide Soothing & Calming Mask Sheet 8pcs',
                    'category_id' => '7',
                    'price' => '158000',
                    'weight' => '200',
                    'description' => 'Delapan lembar masker kertas yang menenangkan ini dirancang khusus untuk memberikan perawatan intensif pada kulit wajah Anda. Setiap lembar masker diperkaya dengan kandungan 5X Ceramide, yang dikenal efektif dalam memperkuat lapisan pelindung kulit dan menjaga kelembapan alami. Ceramide bekerja dengan cara mengisi celah-celah di antara sel-sel kulit, sehingga membantu mencegah kehilangan air dan menjaga kulit tetap terhidrasi sepanjang hari. Selain itu, masker ini juga mengandung bahan-bahan alami yang menenangkan, seperti ekstrak chamomile dan aloe vera, yang membantu meredakan iritasi dan kemerahan pada kulit. Dengan tekstur kertas yang lembut dan mudah menempel pada wajah, masker ini memberikan sensasi relaksasi yang menyenangkan, menjadikannya pilihan ideal untuk perawatan kulit di rumah. Gunakan secara rutin untuk mendapatkan kulit yang lebih halus, lembut, dan bercahaya. ',
                ],
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2023/12/22/98b088b7-5907-4533-b655-64c3dcbe69c7.jpg',
                    'title' => 'SKINTIFIC 2pcs Pure Centella Acne Calming Toner 80ml Centella Asiatica',
                    'category_id' => '12',
                    'price' => '213000',
                    'weight' => '200',
                    'description' => 'Dua botol toner murni Centella, masing-masing berukuran 80ml, dirancang khusus untuk menenangkan dan merawat kulit berjerawat. Produk ini mengandung ekstrak Centella Asiatica yang dikenal dengan sifat anti-inflamasi dan penyembuhannya, membantu mengurangi kemerahan dan iritasi pada kulit yang rentan berjerawat. Formulanya yang lembut namun efektif bekerja dengan cara menyeimbangkan kadar minyak dan kelembapan kulit, sehingga mencegah timbulnya jerawat baru tanpa membuat kulit kering atau teriritasi. Dengan penggunaan rutin, toner ini tidak hanya membantu menenangkan kulit yang meradang, tetapi juga memperbaiki tekstur kulit, menjadikannya lebih halus dan sehat. Ideal untuk semua jenis kulit, terutama kulit sensitif dan berjerawat, toner murni Centella ini adalah solusi alami untuk mendapatkan kulit yang lebih bersih dan tenang. ',
                ],
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2023/12/27/92e81279-6289-4176-8efb-f85ae282f282.png',
                    'title' => 'SKINTIFIC 2PCS Amino Acid Ultra-gentle Cleansing Mousse 100ml',
                    'category_id' => '12',
                    'price' => '182000',
                    'weight' => '250',
                    'description' => 'Paket ini berisi dua botol busa pembersih super lembut dengan ukuran 100ml masing-masing, yang diformulasikan dengan asam amino. Pembersih ini dirancang untuk membersihkan kulit secara menyeluruh tanpa menghilangkan kelembapan alami, menjadikannya ideal untuk semua jenis kulit, termasuk kulit sensitif. Busa pembersih ini membantu menghilangkan kotoran, minyak, dan sisa makeup, sambil menjaga kulit tetap lembut dan terhidrasi. ',
                ],
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2023/12/5/100fe03e-78af-491a-9f8b-a3a358f7bb9e.png',
                    'title' => 'SALE SKINTIFIC Alaska Volcano Pore Detox Clay Mask Stick 40g',
                    'category_id' => '2',
                    'price' => '83000',
                    'weight' => '80',
                    'description' => 'Masker clay detoksifikasi dari Alaska ini hadir dalam bentuk stick dengan ukuran 40g, memudahkan aplikasi langsung pada kulit. Masker ini mengandung lumpur gunung berapi Alaska yang kaya akan mineral untuk membersihkan pori-pori, menghilangkan kotoran dan minyak berlebih, serta memberikan efek detoksifikasi yang menyegarkan. Cocok untuk semua jenis kulit yang membutuhkan pembersihan mendalam. ',
                ],
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2023/12/5/9437b4b3-c454-4940-a67e-0ed98d64357a.jpg',
                    'title' => 'SALE 2PCS SKINTIFIC Panthenol Gel Cleanser 120ml Calming and Soothing',
                    'category_id' => '12',
                    'price' => '182000',
                    'weight' => '250',
                    'description' => 'Paket ini berisi dua botol pembersih gel Panthenol, masing-masing berukuran 120ml. Pembersih gel ini diformulasikan dengan Panthenol (Pro-Vitamin B5) yang dikenal dengan sifat menenangkan dan melembapkannya. Produk ini membersihkan kulit secara efektif tanpa menyebabkan iritasi, membuat kulit terasa lebih lembut, kenyal, dan terhidrasi. Ideal untuk semua jenis kulit, terutama kulit yang kering dan sensitif. ',
                ],
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2023/11/20/d216cdda-13c0-4829-8209-e541331b1093.png',
                    'title' => 'SALE SKINTIFIC 10% Vitamin C Brightening Glow Serum 20ml',
                    'category_id' => '4',
                    'price' => '125000',
                    'weight' => '100',
                    'description' => 'Serum Vitamin C dengan konsentrasi 10% ini hadir dalam kemasan praktis berukuran 20ml, dirancang khusus untuk mencerahkan dan memberikan kilau alami pada kulit Anda. Diperkaya dengan antioksidan kuat, serum ini bekerja efektif untuk mengurangi tampilan bintik hitam, hiperpigmentasi, dan tanda-tanda penuaan dini, sekaligus meningkatkan produksi kolagen untuk kulit yang lebih kenyal dan elastis. Formulanya yang ringan dan cepat meresap memastikan bahwa nutrisi penting dapat menembus lapisan kulit dengan optimal, memberikan hasil yang terlihat dalam waktu singkat. Ideal untuk semua jenis kulit, serum ini juga membantu melindungi kulit dari kerusakan akibat radikal bebas dan polusi lingkungan, menjadikannya pilihan sempurna untuk rutinitas perawatan kulit harian Anda. Dengan penggunaan rutin, kulit Anda akan tampak lebih cerah, sehat, dan bercahaya. ',
                ],
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2023/11/20/7a8baa2a-ad3b-4853-bf2f-8cff62788513.jpg',
                    'title' => 'FLASH SKINTIFIC 5X Ceramide Serum Sunscreen SPF50 PA++++Sunblock',
                    'category_id' => '5',
                    'price' => '93000',
                    'weight' => '150',
                    'description' => 'Tabir surya serum ini menawarkan perlindungan tinggi dengan SPF50 dan PA++++, melindungi kulit dari sinar UVA dan UVB yang merusak. Diformulasikan dengan 5X Ceramide, serum ini tidak hanya melindungi tetapi juga memperbaiki dan memperkuat penghalang kulit, menjaga kelembapan, dan mencegah iritasi. Teksturnya yang ringan dan mudah menyerap menjadikan produk ini ideal untuk penggunaan sehari-hari, memberikan perlindungan maksimal dan perawatan kulit dalam satu langkah. ',
                ],
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/hDjmkQ/2023/11/16/0437f613-3943-44f7-bb9f-6f33f1da0921.jpg',
                    'title' => 'SKINTIFIC 5pcs Barrier Complete Set Paket Skincare 5x Ceramide Repair',
                    'category_id' => '7',
                    'price' => '459000',
                    'weight' => '800',
                    'description' => 'Paket lengkap ini terdiri dari 5 produk perawatan kulit yang semuanya diformulasikan dengan 5X Ceramide untuk memperbaiki dan memperkuat penghalang kulit. Set ini termasuk pembersih, toner, serum, pelembap, dan masker, semuanya dirancang untuk bekerja sinergis dalam memberikan hidrasi mendalam, memperbaiki kerusakan kulit, dan melindungi dari faktor eksternal. Penggunaan rutin dari paket ini akan membuat kulit Anda terasa lebih halus, kenyal, dan sehat. ',
                ],
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2024/2/22/ff488556-9c2b-4f5a-920d-30a5bab03536.jpg',
                    'title' => 'SKINTIFIC 5pcs Glowing Complete Set Paket Skincare hadiah ulang tahun',
                    'category_id' => '2',
                    'price' => '459000',
                    'weight' => '800',
                    'description' => 'Paket perawatan kulit ini terdiri dari produk-produk yang diformulasikan untuk memberikan kilau alami pada kulit, menjadikannya hadiah ulang tahun yang sempurna. Set ini mencakup pembersih, toner, serum pencerah, pelembap, dan masker wajah, semuanya bekerja bersama untuk mencerahkan, meratakan warna kulit, dan memberikan hidrasi yang cukup. Dengan kemasan yang elegan dan manfaat yang menyeluruh, paket ini adalah pilihan ideal untuk merayakan momen spesial dan memberikan perawatan kulit yang mewah. ',
                ],
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2023/11/10/2e7dbba8-4aff-4a1c-acec-27883ea2fb40.jpg',
                    'title' => 'SKINTIFIC Micellar Water 2 pcs Mugwort Purifying Cleansing Oil',
                    'category_id' => '13',
                    'price' => '182000',
                    'weight' => '175',
                    'description' => 'Dua botol air micellar yang diperkaya dengan minyak pembersih mugwort ini dirancang khusus untuk membersihkan dan menyegarkan kulit secara menyeluruh. Air micellar ini mengandung partikel micelles yang efektif mengangkat kotoran, minyak, dan sisa makeup dari permukaan kulit tanpa perlu dibilas, sehingga sangat praktis untuk digunakan sehari-hari. Minyak pembersih mugwort yang terkandung di dalamnya memiliki sifat anti-inflamasi dan antioksidan yang membantu menenangkan kulit yang iritasi serta melindungi dari kerusakan akibat radikal bebas. Kombinasi unik ini tidak hanya membersihkan kulit secara mendalam, tetapi juga memberikan sensasi segar dan lembut, menjadikan kulit tampak lebih sehat dan bercahaya. Produk ini cocok untuk semua jenis kulit, termasuk kulit sensitif, karena formulanya yang lembut dan bebas dari bahan kimia keras. ',
                ],
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2023/11/15/0fecd1a4-b4c0-4190-8870-3354cb35b9eb.png',
                    'title' => 'SKINTIFIC 2 Pcs Set 5% Panthenol Acne Calming Water Gel 45G',
                    'category_id' => '12',
                    'price' => '250000',
                    'weight' => '150',
                    'description' => 'Set ini terdiri dari dua gel air Centella, masing-masing dengan berat 45 gram, yang diformulasikan khusus untuk menenangkan kulit berjerawat. Setiap gel mengandung 5% Panthenol, sebuah bahan aktif yang dikenal karena kemampuannya untuk mempercepat proses penyembuhan kulit dan mengurangi peradangan. Centella Asiatica, bahan utama dalam gel ini, memiliki sifat antioksidan dan anti-inflamasi yang membantu meredakan kemerahan dan iritasi pada kulit. Tekstur gel yang ringan dan mudah meresap membuatnya ideal untuk digunakan pada kulit berminyak dan berjerawat, tanpa meninggalkan rasa lengket. Produk ini juga diperkaya dengan bahan-bahan alami lainnya yang bekerja sinergis untuk memperbaiki tekstur kulit, menghidrasi, dan memberikan efek menenangkan. Dengan penggunaan rutin, gel air Centella ini dapat membantu mengurangi tampilan jerawat, memperbaiki kondisi kulit, dan memberikan rasa nyaman pada kulit yang teriritasi. ',
                ],
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2024/1/10/e6039f50-78f2-403f-ad02-bf433e235526.jpg',
                    'title' => 'SKINTIFIC 5% Panthenol Acne Calming Water Gel 80g',
                    'category_id' => '12',
                    'price' => '239000',
                    'weight' => '100',
                    'description' => 'Gel air ini diformulasikan dengan Centella Asiatica dan 5% Panthenol untuk menenangkan dan merawat kulit berjerawat. Kandungan Centella Asiatica membantu mengurangi peradangan dan mempercepat penyembuhan kulit, sementara Panthenol memberikan hidrasi dan memperkuat penghalang kulit. Teksturnya yang ringan dan cepat menyerap membuat gel ini ideal untuk kulit berminyak dan berjerawat, memberikan sensasi sejuk dan menenangkan tanpa menyumbat pori-pori. ',
                ],
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2023/11/16/e67ca09a-622c-47d1-a280-8b594fd28850.jpg',
                    'title' => 'SKINTIFIC Mugwort Purifying Micellar Water Travel Size 75ml',
                    'category_id' => '13',
                    'price' => '39000',
                    'weight' => '100',
                    'description' => 'Air micellar dengan mugwort dalam ukuran travel 75ml ini dirancang khusus untuk membersihkan dan menyegarkan kulit secara efektif, bahkan saat Anda sedang bepergian. Mengandung ekstrak mugwort yang dikenal dengan sifat anti-inflamasi dan antioksidannya, produk ini tidak hanya membersihkan kotoran dan sisa makeup dengan lembut, tetapi juga membantu menenangkan kulit yang iritasi dan meradang. Formulanya yang ringan dan bebas alkohol memastikan kulit tetap terhidrasi tanpa meninggalkan rasa lengket atau berminyak. Kemasan travel-size yang praktis memudahkan Anda untuk membawa produk ini ke mana saja, sehingga Anda dapat menjaga kebersihan dan kesegaran kulit kapan pun dan di mana pun. Cocok untuk semua jenis kulit, termasuk kulit sensitif, air micellar ini adalah pilihan sempurna untuk rutinitas perawatan kulit harian Anda. ',
                ],
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2024/3/12/12398511-5c5a-4585-aa5c-61fc1351065c.jpg',
                    'title' => 'FLASH SKINTIFIC Mugwort Purifying Micellar Water',
                    'category_id' => '13',
                    'price' => '93000',
                    'weight' => '150',
                    'description' => 'Air micellar dengan kandungan mugwort adalah solusi pembersih kulit yang tidak hanya efektif mengangkat kotoran dan sisa makeup, tetapi juga memberikan sensasi kesegaran yang menenangkan. Mugwort, dikenal dengan sifat anti-inflamasi dan antioksidannya, membantu meredakan iritasi dan kemerahan pada kulit, menjadikannya pilihan ideal untuk semua jenis kulit, termasuk kulit sensitif. Formula micellar bekerja dengan lembut namun efisien, menarik kotoran dan minyak berlebih seperti magnet tanpa perlu dibilas, sehingga menjaga kelembapan alami kulit. Penggunaan rutin air micellar dengan mugwort ini akan membuat kulit terasa lebih bersih, segar, dan sehat, serta memberikan perlindungan tambahan dari radikal bebas dan polusi lingkungan. ',
                ],
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2023/10/31/91f5e49a-036a-4873-a915-6d34687dcfae.jpg',
                    'title' => 'SKINTIFIC Symwhite 377 Dark Spot Set Skincare 6pcs Anti Dark Spot',
                    'category_id' => '2',
                    'price' => '577000',
                    'weight' => '800',
                    'description' => 'Paket perawatan kulit ini terdiri dari beberapa produk yang diformulasikan dengan Symwhite 377, bahan aktif yang efektif untuk mengurangi bintik hitam dan hiperpigmentasi. Set ini mungkin mencakup pembersih, toner, serum, pelembap, dan masker yang bekerja bersama untuk mencerahkan kulit, meratakan warna kulit, dan mengurangi tampilan bintik hitam. Penggunaan rutin dari produk-produk ini akan membantu Anda mendapatkan kulit yang lebih cerah, bersinar, dan bebas dari noda gelap. ',
                ],
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2023/10/20/198c10ec-4014-464d-b325-fddf5eb8ae98.jpg',
                    'title' => 'FLASH SKINTIFIC Symwhite 377 Dark Spot Moisturizer 30g',
                    'category_id' => '2',
                    'price' => '118700',
                    'weight' => '100',
                    'description' => 'Pelembap ini mengandung Symwhite 377, yang dikenal efektif dalam mengurangi bintik hitam dan meratakan warna kulit. Dengan ukuran 30g, pelembap ini memberikan hidrasi intensif sekaligus bekerja aktif untuk mengatasi hiperpigmentasi. Formula ringan dan cepat menyerap membuatnya cocok untuk semua jenis kulit, memberikan hasil kulit yang lebih cerah, halus, dan bersinar dengan penggunaan rutin. ',
                ],
                [
                    'image' => 'https://images.tokopedia.net/img/cache/200-square/VqbcmM/2023/10/20/95ff71e6-4a9c-43c7-a9f9-5cf6603612ff.jpg',
                    'title' => 'SKINTIFIC Symwhite 377 & Panthenol Acne Moisture gel 2PCS Anti Dark',
                    'category_id' => '12',
                    'price' => '250000',
                    'weight' => '150',
                    'description' => 'Dua botol gel pelembap ini dirancang khusus dengan formula canggih yang menggabungkan Symwhite 377 dan Panthenol, memberikan solusi efektif untuk mengurangi bintik hitam dan merawat kulit berjerawat. Symwhite 377 dikenal sebagai agen pencerah kulit yang kuat, membantu mengurangi hiperpigmentasi dan meratakan warna kulit, sementara Panthenol, atau Pro-Vitamin B5, berfungsi sebagai pelembap yang mendalam, memperbaiki dan menenangkan kulit yang teriritasi. Kombinasi kedua bahan ini tidak hanya membantu memudarkan bintik hitam, tetapi juga mempercepat proses penyembuhan jerawat, mengurangi peradangan, dan meningkatkan elastisitas kulit. Dengan tekstur gel yang ringan dan mudah meresap, produk ini cocok untuk semua jenis kulit, termasuk kulit sensitif, memberikan hasil yang optimal tanpa meninggalkan rasa lengket atau berminyak.',
                ],
            ];

        foreach ($data as $item) {
            // Upload gambar dari URL ke folder storage
            $imageContents = file_get_contents($item['image']);
            $imageName = basename($item['image']);
            $storagePath = 'images/'.$imageName;
            Storage::disk('public')->put($storagePath, $imageContents);

            // Buat record produk di database
            $product = Product::create([
                'category_id' => $item['category_id'],
                'title' => $item['title'],
                'price' => $item['price'],
                'quantity' => rand(10, 100), // Atur jumlah sesuai kebutuhan
                'image' => $storagePath,
                'weight' => $item['weight'],
                'description' => $item['description'],
            ]);

            $this->command->info('Tambah Produk '.$product->title);
        }
    }
}
