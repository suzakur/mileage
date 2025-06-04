import React, { useEffect } from 'react';
import { motion, AnimatePresence } from 'framer-motion';

interface MobileMenuProps {
  isOpen: boolean;
  onClose: () => void;
}

const MobileMenu: React.FC<MobileMenuProps> = ({ isOpen, onClose }) => {
  // Prevent scrolling when mobile menu is open
  useEffect(() => {
    if (isOpen) {
      document.body.style.overflow = 'hidden';
    } else {
      document.body.style.overflow = 'auto';
    }
    
    return () => {
      document.body.style.overflow = 'auto';
    };
  }, [isOpen]);

  const menuVariants = {
    closed: {
      opacity: 0,
      x: "100%",
      transition: {
        type: "spring",
        stiffness: 300,
        damping: 30,
      },
    },
    open: {
      opacity: 1,
      x: 0,
      transition: {
        type: "spring",
        stiffness: 300,
        damping: 30,
      },
    },
  };

  const navItemVariants = {
    closed: { opacity: 0, x: 20 },
    open: (i: number) => ({
      opacity: 1,
      x: 0,
      transition: {
        delay: 0.1 + i * 0.1,
        duration: 0.4,
        ease: [0.25, 0.1, 0.25, 1],
      },
    }),
  };
  
  const scrollToSection = (id: string | undefined) => {
    if (!id) return;
    
    const element = document.getElementById(id);
    if (element) {
      element.scrollIntoView({ behavior: 'smooth' });
      onClose();
    }
  };
  
  // Definisikan tipe untuk item menu
  type MenuItem = {
    text: string;
    id?: string;
    href?: string;
    isSubItem?: boolean;
  };

  const menuItems: MenuItem[] = [
    { text: "Beranda", id: "hero" },
    { text: "Fitur", id: "features" },
    { text: "Paket", id: "pricing" },
    { text: "Ajukan", href: "/ajukan" },
    { text: "Blog", href: "/blog" },
    { text: "Promosi", id: "promotions", isSubItem: true },
    { text: "Tutorial", href: "/tutorial", isSubItem: true },
    { text: "Kontak", id: "footer" },
  ];

  return (
    <AnimatePresence>
      {isOpen && (
        <>
          <motion.div 
            className="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm z-40"
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            exit={{ opacity: 0 }}
            onClick={onClose}
          />
          <motion.div
            className="fixed top-0 right-0 bottom-0 w-full max-w-sm bg-black border-l border-gray-800 z-50 glass"
            initial="closed"
            animate="open"
            exit="closed"
            variants={menuVariants}
          >
            <div className="flex justify-between items-center px-6 py-5 border-b border-gray-800">
              <h2 className="text-white font-display text-xl">Menu</h2>
              <button 
                className="text-2xl text-white p-1 hover:text-gray-300 transition-colors"
                onClick={onClose}
                aria-label="Close menu"
              >
                <i className="ri-close-line"></i>
              </button>
            </div>
            
            <div className="flex flex-col items-start justify-start h-full px-6 py-8">
              <nav className="flex flex-col items-start space-y-6 w-full">
                {menuItems.map((item, i) => {
                  // Jika ini item sub-menu, tampilkan dengan indentasi dan ikon
                  if (item.isSubItem) {
                    return (
                      <motion.button
                        key={item.text}
                        onClick={() => {
                          if (item.href) {
                            window.location.href = item.href;
                          } else if (item.id) {
                            scrollToSection(item.id);
                          }
                        }}
                        className="text-white/80 hover:text-blue-400 transition-all duration-300 
                                  text-lg font-display tracking-tight flex items-center text-left pl-6"
                        custom={i}
                        variants={navItemVariants}
                        initial="closed"
                        animate="open"
                        whileHover={{ x: 5 }}
                      >
                        <i className="ri-arrow-right-s-line mr-1"></i> {item.text}
                      </motion.button>
                    );
                  }
                  
                  // Jika ini item menu utama
                  return (
                    <motion.button
                      key={item.text}
                      onClick={() => {
                        if (item.href) {
                          window.location.href = item.href;
                        } else if (item.id) {
                          scrollToSection(item.id);
                        }
                      }}
                      className="text-white hover:text-blue-400 transition-all duration-300 
                                text-2xl font-display tracking-tight flex items-center text-left"
                      custom={i}
                      variants={navItemVariants}
                      initial="closed"
                      animate="open"
                      whileHover={{ x: 5 }}
                    >
                      {item.text}
                    </motion.button>
                  );
                })}
                
                <motion.button 
                  className="mt-12 w-full py-3 rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600
                           text-white transition-all duration-300 font-medium text-base"
                  custom={menuItems.length}
                  variants={navItemVariants}
                  initial="closed"
                  animate="open"
                  whileHover={{ scale: 1.03 }}
                  onClick={() => {
                    onClose();
                    setTimeout(() => {
                      const loginButton = document.querySelector('header button:has(.ri-user-line)') as HTMLButtonElement;
                      if (loginButton) loginButton.click();
                    }, 300);
                  }}
                >
                  <i className="ri-user-line mr-2"></i> Masuk
                </motion.button>
              </nav>
            </div>
            
            {/* Decorative elements */}
            <motion.div
              className="absolute bottom-8 left-6 right-6 h-px bg-gradient-to-r from-transparent via-white to-transparent opacity-20"
              initial={{ scaleX: 0 }}
              animate={{ scaleX: 1 }}
              transition={{ delay: 0.5, duration: 0.8 }}
            />
          </motion.div>
        </>
      )}
    </AnimatePresence>
  );
};

export default MobileMenu;
