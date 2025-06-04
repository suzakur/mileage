import React, { useState } from 'react';
import { motion } from 'framer-motion';
import { Link, useLocation } from 'wouter';
import Header from '@/components/Header';
import Footer from '@/components/Footer';
import MobileMenu from '@/components/MobileMenu';
import CreditCardCarousel from '@/components/CreditCardCarousel';

// Tipe data untuk informasi kartu kredit
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

// Tipe data untuk transaksi
interface Transaction {
  id: string;
  date: string;
  merchant: string;
  amount: number;
  category: string;
  cardId: string;
  status: 'pending' | 'completed';
}

// Tipe data untuk kategori pengeluaran
interface SpendingCategory {
  category: string;
  amount: number;
  percentage: number;
  color: string;
  icon: string;
}

// Tipe data untuk spending challenge
interface SpendingChallenge {
  id: string;
  title: string;
  description: string;
  target: number;
  current: number;
  deadline: string;
  category: string;
  reward: string;
  status: 'in-progress' | 'completed' | 'failed';
}

// Tipe data untuk calendar events
interface CalendarEvent {
  id: string;
  title: string;
  date: string;
  type: 'due-date' | 'expiry' | 'challenge' | 'promo';
  cardId?: string;
  color: string;
  icon: string;
}

// Data dummy untuk kartu kredit
const creditCards: CreditCard[] = [
  {
    id: 'card1',
    name: 'Visa Signature',
    issuer: 'BCA',
    cardNumber: '4388 •••• •••• 1234',
    validThru: '12/25',
    points: 12750,
    expiringPoints: [
      { points: 2500, expiryDate: '20 Jun 2025' },
      { points: 1800, expiryDate: '15 Jul 2025' }
    ],
    availableCredit: 28500000,
    totalCredit: 30000000,
    dueDate: '15 Mei 2025',
    dueAmount: 1500000,
    color: 'from-blue-600 to-blue-900',
    gradient: 'from-blue-900/20 to-blue-600/20'
  },
  {
    id: 'card2',
    name: 'World Elite',
    issuer: 'Mandiri',
    cardNumber: '5412 •••• •••• 5678',
    validThru: '08/26',
    points: 8320,
    expiringPoints: [
      { points: 1200, expiryDate: '30 Jun 2025' }
    ],
    availableCredit: 19800000,
    totalCredit: 25000000,
    dueDate: '20 Mei 2025',
    dueAmount: 2350000,
    color: 'from-green-600 to-cyan-800',
    gradient: 'from-green-900/20 to-cyan-700/20'
  },
  {
    id: 'card3',
    name: 'JCB Platinum',
    issuer: 'BNI',
    cardNumber: '3566 •••• •••• 9012',
    validThru: '03/25',
    points: 5680,
    expiringPoints: [
      { points: 800, expiryDate: '10 Jun 2025' }
    ],
    availableCredit: 9750000,
    totalCredit: 10000000,
    dueDate: '28 Mei 2025',
    dueAmount: 250000,
    color: 'from-fuchsia-600 to-purple-900',
    gradient: 'from-fuchsia-900/20 to-purple-600/20'
  }
];

// Data dummy untuk transaksi
const transactions: Transaction[] = [
  {
    id: 'trx1',
    date: '13 Mei 2025',
    merchant: 'Tokopedia',
    amount: 850000,
    category: 'Shopping',
    cardId: 'card1',
    status: 'completed'
  },
  {
    id: 'trx2',
    date: '12 Mei 2025',
    merchant: 'Starbucks',
    amount: 68000,
    category: 'Food & Beverage',
    cardId: 'card3',
    status: 'completed'
  },
  {
    id: 'trx3',
    date: '11 Mei 2025',
    merchant: 'Netflix',
    amount: 169000,
    category: 'Entertainment',
    cardId: 'card2',
    status: 'completed'
  },
  {
    id: 'trx4',
    date: '10 Mei 2025',
    merchant: 'Shell',
    amount: 350000,
    category: 'Transportation',
    cardId: 'card1',
    status: 'completed'
  },
  {
    id: 'trx5',
    date: '09 Mei 2025',
    merchant: 'Shopee',
    amount: 520000,
    category: 'Shopping',
    cardId: 'card2',
    status: 'completed'
  },
  {
    id: 'trx6',
    date: '08 Mei 2025',
    merchant: 'PLN',
    amount: 450000,
    category: 'Utilities',
    cardId: 'card3',
    status: 'completed'
  },
  {
    id: 'trx7',
    date: '07 Mei 2025',
    merchant: 'Pizza Hut',
    amount: 230000,
    category: 'Food & Beverage',
    cardId: 'card1',
    status: 'completed'
  }
];

// Data dummy untuk spending challenges
const spendingChallenges: SpendingChallenge[] = [
  {
    id: 'chl1',
    title: 'Kurangi Belanja Online',
    description: 'Batasi belanja online maksimal Rp 1 juta dalam bulan ini',
    target: 1000000,
    current: 850000,
    deadline: '31 Mei 2025',
    category: 'Shopping',
    reward: '2x Points',
    status: 'in-progress'
  },
  {
    id: 'chl2',
    title: 'Makan Hemat',
    description: 'Kurangi pengeluaran makanan hingga di bawah Rp 500 ribu',
    target: 500000,
    current: 298000,
    deadline: '31 Mei 2025',
    category: 'Food & Beverage',
    reward: 'Cashback 5%',
    status: 'in-progress'
  },
  {
    id: 'chl3',
    title: 'Tantangan Transportasi',
    description: 'Gunakan transportasi umum 3x minggu ini',
    target: 3,
    current: 1,
    deadline: '20 Mei 2025',
    category: 'Transportation',
    reward: '500 Poin Ekstra',
    status: 'in-progress'
  }
];

