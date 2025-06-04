import React, { useState, useEffect } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { ModernDashboardTopbar } from './dashboard-home-page';
import Footer from '@/components/Footer';
import CreditCard from '@/components/CreditCard';
import {
  Tabs,
  TabsContent,
  TabsList,
  TabsTrigger,
} from "@/components/ui/tabs";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select";

// Credit Card data type
interface CreditCard {
  id: string;
  name: string;
  issuer: string;
  cardNumber?: string;
  annualFee: number;
  interestRate: number;
  minIncome: number;
  cashbackRate?: number;
  pointsMultiplier?: number;
  rewardsProgram?: string;
  insuranceCoverage?: string[];
  travelBenefits?: string[];
  specialOffers?: string[];
  applicationLink?: string;
  description: string;
  type: 'standard' | 'premium' | 'business';
  category: 'travel' | 'cashback' | 'rewards' | 'lifestyle' | 'business';
  color: string;
  gradient: string;
}

// Dummy credit card data with detailed features for comparison
const creditCards: CreditCard[] = [
  {
    id: 'card1',
    name: 'Mileage Signature',
    issuer: 'BCA',
    annualFee: 750000,
    interestRate: 2.25,
    minIncome: 5000000,
    cashbackRate: 0.5,
    pointsMultiplier: 3,
    rewardsProgram: 'BCA Rewards',
    insuranceCoverage: [
      'Asuransi perjalanan hingga Rp 1 Miliar',
      'Asuransi pembelian hingga Rp 100 Juta',
      'Perlindungan pengembalian barang'
    ],
    travelBenefits: [
      'Akses ke 1000+ airport lounge di seluruh dunia',
      'Diskon hotel hingga 15%',
      'Gratis travel concierge'
    ],
    specialOffers: [
      'Diskon 50% di restoran terpilih',
      'Cicilan 0% hingga 12 bulan',
      'Bonus 10,000 poin saat mendaftar'
    ],
    applicationLink: 'https://www.bca.co.id/creditcards',
    description: 'Kartu premium untuk frequent traveler dengan benefit perjalanan yang lengkap dan penawaran eksklusif.',
    type: 'premium',
    category: 'travel',
    color: 'from-blue-600 to-blue-900',
    gradient: 'from-blue-900/20 to-blue-600/20'
  },
  {
    id: 'card2',
    name: 'Mileage Platinum',
    issuer: 'Mandiri',
    annualFee: 950000,
    interestRate: 2.0,
    minIncome: 8000000,
    cashbackRate: 0.8,
    pointsMultiplier: 5,
    rewardsProgram: 'Mandiri Fiestapoin',
    insuranceCoverage: [
      'Asuransi perjalanan hingga Rp 2 Miliar',
      'Asuransi pembelian hingga Rp 200 Juta',
      'Perlindungan barang elektronik hingga 90 hari'
    ],
    travelBenefits: [
      'Fast track di 15 bandara internasional',
      'Gratis antar-jemput airport Premium 3x setahun',
      'Diskon hotel hingga 20%',
      'Priority boarding di maskapai partner'
    ],
    specialOffers: [
      'Diskon 20% di hotel bintang 5 seluruh dunia',
      'Buy 1 Get 1 tiket konser dan pertunjukan',
      'Cicilan 0% hingga 24 bulan',
      'Bonus 20,000 poin saat mendaftar'
    ],
    applicationLink: 'https://www.bankmandiri.co.id/creditcards',
    description: 'Kartu premium dengan tingkat reward paling tinggi dan benefit mewah untuk gaya hidup eksklusif.',
    type: 'business',
    category: 'lifestyle',
    color: 'from-purple-600 to-purple-900',
    gradient: 'from-purple-900/20 to-purple-600/20'
  },
  {
    id: 'card3',
    name: 'Mileage Classic',
    issuer: 'BNI',
    annualFee: 350000,
    interestRate: 2.5,
    minIncome: 3000000,
    cashbackRate: 1.0,
    pointsMultiplier: 2,
    rewardsProgram: 'BNI Rewards',
    insuranceCoverage: [
      'Asuransi perjalanan hingga Rp 500 Juta',
      'Asuransi pembelian hingga Rp 50 Juta'
    ],
    travelBenefits: [
      'Akses ke 500+ airport lounge di Asia',
      'Diskon hotel hingga 10%'
    ],
    specialOffers: [
      'Cashback 5% untuk pembelian pertama',
      'Cicilan 0% hingga 6 bulan',
      'Bonus 5,000 poin saat mendaftar'
    ],
    applicationLink: 'https://www.bni.co.id/creditcards',
    description: 'Kartu terjangkau dengan cashback tinggi untuk kebutuhan sehari-hari dan benefit value for money.',
    type: 'standard',
    category: 'cashback',
    color: 'from-gray-700 to-gray-900',
    gradient: 'from-gray-900/20 to-gray-700/20'
  },
  {
    id: 'card4',
    name: 'Mileage Business',
    issuer: 'BRI',
    annualFee: 1200000,
    interestRate: 1.9,
    minIncome: 10000000,
    cashbackRate: 1.5,
    pointsMultiplier: 4,
    rewardsProgram: 'BRI Rewards',
    insuranceCoverage: [
      'Asuransi bisnis hingga Rp 500 Juta',
      'Asuransi pembelian hingga Rp 300 Juta',
      'Asuransi peralatan kantor'
    ],
    travelBenefits: [
      'Akses ke semua airport lounge di seluruh dunia',
      'Gratis upgrade kamar hotel',
      'Diskon rental mobil hingga 25%'
    ],
    specialOffers: [
      'Diskon 20% untuk pembelian peralatan kantor',
      'Cicilan 0% hingga 36 bulan',
      'Bonus 30,000 poin saat mendaftar',
      'Gratis sekretaris virtual'
    ],
    applicationLink: 'https://www.bri.co.id/creditcards',
    description: 'Kartu premium untuk pebisnis dengan keuntungan maksimal untuk pengeluaran bisnis dan benefit eksklusif.',
    type: 'business',
    category: 'business',
    color: 'from-emerald-600 to-emerald-900',
    gradient: 'from-emerald-900/20 to-emerald-600/20'
  },
  {
    id: 'card5',
    name: 'Mileage Infinite',
    issuer: 'CIMB Niaga',
    annualFee: 1500000,
    interestRate: 1.8,
    minIncome: 15000000,
    cashbackRate: 1.2,
    pointsMultiplier: 10,
    rewardsProgram: 'CIMB Rewards',
    insuranceCoverage: [
      'Asuransi perjalanan hingga Rp 3 Miliar',
      'Asuransi pembelian hingga Rp 500 Juta',
      'Perlindungan perangkat elektronik hingga 180 hari',
      'Asuransi medis darurat di luar negeri'
    ],
    travelBenefits: [
      'Akses ke lounge eksklusif di seluruh dunia',
      'Meet & greet service di bandara internasional',
      'Upgrade kursi di pesawat premium',
      'Gratis antar-jemput airport Luxury 5x setahun'
    ],
    specialOffers: [
      'Fasilitas reservasi restoran eksklusif',
      'Diskon 50% di hotel bintang 5 seluruh dunia',
      'Personal shopper di butik premium',
      'Concierge 24/7'
    ],
    applicationLink: 'https://www.cimbniaga.co.id/creditcards',
    description: 'Kartu super premium dengan layanan eksklusif kelas dunia untuk pengalaman gaya hidup mewah.',
    type: 'premium',
    category: 'travel',
    color: 'from-red-600 to-red-900',
    gradient: 'from-red-900/20 to-red-600/20'
  }
];

