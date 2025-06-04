import React, { useState, useEffect, useRef } from 'react';
import { motion, useMotionValue, useTransform } from 'framer-motion';
import SectionArrow from './SectionArrow';
import { useIsMobile } from '@/hooks/use-mobile';

const features = [
  {
    icon: "ri-compass-line",
    title: "Smart Rewards Tracking",
    description: "Intelligent system tracks all your card rewards and suggests the optimal card for each purchase to maximize your points.",
    gradient: "from-blue-600 to-indigo-600",
    link: "#"
  },
  {
    icon: "ri-wallet-3-line",
    title: "Catat Pengeluaran",
    description: "Rekam dan kategorikan semua transaksi keuangan Anda dengan mudah. Dapatkan grafik analisis pengeluaran bulanan.",
    gradient: "from-emerald-600 to-teal-600",
    link: "#"
  },
  {
    icon: "ri-calendar-todo-line",
    title: "Reminder Pembayaran",
    description: "Dapatkan notifikasi otomatis untuk tanggal jatuh tempo pembayaran. Hindari keterlambatan dan biaya tambahan.",
    gradient: "from-orange-600 to-red-600",
    link: "#"
  },
  {
    icon: "ri-trophy-line",
    title: "Spending Challenge",
    description: "Ikuti tantangan pengeluaran mingguan & bulanan untuk mendapatkan poin tambahan dan rewards eksklusif.",
    gradient: "from-pink-600 to-purple-600",
    link: "#"
  },
  {
    icon: "ri-exchange-line",
    title: "Transfer Poin",
    description: "Transfer dan gabungkan poin reward dari berbagai kartu kredit ke program miles favorit Anda.",
    gradient: "from-red-600 to-orange-600",
    link: "#"
  },
  {
    icon: "ri-lock-line",
    title: "Keamanan Tingkat Tinggi",
    description: "Sistem keamanan lapis ganda dengan enkripsi end-to-end untuk melindungi semua data Anda.",
    gradient: "from-indigo-600 to-blue-600",
    link: "#"
  },
  {
    icon: "ri-flight-takeoff-line",
    title: "Travel Benefit Analyzer",
    description: "Our AI analyzes your travel patterns and finds the cards with the best airline miles, hotel points, and travel benefits.",
    gradient: "from-purple-600 to-blue-600",
    link: "#"
  }
];

const FeatureCard = ({ feature, index, isMobile }: { feature: typeof features[0], index: number, isMobile: boolean }) => {
  return (
    <motion.div 
      className={`bg-black ${isMobile ? 'p-5' : 'p-8'} relative overflow-hidden rounded-xl transition-all duration-300 
                border border-gray-800 hover:border-gray-700 glass group`}
      initial={{ opacity: 0, y: 30 }}
      animate={{ opacity: 1, y: 0 }}
      transition={{ duration: 0.4, delay: index * 0.15 }}
      whileHover={{ 
        y: -8,
        boxShadow: "0 20px 40px rgba(0, 0, 0, 0.3)",
      }}
      whileTap={{ scale: 0.98 }}
    >
      {/* Background gradient with animation */}
      <motion.div 
        className="absolute -inset-1 rounded-xl opacity-20 bg-gradient-to-r pointer-events-none"
        style={{
          backgroundImage: `linear-gradient(to right, hsl(var(--modern-highlight)), transparent)`,
        }}
        animate={{
          opacity: [0.15, 0.25, 0.15],
        }}
        transition={{
          repeat: Infinity,
          duration: 5,
          ease: "easeInOut"
        }}
      />
      
      {/* Icon */}
      <div className="relative z-10">
        <motion.div 
          className="w-14 h-14 rounded-full flex items-center justify-center text-white text-2xl mb-6 overflow-hidden"
          style={{
            background: `linear-gradient(135deg, ${feature.gradient.split(' ')[0]}, ${feature.gradient.split(' ')[1]})`,
            boxShadow: "0 10px 20px rgba(0, 0, 0, 0.15)"
          }}
          whileHover={{
            scale: 1.1,
            rotate: 5,
          }}
          transition={{ type: "spring", stiffness: 400, damping: 10 }}
        >
          <i className={feature.icon}></i>
        </motion.div>
        
        <motion.h3 
          className="text-lg md:text-xl font-display font-bold mb-2 text-foreground"
          initial={{ opacity: 0 }}
          animate={{ opacity: 1 }}
          transition={{ delay: 0.2 }}
        >
          {feature.title}
        </motion.h3>
        
        <motion.p 
          className="text-muted-foreground text-sm mb-4 line-clamp-3"
          initial={{ opacity: 0 }}
          animate={{ opacity: 1 }}
          transition={{ delay: 0.3 }}
        >
          {feature.description}
        </motion.p>
        
        <motion.a 
          href={feature.link}
          className="inline-flex items-center text-sm font-medium text-blue-400 hover:text-blue-300 transition-colors"
          whileHover={{ x: 5 }}
          transition={{ type: "spring", stiffness: 400, damping: 10 }}
        >
          <span className="mr-1">Learn more</span>
          <i className="ri-arrow-right-line"></i>
        </motion.a>
      </div>
    </motion.div>
  );
};