// Data dummy untuk calendar events
const generateCalendarEvents = (): CalendarEvent[] => {
  const events: CalendarEvent[] = [];
  
  // Due date events
  creditCards.forEach(card => {
    events.push({
      id: `due-${card.id}`,
      title: `Jatuh Tempo ${card.issuer} ${card.name}`,
      date: card.dueDate,
      type: 'due-date',
      cardId: card.id,
      color: 'bg-red-500',
      icon: 'ri-calendar-check-line'
    });
  });
  
  // Expiry events
  creditCards.forEach(card => {
    card.expiringPoints.forEach((exp, index) => {
      events.push({
        id: `exp-${card.id}-${index}`,
        title: `${exp.points} Poin ${card.issuer} Kedaluwarsa`,
        date: exp.expiryDate,
        type: 'expiry',
        cardId: card.id,
        color: 'bg-yellow-500',
        icon: 'ri-timer-flash-line'
      });
    });
  });
  
  // Challenge deadlines
  spendingChallenges.forEach(challenge => {
    events.push({
      id: `challenge-${challenge.id}`,
      title: `Deadline: ${challenge.title}`,
      date: challenge.deadline,
      type: 'challenge',
      color: 'bg-blue-500',
      icon: 'ri-award-line'
    });
  });
  
  // Promo expirations
  events.push({
    id: 'promo-1',
    title: 'Cashback 10% Garuda Berakhir',
    date: '30 Jun 2025',
    type: 'promo',
    color: 'bg-purple-500',
    icon: 'ri-percent-line'
  });
  
  events.push({
    id: 'promo-2',
    title: 'Diskon 15% Traveloka Berakhir',
    date: '15 Jun 2025',
    type: 'promo',
    color: 'bg-purple-500',
    icon: 'ri-percent-line'
  });
  
  return events;
};

const calendarEvents = generateCalendarEvents();

// Menghitung data kategori pengeluaran dari transaksi
const calculateSpendingCategories = (): SpendingCategory[] => {
  const categoryMap = new Map<string, number>();
  
  // Menghitung total per kategori
  transactions.forEach(tx => {
    const current = categoryMap.get(tx.category) || 0;
    categoryMap.set(tx.category, current + tx.amount);
  });
  
  // Menghitung total keseluruhan
  const totalSpending = Array.from(categoryMap.values()).reduce((sum, amount) => sum + amount, 0);
  
  // Membuat array SpendingCategory
  const result: SpendingCategory[] = Array.from(categoryMap.entries())
    .map(([category, amount]) => {
      let color = '';
      let icon = 'ri-shopping-bag-line';
      
      switch(category) {
        case 'Food & Beverage':
          color = '#FF6B6B'; // Merah
          icon = 'ri-restaurant-line';
          break;
        case 'Entertainment':
          color = '#8A6FE8'; // Ungu
          icon = 'ri-film-line';
          break;
        case 'Transportation':
          color = '#59CE8F'; // Hijau
          icon = 'ri-gas-station-line';
          break;
        case 'Utilities':
          color = '#FFAB4C'; // Oranye
          icon = 'ri-lightbulb-line';
          break;
        case 'Shopping':
          color = '#4C94FF'; // Biru
          icon = 'ri-shopping-bag-line';
          break;
        default:
          color = '#BFBFBF'; // Abu-abu
          break;
      }
      
      return {
        category,
        amount,
        percentage: (amount / totalSpending) * 100,
        color,
        icon
      };
    })
    .sort((a, b) => b.amount - a.amount);
  
  return result;
};

const spendingCategories = calculateSpendingCategories();

// Komponen untuk modern pie chart dengan animasi dan interaktivitas
const ModernPieChart = ({ categories }: { categories: SpendingCategory[] }) => {
  const [hoveredCategory, setHoveredCategory] = useState<string | null>(null);
  const totalAmount = categories.reduce((sum, cat) => sum + cat.amount, 0);
  
  // Custom colors for modern look
  const getTextColor = (category: SpendingCategory) => {
    return hoveredCategory === category.category ? 'text-white' : 'text-foreground';
  };
  
  // Radius of pie chart
  const radius = 80;
  const centerX = 100;
  const centerY = 100;
  const chartSize = 200;
  
  // Calculate the segments of the pie chart
  const segments = categories.map((category, index) => {
    const startAngle = categories
      .slice(0, index)
      .reduce((acc, cat) => acc + (cat.percentage / 100) * 2 * Math.PI, 0);
    const endAngle = startAngle + (category.percentage / 100) * 2 * Math.PI;
    
    // Calculate SVG path for the segment
    const startX = centerX + radius * Math.cos(startAngle);
    const startY = centerY + radius * Math.sin(startAngle);
    const endX = centerX + radius * Math.cos(endAngle);
    const endY = centerY + radius * Math.sin(endAngle);
    
    // Determine if the arc should be drawn as a large arc (more than 180 degrees)
    const largeArcFlag = endAngle - startAngle > Math.PI ? 1 : 0;
    
    // SVG path for the segment
    const path = `M ${centerX} ${centerY} L ${startX} ${startY} A ${radius} ${radius} 0 ${largeArcFlag} 1 ${endX} ${endY} Z`;
    
    // Hover effect with scale transformation
    const isHovered = hoveredCategory === category.category;
    const hoverOffset = isHovered ? 10 : 0;
    
    // Calculate the center point of the segment for the hover transformation
    const midAngle = startAngle + (endAngle - startAngle) / 2;
    const translateX = hoverOffset * Math.cos(midAngle);
    const translateY = hoverOffset * Math.sin(midAngle);
    
    return (
      <motion.path
        key={category.category}
        d={path}
        fill={category.color}
        strokeWidth={isHovered ? 2 : 0}
        stroke="#FFF"
        initial={{ scale: 0.9, opacity: 0 }}
        animate={{
          scale: 1, 
          opacity: 1,
          translateX: translateX,
          translateY: translateY
        }}
        transition={{ duration: 0.5, delay: index * 0.1 }}
        onMouseEnter={() => setHoveredCategory(category.category)}
        onMouseLeave={() => setHoveredCategory(null)}
        whileHover={{ scale: 1.05 }}
        style={{ transformOrigin: `${centerX}px ${centerY}px` }}
        className="cursor-pointer transition-all duration-300 filter drop-shadow-sm hover:drop-shadow-md"
      />
    );
  });
  
  return (
    <div className="flex flex-col items-center">
      <div className="relative w-full max-w-[300px] mx-auto">
        <svg viewBox="0 0 200 200" width="100%" height="100%">
          {segments}
          
          {/* Center circle with total amount */}
          <motion.circle
            cx={centerX}
            cy={centerY}
            r={radius * 0.5}
            fill="white"
            className="drop-shadow-sm"
            initial={{ scale: 0 }}
            animate={{ scale: 1 }}
            transition={{ duration: 0.5, delay: categories.length * 0.1 }}
          />
          
          {/* Decorative ring */}
          <motion.circle
            cx={centerX}
            cy={centerY}
            r={radius * 0.52}
            fill="none"
            stroke="#e5e7eb"
            strokeWidth="1"
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            transition={{ duration: 0.5, delay: categories.length * 0.1 + 0.2 }}
          />
        </svg>
        
        {/* Center text */}
        <div className="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
          <motion.div 
            className="text-xs text-muted-foreground"
            initial={{ opacity: 0, y: 10 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.5, delay: categories.length * 0.1 + 0.3 }}
          >
            Total Pengeluaran
          </motion.div>
          <motion.div 
            className="font-bold text-lg"
            initial={{ opacity: 0, scale: 0.8 }}
            animate={{ opacity: 1, scale: 1 }}
            transition={{ duration: 0.5, delay: categories.length * 0.1 + 0.4 }}
          >
            Rp {totalAmount.toLocaleString()}
          </motion.div>
        </div>
      </div>
      
      {/* Modern Legend */}
      <div className="grid grid-cols-2 gap-2 mt-6 w-full">
        {categories.map((category, index) => (
          <motion.div
            key={category.category}
            className={`flex items-center p-2 rounded-lg cursor-pointer transition-all
              ${hoveredCategory === category.category ? 'bg-foreground/10' : 'hover:bg-foreground/5'}`}
            initial={{ opacity: 0, x: -10 }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.3, delay: index * 0.1 }}
            onMouseEnter={() => setHoveredCategory(category.category)}
            onMouseLeave={() => setHoveredCategory(null)}
          >
            <div className="flex items-center space-x-3 flex-1">
              <div 
                className="w-3 h-3 rounded-sm transform rotate-45" 
                style={{ backgroundColor: category.color }}
              ></div>
              <div className="flex-1 min-w-0">
                <div className="text-sm font-medium truncate">
                  {category.category}
                </div>
              </div>
            </div>
            <div className="text-right">
              <div className="text-sm font-medium">
                {category.percentage.toFixed(1)}%
              </div>
              <div className="text-xs text-muted-foreground">
                Rp {category.amount.toLocaleString()}
              </div>
            </div>
          </motion.div>
        ))}
      </div>
    </div>
  );
};