// Category icons map
const categoryIcons: Record<string, string> = {
  travel: 'ri-plane-line',
  cashback: 'ri-money-dollar-circle-line',
  rewards: 'ri-gift-line',
  lifestyle: 'ri-vip-crown-line',
  business: 'ri-briefcase-line'
};

// Feature names with formatting data
const featureNames: Record<string, { icon: string, label: string }> = {
  annualFee: { icon: 'ri-money-dollar-circle-line', label: 'Biaya Tahunan' },
  interestRate: { icon: 'ri-percent-line', label: 'Suku Bunga' },
  minIncome: { icon: 'ri-wallet-line', label: 'Minimum Pendapatan' },
  cashbackRate: { icon: 'ri-refund-2-line', label: 'Tingkat Cashback' },
  pointsMultiplier: { icon: 'ri-coins-line', label: 'Poin Multiplier' },
  rewardsProgram: { icon: 'ri-award-line', label: 'Program Reward' },
  insuranceCoverage: { icon: 'ri-shield-check-line', label: 'Perlindungan Asuransi' },
  travelBenefits: { icon: 'ri-flight-takeoff-line', label: 'Benefit Perjalanan' },
  specialOffers: { icon: 'ri-coupon-3-line', label: 'Penawaran Spesial' }
};

// Card Badge component
const CardBadge = ({ type }: { type: string }) => {
  const bgColor = 
    type === 'premium' ? 'bg-blue-600' : 
    type === 'business' ? 'bg-emerald-600' : 
    'bg-gray-600';
  
  return (
    <span className={`${bgColor} px-2 py-1 rounded-full text-xs text-white font-medium`}>
      {type === 'premium' ? 'Premium' : 
       type === 'business' ? 'Business' : 
       'Standard'}
    </span>
  );
};

