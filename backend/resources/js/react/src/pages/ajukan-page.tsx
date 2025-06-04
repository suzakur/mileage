import React, { useState, useEffect } from 'react';
import { motion } from 'framer-motion';
import Header from '@/components/Header';
import Footer from '@/components/Footer';
import MobileMenu from '@/components/MobileMenu';

// Interface untuk data kartu kredit
interface CreditCard {
  id: number;
  name: string;
  bank: string;
  description: string;
  category: string;
  image: string;
  features: string[];
  annualFee: string;
  interestRate: string;
  minIncome: string;
  cardType: 'standard' | 'premium' | 'business';
}

// Data kartu kredit dari berbagai bank di Indonesia
const creditCardsData: CreditCard[] = [
  // BCA
  {
    id: 1,
    name: "BCA Visa Platinum",
    bank: "BCA",
    description: "Kartu kredit premium untuk kemudahan transaksi sehari-hari dengan fitur cashback menarik.",
    category: "Cashback",
    image: "https://www.bca.co.id/-/media/Feature/Card/List-Card/Kartu-Kredit/platinum-card-pilihan.jpg",
    features: ["Cashback hingga 5%", "BCA Flazz", "Asuransi perjalanan", "Airport Lounge"],
    annualFee: "Rp 750.000",
    interestRate: "2.25% per bulan",
    minIncome: "Rp 10.000.000",
    cardType: "premium"
  },
  {
    id: 2,
    name: "BCA MasterCard Black",
    bank: "BCA",
    description: "Kartu kredit dengan poin reward untuk kemudahan transaksi dan keuntungan tambahan.",
    category: "Rewards",
    image: "https://www.bca.co.id/-/media/Feature/Card/List-Card/Kartu-Kredit/mastercard-black-feature.jpg",
    features: ["BCA Poin", "Diskon Merchant", "Asuransi pembelian", "Cicilan 0%"],
    annualFee: "Rp 500.000",
    interestRate: "2.25% per bulan",
    minIncome: "Rp 7.000.000",
    cardType: "standard"
  },
  // Mandiri
  {
    id: 3,
    name: "Mandiri Visa Signature",
    bank: "Mandiri",
    description: "Kartu kredit premium dengan fitur poin reward dan berbagai keuntungan untuk perjalanan.",
    category: "Travel",
    image: "https://www.bankmandiri.co.id/documents/Kartu-Kredit/kartu-kredit-mandiri-visa-signature.png",
    features: ["Mandiri Fiestapoin", "Airport Lounge", "Asuransi perjalanan", "Concierge Service"],
    annualFee: "Rp 1.000.000",
    interestRate: "2.25% per bulan",
    minIncome: "Rp 15.000.000",
    cardType: "premium"
  },
  {
    id: 4,
    name: "Mandiri Skyz Card",
    bank: "Mandiri",
    description: "Kartu kredit dengan fokus untuk kebutuhan perjalanan dengan berbagai keuntungan tiket.",
    category: "Travel",
    image: "https://www.bankmandiri.co.id/documents/Kartu-Kredit/kartu-kredit-mandiri-skyz-card.png",
    features: ["Miles Reward", "Airport Lounge", "Diskon Hotel", "Priority Check-in"],
    annualFee: "Rp 750.000",
    interestRate: "2.25% per bulan",
    minIncome: "Rp 8.000.000",
    cardType: "standard"
  },
  // BNI
  {
    id: 5,
    name: "BNI Visa Platinum",
    bank: "BNI",
    description: "Kartu kredit dengan fitur cashback dan reward poin untuk berbagai kebutuhan.",
    category: "Cashback",
    image: "https://www.bni.co.id/portals/1/BNI/Personal/Kartu-Kredit/Images/kartu%20kredit%20BNI%20Platinum.jpg",
    features: ["BNI Reward Points", "Cashback", "Airport Lounge", "Asuransi perjalanan"],
    annualFee: "Rp 750.000",
    interestRate: "2.25% per bulan",
    minIncome: "Rp 10.000.000",
    cardType: "premium"
  },
  {
    id: 6,
    name: "BNI JCB Platinum",
    bank: "BNI",
    description: "Kartu kredit co-branding dengan JCB untuk kemudahan transaksi di Jepang dan Asia.",
    category: "Travel",
    image: "https://www.bni.co.id/portals/1/BNI/Personal/Kartu-Kredit/Images/kartu%20kredit%20BNI%20JCB%20Platinum.jpg",
    features: ["Diskon di Jepang", "Airport Lounge", "Asuransi perjalanan", "Concierge Service"],
    annualFee: "Rp 750.000",
    interestRate: "2.25% per bulan",
    minIncome: "Rp 8.000.000",
    cardType: "premium"
  },
  // BRI
  {
    id: 7,
    name: "BRI Infinite",
    bank: "BRI",
    description: "Kartu kredit premium untuk gaya hidup eksklusif dengan fasilitas dan pelayanan terbaik.",
    category: "Lifestyle",
    image: "https://bri.co.id/o/bri-corporate-theme/images/credit-card/INFINITE.png",
    features: ["BRI Point", "Airport Lounge", "Concierge Service", "Travel Insurance"],
    annualFee: "Rp 1.500.000",
    interestRate: "2.25% per bulan",
    minIncome: "Rp 25.000.000",
    cardType: "premium"
  },
  {
    id: 8,
    name: "BRI JCB Platinum",
    bank: "BRI",
    description: "Kartu kredit khusus untuk kebutuhan bisnis dengan fitur pengelolaan keuangan.",
    category: "Business",
    image: "https://bri.co.id/o/bri-corporate-theme/images/credit-card/JCB-PLATINUM.png",
    features: ["Laporan Pengeluaran", "Diskon Bisnis", "Poin Reward", "Cicilan 0%"],
    annualFee: "Rp 750.000",
    interestRate: "2.25% per bulan",
    minIncome: "Rp 10.000.000",
    cardType: "business"
  },
  // CIMB Niaga
  {
    id: 9,
    name: "CIMB World MasterCard",
    bank: "CIMB Niaga",
    description: "Kartu kredit premium dengan fitur cashback dan rewards untuk kemudahan transaksi.",
    category: "Cashback",
    image: "https://www.cimbniaga.co.id/content/dam/cimbniaga/id/images/world.png",
    features: ["Cashback hingga 10%", "Airport Lounge", "Travel Insurance", "Concierge Service"],
    annualFee: "Rp 1.200.000",
    interestRate: "2.25% per bulan",
    minIncome: "Rp 15.000.000",
    cardType: "premium"
  },
  {
    id: 10,
    name: "CIMB Niaga AirAsia",
    bank: "CIMB Niaga",
    description: "Kartu kredit co-branding dengan AirAsia untuk keuntungan perjalanan udara.",
    category: "Travel",
    image: "https://www.cimbniaga.co.id/content/dam/cimbniaga/id/images/airasia-new.png",
    features: ["Big Points", "Diskon Tiket", "Priority Boarding", "Free Baggage"],
    annualFee: "Rp 600.000",
    interestRate: "2.25% per bulan",
    minIncome: "Rp 7.000.000",
    cardType: "standard"
  },
  // Bank Mega
  {
    id: 11,
    name: "Mega Visa Infinite",
    bank: "Bank Mega",
    description: "Kartu kredit premium dengan fitur cashback untuk gaya hidup mewah.",
    category: "Lifestyle",
    image: "https://www.bankmega.com/media/images/kartuKredit_infinit.jpg",
    features: ["Cashback", "Airport Lounge", "Concierge Service", "Hotel Discount"],
    annualFee: "Rp 1.000.000",
    interestRate: "2.25% per bulan",
    minIncome: "Rp 20.000.000",
    cardType: "premium"
  },
  {
    id: 12,
    name: "Mega Travel Card",
    bank: "Bank Mega",
    description: "Kartu kredit dengan fokus untuk perjalanan dan wisata.",
    category: "Travel",
    image: "https://www.bankmega.com/media/images/kartuKredit_travelcard.jpg",
    features: ["Diskon Travel", "Miles", "Poin Reward", "Cicilan 0%"],
    annualFee: "Rp 500.000",
    interestRate: "2.25% per bulan",
    minIncome: "Rp 5.000.000",
    cardType: "standard"
  },
  // DBS
  {
    id: 13,
    name: "DBS Black Visa Infinite",
    bank: "DBS",
    description: "Kartu kredit premium dengan fitur rewards dan travel untuk gaya hidup mewah.",
    category: "Travel",
    image: "https://www.dbs.id/id/iwov-resources/media/images/treasures/black-card-premium.png",
    features: ["DBS Rewards", "Airport Lounge", "Hotel Benefits", "Golf Privileges"],
    annualFee: "Rp 1.500.000",
    interestRate: "2.25% per bulan",
    minIncome: "Rp 25.000.000",
    cardType: "premium"
  },
  {
    id: 14,
    name: "DBS Cashback",
    bank: "DBS",
    description: "Kartu kredit dengan fitur cashback untuk belanja harian dan kebutuhan rumah tangga.",
    category: "Cashback",
    image: "https://www.dbs.id/id/iwov-resources/media/images/cards/credit-cards/shopping-card.png",
    features: ["Cashback hingga 5%", "Diskon Grocery", "Cicilan 0%", "Asuransi pembelian"],
    annualFee: "Rp 600.000",
    interestRate: "2.25% per bulan",
    minIncome: "Rp 7.000.000",
    cardType: "standard"
  },
  // HSBC
  {
    id: 15,
    name: "HSBC Visa Platinum",
    bank: "HSBC",
    description: "Kartu kredit premium dengan fitur rewards dan travel untuk gaya hidup dinamis.",
    category: "Travel",
    image: "https://www.hsbc.co.id/content/dam/hsbc/id/images/credit-cards/visa-platinum-card-new.jpg",
    features: ["HSBC Rewards", "Airport Lounge", "Travel Insurance", "Dining Privileges"],
    annualFee: "Rp 900.000",
    interestRate: "2.25% per bulan",
    minIncome: "Rp 15.000.000",
    cardType: "premium"
  },
  {
    id: 16,
    name: "HSBC Gold",
    bank: "HSBC",
    description: "Kartu kredit dengan fitur rewards dan cashback untuk kemudahan transaksi.",
    category: "Rewards",
    image: "https://www.hsbc.co.id/content/dam/hsbc/id/images/credit-cards/visa-gold-card-new.jpg",
    features: ["HSBC Rewards", "Cashback", "Diskon Merchant", "Cicilan 0%"],
    annualFee: "Rp 600.000",
    interestRate: "2.25% per bulan",
    minIncome: "Rp 7.000.000",
    cardType: "standard"
  },
  // Maybank
  {
    id: 17,
    name: "Maybank World MasterCard",
    bank: "Maybank",
    description: "Kartu kredit premium untuk gaya hidup mewah dengan fasilitas eksklusif.",
    category: "Lifestyle",
    image: "https://www.maybank.co.id/iwov-resources/images/cards/credit-card-world-mastercard.png",
    features: ["TreatsPoint", "Airport Lounge", "Golf Privileges", "Concierge Service"],
    annualFee: "Rp 1.000.000",
    interestRate: "2.25% per bulan",
    minIncome: "Rp 20.000.000",
    cardType: "premium"
  },
  {
    id: 18,
    name: "Maybank FC Barcelona",
    bank: "Maybank",
    description: "Kartu kredit co-branding dengan FC Barcelona untuk penggemar sepak bola.",
    category: "Lifestyle",
    image: "https://www.maybank.co.id/iwov-resources/images/cards/credit-card-fc-barcelona.png",
    features: ["Merchandise FC Barcelona", "TreatsPoint", "Travel Benefits", "Diskon Merchant"],
    annualFee: "Rp 700.000",
    interestRate: "2.25% per bulan",
    minIncome: "Rp 7.000.000",
    cardType: "standard"
  },
  // Bank Permata
  {
    id: 19,
    name: "Permata Preferred Visa Signature",
    bank: "Bank Permata",
    description: "Kartu kredit premium dengan fitur rewards dan cashback untuk kemudahan transaksi.",
    category: "Rewards",
    image: "https://www.permatabank.com/sites/default/files/styles/product_listing/public/2020-03/permata_visa_signature_product_page.png",
    features: ["Permata Rewards", "Airport Lounge", "Hotel Privileges", "Dining Discount"],
    annualFee: "Rp 900.000",
    interestRate: "2.25% per bulan",
    minIncome: "Rp 15.000.000",
    cardType: "premium"
  },
  {
    id: 20,
    name: "Permata Shopping Card",
    bank: "Bank Permata",
    description: "Kartu kredit dengan fokus untuk kebutuhan belanja dengan berbagai keuntungan diskon.",
    category: "Shopping",
    image: "https://www.permatabank.com/sites/default/files/styles/product_listing/public/2020-03/permata_shopping_card_product_page-04_0.png",
    features: ["Diskon Shopping", "Cicilan 0%", "Permata Rewards", "Cash Rebate"],
    annualFee: "Rp 500.000",
    interestRate: "2.25% per bulan",
    minIncome: "Rp 5.000.000",
    cardType: "standard"
  }
];