// Komponen untuk menampilkan kartu kredit
const CreditCardItem = ({ card }: { card: CreditCard }) => {
  return (
    <motion.div
      className={`bg-gradient-to-br ${card.color} rounded-2xl p-6 text-white relative overflow-hidden`}
      initial={{ opacity: 0, y: 20 }}
      animate={{ opacity: 1, y: 0 }}
      transition={{ duration: 0.5 }}
      whileHover={{ scale: 1.03 }}
    >
      <div className={`absolute inset-0 bg-gradient-to-br ${card.gradient} opacity-30`}></div>
      <div className="relative z-10">
        <div className="flex justify-between items-start mb-6">
          <div>
            <div className="text-white/70 text-xs uppercase mb-1">Kartu</div>
            <div className="font-medium">{card.issuer} {card.name}</div>
          </div>
          <div className="h-10 w-10">
            {card.issuer === 'BCA' && <i className="ri-visa-line text-2xl"></i>}
            {card.issuer === 'Mandiri' && <i className="ri-mastercard-line text-2xl"></i>}
            {card.issuer === 'BNI' && <i className="ri-bank-card-line text-2xl"></i>}
          </div>
        </div>
        
        <div className="mb-4">
          <div className="text-white/70 text-xs uppercase mb-1">Nomor Kartu</div>
          <div className="font-mono">{card.cardNumber}</div>
        </div>
        
        <div className="flex justify-between mb-3">
          <div>
            <div className="text-white/70 text-xs uppercase mb-1">Valid Thru</div>
            <div className="font-mono">{card.validThru}</div>
          </div>
          <div>
            <div className="text-white/70 text-xs uppercase mb-1">Poin Reward</div>
            <div className="font-medium">{card.points.toLocaleString()}</div>
          </div>
        </div>
        
        {/* Expiring Points */}
        {card.expiringPoints.length > 0 && (
          <div className="mb-4 p-2 bg-white/10 rounded-lg">
            <div className="text-white/90 text-xs font-medium mb-2">Poin Segera Hangus:</div>
            {card.expiringPoints.map((item, index) => (
              <div key={index} className="flex justify-between items-center text-xs mb-1 last:mb-0">
                <div className="flex items-center">
                  <i className="ri-alarm-warning-line mr-1 text-yellow-300"></i>
                  <span>{item.points.toLocaleString()} poin</span>
                </div>
                <div className="text-yellow-300">{item.expiryDate}</div>
              </div>
            ))}
          </div>
        )}
        
        <div className="bg-white/10 rounded-lg p-3 mb-4">
          <div className="flex justify-between mb-1">
            <div className="text-xs">Limit Tersedia</div>
            <div className="text-sm font-medium">Rp {card.availableCredit.toLocaleString()}</div>
          </div>
          <div className="w-full bg-white/20 rounded-full h-1.5">
            <div 
              className="bg-white h-1.5 rounded-full" 
              style={{ width: `${(card.availableCredit / card.totalCredit) * 100}%` }}
            ></div>
          </div>
        </div>
        
        <div className="bg-white/10 rounded-lg p-3">
          <div className="flex justify-between items-center">
            <div>
              <div className="text-xs">Jatuh Tempo</div>
              <div className="text-sm font-medium">{card.dueDate}</div>
            </div>
            <div className="text-right">
              <div className="text-xs">Tagihan</div>
              <div className="text-sm font-medium">Rp {card.dueAmount.toLocaleString()}</div>
            </div>
          </div>
        </div>
      </div>
    </motion.div>
  );
};