// Format value helper function
const formatValue = (key: string, value: any): string => {
  if (key === 'annualFee') {
    return `Rp ${value.toLocaleString()}`;
  } else if (key === 'interestRate') {
    return `${value}% per bulan`;
  } else if (key === 'minIncome') {
    return `Rp ${value.toLocaleString()} per bulan`;
  } else if (key === 'cashbackRate') {
    return `${value}%`;
  } else if (key === 'pointsMultiplier') {
    return `${value}x`;
  } else {
    return value;
  }
};

// Card Compare Item component
const CardCompareItem = ({ 
  card, 
  onRemove,
  highlightFeatures = []
}: { 
  card: CreditCard, 
  onRemove: () => void,
  highlightFeatures?: string[] 
}) => {
  return (
    <div className="flex-1 min-w-0 bg-background border border-border rounded-xl overflow-hidden">
      <div className="bg-gradient-to-br h-44 relative flex items-center justify-center p-4">
        <div className={`absolute inset-0 bg-gradient-to-br ${card.color} opacity-90`}></div>
        <div className={`absolute inset-0 bg-gradient-to-br ${card.gradient} opacity-80`}></div>
        
        <div className="relative z-10 text-white text-center">
          <div className="flex justify-end mb-2">
            <button
              onClick={onRemove}
              className="p-2 bg-white/20 rounded-full backdrop-blur-sm hover:bg-white/30 transition-colors"
            >
              <i className="ri-close-line"></i>
            </button>
          </div>
          <h3 className="font-bold text-lg">{card.name}</h3>
          <p className="text-sm opacity-80">{card.issuer}</p>
          <div className="mt-2 flex items-center justify-center">
            <CardBadge type={card.type} />
            <span className="ml-2 bg-black/30 px-2 py-1 rounded-full text-xs flex items-center">
              <i className={`${categoryIcons[card.category]} mr-1`}></i>
              <span>{card.category.charAt(0).toUpperCase() + card.category.slice(1)}</span>
            </span>
          </div>
        </div>
      </div>
      
      <div className="p-4 text-sm space-y-4">
        <div className="text-center py-2">
          <p className="text-foreground/70">{card.description}</p>
        </div>
        
        {Object.entries(featureNames).map(([key, { icon, label }]) => {
          if (!card[key as keyof CreditCard]) return null;
          
          const value = card[key as keyof CreditCard];
          const isHighlighted = highlightFeatures.includes(key);
          
          return (
            <div 
              key={key} 
              className={`py-3 ${isHighlighted ? 'bg-blue-50 dark:bg-blue-950/20 rounded-lg px-3' : ''}`}
            >
              <div className="flex items-center mb-1">
                <i className={`${icon} mr-2 ${isHighlighted ? 'text-blue-600' : 'text-foreground/70'}`}></i>
                <span className={`font-medium ${isHighlighted ? 'text-blue-600' : ''}`}>{label}</span>
              </div>
              
              {Array.isArray(value) ? (
                <ul className="list-disc pl-8 space-y-1 text-foreground/80">
                  {value.map((item, idx) => (
                    <li key={idx}>{item}</li>
                  ))}
                </ul>
              ) : (
                <div className="pl-6 text-foreground/80">{formatValue(key, value)}</div>
              )}
            </div>
          );
        })}
        
        <div className="pt-4 border-t border-border">
          <a
            href={card.applicationLink}
            target="_blank"
            rel="noopener noreferrer"
            className="block w-full py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-center"
          >
            Ajukan Sekarang
          </a>
        </div>
      </div>
    </div>
  );
};

