import React, { useRef, useState, useEffect } from 'react';
import { motion } from 'framer-motion';
import SectionArrow from './SectionArrow';
import { 
  Carousel,
  CarouselContent,
  CarouselItem,
  CarouselNext,
  CarouselPrevious 
} from '@/components/ui/carousel';

// Definisikan beberapa contoh kartu kredit Indonesia
const indonesianCards = [
  {
    id: 'bca',
    name: 'VISA Platinum',
    issuer: 'BCA',
    number: '4000 •••• •••• 1234',
    validThru: '06/28',
    holderName: 'BUDI SANTOSO',
    features: ['3x Reward Point', 'Akses Airport Lounge', 'Gratis Antar Jemput ke Bandara', 'Perlindungan Transaksi Online'],
    bgColor: 'bg-blue-900',
    gradientColor: 'from-blue-700/80 to-blue-900',
    logo: 'https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg',
    logoPosition: 'top-right',
    chip: true
  },
  {
    id: 'mandiri',
    name: 'Signature',
    issuer: 'Mandiri',
    number: '5200 •••• •••• 7890',
    validThru: '09/27',
    holderName: 'SITI AMINAH',
    features: ['Miles Reward', 'Free Travel Insurance', 'Diskon Dining', 'Concierge Service 24/7'],
    bgColor: 'bg-yellow-900',
    gradientColor: 'from-yellow-700/80 to-yellow-900',
    logo: 'https://upload.wikimedia.org/wikipedia/commons/a/a0/Mastercard_Logo.svg',
    logoPosition: 'bottom-right',
    chip: true
  },
  {
    id: 'bni',
    name: 'JCB Black',
    issuer: 'BNI',
    number: '3528 •••• •••• 4567',
    validThru: '12/28',
    holderName: 'AHMAD FAJAR',
    features: ['Shopping Benefits', 'Bonus Point', 'Cicilan 0%', 'Diskon Merchant Premium'],
    bgColor: 'bg-gray-900',
    gradientColor: 'from-gray-800 to-black',
    logo: 'https://upload.wikimedia.org/wikipedia/commons/4/40/JCB_logo.svg',
    logoPosition: 'bottom-right',
    chip: true
  },
  {
    id: 'cimb',
    name: 'World',
    issuer: 'CIMB',
    number: '4500 •••• •••• 9876',
    validThru: '03/28',
    holderName: 'DEWI SUSANTI',
    features: ['Cashback 5%', 'Reward Points', 'Fitur Travel', 'Asuransi Perjalanan'],
    bgColor: 'bg-red-900',
    gradientColor: 'from-red-700/80 to-red-900',
    logo: 'https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg',
    logoPosition: 'bottom-right',
    chip: true
  },
  {
    id: 'bri',
    name: 'Infinite',
    issuer: 'BRI',
    number: '4123 •••• •••• 5678',
    validThru: '05/27',
    holderName: 'JOKO WIDODO',
    features: ['Priority Banking', 'Executive Lounge', 'Travel Benefits', 'Concierge Service'],
    bgColor: 'bg-indigo-900',
    gradientColor: 'from-indigo-700/80 to-indigo-900',
    logo: 'https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg',
    logoPosition: 'bottom-right',
    chip: true
  },
  {
    id: 'danamon',
    name: 'Prestige',
    issuer: 'Danamon',
    number: '5412 •••• •••• 2468',
    validThru: '11/26',
    holderName: 'RATNA DEWI',
    features: ['Smart Spending', 'Reward Point 2x', 'Asuransi Kecelakaan', 'Diskon Merchant'],
    bgColor: 'bg-green-900',
    gradientColor: 'from-green-700/80 to-green-900',
    logo: 'https://upload.wikimedia.org/wikipedia/commons/a/a0/Mastercard_Logo.svg',
    logoPosition: 'bottom-right',
    chip: true
  },
  {
    id: 'maybank',
    name: 'World Elite',
    issuer: 'Maybank',
    number: '5501 •••• •••• 3579',
    validThru: '08/27',
    holderName: 'HENDRA WIJAYA',
    features: ['Lounge Access', 'Cashback Groceries', 'Golf Privileges', 'Asuransi Perjalanan'],
    bgColor: 'bg-black',
    gradientColor: 'from-gray-800 to-black',
    logo: 'https://upload.wikimedia.org/wikipedia/commons/a/a0/Mastercard_Logo.svg',
    logoPosition: 'bottom-right',
    chip: true
  },
  {
    id: 'ocbc',
    name: 'Titanium',
    issuer: 'OCBC',
    number: '4789 •••• •••• 8765',
    validThru: '01/29',
    holderName: 'FANNY GUNAWAN',
    features: ['Cashback 1.5%', 'Cicilan 0%', 'Reward Point', 'Promo E-commerce'],
    bgColor: 'bg-purple-900',
    gradientColor: 'from-purple-700/80 to-purple-900',
    logo: 'https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg',
    logoPosition: 'bottom-right',
    chip: true
  },
];