// Komponen untuk menampilkan transaksi
const TransactionItem = ({ transaction }: { transaction: Transaction }) => {
  // Mendapatkan kartu berdasarkan cardId
  const card = creditCards.find(card => card.id === transaction.cardId);
  
  return (
    <motion.div 
      className="flex items-center p-4 border-b border-border hover:bg-foreground/5 transition-colors rounded-lg"
      initial={{ opacity: 0 }}
      animate={{ opacity: 1 }}
      whileHover={{ x: 3 }}
    >
      <div className="flex-shrink-0 w-10 h-10 rounded-full bg-gradient-to-br from-blue-500/20 to-indigo-500/20 flex items-center justify-center text-blue-500 mr-4">
        {transaction.category === 'Shopping' && <i className="ri-shopping-bag-line"></i>}
        {transaction.category === 'Food & Beverage' && <i className="ri-restaurant-line"></i>}
        {transaction.category === 'Entertainment' && <i className="ri-film-line"></i>}
        {transaction.category === 'Transportation' && <i className="ri-gas-station-line"></i>}
        {transaction.category === 'Utilities' && <i className="ri-lightbulb-line"></i>}
      </div>
      
      <div className="flex-grow">
        <div className="flex justify-between items-start">
          <div>
            <div className="font-medium text-foreground">{transaction.merchant}</div>
            <div className="text-xs text-muted-foreground flex items-center">
              <span>{transaction.date}</span>
              <span className="mx-1">•</span>
              <span>{card?.issuer} {card?.name.split(' ')[0]}</span>
            </div>
          </div>
          <div className="text-right">
            <div className="font-medium text-foreground">Rp {transaction.amount.toLocaleString()}</div>
            <div className="text-xs text-muted-foreground">{transaction.category}</div>
          </div>
        </div>
      </div>
    </motion.div>
  );
};

// Komponen untuk menampilkan challenge
const SpendingChallengeItem = ({ challenge }: { challenge: SpendingChallenge }) => {
  // Progress calculation
  const progress = (challenge.current / challenge.target) * 100;
  const isCountBased = Number.isInteger(challenge.target) && challenge.target < 100;
  
  return (
    <motion.div 
      className="p-4 border border-border rounded-xl bg-background hover:shadow-md transition-shadow"
      initial={{ opacity: 0, y: 10 }}
      animate={{ opacity: 1, y: 0 }}
      whileHover={{ y: -2 }}
    >
      <div className="flex items-start gap-3 mb-3">
        <div className="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
          <i className="ri-award-line"></i>
        </div>
        <div>
          <h3 className="font-medium text-foreground">{challenge.title}</h3>
          <p className="text-sm text-muted-foreground">{challenge.description}</p>
        </div>
      </div>
      
      <div className="mb-3">
        <div className="flex justify-between text-sm mb-1">
          <div className="text-muted-foreground">
            {isCountBased ? `${challenge.current}/${challenge.target} kali` : 
              `Rp ${challenge.current.toLocaleString()} / Rp ${challenge.target.toLocaleString()}`}
          </div>
          <div className="text-blue-600 font-medium">{Math.min(Math.round(progress), 100)}%</div>
        </div>
        <div className="w-full bg-border/50 rounded-full h-2">
          <div 
            className="bg-blue-600 h-2 rounded-full" 
            style={{ width: `${Math.min(progress, 100)}%` }}
          ></div>
        </div>
      </div>
      
      <div className="flex justify-between items-center text-xs">
        <div className="flex items-center text-muted-foreground">
          <i className="ri-calendar-line mr-1"></i>
          <span>Deadline: {challenge.deadline}</span>
        </div>
        <div className="bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full">
          Reward: {challenge.reward}
        </div>
      </div>
    </motion.div>
  );
};

// Komponen untuk menampilkan calendar
const CalendarWidget = ({ events }: { events: CalendarEvent[] }) => {
  // Mendapatkan bulan saat ini
  const currentDate = new Date();
  const currentMonth = currentDate.getMonth();
  const currentYear = currentDate.getFullYear();
  
  // Nama bulan
  const monthNames = [
    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
  ];
  
  // Hari dalam seminggu
  const dayNames = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
  
  // Mendapatkan jumlah hari dalam bulan
  const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
  
  // Mendapatkan hari pertama dalam bulan (0 = Minggu, 1 = Senin, dst)
  const firstDayOfMonth = new Date(currentYear, currentMonth, 1).getDay();
  
  // Membuat array untuk calendar grid
  const calendarDays = [];
  let dayCounter = 1;
  
  // Mengisi array dengan blank days untuk hari sebelum bulan dimulai
  for (let i = 0; i < firstDayOfMonth; i++) {
    calendarDays.push(null);
  }
  
  // Mengisi array dengan hari-hari dalam bulan
  for (let i = 1; i <= daysInMonth; i++) {
    calendarDays.push(i);
  }
  
  // Mendapatkan tanggal saat ini
  const today = currentDate.getDate();
  
  // Filter events untuk bulan ini saja
  const currentMonthEvents = events.filter(event => {
    const [day, month, year] = event.date.split(' ');
    return monthNames[currentMonth].startsWith(month);
  });
  
  // Mendapatkan events untuk tanggal tertentu
  const getEventsForDay = (day: number) => {
    return currentMonthEvents.filter(event => {
      const [eventDay] = event.date.split(' ');
      return parseInt(eventDay) === day;
    });
  };
  
  return (
    <div className="border border-border rounded-xl p-4 bg-background">
      <div className="flex justify-between items-center mb-4">
        <h3 className="font-medium text-lg">{monthNames[currentMonth]} {currentYear}</h3>
        <div className="flex space-x-2">
          <button className="w-7 h-7 flex items-center justify-center rounded hover:bg-foreground/10">
            <i className="ri-arrow-left-s-line"></i>
          </button>
          <button className="w-7 h-7 flex items-center justify-center rounded hover:bg-foreground/10">
            <i className="ri-arrow-right-s-line"></i>
          </button>
        </div>
      </div>
      
      <div className="grid grid-cols-7 gap-1 text-center mb-2">
        {dayNames.map(day => (
          <div key={day} className="text-xs text-muted-foreground font-medium py-1">
            {day}
          </div>
        ))}
      </div>
      
      <div className="grid grid-cols-7 gap-1">
        {calendarDays.map((day, index) => {
          if (day === null) {
            return <div key={`empty-${index}`} className="p-1"></div>;
          }
          
          const dayEvents = getEventsForDay(day);
          const isToday = day === today;
          
          return (
            <div key={`day-${day}`} className="relative">
              <button 
                className={`w-full h-9 flex items-center justify-center text-sm rounded-md
                  ${isToday ? 'bg-blue-600 text-white' : 'hover:bg-foreground/5'}
                `}
              >
                {day}
              </button>
              <div className="absolute bottom-0 left-1/2 transform -translate-x-1/2 flex space-x-0.5">
                {dayEvents.slice(0, 3).map((event, idx) => (
                  <div key={`event-${day}-${idx}`} className={`w-1.5 h-1.5 rounded-full ${event.color}`}></div>
                ))}
                {dayEvents.length > 3 && (
                  <div key={`event-${day}-more`} className="w-1.5 h-1.5 rounded-full bg-gray-400"></div>
                )}
              </div>
            </div>
          );
        })}
      </div>
      
      <div className="mt-4 space-y-2">
        <h4 className="text-sm font-medium text-foreground">Upcoming Events:</h4>
        {currentMonthEvents
          .sort((a, b) => {
            const dayA = parseInt(a.date.split(' ')[0]);
            const dayB = parseInt(b.date.split(' ')[0]);
            return dayA - dayB;
          })
          .slice(0, 3)
          .map(event => (
            <div key={event.id} className="flex items-center text-sm p-2 rounded hover:bg-foreground/5">
              <div className={`w-6 h-6 rounded-full ${event.color} flex items-center justify-center text-white mr-3`}>
                <i className={`${event.icon} text-xs`}></i>
              </div>
              <div className="flex-1">
                <div className="line-clamp-1">{event.title}</div>
                <div className="text-xs text-muted-foreground">{event.date}</div>
              </div>
            </div>
          ))
        }
        {currentMonthEvents.length > 3 && (
          <button className="text-xs text-blue-600 hover:text-blue-700 flex items-center">
            <span>Lihat semua</span>
            <i className="ri-arrow-right-s-line ml-1"></i>
          </button>
        )}
      </div>
    </div>
  );
};

