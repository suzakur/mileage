import React from 'react';
import { motion } from 'framer-motion';
import Header from '@/components/Header';
import Footer from '@/components/Footer';
import MobileMenu from '@/components/MobileMenu';
import { Link } from 'wouter';

// Blog post data
export const blogPosts = [
  {
    id: 1,
    title: 'Cara Memaksimalkan Poin Reward Kartu Kredit Anda',
    excerpt: 'Pelajari strategi terbaik untuk mengumpulkan poin reward kartu kredit dan menukarnya dengan hadiah yang paling menguntungkan.',
    category: 'Tips & Trik',
    date: '12 Mei 2023',
    imageUrl: 'https://images.unsplash.com/photo-1556742502-ec7c0e9f34b1?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
    readTime: '5 menit',
    author: 'Budi Santoso',
    authorAvatar: 'https://i.pravatar.cc/150?img=11'
  },
  {
    id: 2,
    title: 'Perbandingan 5 Kartu Kredit Travel Terbaik 2023',
    excerpt: 'Analisis mendalam tentang kartu kredit travel terbaik di Indonesia berdasarkan manfaat, biaya tahunan, dan bonus pendaftaran.',
    category: 'Perbandingan',
    date: '5 Mei 2023',
    imageUrl: 'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
    readTime: '7 menit',
    author: 'Siti Aminah',
    authorAvatar: 'https://i.pravatar.cc/150?img=5'
  },
  {
    id: 3,
    title: 'Mengenal Skema Cashback: Bagaimana Memilih yang Terbaik?',
    excerpt: 'Panduan lengkap tentang skema cashback berbagai kartu kredit dan cara memilih yang paling sesuai dengan pola belanja Anda.',
    category: 'Edukasi',
    date: '28 April 2023',
    imageUrl: 'https://images.unsplash.com/photo-1579621970588-a35d0e7ab9b6?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
    readTime: '6 menit',
    author: 'Rudi Hermawan',
    authorAvatar: 'https://i.pravatar.cc/150?img=7'
  },
  {
    id: 4,
    title: 'Terungkap: Biaya Tersembunyi pada Kartu Kredit',
    excerpt: 'Waspadalah terhadap berbagai biaya tersembunyi yang mungkin dikenakan pada kartu kredit Anda dan cara menghindarinya.',
    category: 'Peringatan',
    date: '19 April 2023',
    imageUrl: 'https://images.unsplash.com/photo-1563013544-824ae1b704d3?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
    readTime: '4 menit',
    author: 'Dewi Putri',
    authorAvatar: 'https://i.pravatar.cc/150?img=3'
  },
  {
    id: 5,
    title: 'Bagaimana Teknologi Mengubah Industri Kartu Kredit',
    excerpt: 'Eksplorasi perkembangan teknologi terbaru yang mengubah cara kita menggunakan kartu kredit dan dampaknya pada industri perbankan.',
    category: 'Teknologi',
    date: '10 April 2023',
    imageUrl: 'https://images.unsplash.com/photo-1559526324-593bc073d938?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
    readTime: '8 menit',
    author: 'Agus Wijaya',
    authorAvatar: 'https://i.pravatar.cc/150?img=15'
  },
  {
    id: 6,
    title: 'Panduan Pengajuan Kartu Kredit untuk Pemula',
    excerpt: 'Langkah-langkah praktis untuk mengajukan kartu kredit pertama Anda, termasuk tips untuk meningkatkan peluang persetujuan.',
    category: 'Panduan',
    date: '2 April 2023',
    imageUrl: 'https://images.unsplash.com/photo-1518458028785-8fbcd101ebb9?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
    readTime: '5 menit',
    author: 'Lina Susanti',
    authorAvatar: 'https://i.pravatar.cc/150?img=9'
  },
  {
    id: 7,
    title: 'Strategi Melunasi Hutang Kartu Kredit dengan Cepat',
    excerpt: 'Metode terbaik dan teruji untuk melunasi hutang kartu kredit Anda dalam waktu yang lebih singkat dan menghemat biaya bunga.',
    category: 'Tips & Trik',
    date: '30 Maret 2023',
    imageUrl: 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
    readTime: '6 menit',
    author: 'Joko Prasetyo',
    authorAvatar: 'https://i.pravatar.cc/150?img=12'
  },
  {
    id: 8,
    title: 'Manfaat Tersembunyi Kartu Kredit Premium',
    excerpt: 'Temukan berbagai manfaat eksklusif yang jarang diketahui dari kartu kredit premium dan bagaimana memaksimalkan nilai dari biaya tahunan.',
    category: 'Edukasi',
    date: '25 Maret 2023',
    imageUrl: 'https://images.unsplash.com/photo-1589758438368-0ad531db3366?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
    readTime: '7 menit',
    author: 'Maya Indira',
    authorAvatar: 'https://i.pravatar.cc/150?img=4'
  },
  {
    id: 9,
    title: 'Kartu Kredit vs Kartu Debit: Mana yang Lebih Baik?',
    excerpt: 'Analisis komprehensif tentang perbedaan kartu kredit dan debit, serta situasi ideal untuk menggunakan masing-masing jenis kartu.',
    category: 'Perbandingan',
    date: '18 Maret 2023',
    imageUrl: 'https://images.unsplash.com/photo-1559526324-4b87b5e36e44?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
    readTime: '5 menit',
    author: 'Hendra Gunawan',
    authorAvatar: 'https://i.pravatar.cc/150?img=13'
  },
  {
    id: 10,
    title: 'Cara Aman Bertransaksi Online dengan Kartu Kredit',
    excerpt: 'Panduan keamanan untuk melindungi informasi kartu kredit Anda saat berbelanja online dan menghindari penipuan.',
    category: 'Keamanan',
    date: '10 Maret 2023',
    imageUrl: 'https://images.unsplash.com/photo-1563013544-824ae1b704d3?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
    readTime: '4 menit',
    author: 'Rina Marlina',
    authorAvatar: 'https://i.pravatar.cc/150?img=1'
  },
  {
    id: 11,
    title: 'Tren Kartu Kredit Digital: Apa yang Perlu Anda Ketahui',
    excerpt: 'Perkembangan terbaru dalam industri kartu kredit digital dan bagaimana teknologi ini mengubah cara kita bertransaksi.',
    category: 'Teknologi',
    date: '3 Maret 2023',
    imageUrl: 'https://images.unsplash.com/photo-1563013544-824ae1b704d3?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
    readTime: '6 menit',
    author: 'Tommy Wijaya',
    authorAvatar: 'https://i.pravatar.cc/150?img=14'
  },
  {
    id: 12,
    title: 'Program Co-Branding Kartu Kredit: Apakah Menguntungkan?',
    excerpt: 'Menggali manfaat dan kekurangan program co-branding kartu kredit dengan berbagai merek dan perusahaan.',
    category: 'Analisis',
    date: '25 Februari 2023',
    imageUrl: 'https://images.unsplash.com/photo-1601597111158-2fceff292cdc?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
    readTime: '5 menit',
    author: 'Lia Kusuma',
    authorAvatar: 'https://i.pravatar.cc/150?img=2'
  },
  {
    id: 13,
    title: 'Cara Menaikkan Limit Kartu Kredit Anda',
    excerpt: 'Strategi efektif dan tips praktis untuk mengajukan dan mendapatkan persetujuan kenaikan limit kartu kredit dari bank.',
    category: 'Tips & Trik',
    date: '18 Februari 2023',
    imageUrl: 'https://images.unsplash.com/photo-1565514020179-026b92b2d70b?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
    readTime: '5 menit',
    author: 'Anton Widjaja',
    authorAvatar: 'https://i.pravatar.cc/150?img=10'
  },
  {
    id: 14,
    title: 'Memanfaatkan Reward Point untuk Liburan Impian',
    excerpt: 'Panduan lengkap tentang cara mengumpulkan dan menukarkan poin reward untuk mendapatkan tiket pesawat dan hotel gratis.',
    category: 'Travel',
    date: '10 Februari 2023',
    imageUrl: 'https://images.unsplash.com/photo-1436491865332-7a61a109cc05?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
    readTime: '7 menit',
    author: 'Diana Purnama',
    authorAvatar: 'https://i.pravatar.cc/150?img=6'
  },
  {
    id: 15,
    title: 'Kartu Kredit untuk Wirausahawan: Pilihan Terbaik',
    excerpt: 'Rekomendasi kartu kredit khusus untuk pengusaha dan pemilik bisnis kecil dengan manfaat yang mendukung pertumbuhan usaha.',
    category: 'Bisnis',
    date: '3 Februari 2023',
    imageUrl: 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
    readTime: '6 menit',
    author: 'Bambang Sutrisno',
    authorAvatar: 'https://i.pravatar.cc/150?img=8'
  },
  {
    id: 16,
    title: 'Apakah Cicilan 0% Benar-benar Menguntungkan?',
    excerpt: 'Analisis mendalam tentang program cicilan 0% pada kartu kredit, manfaat sebenarnya, dan hal-hal yang perlu diperhatikan.',
    category: 'Analisis',
    date: '28 Januari 2023',
    imageUrl: 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
    readTime: '5 menit',
    author: 'Yanti Setiawan',
    authorAvatar: 'https://i.pravatar.cc/150?img=20'
  },
  {
    id: 17,
    title: 'Memahami Score Kredit dan Pengaruhnya pada Aplikasi Kartu Kredit',
    excerpt: 'Panduan komprehensif tentang score kredit, bagaimana cara meningkatkannya, dan pentingnya untuk mendapatkan approval kartu kredit.',
    category: 'Edukasi',
    date: '20 Januari 2023',
    imageUrl: 'https://images.unsplash.com/photo-1554224154-22dec7ec8818?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
    readTime: '8 menit',
    author: 'Dina Fitriani',
    authorAvatar: 'https://i.pravatar.cc/150?img=19'
  },
  {
    id: 18,
    title: 'Kartu Kredit Syariah: Alternatif Tanpa Riba',
    excerpt: 'Penjelasan tentang kartu kredit syariah, perbedaannya dengan kartu kredit konvensional, dan rekomendasi terbaik di Indonesia.',
    category: 'Perbandingan',
    date: '15 Januari 2023',
    imageUrl: 'https://images.unsplash.com/photo-1535483102974-fa1e64d0ca86?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
    readTime: '6 menit',
    author: 'Farhan Abdullah',
    authorAvatar: 'https://i.pravatar.cc/150?img=17'
  },
  {
    id: 19,
    title: 'Cashback vs Poin Reward: Mana yang Lebih Menguntungkan?',
    excerpt: 'Perbandingan nilai sebenarnya antara kartu dengan program cashback dan kartu dengan sistem poin reward.',
    category: 'Perbandingan',
    date: '8 Januari 2023',
    imageUrl: 'https://images.unsplash.com/photo-1579621970563-ebec7560ff3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
    readTime: '5 menit',
    author: 'Guntur Prakoso',
    authorAvatar: 'https://i.pravatar.cc/150?img=16'
  },
  {
    id: 20,
    title: 'Manajemen Keuangan Pribadi dengan Kartu Kredit',
    excerpt: 'Cara menggunakan kartu kredit secara bijak sebagai alat manajemen keuangan pribadi dan budgeting.',
    category: 'Tips & Trik',
    date: '1 Januari 2023',
    imageUrl: 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
    readTime: '7 menit',
    author: 'Ratna Sari',
    authorAvatar: 'https://i.pravatar.cc/150?img=18'
  }
];