const CreditCardItem = ({ card, index }: { card: typeof indonesianCards[0], index: number }) => {
  return (
    <motion.div 
      className="flex flex-col space-y-4"
      initial={{ opacity: 0, y: 20 }}
      whileInView={{ opacity: 1, y: 0 }}
      viewport={{ once: true }}
      transition={{ duration: 0.5, delay: index * 0.1 }}
    >
      {/* Credit Card */}
      <motion.div
        className={`relative w-full p-5 rounded-xl ${card.bgColor} bg-gradient-to-br ${card.gradientColor} overflow-hidden shadow-xl`}
        style={{ 
          aspectRatio: '1.586', 
          width: '100%', 
          maxWidth: '340px', 
          margin: '0 auto',
          boxShadow: '0 15px 30px rgba(0, 0, 0, 0.4), 0 0 0 1px rgba(255, 255, 255, 0.05)'
        }}
        whileHover={{ 
          y: -8, 
          scale: 1.03,
          rotateY: 5,
          boxShadow: '0 20px 40px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.1)',
          transition: { duration: 0.3, ease: [0.25, 0.1, 0.25, 1] } 
        }}
      >
        {/* Card Background Pattern */}
        <div className="absolute inset-0" style={{
          backgroundImage: 'radial-gradient(circle at 90% 90%, rgba(255, 255, 255, 0.1) 0%, transparent 40%)',
          backgroundSize: '100% 100%'
        }}></div>
        
        {/* Card Issuer */}
        <div className="flex justify-between items-start mb-6">
          <div className="bg-white/10 backdrop-blur-sm rounded-md px-3 py-1 text-white text-xs font-bold">
            {card.issuer}
          </div>
          {card.chip && (
            <div className="w-10 h-8 bg-yellow-500/60 rounded-md relative overflow-hidden backdrop-blur-sm">
              <div className="absolute inset-0 flex items-center justify-center">
                <div className="w-8 h-6 border-t border-b border-yellow-200/30 flex items-center justify-center">
                  <div className="w-4 h-4 border border-yellow-200/30 rounded-sm"></div>
                </div>
              </div>
            </div>
          )}
        </div>
        
        {/* Card Number */}
        <div className="mb-6">
          <div className="text-white font-mono tracking-wider text-lg">
            {card.number}
          </div>
        </div>
        
        {/* Cardholder and Expiry */}
        <div className="flex justify-between mt-auto">
          <div>
            <div className="text-white/60 text-xxs uppercase mb-1 font-mono">PEMEGANG KARTU</div>
            <div className="text-white font-mono text-sm tracking-wide">{card.holderName}</div>
          </div>
          <div>
            <div className="text-white/60 text-xxs uppercase mb-1 font-mono">VALID THRU</div>
            <div className="text-white font-mono text-sm tracking-wide">{card.validThru}</div>
          </div>
        </div>
        
        {/* Card Logo */}
        {card.logo && (
          <div className={`absolute ${
            card.logoPosition === 'top-right' ? 'top-4 right-4' 
            : card.logoPosition === 'bottom-right' ? 'bottom-4 right-4'
            : 'bottom-4 right-4'
          }`}>
            <img src={card.logo} alt="Card Brand" className="h-8 w-auto"/>
          </div>
        )}
      </motion.div>
      
      {/* Features */}
      <div className="bg-gradient-to-br from-black/80 to-gray-900/80 backdrop-blur-md rounded-xl p-5 border border-white/10 shadow-lg">
        <h4 className="text-white text-sm font-semibold mb-3 flex items-center">
          <i className="ri-shield-star-line mr-2 text-blue-400"></i>
          Fitur Kartu {card.issuer}
        </h4>
        <ul className="space-y-2.5">
          {card.features.map((feature, idx) => (
            <li key={idx} className="flex items-start text-sm text-white/90">
              <i className="ri-check-double-line text-blue-400 mr-2 mt-0.5"></i>
              <span>{feature}</span>
            </li>
          ))}
        </ul>
      </div>
      
      {/* Apply Button */}
      <motion.button
        className="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3.5 px-6 rounded-lg shadow-lg flex items-center justify-center"
        style={{
          boxShadow: '0 10px 30px rgba(37, 99, 235, 0.2), 0 0 0 1px rgba(59, 130, 246, 0.1)'
        }}
        whileHover={{ 
          y: -3,
          boxShadow: '0 15px 30px rgba(37, 99, 235, 0.3), 0 0 0 1px rgba(59, 130, 246, 0.2)'
        }}
        whileTap={{ scale: 0.98 }}
      >
        <i className="ri-bank-card-line mr-2"></i>
        Ajukan Kartu {card.issuer} {card.name}
      </motion.button>
    </motion.div>
  );
};