// Interface untuk kartu yang dimiliki user
interface OwnedCard {
  id: number;
  dateAcquired: string;
  status: 'active' | 'inactive' | 'pending';
}

// Dummy data kartu yang dimiliki
const ownedCards: OwnedCard[] = [
  {
    id: 1, // BCA Visa Platinum
    dateAcquired: '2023-04-15',
    status: 'active'
  },
  {
    id: 5, // BNI Visa Platinum
    dateAcquired: '2024-01-20',
    status: 'pending'
  }
];

// Fungsi untuk cek apakah kartu dimiliki user
const isCardOwned = (cardId: number): OwnedCard | undefined => {
  return ownedCards.find(ownedCard => ownedCard.id === cardId);
};

// Card component untuk menampilkan kartu kredit
const CreditCardItem = ({ 
  card, 
  isComparing = false, 
  onToggleCompare, 
  onShowDetails
}: { 
  card: CreditCard, 
  isComparing?: boolean, 
  onToggleCompare?: (cardId: number) => void,
  onShowDetails?: (card: CreditCard) => void
}) => {
  const ownedCard = isCardOwned(card.id);
  
  return (
    <motion.div 
      className="rounded-xl overflow-hidden bg-background/60 backdrop-blur-sm border border-border/50 hover:shadow-lg shadow-blue-900/10 transition-all duration-300"
      whileHover={{ y: -5 }}
    >
      <div className="relative h-48 overflow-hidden">
        <img 
          src={card.image} 
          alt={card.name} 
          className="w-full h-full object-cover transition-transform duration-700 hover:scale-110"
          onError={(e) => {
            // Saat gambar gagal dimuat, ganti dengan gambar fallback
            e.currentTarget.src = 'https://placehold.co/600x400/2563eb/FFFFFF?text=Kartu+Kredit';
          }}
        />
        <div className="absolute inset-0 bg-gradient-to-t from-background/90 to-transparent"></div>
        <div className="absolute bottom-4 left-4 right-4">
          <div className="flex justify-between items-end">
            <div>
              <span className="px-3 py-1 bg-blue-600/90 backdrop-blur-sm rounded-full text-white text-xs font-medium shadow-lg mb-2 inline-block">
                {card.bank}
              </span>
              <h3 className="text-white text-lg font-bold">{card.name}</h3>
            </div>
            <span className="text-white text-xs bg-background/50 px-2 py-1 rounded backdrop-blur-sm">
              {card.category}
            </span>
          </div>
        </div>
        
        {/* Badge untuk kartu yang dimiliki */}
        {ownedCard && (
          <div className="absolute top-3 right-3">
            <div className={`px-2 py-1 rounded text-xs font-medium text-white ${
              ownedCard.status === 'active' ? 'bg-green-500' : 
              ownedCard.status === 'pending' ? 'bg-amber-500' : 'bg-red-500'
            }`}>
              {ownedCard.status === 'active' ? 'Dimiliki' : 
               ownedCard.status === 'pending' ? 'Dalam Proses' : 'Tidak Aktif'}
            </div>
          </div>
        )}
      </div>
      
      <div className="p-5">
        <p className="text-muted-foreground text-sm mb-4">{card.description}</p>
        
        <div className="grid grid-cols-2 gap-4 mb-4">
          <div>
            <span className="block text-xs text-muted-foreground mb-1">Biaya Tahunan</span>
            <span className="text-foreground font-medium">{card.annualFee}</span>
          </div>
          <div>
            <span className="block text-xs text-muted-foreground mb-1">Bunga</span>
            <span className="text-foreground font-medium">{card.interestRate}</span>
          </div>
        </div>
        
        <div className="flex flex-wrap gap-2 mb-4">
          {card.features.slice(0, 3).map((feature, idx) => (
            <span key={idx} className="text-xs px-2 py-1 rounded-full bg-foreground/10 text-foreground">
              {feature}
            </span>
          ))}
          {card.features.length > 3 && 
            <span className="text-xs px-2 py-1 rounded-full bg-foreground/10 text-foreground">
              +{card.features.length - 3}
            </span>
          }
        </div>
        
        <div className="flex flex-col gap-2">
          {/* Tombol untuk melihat detail, selalu ditampilkan */}
          <button 
            onClick={() => onShowDetails && onShowDetails(card)}
            className="w-full py-2 rounded-lg text-blue-600 border border-blue-600 hover:bg-blue-50 font-medium transition-colors text-sm flex items-center justify-center gap-2"
          >
            <span>Lihat Detail</span>
            <i className="ri-information-line"></i>
          </button>
          
          {/* Group tombol ajukan/lihat yang sudah dimiliki dan bandingkan */}
          <div className="flex gap-2">
            {/* Tombol ajukan atau tombol status kartu dimiliki */}
            {ownedCard ? (
              <button 
                className={`flex-1 py-2 rounded-lg text-white font-medium transition-colors text-sm flex items-center justify-center gap-1 ${
                  ownedCard.status === 'active' ? 'bg-green-600 hover:bg-green-700' : 
                  ownedCard.status === 'pending' ? 'bg-amber-600 hover:bg-amber-700' : 'bg-red-600 hover:bg-red-700'
                }`}
                onClick={() => onShowDetails && onShowDetails(card)}
              >
                <span>
                  {ownedCard.status === 'active' ? 'Lihat Kartu' : 
                   ownedCard.status === 'pending' ? 'Dalam Proses' : 'Aktifkan'}
                </span>
                {ownedCard.status === 'active' && <i className="ri-eye-line"></i>}
                {ownedCard.status === 'pending' && <i className="ri-time-line"></i>}
                {ownedCard.status === 'inactive' && <i className="ri-restart-line"></i>}
              </button>
            ) : (
              <button 
                className="flex-1 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium transition-colors text-sm flex items-center justify-center gap-2"
              >
                <span>Ajukan Kartu</span>
                <i className="ri-arrow-right-line"></i>
              </button>
            )}
            
            {/* Tombol bandingkan */}
            <button 
              onClick={() => onToggleCompare && onToggleCompare(card.id)}
              className={`w-10 py-2 rounded-lg ${
                isComparing 
                  ? 'bg-blue-600 text-white' 
                  : 'bg-foreground/10 text-foreground'
              } hover:opacity-80 font-medium transition-colors text-sm flex items-center justify-center`}
              title={isComparing ? "Batalkan perbandingan" : "Bandingkan kartu"}
            >
              {isComparing 
                ? <i className="ri-checkbox-circle-fill"></i>
                : <i className="ri-scales-line"></i>
              }
            </button>
          </div>
        </div>
      </div>
    </motion.div>
  );
};

