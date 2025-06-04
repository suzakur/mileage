import React from 'react';
import { useIsMobile } from '@/hooks/use-mobile';

const Footer: React.FC = () => {
  const isMobile = useIsMobile();
  return (
    <footer id="footer" className={`${isMobile ? 'py-8' : 'py-12'} px-4 relative overflow-hidden z-10 border-t border-border min-h-[50vh] flex items-center`}>
      <div className="max-w-7xl mx-auto w-full">
        <div className={`grid grid-cols-1 ${isMobile ? 'grid-cols-2 gap-8' : 'md:grid-cols-4 gap-10'}`}>
          <div className={`${isMobile ? 'col-span-2 mb-6' : 'md:col-span-1'}`}>
            <div className={`text-foreground font-display ${isMobile ? 'text-lg' : 'text-xl'} font-bold flex items-center mb-3`}>
              <span className="bg-gradient-to-r from-foreground to-foreground/70 text-transparent bg-clip-text">MILEAGE</span>
            </div>
            <p className={`text-foreground/70 mb-4 ${isMobile ? 'text-xs' : 'text-sm'}`}>Find and compare the best travel reward credit cards with our intuitive platform.</p>
            <div className="flex space-x-4">
              <a href="#" className={`${isMobile ? 'w-7 h-7' : 'w-8 h-8'} border border-border flex items-center justify-center text-foreground/70 hover:bg-background/50 hover:text-foreground transition-all duration-200`}>
                <i className={`ri-github-fill ${isMobile ? 'text-sm' : ''}`}></i>
              </a>
              <a href="#" className={`${isMobile ? 'w-7 h-7' : 'w-8 h-8'} border border-border flex items-center justify-center text-foreground/70 hover:bg-background/50 hover:text-foreground transition-all duration-200`}>
                <i className={`ri-twitter-fill ${isMobile ? 'text-sm' : ''}`}></i>
              </a>
              <a href="#" className={`${isMobile ? 'w-7 h-7' : 'w-8 h-8'} border border-border flex items-center justify-center text-foreground/70 hover:bg-background/50 hover:text-foreground transition-all duration-200`}>
                <i className={`ri-linkedin-fill ${isMobile ? 'text-sm' : ''}`}></i>
              </a>
            </div>
          </div>
          
          <div>
            <h4 className={`font-display text-foreground ${isMobile ? 'text-sm' : 'text-base'} mb-3`}>Navigation</h4>
            <ul className={`${isMobile ? 'space-y-1.5 text-xs' : 'space-y-2 text-sm'}`}>
              <li><button onClick={() => document.getElementById('hero')?.scrollIntoView({behavior: 'smooth'})} className="text-foreground/70 hover:text-blue-400 transition-colors duration-200 text-left">
                Home
              </button></li>
              <li><button onClick={() => document.getElementById('cards')?.scrollIntoView({behavior: 'smooth'})} className="text-foreground/70 hover:text-blue-400 transition-colors duration-200 text-left">
                Cards
              </button></li>
              <li><button onClick={() => document.getElementById('features')?.scrollIntoView({behavior: 'smooth'})} className="text-foreground/70 hover:text-blue-400 transition-colors duration-200 text-left">
                Features
              </button></li>
              <li><button onClick={() => document.getElementById('cta')?.scrollIntoView({behavior: 'smooth'})} className="text-foreground/70 hover:text-blue-400 transition-colors duration-200 text-left">
                Join
              </button></li>
            </ul>
          </div>
          
          <div>
            <h4 className={`font-display text-foreground ${isMobile ? 'text-sm' : 'text-base'} mb-3`}>Legal</h4>
            <ul className={`${isMobile ? 'space-y-1.5 text-xs' : 'space-y-2 text-sm'}`}>
              <li><a href="#" className="text-foreground/70 hover:text-blue-400 transition-colors duration-200">
                Terms & Conditions
              </a></li>
              <li><a href="#" className="text-foreground/70 hover:text-blue-400 transition-colors duration-200">
                Privacy Policy
              </a></li>
              <li><a href="#" className="text-foreground/70 hover:text-blue-400 transition-colors duration-200">
                Cookies
              </a></li>
              <li><a href="#" className="text-foreground/70 hover:text-blue-400 transition-colors duration-200">
                License
              </a></li>
            </ul>
          </div>
          
          <div>
            <h4 className={`font-display text-foreground ${isMobile ? 'text-sm' : 'text-base'} mb-3`}>Contact</h4>
            <ul className={`${isMobile ? 'space-y-1.5 text-xs' : 'space-y-2 text-sm'}`}>
              <li className="flex items-center text-foreground/70">
                <i className={`ri-mail-line ${isMobile ? 'mr-1.5 text-xs' : 'mr-2'} text-blue-400`}></i>
                contact@mileage.com
              </li>
              <li className="flex items-center text-foreground/70">
                <i className={`ri-phone-line ${isMobile ? 'mr-1.5 text-xs' : 'mr-2'} text-blue-400`}></i>
                +1 800-123-4567
              </li>
              <li className="flex items-center text-foreground/70">
                <i className={`ri-map-pin-line ${isMobile ? 'mr-1.5 text-xs' : 'mr-2'} text-blue-400`}></i>
                Mileage Tower, San Francisco
              </li>
            </ul>
          </div>
        </div>
        
        <div className={`border-t border-border ${isMobile ? 'mt-8 pt-4' : 'mt-12 pt-6'} flex flex-col md:flex-row justify-between items-center`}>
          <p className={`text-foreground/50 ${isMobile ? 'text-[10px]' : 'text-xs'} mb-3 md:mb-0`}>
            &copy; {new Date().getFullYear()} Mileage. All rights reserved.
          </p>
          <div className={`flex ${isMobile ? 'space-x-4 text-[10px]' : 'space-x-6 text-xs'}`}>
            <a href="#" className="text-foreground/50 hover:text-blue-400 transition-colors duration-200">Privacy</a>
            <a href="#" className="text-foreground/50 hover:text-blue-400 transition-colors duration-200">Terms</a>
            <a href="#" className="text-foreground/50 hover:text-blue-400 transition-colors duration-200">Cookies</a>
          </div>
        </div>
      </div>
      
      {/* Background decoration */}
      <div className="absolute inset-0 bg-dot-pattern opacity-5 pointer-events-none"></div>
    </footer>
  );
};

export default Footer;