// Blog post card component
const BlogCard = ({ post }: { post: typeof blogPosts[0] }) => {
  return (
    <motion.div 
      className="group h-full flex flex-col bg-background/70 backdrop-blur-sm border border-border/50 rounded-xl overflow-hidden transition-all hover:border-blue-500/50 hover:shadow-lg hover:shadow-blue-500/10"
      whileHover={{ y: -5, transition: { duration: 0.2 } }}
    >
      <div className="relative h-48 overflow-hidden">
        <img 
          src={post.imageUrl} 
          alt={post.title} 
          className="w-full h-full object-cover transition-transform group-hover:scale-105 duration-500"
        />
        <div className="absolute inset-0 bg-gradient-to-t from-background/80 via-transparent to-transparent"></div>
        <div className="absolute top-3 right-3">
          <span className="inline-block px-3 py-1 bg-blue-600/90 backdrop-blur-sm rounded-full text-white text-xs font-medium shadow-lg">
            {post.category}
          </span>
        </div>
      </div>
      
      <div className="flex-1 flex flex-col p-5">
        <h3 className="text-lg font-bold mb-2 text-foreground group-hover:text-blue-500 transition-colors line-clamp-2">
          {post.title}
        </h3>
        <p className="text-muted-foreground text-sm mb-4 flex-1 line-clamp-3">
          {post.excerpt}
        </p>
        
        <div className="flex items-center justify-between mt-auto pt-4 border-t border-border/30">
          <div className="flex items-center">
            <img 
              src={post.authorAvatar} 
              alt={post.author} 
              className="w-8 h-8 rounded-full border border-border mr-2"
            />
            <div>
              <h4 className="text-foreground text-xs font-medium">{post.author}</h4>
              <div className="text-muted-foreground text-xs">{post.date}</div>
            </div>
          </div>
          
          <div className="flex items-center text-muted-foreground text-xs">
            <i className="ri-time-line mr-1"></i>
            {post.readTime}
          </div>
        </div>
      </div>
      
      <div className="px-5 py-3 bg-blue-950/10 backdrop-blur-sm border-t border-border/30 flex justify-between items-center">
        <span className="text-xs text-muted-foreground">#{post.id}</span>
        <button className="text-blue-500 text-sm font-medium flex items-center hover:text-blue-600 transition-colors">
          Baca <i className="ri-arrow-right-line ml-1"></i>
        </button>
      </div>
    </motion.div>
  );
};

