import React from 'react';
import Header from '@/components/Header';
import HeroSection from '@/components/HeroSection';
import FeaturesSection from '@/components/FeaturesSection';
import ApplyCardSection from '@/components/ApplyCardSection';
import PromotionsSection from '@/components/PromotionsSection';
import PricingSection from '@/components/PricingSection';
import BlogSection from '@/components/BlogSection';
import CTASection from '@/components/CTASection';
import Footer from '@/components/Footer';
import MobileMenu from '@/components/MobileMenu';

const Home: React.FC = () => {
  const [isMobileMenuOpen, setIsMobileMenuOpen] = React.useState(false);

  const toggleMobileMenu = () => {
    setIsMobileMenuOpen(!isMobileMenuOpen);
  };

  return (
    <div className="min-h-screen overflow-x-hidden">
      <Header onMobileMenuToggle={toggleMobileMenu} />
      <HeroSection />
      <FeaturesSection />
      <ApplyCardSection />
      <PromotionsSection />
      <PricingSection />
      <BlogSection />
      {/* CTA Section removed as requested */}
      <Footer />
      <MobileMenu isOpen={isMobileMenuOpen} onClose={() => setIsMobileMenuOpen(false)} />
    </div>
  );
};

export default Home;
