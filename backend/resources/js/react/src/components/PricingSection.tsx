import React, { useState, useEffect } from 'react';
import { motion } from 'framer-motion';
import SectionArrow from './SectionArrow';
import { 
  Carousel,
  CarouselContent,
  CarouselItem,
  CarouselNext,
  CarouselPrevious 
} from '@/components/ui/carousel';

// Define pricing plans
const pricingPlans = [
  {
    id: 'basic',
    name: 'Dasar',
    price: 'Gratis',
    description: 'Perbandingan kartu dasar dan rekomendasi',
    gradient: 'from-gray-700 to-gray-900',
    features: [
      'Bandingkan hingga 5 kartu',
      'Kalkulator reward dasar',
      'Dukungan email',
      'Newsletter bulanan'
    ],
    featured: false,
    cta: 'Mulai Sekarang'
  },
  {
    id: 'pro',
    name: 'Pro',
    price: 'Rp 149.000',
    period: 'per bulan',
    description: 'Fitur lanjutan untuk traveler serius',
    gradient: 'from-blue-600 to-indigo-600',
    features: [
      'Bandingkan kartu tanpa batas',
      'Kalkulator reward canggih',
      'Dukungan email prioritas',
      'Rekomendasi personal',
      'Analisis pengeluaran travel',
      'Penawaran eksklusif partner'
    ],
    featured: true,
    cta: 'Coba 14 Hari Gratis'
  },
  {
    id: 'business',
    name: 'Bisnis',
    price: 'Rp 449.000',
    period: 'per bulan',
    description: 'Untuk traveler bisnis dan perusahaan',
    gradient: 'from-purple-600 to-indigo-600',
    features: [
      'Semua fitur Pro',
      'Manajemen tim',
      'Analisis kartu bisnis',
      'Kategorisasi pengeluaran',
      'Akses API',
      'Manajer akun dedicated'
    ],
    featured: false,
    cta: 'Hubungi Sales'
  }
];

const PricingCard = ({ plan, index }: { plan: typeof pricingPlans[0], index: number }) => {
  return (
    <motion.div
      className={`rounded-xl overflow-visible relative flex flex-col h-full ${plan.featured ? 'lg:scale-105 z-10' : ''}`}
      initial={{ opacity: 0, y: 30 }}
      whileInView={{ opacity: 1, y: 0 }}
      viewport={{ once: true }}
      transition={{ duration: 0.5, delay: index * 0.1 }}
    >
      {/* Background gradient */}
      <div className={`absolute inset-0 bg-gradient-to-br ${plan.gradient} opacity-10`}></div>
      
      {/* Border */}
      <div className="absolute inset-0 rounded-xl border border-border/50"></div>
      
      {/* Glass effect */}
      <div className="flex-1 backdrop-blur-sm bg-background/40 p-8 relative z-10">
        {plan.featured && (
          <div className="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 px-4 py-1.5 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full text-white text-xs font-medium whitespace-nowrap shadow-lg z-20">
            Paling Populer
          </div>
        )}
        
        <h3 className="text-foreground font-display text-xl font-bold mb-1">{plan.name}</h3>
        
        <div className="flex items-baseline mb-4">
          <span className="text-foreground text-3xl font-display font-bold">{plan.price}</span>
          {plan.period && <span className="ml-2 text-foreground/60 text-sm">{plan.period}</span>}
        </div>
        
        <p className="text-foreground/70 mb-6 text-sm">{plan.description}</p>
        
        <ul className="space-y-3 mb-8">
          {plan.features.map((feature, i) => (
            <motion.li 
              key={i} 
              className="flex items-center text-foreground/80"
              initial={{ opacity: 0, x: -10 }}
              whileInView={{ opacity: 1, x: 0 }}
              viewport={{ once: true }}
              transition={{ delay: 0.3 + (i * 0.05) }}
            >
              <i className="ri-check-line text-blue-400 mr-3"></i>
              {feature}
            </motion.li>
          ))}
        </ul>
      </div>
      
      {/* CTA Section */}
      <div className="p-6 backdrop-blur-sm bg-background/60 border-t border-border/30 relative z-10">
        <motion.button
          className={`w-full py-3 rounded-lg font-medium ${
            plan.featured 
              ? 'bg-gradient-to-r from-blue-500 to-indigo-600 text-white' 
              : 'bg-foreground/10 border border-border/50 text-foreground hover:bg-foreground/20'
          }`}
          whileHover={{ y: -2, boxShadow: '0 10px 20px rgba(0,0,0,0.1)' }}
          whileTap={{ y: 0 }}
        >
          {plan.cta}
        </motion.button>
      </div>
    </motion.div>
  );
};

