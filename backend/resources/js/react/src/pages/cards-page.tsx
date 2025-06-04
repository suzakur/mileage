import React, { useState } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'wouter';
import { ModernDashboardTopbar } from './dashboard-home-page';
import Footer from '@/components/Footer';
import CreditCardCarousel from '@/components/CreditCardCarousel';

// Credit Card data type
interface CreditCard {
  id: string;
  name: string;
  issuer: string;
  cardNumber: string;
  validThru: string;
  points: number;
  expiringPoints: {
    points: number;
    expiryDate: string;
  }[];
  availableCredit: number;
  totalCredit: number;
  dueDate: string;
  dueAmount: number;
  color: string;
  gradient: string;
  type?: 'standard' | 'premium' | 'business';
}

// Dummy credit card data
const creditCards: CreditCard[] = [
  {
    id: 'card1',
    name: 'Mileage Signature',
    issuer: 'BCA',
    cardNumber: '•••• •••• •••• 1234',
    validThru: '05/28',
    points: 12450,
    expiringPoints: [
      { points: 500, expiryDate: '30 Mei 2025' },
      { points: 1000, expiryDate: '15 Jun 2025' }
    ],
    availableCredit: 24500000,
    totalCredit: 25000000,
    dueDate: '15 Mei 2025',
    dueAmount: 1250000,
    color: 'from-blue-600 to-blue-900',
    gradient: 'from-blue-900/20 to-blue-600/20',
    type: 'premium'
  },
  {
    id: 'card2',
    name: 'Mileage Platinum',
    issuer: 'Mandiri',
    cardNumber: '•••• •••• •••• 5678',
    validThru: '08/26',
    points: 8320,
    expiringPoints: [
      { points: 750, expiryDate: '10 Jun 2025' }
    ],
    availableCredit: 38750000,
    totalCredit: 50000000,
    dueDate: '20 Mei 2025',
    dueAmount: 2780000,
    color: 'from-purple-600 to-purple-900',
    gradient: 'from-purple-900/20 to-purple-600/20',
    type: 'business'
  },
  {
    id: 'card3',
    name: 'Mileage Classic',
    issuer: 'BNI',
    cardNumber: '•••• •••• •••• 9012',
    validThru: '03/27',
    points: 5640,
    expiringPoints: [],
    availableCredit: 9800000,
    totalCredit: 10000000,
    dueDate: '25 Mei 2025',
    dueAmount: 750000,
    color: 'from-gray-700 to-gray-900',
    gradient: 'from-gray-900/20 to-gray-700/20',
    type: 'standard'
  }
];

// Transaction component
interface Transaction {
  id: string;
  date: string;
  merchant: string;
  amount: number;
  category: string;
  cardId: string;
  status: 'pending' | 'completed';
}

// Recent transaction data
const recentTransactions: Transaction[] = [
  {
    id: 'trx1',
    date: '12 Mei 2025',
    merchant: 'Starbucks',
    amount: 85000,
    category: 'Food & Beverage',
    cardId: 'card1',
    status: 'completed'
  },
  {
    id: 'trx2',
    date: '11 Mei 2025',
    merchant: 'Netflix',
    amount: 159000,
    category: 'Entertainment',
    cardId: 'card2',
    status: 'completed'
  },
  {
    id: 'trx3',
    date: '10 Mei 2025',
    merchant: 'Tokopedia',
    amount: 750000,
    category: 'Shopping',
    cardId: 'card3',
    status: 'pending'
  }
];

