import React, { useState } from 'react';
import { motion } from 'framer-motion';
import Header from '@/components/Header';
import Footer from '@/components/Footer';
import MobileMenu from '@/components/MobileMenu';
import { Button } from "@/components/ui/button";
import { Check, X } from "lucide-react";

// Tipe data untuk paket berlangganan
interface SubscriptionPackage {
  id: string;
  name: string;
  description: string;
  price: number;
  duration: string;
  cardLimit: number | 'unlimited';
  features: {
    text: string;
    included: boolean;
  }[];
  popularTag?: boolean;
  color: string;
  buttonText: string;
}

// Data paket berlangganan
const subscriptionPackages: SubscriptionPackage[] = [
  {
    id: 'free',
    name: 'Free',
    description: 'Cocok untuk pengguna kartu kredit pemula',
    price: 0,
    duration: 'Selamanya',
    cardLimit: 2,
    features: [
      { text: 'Tambahkan hingga 2 kartu', included: true },
      { text: 'Akses fitur dasar', included: true },
      { text: 'Notifikasi pembayaran', included: true },
      { text: 'Sinkronisasi transaksi manual', included: true },
      { text: 'Laporan pengeluaran bulanan', included: false },
      { text: 'Sinkronisasi otomatis transaksi', included: false },
      { text: 'Perbandingan kartu kredit', included: false },
      { text: 'Dukungan prioritas', included: false },
    ],
    color: 'blue',
    buttonText: 'Daftar Sekarang'
  },
  {
    id: 'mendang-mending',
    name: 'Mendang Mending',
    description: 'Untuk pengguna aktif beberapa kartu kredit',
    price: 75000,
    duration: '6 bulan',
    cardLimit: 5,
    features: [
      { text: 'Tambahkan hingga 5 kartu', included: true },
      { text: 'Akses fitur dasar', included: true },
      { text: 'Notifikasi pembayaran', included: true },
      { text: 'Sinkronisasi transaksi manual', included: true },
      { text: 'Laporan pengeluaran bulanan', included: true },
      { text: 'Sinkronisasi otomatis transaksi', included: true },
      { text: 'Perbandingan kartu kredit', included: false },
      { text: 'Dukungan prioritas', included: false },
    ],
    popularTag: true,
    color: 'green',
    buttonText: 'Pilih Paket'
  },
  {
    id: 'boss',
    name: 'Boss',
    description: 'Untuk pengguna dengan banyak kartu kredit',
    price: 100000,
    duration: '6 bulan',
    cardLimit: 8,
    features: [
      { text: 'Tambahkan hingga 8 kartu', included: true },
      { text: 'Akses fitur dasar', included: true },
      { text: 'Notifikasi pembayaran', included: true },
      { text: 'Sinkronisasi transaksi manual', included: true },
      { text: 'Laporan pengeluaran bulanan', included: true },
      { text: 'Sinkronisasi otomatis transaksi', included: true },
      { text: 'Perbandingan kartu kredit', included: true },
      { text: 'Dukungan prioritas', included: false },
    ],
    color: 'purple',
    buttonText: 'Pilih Paket'
  },
  {
    id: 'sultan',
    name: 'Sultan',
    description: 'Tanpa batasan, untuk pengalaman terbaik',
    price: 175000,
    duration: '6 bulan',
    cardLimit: 'unlimited',
    features: [
      { text: 'Kartu tidak terbatas', included: true },
      { text: 'Akses fitur dasar', included: true },
      { text: 'Notifikasi pembayaran', included: true },
      { text: 'Sinkronisasi transaksi manual', included: true },
      { text: 'Laporan pengeluaran bulanan', included: true },
      { text: 'Sinkronisasi otomatis transaksi', included: true },
      { text: 'Perbandingan kartu kredit', included: true },
      { text: 'Dukungan prioritas', included: true },
    ],
    color: 'gold',
    buttonText: 'Pilih Paket'
  }
];

