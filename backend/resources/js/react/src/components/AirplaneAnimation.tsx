import React, { useEffect, useRef } from 'react';
import { motion } from 'framer-motion';

interface AirplaneAnimationProps {
  size?: 'small' | 'medium' | 'large';
  color?: string;
  position?: 'top-left' | 'top-right' | 'bottom-left' | 'bottom-right' | 'center';
}

const AirplaneAnimation: React.FC<AirplaneAnimationProps> = ({
  size = 'medium',
  color = 'text-blue-400',
  position = 'top-right'
}) => {
  const containerRef = useRef<HTMLDivElement>(null);
  
  // Ukuran pesawat berdasarkan prop size
  const getSize = () => {
    switch (size) {
      case 'small': return 'w-12 h-12';
      case 'large': return 'w-24 h-24';
      default: return 'w-16 h-16';
    }
  };
  
  // Posisi kontainer pesawat berdasarkan prop position
  const getPosition = () => {
    switch (position) {
      case 'top-left': return 'top-10 left-10';
      case 'top-right': return 'top-10 right-10';
      case 'bottom-left': return 'bottom-10 left-10';
      case 'bottom-right': return 'bottom-10 right-10';
      case 'center': return 'top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2';
      default: return 'top-10 right-10';
    }
  };
  
  // Jalur animasi pesawat berdasarkan posisi
  const getInitialPosition = () => {
    switch (position) {
      case 'top-left': return { x: -100, y: -100, opacity: 0, rotate: 45 };
      case 'top-right': return { x: 100, y: -100, opacity: 0, rotate: -45 };
      case 'bottom-left': return { x: -100, y: 100, opacity: 0, rotate: 135 };
      case 'bottom-right': return { x: 100, y: 100, opacity: 0, rotate: -135 };
      case 'center': return { scale: 0, opacity: 0, rotateY: 0 };
      default: return { x: 100, y: -100, opacity: 0, rotate: -45 };
    }
  };
  
  const getFlightPath = () => {
    const baseDelay = 2;
    const transitionProps = { 
      duration: 8, 
      times: [0, 0.2, 0.8, 1],
      repeat: Infinity,
      repeatDelay: baseDelay
    };
    
    switch (position) {
      case 'top-left':
        return {
          hidden: { x: -100, y: -100, opacity: 0, rotate: 45 },
          visible: { 
            x: [0, 20, 50, 100], 
            y: [0, 30, 80, 100], 
            opacity: [0, 1, 1, 0],
            rotate: [45, 30, 20, 10],
            transition: transitionProps
          }
        };
      case 'top-right':
        return {
          hidden: { x: 100, y: -100, opacity: 0, rotate: -45 },
          visible: { 
            x: [0, -20, -50, -100], 
            y: [0, 30, 80, 100], 
            opacity: [0, 1, 1, 0],
            rotate: [-45, -30, -20, -10],
            transition: transitionProps
          }
        };
      case 'bottom-left':
        return {
          hidden: { x: -100, y: 100, opacity: 0, rotate: 135 },
          visible: { 
            x: [0, 20, 50, 100], 
            y: [0, -30, -80, -100], 
            opacity: [0, 1, 1, 0],
            rotate: [135, 150, 160, 170],
            transition: transitionProps
          }
        };
      case 'bottom-right':
        return {
          hidden: { x: 100, y: 100, opacity: 0, rotate: -135 },
          visible: { 
            x: [0, -20, -50, -100], 
            y: [0, -30, -80, -100], 
            opacity: [0, 1, 1, 0],
            rotate: [-135, -150, -160, -170],
            transition: transitionProps
          }
        };
      case 'center':
        return {
          hidden: { scale: 0, opacity: 0, rotateY: 0 },
          visible: { 
            scale: [0, 1, 1, 0], 
            opacity: [0, 1, 1, 0],
            rotateY: [0, 180, 360, 540],
            transition: { 
              ...transitionProps,
              duration: 10
            }
          }
        };
      default:
        return {
          hidden: { x: 100, y: -100, opacity: 0, rotate: -45 },
          visible: { 
            x: [0, -20, -50, -100], 
            y: [0, 30, 80, 100], 
            opacity: [0, 1, 1, 0],
            rotate: [-45, -30, -20, -10],
            transition: transitionProps
          }
        };
    }
  };
  
  // Efek pergerakan bayangan
  const getShadowAnimation = () => {
    return {
      hidden: { opacity: 0, scale: 0.8 },
      visible: { 
        opacity: [0, 0.2, 0.2, 0],
        scale: [0.8, 1, 1, 0.8],
        transition: { 
          duration: 8, 
          times: [0, 0.2, 0.8, 1],
          repeat: Infinity,
          repeatDelay: 2
        }
      }
    };
  };

  // Memulai animasi setelah komponen dimount
  useEffect(() => {
    if (containerRef.current) {
      // Menambahkan kelas untuk perspektif 3D
      containerRef.current.style.perspective = '1000px';
    }
  }, []);

  const flightPath = getFlightPath();
  const shadowAnimation = getShadowAnimation();
  
  return (
    <div
      ref={containerRef}
      className={`absolute ${getPosition()} ${getSize()} pointer-events-none overflow-visible z-10`}
      style={{ transformStyle: 'preserve-3d' }}
    >
      {/* Pesawat */}
      <motion.div
        className={`relative ${color}`}
        initial={{ opacity: 0 }}
        animate={{ 
          opacity: 1,
          x: position.includes('right') 
            ? [-50, 0, 50, -50] 
            : position === 'center' 
              ? [30, -30, 30, -30] 
              : [50, 0, -50, 50],
          y: position.includes('top') 
            ? [0, 20, 40, 0] 
            : position === 'center' 
              ? [0, 20, 0, -20] 
              : [0, -20, -40, 0],
          rotate: position.includes('right') 
            ? [-20, 0, 20, -20] 
            : position === 'center' 
              ? [0, 15, 0, -15] 
              : [20, 0, -20, 20],
          scale: position === 'center' ? [0.9, 1.1, 0.9, 1.1] : [1, 1, 1, 1]
        }}
        transition={{
          duration: 15,
          repeat: Infinity,
          ease: "linear"
        }}
        style={{ transformStyle: 'preserve-3d' }}
      >
        {/* 3D Airplane using CSS */}
        <div className="relative w-full h-full" style={{ transformStyle: 'preserve-3d' }}>
          {/* Badan Pesawat */}
          <div 
            className="absolute inset-0 bg-current rounded-full" 
            style={{ 
              transform: 'translateZ(2px) scale(0.4, 1)',
              opacity: 0.9
            }}
          ></div>
          
          {/* Sayap */}
          <div 
            className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-current rounded-full" 
            style={{ 
              width: '140%', 
              height: '30%', 
              transform: 'translateZ(1px) rotateZ(90deg)', 
              opacity: 0.8
            }}
          ></div>
          
          {/* Ekor */}
          <div 
            className="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/4 bg-current rounded-sm" 
            style={{ 
              width: '30%', 
              height: '40%', 
              transform: 'translateZ(0px) rotateZ(0deg)', 
              opacity: 0.7
            }}
          ></div>
          
          {/* Jendela-jendela */}
          <div 
            className="absolute top-1/3 left-1/3 w-[10%] h-[10%] rounded-full bg-white" 
            style={{ 
              transform: 'translateZ(3px)', 
              boxShadow: '0 0 5px rgba(255,255,255,0.5)'
            }}
          ></div>
          <div 
            className="absolute top-1/3 left-1/2 w-[10%] h-[10%] rounded-full bg-white" 
            style={{ 
              transform: 'translateZ(3px)', 
              boxShadow: '0 0 5px rgba(255,255,255,0.5)'
            }}
          ></div>
          <div 
            className="absolute top-1/3 left-2/3 w-[10%] h-[10%] rounded-full bg-white" 
            style={{ 
              transform: 'translateZ(3px)', 
              boxShadow: '0 0 5px rgba(255,255,255,0.5)'
            }}
          ></div>
        </div>
        
        {/* Efek jalur */}
        <motion.div
          className="absolute right-full top-1/2 h-[2px] bg-gradient-to-r from-transparent to-current rounded-full opacity-30"
          style={{ width: '150%', transformOrigin: 'right center' }}
          animate={{
            scaleX: [0, 1, 0],
            opacity: [0, 0.3, 0]
          }}
          transition={{
            duration: 2,
            repeat: Infinity,
            repeatDelay: 1
          }}
        />
      </motion.div>
      
      {/* Bayangan */}
      <motion.div
        className="absolute bottom-0 left-1/2 -translate-x-1/2 w-full h-[5%] bg-current rounded-full blur-sm opacity-20"
        style={{ transformOrigin: 'center bottom' }}
        initial="hidden"
        animate="visible"
        variants={shadowAnimation}
      />
    </div>
  );
};

export default AirplaneAnimation;