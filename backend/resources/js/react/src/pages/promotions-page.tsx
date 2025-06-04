import React, { useState, useEffect, useMemo } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { ModernDashboardTopbar } from './dashboard-home-page';
import Footer from '@/components/Footer';
import {
  Tabs,
  TabsContent,
  TabsList,
  TabsTrigger,
} from "@/components/ui/tabs";
import {
  Slider
} from "@/components/ui/slider";
import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from "@/components/ui/popover";
import { Calendar } from "@/components/ui/calendar";
import { DateRange } from 'react-day-picker';
import { format } from "date-fns";
import { id } from 'date-fns/locale';

// Define promotion data types
interface Promotion {
  id: string;
  title: string;
  description: string;
  bank: string;
  category: PromotionCategory;
  discount: {
    type: 'percentage' | 'fixed' | 'cashback' | 'points';
    value: number;
  };
  validFrom: string;
  validUntil: string;
  merchant: string;
  cardTypes: string[];
  minimumSpend?: number;
  maximumDiscount?: number;
  termsAndConditions: string[];
  locations: string[];
  image: string;
  featured: boolean;
  isLimited: boolean;
  limitedCount?: number;
  usageLimit?: number;
  code?: string;
  requiresActivation: boolean;
  activationMethod?: string;
  tags: string[];
  redemptionChannel: ('online' | 'in-store' | 'both')[];
  rating: number;
  reviewCount: number;
  used?: boolean;
  saved?: boolean;
}

type PromotionCategory = 
  | 'Travel' 
  | 'Dining' 
  | 'Shopping' 
  | 'Entertainment' 
  | 'Grocery' 
  | 'Transportation' 
  | 'Utilities' 
  | 'Digital Services'
  | 'Health'
  | 'Education'
  | 'Finance'
  | 'Lifestyle';

// Category configuration
const categoryConfig: Record<PromotionCategory, { icon: string, color: string }> = {
  'Travel': { icon: 'ri-plane-line', color: 'bg-blue-500' },
  'Dining': { icon: 'ri-restaurant-line', color: 'bg-red-500' },
  'Shopping': { icon: 'ri-shopping-bag-line', color: 'bg-purple-500' },
  'Entertainment': { icon: 'ri-movie-line', color: 'bg-indigo-500' },
  'Grocery': { icon: 'ri-store-line', color: 'bg-green-500' },
  'Transportation': { icon: 'ri-car-line', color: 'bg-yellow-500' },
  'Utilities': { icon: 'ri-lightbulb-line', color: 'bg-orange-500' },
  'Digital Services': { icon: 'ri-computer-line', color: 'bg-cyan-500' },
  'Health': { icon: 'ri-heart-pulse-line', color: 'bg-pink-500' },
  'Education': { icon: 'ri-book-open-line', color: 'bg-emerald-500' },
  'Finance': { icon: 'ri-bank-line', color: 'bg-blue-700' },
  'Lifestyle': { icon: 'ri-shirt-line', color: 'bg-violet-500' }
};

// Bank configuration
const banks = [
  { id: 'bca', name: 'BCA', color: 'bg-blue-100 text-blue-800' },
  { id: 'mandiri', name: 'Mandiri', color: 'bg-green-100 text-green-800' },
  { id: 'bni', name: 'BNI', color: 'bg-purple-100 text-purple-800' },
  { id: 'bri', name: 'BRI', color: 'bg-red-100 text-red-800' },
  { id: 'cimb', name: 'CIMB Niaga', color: 'bg-red-100 text-red-800' },
  { id: 'citibank', name: 'Citibank', color: 'bg-blue-100 text-blue-800' },
  { id: 'uob', name: 'UOB', color: 'bg-blue-100 text-blue-800' },
  { id: 'ocbc', name: 'OCBC NISP', color: 'bg-red-100 text-red-800' },
  { id: 'hsbc', name: 'HSBC', color: 'bg-red-100 text-red-800' },
  { id: 'danamon', name: 'Danamon', color: 'bg-orange-100 text-orange-800' },
  { id: 'mega', name: 'Bank Mega', color: 'bg-red-100 text-red-800' },
  { id: 'all', name: 'Semua Bank', color: 'bg-gray-100 text-gray-800' }
];

// Card types
const cardTypes = [
  { id: 'visa', name: 'Visa', icon: 'ri-visa-line' },
  { id: 'mastercard', name: 'Mastercard', icon: 'ri-mastercard-line' },
  { id: 'jcb', name: 'JCB', icon: 'ri-bank-card-line' },
  { id: 'amex', name: 'American Express', icon: 'ri-bank-card-line' },
  { id: 'all', name: 'All Cards', icon: 'ri-bank-card-fill' }
];

// Locations for filtering
const locations = [
  'Jakarta', 'Bandung', 'Surabaya', 'Bali', 'Medan', 'Makassar', 
  'Yogyakarta', 'Semarang', 'Palembang', 'Balikpapan', 'Online', 'Nasional'
];

