import React from 'react';
import { motion } from 'framer-motion';
import SectionArrow from './SectionArrow';

const CTASection: React.FC = () => {
  return (
    <section id="cta" className="relative min-h-screen py-24 px-4 border-t border-border flex items-center">
      <div className="absolute inset-0 bg-gradient-to-b from-transparent to-background/10 pointer-events-none"></div>
      <div className="absolute inset-0 bg-dot-pattern opacity-10 pointer-events-none"></div>
      
      <motion.div 
        className="max-w-5xl mx-auto relative z-10"
        initial={{ opacity: 0 }}
        animate={{ opacity: 1 }}
        transition={{ duration: 0.7 }}
      >
        <div className="flex flex-col lg:flex-row items-center justify-between gap-12">
          <motion.div 
            className="max-w-xl"
            initial={{ opacity: 0, x: -20 }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.5, delay: 0.2 }}
          >
            <motion.div 
              className="inline-block mb-3 px-4 py-1 rounded-full bg-background/30 backdrop-blur-sm border border-border/50"
              initial={{ opacity: 0, scale: 0.8 }}
              animate={{ opacity: 1, scale: 1 }}
              transition={{ duration: 0.4, delay: 0.3 }}
            >
              <span className="text-blue-400 text-sm font-medium">Mulai Hari Ini</span>
            </motion.div>
            
            <h2 className="font-display text-3xl md:text-4xl lg:text-5xl font-bold mb-6 tracking-tight">
              <span className="bg-clip-text text-transparent bg-gradient-to-r from-foreground to-foreground/70">
                Maksimalkan Reward Perjalanan Anda
              </span>
            </h2>
            
            <p className="text-foreground/80 text-lg mb-8">
              Temukan cara terbaik untuk memanfaatkan kartu kredit Anda dan dapatkan pengalaman perjalanan yang lebih baik sekarang.
            </p>
            
            <div className="flex flex-col sm:flex-row items-center gap-4">
              <motion.button 
                className="w-full sm:w-auto px-8 py-4 rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 
                         text-white font-display font-bold text-lg flex items-center justify-center gap-2
                         hover:shadow-lg hover:shadow-blue-600/20 transition-all duration-300"
                whileHover={{ scale: 1.03 }}
                whileTap={{ scale: 0.98 }}
              >
                <i className="ri-flight-takeoff-line mr-1"></i>
                Get Started
              </motion.button>
              
              <motion.button 
                className="w-full sm:w-auto px-8 py-4 rounded-lg bg-background/30 backdrop-blur-sm border border-border/50
                         text-foreground font-display flex items-center justify-center gap-2
                         hover:bg-background/50 transition-all duration-300"
                whileHover={{ scale: 1.03 }}
                whileTap={{ scale: 0.98 }}
              >
                <i className="ri-play-circle-line mr-1"></i>
                Watch Demo
              </motion.button>
            </div>
          </motion.div>
          
          <motion.div
            className="relative"
            initial={{ opacity: 0, scale: 0.9, y: 20 }}
            animate={{ opacity: 1, scale: 1, y: 0 }}
            transition={{ duration: 0.6, delay: 0.4 }}
          >
            <div className="absolute -inset-4 rounded-xl bg-gradient-to-r from-blue-600/10 to-purple-600/10 blur-xl"></div>
            <div className="relative bg-background/40 backdrop-blur-sm p-6 rounded-xl border border-border/50">
              <div className="flex items-center justify-between mb-6">
                <div className="bg-gradient-to-r from-blue-500 to-indigo-500 w-12 h-12 rounded-full flex items-center justify-center">
                  <i className="ri-shield-star-line text-white text-xl"></i>
                </div>
                <div className="flex space-x-2">
                  <div className="w-2 h-2 rounded-full bg-foreground/40"></div>
                  <div className="w-2 h-2 rounded-full bg-foreground/40"></div>
                  <div className="w-2 h-2 rounded-full bg-blue-400"></div>
                </div>
              </div>
              
              <h3 className="font-display text-foreground text-xl font-bold mb-4">Join Premium Membership</h3>
              
              <div className="space-y-4 mb-6">
                <div className="flex items-center">
                  <i className="ri-check-line text-blue-400 mr-3"></i>
                  <span className="text-foreground/80">Exclusive card offers</span>
                </div>
                <div className="flex items-center">
                  <i className="ri-check-line text-blue-400 mr-3"></i>
                  <span className="text-foreground/80">Advanced reward calculators</span>
                </div>
                <div className="flex items-center">
                  <i className="ri-check-line text-blue-400 mr-3"></i>
                  <span className="text-foreground/80">Personalized travel recommendations</span>
                </div>
              </div>
              
              <button className="w-full py-3 rounded-lg bg-gradient-to-r from-blue-500 to-indigo-500
                              text-white font-display font-medium flex items-center justify-center">
                Sign Up Now
              </button>
            </div>
          </motion.div>
        </div>
        
        {/* Section navigation arrow removed per user request */}
      </motion.div>
    </section>
  );
};

export default CTASection;