// Bank filter component
const BankFilter = ({ banks, activeBank, onChange, isMobile }: { 
  banks: string[];
  activeBank: string | null;
  onChange: (bank: string | null) => void;
  isMobile: boolean;
}) => {

  return (
    <div className={`flex items-center ${isMobile ? 'flex-wrap gap-2' : 'space-x-4 overflow-x-auto no-scrollbar'} pb-2`}>
      <motion.button 
        className={`px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap ${
          activeBank === null ? 'bg-blue-600 text-white' : 'bg-foreground/10 text-foreground hover:bg-foreground/20'
        }`}
        onClick={() => onChange(null)}
        whileHover={{ scale: 1.05 }}
        whileTap={{ scale: 0.95 }}
      >
        Semua Bank
      </motion.button>
      
      {banks.map((bank) => (
        <motion.button 
          key={bank}
          className={`px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap ${
            activeBank === bank ? 'bg-blue-600 text-white' : 'bg-foreground/10 text-foreground hover:bg-foreground/20'
          }`}
          onClick={() => onChange(bank)}
          whileHover={{ scale: 1.05 }}
          whileTap={{ scale: 0.95 }}
        >
          {bank}
        </motion.button>
      ))}
    </div>
  );
};



// Main component untuk halaman Ajukan Kartu
// Detail modal component untuk menampilkan spesifikasi lengkap kartu
const CardDetailModal = ({ 
  card, 
  isOpen, 
  onClose 
}: { 
  card: CreditCard | null, 
  isOpen: boolean, 
  onClose: () => void 
}) => {
  if (!card || !isOpen) return null;
  
  const ownedCard = isCardOwned(card.id);
  
  return (
    <div className="fixed inset-0 z-50 flex items-center justify-center p-4">
      <div className="absolute inset-0 bg-black/60 backdrop-blur-sm" onClick={onClose}></div>
      <motion.div 
        initial={{ opacity: 0, scale: 0.95 }}
        animate={{ opacity: 1, scale: 1 }}
        exit={{ opacity: 0, scale: 0.95 }}
        transition={{ duration: 0.2 }}
        className="relative bg-background rounded-xl overflow-hidden max-w-4xl w-full max-h-[80vh] flex flex-col"
      >
        <div className="sticky top-0 z-10 flex justify-between items-center p-4 bg-background/90 backdrop-blur-sm border-b">
          <h2 className="text-xl font-bold flex items-center">
            <span className="mr-2">{card.name}</span>
            {ownedCard && (
              <span className={`ml-2 text-xs px-2 py-1 rounded-full text-white ${
                ownedCard.status === 'active' ? 'bg-green-500' : 
                ownedCard.status === 'pending' ? 'bg-amber-500' : 'bg-red-500'
              }`}>
                {ownedCard.status === 'active' ? 'Dimiliki' : 
                 ownedCard.status === 'pending' ? 'Dalam Proses' : 'Tidak Aktif'}
              </span>
            )}
          </h2>
          <button 
            onClick={onClose}
            className="w-8 h-8 rounded-full flex items-center justify-center hover:bg-foreground/10"
          >
            <i className="ri-close-line text-xl"></i>
          </button>
        </div>
        
        <div className="overflow-y-auto p-4">
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <div className="relative h-56 rounded-lg overflow-hidden mb-4">
                <img 
                  src={card.image} 
                  alt={card.name} 
                  className="w-full h-full object-cover"
                  onError={(e) => {
                    e.currentTarget.src = 'https://placehold.co/600x400/2563eb/FFFFFF?text=Kartu+Kredit';
                  }}
                />
              </div>
              
              <div className="mb-6">
                <h3 className="text-lg font-semibold mb-2">Deskripsi</h3>
                <p className="text-muted-foreground">{card.description}</p>
              </div>
              
              <div className="p-4 border border-border rounded-lg">
                <h3 className="text-lg font-semibold mb-4">Biaya dan Persyaratan</h3>
                <div className="space-y-4">
                  <div className="flex justify-between items-center">
                    <span className="text-muted-foreground">Biaya Tahunan</span>
                    <span className="font-medium">{card.annualFee}</span>
                  </div>
                  <div className="h-px bg-border/50"></div>
                  <div className="flex justify-between items-center">
                    <span className="text-muted-foreground">Suku Bunga</span>
                    <span className="font-medium">{card.interestRate}</span>
                  </div>
                  <div className="h-px bg-border/50"></div>
                  <div className="flex justify-between items-center">
                    <span className="text-muted-foreground">Minimum Penghasilan</span>
                    <span className="font-medium">{card.minIncome}</span>
                  </div>
                  <div className="h-px bg-border/50"></div>
                  <div className="flex justify-between items-center">
                    <span className="text-muted-foreground">Jenis Kartu</span>
                    <span className="font-medium capitalize">{card.cardType}</span>
                  </div>
                </div>
              </div>
            </div>
            
            <div>
              <div className="mb-6">
                <h3 className="text-lg font-semibold mb-4">Bank Penerbit</h3>
                <div className="flex items-center">
                  <div className="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i className="ri-bank-line text-blue-600 text-xl"></i>
                  </div>
                  <div className="ml-3">
                    <h4 className="font-medium">{card.bank}</h4>
                    <div className="text-sm text-muted-foreground">Indonesia</div>
                  </div>
                </div>
              </div>
              
              <div className="mb-6">
                <h3 className="text-lg font-semibold mb-2">Kategori</h3>
                <div className="inline-block px-3 py-1 rounded-full bg-blue-100 text-blue-700">
                  {card.category}
                </div>
              </div>
              
              <div className="mb-6">
                <h3 className="text-lg font-semibold mb-3">Fitur dan Keuntungan</h3>
                <ul className="space-y-2">
                  {card.features.map((feature, idx) => (
                    <li key={idx} className="flex items-start gap-2">
                      <i className="ri-check-line text-green-500 mt-0.5"></i>
                      <span>{feature}</span>
                    </li>
                  ))}
                </ul>
              </div>
              
              <div className="mb-6">
                <h3 className="text-lg font-semibold mb-3">Persyaratan Dokumen</h3>
                <ul className="space-y-2">
                  <li className="flex items-start gap-2">
                    <i className="ri-checkbox-circle-line text-blue-600 mt-0.5"></i>
                    <span>KTP</span>
                  </li>
                  <li className="flex items-start gap-2">
                    <i className="ri-checkbox-circle-line text-blue-600 mt-0.5"></i>
                    <span>NPWP</span>
                  </li>
                  <li className="flex items-start gap-2">
                    <i className="ri-checkbox-circle-line text-blue-600 mt-0.5"></i>
                    <span>Slip Gaji / Bukti Penghasilan</span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        
        <div className="sticky bottom-0 p-4 bg-background/90 backdrop-blur-sm border-t flex gap-2">
          {!ownedCard ? (
            <>
              <button className="flex-1 py-3 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium transition-colors flex items-center justify-center gap-2">
                <i className="ri-add-line"></i>
                <span>Ajukan Kartu Ini</span>
              </button>
            </>
          ) : (
            <button 
              className={`flex-1 py-3 rounded-lg text-white font-medium transition-colors flex items-center justify-center gap-2 ${
                ownedCard.status === 'active' ? 'bg-green-600 hover:bg-green-700' : 
                ownedCard.status === 'pending' ? 'bg-amber-600 hover:bg-amber-700' : 'bg-red-600 hover:bg-red-700'
              }`}
            >
              {ownedCard.status === 'active' && (
                <>
                  <i className="ri-bank-card-line"></i>
                  <span>Kelola Kartu</span>
                </>
              )}
              {ownedCard.status === 'pending' && (
                <>
                  <i className="ri-time-line"></i>
                  <span>Cek Status Pengajuan</span>
                </>
              )}
              {ownedCard.status === 'inactive' && (
                <>
                  <i className="ri-restart-line"></i>
                  <span>Aktifkan Kembali</span>
                </>
              )}
            </button>
          )}
          <button 
            onClick={onClose} 
            className="px-4 py-3 rounded-lg border border-border hover:bg-foreground/5 font-medium transition-colors"
          >
            Tutup
          </button>
        </div>
      </motion.div>
    </div>
  );
};