// Empty Card Slot component
const EmptyCardSlot = ({ 
  onSelect,
  availableCards 
}: { 
  onSelect: (cardId: string) => void,
  availableCards: CreditCard[]
}) => {
  const [isOpen, setIsOpen] = useState(false);
  
  return (
    <div className="flex-1 min-w-0 border border-dashed border-border rounded-xl overflow-hidden bg-foreground/5 flex flex-col items-center justify-center p-8 text-center">
      <div className="w-16 h-16 rounded-full border-2 border-dashed border-border flex items-center justify-center mb-4">
        <i className="ri-add-line text-2xl text-foreground/50"></i>
      </div>
      <h3 className="font-medium text-lg mb-2">Tambahkan Kartu</h3>
      <p className="text-foreground/60 mb-4">
        Pilih kartu untuk dibandingkan
      </p>
      
      {isOpen ? (
        <div className="w-full">
          <Select onValueChange={(value) => {
            onSelect(value);
            setIsOpen(false);
          }}>
            <SelectTrigger className="w-full">
              <SelectValue placeholder="Pilih kartu" />
            </SelectTrigger>
            <SelectContent>
              {availableCards.map(card => (
                <SelectItem key={card.id} value={card.id}>
                  {card.issuer} {card.name}
                </SelectItem>
              ))}
            </SelectContent>
          </Select>
          
          <button
            onClick={() => setIsOpen(false)}
            className="mt-2 w-full py-2 px-4 border border-border rounded-lg text-sm hover:bg-foreground/5 transition-colors"
          >
            Batal
          </button>
        </div>
      ) : (
        <button
          onClick={() => setIsOpen(true)}
          className="py-2 px-6 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
        >
          Pilih Kartu
        </button>
      )}
    </div>
  );
};

// Feature Highlight Panel
const FeatureHighlightPanel = ({
  selectedFeatures,
  onToggleFeature
}: {
  selectedFeatures: string[],
  onToggleFeature: (feature: string) => void
}) => {
  return (
    <div className="bg-background border border-border rounded-xl p-6 overflow-hidden">
      <h3 className="font-bold text-lg mb-4">Sorot Fitur Penting</h3>
      
      <p className="text-sm text-foreground/70 mb-4">
        Pilih fitur yang ingin Anda bandingkan atau soroti untuk melihat perbedaan utama antar kartu.
      </p>
      
      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
        {Object.entries(featureNames).map(([key, { icon, label }]) => (
          <button
            key={key}
            className={`flex items-center p-3 rounded-lg border ${
              selectedFeatures.includes(key) 
                ? 'bg-blue-50 border-blue-200 text-blue-700 dark:bg-blue-950/20 dark:border-blue-800'
                : 'border-border hover:bg-foreground/5'
            } transition-colors`}
            onClick={() => onToggleFeature(key)}
          >
            <i className={`${icon} mr-2 ${selectedFeatures.includes(key) ? 'text-blue-600' : 'text-foreground/70'}`}></i>
            <span className="text-sm">{label}</span>
            {selectedFeatures.includes(key) && (
              <i className="ri-check-line ml-auto text-blue-600"></i>
            )}
          </button>
        ))}
      </div>
    </div>
  );
};

