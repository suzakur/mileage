import React, { useState, useEffect, useRef } from 'react';
import { motion, PanInfo, useAnimation, useMotionValue, useTransform } from 'framer-motion';
import CreditCard from './CreditCard';

interface CreditCardData {
  id: string;
  name: string;
  issuer: string;
  cardNumber: string;
  validThru: string;
  points: number;
  expiringPoints?: {
    points: number;
    expiryDate: string;
  }[];
  availableCredit: number;
  totalCredit: number;
  dueDate: string;
  dueAmount: number;
  color: string;
  gradient: string;
  type?: 'standard' | 'premium' | 'business';
}

interface CreditCardCarouselProps {
  cards: CreditCardData[];
  showCardInfo?: boolean;
  onCardChange?: (card: CreditCardData) => void;
  initialCardIndex?: number;
}

const CreditCardCarousel: React.FC<CreditCardCarouselProps> = ({
  cards,
  showCardInfo = true,
  onCardChange,
  initialCardIndex = 0
}) => {
  const [currentIndex, setCurrentIndex] = useState(initialCardIndex);
  const [dragging, setDragging] = useState(false);
  const carouselRef = useRef<HTMLDivElement>(null);
  const controls = useAnimation();
  
  // Motion values for drag interaction
  const x = useMotionValue(0);
  const cardWidth = useMotionValue(0);
  const cardGap = 20;
  
  // Update card width based on container size
  useEffect(() => {
    const updateWidth = () => {
      if (carouselRef.current) {
        const newWidth = Math.min(carouselRef.current.offsetWidth * 0.85, 400);
        cardWidth.set(newWidth);
      }
    };
    
    updateWidth();
    window.addEventListener('resize', updateWidth);
    return () => window.removeEventListener('resize', updateWidth);
  }, [cardWidth]);
  
  // Rotate based on drag position
  const rotate = useTransform(
    x,
    [-300, 0, 300], 
    [5, 0, -5]
  );
  
  // Calculate visible cards and their positions
  const calculateCardPosition = (index: number) => {
    const distance = index - currentIndex;
    const width = cardWidth.get() + cardGap;
    
    if (Math.abs(distance) <= 2) {
      return {
        x: distance * width,
        scale: 1 - Math.abs(distance) * 0.1,
        zIndex: 10 - Math.abs(distance)
      };
    }
    
    return {
      x: (distance < 0 ? -2 : 2) * width,
      scale: 0.8,
      zIndex: 0
    };
  };
  
  // Handle drag end
  const handleDragEnd = (event: MouseEvent | TouchEvent | PointerEvent, info: PanInfo) => {
    setDragging(false);
    
    const width = cardWidth.get() + cardGap;
    const dragThreshold = width * 0.4;
    const velocity = info.velocity.x;
    const dragDistance = info.offset.x;
    
    // Change card based on drag distance and velocity
    if (
      (dragDistance < -dragThreshold || velocity < -500) && 
      currentIndex < cards.length - 1
    ) {
      nextCard();
    } else if (
      (dragDistance > dragThreshold || velocity > 500) && 
      currentIndex > 0
    ) {
      prevCard();
    } else {
      // Snap back to current card
      controls.start({ x: 0, transition: { type: 'spring', stiffness: 300, damping: 30 } });
    }
  };
  
  // Navigate to previous card
  const prevCard = () => {
    if (currentIndex > 0) {
      setCurrentIndex(currentIndex - 1);
      if (onCardChange) onCardChange(cards[currentIndex - 1]);
    }
  };
  
  // Navigate to next card
  const nextCard = () => {
    if (currentIndex < cards.length - 1) {
      setCurrentIndex(currentIndex + 1);
      if (onCardChange) onCardChange(cards[currentIndex + 1]);
    }
  };
  
  // Reset animation when currentIndex changes
  useEffect(() => {
    x.set(0);
    controls.set({ x: 0 });
  }, [currentIndex, controls, x]);
  
  return (
    <div className="relative w-full overflow-hidden" ref={carouselRef}>
      {/* Card carousel */}
      <div className="relative px-4 py-6 flex justify-center items-center min-h-[280px]">
        {cards.map((card, index) => {
          const { x: cardX, scale, zIndex } = calculateCardPosition(index);
          
          return (
            <motion.div
              key={card.id}
              className="absolute"
              style={{
                zIndex,
                filter: index !== currentIndex ? 'brightness(0.9)' : 'none',
                width: cardWidth
              }}
              initial={false}
              animate={{
                x: dragging ? undefined : cardX,
                scale,
                transition: { type: 'spring', stiffness: 300, damping: 30 }
              }}
            >
              {index === currentIndex ? (
                <motion.div
                  drag="x"
                  dragConstraints={{ left: -100, right: 100 }}
                  dragElastic={0.1}
                  dragTransition={{ bounceStiffness: 600, bounceDamping: 30 }}
                  onDragStart={() => setDragging(true)}
                  onDragEnd={handleDragEnd}
                  animate={controls}
                  style={{ x, rotate }}
                >
                  <CreditCard 
                    type={card.type || 'standard'} 
                    isAnimated 
                  />
                </motion.div>
              ) : (
                <div>
                  <CreditCard 
                    type={card.type || 'standard'} 
                    isAnimated={false} 
                  />
                </div>
              )}
            </motion.div>
          );
        })}
      </div>
      
      {/* Navigation dots */}
      <div className="flex justify-center mt-2 space-x-2">
        {cards.map((_, index) => (
          <button
            key={index}
            className={`w-2.5 h-2.5 rounded-full transition-all ${
              index === currentIndex
                ? 'bg-blue-600 w-4'
                : 'bg-gray-300 dark:bg-gray-600'
            }`}
            onClick={() => {
              setCurrentIndex(index);
              if (onCardChange) onCardChange(cards[index]);
            }}
            aria-label={`Go to card ${index + 1}`}
          />
        ))}
      </div>
      
      {/* Navigation arrows */}
      <div className="absolute inset-x-0 top-1/2 -mt-6 flex justify-between items-center pointer-events-none px-4">
        <button
          className={`w-10 h-10 rounded-full bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm flex items-center justify-center shadow-lg pointer-events-auto transition-opacity ${
            currentIndex === 0 ? 'opacity-40 cursor-not-allowed' : 'opacity-80 hover:opacity-100'
          }`}
          onClick={prevCard}
          disabled={currentIndex === 0}
          aria-label="Previous card"
        >
          <i className="ri-arrow-left-s-line text-lg"></i>
        </button>
        <button
          className={`w-10 h-10 rounded-full bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm flex items-center justify-center shadow-lg pointer-events-auto transition-opacity ${
            currentIndex === cards.length - 1 ? 'opacity-40 cursor-not-allowed' : 'opacity-80 hover:opacity-100'
          }`}
          onClick={nextCard}
          disabled={currentIndex === cards.length - 1}
          aria-label="Next card"
        >
          <i className="ri-arrow-right-s-line text-lg"></i>
        </button>
      </div>
      
      {/* Card info */}
      {showCardInfo && (
        <motion.div 
          className="mt-4 text-center"
          initial={{ opacity: 0, y: 10 }}
          animate={{ opacity: 1, y: 0 }}
          key={cards[currentIndex].id}
          transition={{ type: 'spring', stiffness: 300, damping: 30 }}
        >
          <h3 className="text-lg font-semibold">{cards[currentIndex].name}</h3>
          <p className="text-sm text-foreground/70">
            {cards[currentIndex].issuer} • {cards[currentIndex].cardNumber.slice(-4)}
          </p>
          
          <div className="mt-4 grid grid-cols-2 gap-4 max-w-md mx-auto">
            <div className="bg-foreground/5 p-3 rounded-lg">
              <div className="text-sm text-foreground/70">Saldo Tersedia</div>
              <div className="text-lg font-semibold">
                Rp {cards[currentIndex].availableCredit.toLocaleString()}
              </div>
            </div>
            <div className="bg-foreground/5 p-3 rounded-lg">
              <div className="text-sm text-foreground/70">Poin</div>
              <div className="text-lg font-semibold">
                {cards[currentIndex].points.toLocaleString()}
              </div>
            </div>
          </div>
          
          <div className="mt-4 flex justify-center space-x-2">
            <button className="px-4 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-colors">
              <i className="ri-bank-card-line mr-1.5"></i>
              <span>Lihat Detail</span>
            </button>
            <button className="px-4 py-2 border border-blue-600 text-blue-600 rounded-full hover:bg-blue-50 dark:hover:bg-blue-950/30 transition-colors">
              <i className="ri-exchange-line mr-1.5"></i>
              <span>Bayar Tagihan</span>
            </button>
          </div>
        </motion.div>
      )}
      
      {/* Swipe instruction */}
      <div className="text-center text-foreground/60 text-sm mt-4 flex items-center justify-center">
        <i className="ri-drag-move-line mr-1.5"></i>
        <span>Geser untuk melihat kartu lainnya</span>
      </div>
    </div>
  );
};

export default CreditCardCarousel;