import React, { useState, useEffect } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import CreditCard from './CreditCard';

// Card data
const cards = [
  {
    id: 'card1',
    type: 'standard',
    title: 'Mileage Basic',
    color: 'bg-gradient-to-br from-black to-gray-900',
    benefits: ['0% Biaya Transfer', '1% Cashback', 'Tanpa Biaya Tahunan'],
    entranceDelay: 0.5,
    entrancePosition: 'left'
  },
  {
    id: 'card2',
    type: 'premium',
    title: 'Mileage Premiere',
    color: 'bg-gradient-to-br from-blue-500/20 to-blue-500/5',
    benefits: ['2X Miles Penerbangan', 'Akses Lounge', '2% Cashback Restoran'],
    entranceDelay: 0.8,
    entrancePosition: 'right'
  },
  {
    id: 'card3',
    type: 'business',
    title: 'Mileage Business',
    color: 'bg-gradient-to-br from-white/20 to-white/5',
    benefits: ['3% Cashback Bisnis', 'Laporan Pengeluaran', 'Manajemen Tim'],
    entranceDelay: 1.1,
    entrancePosition: 'left'
  },
  {
    id: 'card4',
    type: 'standard',
    title: 'Mileage Black',
    color: 'bg-gradient-to-br from-gray-800 to-black',
    benefits: ['Keamanan Tingkat Tinggi', 'Notifikasi Real-Time', 'Kontrol Belanja Online'],
    entranceDelay: 1.4,
    entrancePosition: 'right'
  },
  {
    id: 'card5',
    type: 'premium',
    title: 'Mileage Travel',
    color: 'bg-gradient-to-br from-amber-500/20 to-amber-500/5',
    benefits: ['Asuransi Perjalanan', '3X Miles Penerbangan', 'Tidak Ada Biaya Asing'],
    entranceDelay: 1.7,
    entrancePosition: 'left'
  }
];