// Komponen untuk kartu paket berlangganan
const SubscriptionCard: React.FC<{ 
  pkg: SubscriptionPackage; 
  isSelected: boolean;
  onSelect: () => void;
}> = ({ pkg, isSelected, onSelect }) => {
  // Menentukan warna border dan background berdasarkan paket
  let borderColor = 'border-border';
  let backgroundColor = 'bg-background';
  let accentColor = 'bg-blue-500';
  let buttonClass = 'bg-blue-600 hover:bg-blue-700';
  
  if (pkg.color === 'blue') {
    accentColor = 'bg-blue-500';
    buttonClass = 'bg-blue-600 hover:bg-blue-700';
  } else if (pkg.color === 'green') {
    accentColor = 'bg-green-500';
    buttonClass = 'bg-green-600 hover:bg-green-700';
  } else if (pkg.color === 'purple') {
    accentColor = 'bg-purple-500';
    buttonClass = 'bg-purple-600 hover:bg-purple-700';
  } else if (pkg.color === 'gold') {
    accentColor = 'bg-amber-500';
    buttonClass = 'bg-amber-600 hover:bg-amber-700';
  }
  
  if (isSelected) {
    borderColor = `border-${pkg.color === 'gold' ? 'amber' : pkg.color}-500`;
    backgroundColor = `bg-${pkg.color === 'gold' ? 'amber' : pkg.color}-50 dark:bg-${pkg.color === 'gold' ? 'amber' : pkg.color}-950/20`;
  }
  
  return (
    <motion.div 
      className={`relative flex flex-col rounded-2xl border-2 ${borderColor} ${backgroundColor} transition-all duration-300 overflow-hidden h-full`}
      whileHover={{ y: -5, transition: { duration: 0.2 } }}
      initial={{ opacity: 0, y: 20 }}
      animate={{ opacity: 1, y: 0 }}
      transition={{ duration: 0.5 }}
    >
      {/* Popular tag */}
      {pkg.popularTag && (
        <div className="absolute top-0 right-0">
          <div className="bg-green-500 text-white py-1 px-3 rounded-bl-lg text-xs font-medium shadow-lg">
            Populer
          </div>
        </div>
      )}
      
      {/* Header */}
      <div className={`${accentColor} p-6 text-white`}>
        <h3 className="text-xl font-bold">{pkg.name}</h3>
        <p className="text-white/90 text-sm mt-2">{pkg.description}</p>
      </div>
      
      {/* Pricing */}
      <div className="p-6 border-b border-border">
        <div className="flex items-baseline">
          <span className="text-3xl font-bold">
            {pkg.price === 0 ? 'Gratis' : `Rp ${pkg.price.toLocaleString('id-ID')}`}
          </span>
          {pkg.price > 0 && (
            <span className="text-muted-foreground text-sm ml-2">/{pkg.duration}</span>
          )}
        </div>
        <div className="mt-2 flex items-center">
          <span className="text-sm text-muted-foreground">
            {typeof pkg.cardLimit === 'number' 
              ? `Hingga ${pkg.cardLimit} kartu kredit` 
              : 'Kartu kredit tidak terbatas'}
          </span>
        </div>
      </div>
      
      {/* Features */}
      <div className="p-6 flex-grow">
        <ul className="space-y-3">
          {pkg.features.map((feature, idx) => (
            <li key={idx} className="flex items-start">
              {feature.included ? (
                <Check className="h-5 w-5 text-green-500 mr-2 flex-shrink-0" />
              ) : (
                <X className="h-5 w-5 text-muted-foreground/50 mr-2 flex-shrink-0" />
              )}
              <span className={feature.included ? 'text-foreground' : 'text-muted-foreground/70'}>
                {feature.text}
              </span>
            </li>
          ))}
        </ul>
      </div>
      
      {/* Button */}
      <div className="p-6 pt-3">
        <Button 
          className={`w-full ${buttonClass} text-white`}
          onClick={onSelect}
        >
          {pkg.buttonText}
        </Button>
      </div>
    </motion.div>
  );
};

// Komponen modal konfirmasi langganan
const SubscriptionConfirmModal: React.FC<{
  isOpen: boolean;
  onClose: () => void;
  selectedPackage: SubscriptionPackage | null;
}> = ({ isOpen, onClose, selectedPackage }) => {
  if (!isOpen || !selectedPackage) return null;
  
  return (
    <div className="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
      <motion.div 
        className="bg-background rounded-xl border border-border max-w-md w-full p-6 shadow-xl"
        initial={{ scale: 0.9, opacity: 0 }}
        animate={{ scale: 1, opacity: 1 }}
        exit={{ scale: 0.9, opacity: 0 }}
      >
        <h3 className="text-xl font-bold mb-4">Konfirmasi Berlangganan</h3>
        
        <div className="space-y-4">
          <p>
            Anda akan berlangganan paket <span className="font-semibold">{selectedPackage.name}</span> seharga{' '}
            <span className="font-semibold">
              {selectedPackage.price === 0 ? 'Gratis' : `Rp ${selectedPackage.price.toLocaleString('id-ID')}`}
            </span>
            {selectedPackage.price > 0 && ` untuk ${selectedPackage.duration}`}.
          </p>
          
          <div className="bg-foreground/5 rounded-lg p-4">
            <p className="text-sm">
              Dengan paket ini, Anda akan mendapatkan:
            </p>
            <ul className="mt-2 space-y-1 text-sm">
              {selectedPackage.features
                .filter(f => f.included)
                .map((feature, idx) => (
                  <li key={idx} className="flex items-center">
                    <Check className="h-4 w-4 text-green-500 mr-2" />
                    {feature.text}
                  </li>
                ))}
            </ul>
          </div>
          
          {selectedPackage.price > 0 && (
            <p className="text-sm text-muted-foreground">
              Pembayaran akan diproses melalui penyedia layanan pembayaran yang aman.
              Anda dapat membatalkan kapan saja dari pengaturan akun Anda.
            </p>
          )}
        </div>
        
        <div className="flex space-x-3 mt-6">
          <Button
            variant="outline"
            onClick={onClose}
            className="flex-1"
          >
            Batal
          </Button>
          
          <Button
            className={`flex-1 ${
              selectedPackage.color === 'blue' ? 'bg-blue-600 hover:bg-blue-700' :
              selectedPackage.color === 'green' ? 'bg-green-600 hover:bg-green-700' :
              selectedPackage.color === 'purple' ? 'bg-purple-600 hover:bg-purple-700' :
              'bg-amber-600 hover:bg-amber-700'
            } text-white`}
            onClick={() => {
              // Simulasikan proses berlangganan
              setTimeout(() => {
                onClose();
              }, 1000);
            }}
          >
            Konfirmasi
          </Button>
        </div>
      </motion.div>
    </div>
  );
};