// Generate promotion data
const generatePromotions = (): Promotion[] => {
  return [
    {
      id: 'promo1',
      title: 'Diskon 50% di Starbucks',
      description: 'Nikmati diskon 50% untuk minuman favorit Anda di Starbucks setiap hari Jumat',
      bank: 'bca',
      category: 'Dining',
      discount: {
        type: 'percentage',
        value: 50
      },
      validFrom: '01 Mei 2025',
      validUntil: '31 Mei 2025',
      merchant: 'Starbucks',
      cardTypes: ['visa', 'mastercard'],
      minimumSpend: 100000,
      maximumDiscount: 75000,
      termsAndConditions: [
        'Berlaku setiap hari Jumat',
        'Maksimal diskon Rp 75.000',
        'Minimum transaksi Rp 100.000',
        'Tidak dapat digabung dengan promo lain'
      ],
      locations: ['Jakarta', 'Bandung', 'Surabaya', 'Bali'],
      image: 'https://images.unsplash.com/photo-1589476993333-f55b84301219?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTZ8fHN0YXJidWNrc3xlbnwwfHwwfHx8MA%3D%3D',
      featured: true,
      isLimited: false,
      requiresActivation: false,
      tags: ['coffee', 'weekendpromo', 'dining'],
      redemptionChannel: ['in-store'],
      rating: 4.5,
      reviewCount: 128,
      saved: true
    },
    {
      id: 'promo2',
      title: 'Cashback 10% Tokopedia',
      description: 'Dapatkan cashback 10% untuk setiap transaksi di Tokopedia menggunakan kartu Visa BCA',
      bank: 'bca',
      category: 'Shopping',
      discount: {
        type: 'cashback',
        value: 10
      },
      validFrom: '01 Mei 2025',
      validUntil: '30 Jun 2025',
      merchant: 'Tokopedia',
      cardTypes: ['visa'],
      minimumSpend: 500000,
      maximumDiscount: 100000,
      termsAndConditions: [
        'Berlaku untuk semua kategori produk',
        'Maksimal cashback Rp 100.000',
        'Minimum transaksi Rp 500.000',
        'Diterima dalam bentuk kredit pada statement bulan berikutnya'
      ],
      locations: ['Online'],
      image: 'https://images.unsplash.com/photo-1563013544-824ae1b704d3?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8b25saW5lJTIwc2hvcHBpbmd8ZW58MHx8MHx8fDA%3D',
      featured: true,
      isLimited: true,
      limitedCount: 5000,
      requiresActivation: true,
      activationMethod: 'SMS ke 12345 dengan format BCA TOPED',
      tags: ['onlineshopping', 'cashback', 'ecommerce'],
      redemptionChannel: ['online'],
      rating: 4.8,
      reviewCount: 532
    },
    {
      id: 'promo3',
      title: 'Buy 1 Get 1 Free di CGV',
      description: 'Beli 1 tiket dapat 1 tiket gratis di CGV dengan kartu Mastercard Mandiri',
      bank: 'mandiri',
      category: 'Entertainment',
      discount: {
        type: 'fixed',
        value: 100
      },
      validFrom: '01 Mei 2025',
      validUntil: '30 Sep 2025',
      merchant: 'CGV',
      cardTypes: ['mastercard'],
      termsAndConditions: [
        'Berlaku untuk film regular 2D',
        'Tidak berlaku untuk premier seats, Velvet, 4DX, dan Sweetbox',
        'Tidak berlaku pada hari libur nasional',
        'Tiket gratis dengan nilai yang sama atau lebih rendah'
      ],
      locations: ['Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta'],
      image: 'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8bW92aWUlMjB0aGVhdGVyfGVufDB8fDB8fHww',
      featured: false,
      isLimited: false,
      requiresActivation: false,
      tags: ['movie', 'entertainment', 'buyonegetone'],
      redemptionChannel: ['in-store'],
      rating: 4.2,
      reviewCount: 74
    },
    {
      id: 'promo4',
      title: '5x Poin di SPBU Shell',
      description: 'Dapatkan 5x poin untuk setiap transaksi di SPBU Shell menggunakan kartu BNI JCB',
      bank: 'bni',
      category: 'Transportation',
      discount: {
        type: 'points',
        value: 5
      },
      validFrom: '15 Mei 2025',
      validUntil: '15 Aug 2025',
      merchant: 'Shell',
      cardTypes: ['jcb'],
      minimumSpend: 200000,
      termsAndConditions: [
        'Berlaku untuk semua jenis bahan bakar',
        'Minimum transaksi Rp 200.000',
        'Bonus poin akan dikreditkan dalam 14 hari kerja',
        'Tidak berlaku untuk pembayaran non-bahan bakar'
      ],
      locations: ['Jakarta', 'Bandung', 'Surabaya', 'Bali', 'Medan', 'Makassar', 'Nasional'],
      image: 'https://images.unsplash.com/photo-1601784551446-20c9e07cdbdb?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8Z2FzJTIwc3RhdGlvbnxlbnwwfHwwfHx8MA%3D%3D',
      featured: false,
      isLimited: false,
      requiresActivation: false,
      tags: ['fuel', 'points', 'transportation'],
      redemptionChannel: ['in-store'],
      rating: 4.0,
      reviewCount: 128
    },
    {
      id: 'promo5',
      title: 'Diskon 30% di Zalora',
      description: 'Belanja fashion di Zalora dengan diskon 30% menggunakan kartu kredit Citibank',
      bank: 'citibank',
      category: 'Shopping',
      discount: {
        type: 'percentage',
        value: 30
      },
      validFrom: '01 Mei 2025',
      validUntil: '31 Jul 2025',
      merchant: 'Zalora',
      cardTypes: ['visa', 'mastercard'],
      minimumSpend: 750000,
      maximumDiscount: 300000,
      termsAndConditions: [
        'Berlaku untuk semua produk non-sale',
        'Minimum transaksi Rp 750.000',
        'Maksimal diskon Rp 300.000',
        'Gunakan kode CITIZALORA30 saat checkout'
      ],
      locations: ['Online'],
      image: 'https://images.unsplash.com/photo-1560243563-062bfc001d68?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTV8fGZhc2hpb24lMjBzdG9yZXxlbnwwfHwwfHx8MA%3D%3D',
      featured: true,
      isLimited: false,
      code: 'CITIZALORA30',
      requiresActivation: false,
      tags: ['fashion', 'online', 'shopping'],
      redemptionChannel: ['online'],
      rating: 4.7,
      reviewCount: 216
    },
    {
      id: 'promo6',
      title: 'Diskon 20% di Sushi Tei',
      description: 'Nikmati hidangan Jepang favorit di Sushi Tei dengan diskon 20% menggunakan kartu CIMB Niaga',
      bank: 'cimb',
      category: 'Dining',
      discount: {
        type: 'percentage',
        value: 20
      },
      validFrom: '01 Mei 2025',
      validUntil: '30 Jun 2025',
      merchant: 'Sushi Tei',
      cardTypes: ['visa', 'mastercard'],
      minimumSpend: 300000,
      termsAndConditions: [
        'Berlaku setiap hari termasuk hari libur',
        'Minimum transaksi Rp 300.000',
        'Tidak dapat digabung dengan promo lain',
        'Berlaku untuk dine-in saja'
      ],
      locations: ['Jakarta', 'Bandung', 'Surabaya', 'Bali'],
      image: 'https://images.unsplash.com/photo-1611143669185-af224c5e3252?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8c3VzaGl8ZW58MHx8MHx8fDA%3D',
      featured: false,
      isLimited: false,
      requiresActivation: false,
      tags: ['japanese', 'dining', 'sushi'],
      redemptionChannel: ['in-store'],
      rating: 4.4,
      reviewCount: 87
    },
    {
      id: 'promo7',
      title: 'Cashback 5% untuk Tagihan Listrik',
      description: 'Dapatkan cashback 5% untuk pembayaran tagihan listrik melalui internet banking BRI',
      bank: 'bri',
      category: 'Utilities',
      discount: {
        type: 'cashback',
        value: 5
      },
      validFrom: '01 Mei 2025',
      validUntil: '31 Dec 2025',
      merchant: 'PLN',
      cardTypes: ['visa', 'mastercard'],
      maximumDiscount: 50000,
      termsAndConditions: [
        'Berlaku untuk pembayaran melalui Internet Banking atau Mobile Banking BRI',
        'Maksimal cashback Rp 50.000 per bulan',
        'Cashback akan dikreditkan pada akhir bulan'
      ],
      locations: ['Online', 'Nasional'],
      image: 'https://images.unsplash.com/photo-1626962133832-ea37fbac8b12?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTR8fGVsZWN0cmljaXR5fGVufDB8fDB8fHww',
      featured: false,
      isLimited: false,
      requiresActivation: false,
      tags: ['utilities', 'bill', 'cashback'],
      redemptionChannel: ['online'],
      rating: 4.1,
      reviewCount: 63
    },
    {
      id: 'promo8',
      title: 'Diskon 40% di Agoda',
      description: 'Rencanakan liburan Anda dengan diskon 40% untuk pemesanan hotel di Agoda',
      bank: 'mandiri',
      category: 'Travel',
      discount: {
        type: 'percentage',
        value: 40
      },
      validFrom: '01 Mei 2025',
      validUntil: '31 Aug 2025',
      merchant: 'Agoda',
      cardTypes: ['visa', 'mastercard'],
      minimumSpend: 1000000,
      maximumDiscount: 1000000,
      termsAndConditions: [
        'Berlaku untuk pemesanan hotel di seluruh dunia',
        'Minimum transaksi Rp 1.000.000',
        'Maksimal diskon Rp 1.000.000',
        'Gunakan kode MANDIRIAGODA40'
      ],
      locations: ['Online'],
      image: 'https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MjB8fGhvdGVsfGVufDB8fDB8fHww',
      featured: true,
      isLimited: false,
      code: 'MANDIRIAGODA40',
      requiresActivation: false,
      tags: ['travel', 'hotel', 'vacation'],
      redemptionChannel: ['online'],
      rating: 4.9,
      reviewCount: 312,
      used: true
    },
    {
      id: 'promo9',
      title: 'Diskon 25% di Guardian',
      description: 'Belanja produk kesehatan dan kecantikan di Guardian dengan diskon 25%',
      bank: 'bni',
      category: 'Health',
      discount: {
        type: 'percentage',
        value: 25
      },
      validFrom: '15 May 2025',
      validUntil: '15 Jun 2025',
      merchant: 'Guardian',
      cardTypes: ['visa', 'mastercard', 'jcb'],
      minimumSpend: 200000,
      termsAndConditions: [
        'Berlaku untuk semua produk kecuali susu formula dan obat resep',
        'Minimum transaksi Rp 200.000',
        'Tidak dapat digabung dengan promo lain'
      ],
      locations: ['Jakarta', 'Bandung', 'Surabaya', 'Bali', 'Medan', 'Makassar', 'Yogyakarta', 'Semarang'],
      image: 'https://images.unsplash.com/photo-1607619056574-7b8d3ee536b2?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTB8fHBoYXJtYWN5fGVufDB8fDB8fHww',
      featured: false,
      isLimited: true,
      limitedCount: 10000,
      requiresActivation: false,
      tags: ['health', 'beauty', 'pharmacy'],
      redemptionChannel: ['in-store'],
      rating: 4.3,
      reviewCount: 168
    },
    {
      id: 'promo10',
      title: 'Cicilan 0% di Power Mac Center',
      description: 'Beli produk Apple dengan cicilan 0% selama 12 bulan di Power Mac Center',
      bank: 'bca',
      category: 'Digital Services',
      discount: {
        type: 'fixed',
        value: 0
      },
      validFrom: '01 Mei 2025',
      validUntil: '31 Jul 2025',
      merchant: 'Power Mac Center',
      cardTypes: ['visa', 'mastercard'],
      minimumSpend: 5000000,
      termsAndConditions: [
        'Berlaku untuk semua produk Apple',
        'Minimum transaksi Rp 5.000.000',
        'Cicilan 0% hingga 12 bulan',
        'Dikenakan biaya admin 1% dari total transaksi'
      ],
      locations: ['Jakarta', 'Bandung', 'Surabaya', 'Bali'],
      image: 'https://images.unsplash.com/photo-1581993192008-63a3b5633df6?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8N3x8YXBwbGUlMjBzdG9yZXxlbnwwfHwwfHx8MA%3D%3D',
      featured: false,
      isLimited: false,
      requiresActivation: false,
      tags: ['apple', 'electronics', 'installment'],
      redemptionChannel: ['in-store', 'online'],
      rating: 4.6,
      reviewCount: 92
    },
    {
      id: 'promo11',
      title: 'Diskon 15% di Gramedia',
      description: 'Belanja buku dan alat tulis di Gramedia dengan diskon 15%',
      bank: 'mandiri',
      category: 'Education',
      discount: {
        type: 'percentage',
        value: 15
      },
      validFrom: '01 Mei 2025',
      validUntil: '30 Jun 2025',
      merchant: 'Gramedia',
      cardTypes: ['visa', 'mastercard'],
      minimumSpend: 150000,
      termsAndConditions: [
        'Berlaku untuk semua buku dan alat tulis',
        'Minimum transaksi Rp 150.000',
        'Tidak berlaku untuk majalah dan buku import'
      ],
      locations: ['Jakarta', 'Bandung', 'Surabaya', 'Bali', 'Medan', 'Makassar', 'Yogyakarta', 'Semarang', 'Nasional'],
      image: 'https://images.unsplash.com/photo-1507842217343-583bb7270b66?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8Ym9va3N0b3JlfGVufDB8fDB8fHww',
      featured: false,
      isLimited: false,
      requiresActivation: false,
      tags: ['books', 'education', 'stationery'],
      redemptionChannel: ['in-store'],
      rating: 4.4,
      reviewCount: 203
    },
    {
      id: 'promo12',
      title: 'Gratis Biaya Admin Top Up GoPay',
      description: 'Nikmati gratis biaya admin untuk top up GoPay melalui internet banking OCBC NISP',
      bank: 'ocbc',
      category: 'Finance',
      discount: {
        type: 'fixed',
        value: 100
      },
      validFrom: '01 Mei 2025',
      validUntil: '31 Dec 2025',
      merchant: 'GoPay',
      cardTypes: ['visa', 'mastercard'],
      termsAndConditions: [
        'Berlaku untuk top up melalui Internet Banking atau Mobile Banking OCBC NISP',
        'Tidak ada batasan jumlah transaksi',
        'Setiap top up dikenakan cashback sebesar biaya admin'
      ],
      locations: ['Online', 'Nasional'],
      image: 'https://images.unsplash.com/photo-1556742502-ec7c0e9f34b1?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8d2FsbGV0fGVufDB8fDB8fHww',
      featured: false,
      isLimited: false,
      requiresActivation: false,
      tags: ['ewallet', 'topup', 'digital'],
      redemptionChannel: ['online'],
      rating: 4.2,
      reviewCount: 84
    },
    {
      id: 'promo13',
      title: 'Diskon 10% di Ace Hardware',
      description: 'Belanja perlengkapan rumah di Ace Hardware dengan diskon 10%',
      bank: 'mega',
      category: 'Lifestyle',
      discount: {
        type: 'percentage',
        value: 10
      },
      validFrom: '01 Mei 2025',
      validUntil: '31 Jul 2025',
      merchant: 'Ace Hardware',
      cardTypes: ['visa', 'mastercard'],
      minimumSpend: 500000,
      termsAndConditions: [
        'Berlaku untuk semua produk',
        'Minimum transaksi Rp 500.000',
        'Tidak dapat digabung dengan promo lain'
      ],
      locations: ['Jakarta', 'Bandung', 'Surabaya', 'Bali', 'Medan', 'Makassar', 'Yogyakarta', 'Semarang', 'Nasional'],
      image: 'https://images.unsplash.com/photo-1581783898377-1c85bf937427?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTB8fGhhcmR3YXJlJTIwc3RvcmV8ZW58MHx8MHx8fDA%3D',
      featured: false,
      isLimited: false,
      requiresActivation: false,
      tags: ['hardware', 'home', 'lifestyle'],
      redemptionChannel: ['in-store'],
      rating: 4.0,
      reviewCount: 78
    },
    {
      id: 'promo14',
      title: 'Diskon 20% di Baskin Robbins',
      description: 'Nikmati diskon 20% untuk pembelian es krim di Baskin Robbins',
      bank: 'hsbc',
      category: 'Dining',
      discount: {
        type: 'percentage',
        value: 20
      },
      validFrom: '01 Mei 2025',
      validUntil: '31 May 2025',
      merchant: 'Baskin Robbins',
      cardTypes: ['visa', 'mastercard'],
      termsAndConditions: [
        'Berlaku setiap hari',
        'Tidak ada minimum transaksi',
        'Tidak dapat digabung dengan promo lain',
        'Berlaku untuk dine-in dan take away'
      ],
      locations: ['Jakarta', 'Bandung', 'Surabaya', 'Bali'],
      image: 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8aWNlJTIwY3JlYW18ZW58MHx8MHx8fDA%3D',
      featured: false,
      isLimited: false,
      requiresActivation: false,
      tags: ['icecream', 'dessert', 'dining'],
      redemptionChannel: ['in-store'],
      rating: 4.5,
      reviewCount: 156
    },
    {
      id: 'promo15',
      title: 'Bonus 1000 Poin di Indomaret',
      description: 'Belanja di Indomaret dan dapatkan bonus 1000 poin dengan minimum transaksi',
      bank: 'bri',
      category: 'Grocery',
      discount: {
        type: 'points',
        value: 1000
      },
      validFrom: '01 Mei 2025',
      validUntil: '31 Mei 2025',
      merchant: 'Indomaret',
      cardTypes: ['visa', 'mastercard'],
      minimumSpend: 200000,
      termsAndConditions: [
        'Berlaku untuk semua produk',
        'Minimum transaksi Rp 200.000',
        'Bonus poin akan dikreditkan dalam 7 hari kerja',
        'Berlaku hanya untuk 1 transaksi per hari'
      ],
      locations: ['Nasional'],
      image: 'https://images.unsplash.com/photo-1604719312566-8912e9667d9f?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8Z3JvY2VyeXxlbnwwfHwwfHx8MA%3D%3D',
      featured: false,
      isLimited: true,
      limitedCount: 20000,
      requiresActivation: false,
      tags: ['grocery', 'convenience', 'points'],
      redemptionChannel: ['in-store'],
      rating: 4.3,
      reviewCount: 267
    },
    {
      id: 'promo16',
      title: 'Cashback 20% di Lazada',
      description: 'Belanja online di Lazada dan dapatkan cashback 20% untuk kategori elektronik',
      bank: 'danamon',
      category: 'Shopping',
      discount: {
        type: 'cashback',
        value: 20
      },
      validFrom: '20 Mei 2025',
      validUntil: '20 Jun 2025',
      merchant: 'Lazada',
      cardTypes: ['visa', 'mastercard'],
      minimumSpend: 1000000,
      maximumDiscount: 500000,
      termsAndConditions: [
        'Berlaku untuk kategori elektronik',
        'Minimum transaksi Rp 1.000.000',
        'Maksimal cashback Rp 500.000',
        'Gunakan kode DANAMONELEK20'
      ],
      locations: ['Online'],
      image: 'https://images.unsplash.com/photo-1555774698-0b77e0d5fac6?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NHx8ZWxlY3Ryb25pY3N8ZW58MHx8MHx8fDA%3D',
      featured: true,
      isLimited: false,
      code: 'DANAMONELEK20',
      requiresActivation: false,
      tags: ['electronics', 'online', 'cashback'],
      redemptionChannel: ['online'],
      rating: 4.7,
      reviewCount: 352
    },
    {
      id: 'promo17',
      title: 'Diskon 30% di Fitness First',
      description: 'Dapatkan diskon 30% untuk membership baru di Fitness First',
      bank: 'citibank',
      category: 'Lifestyle',
      discount: {
        type: 'percentage',
        value: 30
      },
      validFrom: '01 Mei 2025',
      validUntil: '30 Jun 2025',
      merchant: 'Fitness First',
      cardTypes: ['visa', 'mastercard'],
      termsAndConditions: [
        'Berlaku untuk membership baru',
        'Minimum pendaftaran 6 bulan',
        'Tidak dapat digabung dengan promo lain',
        'Pembayaran harus menggunakan kartu kredit Citibank'
      ],
      locations: ['Jakarta', 'Bandung', 'Surabaya'],
      image: 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8Z3ltfGVufDB8fDB8fHww',
      featured: false,
      isLimited: false,
      requiresActivation: true,
      activationMethod: 'Tunjukkan kartu kredit Citibank saat mendaftar di lokasi',
      tags: ['fitness', 'gym', 'lifestyle'],
      redemptionChannel: ['in-store'],
      rating: 4.5,
      reviewCount: 87
    },
    {
      id: 'promo18',
      title: 'Diskon 35% di Tiket Garuda Indonesia',
      description: 'Rencanakan perjalanan Anda dengan diskon 35% untuk tiket pesawat Garuda Indonesia',
      bank: 'bni',
      category: 'Travel',
      discount: {
        type: 'percentage',
        value: 35
      },
      validFrom: '01 Mei 2025',
      validUntil: '31 Jul 2025',
      merchant: 'Garuda Indonesia',
      cardTypes: ['visa', 'mastercard', 'jcb'],
      termsAndConditions: [
        'Berlaku untuk semua rute domestik dan internasional',
        'Berlaku untuk kelas ekonomi dan bisnis',
        'Blackout dates: 1-5 Juni 2025, 10-20 Juli 2025',
        'Pemesanan harus dilakukan di website resmi Garuda Indonesia'
      ],
      locations: ['Online'],
      image: 'https://images.unsplash.com/photo-1569154941061-e231b4725ef1?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Nnx8YWlycGxhbmV8ZW58MHx8MHx8fDA%3D',
      featured: true,
      isLimited: false,
      code: 'BNIGARUDA35',
      requiresActivation: false,
      tags: ['travel', 'flight', 'airline'],
      redemptionChannel: ['online'],
      rating: 4.8,
      reviewCount: 412
    },
    {
      id: 'promo19',
      title: 'Diskon 50% di IMAX Cinema',
      description: 'Nikmati pengalaman menonton film terbaik di IMAX dengan diskon 50%',
      bank: 'bca',
      category: 'Entertainment',
      discount: {
        type: 'percentage',
        value: 50
      },
      validFrom: '15 Mei 2025',
      validUntil: '15 Jun 2025',
      merchant: 'IMAX',
      cardTypes: ['visa'],
      termsAndConditions: [
        'Berlaku setiap hari Senin-Kamis',
        'Maksimal 2 tiket per transaksi',
        'Tidak berlaku pada tanggal merah dan hari libur nasional',
        'Tidak dapat digabung dengan promo lain'
      ],
      locations: ['Jakarta', 'Bandung', 'Surabaya'],
      image: 'https://images.unsplash.com/photo-1595769816263-9b910be24d5f?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OHx8bW92aWUlMjB0aGVhdGVyfGVufDB8fDB8fHww',
      featured: true,
      isLimited: true,
      limitedCount: 5000,
      requiresActivation: false,
      tags: ['movie', 'imax', 'entertainment'],
      redemptionChannel: ['in-store'],
      rating: 4.9,
      reviewCount: 186
    },
    {
      id: 'promo20',
      title: 'Diskon 25% di Ismaya Restaurants',
      description: 'Nikmati hidangan lezat di restoran Ismaya Group dengan diskon 25%',
      bank: 'mandiri',
      category: 'Dining',
      discount: {
        type: 'percentage',
        value: 25
      },
      validFrom: '01 Mei 2025',
      validUntil: '31 Aug 2025',
      merchant: 'Ismaya Group',
      cardTypes: ['visa', 'mastercard'],
      minimumSpend: 500000,
      termsAndConditions: [
        'Berlaku di semua outlet Ismaya Group (SKYE, Social House, Pizza e Birra, dll)',
        'Minimum transaksi Rp 500.000',
        'Berlaku setiap hari termasuk hari libur',
        'Tidak dapat digabung dengan promo lain'
      ],
      locations: ['Jakarta', 'Bali'],
      image: 'https://images.unsplash.com/photo-1550966871-3ed3cdb5ed0c?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTR8fHJlc3RhdXJhbnR8ZW58MHx8MHx8fDA%3D',
      featured: false,
      isLimited: false,
      requiresActivation: false,
      tags: ['dining', 'restaurant', 'ismaya'],
      redemptionChannel: ['in-store'],
      rating: 4.6,
      reviewCount: 278,
      saved: true
    }
  ];
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
      className={`rounded-full px-3 py-1.5 text-sm font-medium whitespace-nowrap transition-all flex-shrink-0 ${
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

// PromotionCard component
const PromotionCard = ({ 
  promotion, 
  onClick 
}: { 
  promotion: Promotion; 
  onClick?: () => void; 
}) => {
  const bank = banks.find(b => b.id === promotion.bank);
  const categoryInfo = categoryConfig[promotion.category];
  
  return (
    <motion.div 
      className="border border-border rounded-xl overflow-hidden bg-background transition-all hover:shadow-md"
      initial={{ opacity: 0, y: 10 }}
      animate={{ opacity: 1, y: 0 }}
      whileHover={{ y: -5 }}
      onClick={onClick}
    >
      <div className="relative h-48 overflow-hidden">
        <img 
          src={promotion.image} 
          alt={promotion.title} 
          className="w-full h-full object-cover transition-transform hover:scale-110"
        />
        <div className="absolute top-0 left-0 right-0 p-3 flex justify-between">
          <div className={`px-2 py-1 rounded-lg ${bank?.color || 'bg-gray-100'} text-xs font-medium`}>
            {bank?.name}
          </div>
          <div className="flex space-x-1">
            {promotion.featured && (
              <div className="bg-blue-600 text-white px-2 py-1 rounded-lg text-xs font-medium">
                Featured
              </div>
            )}
            {promotion.isLimited && (
              <div className="bg-orange-600 text-white px-2 py-1 rounded-lg text-xs font-medium">
                Limited
              </div>
            )}
          </div>
        </div>
        
        <div className="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-3 text-white">
          <div className="flex items-center space-x-1 text-xs">
            <i className={categoryInfo?.icon || 'ri-store-line'}></i>
            <span>{promotion.category}</span>
            <span className="mx-1">•</span>
            <div className="flex items-center">
              <i className="ri-star-fill text-yellow-400 mr-1"></i>
              <span>{promotion.rating.toFixed(1)}</span>
            </div>
          </div>
        </div>
        
        {promotion.saved && (
          <div className="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/80 backdrop-blur-sm flex items-center justify-center text-red-500">
            <i className="ri-heart-fill"></i>
          </div>
        )}
        
        {promotion.used && (
          <div className="absolute inset-0 bg-black/50 flex items-center justify-center">
            <div className="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-lg text-white font-medium border border-white/30 transform -rotate-12">
              Digunakan
            </div>
          </div>
        )}
      </div>
      
      <div className="p-4">
        <h3 className="font-medium text-lg mb-1 line-clamp-1">{promotion.title}</h3>
        <p className="text-foreground/70 text-sm mb-3 line-clamp-2">{promotion.description}</p>
        
        <div className="flex justify-between items-center">
          <div className="flex space-x-1">
            {promotion.cardTypes.map(card => {
              const cardTypeInfo = cardTypes.find(c => c.id === card);
              return (
                <div key={card} className="w-7 h-7 rounded-full bg-foreground/5 flex items-center justify-center text-foreground/70" title={cardTypeInfo?.name}>
                  <i className={cardTypeInfo?.icon || 'ri-bank-card-line'}></i>
                </div>
              );
            })}
          </div>
          
          <div className="text-right">
            <div className="text-base font-bold text-blue-600">
              {promotion.discount.type === 'percentage' ? `${promotion.discount.value}% OFF` :
               promotion.discount.type === 'cashback' ? `${promotion.discount.value}% Cashback` :
               promotion.discount.type === 'points' ? `${promotion.discount.value} Poin` :
               promotion.discount.type === 'fixed' && promotion.discount.value === 0 ? 'Cicilan 0%' :
               `Rp ${promotion.discount.value.toLocaleString()} OFF`}
            </div>
            <div className="text-xs text-foreground/60">
              {new Date(promotion.validUntil.split(' ').reverse().join('-')).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })}
            </div>
          </div>
        </div>
      </div>
    </motion.div>
  );
};

// PromotionDetailModal component
const PromotionDetailModal = ({ 
  promotion, 
  onClose 
}: { 
  promotion: Promotion | null; 
  onClose: () => void; 
}) => {
  if (!promotion) return null;
  
  const bank = banks.find(b => b.id === promotion.bank);
  const categoryInfo = categoryConfig[promotion.category];
  
  return (
    <AnimatePresence>
      <motion.div
        className="fixed inset-0 flex items-center justify-center z-50 bg-black/50 p-4 overflow-y-auto"
        initial={{ opacity: 0 }}
        animate={{ opacity: 1 }}
        exit={{ opacity: 0 }}
        onClick={onClose}
      >
        <motion.div
          className="bg-background rounded-xl shadow-xl overflow-hidden max-w-4xl w-full max-h-[90vh] overflow-y-auto"
          initial={{ scale: 0.9, opacity: 0 }}
          animate={{ scale: 1, opacity: 1 }}
          exit={{ scale: 0.9, opacity: 0 }}
          onClick={e => e.stopPropagation()}
        >
          <div className="relative h-64 sm:h-80">
            <img 
              src={promotion.image} 
              alt={promotion.title} 
              className="w-full h-full object-cover"
            />
            <button
              className="absolute top-4 right-4 w-8 h-8 rounded-full bg-black/30 backdrop-blur-sm text-white flex items-center justify-center hover:bg-black/50 transition-colors"
              onClick={onClose}
            >
              <i className="ri-close-line"></i>
            </button>
            <div className="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-6 text-white">
              <div className="flex items-center space-x-2 mb-2">
                <div className={`px-3 py-1 rounded-lg ${bank?.color?.replace('text-', 'text-white ') || 'bg-gray-100'} text-sm font-medium`}>
                  {bank?.name}
                </div>
                <div className={`px-3 py-1 rounded-lg ${categoryInfo?.color || 'bg-blue-500'} text-sm font-medium flex items-center`}>
                  <i className={`${categoryInfo?.icon || 'ri-store-line'} mr-1.5`}></i>
                  {promotion.category}
                </div>
              </div>
              <h2 className="text-2xl font-bold">{promotion.title}</h2>
            </div>
          </div>
          
          <div className="p-6">
            <div className="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">
              <div>
                <p className="text-lg mb-2">{promotion.description}</p>
                <div className="flex items-center text-sm text-foreground/70">
                  <span>Merchant: {promotion.merchant}</span>
                  <span className="mx-2">•</span>
                  <div className="flex items-center">
                    <i className="ri-star-fill text-yellow-400 mr-1"></i>
                    <span>{promotion.rating.toFixed(1)} ({promotion.reviewCount} reviews)</span>
                  </div>
                </div>
              </div>
              
              <div className="flex flex-col items-end">
                <div className="text-xl font-bold text-blue-600 mb-1">
                  {promotion.discount.type === 'percentage' ? `${promotion.discount.value}% OFF` :
                   promotion.discount.type === 'cashback' ? `${promotion.discount.value}% Cashback` :
                   promotion.discount.type === 'points' ? `${promotion.discount.value} Poin` :
                   promotion.discount.type === 'fixed' && promotion.discount.value === 0 ? 'Cicilan 0%' :
                   `Rp ${promotion.discount.value.toLocaleString()} OFF`}
                </div>
                <div className="text-sm">
                  Berlaku hingga: {promotion.validUntil}
                </div>
              </div>
            </div>
            
            <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
              <div>
                <h3 className="text-lg font-medium mb-3">Informasi Kartu</h3>
                <div className="bg-foreground/5 rounded-lg p-4">
                  <div className="flex flex-wrap gap-2 mb-4">
                    {promotion.cardTypes.map(card => {
                      const cardTypeInfo = cardTypes.find(c => c.id === card);
                      return (
                        <div key={card} className="flex items-center space-x-2 px-3 py-1.5 rounded-lg bg-background border border-border">
                          <i className={cardTypeInfo?.icon || 'ri-bank-card-line'}></i>
                          <span>{cardTypeInfo?.name}</span>
                        </div>
                      );
                    })}
                  </div>
                  
                  <div className="space-y-2 text-sm">
                    {promotion.minimumSpend && (
                      <div className="flex justify-between">
                        <span>Minimum Transaksi:</span>
                        <span className="font-medium">Rp {promotion.minimumSpend.toLocaleString()}</span>
                      </div>
                    )}
                    {promotion.maximumDiscount && (
                      <div className="flex justify-between">
                        <span>Maksimum Diskon:</span>
                        <span className="font-medium">Rp {promotion.maximumDiscount.toLocaleString()}</span>
                      </div>
                    )}
                    {promotion.code && (
                      <div className="flex justify-between items-center mt-3">
                        <span>Kode Promo:</span>
                        <div className="flex items-center space-x-2">
                          <span className="bg-foreground/10 px-3 py-1 rounded font-mono font-medium">{promotion.code}</span>
                          <button className="text-blue-600 hover:text-blue-700" title="Copy code">
                            <i className="ri-file-copy-line"></i>
                          </button>
                        </div>
                      </div>
                    )}
                  </div>
                </div>
              </div>
              
              <div>
                <h3 className="text-lg font-medium mb-3">Lokasi</h3>
                <div className="bg-foreground/5 rounded-lg p-4 h-full">
                  <div className="flex flex-wrap gap-2">
                    {promotion.locations.map(location => (
                      <div key={location} className="px-3 py-1 rounded-lg bg-background border border-border text-sm">
                        {location === 'Online' ? (
                          <div className="flex items-center">
                            <i className="ri-global-line mr-1.5"></i>
                            <span>{location}</span>
                          </div>
                        ) : location === 'Nasional' ? (
                          <div className="flex items-center">
                            <i className="ri-flag-line mr-1.5"></i>
                            <span>{location}</span>
                          </div>
                        ) : (
                          <div className="flex items-center">
                            <i className="ri-map-pin-line mr-1.5"></i>
                            <span>{location}</span>
                          </div>
                        )}
                      </div>
                    ))}
                  </div>
                  
                  <div className="mt-4 text-sm">
                    <div className="flex items-center space-x-1 mb-2">
                      <span>Dapat digunakan di:</span>
                      <div className="flex">
                        {promotion.redemptionChannel.includes('online') && (
                          <span className="text-green-600 flex items-center mr-2">
                            <i className="ri-check-line mr-0.5"></i>
                            <span>Online</span>
                          </span>
                        )}
                        {promotion.redemptionChannel.includes('in-store') && (
                          <span className="text-green-600 flex items-center">
                            <i className="ri-check-line mr-0.5"></i>
                            <span>Offline</span>
                          </span>
                        )}
                      </div>
                    </div>
                    
                    {promotion.isLimited && promotion.limitedCount && (
                      <div className="mt-2 text-amber-600 flex items-center">
                        <i className="ri-alarm-warning-line mr-1.5"></i>
                        <span>Limited offer: {promotion.limitedCount.toLocaleString()} kuota tersedia</span>
                      </div>
                    )}
                  </div>
                </div>
              </div>
            </div>
            
            <div className="mb-6">
              <h3 className="text-lg font-medium mb-3">Syarat & Ketentuan</h3>
              <div className="bg-foreground/5 rounded-lg p-4">
                <ul className="list-disc pl-5 space-y-1 text-sm">
                  {promotion.termsAndConditions.map((term, index) => (
                    <li key={index}>{term}</li>
                  ))}
                  {promotion.requiresActivation && promotion.activationMethod && (
                    <li className="text-blue-600">
                      <span className="font-medium">Aktivasi diperlukan:</span> {promotion.activationMethod}
                    </li>
                  )}
                </ul>
              </div>
            </div>
            
            <div className="flex flex-wrap gap-2 mb-6">
              {promotion.tags.map(tag => (
                <SmartChip key={tag} label={`#${tag}`} color="bg-foreground/10" />
              ))}
            </div>
            
            <div className="flex justify-between">
              <div className="flex space-x-2">
                <button className="flex items-center space-x-1 px-3 py-2 rounded-lg border border-border hover:bg-foreground/5">
                  <i className="ri-heart-line"></i>
                  <span>Simpan</span>
                </button>
                <button className="flex items-center space-x-1 px-3 py-2 rounded-lg border border-border hover:bg-foreground/5">
                  <i className="ri-share-line"></i>
                  <span>Bagikan</span>
                </button>
              </div>
              
              <button 
                className="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                disabled={promotion.used}
              >
                {promotion.used ? 'Sudah Digunakan' : 'Gunakan Promo'}
              </button>
            </div>
          </div>
        </motion.div>
      </motion.div>
    </AnimatePresence>
  );
};