// Comparison table component untuk perbandingan kartu
const ComparisonTable = ({ 
  cards, 
  onClose 
}: { 
  cards: CreditCard[], 
  onClose: () => void 
}) => {
  if (!cards.length) return null;
  
  return (
    <div className="bg-background border border-border rounded-xl p-6 mb-8">
      <div className="flex justify-between items-center mb-4">
        <h2 className="text-xl font-bold">Perbandingan Kartu Kredit</h2>
        <button 
          onClick={onClose}
          className="text-muted-foreground hover:text-foreground"
        >
          <i className="ri-close-line text-xl"></i>
        </button>
      </div>
      
      <div className="overflow-x-auto">
        <table className="w-full border-collapse">
          <thead>
            <tr className="border-b border-border">
              <th className="text-left py-3 px-4 font-medium">Kriteria</th>
              {cards.map(card => (
                <th key={card.id} className="text-left py-3 px-4 font-medium">
                  <div className="flex flex-col items-center text-center">
                    <img 
                      src={card.image} 
                      alt={card.name} 
                      className="w-20 h-12 object-cover rounded mb-2"
                      onError={(e) => {
                        e.currentTarget.src = 'https://placehold.co/160x96/2563eb/FFFFFF?text=Kartu+Kredit';
                      }}
                    />
                    <span>{card.name}</span>
                    <span className="text-xs text-muted-foreground">{card.bank}</span>
                  </div>
                </th>
              ))}
            </tr>
          </thead>
          <tbody>
            <tr className="border-b border-border/50">
              <td className="py-3 px-4 font-medium">Biaya Tahunan</td>
              {cards.map(card => (
                <td key={card.id} className="py-3 px-4">{card.annualFee}</td>
              ))}
            </tr>
            <tr className="border-b border-border/50">
              <td className="py-3 px-4 font-medium">Suku Bunga</td>
              {cards.map(card => (
                <td key={card.id} className="py-3 px-4">{card.interestRate}</td>
              ))}
            </tr>
            <tr className="border-b border-border/50">
              <td className="py-3 px-4 font-medium">Kategori</td>
              {cards.map(card => (
                <td key={card.id} className="py-3 px-4">{card.category}</td>
              ))}
            </tr>
            <tr className="border-b border-border/50">
              <td className="py-3 px-4 font-medium">Min. Penghasilan</td>
              {cards.map(card => (
                <td key={card.id} className="py-3 px-4">{card.minIncome}</td>
              ))}
            </tr>
            <tr className="border-b border-border/50">
              <td className="py-3 px-4 font-medium">Fitur Utama</td>
              {cards.map(card => (
                <td key={card.id} className="py-3 px-4">
                  <ul className="list-disc list-inside text-sm space-y-1">
                    {card.features.map((feature, index) => (
                      <li key={index}>{feature}</li>
                    ))}
                  </ul>
                </td>
              ))}
            </tr>
            <tr>
              <td className="py-3 px-4 font-medium">Jenis Kartu</td>
              {cards.map(card => (
                <td key={card.id} className="py-3 px-4 capitalize">{card.cardType}</td>
              ))}
            </tr>
          </tbody>
        </table>
      </div>
      
      <div className="mt-6 flex justify-end gap-2">
        <button 
          onClick={onClose}
          className="px-4 py-2 rounded-lg border border-border hover:bg-foreground/5"
        >
          Tutup
        </button>
        <button className="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white">
          Ajukan Kartu Terpilih
        </button>
      </div>
    </div>
  );
};