// Transaction item component
const TransactionItem = ({ transaction }: { transaction: Transaction }) => {
  const card = creditCards.find(c => c.id === transaction.cardId);
  
  return (
    <div className="flex items-center justify-between p-4 hover:bg-foreground/5 transition-colors">
      <div className="flex items-center">
        <div className="w-10 h-10 rounded-full bg-foreground/10 flex items-center justify-center mr-3">
          {transaction.category === 'Food & Beverage' && <i className="ri-restaurant-line"></i>}
          {transaction.category === 'Entertainment' && <i className="ri-film-line"></i>}
          {transaction.category === 'Shopping' && <i className="ri-shopping-bag-line"></i>}
          {transaction.category === 'Transportation' && <i className="ri-car-line"></i>}
          {transaction.category === 'Utilities' && <i className="ri-lightbulb-line"></i>}
        </div>
        <div>
          <div className="font-medium">{transaction.merchant}</div>
          <div className="text-xs text-muted-foreground flex items-center">
            <span>{transaction.date}</span>
            <span className="mx-1">•</span>
            <span>{transaction.category}</span>
          </div>
        </div>
      </div>
      <div className="text-right">
        <div className="font-medium">Rp {transaction.amount.toLocaleString()}</div>
        <div className="text-xs flex items-center justify-end">
          <div className={`h-2 w-2 rounded-full mr-1 ${
            transaction.status === 'completed' ? 'bg-green-500' : 'bg-yellow-500'
          }`}></div>
          <span className="text-muted-foreground">
            {transaction.status === 'completed' ? 'Selesai' : 'Tertunda'}
          </span>
        </div>
      </div>
    </div>
  );
};

// Bill component
interface Bill {
  id: string;
  title: string;
  dueDate: string;
  amount: number;
  isPaid: boolean;
  cardId: string;
  iconClass: string;
  category: string;
}

// Bills data
const bills: Bill[] = [
  {
    id: 'bill1',
    title: 'Netflix Premium',
    dueDate: '15 Mei 2025',
    amount: 159000,
    isPaid: false,
    cardId: 'card1',
    iconClass: 'ri-netflix-fill',
    category: 'Entertainment'
  },
  {
    id: 'bill2',
    title: 'Spotify Family',
    dueDate: '20 Mei 2025',
    amount: 89000,
    isPaid: false,
    cardId: 'card2',
    iconClass: 'ri-spotify-fill',
    category: 'Entertainment'
  },
  {
    id: 'bill3',
    title: 'Tagihan Listrik',
    dueDate: '25 Mei 2025',
    amount: 450000,
    isPaid: false,
    cardId: 'card3',
    iconClass: 'ri-lightbulb-line',
    category: 'Utilities'
  }
];

// Bill item component
const BillItem = ({ bill }: { bill: Bill }) => {
  const card = creditCards.find(c => c.id === bill.cardId);
  
  return (
    <div className="flex items-center justify-between p-4 hover:bg-foreground/5 transition-colors">
      <div className="flex items-center">
        <div className="w-10 h-10 rounded-full bg-foreground/10 flex items-center justify-center mr-3">
          <i className={bill.iconClass}></i>
        </div>
        <div>
          <div className="font-medium">{bill.title}</div>
          <div className="text-xs text-muted-foreground flex items-center">
            <span>Jatuh tempo: {bill.dueDate}</span>
            <span className="mx-1">•</span>
            <span>{card?.name}</span>
          </div>
        </div>
      </div>
      <div className="text-right">
        <div className="font-medium">Rp {bill.amount.toLocaleString()}</div>
        <div>
          {bill.isPaid ? (
            <span className="text-xs px-2 py-1 bg-green-100 text-green-800 rounded-full">Dibayar</span>
          ) : (
            <button className="text-xs px-2 py-1 bg-blue-100 text-blue-800 rounded-full hover:bg-blue-200 transition-colors">
              Bayar
            </button>
          )}
        </div>
      </div>
    </div>
  );
};

// Add card form
const AddCardForm = ({ onClose }: { onClose: () => void }) => {
  return (
    <div className="bg-background border border-border rounded-xl p-6">
      <div className="flex justify-between items-center mb-6">
        <h3 className="text-lg font-bold">Tambah Kartu Baru</h3>
        <button onClick={onClose} className="text-lg text-muted-foreground hover:text-foreground">
          <i className="ri-close-line"></i>
        </button>
      </div>
      
      <div className="space-y-4">
        <div>
          <label className="block text-sm font-medium mb-1">Jenis Kartu</label>
          <select className="w-full p-2 border border-border rounded-lg bg-background">
            <option>Visa</option>
            <option>Mastercard</option>
            <option>American Express</option>
            <option>JCB</option>
          </select>
        </div>
        
        <div>
          <label className="block text-sm font-medium mb-1">Bank Penerbit</label>
          <select className="w-full p-2 border border-border rounded-lg bg-background">
            <option>BCA</option>
            <option>Mandiri</option>
            <option>BNI</option>
            <option>BRI</option>
            <option>CIMB Niaga</option>
          </select>
        </div>
        
        <div>
          <label className="block text-sm font-medium mb-1">Nomor Kartu</label>
          <input type="text" placeholder="**** **** **** ****" className="w-full p-2 border border-border rounded-lg bg-background" />
        </div>
        
        <div className="grid grid-cols-2 gap-4">
          <div>
            <label className="block text-sm font-medium mb-1">Tanggal Berlaku</label>
            <input type="text" placeholder="MM/YY" className="w-full p-2 border border-border rounded-lg bg-background" />
          </div>
          <div>
            <label className="block text-sm font-medium mb-1">CVV</label>
            <input type="text" placeholder="***" className="w-full p-2 border border-border rounded-lg bg-background" />
          </div>
        </div>
        
        <div>
          <label className="block text-sm font-medium mb-1">Limit Kartu</label>
          <input type="text" placeholder="Rp" className="w-full p-2 border border-border rounded-lg bg-background" />
        </div>
        
        <div className="pt-4">
          <button className="w-full py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            Tambah Kartu
          </button>
        </div>
      </div>
    </div>
  );
};