const ApplyCardSection: React.FC = () => {
  // State untuk menyimpan informasi apakah layarnya mobile atau tidak
  const [isMobile, setIsMobile] = useState(false);

  // Effect untuk mendeteksi ukuran layar
  useEffect(() => {
    const checkIfMobile = () => {
      setIsMobile(window.innerWidth < 768);
    };
    
    // Check awal
    checkIfMobile();
    
    // Tambahkan event listener untuk resize
    window.addEventListener('resize', checkIfMobile);
    
    // Cleanup
    return () => {
      window.removeEventListener('resize', checkIfMobile);
    };
  }, []);

  return (
    <section id="apply" className="relative min-h-screen w-full flex items-center justify-center px-4 py-20 border-t border-border overflow-hidden">
      {/* Background effects */}
      <div className="absolute inset-0" style={{
        backgroundImage: 'radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px)',
        backgroundSize: '30px 30px',
        opacity: 0.15
      }}></div>
      
      <div className="max-w-6xl mx-auto w-full z-10">
        <div className="text-center mb-14">
          <motion.div 
            className="inline-block mb-2 px-4 py-1 rounded-full bg-background/30 backdrop-blur-sm border border-border/50"
            initial={{ opacity: 0, scale: 0.8 }}
            whileInView={{ opacity: 1, scale: 1 }}
            viewport={{ once: true }}
            transition={{ duration: 0.4, delay: 0.2 }}
          >
            <span className="text-foreground text-sm font-medium">Mulai Perjalanan Anda</span>
          </motion.div>
          
          <motion.h2 
            className="text-3xl md:text-5xl font-display font-bold text-foreground mb-6"
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true }}
            transition={{ duration: 0.6 }}
          >
            <span className="bg-clip-text text-transparent bg-gradient-to-r from-primary to-primary/50">
              Pilih Kartu Kredit Terbaik
            </span>
          </motion.h2>
          
          <motion.p 
            className="text-muted-foreground text-lg max-w-2xl mx-auto mb-12"
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true }}
            transition={{ duration: 0.6, delay: 0.1 }}
          >
            Temukan kartu kredit yang sesuai dengan gaya hidup dan kebutuhan Anda. 
            Nikmati berbagai keuntungan dan reward point.
          </motion.p>
        </div>
        
        {/* Tampilan Mobile: Carousel */}
        {isMobile ? (
          <div className="mb-8">
            <Carousel
              opts={{
                align: "start",
                loop: true,
              }}
              className="w-full"
            >
              <CarouselContent className="-ml-1">
                {indonesianCards.map((card, index) => (
                  <CarouselItem key={card.id} className="pl-1 md:basis-1/2 lg:basis-1/3">
                    <div className="p-1">
                      <CreditCardItem card={card} index={index} />
                    </div>
                  </CarouselItem>
                ))}
              </CarouselContent>
              <div className="flex justify-center mt-8 gap-2">
                <CarouselPrevious className="static transform-none mx-2" />
                <CarouselNext className="static transform-none mx-2" />
              </div>
            </Carousel>
          </div>
        ) : (
          // Tampilan Desktop: Grid
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            {indonesianCards.map((card, index) => (
              <CreditCardItem key={card.id} card={card} index={index} />
            ))}
          </div>
        )}
        
        <motion.div 
          className="mt-14 text-center"
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          transition={{ duration: 0.6, delay: 0.3 }}
        >
          <motion.button
            className="inline-flex items-center px-8 py-4 rounded-full bg-white text-black font-medium"
            whileHover={{ scale: 1.05 }}
            whileTap={{ scale: 0.98 }}
          >
            Bandingkan Semua Kartu <i className="ri-arrow-right-line ml-2"></i>
          </motion.button>
        </motion.div>
      </div>
      
      {/* Section navigation arrow removed */}
    </section>
  );
};

export default ApplyCardSection;