// Helper to get month number from name
const getMonthNumber = (monthName: string): string => {
  const months: Record<string, string> = {
    'Jan': '01', 'Feb': '02', 'Mar': '03', 'Apr': '04', 'Mei': '05', 'Jun': '06',
    'Jul': '07', 'Agu': '08', 'Sep': '09', 'Okt': '10', 'Nov': '11', 'Des': '12'
  };
  return months[monthName] || '01';
};

// Main PromotionsPage component
const PromotionsPage: React.FC = () => {
  const [promotions] = useState<Promotion[]>(generatePromotions());
  const [searchTerm, setSearchTerm] = useState('');
  const [selectedCategories, setSelectedCategories] = useState<string[]>([]);
  const [selectedBanks, setSelectedBanks] = useState<string[]>([]);
  const [selectedCardType, setSelectedCardType] = useState<string | null>(null);
  const [selectedLocation, setSelectedLocation] = useState<string | null>(null);
  const [discountRange, setDiscountRange] = useState<[number, number]>([0, 100]);
  const [discountAmountRange, setDiscountAmountRange] = useState<[number, number]>([0, 2000000]);
  const [showActiveOnly, setShowActiveOnly] = useState(false);
  const [showFeaturedOnly, setShowFeaturedOnly] = useState(false);
  const [selectedPromotion, setSelectedPromotion] = useState<Promotion | null>(null);
  const [viewMode, setViewMode] = useState<'grid' | 'list'>('grid');
  const [sortBy, setSortBy] = useState<'newest' | 'expiring' | 'discount' | 'rating'>('newest');
  const [dateRange, setDateRange] = useState<{ from: Date | undefined, to: Date | undefined }>({ from: undefined, to: undefined });
  const [isCalendarOpen, setIsCalendarOpen] = useState(false);
  const [savedOnly, setSavedOnly] = useState(false);
  
  // Bank card types mapping (untuk filter subgroup)
  const bankCardTypes: Record<string, string[]> = useMemo(() => {
    const cardTypesMap: Record<string, string[]> = {};
    
    promotions.forEach(promo => {
      if (!cardTypesMap[promo.bank]) {
        cardTypesMap[promo.bank] = [];
      }
      
      promo.cardTypes.forEach(cardType => {
        if (!cardTypesMap[promo.bank].includes(cardType)) {
          cardTypesMap[promo.bank].push(cardType);
        }
      });
    });
    
    return cardTypesMap;
  }, [promotions]);
  
  // Count untuk bank card types
  const bankCardTypesCounts: Record<string, number> = useMemo(() => {
    const counts: Record<string, number> = {};
    
    promotions.forEach(promo => {
      promo.cardTypes.forEach(cardType => {
        const key = `${promo.bank}-${cardType}`;
        if (!counts[key]) {
          counts[key] = 0;
        }
        counts[key]++;
      });
    });
    
    return counts;
  }, [promotions]);
  
  // Filter promotions
  const filteredPromotions = useMemo(() => {
    return promotions.filter(promotion => {
      // Search filter
      if (searchTerm && !promotion.title.toLowerCase().includes(searchTerm.toLowerCase()) && 
          !promotion.description.toLowerCase().includes(searchTerm.toLowerCase()) &&
          !promotion.merchant.toLowerCase().includes(searchTerm.toLowerCase())) {
        return false;
      }
      
      // Category filter (multi-select)
      if (selectedCategories.length > 0 && !selectedCategories.includes(promotion.category)) {
        return false;
      }
      
      // Bank filter (multi-select)
      if (selectedBanks.length > 0 && !selectedBanks.includes(promotion.bank)) {
        return false;
      }
      
      // Card type filter
      if (selectedCardType && selectedCardType !== 'all' && !promotion.cardTypes.includes(selectedCardType)) {
        return false;
      }
      
      // Location filter
      if (selectedLocation && !promotion.locations.includes(selectedLocation)) {
        return false;
      }
      
      // Discount range filter (percentage)
      if (promotion.discount.type === 'percentage' || promotion.discount.type === 'cashback') {
        if (promotion.discount.value < discountRange[0] || promotion.discount.value > discountRange[1]) {
          return false;
        }
      }
      
      // Discount amount filter (rupiah value)
      if (promotion.maximumDiscount) {
        if (promotion.maximumDiscount < discountAmountRange[0] || 
            promotion.maximumDiscount > discountAmountRange[1]) {
          return false;
        }
      }
      
      // Active only filter
      if (showActiveOnly) {
        const today = new Date();
        const [dayEnd, monthEnd, yearEnd] = promotion.validUntil.split(' ');
        const endDate = new Date(`${yearEnd}-${getMonthNumber(monthEnd)}-${dayEnd.padStart(2, '0')}`);
        
        if (endDate < today) {
          return false;
        }
      }
      
      // Featured only filter
      if (showFeaturedOnly && !promotion.featured) {
        return false;
      }
      
      // Date range filter
      if (dateRange.from || dateRange.to) {
        const [dayStart, monthStart, yearStart] = promotion.validFrom.split(' ');
        const [dayEnd, monthEnd, yearEnd] = promotion.validUntil.split(' ');
        
        const startDate = new Date(`${yearStart}-${getMonthNumber(monthStart)}-${dayStart.padStart(2, '0')}`);
        const endDate = new Date(`${yearEnd}-${getMonthNumber(monthEnd)}-${dayEnd.padStart(2, '0')}`);
        
        if (dateRange.from && endDate < dateRange.from) {
          return false;
        }
        
        if (dateRange.to) {
          // Add one day to include the end date
          const toDate = new Date(dateRange.to);
          toDate.setDate(toDate.getDate() + 1);
          if (startDate > toDate) {
            return false;
          }
        }
      }
      
      // Saved only filter
      if (savedOnly && !promotion.saved) {
        return false;
      }
      
      return true;
    });
  }, [
    promotions, 
    searchTerm, 
    selectedCategories, 
    selectedBanks, 
    selectedCardType, 
    selectedLocation, 
    discountRange,
    discountAmountRange,
    showActiveOnly, 
    showFeaturedOnly,
    dateRange,
    savedOnly
  ]);
  
  // Sort promotions
  const sortedPromotions = useMemo(() => {
    if (sortBy === 'newest') {
      return [...filteredPromotions].sort((a, b) => {
        const [dayA, monthA, yearA] = a.validFrom.split(' ');
        const [dayB, monthB, yearB] = b.validFrom.split(' ');
        
        const dateA = new Date(`${yearA}-${getMonthNumber(monthA)}-${dayA.padStart(2, '0')}`);
        const dateB = new Date(`${yearB}-${getMonthNumber(monthB)}-${dayB.padStart(2, '0')}`);
        
        return dateB.getTime() - dateA.getTime(); // newest first
      });
    } else if (sortBy === 'expiring') {
      return [...filteredPromotions].sort((a, b) => {
        const [dayA, monthA, yearA] = a.validUntil.split(' ');
        const [dayB, monthB, yearB] = b.validUntil.split(' ');
        
        const dateA = new Date(`${yearA}-${getMonthNumber(monthA)}-${dayA.padStart(2, '0')}`);
        const dateB = new Date(`${yearB}-${getMonthNumber(monthB)}-${dayB.padStart(2, '0')}`);
        
        return dateA.getTime() - dateB.getTime(); // expiring soon first
      });
    } else if (sortBy === 'discount') {
      return [...filteredPromotions].sort((a, b) => {
        // Only sort by value for percentage and cashback
        if ((a.discount.type === 'percentage' || a.discount.type === 'cashback') && 
            (b.discount.type === 'percentage' || b.discount.type === 'cashback')) {
          return b.discount.value - a.discount.value; // highest discount first
        }
        
        return 0;
      });
    } else if (sortBy === 'rating') {
      return [...filteredPromotions].sort((a, b) => b.rating - a.rating); // highest rating first
    }
    
    return filteredPromotions;
  }, [filteredPromotions, sortBy]);
  
  // Click on promotion
  const handlePromotionClick = (promotion: Promotion) => {
    setSelectedPromotion(promotion);
  };
  
  // Clear all filters
  const clearAllFilters = () => {
    setSearchTerm('');
    setSelectedCategories([]);
    setSelectedBanks([]);
    setSelectedCardType(null);
    setSelectedLocation(null);
    setDiscountRange([0, 100]);
    setDiscountAmountRange([0, 2000000]);
    setShowActiveOnly(false);
    setShowFeaturedOnly(false);
    setDateRange({ from: undefined, to: undefined });
    setSavedOnly(false);
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
  
  // Get category counts for the filter
  const getCategoryCounts = (): Record<string, number> => {
    const counts: Record<string, number> = {};
    
    promotions.forEach(promotion => {
      counts[promotion.category] = (counts[promotion.category] || 0) + 1;
    });
    
    return counts;
  };
  
  const categoryCounts = getCategoryCounts();
  
  // Get bank counts for the filter
  const getBankCounts = (): Record<string, number> => {
    const counts: Record<string, number> = {};
    
    promotions.forEach(promotion => {
      counts[promotion.bank] = (counts[promotion.bank] || 0) + 1;
    });
    
    return counts;
  };
  
  const bankCounts = getBankCounts();
  
  return (
    <div className="min-h-screen bg-background">
      <ModernDashboardTopbar />
      
      <main className="py-6 px-4 lg:px-8 pb-20">
        <div className="max-w-7xl mx-auto">
          <div className="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6">
            <div>
              <h1 className="text-2xl lg:text-3xl font-bold font-display mb-1">Promosi</h1>
              <p className="text-muted-foreground">Temukan penawaran dan diskon eksklusif untuk kartu Anda</p>
            </div>
            
            <div className="mt-4 lg:mt-0 flex space-x-2">
              <button className="flex items-center space-x-1 px-3 py-2 rounded-lg border border-border hover:bg-foreground/5 transition-colors">
                <i className="ri-wallet-3-line"></i>
                <span>Kartu Saya</span>
              </button>
              <button className="flex items-center space-x-1 px-3 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                <i className="ri-heart-line"></i>
                <span>Favorit Saya</span>
              </button>
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
                placeholder="Cari promosi berdasarkan judul, deskripsi, atau merchant..."
                className="w-full py-2 pl-10 pr-4 border border-border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all bg-background"
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
              />
            </div>
            
            <div className="flex flex-wrap gap-2 items-center">
              {/* View mode toggle */}
              <div className="bg-foreground/5 rounded-lg p-1 flex">
                <button 
                  className={`p-1.5 rounded ${viewMode === 'grid' ? 'bg-background shadow-sm' : 'hover:bg-foreground/10'}`}
                  onClick={() => setViewMode('grid')}
                >
                  <i className="ri-grid-fill"></i>
                </button>
                <button 
                  className={`p-1.5 rounded ${viewMode === 'list' ? 'bg-background shadow-sm' : 'hover:bg-foreground/10'}`}
                  onClick={() => setViewMode('list')}
                >
                  <i className="ri-list-check"></i>
                </button>
              </div>
              
              {/* Sort by */}
              <Popover>
                <PopoverTrigger asChild>
                  <button className="rounded-full px-3 py-1.5 text-sm font-medium whitespace-nowrap border border-border hover:bg-foreground/5 transition-all flex items-center">
                    <i className="ri-sort-desc-line mr-1.5"></i>
                    <span>
                      {sortBy === 'newest' && 'Terbaru'}
                      {sortBy === 'expiring' && 'Segera Berakhir'}
                      {sortBy === 'discount' && 'Diskon Tertinggi'}
                      {sortBy === 'rating' && 'Rating Tertinggi'}
                    </span>
                  </button>
                </PopoverTrigger>
                <PopoverContent className="w-48 p-0" align="start">
                  <div className="py-1">
                    <button
                      className={`flex items-center w-full px-4 py-2 text-sm ${
                        sortBy === 'newest' ? 'bg-blue-50 text-blue-700' : 'hover:bg-foreground/5'
                      }`}
                      onClick={() => setSortBy('newest')}
                    >
                      <i className={`ri-time-line mr-2 ${sortBy === 'newest' ? 'text-blue-700' : 'text-foreground/70'}`}></i>
                      <span>Terbaru</span>
                    </button>
                    <button
                      className={`flex items-center w-full px-4 py-2 text-sm ${
                        sortBy === 'expiring' ? 'bg-blue-50 text-blue-700' : 'hover:bg-foreground/5'
                      }`}
                      onClick={() => setSortBy('expiring')}
                    >
                      <i className={`ri-alarm-line mr-2 ${sortBy === 'expiring' ? 'text-blue-700' : 'text-foreground/70'}`}></i>
                      <span>Segera Berakhir</span>
                    </button>
                    <button
                      className={`flex items-center w-full px-4 py-2 text-sm ${
                        sortBy === 'discount' ? 'bg-blue-50 text-blue-700' : 'hover:bg-foreground/5'
                      }`}
                      onClick={() => setSortBy('discount')}
                    >
                      <i className={`ri-percent-line mr-2 ${sortBy === 'discount' ? 'text-blue-700' : 'text-foreground/70'}`}></i>
                      <span>Diskon Tertinggi</span>
                    </button>
                    <button
                      className={`flex items-center w-full px-4 py-2 text-sm ${
                        sortBy === 'rating' ? 'bg-blue-50 text-blue-700' : 'hover:bg-foreground/5'
                      }`}
                      onClick={() => setSortBy('rating')}
                    >
                      <i className={`ri-star-line mr-2 ${sortBy === 'rating' ? 'text-blue-700' : 'text-foreground/70'}`}></i>
                      <span>Rating Tertinggi</span>
                    </button>
                  </div>
                </PopoverContent>
              </Popover>
              
              {/* Category filter */}
              <Popover>
                <PopoverTrigger asChild>
                  <button className="rounded-full px-3 py-1.5 text-sm font-medium whitespace-nowrap border border-border hover:bg-foreground/5 transition-all flex items-center">
                    <i className="ri-price-tag-3-line mr-1.5"></i>
                    <span>Kategori</span>
                    {selectedCategories.length > 0 && <i className="ri-check-line ml-1"></i>}
                  </button>
                </PopoverTrigger>
                <PopoverContent className="w-64 p-3" align="start">
                  <div className="space-y-2">
                    <div className="text-sm font-medium mb-2">Pilih Kategori (Multi-select)</div>
                    <div className="h-48 overflow-y-auto pr-2 -mr-2 space-y-1.5">
                      {selectedCategories.length > 0 && (
                        <button 
                          className="w-full text-xs text-red-600 hover:text-red-700 mb-2"
                          onClick={() => setSelectedCategories([])}
                        >
                          Hapus semua kategori
                        </button>
                      )}
                      {Object.entries(categoryConfig).map(([category, config]) => (
                        <button
                          key={category}
                          className={`flex items-center w-full px-2 py-1.5 rounded-md text-sm ${
                            selectedCategories.includes(category) 
                              ? 'bg-blue-100 text-blue-700' 
                              : 'hover:bg-foreground/5'
                          }`}
                          onClick={() => {
                            if (selectedCategories.includes(category)) {
                              setSelectedCategories(selectedCategories.filter(c => c !== category));
                            } else {
                              setSelectedCategories([...selectedCategories, category]);
                            }
                          }}
                        >
                          <div className={`w-6 h-6 rounded-full ${config.color} text-white flex items-center justify-center mr-2`}>
                            <i className={config.icon}></i>
                          </div>
                          <span className="flex-1 text-left">{category}</span>
                          <span className="text-xs text-foreground/60">
                            {categoryCounts[category] || 0}
                          </span>
                        </button>
                      ))}
                    </div>
                  </div>
                </PopoverContent>
              </Popover>
              
              {/* Bank filter */}
              <Popover>
                <PopoverTrigger asChild>
                  <button className="rounded-full px-3 py-1.5 text-sm font-medium whitespace-nowrap border border-border hover:bg-foreground/5 transition-all flex items-center">
                    <i className="ri-bank-line mr-1.5"></i>
                    <span>Bank</span>
                    {selectedBanks.length > 0 && <i className="ri-check-line ml-1"></i>}
                  </button>
                </PopoverTrigger>
                <PopoverContent className="w-64 p-3" align="start">
                  <div className="space-y-2">
                    <div className="text-sm font-medium mb-2">Pilih Bank (Multi-select)</div>
                    <div className="h-60 overflow-y-auto pr-2 -mr-2 space-y-1.5">
                      {selectedBanks.length > 0 && (
                        <button 
                          className="w-full text-xs text-red-600 hover:text-red-700 mb-2"
                          onClick={() => setSelectedBanks([])}
                        >
                          Hapus semua bank
                        </button>
                      )}
                      
                      {/* Grup bank berdasarkan kartu kredit */}
                      <div className="mb-4">
                        <div className="font-medium text-xs text-foreground/70 mb-2 px-1">SEMUA BANK</div>
                        {banks.map((bank) => (
                          <button
                            key={bank.id}
                            className={`flex items-center w-full px-2 py-1.5 rounded-md text-sm ${
                              selectedBanks.includes(bank.id) 
                                ? 'bg-blue-100 text-blue-700' 
                                : 'hover:bg-foreground/5'
                            }`}
                            onClick={() => {
                              if (selectedBanks.includes(bank.id)) {
                                setSelectedBanks(selectedBanks.filter(b => b !== bank.id));
                              } else {
                                setSelectedBanks([...selectedBanks, bank.id]);
                              }
                            }}
                          >
                            <div className={`px-2 py-0.5 rounded ${bank.color} text-xs mr-2`}>
                              {bank.name}
                            </div>
                            <span className="flex-1 text-left overflow-hidden text-ellipsis">{bank.name}</span>
                            <span className="text-xs text-foreground/60">
                              {bankCounts[bank.id] || 0}
                            </span>
                          </button>
                        ))}
                      </div>
                      
                      {/* Grup kartu kredit Visa */}
                      <div className="pt-2 border-t border-border">
                        <div className="font-medium text-xs text-foreground/70 mb-2 px-1 flex items-center">
                          <span className="w-5 h-5 bg-blue-700 text-white rounded-full flex items-center justify-center mr-1.5">
                            <i className="ri-visa-line text-xs"></i>
                          </span>
                          <span>VISA</span>
                        </div>
                        {banks.filter(bank => {
                          const cardTypes = bankCardTypes ? bankCardTypes[bank.id] : null;
                          return cardTypes && cardTypes.includes('visa');
                        }).map((bank) => (
                          <button
                            key={`visa-${bank.id}`}
                            className={`flex items-center w-full px-2 py-1.5 rounded-md text-sm ${
                              selectedBanks.includes(bank.id) 
                                ? 'bg-blue-100 text-blue-700' 
                                : 'hover:bg-foreground/5'
                            }`}
                            onClick={() => {
                              if (selectedBanks.includes(bank.id)) {
                                setSelectedBanks(selectedBanks.filter(b => b !== bank.id));
                              } else {
                                setSelectedBanks([...selectedBanks, bank.id]);
                              }
                            }}
                          >
                            <div className={`px-2 py-0.5 rounded ${bank.color} text-xs mr-2`}>
                              {bank.name}
                            </div>
                            <span className="flex-1 text-left overflow-hidden text-ellipsis">{bank.name} Visa</span>
                            <span className="text-xs text-foreground/60">
                              {bankCardTypesCounts && bankCardTypesCounts[`${bank.id}-visa`] || 0}
                            </span>
                          </button>
                        ))}
                      </div>
                      
                      {/* Grup kartu kredit Mastercard */}
                      <div className="pt-2 border-t border-border mt-2">
                        <div className="font-medium text-xs text-foreground/70 mb-2 px-1 flex items-center">
                          <span className="w-5 h-5 bg-orange-600 text-white rounded-full flex items-center justify-center mr-1.5">
                            <i className="ri-mastercard-line text-xs"></i>
                          </span>
                          <span>MASTERCARD</span>
                        </div>
                        {banks.filter(bank => {
                          const cardTypes = bankCardTypes ? bankCardTypes[bank.id] : null;
                          return cardTypes && cardTypes.includes('mastercard');
                        }).map((bank) => (
                          <button
                            key={`mastercard-${bank.id}`}
                            className={`flex items-center w-full px-2 py-1.5 rounded-md text-sm ${
                              selectedBanks.includes(bank.id) 
                                ? 'bg-blue-100 text-blue-700' 
                                : 'hover:bg-foreground/5'
                            }`}
                            onClick={() => {
                              if (selectedBanks.includes(bank.id)) {
                                setSelectedBanks(selectedBanks.filter(b => b !== bank.id));
                              } else {
                                setSelectedBanks([...selectedBanks, bank.id]);
                              }
                            }}
                          >
                            <div className={`px-2 py-0.5 rounded ${bank.color} text-xs mr-2`}>
                              {bank.name}
                            </div>
                            <span className="flex-1 text-left overflow-hidden text-ellipsis">{bank.name} Mastercard</span>
                            <span className="text-xs text-foreground/60">
                              {bankCardTypesCounts && bankCardTypesCounts[`${bank.id}-mastercard`] || 0}
                            </span>
                          </button>
                        ))}
                      </div>
                    </div>
                  </div>
                </PopoverContent>
              </Popover>
              
              {/* Card type filter */}
              <Popover>
                <PopoverTrigger asChild>
                  <button className="rounded-full px-3 py-1.5 text-sm font-medium whitespace-nowrap border border-border hover:bg-foreground/5 transition-all flex items-center">
                    <i className="ri-bank-card-line mr-1.5"></i>
                    <span>Tipe Kartu</span>
                    {selectedCardType && <i className="ri-check-line ml-1"></i>}
                  </button>
                </PopoverTrigger>
                <PopoverContent className="w-56 p-3" align="start">
                  <div className="space-y-2">
                    <div className="text-sm font-medium mb-2">Pilih Tipe Kartu</div>
                    <div className="space-y-1.5">
                      {cardTypes.map((card) => (
                        <button
                          key={card.id}
                          className={`flex items-center w-full px-2 py-1.5 rounded-md text-sm ${
                            selectedCardType === card.id 
                              ? 'bg-blue-100 text-blue-700' 
                              : 'hover:bg-foreground/5'
                          }`}
                          onClick={() => setSelectedCardType(selectedCardType === card.id ? null : card.id)}
                        >
                          <i className={`${card.icon} mr-2 ${selectedCardType === card.id ? 'text-blue-700' : 'text-foreground/70'}`}></i>
                          <span>{card.name}</span>
                        </button>
                      ))}
                    </div>
                  </div>
                </PopoverContent>
              </Popover>
              
              {/* Location filter */}
              <Popover>
                <PopoverTrigger asChild>
                  <button className="rounded-full px-3 py-1.5 text-sm font-medium whitespace-nowrap border border-border hover:bg-foreground/5 transition-all flex items-center">
                    <i className="ri-map-pin-line mr-1.5"></i>
                    <span>Lokasi</span>
                    {selectedLocation && <i className="ri-check-line ml-1"></i>}
                  </button>
                </PopoverTrigger>
                <PopoverContent className="w-56 p-3" align="start">
                  <div className="space-y-2">
                    <div className="text-sm font-medium mb-2">Pilih Lokasi</div>
                    <div className="h-48 overflow-y-auto pr-2 -mr-2 space-y-1.5">
                      {locations.map((location) => (
                        <button
                          key={location}
                          className={`flex items-center w-full px-2 py-1.5 rounded-md text-sm ${
                            selectedLocation === location 
                              ? 'bg-blue-100 text-blue-700' 
                              : 'hover:bg-foreground/5'
                          }`}
                          onClick={() => setSelectedLocation(selectedLocation === location ? null : location)}
                        >
                          {location === 'Online' ? (
                            <i className="ri-global-line mr-2"></i>
                          ) : location === 'Nasional' ? (
                            <i className="ri-flag-line mr-2"></i>
                          ) : (
                            <i className="ri-map-pin-line mr-2"></i>
                          )}
                          <span>{location}</span>
                        </button>
                      ))}
                    </div>
                  </div>
                </PopoverContent>
              </Popover>
              
              {/* Discount range filter */}
              <Popover>
                <PopoverTrigger asChild>
                  <button className="rounded-full px-3 py-1.5 text-sm font-medium whitespace-nowrap border border-border hover:bg-foreground/5 transition-all flex items-center">
                    <i className="ri-percent-line mr-1.5"></i>
                    <span>Diskon {discountRange[0]}% - {discountRange[1]}%</span>
                  </button>
                </PopoverTrigger>
                <PopoverContent className="w-64 p-4" align="start">
                  <div className="space-y-4">
                    <div className="text-sm font-medium">Rentang Diskon</div>
                    <div className="px-2">
                      <Slider
                        defaultValue={discountRange}
                        max={100}
                        min={0}
                        step={5}
                        onValueChange={(value: number[]) => setDiscountRange(value as [number, number])}
                      />
                    </div>
                    <div className="flex justify-between text-sm">
                      <span>{discountRange[0]}%</span>
                      <span>{discountRange[1]}%</span>
                    </div>
                  </div>
                </PopoverContent>
              </Popover>
              
              {/* Discount amount filter (Rupiah) */}
              <Popover>
                <PopoverTrigger asChild>
                  <button className="rounded-full px-3 py-1.5 text-sm font-medium whitespace-nowrap border border-border hover:bg-foreground/5 transition-all flex items-center">
                    <i className="ri-money-dollar-circle-line mr-1.5"></i>
                    <span>Nilai Diskon</span>
                    {discountAmountRange[0] > 0 || discountAmountRange[1] < 2000000 && <i className="ri-check-line ml-1"></i>}
                  </button>
                </PopoverTrigger>
                <PopoverContent className="w-72 p-4" align="start">
                  <div className="space-y-4">
                    <div className="text-sm font-medium">Nilai Diskon (Rupiah)</div>
                    <div className="px-2">
                      <Slider
                        defaultValue={discountAmountRange}
                        max={2000000}
                        min={0}
                        step={50000}
                        onValueChange={(value: number[]) => setDiscountAmountRange(value as [number, number])}
                      />
                    </div>
                    <div className="flex justify-between text-sm">
                      <span>Rp {discountAmountRange[0].toLocaleString()}</span>
                      <span>Rp {discountAmountRange[1].toLocaleString()}</span>
                    </div>
                    
                    <div className="grid grid-cols-2 gap-2 pt-2">
                      <button 
                        className="px-2 py-1 text-xs border border-border rounded hover:bg-foreground/5 transition-colors"
                        onClick={() => setDiscountAmountRange([0, 500000])}
                      >
                        Hingga 500rb
                      </button>
                      <button 
                        className="px-2 py-1 text-xs border border-border rounded hover:bg-foreground/5 transition-colors"
                        onClick={() => setDiscountAmountRange([500000, 1000000])}
                      >
                        500rb - 1jt
                      </button>
                      <button 
                        className="px-2 py-1 text-xs border border-border rounded hover:bg-foreground/5 transition-colors"
                        onClick={() => setDiscountAmountRange([1000000, 2000000])}
                      >
                        1jt - 2jt
                      </button>
                      <button 
                        className="px-2 py-1 text-xs border border-border rounded hover:bg-foreground/5 transition-colors"
                        onClick={() => setDiscountAmountRange([0, 2000000])}
                      >
                        Semua nilai
                      </button>
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
              
              {/* Additional filters */}
              <SmartChip 
                label="Masih Berlaku" 
                icon="ri-time-line"
                isActive={showActiveOnly}
                onClick={() => setShowActiveOnly(!showActiveOnly)}
              />
              
              <SmartChip 
                label="Featured" 
                icon="ri-star-line"
                isActive={showFeaturedOnly}
                onClick={() => setShowFeaturedOnly(!showFeaturedOnly)}
              />
              
              <SmartChip 
                label="Tersimpan" 
                icon="ri-heart-line"
                isActive={savedOnly}
                onClick={() => setSavedOnly(!savedOnly)}
              />
              
              {(searchTerm || selectedCategories.length > 0 || selectedBanks.length > 0 || selectedCardType || 
                selectedLocation || discountRange[0] > 0 || discountRange[1] < 100 || 
                discountAmountRange[0] > 0 || discountAmountRange[1] < 2000000 ||
                showActiveOnly || showFeaturedOnly || dateRange.from || dateRange.to || savedOnly) && (
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
          
          {/* Results count */}
          <div className="mb-4 text-foreground/70">
            Menampilkan {sortedPromotions.length} dari {promotions.length} promosi
          </div>
          
          {/* Promotions grid */}
          {sortedPromotions.length > 0 ? (
            <div className={viewMode === 'grid' ? 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6' : 'space-y-4'}>
              {sortedPromotions.map(promotion => (
                <PromotionCard
                  key={promotion.id}
                  promotion={promotion}
                  onClick={() => handlePromotionClick(promotion)}
                />
              ))}
            </div>
          ) : (
            <div className="text-center py-16 bg-foreground/5 rounded-xl">
              <div className="inline-flex h-12 w-12 items-center justify-center rounded-full bg-foreground/10 mb-4">
                <i className="ri-search-line text-xl text-foreground/40"></i>
              </div>
              <h3 className="text-lg font-medium mb-2">Tidak ada promosi</h3>
              <p className="text-foreground/60 max-w-md mx-auto">
                Tidak ada promosi yang sesuai dengan kriteria pencarian Anda. Coba ubah filter atau hapus pencarian.
              </p>
            </div>
          )}
        </div>
      </main>
      
      {/* Promotion detail modal */}
      {selectedPromotion && (
        <PromotionDetailModal
          promotion={selectedPromotion}
          onClose={() => setSelectedPromotion(null)}
        />
      )}
      
      <Footer />
    </div>
  );
};

export default PromotionsPage;