// Main cards page component
const CardsPage: React.FC = () => {
  const [currentCard, setCurrentCard] = useState<CreditCard>(creditCards[0]);
  const [showAddCard, setShowAddCard] = useState(false);
  
  const handleCardChange = (card: CreditCard) => {
    setCurrentCard(card);
  };
  
  return (
    <div className="min-h-screen bg-background">
      <ModernDashboardTopbar />
      
      <main className="py-6 px-4 lg:px-8 pb-20">
        <div className="max-w-7xl mx-auto">
          <div className="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8">
            <div>
              <h1 className="text-2xl lg:text-3xl font-bold font-display mb-1">Kartu Kredit Anda</h1>
              <p className="text-muted-foreground">Kelola semua kartu kredit Anda dalam satu tampilan</p>
            </div>
            
            <div className="mt-4 lg:mt-0 flex space-x-2">
              <button 
                className="flex items-center space-x-2 px-3 py-2 rounded-lg border border-border hover:bg-foreground/5 transition-colors"
                onClick={() => window.print()}
              >
                <i className="ri-download-line"></i>
                <span>Ekspor Ringkasan</span>
              </button>
              <Link href="/compare-cards">
                <div className="flex items-center space-x-2 px-3 py-2 rounded-lg border border-blue-600 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors cursor-pointer">
                  <i className="ri-scales-line"></i>
                  <span>Bandingkan Kartu</span>
                </div>
              </Link>
              <button 
                className="flex items-center space-x-2 px-3 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors"
                onClick={() => setShowAddCard(true)}
              >
                <i className="ri-add-line"></i>
                <span>Tambah Kartu</span>
              </button>
            </div>
          </div>
          
          {/* Dashboard Content */}
          <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {/* Left Column - Card Carousel */}
            <div className="lg:col-span-2 space-y-6">
              {/* Credit Card Carousel */}
              <div className="bg-background border border-border rounded-xl overflow-hidden">
                <div className="flex items-center justify-between p-6 border-b border-border">
                  <h2 className="font-display font-bold text-lg">Kartu Kredit Anda</h2>
                  <div className="flex space-x-1">
                    <button className="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-foreground/5">
                      <i className="ri-refresh-line"></i>
                    </button>
                    <button className="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-foreground/5">
                      <i className="ri-more-2-fill"></i>
                    </button>
                  </div>
                </div>
                
                <div className="p-6">
                  <CreditCardCarousel 
                    cards={creditCards} 
                    onCardChange={handleCardChange}
                  />
                </div>
              </div>
              
              {/* Card Details */}
              <div className="bg-background border border-border rounded-xl overflow-hidden">
                <div className="flex items-center justify-between p-6 border-b border-border">
                  <h2 className="font-display font-bold text-lg">Detail Kartu</h2>
                  <button className="flex items-center space-x-1 text-sm text-blue-600 hover:text-blue-700">
                    <span>Lihat Semua</span>
                    <i className="ri-arrow-right-s-line"></i>
                  </button>
                </div>
                
                <div className="p-6">
                  <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div className="bg-foreground/5 p-4 rounded-xl">
                      <div className="text-sm text-muted-foreground mb-1">Limit Kredit</div>
                      <div className="text-xl font-bold">Rp {currentCard.totalCredit.toLocaleString()}</div>
                      <div className="mt-3">
                        <div className="flex justify-between text-sm mb-1">
                          <span>Terpakai</span>
                          <span>{Math.round((1 - currentCard.availableCredit / currentCard.totalCredit) * 100)}%</span>
                        </div>
                        <div className="w-full bg-foreground/10 rounded-full h-2">
                          <div 
                            className="bg-blue-600 h-2 rounded-full" 
                            style={{ width: `${Math.round((1 - currentCard.availableCredit / currentCard.totalCredit) * 100)}%` }}
                          ></div>
                        </div>
                      </div>
                    </div>
                    
                    <div className="bg-foreground/5 p-4 rounded-xl">
                      <div className="text-sm text-muted-foreground mb-1">Saldo Tersedia</div>
                      <div className="text-xl font-bold">Rp {currentCard.availableCredit.toLocaleString()}</div>
                      <div className="mt-2 text-sm flex items-center">
                        <i className="ri-information-line mr-1 text-muted-foreground"></i>
                        <span className="text-muted-foreground">Terakhir diperbarui: 13 Mei 2025</span>
                      </div>
                    </div>
                    
                    <div className="bg-foreground/5 p-4 rounded-xl">
                      <div className="text-sm text-muted-foreground mb-1">Poin Reward</div>
                      <div className="text-xl font-bold">{currentCard.points.toLocaleString()}</div>
                      <div className="mt-2">
                        {currentCard.expiringPoints.length > 0 ? (
                          <div className="text-sm text-amber-600 flex items-center">
                            <i className="ri-alarm-warning-line mr-1"></i>
                            <span>{currentCard.expiringPoints[0].points} poin kedaluwarsa {currentCard.expiringPoints[0].expiryDate}</span>
                          </div>
                        ) : (
                          <div className="text-sm text-muted-foreground">
                            Tidak ada poin yang akan kedaluwarsa
                          </div>
                        )}
                      </div>
                    </div>
                  </div>
                  
                  <div className="mt-6 border-t border-border pt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                      <h3 className="text-lg font-medium mb-4">Tagihan Saat Ini</h3>
                      <div className="bg-foreground/5 p-4 rounded-xl">
                        <div className="flex justify-between mb-2">
                          <span className="text-muted-foreground">Jumlah Tagihan</span>
                          <span className="font-medium">Rp {currentCard.dueAmount.toLocaleString()}</span>
                        </div>
                        <div className="flex justify-between mb-2">
                          <span className="text-muted-foreground">Jatuh Tempo</span>
                          <span className="font-medium">{currentCard.dueDate}</span>
                        </div>
                        <div className="flex justify-between mb-4">
                          <span className="text-muted-foreground">Minimum Pembayaran</span>
                          <span className="font-medium">Rp {Math.round(currentCard.dueAmount * 0.1).toLocaleString()}</span>
                        </div>
                        
                        <button className="w-full py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center">
                          <i className="ri-bank-line mr-1.5"></i>
                          <span>Bayar Tagihan</span>
                        </button>
                      </div>
                    </div>
                    
                    <div>
                      <h3 className="text-lg font-medium mb-4">Transaksi Terbaru</h3>
                      <div className="bg-foreground/5 rounded-xl max-h-48 overflow-y-auto">
                        {recentTransactions
                          .filter(t => t.cardId === currentCard.id)
                          .map(transaction => (
                            <TransactionItem key={transaction.id} transaction={transaction} />
                          ))}
                          
                        {recentTransactions.filter(t => t.cardId === currentCard.id).length === 0 && (
                          <div className="p-4 text-center text-muted-foreground">
                            Tidak ada transaksi terbaru
                          </div>
                        )}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            {/* Right Column - Info and Actions */}
            <div className="space-y-6">
              {/* Card Actions */}
              <div className="bg-background border border-border rounded-xl overflow-hidden">
                <div className="p-6 border-b border-border">
                  <h2 className="font-display font-bold text-lg">Aksi Cepat</h2>
                </div>
                <div className="p-4">
                  <div className="grid grid-cols-2 gap-4">
                    <button className="flex flex-col items-center justify-center p-4 rounded-xl hover:bg-foreground/5 transition-colors">
                      <div className="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mb-2">
                        <i className="ri-lock-line"></i>
                      </div>
                      <span className="text-sm font-medium">Block Kartu</span>
                    </button>
                    
                    <button className="flex flex-col items-center justify-center p-4 rounded-xl hover:bg-foreground/5 transition-colors">
                      <div className="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 mb-2">
                        <i className="ri-bank-line"></i>
                      </div>
                      <span className="text-sm font-medium">Bayar Tagihan</span>
                    </button>
                    
                    <button className="flex flex-col items-center justify-center p-4 rounded-xl hover:bg-foreground/5 transition-colors">
                      <div className="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 mb-2">
                        <i className="ri-exchange-line"></i>
                      </div>
                      <span className="text-sm font-medium">Tukar Poin</span>
                    </button>
                    
                    <button className="flex flex-col items-center justify-center p-4 rounded-xl hover:bg-foreground/5 transition-colors">
                      <div className="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 mb-2">
                        <i className="ri-secure-payment-line"></i>
                      </div>
                      <span className="text-sm font-medium">Cicilan</span>
                    </button>
                  </div>
                </div>
              </div>
              
              {/* Upcoming Bills */}
              <div className="bg-background border border-border rounded-xl overflow-hidden">
                <div className="flex items-center justify-between p-6 border-b border-border">
                  <h2 className="font-display font-bold text-lg">Tagihan Mendatang</h2>
                  <button className="flex items-center space-x-1 text-sm text-blue-600 hover:text-blue-700">
                    <span>Lihat Semua</span>
                    <i className="ri-arrow-right-s-line"></i>
                  </button>
                </div>
                
                <div className="divide-y divide-border">
                  {bills
                    .filter(bill => bill.cardId === currentCard.id)
                    .map(bill => (
                      <BillItem key={bill.id} bill={bill} />
                    ))}
                    
                  {bills.filter(bill => bill.cardId === currentCard.id).length === 0 && (
                    <div className="p-4 text-center text-muted-foreground">
                      Tidak ada tagihan mendatang
                    </div>
                  )}
                </div>
              </div>
              
              {/* Promo Cards */}
              <div className="bg-gradient-to-br from-blue-600 to-blue-800 rounded-xl overflow-hidden text-white p-6">
                <div className="flex justify-between items-start mb-4">
                  <div>
                    <h3 className="text-lg font-medium mb-1">Hemat Hingga 15%</h3>
                    <p className="text-white/80 text-sm">Bayar tagihan dengan cicilan 0%</p>
                  </div>
                  <div className="bg-white/20 p-2 rounded-lg">
                    <i className="ri-percent-line text-lg"></i>
                  </div>
                </div>
                <button className="mt-2 py-2 px-4 bg-white/20 backdrop-blur-sm rounded-lg hover:bg-white/30 transition-colors text-sm font-medium">
                  Lihat Detail
                </button>
              </div>
              
              <div className="bg-gradient-to-br from-purple-600 to-purple-800 rounded-xl overflow-hidden text-white p-6">
                <div className="flex justify-between items-start mb-4">
                  <div>
                    <h3 className="text-lg font-medium mb-1">Upgrade Kartu Anda</h3>
                    <p className="text-white/80 text-sm">Nikmati limit lebih tinggi & benefit premium</p>
                  </div>
                  <div className="bg-white/20 p-2 rounded-lg">
                    <i className="ri-arrow-up-line text-lg"></i>
                  </div>
                </div>
                <button className="mt-2 py-2 px-4 bg-white/20 backdrop-blur-sm rounded-lg hover:bg-white/30 transition-colors text-sm font-medium">
                  Ajukan Sekarang
                </button>
              </div>
            </div>
          </div>
          
          {/* Add Card Modal */}
          {showAddCard && (
            <div className="fixed inset-0 flex items-center justify-center bg-black/50 z-50 p-4">
              <motion.div
                initial={{ opacity: 0, scale: 0.9 }}
                animate={{ opacity: 1, scale: 1 }}
                exit={{ opacity: 0, scale: 0.9 }}
                className="w-full max-w-md"
              >
                <AddCardForm onClose={() => setShowAddCard(false)} />
              </motion.div>
            </div>
          )}
        </div>
      </main>
      
      <Footer />
    </div>
  );
};

export default CardsPage;