// Filter Options component
const FilterOptions = ({
  onTypeChange,
  onCategoryChange,
  selectedType,
  selectedCategory
}: {
  onTypeChange: (type: string | null) => void,
  onCategoryChange: (category: string | null) => void,
  selectedType: string | null,
  selectedCategory: string | null
}) => {
  return (
    <div className="flex flex-wrap items-center gap-3 mb-6">
      <div className="flex items-center space-x-3">
        <span className="text-sm font-medium">Tipe:</span>
        <div className="flex items-center space-x-2">
          <button 
            className={`px-3 py-1 rounded-full text-sm ${
              selectedType === null 
                ? 'bg-blue-600 text-white' 
                : 'bg-foreground/10 hover:bg-foreground/20'
            }`}
            onClick={() => onTypeChange(null)}
          >
            Semua
          </button>
          <button 
            className={`px-3 py-1 rounded-full text-sm ${
              selectedType === 'standard' 
                ? 'bg-blue-600 text-white' 
                : 'bg-foreground/10 hover:bg-foreground/20'
            }`}
            onClick={() => onTypeChange('standard')}
          >
            Standard
          </button>
          <button 
            className={`px-3 py-1 rounded-full text-sm ${
              selectedType === 'premium' 
                ? 'bg-blue-600 text-white' 
                : 'bg-foreground/10 hover:bg-foreground/20'
            }`}
            onClick={() => onTypeChange('premium')}
          >
            Premium
          </button>
          <button 
            className={`px-3 py-1 rounded-full text-sm ${
              selectedType === 'business' 
                ? 'bg-blue-600 text-white' 
                : 'bg-foreground/10 hover:bg-foreground/20'
            }`}
            onClick={() => onTypeChange('business')}
          >
            Business
          </button>
        </div>
      </div>
      
      <div className="flex items-center space-x-3">
        <span className="text-sm font-medium">Kategori:</span>
        <div className="flex items-center space-x-2">
          <button 
            className={`px-3 py-1 rounded-full text-sm ${
              selectedCategory === null 
                ? 'bg-blue-600 text-white' 
                : 'bg-foreground/10 hover:bg-foreground/20'
            }`}
            onClick={() => onCategoryChange(null)}
          >
            Semua
          </button>
          <button 
            className={`px-3 py-1 rounded-full text-sm ${
              selectedCategory === 'travel' 
                ? 'bg-blue-600 text-white' 
                : 'bg-foreground/10 hover:bg-foreground/20'
            }`}
            onClick={() => onCategoryChange('travel')}
          >
            Travel
          </button>
          <button 
            className={`px-3 py-1 rounded-full text-sm ${
              selectedCategory === 'cashback' 
                ? 'bg-blue-600 text-white' 
                : 'bg-foreground/10 hover:bg-foreground/20'
            }`}
            onClick={() => onCategoryChange('cashback')}
          >
            Cashback
          </button>
          <button 
            className={`px-3 py-1 rounded-full text-sm ${
              selectedCategory === 'rewards' 
                ? 'bg-blue-600 text-white' 
                : 'bg-foreground/10 hover:bg-foreground/20'
            }`}
            onClick={() => onCategoryChange('rewards')}
          >
            Rewards
          </button>
          <button 
            className={`px-3 py-1 rounded-full text-sm ${
              selectedCategory === 'lifestyle' 
                ? 'bg-blue-600 text-white' 
                : 'bg-foreground/10 hover:bg-foreground/20'
            }`}
            onClick={() => onCategoryChange('lifestyle')}
          >
            Lifestyle
          </button>
          <button 
            className={`px-3 py-1 rounded-full text-sm ${
              selectedCategory === 'business' 
                ? 'bg-blue-600 text-white' 
                : 'bg-foreground/10 hover:bg-foreground/20'
            }`}
            onClick={() => onCategoryChange('business')}
          >
            Business
          </button>
        </div>
      </div>
    </div>
  );
};