// Tipe data untuk notifikasi
interface Notification {
  id: string;
  title: string;
  message: string;
  time: string;
  isRead: boolean;
  type: 'info' | 'warning' | 'success';
}

// Data dummy untuk notifikasi
const notificationData: Notification[] = [
  {
    id: 'notif1',
    title: 'Tagihan Jatuh Tempo',
    message: 'Kartu BCA Visa Signature akan jatuh tempo dalam 2 hari',
    time: '3 jam yang lalu',
    isRead: false,
    type: 'warning'
  },
  {
    id: 'notif2',
    title: 'Poin Segera Hangus',
    message: '2.500 poin akan hangus pada 20 Juni 2025',
    time: '5 jam yang lalu',
    isRead: false,
    type: 'warning'
  },
  {
    id: 'notif3',
    title: 'Reward Baru Tersedia',
    message: 'Klaim reward 50% diskon di CGV dengan 1.000 poin',
    time: '1 hari yang lalu',
    isRead: true,
    type: 'info'
  },
  {
    id: 'notif4',
    title: 'Transaksi Berhasil',
    message: 'Pembayaran Rp 850.000 ke Tokopedia telah berhasil',
    time: '2 hari yang lalu',
    isRead: true,
    type: 'success'
  }
];

// Top navigation untuk dashboard dengan desain lebih modern
const ModernDashboardTopbar = () => {
  const [location] = useLocation();
  const [isMenuOpen, setIsMenuOpen] = useState(false);
  const [isNotificationOpen, setIsNotificationOpen] = useState(false);
  const [notifications, setNotifications] = useState<Notification[]>(notificationData);
  
  const menuItems = [
    { icon: 'ri-dashboard-line', path: '/dashboard-home', id: 'dashboard' },
    { icon: 'ri-bank-card-line', path: '/cards', id: 'cards' },
    { icon: 'ri-exchange-line', path: '/transactions', id: 'transactions' },
    { icon: 'ri-coupon-3-line', path: '/promotions', id: 'promotions' },
    { icon: 'ri-gift-line', path: '/dashboard-home', id: 'rewards' },
    { icon: 'ri-settings-line', path: '/settings', id: 'settings' },
  ];
  
  // Menghitung notifikasi yang belum dibaca
  const unreadNotificationsCount = notifications.filter(notif => !notif.isRead).length;
  
  // Menandai semua notifikasi sebagai telah dibaca
  const markAllAsRead = () => {
    setNotifications(prev => prev.map(notif => ({
      ...notif,
      isRead: true
    })));
  };
  
  // Menandai satu notifikasi sebagai sudah dibaca
  const markAsRead = (id: string) => {
    setNotifications(prev => prev.map(notif => 
      notif.id === id ? { ...notif, isRead: true } : notif
    ));
  };
  
  // Toggle antara dropdown menu user dan notifikasi
  const toggleNotification = () => {
    setIsNotificationOpen(!isNotificationOpen);
    if (isMenuOpen) setIsMenuOpen(false);
  };
  
  const toggleUserMenu = () => {
    setIsMenuOpen(!isMenuOpen);
    if (isNotificationOpen) setIsNotificationOpen(false);
  };
  
  return (
    <div className="sticky top-0 z-30">
      {/* Modern glass morphism header */}
      <div className="backdrop-blur-md bg-background/70 border-b border-border shadow-sm">
        <div className="max-w-7xl mx-auto px-4 lg:px-8">
          <div className="flex items-center justify-between h-16">
            <div className="flex items-center space-x-4">
              <div className="flex-shrink-0">
                <div className="flex items-center">
                  <div className="bg-gradient-to-br from-blue-600 to-indigo-600 w-9 h-9 rounded-lg flex items-center justify-center shadow-lg">
                    <i className="ri-bank-card-line text-white"></i>
                  </div>
                  <span className="ml-3 text-xl font-bold font-display hidden md:block">Mileage</span>
                </div>
              </div>
              
              {/* Desktop Navigation - Simplified */}
              <div className="hidden lg:block">
                <div className="flex items-center ml-6 space-x-1">
                  {menuItems.map((item) => (
                    <Link 
                      href={item.path}
                      key={item.id}
                    >
                      <a 
                        className={`
                          px-4 py-2 rounded-lg flex items-center space-x-2 text-sm transition-all duration-200
                          ${location === item.path 
                            ? 'bg-blue-600 text-white shadow-md' 
                            : 'text-foreground hover:bg-foreground/10'
                          }
                        `}
                      >
                        <i className={`${item.icon} ${location !== item.path ? 'text-blue-600' : ''} text-lg`}></i>
                        <span className="font-medium">
                          {item.id === 'dashboard' && 'Dashboard'}
                          {item.id === 'cards' && 'Kartu Kredit'}
                          {item.id === 'transactions' && 'Transaksi'}
                          {item.id === 'rewards' && 'Reward'}
                          {item.id === 'settings' && 'Pengaturan'}
                        </span>
                      </a>
                    </Link>
                  ))}
                </div>
              </div>
            </div>
            
            <div className="flex items-center space-x-1">
              {/* Notification button with functional dropdown */}
              <div className="relative">
                <button 
                  className="p-2 rounded-full text-foreground hover:bg-foreground/10 transition-colors"
                  onClick={toggleNotification}
                >
                  <i className="ri-notification-3-line"></i>
                  {unreadNotificationsCount > 0 && (
                    <span className="absolute top-1 right-1 w-4 h-4 bg-red-500 rounded-full text-white text-xs flex items-center justify-center">
                      {unreadNotificationsCount}
                    </span>
                  )}
                </button>
                
                {/* Notification dropdown */}
                {isNotificationOpen && (
                  <div className="absolute right-0 mt-2 w-80 max-h-96 overflow-y-auto origin-top-right rounded-xl bg-background shadow-lg border border-border focus:outline-none z-40">
                    <div className="flex items-center justify-between px-4 py-3 border-b border-border sticky top-0 bg-background">
                      <p className="text-sm font-medium">Notifikasi</p>
                      {unreadNotificationsCount > 0 && (
                        <button 
                          className="text-xs text-blue-600 hover:text-blue-700"
                          onClick={markAllAsRead}
                        >
                          Tandai semua dibaca
                        </button>
                      )}
                    </div>
                    
                    <div className="divide-y divide-border">
                      {notifications.length > 0 ? (
                        notifications.map(notif => (
                          <div 
                            key={notif.id} 
                            className={`px-4 py-3 hover:bg-foreground/5 cursor-pointer ${!notif.isRead ? 'bg-blue-50/20' : ''}`}
                            onClick={() => markAsRead(notif.id)}
                          >
                            <div className="flex items-start">
                              <div className={`
                                w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 mr-3
                                ${notif.type === 'warning' ? 'bg-amber-100 text-amber-600' : 
                                  notif.type === 'success' ? 'bg-green-100 text-green-600' : 
                                  'bg-blue-100 text-blue-600'}
                              `}>
                                {notif.type === 'warning' && <i className="ri-alarm-warning-line"></i>}
                                {notif.type === 'success' && <i className="ri-check-line"></i>}
                                {notif.type === 'info' && <i className="ri-information-line"></i>}
                              </div>
                              <div className="flex-1">
                                <div className="flex items-start justify-between">
                                  <p className="font-medium text-sm">{notif.title}</p>
                                  <span className="text-xs text-muted-foreground ml-2">{notif.time}</span>
                                </div>
                                <p className="text-sm text-muted-foreground mt-1">{notif.message}</p>
                              </div>
                            </div>
                            {!notif.isRead && (
                              <div className="w-2 h-2 bg-blue-600 rounded-full absolute right-4 top-4"></div>
                            )}
                          </div>
                        ))
                      ) : (
                        <div className="py-8 text-center">
                          <div className="inline-flex h-12 w-12 items-center justify-center rounded-full bg-foreground/5 mb-4">
                            <i className="ri-notification-off-line text-xl text-muted-foreground"></i>
                          </div>
                          <p className="text-muted-foreground">Tidak ada notifikasi</p>
                        </div>
                      )}
                    </div>
                    
                    {notifications.length > 0 && (
                      <div className="p-3 border-t border-border">
                        <button className="w-full py-2 text-sm text-center text-blue-600 hover:bg-blue-50 rounded-md">
                          Lihat semua notifikasi
                        </button>
                      </div>
                    )}
                  </div>
                )}
              </div>
              
              {/* User menu */}
              <div className="relative ml-3">
                <div>
                  <button
                    className="flex items-center space-x-3 p-1 rounded-full bg-foreground/5 hover:bg-foreground/10 transition-colors"
                    onClick={toggleUserMenu}
                  >
                    <div className="relative w-8 h-8 rounded-full bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center shadow-sm">
                      <span className="text-blue-700 text-sm font-semibold">JD</span>
                      <span className="absolute bottom-0 right-0 w-2 h-2 bg-green-500 rounded-full border border-white"></span>
                    </div>
                    <div className="hidden md:block text-left">
                      <div className="text-sm font-medium">John Doe</div>
                      <div className="text-xs text-muted-foreground">Premium</div>
                    </div>
                    <i className={`ri-arrow-down-s-line transition-transform duration-200 ${isMenuOpen ? 'rotate-180' : ''} hidden md:block`}></i>
                  </button>
                </div>
                
                {/* Dropdown menu */}
                {isMenuOpen && (
                  <div className="absolute right-0 mt-2 w-64 origin-top-right rounded-xl bg-background shadow-lg border border-border ring-1 ring-black ring-opacity-5 focus:outline-none z-40">
                    <div className="px-4 py-3 border-b border-border">
                      <p className="text-sm leading-5">Signed in as</p>
                      <p className="truncate text-sm font-medium leading-5">john.doe@example.com</p>
                    </div>
                    
                    <div className="py-2">
                      <button className="w-full text-left px-4 py-2 text-sm hover:bg-foreground/5 flex items-center">
                        <i className="ri-user-line mr-3 text-blue-600"></i>
                        <span>Profile</span>
                      </button>
                      <button className="w-full text-left px-4 py-2 text-sm hover:bg-foreground/5 flex items-center">
                        <i className="ri-settings-4-line mr-3 text-blue-600"></i>
                        <span>Settings</span>
                      </button>
                      <button className="w-full text-left px-4 py-2 text-sm hover:bg-foreground/5 flex items-center">
                        <i className="ri-shield-check-line mr-3 text-blue-600"></i>
                        <span>Security</span>
                      </button>
                    </div>
                    
                    <div className="py-1 border-t border-border">
                      <div className="px-4 py-2 flex justify-between items-center">
                        <span className="text-xs text-muted-foreground">Dark Mode</span>
                        <button className="relative inline-flex h-5 w-10 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-foreground/10 transition-colors duration-200 ease-in-out focus:outline-none">
                          <span className="translate-x-5 relative inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                        </button>
                      </div>
                    </div>
                    
                    <div className="py-1 border-t border-border">
                      <button className="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center">
                        <i className="ri-logout-box-r-line mr-3"></i>
                        <span>Sign out</span>
                      </button>
                    </div>
                  </div>
                )}
              </div>
            </div>
          </div>
        </div>
      </div>
      
      {/* Mobile Menu - Simplified */}
      <div className="lg:hidden border-b border-border bg-background/70 backdrop-blur-sm">
        <div className="px-4 py-2">
          <div className="flex justify-around">
            {menuItems.map((item) => (
              <Link
                href={item.path}
                key={`mobile-${item.id}`}
              >
                <a
                  className={`
                    flex flex-col items-center py-2 px-4 text-xs transition-colors
                    ${location === item.path
                      ? 'text-blue-600'
                      : 'text-foreground hover:text-blue-600'
                    }
                  `}
                >
                  <i className={`${item.icon} text-lg`}></i>
                  <span className="mt-1">
                    {item.id === 'dashboard' && 'Dashboard'}
                    {item.id === 'cards' && 'Kartu'}
                    {item.id === 'transactions' && 'Transaksi'}
                    {item.id === 'rewards' && 'Reward'}
                    {item.id === 'settings' && 'Pengaturan'}
                  </span>
                </a>
              </Link>
            ))}
          </div>
        </div>
      </div>
    </div>
  );
};

