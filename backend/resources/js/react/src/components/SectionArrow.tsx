import React from 'react';
import { motion } from 'framer-motion';

interface SectionArrowProps {
  targetId: string;
}

const SectionArrow: React.FC<SectionArrowProps> = ({ targetId }) => {
  const scrollToNextSection = () => {
    const targetElement = document.getElementById(targetId);
    if (targetElement) {
      targetElement.scrollIntoView({ behavior: 'smooth' });
    }
  };

  return (
    <motion.div 
      className="section-arrow"
      initial={{ opacity: 0, y: -10 }}
      animate={{ opacity: 1, y: 0 }}
      transition={{ 
        duration: 1,
        delay: 1.2,
        ease: "easeOut" 
      }}
    >
      <motion.button
        className="flex flex-col items-center cursor-pointer"
        onClick={scrollToNextSection}
        whileHover={{ y: -5 }}
        whileTap={{ y: 0 }}
      >
        <motion.div 
          className="w-10 h-10 rounded-full flex items-center justify-center text-white border border-white/10 bg-white/5"
          animate={{ y: [0, 5, 0] }}
          transition={{ repeat: Infinity, duration: 1.5 }}
        >
          <i className="ri-arrow-down-s-line text-xl"></i>
        </motion.div>
      </motion.button>
    </motion.div>
  );
};

export default SectionArrow;