const PhoneDisplay: React.FC = () => {
  const [activeCardIndex, setActiveCardIndex] = useState(0);
  const [isAnimating, setIsAnimating] = useState(false);
  const [cardsInPhone, setCardsInPhone] = useState<string[]>([]);
  
  useEffect(() => {
    // Animasi kartu masuk ke iPhone dengan delay yang telah ditentukan
    cards.forEach((card) => {
      setTimeout(() => {
        setCardsInPhone(prev => [...prev, card.id]);
      }, card.entranceDelay * 1000); // Konversi ke milidetik
    });
  }, []);
  
  const changeCard = (direction: 'next' | 'prev') => {
    if (isAnimating) return;
    
    setIsAnimating(true);
    
    // Simpan referensi kartu yang aktif saat ini
    const currentActiveCard = cards[activeCardIndex];
    
    // Update index kartu aktif
    setActiveCardIndex(current => {
      if (direction === 'next') {
        return current === cards.length - 1 ? 0 : current + 1;
      } else {
        return current === 0 ? cards.length - 1 : current - 1;
      }
    });
    
    // Animasi untuk membawa kartu ke depan
    setTimeout(() => {
      // Re-render kartu dan animasi selesai
      setIsAnimating(false);
      
      // Saat ini kita bisa menambahkan kode untuk event tambahan setelah animasi selesai
      console.log(`Kartu aktif sekarang: ${cards[activeCardIndex].title}`);
    }, 500);
  };

  // Mendapatkan transformasi untuk posisi kartu dalam stack
  const getCardTransform = (index: number) => {
    // Mendapatkan posisi relatif untuk kartu saat ini
    const positionIndex = (index - activeCardIndex + cards.length) % cards.length;
    
    // Nilai transformasi yang berbeda untuk mobile dan desktop
    const transformValues = isMobile ? {
      active: 'translateY(0px) scale(1) rotate(0deg)',
      second: 'translateY(12px) scale(0.95) rotate(0.5deg)',
      third: 'translateY(24px) scale(0.9) rotate(1deg)',
      rest: 'translateY(32px) scale(0.85) rotate(1.5deg)'
    } : {
      active: 'translateY(0px) scale(1) rotate(0deg)',
      second: 'translateY(15px) scale(0.95) rotate(1deg)',
      third: 'translateY(30px) scale(0.9) rotate(2deg)',
      rest: 'translateY(45px) scale(0.85) rotate(3deg)'
    };
    
    // Menentukan style berdasarkan posisi
    switch(positionIndex) {
      case 0: // Kartu aktif di depan
        return transformValues.active;
      case 1: // Kartu kedua
        return transformValues.second;
      case 2: // Kartu ketiga
        return transformValues.third;
      default: // Semua kartu lainnya
        return transformValues.rest;
    }
  };
  
  // Mendeteksi tampilan mobile
  const [isMobile, setIsMobile] = useState(false);
  
  useEffect(() => {
    const checkIfMobile = () => {
      setIsMobile(window.innerWidth < 768);
    };
    
    // Check awal
    checkIfMobile();
    
    // Tambahkan event listener untuk resize
    window.addEventListener('resize', checkIfMobile);
    
    // Cleanup
    return () => {
      window.removeEventListener('resize', checkIfMobile);
    };
  }, []);

  return (
    <div className={`relative w-full ${isMobile ? 'max-w-[280px]' : 'max-w-[340px]'} mx-auto`}>
      {/* iPhone frame */}
      <motion.div 
        className="relative z-10 w-full border-[12px] border-black rounded-[48px] overflow-hidden shadow-2xl bg-black"
        initial={{ opacity: 0, y: 30 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ delay: 0.3, duration: 0.8 }}
      >
        {/* Notch */}
        <div className="absolute top-0 left-1/2 transform -translate-x-1/2 w-[40%] h-7 bg-black rounded-b-2xl z-50"></div>
        
        {/* Phone screen */}
        <div className="bg-gray-900 aspect-[9/19.5] w-full rounded-[36px] overflow-hidden relative">
          {/* Background gradient */}
          <div className="absolute inset-0 bg-gradient-to-b from-indigo-900/40 to-black/50"></div>
          <div className="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-blue-800/10 via-transparent to-transparent opacity-40"></div>
          
          {/* Status bar */}
          <div className="absolute top-0 inset-x-0 h-6 px-6 flex justify-between items-center text-white z-40">
            <div className={`${isMobile ? 'text-[10px]' : 'text-xs'}`}>9:41</div>
            <div className={`flex items-center gap-1 ${isMobile ? 'text-[10px]' : 'text-xs'}`}>
              <i className="ri-signal-wifi-line"></i>
              <i className="ri-battery-line"></i>
            </div>
          </div>
          
          {/* App content */}
          <div className="absolute inset-0 flex flex-col pt-14 pb-8 px-5">
            {/* App header */}
            <div className="mb-5">
              <h3 className={`text-white ${isMobile ? 'text-base' : 'text-lg'} font-medium mb-1.5`}>Mileage Card</h3>
              <div className="flex justify-between items-center">
                <div className={`text-blue-400 ${isMobile ? 'text-xs' : 'text-sm'}`}>Kartu Saya</div>
              </div>
            </div>
            
            {/* Card carousel/stack */}
            <div className={`relative ${isMobile ? 'h-44' : 'h-52'} mb-3`}>
              {cards.map((card, index) => {
                const isInPhone = cardsInPhone.includes(card.id);
                const startingPosition = card.entrancePosition === 'left' ? -400 : 400;
                
                return (
                  <AnimatePresence key={card.id}>
                    {isInPhone && (
                      <motion.div
                        className={`absolute w-full ${isMobile ? 'h-36' : 'h-48'} origin-bottom`}
                        initial={{ 
                          opacity: 0, 
                          x: startingPosition, 
                          y: card.entrancePosition === 'left' ? 10 : -10, 
                          scale: 0.6, 
                          rotate: card.entrancePosition === 'left' ? -20 : 20 
                        }}
                        animate={{ 
                          opacity: 1, 
                          x: 0, 
                          y: 0, 
                          scale: index === activeCardIndex ? 1.05 : 1, 
                          rotate: 0,
                          transformOrigin: "center center",
                          transform: getCardTransform(index),
                          zIndex: index === activeCardIndex ? 50 : cards.length - index
                        }}
                        transition={{
                          type: 'spring',
                          stiffness: 100,
                          damping: 15,
                          delay: 0.1
                        }}
                        style={{ zIndex: cards.length - index }}
                      >
                        <CreditCard 
                          type={card.type as 'standard' | 'premium' | 'business'} 
                          isAnimated={!isAnimating}
                          isMobile={isMobile}
                        />
                      </motion.div>
                    )}
                  </AnimatePresence>
                );
              })}
            </div>
            
            {/* Navigation dots */}
            <div className="flex justify-center mb-2">
              {cards.map((_, index) => (
                <motion.div
                  key={index}
                  className={`${isMobile ? 'w-1.5 h-1.5' : 'w-2 h-2'} mx-1 rounded-full ${index === activeCardIndex ? 'bg-blue-500' : 'bg-gray-600'}`}
                  animate={{ scale: index === activeCardIndex ? 1.2 : 1 }}
                />
              ))}
            </div>
            
            {/* Card details */}
            <AnimatePresence mode="wait">
              <motion.div
                key={cards[activeCardIndex].id}
                initial={{ opacity: 0, y: 10 }}
                animate={{ opacity: 1, y: 0 }}
                exit={{ opacity: 0, y: -10 }}
                className={`bg-gray-800/50 backdrop-blur-sm rounded-xl ${isMobile ? 'p-3' : 'p-4'} border border-white/10`}
              >
                <h4 className={`text-white font-medium mb-2 ${isMobile ? 'text-sm' : ''}`}>{cards[activeCardIndex].title}</h4>
                <ul className={`${isMobile ? 'text-[10px]' : 'text-xs'} text-gray-300 space-y-1`}>
                  {cards[activeCardIndex].benefits.map((benefit, idx) => (
                    <li key={idx} className="flex items-center">
                      <div className={`${isMobile ? 'w-0.5 h-0.5' : 'w-1 h-1'} rounded-full bg-blue-400 mr-2`}></div>
                      {benefit}
                    </li>
                  ))}
                </ul>
              </motion.div>
            </AnimatePresence>
          </div>
          
          {/* Navigation buttons */}
          <button
            className={`absolute left-2 top-1/2 -translate-y-1/2 ${isMobile ? 'w-6 h-6' : 'w-8 h-8'} bg-black/30 backdrop-blur-sm rounded-full flex items-center justify-center text-white border border-white/10 z-20`}
            onClick={() => changeCard('prev')}
          >
            <i className={`ri-arrow-left-s-line ${isMobile ? 'text-sm' : ''}`}></i>
          </button>
          
          <button
            className={`absolute right-2 top-1/2 -translate-y-1/2 ${isMobile ? 'w-6 h-6' : 'w-8 h-8'} bg-black/30 backdrop-blur-sm rounded-full flex items-center justify-center text-white border border-white/10 z-20`}
            onClick={() => changeCard('next')}
          >
            <i className={`ri-arrow-right-s-line ${isMobile ? 'text-sm' : ''}`}></i>
          </button>
          
          {/* Bottom indicator */}
          <div className={`absolute bottom-1 left-1/2 transform -translate-x-1/2 ${isMobile ? 'w-1/4' : 'w-1/3'} ${isMobile ? 'h-0.5' : 'h-1'} bg-white/20 rounded-full`}></div>
        </div>
      </motion.div>
      
      {/* Phone shadow */}
      <div className="absolute inset-x-5 bottom-0 h-10 bg-black/20 filter blur-xl rounded-full z-0"></div>
      
      {/* Glow effects behind the phone */}
      <motion.div 
        className={`absolute top-1/4 ${isMobile ? '-right-10 w-32 h-32' : '-right-20 w-40 h-40'} bg-blue-500/20 rounded-full filter blur-3xl`}
        animate={{ opacity: [0.1, 0.2, 0.1], scale: [0.9, 1, 0.9] }}
        transition={{ duration: 4, repeat: Infinity, ease: "easeInOut" }}
      ></motion.div>
      <motion.div 
        className={`absolute bottom-10 ${isMobile ? '-left-10 w-32 h-32' : '-left-20 w-40 h-40'} bg-indigo-500/20 rounded-full filter blur-3xl`}
        animate={{ opacity: [0.1, 0.2, 0.1], scale: [1, 0.9, 1] }}
        transition={{ duration: 4, repeat: Infinity, ease: "easeInOut", delay: 1 }}
      ></motion.div>
    </div>
  );
};

export default PhoneDisplay;