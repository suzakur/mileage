import React, { useRef, useEffect } from 'react';
import { motion, useAnimation, useMotionValue, useTransform } from 'framer-motion';
import PhoneDisplay from './PhoneDisplay';
import SectionArrow from './SectionArrow';
import AirplaneAnimation from './AirplaneAnimation';
import { useIsMobile } from '@/hooks/use-mobile';

const HeroSection: React.FC = () => {
  const isMobile = useIsMobile();
  const containerRef = useRef<HTMLDivElement>(null);
  const x = useMotionValue(0);
  const y = useMotionValue(0);
  
  // Transform for 3D effect
  const rotateX = useTransform(y, [-100, 100], [5, -5]);
  const rotateY = useTransform(x, [-100, 100], [-5, 5]);
  
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
  return (
    <section id="hero" className="relative min-h-screen w-full flex items-center justify-center px-4 py-10 overflow-hidden bg-background">
      {/* Background Effects */}
      <div className="absolute inset-0 z-0">
        {/* Modern subtle dot pattern */}
        <div className="absolute inset-0" style={{
          backgroundImage: 'radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px)',
          backgroundSize: '30px 30px',
          opacity: 0.15
        }}></div>
        
        {/* Simpler gradient background */}
        <div className="absolute inset-0 pointer-events-none opacity-20" 
             style={{ 
               backgroundImage: 'radial-gradient(circle at 50% 50%, rgba(255, 255, 255, 0.1), transparent 70%)'
             }}></div>
      </div>
      
      {/* Hero Content */}
      <motion.div 
        ref={containerRef}
        className="flex flex-col lg:flex-row items-center justify-between gap-10 w-full max-w-6xl mx-auto z-10 relative"
        style={{ 
          perspective: 1000
        }}
      >
        <motion.div
          className="text-left lg:w-1/2"
          initial={{ opacity: 0, x: -30 }}
          animate={{ opacity: 1, x: 0 }}
          transition={{ duration: 0.8, ease: [0.25, 0.1, 0.25, 1] }}
          style={{ 
            transformStyle: "preserve-3d",
            transform: !isMobile ? `rotateX(${rotateX.get()}deg) rotateY(${rotateY.get()}deg)` : undefined
          }}
        >
          <motion.div 
            className="inline-block mb-2 px-4 py-1 rounded-full bg-foreground/5 backdrop-blur-sm border border-border/50"
            initial={{ opacity: 0, scale: 0.8 }}
            animate={{ opacity: 1, scale: 1 }}
            transition={{ duration: 0.4, delay: 0.2 }}
          >
            <span className={`text-foreground ${isMobile ? 'text-xs' : 'text-sm'} font-medium`}>Poin Reward • Benefit Perjalanan • Cashback</span>
          </motion.div>
          
          <motion.h1 
            className={`font-display ${isMobile ? 'text-3xl mb-4' : 'text-4xl md:text-6xl mb-6'} font-bold text-foreground`}
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6, delay: 0.3 }}
          >
            <span className="bg-clip-text text-transparent bg-gradient-to-r from-foreground via-foreground to-foreground/70">
              Maksimalkan
            </span>
            <span className="block mt-2 bg-clip-text text-transparent bg-gradient-to-r from-foreground to-foreground/60">
              Poin Reward Anda
            </span>
          </motion.h1>
          
          <motion.p 
            className={`${isMobile ? 'text-sm' : 'text-lg md:text-xl'} text-muted-foreground ${isMobile ? 'mb-6' : 'mb-8'} leading-relaxed`}
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            transition={{ duration: 0.6, delay: 0.4 }}
          >
            {isMobile 
              ? 'Temukan kartu kredit dengan reward perjalanan terbaik. Tanpa biaya tersembunyi.'
              : 'Temukan dan bandingkan kartu kredit dengan reward perjalanan terbaik melalui platform kami yang intuitif. Tanpa biaya tersembunyi, hanya manfaat mile yang maksimal.'
            }
          </motion.p>
        </motion.div>
        
        {/* iPhone with Credit Cards */}
        <motion.div
          className="w-full lg:w-1/2 max-w-md mx-auto z-10"
          initial={{ opacity: 0, y: 40 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ 
            duration: 0.8, 
            delay: 0.6, 
            ease: [0.25, 0.1, 0.25, 1] 
          }}
          style={{ 
            transformStyle: "preserve-3d",
            transform: !isMobile ? `rotateX(${rotateX.get() * 0.7}deg) rotateY(${rotateY.get() * 0.7}deg)` : undefined
          }}
        >
          <PhoneDisplay />
        </motion.div>
      </motion.div>
      
      {/* Airplane animations - more subtle, white colors */}
      <AirplaneAnimation position="top-left" color="text-white" size="small" />
      <AirplaneAnimation position="top-right" color="text-white" size="medium" />
      <AirplaneAnimation position="bottom-left" color="text-white" size="small" />
      <AirplaneAnimation position="bottom-right" color="text-white" size="medium" />
      <AirplaneAnimation position="center" color="text-white" size="medium" />
      <AirplaneAnimation position="top-left" color="text-white/60" size="small" />
      <AirplaneAnimation position="bottom-right" color="text-white/60" size="large" />
      
      {/* Section navigation arrow removed */}
    </section>
  );
};

export default HeroSection;