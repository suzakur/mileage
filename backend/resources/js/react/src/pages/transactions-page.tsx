import React, { useState, useEffect, useMemo } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { ModernDashboardTopbar } from './dashboard-home-page';
import Footer from '@/components/Footer';
import { 
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select";
import {
  Tabs,
  TabsContent,
  TabsList,
  TabsTrigger,
} from "@/components/ui/tabs";
import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from "@/components/ui/popover";
import { Calendar } from "@/components/ui/calendar";
import { format } from "date-fns";
import { id } from 'date-fns/locale';
import { DateRange } from 'react-day-picker';

// Transaction interface
interface Transaction {
  id: string;
  date: string;
  timestamp: string;
  merchant: string;
  amount: number;
  category: TransactionCategory;
  cardId: string;
  cardName: string;
  cardIssuer: string;
  description?: string;
  status: 'pending' | 'completed' | 'declined';
  location?: string;
  paymentMethod: 'online' | 'in-store' | 'recurring';
  tags?: string[];
  receiptAvailable: boolean;
  isRefundable: boolean;
  recurrenceFrequency?: 'monthly' | 'weekly' | 'yearly';
  isFlagged: boolean;
  smartCategory?: string;
}

type TransactionCategory = 
  | 'Food & Beverage' 
  | 'Shopping' 
  | 'Entertainment' 
  | 'Transportation' 
  | 'Utilities' 
  | 'Healthcare' 
  | 'Education'
  | 'Travel'
  | 'Housing'
  | 'Insurance'
  | 'Investments'
  | 'Personal'
  | 'Business'
  | 'Taxes'
  | 'Others';

// Smart category rules
const smartCategoryRules = [
  { keyword: 'cafe', category: 'Food & Beverage', subcategory: 'Coffee Shops' },
  { keyword: 'starbucks', category: 'Food & Beverage', subcategory: 'Coffee Shops' },
  { keyword: 'restaurant', category: 'Food & Beverage', subcategory: 'Dining' },
  { keyword: 'pizza', category: 'Food & Beverage', subcategory: 'Fast Food' },
  { keyword: 'uber', category: 'Transportation', subcategory: 'Ride Sharing' },
  { keyword: 'gojek', category: 'Transportation', subcategory: 'Ride Sharing' },
  { keyword: 'grab', category: 'Transportation', subcategory: 'Ride Sharing' },
  { keyword: 'tokopedia', category: 'Shopping', subcategory: 'Online Shopping' },
  { keyword: 'shopee', category: 'Shopping', subcategory: 'Online Shopping' },
  { keyword: 'bukalapak', category: 'Shopping', subcategory: 'Online Shopping' },
  { keyword: 'lazada', category: 'Shopping', subcategory: 'Online Shopping' },
  { keyword: 'netflix', category: 'Entertainment', subcategory: 'Streaming Services' },
  { keyword: 'spotify', category: 'Entertainment', subcategory: 'Streaming Services' },
  { keyword: 'cinema', category: 'Entertainment', subcategory: 'Movies' },
  { keyword: 'xxi', category: 'Entertainment', subcategory: 'Movies' },
  { keyword: 'cgv', category: 'Entertainment', subcategory: 'Movies' },
  { keyword: 'pln', category: 'Utilities', subcategory: 'Electricity' },
  { keyword: 'listrik', category: 'Utilities', subcategory: 'Electricity' },
  { keyword: 'indihome', category: 'Utilities', subcategory: 'Internet' },
  { keyword: 'biznet', category: 'Utilities', subcategory: 'Internet' },
  { keyword: 'wifi', category: 'Utilities', subcategory: 'Internet' },
  { keyword: 'internet', category: 'Utilities', subcategory: 'Internet' },
  { keyword: 'pdam', category: 'Utilities', subcategory: 'Water' },
  { keyword: 'air', category: 'Utilities', subcategory: 'Water' },
  { keyword: 'telepon', category: 'Utilities', subcategory: 'Phone' },
  { keyword: 'telkom', category: 'Utilities', subcategory: 'Phone' },
  { keyword: 'pulsa', category: 'Utilities', subcategory: 'Phone' },
  { keyword: 'hospital', category: 'Healthcare', subcategory: 'Hospital' },
  { keyword: 'rumah sakit', category: 'Healthcare', subcategory: 'Hospital' },
  { keyword: 'doctor', category: 'Healthcare', subcategory: 'Doctor' },
  { keyword: 'dokter', category: 'Healthcare', subcategory: 'Doctor' },
  { keyword: 'apotek', category: 'Healthcare', subcategory: 'Pharmacy' },
  { keyword: 'pharmacy', category: 'Healthcare', subcategory: 'Pharmacy' },
  { keyword: 'school', category: 'Education', subcategory: 'School' },
  { keyword: 'sekolah', category: 'Education', subcategory: 'School' },
  { keyword: 'university', category: 'Education', subcategory: 'University' },
  { keyword: 'universitas', category: 'Education', subcategory: 'University' },
  { keyword: 'course', category: 'Education', subcategory: 'Course' },
  { keyword: 'kursus', category: 'Education', subcategory: 'Course' },
  { keyword: 'book', category: 'Education', subcategory: 'Books' },
  { keyword: 'buku', category: 'Education', subcategory: 'Books' },
  { keyword: 'apartment', category: 'Housing', subcategory: 'Rent' },
  { keyword: 'apartemen', category: 'Housing', subcategory: 'Rent' },
  { keyword: 'rent', category: 'Housing', subcategory: 'Rent' },
  { keyword: 'sewa', category: 'Housing', subcategory: 'Rent' },
  { keyword: 'hotel', category: 'Travel', subcategory: 'Accommodation' },
  { keyword: 'flight', category: 'Travel', subcategory: 'Flights' },
  { keyword: 'pesawat', category: 'Travel', subcategory: 'Flights' },
  { keyword: 'tiket', category: 'Travel', subcategory: 'Tickets' },
  { keyword: 'ticket', category: 'Travel', subcategory: 'Tickets' },
];

// Card data for filtering
const cards = [
  { id: 'card1', name: 'Visa Signature', issuer: 'BCA', color: 'bg-blue-100', textColor: 'text-blue-800' },
  { id: 'card2', name: 'World Elite', issuer: 'Mandiri', color: 'bg-green-100', textColor: 'text-green-800' },
  { id: 'card3', name: 'JCB Platinum', issuer: 'BNI', color: 'bg-purple-100', textColor: 'text-purple-800' },
];

// Category icon and color mapping
const categoryConfig: Record<TransactionCategory, { icon: string, color: string }> = {
  'Food & Beverage': { icon: 'ri-restaurant-line', color: 'bg-red-500' },
  'Shopping': { icon: 'ri-shopping-bag-line', color: 'bg-blue-500' },
  'Entertainment': { icon: 'ri-film-line', color: 'bg-purple-500' },
  'Transportation': { icon: 'ri-car-line', color: 'bg-green-500' },
  'Utilities': { icon: 'ri-lightbulb-line', color: 'bg-yellow-500' },
  'Healthcare': { icon: 'ri-heart-pulse-line', color: 'bg-pink-500' },
  'Education': { icon: 'ri-book-open-line', color: 'bg-cyan-500' },
  'Travel': { icon: 'ri-plane-line', color: 'bg-indigo-500' },
  'Housing': { icon: 'ri-home-line', color: 'bg-orange-500' },
  'Insurance': { icon: 'ri-shield-check-line', color: 'bg-emerald-500' },
  'Investments': { icon: 'ri-line-chart-line', color: 'bg-blue-700' },
  'Personal': { icon: 'ri-user-line', color: 'bg-violet-500' },
  'Business': { icon: 'ri-briefcase-line', color: 'bg-gray-600' },
  'Taxes': { icon: 'ri-government-line', color: 'bg-red-700' },
  'Others': { icon: 'ri-more-line', color: 'bg-gray-500' },
};

// Generate dummy data for transactions with different timestamps in a day
const generateTransactions = (): Transaction[] => {
  const transactions: Transaction[] = [];
  
  // May 13, 2025
  transactions.push(
    {
      id: 'trx1',
      date: '13 Mei 2025',
      timestamp: '08:45',
      merchant: 'Starbucks Kota Kasablanka',
      amount: 68000,
      category: 'Food & Beverage',
      cardId: 'card1',
      cardName: 'Visa Signature',
      cardIssuer: 'BCA',
      description: 'Breakfast meeting',
      status: 'completed',
      location: 'Jakarta Selatan',
      paymentMethod: 'in-store',
      receiptAvailable: true,
      isRefundable: false,
      isFlagged: false,
      smartCategory: 'Coffee Shops'
    },
    {
      id: 'trx2',
      date: '13 Mei 2025',
      timestamp: '12:30',
      merchant: 'Sushi Tei',
      amount: 235000,
      category: 'Food & Beverage',
      cardId: 'card1',
      cardName: 'Visa Signature',
      cardIssuer: 'BCA',
      description: 'Lunch with client',
      status: 'completed',
      location: 'Grand Indonesia',
      paymentMethod: 'in-store',
      receiptAvailable: true,
      isRefundable: false,
      isFlagged: false,
      smartCategory: 'Dining'
    },
    {
      id: 'trx3',
      date: '13 Mei 2025',
      timestamp: '15:20',
      merchant: 'Tokopedia',
      amount: 850000,
      category: 'Shopping',
      cardId: 'card1',
      cardName: 'Visa Signature',
      cardIssuer: 'BCA',
      description: 'New phone case and accessories',
      status: 'completed',
      paymentMethod: 'online',
      tags: ['gadget', 'personal'],
      receiptAvailable: true,
      isRefundable: true,
      isFlagged: false,
      smartCategory: 'Online Shopping'
    },
    {
      id: 'trx4',
      date: '13 Mei 2025',
      timestamp: '18:45',
      merchant: 'Shell',
      amount: 350000,
      category: 'Transportation',
      cardId: 'card2',
      cardName: 'World Elite',
      cardIssuer: 'Mandiri',
      status: 'completed',
      location: 'TB Simatupang',
      paymentMethod: 'in-store',
      receiptAvailable: true,
      isRefundable: false,
      isFlagged: false,
      smartCategory: 'Fuel'
    }
  );
  
  // May 12, 2025
  transactions.push(
    {
      id: 'trx5',
      date: '12 Mei 2025',
      timestamp: '09:15',
      merchant: 'Grab',
      amount: 75000,
      category: 'Transportation',
      cardId: 'card3',
      cardName: 'JCB Platinum',
      cardIssuer: 'BNI',
      description: 'Morning ride to office',
      status: 'completed',
      location: 'Jakarta',
      paymentMethod: 'online',
      receiptAvailable: true,
      isRefundable: false,
      isFlagged: false,
      smartCategory: 'Ride Sharing'
    },
    {
      id: 'trx6',
      date: '12 Mei 2025',
      timestamp: '13:10',
      merchant: 'KFC',
      amount: 98000,
      category: 'Food & Beverage',
      cardId: 'card2',
      cardName: 'World Elite',
      cardIssuer: 'Mandiri',
      status: 'completed',
      location: 'Plaza Indonesia',
      paymentMethod: 'in-store',
      receiptAvailable: false,
      isRefundable: false,
      isFlagged: false,
      smartCategory: 'Fast Food'
    },
    {
      id: 'trx7',
      date: '12 Mei 2025',
      timestamp: '19:30',
      merchant: 'Netflix',
      amount: 169000,
      category: 'Entertainment',
      cardId: 'card2',
      cardName: 'World Elite',
      cardIssuer: 'Mandiri',
      description: 'Monthly subscription',
      status: 'completed',
      paymentMethod: 'recurring',
      recurrenceFrequency: 'monthly',
      receiptAvailable: true,
      isRefundable: false,
      isFlagged: false,
      smartCategory: 'Streaming Services'
    }
  );
  
  // May 11, 2025
  transactions.push(
    {
      id: 'trx8',
      date: '11 Mei 2025',
      timestamp: '10:45',
      merchant: 'Hypermart',
      amount: 456000,
      category: 'Shopping',
      cardId: 'card3',
      cardName: 'JCB Platinum',
      cardIssuer: 'BNI',
      description: 'Weekly groceries',
      status: 'completed',
      location: 'Pejaten Village',
      paymentMethod: 'in-store',
      tags: ['groceries', 'household'],
      receiptAvailable: true,
      isRefundable: false,
      isFlagged: false,
      smartCategory: 'Groceries'
    },
    {
      id: 'trx9',
      date: '11 Mei 2025',
      timestamp: '15:20',
      merchant: 'UNIQLO',
      amount: 599000,
      category: 'Shopping',
      cardId: 'card1',
      cardName: 'Visa Signature',
      cardIssuer: 'BCA',
      description: 'New clothes',
      status: 'completed',
      location: 'Mall Kelapa Gading',
      paymentMethod: 'in-store',
      tags: ['fashion', 'personal'],
      receiptAvailable: true,
      isRefundable: true,
      isFlagged: false,
      smartCategory: 'Clothing'
    },
    {
      id: 'trx10',
      date: '11 Mei 2025',
      timestamp: '20:10',
      merchant: 'CGV',
      amount: 200000,
      category: 'Entertainment',
      cardId: 'card2',
      cardName: 'World Elite',
      cardIssuer: 'Mandiri',
      description: 'Movie night',
      status: 'completed',
      location: 'Central Park',
      paymentMethod: 'online',
      receiptAvailable: true,
      isRefundable: false,
      isFlagged: false,
      smartCategory: 'Movies'
    }
  );
  
  // May 10, 2025
  transactions.push(
    {
      id: 'trx11',
      date: '10 Mei 2025',
      timestamp: '09:30',
      merchant: 'PLN',
      amount: 450000,
      category: 'Utilities',
      cardId: 'card3',
      cardName: 'JCB Platinum',
      cardIssuer: 'BNI',
      description: 'Electricity bill',
      status: 'completed',
      paymentMethod: 'online',
      receiptAvailable: true,
      isRefundable: false,
      recurrenceFrequency: 'monthly',
      isFlagged: false,
      smartCategory: 'Electricity'
    },
    {
      id: 'trx12',
      date: '10 Mei 2025',
      timestamp: '14:15',
      merchant: 'Shopee',
      amount: 520000,
      category: 'Shopping',
      cardId: 'card2',
      cardName: 'World Elite',
      cardIssuer: 'Mandiri',
      description: 'Home appliances',
      status: 'completed',
      paymentMethod: 'online',
      tags: ['home', 'electronics'],
      receiptAvailable: true,
      isRefundable: true,
      isFlagged: false,
      smartCategory: 'Online Shopping'
    },
    {
      id: 'trx13',
      date: '10 Mei 2025',
      timestamp: '16:45',
      merchant: 'Pertamina',
      amount: 300000,
      category: 'Transportation',
      cardId: 'card1',
      cardName: 'Visa Signature',
      cardIssuer: 'BCA',
      status: 'completed',
      location: 'Fatmawati',
      paymentMethod: 'in-store',
      receiptAvailable: false,
      isRefundable: false,
      isFlagged: false,
      smartCategory: 'Fuel'
    }
  );
  
  // May 9, 2025
  transactions.push(
    {
      id: 'trx14',
      date: '09 Mei 2025',
      timestamp: '11:30',
      merchant: 'Pizza Hut',
      amount: 230000,
      category: 'Food & Beverage',
      cardId: 'card1',
      cardName: 'Visa Signature',
      cardIssuer: 'BCA',
      description: 'Team lunch',
      status: 'completed',
      location: 'Sudirman',
      paymentMethod: 'in-store',
      receiptAvailable: true,
      isRefundable: false,
      isFlagged: false,
      smartCategory: 'Dining'
    },
    {
      id: 'trx15',
      date: '09 Mei 2025',
      timestamp: '18:30',
      merchant: 'Apotek Roxy',
      amount: 145000,
      category: 'Healthcare',
      cardId: 'card3',
      cardName: 'JCB Platinum',
      cardIssuer: 'BNI',
      description: 'Medicine',
      status: 'completed',
      location: 'Salemba',
      paymentMethod: 'in-store',
      receiptAvailable: true,
      isRefundable: false,
      isFlagged: false,
      smartCategory: 'Pharmacy'
    }
  );
  
  // May 8, 2025
  transactions.push(
    {
      id: 'trx16',
      date: '08 Mei 2025',
      timestamp: '07:45',
      merchant: 'Starbucks',
      amount: 58000,
      category: 'Food & Beverage',
      cardId: 'card2',
      cardName: 'World Elite',
      cardIssuer: 'Mandiri',
      status: 'completed',
      location: 'Thamrin',
      paymentMethod: 'in-store',
      receiptAvailable: false,
      isRefundable: false,
      isFlagged: false,
      smartCategory: 'Coffee Shops'
    },
    {
      id: 'trx17',
      date: '08 Mei 2025',
      timestamp: '12:20',
      merchant: 'Gramedia',
      amount: 350000,
      category: 'Education',
      cardId: 'card1',
      cardName: 'Visa Signature',
      cardIssuer: 'BCA',
      description: 'Books',
      status: 'completed',
      location: 'Grand Indonesia',
      paymentMethod: 'in-store',
      tags: ['books', 'education'],
      receiptAvailable: true,
      isRefundable: true,
      isFlagged: false,
      smartCategory: 'Books'
    },
    {
      id: 'trx18',
      date: '08 Mei 2025',
      timestamp: '16:30',
      merchant: 'Biznet',
      amount: 455000,
      category: 'Utilities',
      cardId: 'card3',
      cardName: 'JCB Platinum',
      cardIssuer: 'BNI',
      description: 'Internet bill',
      status: 'completed',
      paymentMethod: 'online',
      recurrenceFrequency: 'monthly',
      receiptAvailable: true,
      isRefundable: false,
      isFlagged: false,
      smartCategory: 'Internet'
    }
  );
  
  // Flag suspicious transaction
  transactions.push({
    id: 'trx19',
    date: '08 Mei 2025',
    timestamp: '23:45',
    merchant: 'Unknown Merchant',
    amount: 2500000,
    category: 'Others',
    cardId: 'card2',
    cardName: 'World Elite',
    cardIssuer: 'Mandiri',
    status: 'completed',
    location: 'Istanbul, Turkey',
    paymentMethod: 'online',
    receiptAvailable: false,
    isRefundable: true,
    isFlagged: true,
    smartCategory: 'Suspicious Activity'
  });
  
  // Add a pending transaction
  transactions.push({
    id: 'trx20',
    date: '13 Mei 2025',
    timestamp: '19:30',
    merchant: 'AEON Mall',
    amount: 1200000,
    category: 'Shopping',
    cardId: 'card1',
    cardName: 'Visa Signature',
    cardIssuer: 'BCA',
    description: 'Electronics purchase',
    status: 'pending',
    location: 'BSD City',
    paymentMethod: 'in-store',
    receiptAvailable: false,
    isRefundable: true,
    isFlagged: false,
    smartCategory: 'Electronics'
  });
  
  // Add a declined transaction
  transactions.push({
    id: 'trx21',
    date: '12 Mei 2025',
    timestamp: '22:15',
    merchant: 'Apple App Store',
    amount: 150000,
    category: 'Entertainment',
    cardId: 'card3',
    cardName: 'JCB Platinum',
    cardIssuer: 'BNI',
    description: 'App purchase',
    status: 'declined',
    paymentMethod: 'online',
    receiptAvailable: false,
    isRefundable: false,
    isFlagged: false,
    smartCategory: 'Digital Purchases'
  });
  
  return transactions;
};

// SmartChip component for rendering filters and tags
const SmartChip = ({ 
  label, 
  isActive = false, 
  onClick,
  icon,
  color = 'bg-gray-100',
  closeButton = false,
  count
}: { 
  label: string; 
  isActive?: boolean; 
  onClick?: () => void;
  icon?: string;
  color?: string;
  closeButton?: boolean;
  count?: number;
}) => {
  return (
    <button 
      className={`rounded-full px-3 py-1.5 text-sm font-medium whitespace-nowrap transition-all ${
        isActive 
          ? 'bg-blue-600 text-white' 
          : `${color} text-foreground hover:bg-foreground/10`
      }`}
      onClick={onClick}
    >
      <div className="flex items-center">
        {icon && <i className={`${icon} mr-1.5`}></i>}
        <span>{label}</span>
        {count !== undefined && (
          <span className={`ml-1.5 px-1.5 py-0.5 rounded-full ${
            isActive ? 'bg-white/20 text-white' : 'bg-foreground/10 text-foreground/70'
          }`}>
            {count}
          </span>
        )}
        {closeButton && (
          <i className="ri-close-line ml-1.5"></i>
        )}
      </div>
    </button>
  );
};

// TransactionItem component
const TransactionItem = ({ 
  transaction, 
  showDetailedView = false,
  onClick
}: { 
  transaction: Transaction;
  showDetailedView?: boolean;
  onClick?: () => void;
}) => {
  const categoryConfig = {
    'Food & Beverage': { icon: 'ri-restaurant-line', color: 'bg-red-500' },
    'Shopping': { icon: 'ri-shopping-bag-line', color: 'bg-blue-500' },
    'Entertainment': { icon: 'ri-film-line', color: 'bg-purple-500' },
    'Transportation': { icon: 'ri-car-line', color: 'bg-green-500' },
    'Utilities': { icon: 'ri-lightbulb-line', color: 'bg-yellow-500' },
    'Healthcare': { icon: 'ri-heart-pulse-line', color: 'bg-pink-500' },
    'Education': { icon: 'ri-book-open-line', color: 'bg-cyan-500' },
    'Travel': { icon: 'ri-plane-line', color: 'bg-indigo-500' },
    'Housing': { icon: 'ri-home-line', color: 'bg-orange-500' },
    'Insurance': { icon: 'ri-shield-check-line', color: 'bg-emerald-500' },
    'Investments': { icon: 'ri-line-chart-line', color: 'bg-blue-700' },
    'Personal': { icon: 'ri-user-line', color: 'bg-violet-500' },
    'Business': { icon: 'ri-briefcase-line', color: 'bg-gray-600' },
    'Taxes': { icon: 'ri-government-line', color: 'bg-red-700' },
    'Others': { icon: 'ri-more-line', color: 'bg-gray-500' },
  };
  
  const config = categoryConfig[transaction.category] || categoryConfig.Others;
  
  const getStatusBadge = (status: Transaction['status']) => {
    switch(status) {
      case 'pending':
        return <span className="px-2 py-0.5 bg-yellow-100 text-yellow-700 rounded text-xs font-medium">Pending</span>;
      case 'declined':
        return <span className="px-2 py-0.5 bg-red-100 text-red-700 rounded text-xs font-medium">Gagal</span>;
      default:
        return null;
    }
  };
  
  return (
    <motion.div 
      className={`border border-border rounded-xl overflow-hidden mb-3 transition-all ${showDetailedView ? 'bg-foreground/5' : 'bg-background hover:bg-foreground/5 cursor-pointer'}`}
      initial={{ opacity: 0, y: 10 }}
      animate={{ opacity: 1, y: 0 }}
      whileHover={{ y: showDetailedView ? 0 : -2 }}
      onClick={!showDetailedView ? onClick : undefined}
    >
      <div className="p-4">
        <div className="flex items-center">
          <div className={`w-10 h-10 rounded-full ${config.color} text-white flex items-center justify-center flex-shrink-0`}>
            <i className={`${config.icon} text-lg`}></i>
          </div>
          
          <div className="ml-3 flex-1 min-w-0">
            <div className="flex items-start justify-between">
              <div className="flex-1 min-w-0">
                <div className="flex items-center">
                  <h3 className="font-medium text-foreground truncate">{transaction.merchant}</h3>
                  {transaction.isFlagged && (
                    <div className="ml-2 text-red-500">
                      <i className="ri-error-warning-line"></i>
                    </div>
                  )}
                  {getStatusBadge(transaction.status)}
                </div>
                
                <div className="text-sm text-foreground/60 flex items-center mt-0.5">
                  <span>{transaction.date}</span>
                  <span className="mx-1 text-foreground/30">•</span>
                  <span>{transaction.timestamp}</span>
                  {transaction.location && (
                    <>
                      <span className="mx-1 text-foreground/30">•</span>
                      <span className="flex items-center">
                        <i className="ri-map-pin-line mr-0.5 text-foreground/40"></i>
                        {transaction.location}
                      </span>
                    </>
                  )}
                </div>
              </div>
              
              <div className="text-right ml-3">
                <div className={`font-semibold ${transaction.status === 'declined' ? 'text-foreground/50 line-through' : ''}`}>
                  Rp {transaction.amount.toLocaleString()}
                </div>
                <div className="flex items-center justify-end text-xs mt-0.5">
                  <div className={`w-2 h-2 rounded-full ${
                    transaction.cardIssuer === 'BCA' ? 'bg-blue-500' :
                    transaction.cardIssuer === 'Mandiri' ? 'bg-green-500' :
                    'bg-purple-500'
                  } mr-1`}></div>
                  <span className="text-foreground/60">{transaction.cardIssuer} {transaction.cardName.split(' ')[0]}</span>
                </div>
              </div>
            </div>
            
            {transaction.smartCategory && (
              <div className="mt-2">
                <span className="px-2 py-0.5 bg-foreground/10 text-foreground/70 rounded text-xs">
                  {transaction.smartCategory}
                </span>
              </div>
            )}
          </div>
        </div>
        
        {showDetailedView && (
          <motion.div 
            className="mt-4 pt-4 border-t border-border"
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            transition={{ delay: 0.2 }}
          >
            <div className="grid grid-cols-2 md:grid-cols-4 gap-3">
              <div>
                <div className="text-sm text-foreground/60 mb-1">Kategori</div>
                <div className="flex items-center">
                  <span className={`w-3 h-3 rounded-full ${config.color} mr-1.5`}></span>
                  <span>{transaction.category}</span>
                </div>
              </div>
              
              <div>
                <div className="text-sm text-foreground/60 mb-1">Metode Pembayaran</div>
                <div className="capitalize">
                  {transaction.paymentMethod === 'in-store' ? 'Di Toko' : 
                   transaction.paymentMethod === 'online' ? 'Online' : 'Berlangganan'}
                </div>
              </div>
              
              <div>
                <div className="text-sm text-foreground/60 mb-1">Status</div>
                <div className="capitalize">
                  {transaction.status === 'completed' ? 'Selesai' : 
                   transaction.status === 'pending' ? 'Tertunda' : 'Gagal'}
                </div>
              </div>
              
              <div>
                <div className="text-sm text-foreground/60 mb-1">Dapat Dikembalikan</div>
                <div>{transaction.isRefundable ? 'Ya' : 'Tidak'}</div>
              </div>
            </div>
            
            {transaction.description && (
              <div className="mt-3 pt-3 border-t border-border">
                <div className="text-sm text-foreground/60 mb-1">Deskripsi</div>
                <div>{transaction.description}</div>
              </div>
            )}
            
            {transaction.tags && transaction.tags.length > 0 && (
              <div className="mt-3 pt-3 border-t border-border">
                <div className="text-sm text-foreground/60 mb-1">Tags</div>
                <div className="flex flex-wrap gap-2">
                  {transaction.tags.map(tag => (
                    <SmartChip 
                      key={tag} 
                      label={tag} 
                      color="bg-foreground/10"
                    />
                  ))}
                </div>
              </div>
            )}
            
            <div className="mt-4 flex justify-end gap-2">
              {transaction.receiptAvailable && (
                <button className="flex items-center space-x-1 px-3 py-1.5 rounded-lg border border-border hover:bg-foreground/5 text-sm">
                  <i className="ri-receipt-line"></i>
                  <span>Lihat Struk</span>
                </button>
              )}
              
              <button className="flex items-center space-x-1 px-3 py-1.5 rounded-lg border border-border hover:bg-foreground/5 text-sm">
                <i className="ri-edit-line"></i>
                <span>Edit</span>
              </button>
              
              {transaction.status === 'completed' && transaction.isRefundable && (
                <button className="flex items-center space-x-1 px-3 py-1.5 rounded-lg border border-red-200 text-red-600 hover:bg-red-50 text-sm">
                  <i className="ri-refund-line"></i>
                  <span>Refund</span>
                </button>
              )}
              
              {transaction.isFlagged && (
                <button className="flex items-center space-x-1 px-3 py-1.5 rounded-lg bg-red-600 text-white hover:bg-red-700 text-sm">
                  <i className="ri-shield-cross-line"></i>
                  <span>Laporkan Fraud</span>
                </button>
              )}
            </div>
          </motion.div>
        )}
      </div>
    </motion.div>
  );
};

// Group transactions by date
const groupTransactionsByDate = (transactions: Transaction[]): Record<string, Transaction[]> => {
  const grouped: Record<string, Transaction[]> = {};
  
  transactions.forEach(transaction => {
    if (!grouped[transaction.date]) {
      grouped[transaction.date] = [];
    }
    grouped[transaction.date].push(transaction);
  });
  
  // Sort each group by timestamp (latest first)
  Object.keys(grouped).forEach(date => {
    grouped[date].sort((a, b) => {
      const timeA = a.timestamp.split(':').map(Number);
      const timeB = b.timestamp.split(':').map(Number);
      
      if (timeA[0] !== timeB[0]) {
        return timeB[0] - timeA[0]; // Hours
      }
      return timeB[1] - timeA[1]; // Minutes
    });
  });
  
  return grouped;
};

// Main TransactionsPage component
const TransactionsPage: React.FC = () => {
  const [transactions] = useState<Transaction[]>(generateTransactions());
  const [searchTerm, setSearchTerm] = useState('');
  const [selectedCategory, setSelectedCategory] = useState<string | null>(null);
  const [selectedCard, setSelectedCard] = useState<string | null>(null);
  const [showPendingOnly, setShowPendingOnly] = useState(false);
  const [selectedTransaction, setSelectedTransaction] = useState<string | null>(null);
  const [dateRange, setDateRange] = useState<{ from: Date | undefined, to: Date | undefined }>({ from: undefined, to: undefined });
  const [amountRange, setAmountRange] = useState<{ min: number | undefined, max: number | undefined }>({ min: undefined, max: undefined });
  const [viewMode, setViewMode] = useState<'timeline' | 'analytics'>('timeline');
  const [isCalendarOpen, setIsCalendarOpen] = useState(false);
  
  // Filter transactions based on search and filters
  const filteredTransactions = useMemo(() => {
    return transactions.filter(transaction => {
      // Search filter
      if (searchTerm && !transaction.merchant.toLowerCase().includes(searchTerm.toLowerCase()) && 
          !transaction.description?.toLowerCase().includes(searchTerm.toLowerCase())) {
        return false;
      }
      
      // Category filter
      if (selectedCategory && transaction.category !== selectedCategory) {
        return false;
      }
      
      // Card filter
      if (selectedCard && transaction.cardId !== selectedCard) {
        return false;
      }
      
      // Pending only filter
      if (showPendingOnly && transaction.status !== 'pending') {
        return false;
      }
      
      // Date range filter
      if (dateRange.from || dateRange.to) {
        const [day, month, year] = transaction.date.split(' ');
        const transactionDate = new Date(`${year}-${getMonthNumber(month)}-${day.padStart(2, '0')}`);
        
        if (dateRange.from && transactionDate < dateRange.from) {
          return false;
        }
        
        if (dateRange.to) {
          // Add one day to include the end date
          const endDate = new Date(dateRange.to);
          endDate.setDate(endDate.getDate() + 1);
          if (transactionDate > endDate) {
            return false;
          }
        }
      }
      
      // Amount range filter
      if (amountRange.min !== undefined && transaction.amount < amountRange.min) {
        return false;
      }
      
      if (amountRange.max !== undefined && transaction.amount > amountRange.max) {
        return false;
      }
      
      return true;
    });
  }, [transactions, searchTerm, selectedCategory, selectedCard, showPendingOnly, dateRange, amountRange]);
  
  // Group transactions by date
  const groupedTransactions = useMemo(() => {
    return groupTransactionsByDate(filteredTransactions);
  }, [filteredTransactions]);
  
  // Calculate statistics
  const stats = useMemo(() => {
    const totalAmount = filteredTransactions
      .filter(tx => tx.status === 'completed')
      .reduce((sum, tx) => sum + tx.amount, 0);
    
    const categoryCounts: Record<string, { count: number, amount: number }> = {};
    filteredTransactions.forEach(tx => {
      if (tx.status === 'completed') {
        if (!categoryCounts[tx.category]) {
          categoryCounts[tx.category] = { count: 0, amount: 0 };
        }
        categoryCounts[tx.category].count += 1;
        categoryCounts[tx.category].amount += tx.amount;
      }
    });
    
    return {
      totalAmount,
      categoryCounts,
      pendingCount: filteredTransactions.filter(tx => tx.status === 'pending').length,
      declinedCount: filteredTransactions.filter(tx => tx.status === 'declined').length,
      flaggedCount: filteredTransactions.filter(tx => tx.isFlagged).length,
    };
  }, [filteredTransactions]);
  
  // Helper function to convert month name to number
  const getMonthNumber = (monthName: string): string => {
    const months: Record<string, string> = {
      'Jan': '01', 'Feb': '02', 'Mar': '03', 'Apr': '04', 'Mei': '05', 'Jun': '06',
      'Jul': '07', 'Agu': '08', 'Sep': '09', 'Okt': '10', 'Nov': '11', 'Des': '12'
    };
    return months[monthName] || '01';
  };
  
  // Handle transaction click
  const handleTransactionClick = (id: string) => {
    setSelectedTransaction(id === selectedTransaction ? null : id);
  };
  
  // Format date range for display
  const formatDateRange = (): string => {
    if (!dateRange.from && !dateRange.to) {
      return 'Pilih Tanggal';
    }
    
    if (dateRange.from && !dateRange.to) {
      return `Dari ${format(dateRange.from, 'dd MMM yyyy', { locale: id })}`;
    }
    
    if (!dateRange.from && dateRange.to) {
      return `Hingga ${format(dateRange.to, 'dd MMM yyyy', { locale: id })}`;
    }
    
    return `${format(dateRange.from!, 'dd MMM')} - ${format(dateRange.to!, 'dd MMM yyyy', { locale: id })}`;
  };
  
  // Clear all filters
  const clearAllFilters = () => {
    setSearchTerm('');
    setSelectedCategory(null);
    setSelectedCard(null);
    setShowPendingOnly(false);
    setDateRange({ from: undefined, to: undefined });
    setAmountRange({ min: undefined, max: undefined });
  };
  
  // Export transactions
  const exportTransactions = () => {
    alert('Data transaksi akan diexport ke CSV/Excel');
  };
  
  return (
    <div className="min-h-screen bg-background">
      <ModernDashboardTopbar />
      
      <main className="py-6 px-4 lg:px-8 pb-20">
        <div className="max-w-5xl mx-auto">
          <div className="flex items-center justify-between mb-6">
            <div>
              <h1 className="text-2xl lg:text-3xl font-bold font-display mb-1">Transaksi</h1>
              <p className="text-muted-foreground">Lihat dan kelola semua transaksi Anda</p>
            </div>
            
            <div className="flex gap-2">
              <button 
                className="px-3 py-2 rounded-lg border border-border hover:bg-foreground/5 transition-colors flex items-center space-x-1 text-sm"
                onClick={exportTransactions}
              >
                <i className="ri-download-2-line"></i>
                <span className="hidden sm:inline">Export</span>
              </button>
              
              <button 
                className="px-3 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors flex items-center space-x-1 text-sm"
              >
                <i className="ri-add-line"></i>
                <span className="hidden sm:inline">Transaksi Baru</span>
              </button>
            </div>
          </div>
          
          {/* Tabs */}
          <Tabs defaultValue="timeline" className="mb-6" onValueChange={(value) => setViewMode(value as any)}>
            <TabsList className="grid grid-cols-2 w-[260px]">
              <TabsTrigger value="timeline" className="flex items-center">
                <i className="ri-time-line mr-2"></i>
                <span>Timeline</span>
              </TabsTrigger>
              <TabsTrigger value="analytics" className="flex items-center">
                <i className="ri-bar-chart-grouped-line mr-2"></i>
                <span>Analytics</span>
              </TabsTrigger>
            </TabsList>
          </Tabs>
          
          {/* Quick Stats */}
          <div className="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div className="rounded-xl border border-border p-4 bg-background">
              <div className="text-sm text-foreground/60 mb-1">Total Pengeluaran</div>
              <div className="text-xl font-bold">Rp {stats.totalAmount.toLocaleString()}</div>
            </div>
            
            <div className="rounded-xl border border-border p-4 bg-background">
              <div className="text-sm text-foreground/60 mb-1">Transaksi</div>
              <div className="text-xl font-bold">{filteredTransactions.length}</div>
            </div>
            
            <div className="rounded-xl border border-border p-4 bg-background">
              <div className="text-sm text-foreground/60 mb-1">Pending</div>
              <div className="text-xl font-bold">{stats.pendingCount}</div>
            </div>
            
            <div className="rounded-xl border border-border p-4 bg-background">
              <div className="text-sm text-foreground/60 mb-1">Flagged</div>
              <div className="text-xl font-bold">{stats.flaggedCount}</div>
            </div>
          </div>
          
          {/* Search and filters */}
          <div className="mb-6 space-y-4">
            <div className="relative">
              <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i className="ri-search-line text-foreground/50"></i>
              </div>
              <input
                type="text"
                placeholder="Cari transaksi berdasarkan nama merchant atau deskripsi..."
                className="w-full py-2 pl-10 pr-4 border border-border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all bg-background"
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
              />
            </div>
            
            <div className="flex flex-wrap gap-2">
              {/* Category filter */}
              <Popover>
                <PopoverTrigger asChild>
                  <button className="rounded-full px-3 py-1.5 text-sm font-medium whitespace-nowrap border border-border hover:bg-foreground/5 transition-all flex items-center">
                    <i className="ri-filter-line mr-1.5"></i>
                    <span>Kategori</span>
                    {selectedCategory && <i className="ri-check-line ml-1"></i>}
                  </button>
                </PopoverTrigger>
                <PopoverContent className="w-56 p-3" align="start">
                  <div className="space-y-2">
                    <div className="text-sm font-medium mb-2">Pilih Kategori</div>
                    <div className="h-48 overflow-y-auto pr-2 -mr-2 space-y-1.5">
                      {Object.entries(categoryConfig).map(([category, config]) => (
                        <button
                          key={category}
                          className={`flex items-center w-full px-2 py-1.5 rounded-md text-sm ${
                            selectedCategory === category 
                              ? 'bg-blue-100 text-blue-700' 
                              : 'hover:bg-foreground/5'
                          }`}
                          onClick={() => setSelectedCategory(selectedCategory === category ? null : category)}
                        >
                          <div className={`w-6 h-6 rounded-full ${config.color} text-white flex items-center justify-center mr-2`}>
                            <i className={config.icon}></i>
                          </div>
                          <span>{category}</span>
                        </button>
                      ))}
                    </div>
                  </div>
                </PopoverContent>
              </Popover>
              
              {/* Card filter */}
              <Popover>
                <PopoverTrigger asChild>
                  <button className="rounded-full px-3 py-1.5 text-sm font-medium whitespace-nowrap border border-border hover:bg-foreground/5 transition-all flex items-center">
                    <i className="ri-bank-card-line mr-1.5"></i>
                    <span>Kartu</span>
                    {selectedCard && <i className="ri-check-line ml-1"></i>}
                  </button>
                </PopoverTrigger>
                <PopoverContent className="w-56 p-3" align="start">
                  <div className="space-y-2">
                    <div className="text-sm font-medium mb-2">Pilih Kartu</div>
                    <div className="space-y-1.5">
                      {cards.map(card => (
                        <button
                          key={card.id}
                          className={`flex items-center w-full px-2 py-1.5 rounded-md text-sm ${
                            selectedCard === card.id 
                              ? 'bg-blue-100 text-blue-700' 
                              : 'hover:bg-foreground/5'
                          }`}
                          onClick={() => setSelectedCard(selectedCard === card.id ? null : card.id)}
                        >
                          <div className={`w-2 h-2 rounded-full ${
                            card.issuer === 'BCA' ? 'bg-blue-500' :
                            card.issuer === 'Mandiri' ? 'bg-green-500' :
                            'bg-purple-500'
                          } mr-2`}></div>
                          <span>{card.issuer} {card.name}</span>
                        </button>
                      ))}
                    </div>
                  </div>
                </PopoverContent>
              </Popover>
              
              {/* Date range filter */}
              <Popover open={isCalendarOpen} onOpenChange={setIsCalendarOpen}>
                <PopoverTrigger asChild>
                  <button className="rounded-full px-3 py-1.5 text-sm font-medium whitespace-nowrap border border-border hover:bg-foreground/5 transition-all flex items-center">
                    <i className="ri-calendar-line mr-1.5"></i>
                    <span>{formatDateRange()}</span>
                    {(dateRange.from || dateRange.to) && <i className="ri-check-line ml-1"></i>}
                  </button>
                </PopoverTrigger>
                <PopoverContent className="w-auto p-0" align="start">
                  <Calendar
                    initialFocus
                    mode="range"
                    defaultMonth={dateRange.from || new Date()}
                    selected={{ from: dateRange.from, to: dateRange.to }}
                    onSelect={(range) => {
                      if (range) {
                        setDateRange({ 
                          from: range.from, 
                          to: range.to || undefined 
                        });
                      } else {
                        setDateRange({ from: undefined, to: undefined });
                      }
                      setIsCalendarOpen(false);
                    }}
                    numberOfMonths={2}
                  />
                </PopoverContent>
              </Popover>
              
              {/* Status filter */}
              <SmartChip 
                label="Hanya Pending" 
                icon="ri-time-line"
                isActive={showPendingOnly}
                onClick={() => setShowPendingOnly(!showPendingOnly)}
              />
              
              {(searchTerm || selectedCategory || selectedCard || showPendingOnly || dateRange.from || dateRange.to || amountRange.min || amountRange.max) && (
                <button 
                  className="text-sm text-red-600 hover:text-red-700 flex items-center px-3 py-1.5"
                  onClick={clearAllFilters}
                >
                  <i className="ri-delete-bin-line mr-1"></i>
                  <span>Hapus Filter</span>
                </button>
              )}
            </div>
          </div>
          
          {/* Transaction timeline view */}
          {viewMode === 'timeline' && (
            <div>
              {Object.keys(groupedTransactions).length > 0 ? (
                Object.keys(groupedTransactions)
                  .sort((a, b) => {
                    // Convert Indonesian date format (DD Month YYYY) to Date objects for comparison
                    const [dayA, monthA, yearA] = a.split(' ');
                    const [dayB, monthB, yearB] = b.split(' ');
                    
                    const dateA = new Date(`${yearA}-${getMonthNumber(monthA)}-${dayA.padStart(2, '0')}`);
                    const dateB = new Date(`${yearB}-${getMonthNumber(monthB)}-${dayB.padStart(2, '0')}`);
                    
                    return dateB.getTime() - dateA.getTime(); // Sort latest first
                  })
                  .map(date => (
                    <div key={date} className="mb-6">
                      <div className="flex items-center mb-4">
                        <div className="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mr-3">
                          <i className="ri-calendar-line"></i>
                        </div>
                        <h2 className="text-lg font-semibold">{date}</h2>
                      </div>
                      
                      <div className="space-y-3">
                        {groupedTransactions[date].map(transaction => (
                          <TransactionItem 
                            key={transaction.id} 
                            transaction={transaction}
                            showDetailedView={selectedTransaction === transaction.id}
                            onClick={() => handleTransactionClick(transaction.id)}
                          />
                        ))}
                      </div>
                    </div>
                  ))
              ) : (
                <div className="text-center py-16 bg-foreground/5 rounded-xl">
                  <div className="inline-flex h-12 w-12 items-center justify-center rounded-full bg-foreground/10 mb-4">
                    <i className="ri-search-line text-xl text-foreground/40"></i>
                  </div>
                  <h3 className="text-lg font-medium mb-2">Tidak ada transaksi</h3>
                  <p className="text-foreground/60 max-w-md mx-auto">
                    Tidak ada transaksi yang sesuai dengan kriteria pencarian Anda. Coba ubah filter atau hapus pencarian.
                  </p>
                </div>
              )}
            </div>
          )}
          
          {/* Transaction analytics view */}
          {viewMode === 'analytics' && (
            <div className="space-y-6">
              <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div className="border border-border rounded-xl p-6 bg-background">
                  <h3 className="text-lg font-semibold mb-4">Pengeluaran Berdasarkan Kategori</h3>
                  
                  <div className="space-y-3">
                    {Object.entries(stats.categoryCounts)
                      .sort(([, a], [, b]) => b.amount - a.amount)
                      .map(([category, { amount, count }]) => {
                        const config = categoryConfig[category as TransactionCategory] || categoryConfig.Others;
                        const percentage = (amount / stats.totalAmount) * 100;
                        
                        return (
                          <div key={category} className="group">
                            <div className="flex items-center justify-between mb-1">
                              <div className="flex items-center">
                                <div className={`w-3 h-3 rounded-full ${config.color} mr-2`}></div>
                                <span className="font-medium">{category}</span>
                              </div>
                              <div className="text-sm">
                                Rp {amount.toLocaleString()} ({percentage.toFixed(1)}%)
                              </div>
                            </div>
                            <div className="w-full bg-foreground/10 rounded-full h-2 overflow-hidden">
                              <motion.div 
                                className={`h-2 ${config.color}`}
                                initial={{ width: 0 }}
                                animate={{ width: `${percentage}%` }}
                                transition={{ duration: 0.5 }}
                              />
                            </div>
                          </div>
                        );
                      })}
                  </div>
                </div>
                
                <div className="border border-border rounded-xl p-6 bg-background">
                  <h3 className="text-lg font-semibold mb-4">Pengeluaran Berdasarkan Kartu</h3>
                  
                  <div className="space-y-3">
                    {cards.map(card => {
                      const cardTransactions = filteredTransactions.filter(tx => 
                        tx.cardId === card.id && tx.status === 'completed'
                      );
                      
                      const totalAmount = cardTransactions.reduce((sum, tx) => sum + tx.amount, 0);
                      const percentage = stats.totalAmount ? (totalAmount / stats.totalAmount) * 100 : 0;
                      
                      const cardColor = card.issuer === 'BCA' ? 'bg-blue-500' :
                                        card.issuer === 'Mandiri' ? 'bg-green-500' :
                                        'bg-purple-500';
                      
                      return (
                        <div key={card.id} className="group">
                          <div className="flex items-center justify-between mb-1">
                            <div className="flex items-center">
                              <div className={`w-3 h-3 rounded-full ${cardColor} mr-2`}></div>
                              <span className="font-medium">{card.issuer} {card.name}</span>
                            </div>
                            <div className="text-sm">
                              Rp {totalAmount.toLocaleString()} ({percentage.toFixed(1)}%)
                            </div>
                          </div>
                          <div className="w-full bg-foreground/10 rounded-full h-2 overflow-hidden">
                            <motion.div 
                              className={`h-2 ${cardColor}`}
                              initial={{ width: 0 }}
                              animate={{ width: `${percentage}%` }}
                              transition={{ duration: 0.5 }}
                            />
                          </div>
                        </div>
                      );
                    })}
                  </div>
                </div>
              </div>
              
              <div className="border border-border rounded-xl p-6 bg-background">
                <h3 className="text-lg font-semibold mb-4">Smart Insights</h3>
                
                <div className="space-y-4">
                  {filteredTransactions.length > 0 && (
                    <>
                      <div className="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg">
                        <div className="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                          <i className="ri-line-chart-line"></i>
                        </div>
                        <div>
                          <div className="font-medium">Pola Pengeluaran</div>
                          <p className="text-sm text-foreground/70 mt-1">
                            Kategori pengeluaran terbesar Anda bulan ini adalah <span className="font-medium">{
                              Object.entries(stats.categoryCounts)
                                .sort(([, a], [, b]) => b.amount - a.amount)[0]?.[0] || 'None'
                            }</span> sebesar Rp {
                              Object.entries(stats.categoryCounts)
                                .sort(([, a], [, b]) => b.amount - a.amount)[0]?.[1].amount.toLocaleString() || '0'
                            }
                          </p>
                        </div>
                      </div>
                      
                      {stats.flaggedCount > 0 && (
                        <div className="flex items-start space-x-3 p-3 bg-red-50 rounded-lg">
                          <div className="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center text-red-600 flex-shrink-0">
                            <i className="ri-error-warning-line"></i>
                          </div>
                          <div>
                            <div className="font-medium">Transaksi Mencurigakan</div>
                            <p className="text-sm text-foreground/70 mt-1">
                              Ditemukan {stats.flaggedCount} transaksi mencurigakan yang memerlukan perhatian Anda.
                            </p>
                          </div>
                        </div>
                      )}
                      
                      {filteredTransactions.some(tx => tx.recurrenceFrequency) && (
                        <div className="flex items-start space-x-3 p-3 bg-purple-50 rounded-lg">
                          <div className="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 flex-shrink-0">
                            <i className="ri-repeat-line"></i>
                          </div>
                          <div>
                            <div className="font-medium">Langganan Terdeteksi</div>
                            <p className="text-sm text-foreground/70 mt-1">
                              Anda memiliki {filteredTransactions.filter(tx => tx.recurrenceFrequency).length} langganan aktif dengan total Rp {
                                filteredTransactions
                                  .filter(tx => tx.recurrenceFrequency)
                                  .reduce((sum, tx) => sum + tx.amount, 0)
                                  .toLocaleString()
                              } per bulan.
                            </p>
                          </div>
                        </div>
                      )}
                    </>
                  )}
                </div>
              </div>
            </div>
          )}
        </div>
      </main>
      
      <Footer />
    </div>
  );
};

export default TransactionsPage;