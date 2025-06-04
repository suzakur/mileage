import React, { useEffect, useRef } from 'react';
import { motion, useAnimation } from 'framer-motion';

interface CreditCardProps {
  type?: 'standard' | 'premium' | 'business';
  isAnimated?: boolean;
  isMobile?: boolean;
}

const CreditCard: React.FC<CreditCardProps> = ({ 
  type = 'standard',
  isAnimated = true,
  isMobile = false
}) => {
  const controls = useAnimation();
  const cardRef = useRef<HTMLDivElement>(null);

  // Get card details based on type
  const cardDetails = {
    standard: {
      name: 'MILEAGE BASIC',
      number: '4728 •••• •••• 3091',
      holder: 'JOHN D.',
      expires: '04/28',
      variant: 'border-white/20 bg-gradient-to-br from-gray-800 to-black',
      color: 'bg-black'
    },
    premium: {
      name: 'MILEAGE PREMIERE',
      number: '5291 •••• •••• 1337',
      holder: 'JANE S.',
      expires: '09/26',
      variant: 'border-white/20 bg-gradient-to-br from-blue-500/30 to-blue-500/5',
      color: 'bg-blue-500/10'
    },
    business: {
      name: 'MILEAGE BUSINESS',
      number: '3714 •••• •••• 5678',
      holder: 'ACME',
      expires: '11/27',
      variant: 'border-white/20 bg-gradient-to-br from-amber-500/30 to-amber-500/5',
      color: 'bg-amber-500/10'
    }
  };

  const card = cardDetails[type];

  // Parallax effect on mouse move
  useEffect(() => {
    if (!isAnimated) return;

    const handleMouseMove = (e: MouseEvent) => {
      if (!cardRef.current || window.innerWidth <= 768) return;
      
      const rect = cardRef.current.getBoundingClientRect();
      const centerX = rect.left + rect.width / 2;
      const centerY = rect.top + rect.height / 2;
      
      const moveX = (e.clientX - centerX) / 30;
      const moveY = (e.clientY - centerY) / 30;
      
      controls.start({ 
        rotateY: moveX, 
        rotateX: -moveY,
        transition: { duration: 0.2 }
      });
    };
    
    const handleMouseLeave = () => {
      controls.start({ 
        rotateY: 0, 
        rotateX: 0,
        transition: { duration: 0.5 }
      });
    };

    document.addEventListener('mousemove', handleMouseMove);
    document.addEventListener('mouseleave', handleMouseLeave);
    
    return () => {
      document.removeEventListener('mousemove', handleMouseMove);
      document.removeEventListener('mouseleave', handleMouseLeave);
    };
  }, [controls, isAnimated]);

  return (
    <motion.div 
      ref={cardRef}
      className={`w-full h-full ${isMobile ? 'p-4' : 'p-5'} rounded-xl border ${card.variant} ${card.color} backdrop-blur-sm ${isAnimated ? 'animate-float' : ''}`}
      animate={controls}
      style={{ transformStyle: 'preserve-3d' }}
      whileHover={{ 
        y: -5, 
        boxShadow: "0 10px 20px rgba(0, 0, 0, 0.2)" 
      }}
    >
      <div className={`flex justify-between items-start ${isMobile ? 'mb-6' : 'mb-8'}`}>
        <div className={`${isMobile ? 'w-8 h-6' : 'w-10 h-7'} border border-white/30 rounded-md flex items-center justify-center overflow-hidden backdrop-blur-sm`}>
          <div className="w-full h-full p-1">
            <div className="border-t border-b border-white/40 h-full flex items-center justify-center">
              <div className={`${isMobile ? 'w-2 h-2' : 'w-3 h-3'} border border-white/40 rounded-full`}></div>
            </div>
          </div>
        </div>
        <div className={`font-mono ${isMobile ? 'text-[10px]' : 'text-xs'} tracking-wider text-white/80`}>{card.name}</div>
      </div>
      
      <div className={`${isMobile ? 'text-sm' : 'text-base'} font-mono tracking-widest ${isMobile ? 'mb-5' : 'mb-6'} text-white/90`}>
        {card.number}
      </div>
      
      <div className={`flex justify-between items-end ${isMobile ? 'absolute bottom-4 left-4 right-4' : ''}`}>
        <div>
          <div className={`${isMobile ? 'text-[7px]' : 'text-[10px]'} uppercase text-white/50 mb-0.5 font-mono tracking-wider`}>Pemegang Kartu</div>
          <div className={`font-medium text-white/90 ${isMobile ? 'text-[10px]' : 'text-sm'} tracking-wide`}>{card.holder}</div>
        </div>
        <div>
          <div className={`${isMobile ? 'text-[7px]' : 'text-[10px]'} uppercase text-white/50 mb-0.5 font-mono tracking-wider`}>Berlaku Hingga</div>
          <div className={`font-medium text-white/90 ${isMobile ? 'text-[10px]' : 'text-sm'} tracking-wide`}>{card.expires}</div>
        </div>
      </div>
      
      {/* Card aesthetic elements */}
      <div className="absolute top-0 left-0 w-full h-full pointer-events-none overflow-hidden rounded-xl">
        <div className={`absolute ${isMobile ? 'bottom-1.5 right-1.5 text-[7px]' : 'bottom-2 right-2 text-[8px]'} text-white/40 font-mono`}>MILEAGE</div>
        <div className={`absolute ${isMobile ? 'top-1.5 right-1.5' : 'top-2 right-2'}`}>
          <svg className={`${isMobile ? 'w-5 h-5' : 'w-6 h-6'} text-white/60`} viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M6 10C6 7.79086 7.79086 6 10 6H18C20.2091 6 22 7.79086 22 10V14C22 16.2091 20.2091 18 18 18H10C7.79086 18 6 16.2091 6 14V10Z" stroke="currentColor" strokeWidth="1.5" />
            <path d="M2 12L6 12" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" />
          </svg>
        </div>
      </div>
    </motion.div>
  );
};

export default CreditCard;
