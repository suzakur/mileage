import React, { useState, useRef, useEffect } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import LoginModal from './LoginModal';
import ContactSupportModal from './ContactSupportModal';
import { toggleTheme, isDarkMode as getIsDarkMode } from '@/lib/theme-util';
import { Dialog, DialogContent, DialogTitle } from "@/components/ui/dialog";
import { useIsMobile } from '@/hooks/use-mobile';

interface HeaderProps {
  onMobileMenuToggle: () => void;
}

const Header: React.FC<HeaderProps> = ({ onMobileMenuToggle }) => {
  // State untuk kontrol tema (menggunakan utility functions)
  const [isDarkMode, setIsDarkMode] = useState(getIsDarkMode());
  const [loginModalOpen, setLoginModalOpen] = useState(false);
  const [searchModalOpen, setSearchModalOpen] = useState(false);
  const [isSearchExpanded, setIsSearchExpanded] = useState(false);
  const [searchQuery, setSearchQuery] = useState('');
  const searchInputRef = useRef<HTMLInputElement>(null);
  const [authMode, setAuthMode] = useState<'login' | 'register'>('login');
  const [supportModalOpen, setSupportModalOpen] = useState(false);
  const isMobile = useIsMobile();
  
  const handleToggleDarkMode = () => {
    // Menggunakan helper function untuk toggle tema
    const newMode = toggleTheme();
    // Update state komponen
    setIsDarkMode(newMode);
  };
  
  const scrollToSection = (id: string) => {
    // Jika kita tidak berada di halaman utama, navigasi ke halaman utama terlebih dahulu
    const currentPath = window.location.pathname;
    if (currentPath.includes('/blog') || currentPath.includes('/ajukan') || (currentPath !== '/' && currentPath !== '')) {
      window.location.href = `/#${id}`;
      return;
    }
    
    // Jika kita berada di halaman utama, kita bisa langsung scroll
    const element = document.getElementById(id);
    if (element) {
      element.scrollIntoView({ behavior: 'smooth' });
    }
  };
  
  const openLoginModal = () => {
    setAuthMode('login');
    setLoginModalOpen(true);
  };
  
  const toggleAuthMode = () => {
    setAuthMode(prev => prev === 'login' ? 'register' : 'login');
  };
  
  const toggleSearchExpand = () => {
    setIsSearchExpanded(!isSearchExpanded);
    if (!isSearchExpanded) {
      // Focus the input when expanded
      setTimeout(() => {
        searchInputRef.current?.focus();
      }, 200);
    } else {
      // Clear search when collapsed
      setSearchQuery('');
    }
  };
  
  const handleSearchSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (searchQuery.trim()) {
      setSearchModalOpen(true);
    }
  };
  
  return (
    <header className="w-full py-4 px-6 lg:px-12 flex justify-between items-center fixed top-0 left-0 right-0 z-50 backdrop-blur-md bg-background/80 border-b border-border/30">
      <motion.div 
        className="flex items-center"
        initial={{ opacity: 0, x: -20 }}
        animate={{ opacity: 1, x: 0 }}
        transition={{ duration: 0.5 }}
      >
        <a href="/" className="text-foreground font-display text-lg md:text-2xl font-bold tracking-tight flex items-center">
          <span className="bg-gradient-to-r from-foreground to-foreground/60 text-transparent bg-clip-text">MILEAGE</span>
        </a>
      </motion.div>
      
      <motion.nav 
        className="hidden md:flex items-center space-x-8"
        initial={{ opacity: 0, y: -10 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ duration: 0.5, delay: 0.1 }}
      >
        <button onClick={() => scrollToSection('hero')} className="text-foreground hover:text-foreground/80 transition-all duration-300 font-medium tracking-wide text-sm">Beranda</button>
        <button onClick={() => scrollToSection('features')} className="text-foreground hover:text-foreground/80 transition-all duration-300 font-medium tracking-wide text-sm">Fitur</button>
        <button onClick={() => scrollToSection('pricing')} className="text-foreground hover:text-foreground/80 transition-all duration-300 font-medium tracking-wide text-sm">Paket</button>
        <a href="/ajukan" className="text-foreground hover:text-foreground/80 transition-all duration-300 font-medium tracking-wide text-sm">Ajukan</a>
        <button 
          onClick={() => setSupportModalOpen(true)}
          className="text-foreground hover:text-foreground/80 transition-all duration-300 font-medium tracking-wide text-sm"
        >
          Hubungi Dukungan
        </button>
        
        {/* Dropdown Menu */}
        <div className="relative group">
          <button 
            className="text-foreground hover:text-foreground/80 transition-all duration-300 font-medium tracking-wide text-sm flex items-center"
          >
            Konten <i className="ri-arrow-down-s-line ml-1"></i>
          </button>
          
          <div className="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-background/90 backdrop-blur-sm border border-border/50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 py-2">
            <a
              href="/blog" 
              className="block w-full text-left px-4 py-2 text-sm text-foreground hover:bg-foreground/10 transition-colors"
            >
              Blog
            </a>
            <button 
              onClick={() => scrollToSection('promotions')} 
              className="block w-full text-left px-4 py-2 text-sm text-foreground hover:bg-foreground/10 transition-colors"
            >
              Promosi
            </button>
            <a 
              href="/tutorial" 
              className="block w-full text-left px-4 py-2 text-sm text-foreground hover:bg-foreground/10 transition-colors"
            >
              Tutorial
            </a>
          </div>
        </div>
      </motion.nav>
      
      <motion.div 
        className="flex items-center space-x-4"
        initial={{ opacity: 0, x: 20 }}
        animate={{ opacity: 1, x: 0 }}
        transition={{ duration: 0.5 }}
      >
        <div className="relative flex items-center">
          <AnimatePresence>
            {isSearchExpanded ? (
              <motion.form 
                initial={{ width: 40, opacity: 0.5 }}
                animate={{ width: isMobile ? 160 : 200, opacity: 1 }}
                exit={{ width: 40, opacity: 0 }}
                transition={{ duration: 0.2 }}
                className="flex items-center"
                onSubmit={handleSearchSubmit}
              >
                <input
                  ref={searchInputRef}
                  type="text"
                  placeholder="Cari..."
                  value={searchQuery}
                  onChange={(e) => setSearchQuery(e.target.value)}
                  className={`w-full ${isMobile ? 'px-3 py-1.5 pl-8 text-xs' : 'px-4 py-2 pl-10 text-sm'} bg-foreground/10 backdrop-blur-sm border border-border/50 rounded-full text-foreground focus:outline-none focus:ring-2 focus:ring-blue-500`}
                />
                <motion.button
                  type="button"
                  onClick={toggleSearchExpand}
                  className={`absolute ${isMobile ? 'left-2' : 'left-3'} text-foreground`}
                >
                  <i className={`ri-search-line ${isMobile ? 'text-sm' : ''}`}></i>
                </motion.button>
              </motion.form>
            ) : (
              <motion.button 
                onClick={toggleSearchExpand}
                className={`${isMobile ? 'p-1.5' : 'p-2'} rounded-full bg-foreground/10 backdrop-blur-sm border border-border/50 text-foreground transition-all duration-300 hover:bg-foreground/20 flex items-center justify-center`}
                whileHover={{ scale: 1.05 }}
                whileTap={{ scale: 0.95 }}
                aria-label="Search"
              >
                <i className={`ri-search-line ${isMobile ? 'text-base' : 'text-lg'}`}></i>
              </motion.button>
            )}
          </AnimatePresence>
        </div>
        
        <motion.button 
          onClick={handleToggleDarkMode}
          className={`${isMobile ? 'p-1.5' : 'p-2'} rounded-full bg-foreground/10 backdrop-blur-sm border border-border/50 text-foreground transition-all duration-300 hover:bg-foreground/20 flex items-center justify-center`}
          whileHover={{ scale: 1.05 }}
          whileTap={{ scale: 0.95 }}
          aria-label={isDarkMode ? 'Switch to light mode' : 'Switch to dark mode'}
        >
          <i className={`ri-${isDarkMode ? 'sun' : 'moon'}-line ${isMobile ? 'text-base' : 'text-lg'}`}></i>
        </motion.button>
        
        <button 
          onClick={openLoginModal}
          className="hidden md:flex items-center px-5 py-2 rounded-lg bg-foreground/10 border border-border/50 text-foreground transition-all duration-300 font-medium text-sm hover:bg-foreground/20 hover:-translate-y-0.5"
        >
          <i className="ri-user-line mr-2"></i> Masuk
        </button>
        
        <LoginModal 
          isOpen={loginModalOpen} 
          onClose={() => setLoginModalOpen(false)} 
          mode={authMode} 
          onChangeMode={toggleAuthMode} 
        />
        
        <ContactSupportModal
          isOpen={supportModalOpen}
          onClose={() => setSupportModalOpen(false)}
        />
        
        <button
          className="md:hidden text-2xl text-foreground p-1"
          onClick={onMobileMenuToggle}
          aria-label="Toggle menu"
        >
          <i className="ri-menu-line"></i>
        </button>
      </motion.div>
      
      {/* Search Modal */}
      <Dialog open={searchModalOpen} onOpenChange={setSearchModalOpen}>
        <DialogContent className="bg-background/95 backdrop-blur-md border border-border/50 sm:max-w-md">
          <DialogTitle>Cari Kartu atau Promo</DialogTitle>
          <div className="space-y-4">
            <div className="relative">
              <input
                type="text"
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
                placeholder="Masukkan kata kunci pencarian..."
                className="w-full px-4 py-3 pl-10 bg-background/50 border border-border/50 rounded-lg text-foreground focus:outline-none focus:ring-2 focus:ring-blue-500"
              />
              <i className="ri-search-line absolute left-3 top-3.5 text-foreground/50"></i>
            </div>
            
            <div className="space-y-2">
              <h4 className="text-sm font-medium text-foreground/70">Pencarian Populer</h4>
              <div className="flex flex-wrap gap-2">
                <button className="px-3 py-1 bg-foreground/10 hover:bg-foreground/20 rounded-full text-sm text-foreground/80">Kartu Cashback</button>
                <button className="px-3 py-1 bg-foreground/10 hover:bg-foreground/20 rounded-full text-sm text-foreground/80">Kartu Miles</button>
                <button className="px-3 py-1 bg-foreground/10 hover:bg-foreground/20 rounded-full text-sm text-foreground/80">Promo Liburan</button>
                <button className="px-3 py-1 bg-foreground/10 hover:bg-foreground/20 rounded-full text-sm text-foreground/80">Biaya Tahunan 0</button>
              </div>
            </div>
          </div>
        </DialogContent>
      </Dialog>
    </header>
  );
};

export default Header;
