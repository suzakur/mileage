import React, { useState } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import SectionArrow from './SectionArrow';

// Define promotion cards
const allPromotions = [
  {
    id: 'promo1',
    title: 'Kartu Travel Premium',
    description: '3X poin untuk penerbangan, hotel, dan restoran dengan Kartu Travel Premium sepanjang musim liburan.',
    gradient: 'from-blue-500 to-purple-500',
    icon: 'ri-flight-takeoff-line',
    offer: 'Terbatas',
    category: 'travel'
  },
  {
    id: 'promo2',
    title: 'Cashback 5%',
    description: 'Dapatkan cashback 5% untuk semua pembelian selama 3 bulan pertama dengan Kartu Cashback Pro baru.',
    gradient: 'from-amber-500 to-yellow-500',
    icon: 'ri-money-dollar-circle-line',
    offer: 'Pengguna Baru',
    category: 'cashback'
  },
  {
    id: 'promo3',
    title: 'Tanpa Biaya Tahunan',
    description: 'Bebas biaya tahunan untuk tahun pertama saat Anda mendaftar Kartu Elite Rewards sebelum 30 Juni.',
    gradient: 'from-green-500 to-teal-500',
    icon: 'ri-bank-card-line',
    offer: 'Terbatas',
    category: 'rewards'
  },
  {
    id: 'promo4',
    title: '0% Bunga 12 Bulan',
    description: 'Nikmati 0% bunga selama 12 bulan untuk semua pembelian dan transfer saldo dengan Kartu Balance Pro.',
    gradient: 'from-pink-500 to-red-500',
    icon: 'ri-percent-line',
    offer: 'Transfer Saldo',
    category: 'balance'
  },
  {
    id: 'promo5',
    title: 'Poin Welcome 50,000',
    description: 'Dapatkan 50,000 poin welcome bonus setelah pembelanjaan Rp5 juta dalam 3 bulan pertama.',
    gradient: 'from-indigo-500 to-blue-500',
    icon: 'ri-gift-line',
    offer: 'Bonus',
    category: 'rewards'
  },
  {
    id: 'promo6',
    title: 'Cashback Belanja Online',
    description: 'Cashback 7% untuk semua pembelanjaan online di e-commerce partner dengan Kartu Digital.',
    gradient: 'from-orange-500 to-amber-500',
    icon: 'ri-shopping-cart-line',
    offer: 'E-commerce',
    category: 'cashback'
  },
  {
    id: 'promo7',
    title: 'Miles Penerbangan 2X',
    description: 'Dapatkan miles 2X untuk semua pembelian tiket pesawat dengan Kartu Skypass Premium.',
    gradient: 'from-blue-400 to-cyan-500',
    icon: 'ri-plane-line',
    offer: 'Travel',
    category: 'travel'
  },
  {
    id: 'promo8',
    title: 'Dining Rewards',
    description: 'Poin 4X di semua restoran dan 10% diskon di restoran partner dengan Kartu Dining Privileges.',
    gradient: 'from-red-400 to-rose-500',
    icon: 'ri-restaurant-line',
    offer: 'Kuliner',
    category: 'dining'
  },
  {
    id: 'promo9',
    title: 'Kartu Bisnis Premier',
    description: 'Kelola pengeluaran bisnis dengan lebih efisien dan dapatkan laporan pengeluaran terperinci.',
    gradient: 'from-gray-600 to-slate-700',
    icon: 'ri-briefcase-line',
    offer: 'Bisnis',
    category: 'business'
  }
];

const PromotionCard = ({ promotion, index }: { promotion: typeof allPromotions[0], index: number }) => {
  return (
    <motion.div
      className="p-6 rounded-xl relative overflow-hidden border border-border/50 backdrop-blur-sm bg-card/50"
      initial={{ opacity: 0, y: 20 }}
      whileInView={{ opacity: 1, y: 0 }}
      viewport={{ once: true }}
      transition={{ duration: 0.5, delay: index * 0.1 }}
      whileHover={{ y: -5, scale: 1.02 }}
    >
      <div className="relative z-10">
        <div className="flex justify-between items-start mb-4">
          <div className="w-12 h-12 rounded-lg flex items-center justify-center border border-border/50 bg-background/30">
            <i className={`${promotion.icon} text-xl text-foreground`}></i>
          </div>
          <span className="text-xs font-medium px-3 py-1 rounded-full bg-background/30 backdrop-blur-sm border border-border/50 text-foreground">
            {promotion.offer}
          </span>
        </div>
        
        <span className="text-xs text-foreground/60 mb-2 font-medium inline-block">{promotion.category.toUpperCase()}</span>
        <h3 className="text-foreground text-xl font-medium mb-3">{promotion.title}</h3>
        <p className="text-foreground/80 mb-6 text-sm">{promotion.description}</p>
        
        <motion.button
          className="flex items-center text-foreground font-medium hover:text-foreground/80 transition-colors duration-200"
          whileHover={{ x: 5 }}
          whileTap={{ x: 0 }}
        >
          Ajukan Sekarang <i className="ri-arrow-right-line ml-2"></i>
        </motion.button>
      </div>
    </motion.div>
  );
};

