import React, { useState } from 'react';
import { motion } from 'framer-motion';

// Define card images - in a real implementation, these would be actual PNG files
// For now we'll create placeholder cards with different styling
const cardImages = [
  {
    id: 'card1',
    name: 'PREMIUM',
    cardNumber: '4728 •••• •••• 5631',
    holder: 'JOHN SMITH',
    expires: '09/26',
    gradient: 'from-blue-600 to-indigo-600',
    position: { x: 0, y: 0, z: 0, rotate: 0 }
  },
  {
    id: 'card2',
    name: 'GOLD',
    cardNumber: '5412 •••• •••• 7890',
    holder: 'EMMA WILSON',
    expires: '11/27',
    gradient: 'from-amber-400 to-yellow-500',
    position: { x: -20, y: 20, z: -10, rotate: -4 }
  },
  {
    id: 'card3',
    name: 'TITANIUM',
    cardNumber: '3714 •••• •••• 1234',
    holder: 'ALEX PARKER',
    expires: '03/25',
    gradient: 'from-gray-400 to-slate-600',
    position: { x: -40, y: 40, z: -20, rotate: -8 }
  },
  {
    id: 'card4',
    name: 'BLACK',
    cardNumber: '6011 •••• •••• 4567',
    holder: 'MAYA JOHNSON',
    expires: '07/28',
    gradient: 'from-gray-800 to-gray-900',
    position: { x: -60, y: 60, z: -30, rotate: -12 }
  }
];

const CardStack: React.FC = () => {
  // Track which card is being hovered
  const [activeIndex, setActiveIndex] = useState<number | null>(null);

  return (
    <div id="cards" className="relative w-full perspective-1000 mt-12 mb-16 mx-auto max-w-xl">
      {/* Main container with 3D effect */}
      <div className="relative w-full aspect-[16/9] transform-style preserve-3d">
        {cardImages.map((card, index) => {
          // Calculate base position and transformations
          const { x, y, z, rotate } = card.position;
          const isActive = activeIndex === index;
          
          // Adjust position when hovered/active
          const hoverX = isActive ? 0 : x;
          const hoverY = isActive ? 0 : y;
          const hoverZ = isActive ? 50 : z;
          const hoverRotate = isActive ? 0 : rotate;
          
          return (
            <motion.div
              key={card.id}
              className={`absolute w-full aspect-[16/9] modern-card p-6 bg-gradient-to-br ${card.gradient}`}
              style={{
                zIndex: isActive ? 10 : 4 - index,
                transformStyle: 'preserve-3d'
              }}
              initial={{
                x: x,
                y: y,
                rotate: rotate,
                z: z
              }}
              animate={{
                x: hoverX,
                y: hoverY,
                rotate: hoverRotate,
                z: hoverZ,
                scale: isActive ? 1.05 : 1
              }}
              transition={{
                type: "spring",
                stiffness: 300,
                damping: 20,
              }}
              onHoverStart={() => setActiveIndex(index)}
              onHoverEnd={() => setActiveIndex(null)}
              onTap={() => {
                if (activeIndex === index) {
                  setActiveIndex(null);
                } else {
                  setActiveIndex(index);
                }
              }}
              whileHover={{
                boxShadow: "0 25px 50px rgba(0,0,0,0.3), 0 0 0 1px rgba(255,255,255,0.2)"
              }}
            >
              {/* Overlay pattern - using a subtle gradient instead of console/code pattern */}
              <div className="absolute inset-0 overflow-hidden opacity-20 rounded-2xl">
                <div className="w-full h-full bg-gradient-to-br from-white/10 to-transparent"></div>
              </div>
              
              {/* Card content */}
              <div className="h-full w-full flex flex-col justify-between relative z-10">
                <div className="flex justify-between items-start">
                  <div className="card-chip w-10 h-8 rounded"></div>
                  <div className="text-white font-display text-sm tracking-wider">MILEAGE</div>
                </div>
                
                <div className="text-base font-display tracking-widest text-white mt-2 font-medium">
                  {card.cardNumber}
                </div>
                
                <div className="flex justify-between items-end">
                  <div>
                    <div className="text-[10px] text-white opacity-80 mb-1 uppercase tracking-wider">Cardholder</div>
                    <div className="text-white text-sm font-medium">{card.holder}</div>
                  </div>
                  <div>
                    <div className="text-[10px] text-white opacity-80 mb-1 uppercase tracking-wider">Expires</div>
                    <div className="text-white text-sm font-medium">{card.expires}</div>
                  </div>
                </div>
                
                <div className="absolute top-6 right-6 text-white font-display text-xs tracking-widest font-bold bg-white/10 px-2 py-1 rounded-full backdrop-blur-sm">
                  {card.name}
                </div>
              </div>
            </motion.div>
          );
        })}
        
        {/* Add a reflection effect for the active card */}
        {activeIndex !== null && (
          <motion.div
            className="absolute inset-0 bg-gradient-to-b from-white/5 to-transparent rounded-2xl"
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            exit={{ opacity: 0 }}
            transition={{ duration: 0.3 }}
            style={{
              zIndex: 15,
              clipPath: 'polygon(0 0, 100% 0, 100% 30%, 0 30%)',
              pointerEvents: 'none'
            }}
          />
        )}
      </div>
    </div>
  );
};

export default CardStack;