const FeaturesSection: React.FC = () => {
  const isMobile = useIsMobile();
  const containerRef = useRef<HTMLDivElement>(null);
  const x = useMotionValue(0);
  const y = useMotionValue(0);
  
  // Transform for 3D effect
  const rotateX = useTransform(y, [-100, 100], [3, -3]);
  const rotateY = useTransform(x, [-100, 100], [-3, 3]);
  
  // Handle mouse move for 3D effect
  useEffect(() => {
    const handleMouseMove = (e: MouseEvent) => {
      if (isMobile || !containerRef.current) return;
      
      const rect = containerRef.current.getBoundingClientRect();
      const centerX = rect.left + rect.width / 2;
      const centerY = rect.top + rect.height / 2;
      
      x.set((e.clientX - centerX) / 10);
      y.set((e.clientY - centerY) / 10);
    };
    
    window.addEventListener('mousemove', handleMouseMove);
    return () => window.removeEventListener('mousemove', handleMouseMove);
  }, [x, y, isMobile]);
  
  // Tambahkan juga section padding yang lebih kecil untuk mobile
  const sectionPadding = isMobile ? 'py-14' : 'py-20';
  
  // Pada tampilan mobile, hanya tampilkan 4 fitur teratas untuk merampingkan halaman
  const displayedFeatures = isMobile ? features.slice(0, 4) : features;
  
  return (
    <section id="features" className={`relative ${isMobile ? '' : 'min-h-screen'} ${sectionPadding} px-4 md:px-8 lg:px-16 border-t border-border z-10 flex items-center`}>
      <div ref={containerRef} className="max-w-7xl mx-auto w-full" style={{ perspective: 1000 }}>
        <div style={{ 
          transformStyle: "preserve-3d",
          transform: !isMobile ? `rotateX(${rotateX.get()}deg) rotateY(${rotateY.get()}deg)` : undefined
        }}>
          <motion.div 
            className={`text-center ${isMobile ? 'mb-10' : 'mb-16'}`}
            initial={{ opacity: 0, y: 50 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.7, type: "spring", stiffness: 100 }}
          >
            <motion.div 
              className="inline-block mb-2 px-4 py-1 rounded-full bg-background/30 backdrop-blur-sm border border-border/50"
              initial={{ opacity: 0, scale: 0.8, y: -20 }}
              animate={{ opacity: 1, scale: 1, y: 0 }}
              transition={{ duration: 0.5, delay: 0.2, type: "spring" }}
              whileHover={{ scale: 1.05, y: -2 }}
            >
              <span className="text-blue-400 text-sm font-medium">Powerful Features</span>
            </motion.div>
            
            <motion.h2 
              className={`font-display ${isMobile ? 'text-2xl' : 'text-3xl md:text-4xl'} font-bold ${isMobile ? 'mb-3' : 'mb-4'} tracking-tight text-foreground`}
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.5, delay: 0.3 }}
            >
              <motion.span 
                className="bg-clip-text text-transparent bg-gradient-to-r from-foreground to-foreground/70 inline-block"
                whileHover={{ scale: 1.02 }}
                transition={{ duration: 0.2 }}
              >
                Designed for Travelers
              </motion.span>
            </motion.h2>
            
            <div className="mx-auto w-20 h-1 bg-gradient-to-r from-blue-500 to-indigo-600 mb-4"></div>
            
            <p className="text-muted-foreground max-w-2xl mx-auto">
              Fitur-fitur cerdas untuk membantu Anda memaksimalkan nilai dari setiap kartu kredit.
            </p>
          </motion.div>
          
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {displayedFeatures.map((feature, index) => (
              <FeatureCard key={feature.title} feature={feature} index={index} isMobile={isMobile} />
            ))}
          </div>
          
          {/* Section navigation arrow removed */}
          
          {/* Link untuk melihat lebih banyak fitur (hanya untuk mobile) */}
          {isMobile && (
            <div className="mt-10 text-center">
              <motion.a
                href="#"
                className="inline-flex items-center px-5 py-2 rounded-lg bg-foreground/10 border border-border/50 text-foreground hover:bg-foreground/20 transition-all"
                whileHover={{ y: -2, boxShadow: "0 10px 25px rgba(0,0,0,0.1)" }}
                whileTap={{ scale: 0.98 }}
              >
                <span className="mr-2">Lihat semua fitur</span>
                <i className="ri-arrow-right-line"></i>
              </motion.a>
            </div>
          )}
        </div>
      </div>
    </section>
  );
};

export default FeaturesSection;