// Main Blog Page component
const BlogPage: React.FC = () => {
  const [isMobileMenuOpen, setIsMobileMenuOpen] = React.useState(false);
  const [selectedCategory, setSelectedCategory] = React.useState<string | null>(null);
  const [isMobile, setIsMobile] = React.useState(false);
  
  // Deteksi tampilan mobile
  React.useEffect(() => {
    const checkIfMobile = () => {
      setIsMobile(window.innerWidth < 768);
    };
    
    checkIfMobile();
    window.addEventListener('resize', checkIfMobile);
    return () => window.removeEventListener('resize', checkIfMobile);
  }, []);

  return (
    <div className="min-h-screen overflow-x-hidden bg-background">
      <Header onMobileMenuToggle={() => setIsMobileMenuOpen(!isMobileMenuOpen)} />
      
      <main className="pb-20 px-4">
        {/* Fixed Categories at the top */}
        <div className="sticky top-0 pt-20 pb-4 z-30 bg-background">
          <div className="max-w-6xl mx-auto">
            <div className="flex justify-center items-center mb-4">
              <motion.h2 
                className="text-2xl font-display font-bold text-foreground"
                initial={{ opacity: 0, y: 10 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.4 }}
              >
                <span className="bg-clip-text text-transparent bg-gradient-to-r from-blue-500 to-indigo-600">
                  Artikel
                </span>
              </motion.h2>
            </div>
            
            <div className="relative">
              <div className="relative z-10 overflow-x-auto whitespace-nowrap pb-2 -mx-1 px-1 no-scrollbar">
                <motion.div 
                  className={`${isMobile ? 'flex flex-wrap gap-2' : 'inline-flex gap-2'} items-center ${isMobile ? 'h-auto py-2' : 'h-9'}`}
                  initial={{ opacity: 0, y: 10 }}
                  animate={{ opacity: 1, y: 0 }}
                  transition={{ duration: 0.4 }}
                  style={{ lineHeight: 0 }}
                >
                  {[
                    { id: null, name: 'Semua Artikel' },
                    { id: 'Tips & Trik', name: 'Tips & Trik' },
                    { id: 'Perbandingan', name: 'Perbandingan' },
                    { id: 'Edukasi', name: 'Edukasi' },
                    { id: 'Teknologi', name: 'Teknologi' },
                    { id: 'Panduan', name: 'Panduan' },
                    { id: 'Peringatan', name: 'Peringatan' },
                    { id: 'Bisnis', name: 'Bisnis' },
                    { id: 'Travel', name: 'Travel' },
                    { id: 'Analisis', name: 'Analisis' },
                    { id: 'Keamanan', name: 'Keamanan' }
                  ].map((category) => (
                    <motion.button 
                      key={category.id || 'all'}
                      className={`${isMobile ? 'h-8 my-1' : 'h-9 my-0'} px-4 rounded-full flex items-center justify-center leading-none ${selectedCategory === category.id ? 'bg-blue-600 text-white' : 'bg-foreground/10 text-foreground hover:bg-foreground/20'} border border-border/50 text-sm`}
                      onClick={() => setSelectedCategory(category.id)}
                      whileHover={{ scale: 1.05 }}
                      whileTap={{ scale: 0.95 }}
                    >
                      {category.name}
                    </motion.button>
                  ))}
                </motion.div>
              </div>
              {!isMobile && <div className="absolute right-0 top-0 h-full w-20 bg-gradient-to-l from-background to-transparent pointer-events-none"></div>}
            </div>
          </div>
          <div className="h-px w-full bg-border/30 mt-4"></div>
        </div>
        
        <div className="pt-6"></div>
        
        {/* Blog Post Grid */}
        <section className="max-w-6xl mx-auto">
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            {blogPosts
              .filter(post => selectedCategory === null || post.category === selectedCategory)
              .map((post, index) => (
                <motion.div
                  key={post.id}
                  initial={{ opacity: 0, y: 30 }}
                  animate={{ opacity: 1, y: 0 }}
                  transition={{ duration: 0.5, delay: 0.05 * Math.min(index, 10) }}
                >
                  <BlogCard post={post} />
                </motion.div>
              ))}
          </div>
          
          <div className="mt-16 text-center flex flex-col items-center">
            <motion.button 
              className="px-8 py-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-medium transition-colors shadow-lg shadow-blue-900/20 flex items-center gap-2"
              whileHover={{ scale: 1.05 }}
              whileTap={{ scale: 0.98 }}
            >
              <span>Muat Lebih Banyak</span>
              <i className="ri-refresh-line"></i>
            </motion.button>
            
            <p className="mt-4 text-sm text-muted-foreground">
              Menampilkan 20 dari 42 artikel
            </p>
          </div>
        </section>
      </main>
      
      <Footer />
      <MobileMenu isOpen={isMobileMenuOpen} onClose={() => setIsMobileMenuOpen(false)} />
    </div>
  );
};

export default BlogPage;