const PromotionsSection: React.FC = () => {
  const [selectedCategory, setSelectedCategory] = useState<string | null>(null);
  
  // Filter promotions based on selected category
  const filteredPromotions = selectedCategory 
    ? allPromotions.filter(promo => promo.category === selectedCategory)
    : allPromotions;
    
  const categories = [
    { id: 'all', label: 'Semua' },
    { id: 'travel', label: 'Travel' },
    { id: 'cashback', label: 'Cashback' },
    { id: 'rewards', label: 'Rewards' },
    { id: 'business', label: 'Bisnis' },
    { id: 'dining', label: 'Kuliner' },
    { id: 'balance', label: 'Balance' }
  ];
  return (
    <section id="promotions" className="relative min-h-screen py-20 px-4 border-t border-border flex items-center">
      {/* Background effects */}
      <div className="absolute inset-0 bg-dot-pattern opacity-10 pointer-events-none"></div>
      <div className="absolute inset-0 bg-gradient-to-b from-transparent to-background/30 pointer-events-none"></div>
      
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
            <span className="text-foreground text-sm font-medium">Penawaran Khusus</span>
          </motion.div>
          
          <h2 className="font-display text-3xl md:text-4xl font-bold mb-4 tracking-tight text-foreground">
            <span className="bg-clip-text text-transparent bg-gradient-to-r from-blue-500 to-indigo-600">
              Promosi yang Sedang Trend
            </span>
          </h2>
          
          <div className="mx-auto w-20 h-1 bg-gradient-to-r from-blue-500 to-indigo-600 mb-6"></div>
          
          <p className="text-foreground/80 max-w-2xl mx-auto text-lg mb-8">
            Jangan lewatkan penawaran terpopuler saat ini yang dapat memaksimalkan manfaat kartu kredit Anda.
          </p>
          
          {/* Category filter */}
          <div className="flex flex-wrap justify-center gap-2 mb-12">
            {categories.map((category) => (
              <motion.button
                key={category.id}
                onClick={() => setSelectedCategory(category.id === 'all' ? null : category.id)}
                className={`px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 ${
                  (category.id === 'all' && selectedCategory === null) || category.id === selectedCategory
                    ? 'bg-foreground text-background'
                    : 'bg-background/30 backdrop-blur-sm border border-border/50 text-foreground hover:bg-background/50'
                }`}
                whileHover={{ scale: 1.05 }}
                whileTap={{ scale: 0.95 }}
              >
                {category.label}
              </motion.button>
            ))}
          </div>
        </motion.div>
        
        <AnimatePresence mode="wait">
          {filteredPromotions.length > 0 ? (
            <motion.div 
              key="grid"
              className="grid grid-cols-1 md:grid-cols-3 gap-6"
              initial={{ opacity: 0 }}
              animate={{ opacity: 1 }}
              exit={{ opacity: 0 }}
            >
              {filteredPromotions.map((promotion, index) => (
                <PromotionCard key={promotion.id} promotion={promotion} index={index} />
              ))}
            </motion.div>
          ) : (
            <motion.div 
              key="empty"
              className="text-center py-20"
              initial={{ opacity: 0 }}
              animate={{ opacity: 1 }}
              exit={{ opacity: 0 }}
            >
              <i className="ri-inbox-line text-5xl text-foreground/20 mb-4 block"></i>
              <h3 className="text-xl text-foreground mb-2">Tidak ada promosi ditemukan</h3>
              <p className="text-foreground/60">Silakan pilih kategori lain</p>
            </motion.div>
          )}
        </AnimatePresence>
        
        <motion.div 
          className="mt-16 text-center"
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          transition={{ duration: 0.6, delay: 0.3 }}
        >
          <motion.button
            className="inline-flex items-center px-8 py-3 rounded-full bg-foreground text-background font-medium"
            whileHover={{ scale: 1.05 }}
            whileTap={{ scale: 0.98 }}
          >
            Lihat Semua Promo <i className="ri-arrow-right-line ml-2"></i>
          </motion.button>
        </motion.div>
        
        {/* Section navigation arrow removed */}
      </div>
    </section>
  );
};

export default PromotionsSection;