const PricingSection: React.FC = () => {
  // State untuk mendeteksi mobile view
  const [isMobile, setIsMobile] = useState(false);

  // Effect untuk mendeteksi ukuran layar
  useEffect(() => {
    const checkIfMobile = () => {
      setIsMobile(window.innerWidth < 768);
    };
    
    // Check awal
    checkIfMobile();
    
    // Event listener untuk resize
    window.addEventListener('resize', checkIfMobile);
    
    // Cleanup
    return () => {
      window.removeEventListener('resize', checkIfMobile);
    };
  }, []);
  
  return (
    <section id="pricing" className="relative min-h-screen py-20 px-4 border-t border-border flex items-center">
      {/* Background effects */}
      <div className="absolute inset-0 bg-dot-pattern opacity-10 pointer-events-none"></div>
      <div className="absolute inset-0 opacity-30 pointer-events-none" 
           style={{ 
             backgroundImage: 'radial-gradient(circle at 10% 20%, rgba(30, 64, 175, 0.15), transparent 30%), radial-gradient(circle at 80% 70%, rgba(109, 40, 217, 0.15), transparent 30%)' 
           }}>
      </div>
      
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
            whileHover={{ scale: 1.05 }}
          >
            <span className="text-blue-400 text-sm font-medium">Paket Fleksibel</span>
          </motion.div>
          
          <motion.h2 
            className="font-display text-3xl md:text-4xl font-bold mb-4 tracking-tight text-foreground"
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true }}
            transition={{ duration: 0.6, delay: 0.2 }}
          >
            <motion.span 
              className="bg-clip-text text-transparent bg-gradient-to-r from-foreground to-foreground/70 inline-block"
              whileHover={{ scale: 1.02 }}
            >
              Pilih Paket yang Tepat
            </motion.span>
          </motion.h2>
          
          <motion.div 
            className="mx-auto w-20 h-1 bg-gradient-to-r from-blue-500 to-indigo-600 mb-6"
            initial={{ width: 0, opacity: 0 }}
            whileInView={{ width: 80, opacity: 1 }}
            viewport={{ once: true }}
            transition={{ duration: 0.6, delay: 0.3 }}
            whileHover={{ width: 100 }}
          ></motion.div>
          
          <motion.p 
            className="text-foreground/80 max-w-2xl mx-auto text-lg"
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true }}
            transition={{ duration: 0.6, delay: 0.4 }}
          >
            Pilih paket yang paling sesuai dengan kebutuhan Anda, dari pelancong biasa hingga profesional bisnis.
          </motion.p>
        </motion.div>
        
        {isMobile ? (
          // Tampilan carousel untuk mobile dengan defaultIndex mengarah ke paket Pro (index 1)
          <div className="mb-8">
            <Carousel
              opts={{
                align: "center",
                loop: true,
                startIndex: 1, // Mulai dari paket Pro yang ada di index 1
              }}
              className="w-full"
            >
              <CarouselContent>
                {/* Urutkan ulang agar paket featured (Pro) muncul pertama */}
                {[...pricingPlans].sort((a, b) => {
                  if (a.featured) return -1;
                  if (b.featured) return 1;
                  return 0;
                }).map((plan, index) => (
                  <CarouselItem key={plan.id} className="basis-full md:basis-1/2 lg:basis-1/3 px-2">
                    <div className="h-full">
                      <PricingCard plan={plan} index={index} />
                    </div>
                  </CarouselItem>
                ))}
              </CarouselContent>
              <div className="flex justify-center mt-8 gap-4">
                <CarouselPrevious className="static transform-none bg-background/20 border border-border/50 hover:bg-background/40" />
                <CarouselNext className="static transform-none bg-background/20 border border-border/50 hover:bg-background/40" />
              </div>
            </Carousel>
          </div>
        ) : (
          // Tampilan grid untuk desktop
          <div className="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-4 pt-6">
            {pricingPlans.map((plan, index) => (
              <PricingCard key={plan.id} plan={plan} index={index} />
            ))}
          </div>
        )}
        
        {/* FAQs Teaser */}
        <motion.div
          className="mt-24 text-center"
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          transition={{ duration: 0.6, delay: 0.4 }}
        >
          <motion.h3 
            className="text-white font-display text-2xl font-bold mb-4"
            initial={{ opacity: 0, y: 10 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true }}
            transition={{ duration: 0.4, delay: 0.5 }}
          >
            Pertanyaan yang Sering Diajukan
          </motion.h3>
          
          <motion.p 
            className="text-gray-400 max-w-2xl mx-auto mb-6"
            initial={{ opacity: 0, y: 10 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true }}
            transition={{ duration: 0.4, delay: 0.6 }}
          >
            Punya pertanyaan tentang paket atau fitur kami? Lihat bagian FAQ kami atau hubungi tim dukungan kami.
          </motion.p>
          
          <motion.button
            className="px-6 py-3 rounded-lg bg-white/5 border border-white/10 text-white hover:bg-white/10 transition-all duration-300"
            whileHover={{ y: -3, boxShadow: "0 10px 25px rgba(0, 0, 0, 0.1)" }}
            whileTap={{ scale: 0.98 }}
            onClick={() => document.getElementById('cta')?.scrollIntoView({behavior: 'smooth'})}
            initial={{ opacity: 0, y: 10 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true }}
            transition={{ duration: 0.4, delay: 0.7 }}
          >
            Hubungi Dukungan
          </motion.button>
        </motion.div>
        
        {/* Section navigation arrow removed */}
      </div>
    </section>
  );
};

export default PricingSection;