const AjukanPage: React.FC = () => {
  const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);
  const [selectedBank, setSelectedBank] = useState<string | null>(null);
  const [isMobile, setIsMobile] = useState(false);
  
  // State untuk detail kartu dan perbandingan
  const [selectedCard, setSelectedCard] = useState<CreditCard | null>(null);
  const [isDetailOpen, setIsDetailOpen] = useState(false);
  const [comparingCards, setComparingCards] = useState<number[]>([]);
  
  // Effect untuk mendeteksi ukuran layar
  useEffect(() => {
    const checkIfMobile = () => {
      setIsMobile(window.innerWidth < 768);
    };
    
    // Check awal
    checkIfMobile();
    
    // Listener untuk resize
    window.addEventListener('resize', checkIfMobile);
    
    // Cleanup
    return () => {
      window.removeEventListener('resize', checkIfMobile);
    };
  }, []);
  
  // Fungsi untuk menampilkan detail kartu
  const handleShowCardDetails = (card: CreditCard) => {
    setSelectedCard(card);
    setIsDetailOpen(true);
  };
  
  // Fungsi untuk toggle kartu yang dibandingkan
  const handleToggleCompare = (cardId: number) => {
    if (comparingCards.includes(cardId)) {
      setComparingCards(comparingCards.filter(id => id !== cardId));
    } else {
      // Batasi maksimal 3 kartu untuk dibandingkan
      if (comparingCards.length < 3) {
        setComparingCards([...comparingCards, cardId]);
      } else {
        // Jika sudah 3, ganti kartu pertama
        setComparingCards([...comparingCards.slice(1), cardId]);
      }
    }
  };
  
  // Extract unique banks
  const banks = Array.from(new Set(creditCardsData.map(card => card.bank))).sort();
  
  // Filter cards based on selected bank only
  const filteredCards = creditCardsData.filter(card => {
    return selectedBank === null || card.bank === selectedBank;
  });
  
  // Group cards by bank
  const cardsByBank = filteredCards.reduce((acc, card) => {
    if (!acc[card.bank]) {
      acc[card.bank] = [];
    }
    acc[card.bank].push(card);
    return acc;
  }, {} as Record<string, CreditCard[]>);
  
  // Mendapatkan kartu yang dipilih untuk dibandingkan
  const selectedComparisonCards = creditCardsData.filter(card => 
    comparingCards.includes(card.id)
  );
  
  return (
    <div className="min-h-screen overflow-x-hidden bg-background">
      <Header onMobileMenuToggle={() => setIsMobileMenuOpen(!isMobileMenuOpen)} />
      
      <main className="pb-20 px-4">
        {/* Fixed Bank Filters at the top */}
        <div className="sticky top-0 pt-20 pb-4 z-30 bg-background">
          <div className="max-w-6xl mx-auto">
            <div className="flex justify-between items-center mb-4">
              <motion.h2 
                className="text-2xl font-display font-bold text-foreground"
                initial={{ opacity: 0, y: 10 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.4 }}
              >
                <span className="bg-clip-text text-transparent bg-gradient-to-r from-blue-500 to-indigo-600">
                  Kartu Kredit
                </span>
              </motion.h2>
              
              {/* Tombol bandingkan */}
              {comparingCards.length > 0 && (
                <motion.button
                  className="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium flex items-center gap-2"
                  initial={{ opacity: 0, scale: 0.95 }}
                  animate={{ opacity: 1, scale: 1 }}
                  onClick={() => {window.scrollTo({top: 0, behavior: 'smooth'})}}
                >
                  <i className="ri-scales-3-line"></i>
                  <span>Bandingkan {comparingCards.length} Kartu</span>
                </motion.button>
              )}
            </div>
            
            {/* Bank Filter */}
            <div className="relative mb-2">
              <div className="flex items-center gap-2 mb-2">
                <i className="ri-bank-line text-blue-400"></i>
                <span className="text-sm font-medium">Filter Bank:</span>
              </div>
              <div className="relative z-10 overflow-x-auto whitespace-nowrap pb-2 -mx-1 px-1 no-scrollbar">
                <BankFilter 
                  banks={banks} 
                  activeBank={selectedBank} 
                  onChange={setSelectedBank}
                  isMobile={isMobile}
                />
              </div>
              <div className="absolute right-0 top-0 h-full w-20 bg-gradient-to-l from-background to-transparent pointer-events-none"></div>
            </div>
            

          </div>
          <div className="h-px w-full bg-border/30 mt-4"></div>
        </div>
        
        <div className="pt-6"></div>
        
        {/* Comparison table section - terlihat saat kartu dipilih untuk dibandingkan */}
        {selectedComparisonCards.length > 0 && (
          <section className="max-w-6xl mx-auto -mt-6">
            <ComparisonTable 
              cards={selectedComparisonCards} 
              onClose={() => setComparingCards([])} 
            />
          </section>
        )}
        
        {/* Credit Cards Section */}
        <section className="max-w-6xl mx-auto">
          {selectedBank === null ? (
            // Display cards grouped by bank
            Object.entries(cardsByBank).map(([bank, cards]) => (
              <div key={bank} className="mb-12">
                <div className="flex items-center mb-4">
                  <h2 className="text-2xl font-display font-bold text-foreground">{bank}</h2>
                  <div className="ml-4 h-px bg-border flex-grow"></div>
                </div>
                
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                  {cards.map((card) => (
                    <CreditCardItem 
                      key={card.id} 
                      card={card}
                      isComparing={comparingCards.includes(card.id)}
                      onToggleCompare={handleToggleCompare}
                      onShowDetails={handleShowCardDetails}
                    />
                  ))}
                </div>
              </div>
            ))
          ) : (
            // Display cards of selected bank
            <div className="mb-12">
              <div className="flex items-center mb-4">
                <h2 className="text-2xl font-display font-bold text-foreground">{selectedBank}</h2>
                <div className="ml-4 h-px bg-border flex-grow"></div>
              </div>
              
              <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {filteredCards.map((card) => (
                  <CreditCardItem 
                    key={card.id} 
                    card={card} 
                    isComparing={comparingCards.includes(card.id)}
                    onToggleCompare={handleToggleCompare}
                    onShowDetails={handleShowCardDetails}
                  />
                ))}
              </div>
            </div>
          )}
          
          {filteredCards.length === 0 && (
            <div className="text-center py-12">
              <i className="ri-search-line text-6xl text-foreground/20 mb-4"></i>
              <h3 className="text-xl font-medium text-foreground mb-2">Tidak ada kartu yang sesuai</h3>
              <p className="text-muted-foreground">Coba ubah filter pencarian Anda</p>
            </div>
          )}
        </section>
      </main>
      
      <Footer />
      <MobileMenu isOpen={isMobileMenuOpen} onClose={() => setIsMobileMenuOpen(false)} />
    </div>
  );
};

export default AjukanPage;