// Compare Cards Page component
const CompareCardsPage: React.FC = () => {
  const [selectedType, setSelectedType] = useState<string | null>(null);
  const [selectedCategory, setSelectedCategory] = useState<string | null>(null);
  const [selectedCards, setSelectedCards] = useState<string[]>([]);
  const [highlightedFeatures, setHighlightedFeatures] = useState<string[]>([]);
  
  // Filter cards based on selected type and category
  const filteredCards = creditCards.filter(card => {
    if (selectedType && card.type !== selectedType) {
      return false;
    }
    if (selectedCategory && card.category !== selectedCategory) {
      return false;
    }
    return true;
  });
  
  // Available cards (cards not already selected)
  const availableCards = filteredCards.filter(card => !selectedCards.includes(card.id));
  
  // Selected card objects
  const selectedCardObjects = selectedCards.map(id => 
    creditCards.find(card => card.id === id)
  ).filter(Boolean) as CreditCard[];
  
  // Toggle feature highlight
  const toggleFeatureHighlight = (feature: string) => {
    if (highlightedFeatures.includes(feature)) {
      setHighlightedFeatures(highlightedFeatures.filter(f => f !== feature));
    } else {
      setHighlightedFeatures([...highlightedFeatures, feature]);
    }
  };
  
  // Handle adding a card to comparison
  const handleAddCard = (cardId: string) => {
    if (selectedCards.length < 3 && !selectedCards.includes(cardId)) {
      setSelectedCards([...selectedCards, cardId]);
    }
  };
  
  // Handle removing a card from comparison
  const handleRemoveCard = (cardId: string) => {
    setSelectedCards(selectedCards.filter(id => id !== cardId));
  };
  
  // Reset all selections
  const resetComparison = () => {
    setSelectedCards([]);
    setHighlightedFeatures([]);
  };
  
  return (
    <div className="min-h-screen bg-background">
      <ModernDashboardTopbar />
      
      <main className="py-6 px-4 lg:px-8 pb-20">
        <div className="max-w-7xl mx-auto">
          <div className="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8">
            <div>
              <h1 className="text-2xl lg:text-3xl font-bold font-display mb-1">Bandingkan Kartu Kredit</h1>
              <p className="text-muted-foreground">Temukan kartu kredit terbaik yang sesuai dengan kebutuhan Anda</p>
            </div>
            
            <div className="mt-4 lg:mt-0 flex space-x-2">
              <button 
                className="flex items-center space-x-2 px-3 py-2 rounded-lg border border-border hover:bg-foreground/5 transition-colors"
                onClick={resetComparison}
              >
                <i className="ri-refresh-line"></i>
                <span>Reset</span>
              </button>
              <button 
                className="flex items-center space-x-2 px-3 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors"
                onClick={() => window.print()}
              >
                <i className="ri-printer-line"></i>
                <span>Cetak Perbandingan</span>
              </button>
            </div>
          </div>
          
          {/* Tabs */}
          <Tabs defaultValue="compare" className="mb-8">
            <TabsList className="w-full justify-start mb-6 bg-transparent border-b border-border p-0 h-auto">
              <TabsTrigger 
                value="compare" 
                className="data-[state=active]:bg-transparent data-[state=active]:shadow-none px-4 h-10 border-b-2 border-transparent data-[state=active]:border-blue-600 rounded-none font-medium"
              >
                Bandingkan Kartu
              </TabsTrigger>
              <TabsTrigger 
                value="browse" 
                className="data-[state=active]:bg-transparent data-[state=active]:shadow-none px-4 h-10 border-b-2 border-transparent data-[state=active]:border-blue-600 rounded-none font-medium"
              >
                Telusuri Semua Kartu
              </TabsTrigger>
            </TabsList>
            
            <TabsContent value="compare" className="mt-0">
              {/* Filters */}
              <FilterOptions 
                onTypeChange={setSelectedType}
                onCategoryChange={setSelectedCategory}
                selectedType={selectedType}
                selectedCategory={selectedCategory}
              />
              
              {/* Feature Highlight Panel */}
              <FeatureHighlightPanel 
                selectedFeatures={highlightedFeatures}
                onToggleFeature={toggleFeatureHighlight}
              />
              
              {/* Card Comparison Area */}
              <div className="mt-8">
                <h2 className="text-xl font-bold mb-4">Perbandingan Kartu</h2>
                
                <div className="flex flex-col md:flex-row gap-6">
                  {selectedCardObjects.map(card => (
                    <CardCompareItem 
                      key={card.id} 
                      card={card} 
                      onRemove={() => handleRemoveCard(card.id)}
                      highlightFeatures={highlightedFeatures}
                    />
                  ))}
                  
                  {selectedCards.length < 3 && (
                    <EmptyCardSlot 
                      onSelect={handleAddCard}
                      availableCards={availableCards}
                    />
                  )}
                  
                  {selectedCards.length === 0 && selectedCards.length < 3 && (
                    <EmptyCardSlot 
                      onSelect={handleAddCard}
                      availableCards={availableCards}
                    />
                  )}
                  
                  {selectedCards.length === 0 && selectedCards.length < 3 && (
                    <EmptyCardSlot 
                      onSelect={handleAddCard}
                      availableCards={availableCards}
                    />
                  )}
                </div>
                
                {selectedCards.length === 0 && (
                  <div className="text-center py-10 text-muted-foreground">
                    <i className="ri-bank-card-line text-4xl mb-2 block"></i>
                    <p>Pilih minimal satu kartu untuk dibandingkan</p>
                  </div>
                )}
              </div>
              
              {/* Recommendation */}
              {selectedCards.length > 0 && (
                <div className="mt-10 bg-blue-50 dark:bg-blue-950/20 rounded-xl p-6">
                  <h3 className="text-lg font-bold text-blue-800 dark:text-blue-300 mb-2">Rekomendasi</h3>
                  <p className="text-blue-700 dark:text-blue-400">
                    {selectedCards.length === 1 ? (
                      <>
                        <span className="font-medium">{selectedCardObjects[0].name}</span> adalah pilihan tepat untuk Anda jika Anda mencari kartu dengan {' '}
                        {selectedCardObjects[0].type === 'premium' ? 'benefit premium dan layanan eksklusif' : 
                         selectedCardObjects[0].type === 'business' ? 'keuntungan bisnis dan fleksibilitas tinggi' : 
                         'kemudahan penggunaan dan biaya tahunan terjangkau'}.
                      </>
                    ) : selectedCards.length === 2 ? (
                      <>
                        Dari perbandingan ini, <span className="font-medium">{selectedCardObjects[0].name}</span> lebih unggul dalam hal 
                        {selectedCardObjects[0].cashbackRate && selectedCardObjects[0].cashbackRate > (selectedCardObjects[1].cashbackRate || 0) ? ' cashback ' : ''}
                        {selectedCardObjects[0].pointsMultiplier && selectedCardObjects[0].pointsMultiplier > (selectedCardObjects[1].pointsMultiplier || 0) ? ' pengumpulan poin ' : ''}
                        {selectedCardObjects[0].annualFee < selectedCardObjects[1].annualFee ? ' biaya tahunan lebih rendah ' : ''},
                        sementara <span className="font-medium">{selectedCardObjects[1].name}</span> menawarkan keunggulan dalam hal
                        {selectedCardObjects[1].travelBenefits && (!selectedCardObjects[0].travelBenefits || selectedCardObjects[1].travelBenefits.length > selectedCardObjects[0].travelBenefits.length) ? ' benefit perjalanan ' : ''}
                        {selectedCardObjects[1].specialOffers && (!selectedCardObjects[0].specialOffers || selectedCardObjects[1].specialOffers.length > selectedCardObjects[0].specialOffers.length) ? ' penawaran spesial ' : ''}.
                      </>
                    ) : (
                      <>
                        Dari ketiga kartu, <span className="font-medium">{
                          selectedCardObjects.sort((a, b) => (
                            (b.cashbackRate || 0) - (a.cashbackRate || 0) + 
                            (b.pointsMultiplier || 0) - (a.pointsMultiplier || 0)
                          ))[0].name
                        }</span> menawarkan nilai terbaik secara keseluruhan, 
                        sementara <span className="font-medium">{
                          selectedCardObjects.sort((a, b) => a.annualFee - b.annualFee)[0].name
                        }</span> paling ekonomis dengan biaya tahunan terendah.
                      </>
                    )}
                  </p>
                </div>
              )}
            </TabsContent>
            
            <TabsContent value="browse" className="mt-0">
              {/* Filters */}
              <FilterOptions 
                onTypeChange={setSelectedType}
                onCategoryChange={setSelectedCategory}
                selectedType={selectedType}
                selectedCategory={selectedCategory}
              />
              
              {/* Card Browsing */}
              <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                {filteredCards.map(card => (
                  <motion.div
                    key={card.id}
                    className="bg-background border border-border rounded-xl overflow-hidden"
                    initial={{ opacity: 0, y: 10 }}
                    animate={{ opacity: 1, y: 0 }}
                    transition={{ duration: 0.4 }}
                    whileHover={{ y: -5, transition: { duration: 0.2 } }}
                  >
                    <div className="h-44 relative">
                      <div className={`absolute inset-0 bg-gradient-to-br ${card.color}`}></div>
                      <div className={`absolute inset-0 bg-gradient-to-tr ${card.gradient}`}></div>
                      
                      <div className="absolute inset-0 p-6 flex flex-col justify-between text-white">
                        <div className="flex items-start justify-between">
                          <div>
                            <h3 className="font-bold text-lg">{card.name}</h3>
                            <p className="text-sm opacity-80">{card.issuer}</p>
                          </div>
                          <div className="flex space-x-2">
                            <CardBadge type={card.type} />
                          </div>
                        </div>
                        
                        <div className="flex items-center">
                          <span className="bg-black/30 px-2 py-1 rounded-full text-xs flex items-center">
                            <i className={`${categoryIcons[card.category]} mr-1`}></i>
                            <span>{card.category.charAt(0).toUpperCase() + card.category.slice(1)}</span>
                          </span>
                        </div>
                      </div>
                    </div>
                    
                    <div className="p-4">
                      <p className="text-sm text-muted-foreground mb-4">{card.description}</p>
                      
                      <div className="space-y-3 mb-4">
                        <div className="flex justify-between text-sm">
                          <span className="text-muted-foreground">Biaya Tahunan:</span>
                          <span className="font-medium">Rp {card.annualFee.toLocaleString()}</span>
                        </div>
                        <div className="flex justify-between text-sm">
                          <span className="text-muted-foreground">Suku Bunga:</span>
                          <span className="font-medium">{card.interestRate}% per bulan</span>
                        </div>
                        {card.cashbackRate && (
                          <div className="flex justify-between text-sm">
                            <span className="text-muted-foreground">Cashback:</span>
                            <span className="font-medium">{card.cashbackRate}%</span>
                          </div>
                        )}
                        {card.pointsMultiplier && (
                          <div className="flex justify-between text-sm">
                            <span className="text-muted-foreground">Poin Multiplier:</span>
                            <span className="font-medium">{card.pointsMultiplier}x</span>
                          </div>
                        )}
                      </div>
                      
                      <div className="flex space-x-2">
                        <button
                          onClick={() => handleAddCard(card.id)}
                          className={`flex-1 py-2 px-4 ${
                            selectedCards.includes(card.id) || selectedCards.length >= 3
                              ? 'bg-foreground/10 text-muted-foreground cursor-not-allowed'
                              : 'bg-blue-600 text-white hover:bg-blue-700'
                          } rounded-lg transition-colors text-sm`}
                          disabled={selectedCards.includes(card.id) || selectedCards.length >= 3}
                        >
                          {selectedCards.includes(card.id) 
                            ? 'Sudah Dipilih' 
                            : selectedCards.length >= 3
                              ? 'Maksimum 3 Kartu'
                              : 'Bandingkan'}
                        </button>
                        <a
                          href={card.applicationLink}
                          target="_blank"
                          rel="noopener noreferrer"
                          className="py-2 px-4 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-950/20 transition-colors text-sm"
                        >
                          Detail
                        </a>
                      </div>
                    </div>
                  </motion.div>
                ))}
              </div>
              
              {filteredCards.length === 0 && (
                <div className="text-center py-20 text-muted-foreground">
                  <i className="ri-filter-off-line text-4xl mb-2 block"></i>
                  <p>Tidak ada kartu yang sesuai dengan filter yang dipilih</p>
                  <button
                    onClick={() => {
                      setSelectedType(null);
                      setSelectedCategory(null);
                    }}
                    className="mt-4 py-2 px-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                  >
                    Reset Filter
                  </button>
                </div>
              )}
            </TabsContent>
          </Tabs>
        </div>
      </main>
      
      <Footer />
    </div>
  );
};

export default CompareCardsPage;