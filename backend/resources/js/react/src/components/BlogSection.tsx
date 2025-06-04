import React from 'react';
import { motion } from 'framer-motion';
import SectionArrow from './SectionArrow';

// Blog post data
const blogPosts = [
  {
    id: 'post1',
    title: 'Cara Memaksimalkan Poin Reward Kartu Kredit',
    excerpt: 'Panduan lengkap tentang cara mengumpulkan dan memaksimalkan poin reward dari kartu kredit Anda.',
    category: 'Tips',
    date: '12 Mei 2023',
    author: 'Sarah Wijaya',
    image: '',
    imageUrl: 'https://images.unsplash.com/photo-1563013544-824ae1b704d3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
    readTime: '5 menit',
  },
  {
    id: 'post2',
    title: '5 Kartu Kredit Terbaik untuk Travel di Tahun 2023',
    excerpt: 'Perbandingan kartu kredit dengan manfaat travel terbaik untuk merencanakan liburan Anda tahun ini.',
    category: 'Review',
    date: '28 April 2023',
    author: 'Budi Santoso',
    image: '',
    imageUrl: 'https://images.unsplash.com/photo-1517400508447-f8dd518b86db?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
    readTime: '7 menit',
  },
  {
    id: 'post3',
    title: 'Cashback vs. Miles: Mana yang Lebih Menguntungkan?',
    excerpt: 'Analisis mendalam tentang keuntungan memilih kartu kredit dengan cashback atau miles sebagai reward.',
    category: 'Analisis',
    date: '10 April 2023',
    author: 'Dewi Lestari',
    image: '',
    imageUrl: 'https://images.unsplash.com/photo-1564410267841-915d8e4d71ea?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
    readTime: '6 menit',
  },
  {
    id: 'post4',
    title: 'Mengoptimalkan Reward untuk Bisnis Anda',
    excerpt: 'Strategi menggunakan kartu kredit bisnis untuk memaksimalkan manfaat dan arus kas perusahaan Anda.',
    category: 'Bisnis',
    date: '5 April 2023',
    author: 'Anton Wijaya',
    image: '',
    imageUrl: 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
    readTime: '8 menit',
  },
  {
    id: 'post5',
    title: 'Panduan Merencanakan Perjalanan dengan Poin',
    excerpt: 'Cara merencanakan liburan impian menggunakan poin reward yang telah Anda kumpulkan.',
    category: 'Travel',
    date: '28 Maret 2023',
    author: 'Maya Sari',
    image: '',
    imageUrl: 'https://images.unsplash.com/photo-1488085061387-422e29b40080?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
    readTime: '10 menit',
  },
  {
    id: 'post6',
    title: 'Tips Menjaga Kesehatan Keuangan dengan Kartu Kredit',
    excerpt: 'Panduan lengkap untuk menggunakan kartu kredit secara bijak tanpa terjebak utang.',
    category: 'Keuangan',
    date: '15 Maret 2023',
    author: 'Rina Anggraini',
    image: '',
    imageUrl: 'https://images.unsplash.com/photo-1579621970588-a35d0e7ab9b6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
    readTime: '6 menit',
  }
];

const BlogPost = ({ post, index }: { post: typeof blogPosts[0], index: number }) => {
  return (
    <motion.article
      className="rounded-xl overflow-hidden bg-background/40 border border-border/50 backdrop-blur-sm"
      initial={{ opacity: 0, y: 20 }}
      whileInView={{ opacity: 1, y: 0 }}
      viewport={{ once: true }}
      transition={{ duration: 0.5, delay: index * 0.1 }}
      whileHover={{ y: -5, transition: { duration: 0.2 } }}
    >
      {/* Post image/gradient */}
      <div className="w-full h-48 relative overflow-hidden">
        <img 
          src={post.imageUrl} 
          alt={post.title}
          className="w-full h-full object-cover transform hover:scale-110 transition-transform duration-700"
        />
        <div className="absolute inset-0 bg-background/30 backdrop-blur-[2px]"></div>
        <div className="absolute top-4 left-4">
          <span className="px-3 py-1 bg-background/30 backdrop-blur-sm rounded-full text-xs font-medium text-foreground border border-border/50">
            {post.category}
          </span>
        </div>
      </div>
      
      {/* Post content */}
      <div className="p-6">
        <div className="flex justify-between items-center text-xs text-foreground/60 mb-3">
          <span>{post.date}</span>
          <span>{post.readTime}</span>
        </div>
        
        <h3 className="font-display text-lg font-bold text-foreground mb-3">{post.title}</h3>
        <p className="text-foreground/70 text-sm mb-4">{post.excerpt}</p>
        
        <div className="flex justify-between items-center">
          <span className="text-foreground/60 text-xs">Oleh {post.author}</span>
        </div>
      </div>
    </motion.article>
  );
};

const BlogSection: React.FC = () => {
  return (
    <section id="blog" className="relative min-h-screen py-20 px-4 border-t border-border flex items-center">
      {/* Background effects */}
      <div className="absolute inset-0 bg-dot-pattern opacity-10 pointer-events-none"></div>
      <div className="absolute inset-0 bg-gradient-to-b from-transparent to-background/20 pointer-events-none"></div>
      
      <div className="max-w-7xl mx-auto w-full">
        <motion.div
          className="text-center mb-16"
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          transition={{ duration: 0.6 }}
        >
          <motion.div 
            className="inline-block mb-2 px-4 py-1 rounded-full bg-background/30 backdrop-blur-sm border border-border/50"
            initial={{ opacity: 0, scale: 0.8 }}
            animate={{ opacity: 1, scale: 1 }}
            transition={{ duration: 0.4, delay: 0.2 }}
          >
            <span className="text-blue-400 text-sm font-medium">Artikel & Tips</span>
          </motion.div>
          
          <h2 className="font-display text-3xl md:text-4xl font-bold mb-4 tracking-tight text-foreground">
            <span className="bg-clip-text text-transparent bg-gradient-to-r from-foreground to-foreground/70">
              Blog Mileage
            </span>
          </h2>
          
          <div className="mx-auto w-20 h-1 bg-gradient-to-r from-blue-500 to-indigo-600 mb-6"></div>
          
          <p className="text-foreground/80 max-w-2xl mx-auto text-lg">
            Berbagai artikel, tips, dan panduan untuk memaksimalkan manfaat kartu kredit Anda.
          </p>
        </motion.div>
        
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
          {blogPosts.map((post, index) => (
            <BlogPost key={post.id} post={post} index={index} />
          ))}
        </div>
        

        
        {/* Section navigation arrow removed */}
      </div>
    </section>
  );
};

export default BlogSection;