// Komponen utama halaman berlangganan
const SubscriptionPage: React.FC = () => {
  const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);
  const [selectedPackage, setSelectedPackage] = useState<SubscriptionPackage | null>(null);
  const [showConfirmModal, setShowConfirmModal] = useState(false);
  
  const handleSelectPackage = (pkg: SubscriptionPackage) => {
    setSelectedPackage(pkg);
    setShowConfirmModal(true);
  };
  
  const closeConfirmModal = () => {
    setShowConfirmModal(false);
  };
  
  return (
    <div className="min-h-screen overflow-x-hidden bg-background">
      <Header onMobileMenuToggle={() => setIsMobileMenuOpen(!isMobileMenuOpen)} />
      
      <main className="pt-24 pb-20 px-4">
        <section className="max-w-6xl mx-auto">
          <div className="text-center mb-12">
            <motion.h1
              className="text-4xl md:text-5xl font-display font-bold"
              initial={{ opacity: 0, y: -10 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.5 }}
            >
              Pilih Paket <span className="text-blue-600">Berlangganan</span>
            </motion.h1>
            <motion.p
              className="mt-4 text-lg text-muted-foreground max-w-3xl mx-auto"
              initial={{ opacity: 0, y: 10 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.5, delay: 0.1 }}
            >
              Pilih paket yang sesuai dengan kebutuhan Anda. Upgrade kapan saja untuk mendapatkan fitur lebih banyak.
            </motion.p>
          </div>
          
          <div className="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
            {subscriptionPackages.map((pkg, idx) => (
              <SubscriptionCard
                key={pkg.id}
                pkg={pkg}
                isSelected={selectedPackage?.id === pkg.id}
                onSelect={() => handleSelectPackage(pkg)}
              />
            ))}
          </div>
          
          <div className="mt-16 max-w-3xl mx-auto p-6 bg-blue-50 dark:bg-blue-950/20 rounded-xl border border-blue-200 dark:border-blue-800/60">
            <h3 className="text-xl font-bold mb-3">Pertanyaan Umum</h3>
            
            <div className="space-y-4">
              <div>
                <h4 className="font-medium mb-1">Apa perbedaan antar paket?</h4>
                <p className="text-sm text-muted-foreground">
                  Perbedaan utama adalah jumlah kartu kredit yang dapat Anda tambahkan dan fitur-fitur
                  tambahan seperti laporan pengeluaran, perbandingan kartu, dan dukungan prioritas.
                </p>
              </div>
              
              <div>
                <h4 className="font-medium mb-1">Apakah saya bisa mengganti paket?</h4>
                <p className="text-sm text-muted-foreground">
                  Ya, Anda dapat melakukan upgrade atau downgrade kapan saja. Jika Anda melakukan upgrade,
                  biaya akan disesuaikan secara proporsional dengan sisa waktu berlangganan Anda.
                </p>
              </div>
              
              <div>
                <h4 className="font-medium mb-1">Bagaimana cara membatalkan langganan?</h4>
                <p className="text-sm text-muted-foreground">
                  Anda dapat membatalkan langganan kapan saja melalui pengaturan akun Anda. Langganan akan
                  tetap aktif hingga akhir periode berlangganan Anda.
                </p>
              </div>
              
              <div>
                <h4 className="font-medium mb-1">Apakah ada jaminan uang kembali?</h4>
                <p className="text-sm text-muted-foreground">
                  Ya, kami menawarkan jaminan uang kembali 14 hari. Jika Anda tidak puas dengan layanan kami,
                  silakan hubungi tim dukungan kami untuk proses pengembalian dana.
                </p>
              </div>
            </div>
          </div>
        </section>
      </main>
      
      <SubscriptionConfirmModal
        isOpen={showConfirmModal}
        onClose={closeConfirmModal}
        selectedPackage={selectedPackage}
      />
      
      <MobileMenu isOpen={isMobileMenuOpen} onClose={() => setIsMobileMenuOpen(false)} />
      <Footer />
    </div>
  );
};

export default SubscriptionPage;