// Halaman utama Dashboard
const DashboardHomePage: React.FC = () => {
  const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);
  
  return (
    <div className="min-h-screen bg-background">
      <ModernDashboardTopbar />
      
      <main className="py-6 px-4 lg:px-8 pb-20">
        <div className="max-w-7xl mx-auto">
          <div className="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8">
            <div>
              <h1 className="text-2xl lg:text-3xl font-bold font-display mb-1">Selamat Datang, John!</h1>
              <p className="text-muted-foreground">Berikut adalah informasi terbaru tentang kartu dan reward Anda</p>
            </div>
            
            <div className="mt-4 lg:mt-0 flex space-x-2">
              <button className="flex items-center space-x-2 px-3 py-2 rounded-lg border border-border hover:bg-foreground/5 transition-colors">
                <i className="ri-download-line"></i>
                <span>Ekspor Data</span>
              </button>
              <button className="flex items-center space-x-2 px-3 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                <i className="ri-add-line"></i>
                <span>Tambah Kartu</span>
              </button>
            </div>
          </div>
          
          {/* Dashboard Content */}
          <div className="grid grid-cols-1 xl:grid-cols-3 gap-6">
            {/* Left Column */}
            <div className="xl:col-span-2 space-y-6">
              {/* Metrics Cards */}
              <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                <motion.div 
                  className="bg-background border border-border rounded-xl p-5"
                  initial={{ opacity: 0, y: 20 }}
                  animate={{ opacity: 1, y: 0 }}
                  transition={{ duration: 0.4 }}
                >
                  <div className="flex items-center justify-between mb-2">
                    <div className="text-sm text-muted-foreground">Total Poin</div>
                    <div className="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                      <i className="ri-coin-line"></i>
                    </div>
                  </div>
                  <div className="text-2xl font-bold">
                    {creditCards.reduce((sum, card) => sum + card.points, 0).toLocaleString()}
                  </div>
                  <div className="text-xs text-green-500 mt-1 flex items-center">
                    <i className="ri-arrow-up-line mr-1"></i>
                    <span>15% dari bulan lalu</span>
                  </div>
                </motion.div>
                
                <motion.div 
                  className="bg-background border border-border rounded-xl p-5"
                  initial={{ opacity: 0, y: 20 }}
                  animate={{ opacity: 1, y: 0 }}
                  transition={{ duration: 0.4, delay: 0.1 }}
                >
                  <div className="flex items-center justify-between mb-2">
                    <div className="text-sm text-muted-foreground">Total Kartu</div>
                    <div className="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center text-purple-600">
                      <i className="ri-bank-card-line"></i>
                    </div>
                  </div>
                  <div className="text-2xl font-bold">
                    {creditCards.length}
                  </div>
                  <div className="text-xs text-muted-foreground mt-1 flex items-center">
                    <span>Dari 3 bank berbeda</span>
                  </div>
                </motion.div>
                
                <motion.div 
                  className="bg-background border border-border rounded-xl p-5"
                  initial={{ opacity: 0, y: 20 }}
                  animate={{ opacity: 1, y: 0 }}
                  transition={{ duration: 0.4, delay: 0.2 }}
                >
                  <div className="flex items-center justify-between mb-2">
                    <div className="text-sm text-muted-foreground">Total Pengeluaran</div>
                    <div className="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                      <i className="ri-money-dollar-circle-line"></i>
                    </div>
                  </div>
                  <div className="text-2xl font-bold">
                    Rp {transactions.reduce((sum, trx) => sum + trx.amount, 0).toLocaleString()}
                  </div>
                  <div className="text-xs text-red-500 mt-1 flex items-center">
                    <i className="ri-arrow-down-line mr-1"></i>
                    <span>8% dari bulan lalu</span>
                  </div>
                </motion.div>
              </div>
              
              {/* Spending Categories & Calendar */}
              <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                {/* Kategori Pengeluaran dengan Pie Chart Modern */}
                <div className="bg-background border border-border rounded-xl overflow-hidden">
                  <div className="flex items-center justify-between p-6 border-b border-border">
                    <h2 className="font-display font-bold text-lg">Kategori Pengeluaran</h2>
                    <button className="text-sm text-blue-500 hover:text-blue-600 flex items-center space-x-1">
                      <span>Detail</span>
                      <i className="ri-arrow-right-s-line"></i>
                    </button>
                  </div>
                  
                  <div className="p-6">
                    <ModernPieChart categories={spendingCategories} />
                  </div>
                </div>
                
                {/* Calendar Widget */}
                <div className="bg-background border border-border rounded-xl overflow-hidden">
                  <div className="flex items-center justify-between p-6 border-b border-border">
                    <h2 className="font-display font-bold text-lg">Kalender</h2>
                    <button className="text-sm text-blue-500 hover:text-blue-600 flex items-center space-x-1">
                      <span>Detail</span>
                      <i className="ri-arrow-right-s-line"></i>
                    </button>
                  </div>
                  
                  <div className="p-4">
                    <CalendarWidget events={calendarEvents} />
                  </div>
                </div>
              </div>
              
              {/* Spending Challenges */}
              <div className="bg-background border border-border rounded-xl overflow-hidden">
                <div className="flex items-center justify-between p-6 border-b border-border">
                  <h2 className="font-display font-bold text-lg">Tantangan Pengeluaran</h2>
                  <button className="text-sm text-blue-500 hover:text-blue-600">
                    Lihat Semua
                  </button>
                </div>
                
                <div className="p-6">
                  <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    {spendingChallenges.map(challenge => (
                      <SpendingChallengeItem key={challenge.id} challenge={challenge} />
                    ))}
                    
                    <motion.div 
                      className="p-4 border border-dashed border-border rounded-xl flex flex-col items-center justify-center text-muted-foreground hover:text-foreground cursor-pointer hover:bg-foreground/5 transition-colors"
                      whileHover={{ scale: 1.02 }}
                    >
                      <div className="w-12 h-12 rounded-full border-2 border-dashed border-border flex items-center justify-center mb-2">
                        <i className="ri-add-line text-xl"></i>
                      </div>
                      <div className="text-sm font-medium">Buat Tantangan Baru</div>
                      <div className="text-xs text-muted-foreground mt-1">Tetapkan target hemat</div>
                    </motion.div>
                  </div>
                </div>
              </div>
              
              {/* Transaksi Terbaru */}
              <div className="bg-background border border-border rounded-xl overflow-hidden">
                <div className="flex items-center justify-between p-6 border-b border-border">
                  <h2 className="font-display font-bold text-lg">Transaksi Terbaru</h2>
                  <Link href="/transactions">
                    <div className="text-sm text-blue-500 hover:text-blue-600 flex items-center space-x-1 cursor-pointer">
                      <span>Lihat Semua</span>
                      <i className="ri-arrow-right-s-line"></i>
                    </div>
                  </Link>
                </div>
                
                <div className="divide-y divide-border">
                  {transactions.slice(0, 5).map((transaction) => (
                    <TransactionItem key={transaction.id} transaction={transaction} />
                  ))}
                  
                  <div className="p-4">
                    <Link href="/transactions">
                      <div className="w-full py-2 text-center text-blue-600 hover:text-blue-700 cursor-pointer">
                        Lihat Transaksi Terbaru
                      </div>
                    </Link>
                  </div>
                </div>
              </div>
            </div>
            
            {/* Right Column */}
            <div className="space-y-6">
              <div className="bg-background border border-border rounded-xl overflow-hidden">
                <div className="p-6 border-b border-border">
                  <h2 className="font-display font-bold text-lg">Kartu Kredit Anda</h2>
                </div>
                
                <div className="p-6 space-y-6">
                  {creditCards.map((card) => (
                    <CreditCardItem key={card.id} card={card} />
                  ))}
                  
                  <button className="w-full py-3 flex items-center justify-center space-x-2 border-2 border-dashed border-border rounded-xl text-muted-foreground hover:text-foreground hover:border-foreground/20 transition-colors">
                    <i className="ri-add-line"></i>
                    <span>Tambah Kartu Baru</span>
                  </button>
                </div>
              </div>
              
              <div className="bg-background border border-border rounded-xl overflow-hidden">
                <div className="p-6 border-b border-border">
                  <h2 className="font-display font-bold text-lg">Promo Terbaru</h2>
                </div>
                
                <div className="p-6">
                  <div className="space-y-4">
                    <Link href="/promotions">
                      <div className="border border-border rounded-lg p-4 hover:bg-foreground/5 transition-colors cursor-pointer">
                        <div className="flex items-start space-x-3">
                          <div className="w-10 h-10 rounded bg-blue-100 flex items-center justify-center text-blue-600">
                            <i className="ri-flight-takeoff-line"></i>
                          </div>
                          <div>
                            <div className="font-medium">Cashback 10% untuk pembelian tiket Garuda</div>
                            <div className="text-xs text-muted-foreground mt-1">Berlaku hingga 30 Juni 2025</div>
                          </div>
                        </div>
                      </div>
                    </Link>
                    
                    <Link href="/promotions">
                      <div className="border border-border rounded-lg p-4 hover:bg-foreground/5 transition-colors cursor-pointer">
                        <div className="flex items-start space-x-3">
                          <div className="w-10 h-10 rounded bg-purple-100 flex items-center justify-center text-purple-600">
                            <i className="ri-hotel-line"></i>
                          </div>
                          <div>
                            <div className="font-medium">Diskon 15% untuk booking hotel via Traveloka</div>
                            <div className="text-xs text-muted-foreground mt-1">Berlaku hingga 15 Juni 2025</div>
                          </div>
                        </div>
                      </div>
                    </Link>
                    
                    <Link href="/promotions">
                      <div className="border border-border rounded-lg p-4 hover:bg-foreground/5 transition-colors cursor-pointer">
                        <div className="flex items-start space-x-3">
                          <div className="w-10 h-10 rounded bg-amber-100 flex items-center justify-center text-amber-600">
                            <i className="ri-restaurant-line"></i>
                          </div>
                          <div>
                            <div className="font-medium">Bayar 1 Gratis 1 di Starbucks setiap Jumat</div>
                            <div className="text-xs text-muted-foreground mt-1">Berlaku hingga 31 Mei 2025</div>
                          </div>
                        </div>
                      </div>
                    </Link>
                    
                    <Link href="/promotions">
                      <div className="text-center text-sm text-blue-600 hover:text-blue-700 flex items-center justify-center py-2">
                        <span>Lihat Semua Promo</span>
                        <i className="ri-arrow-right-s-line ml-1"></i>
                      </div>
                    </Link>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
      
      <Footer />
    </div>
  );
};

export { ModernDashboardTopbar };
export default DashboardHomePage;