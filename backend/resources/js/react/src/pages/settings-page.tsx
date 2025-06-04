import React, { useState, useEffect } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import Footer from '@/components/Footer';
import { ModernDashboardTopbar } from './dashboard-home-page';

// Achievement interface
interface Achievement {
  id: string;
  title: string;
  description: string;
  icon: string;
  points: number;
  category: 'profile' | 'security' | 'notifications' | 'payment' | 'preferences' | 'advanced';
  isUnlocked: boolean;
  progress: number;
  maxProgress: number;
  rewards: string[];
  rarity: 'common' | 'rare' | 'epic' | 'legendary';
}

// Settings section interface
interface SettingsSection {
  id: string;
  title: string;
  icon: string;
  description: string;
  achievements: Achievement[];
  isLocked: boolean;
  requiredPoints: number;
}

// Dummy data for achievements
const achievementsData: Achievement[] = [
  {
    id: 'achievement1',
    title: 'Profile Master',
    description: 'Complete your profile 100%',
    icon: 'ri-user-star-line',
    points: 50,
    category: 'profile',
    isUnlocked: true,
    progress: 100,
    maxProgress: 100,
    rewards: ['150 bonus points', 'Profile Badge'],
    rarity: 'common'
  },
  {
    id: 'achievement2',
    title: 'Security Guardian',
    description: 'Enable 2FA and set a strong password',
    icon: 'ri-shield-check-line',
    points: 75,
    category: 'security',
    isUnlocked: true,
    progress: 2,
    maxProgress: 2,
    rewards: ['200 bonus points', 'Security Badge', '+5% points on all transactions'],
    rarity: 'rare'
  },
  {
    id: 'achievement3',
    title: 'Early Adopter',
    description: 'Try all new features within 7 days of release',
    icon: 'ri-rocket-line',
    points: 100,
    category: 'advanced',
    isUnlocked: false,
    progress: 3,
    maxProgress: 5,
    rewards: ['250 bonus points', 'Early Adopter Badge', 'Beta features access'],
    rarity: 'epic'
  },
  {
    id: 'achievement4',
    title: 'Data Analyst',
    description: 'View all your spending reports for 3 consecutive months',
    icon: 'ri-bar-chart-box-line',
    points: 60,
    category: 'preferences',
    isUnlocked: false,
    progress: 2,
    maxProgress: 3,
    rewards: ['180 bonus points', 'Advanced analytics access'],
    rarity: 'rare'
  },
  {
    id: 'achievement5',
    title: 'Payment Guru',
    description: 'Set up automatic payments for all your credit cards',
    icon: 'ri-bank-card-line',
    points: 80,
    category: 'payment',
    isUnlocked: false,
    progress: 1,
    maxProgress: 3,
    rewards: ['200 bonus points', 'Payment Badge', '10% cashback boost for 1 month'],
    rarity: 'epic'
  },
  {
    id: 'achievement6',
    title: 'Notification Ninja',
    description: 'Customize all your notification preferences',
    icon: 'ri-notification-4-line',
    points: 40,
    category: 'notifications',
    isUnlocked: true,
    progress: 5,
    maxProgress: 5,
    rewards: ['100 bonus points', 'Custom notification sounds'],
    rarity: 'common'
  },
  {
    id: 'achievement7',
    title: 'Spending Challenge Champion',
    description: 'Complete 5 spending challenges',
    icon: 'ri-award-line',
    points: 150,
    category: 'advanced',
    isUnlocked: false,
    progress: 2,
    maxProgress: 5,
    rewards: ['500 bonus points', 'Champion Badge', 'Custom spending challenge creator'],
    rarity: 'legendary'
  },
  {
    id: 'achievement8',
    title: 'Dark Mode Dweller',
    description: 'Use dark mode for 7 consecutive days',
    icon: 'ri-moon-line',
    points: 30,
    category: 'preferences',
    isUnlocked: true,
    progress: 7,
    maxProgress: 7,
    rewards: ['Special dark theme options'],
    rarity: 'common'
  },
  {
    id: 'achievement9',
    title: 'Financial Detective',
    description: 'Identify and report 3 unusual transactions',
    icon: 'ri-spy-line',
    points: 120,
    category: 'security',
    isUnlocked: false,
    progress: 1,
    maxProgress: 3,
    rewards: ['300 bonus points', 'Detective Badge', 'Fraud protection boost'],
    rarity: 'epic'
  },
  {
    id: 'achievement10',
    title: 'Feedback Contributor',
    description: 'Provide feedback on 10 features',
    icon: 'ri-feedback-line',
    points: 90,
    category: 'advanced',
    isUnlocked: false,
    progress: 4,
    maxProgress: 10,
    rewards: ['250 bonus points', 'Beta tester status'],
    rarity: 'rare'
  },
  {
    id: 'achievement11',
    title: 'Billing Wizard',
    description: 'Set up custom billing cycles for all cards',
    icon: 'ri-calendar-check-line',
    points: 70,
    category: 'payment',
    isUnlocked: false,
    progress: 0,
    maxProgress: 3,
    rewards: ['180 bonus points', 'Custom payment date options'],
    rarity: 'rare'
  },
  {
    id: 'achievement12',
    title: 'Savings Master',
    description: 'Save 20% more than last month for 3 consecutive months',
    icon: 'ri-money-dollar-box-line',
    points: 200,
    category: 'payment',
    isUnlocked: false,
    progress: 1,
    maxProgress: 3,
    rewards: ['500 bonus points', 'Savings Badge', 'High-yield savings options'],
    rarity: 'legendary'
  }
];

// Settings sections
const settingsSectionsData: SettingsSection[] = [
  {
    id: 'profile',
    title: 'Profil Saya',
    icon: 'ri-user-settings-line',
    description: 'Kelola informasi akun dan preferensi profil Anda',
    achievements: achievementsData.filter(a => a.category === 'profile'),
    isLocked: false,
    requiredPoints: 0
  },
  {
    id: 'security',
    title: 'Keamanan',
    icon: 'ri-shield-keyhole-line',
    description: 'Kelola pengaturan keamanan dan privasi akun Anda',
    achievements: achievementsData.filter(a => a.category === 'security'),
    isLocked: false,
    requiredPoints: 0
  },
  {
    id: 'notifications',
    title: 'Notifikasi',
    icon: 'ri-notification-4-line',
    description: 'Atur preferensi pemberitahuan untuk email dan ponsel Anda',
    achievements: achievementsData.filter(a => a.category === 'notifications'),
    isLocked: false,
    requiredPoints: 0
  },
  {
    id: 'payment',
    title: 'Metode Pembayaran',
    icon: 'ri-bank-card-line',
    description: 'Kelola kartu kredit dan metode pembayaran lainnya',
    achievements: achievementsData.filter(a => a.category === 'payment'),
    isLocked: false,
    requiredPoints: 100
  },
  {
    id: 'preferences',
    title: 'Preferensi',
    icon: 'ri-settings-4-line',
    description: 'Sesuaikan tema, bahasa, dan preferensi tampilan',
    achievements: achievementsData.filter(a => a.category === 'preferences'),
    isLocked: false,
    requiredPoints: 50
  },
  {
    id: 'advanced',
    title: 'Pengaturan Lanjutan',
    icon: 'ri-tools-line',
    description: 'Fitur lanjutan untuk pengguna tingkat atas',
    achievements: achievementsData.filter(a => a.category === 'advanced'),
    isLocked: true,
    requiredPoints: 200
  }
];

// Achievement card component
const AchievementCard = ({ achievement, onUnlock }: { achievement: Achievement, onUnlock: (id: string) => void }) => {
  const getRarityColor = (rarity: string): string => {
    switch(rarity) {
      case 'common': return 'bg-gray-200 text-gray-700';
      case 'rare': return 'bg-blue-200 text-blue-700';
      case 'epic': return 'bg-purple-200 text-purple-700';
      case 'legendary': return 'bg-amber-200 text-amber-700';
      default: return 'bg-gray-200 text-gray-700';
    }
  };

  return (
    <motion.div
      className={`border rounded-xl p-4 relative overflow-hidden transition-shadow ${achievement.isUnlocked ? 'border-blue-500 shadow-md' : 'border-border hover:shadow-sm'}`}
      initial={{ opacity: 0, y: 20 }}
      animate={{ opacity: 1, y: 0 }}
      whileHover={{ y: -5 }}
      transition={{ duration: 0.3 }}
    >
      {/* Rarity badge */}
      <div className={`absolute top-0 right-0 px-2 py-0.5 rounded-bl-md text-xs font-medium ${getRarityColor(achievement.rarity)}`}>
        {achievement.rarity.charAt(0).toUpperCase() + achievement.rarity.slice(1)}
      </div>
      
      <div className="flex items-start">
        <div className={`flex-shrink-0 w-10 h-10 rounded-full ${achievement.isUnlocked ? 'bg-blue-100 text-blue-600' : 'bg-foreground/10 text-foreground/60'} flex items-center justify-center`}>
          <i className={`${achievement.icon} text-xl`}></i>
        </div>
        <div className="ml-3 flex-1">
          <h3 className="font-medium text-base flex items-center">
            {achievement.title}
            {achievement.isUnlocked && <i className="ri-check-double-line text-blue-500 ml-1"></i>}
          </h3>
          <p className="text-sm text-foreground/70 mt-1">{achievement.description}</p>
        </div>
      </div>
      
      {/* Progress bar */}
      <div className="mt-4">
        <div className="flex justify-between text-xs text-foreground/70 mb-1">
          <span>Progress: {achievement.progress}/{achievement.maxProgress}</span>
          <span>{achievement.points} Points</span>
        </div>
        <div className="w-full bg-foreground/10 rounded-full h-2">
          <div 
            className={`h-2 rounded-full ${achievement.isUnlocked ? 'bg-blue-500' : 'bg-foreground/30'}`} 
            style={{ width: `${(achievement.progress / achievement.maxProgress) * 100}%` }}
          ></div>
        </div>
      </div>
      
      {/* Rewards */}
      <div className="mt-3">
        <div className="text-xs text-foreground/70 mb-1">Rewards:</div>
        <div className="flex flex-wrap gap-1">
          {achievement.rewards.map((reward, idx) => (
            <div 
              key={idx} 
              className={`px-2 py-0.5 rounded-md text-xs border ${achievement.isUnlocked ? 'border-blue-200 bg-blue-50 text-blue-700' : 'border-foreground/20 bg-foreground/5 text-foreground/50'}`}
            >
              {reward}
            </div>
          ))}
        </div>
      </div>
      
      {/* Unlock button - only show for achievements that have met criteria but aren't unlocked yet */}
      {!achievement.isUnlocked && achievement.progress >= achievement.maxProgress && (
        <motion.button
          className="mt-3 w-full py-1.5 rounded-md bg-blue-600 text-white text-sm font-medium hover:bg-blue-700"
          whileTap={{ scale: 0.95 }}
          onClick={() => onUnlock(achievement.id)}
        >
          Claim Reward
        </motion.button>
      )}
    </motion.div>
  );
};

// Settings section component
const SettingsSection = ({ 
  section, 
  isActive, 
  onClick, 
  totalPoints 
}: { 
  section: SettingsSection, 
  isActive: boolean, 
  onClick: () => void,
  totalPoints: number
}) => {
  return (
    <motion.div
      className={`p-4 rounded-xl cursor-pointer transition-colors ${
        isActive 
          ? 'bg-blue-50 border-blue-200 border' 
          : section.isLocked && totalPoints < section.requiredPoints
            ? 'bg-foreground/5 cursor-not-allowed border border-foreground/10'
            : 'hover:bg-foreground/5 border border-transparent'
      }`}
      whileHover={section.isLocked && totalPoints < section.requiredPoints ? {} : { scale: 1.02 }}
      onClick={section.isLocked && totalPoints < section.requiredPoints ? undefined : onClick}
    >
      <div className="flex items-center">
        <div className={`w-10 h-10 rounded-full flex items-center justify-center ${
          isActive 
            ? 'bg-blue-100 text-blue-600' 
            : section.isLocked && totalPoints < section.requiredPoints
              ? 'bg-foreground/10 text-foreground/30'
              : 'bg-foreground/10 text-foreground/60'
        }`}>
          <i className={`${section.icon} text-xl`}></i>
        </div>
        <div className="ml-3 flex-1">
          <div className="flex items-center">
            <h3 className={`font-medium ${section.isLocked && totalPoints < section.requiredPoints ? 'text-foreground/50' : ''}`}>
              {section.title}
            </h3>
            {section.isLocked && totalPoints < section.requiredPoints && (
              <div className="ml-2 flex items-center text-xs text-foreground/60">
                <i className="ri-lock-line mr-1"></i>
                <span>Butuh {section.requiredPoints} poin</span>
              </div>
            )}
          </div>
          <p className={`text-sm ${section.isLocked && totalPoints < section.requiredPoints ? 'text-foreground/40' : 'text-foreground/70'} mt-0.5`}>
            {section.description}
          </p>
        </div>
        <div>
          <i className={`ri-arrow-right-s-line text-xl ${
            isActive 
              ? 'text-blue-500' 
              : section.isLocked && totalPoints < section.requiredPoints
                ? 'text-foreground/30'
                : 'text-foreground/50'
          }`}></i>
        </div>
      </div>
    </motion.div>
  );
};

// Main settings page component
const SettingsPage: React.FC = () => {
  const [activeSection, setActiveSection] = useState<string>('profile');
  const [achievements, setAchievements] = useState<Achievement[]>(achievementsData);
  const [sections, setSections] = useState<SettingsSection[]>(settingsSectionsData);
  const [showUnlockAnimation, setShowUnlockAnimation] = useState(false);
  const [unlockedAchievement, setUnlockedAchievement] = useState<Achievement | null>(null);
  const [userPoints, setUserPoints] = useState(200); // Starting with some points
  
  // Calculate total points from unlocked achievements
  const calculateTotalPoints = (): number => {
    return achievements.filter(a => a.isUnlocked).reduce((sum, a) => sum + a.points, 0);
  };
  
  // Handle unlocking an achievement
  const handleUnlockAchievement = (id: string) => {
    const achievement = achievements.find(a => a.id === id);
    if (!achievement) return;
    
    const updatedAchievements = achievements.map(a =>
      a.id === id ? { ...a, isUnlocked: true } : a
    );
    
    setUnlockedAchievement(achievement);
    setShowUnlockAnimation(true);
    setAchievements(updatedAchievements);
    setUserPoints(prev => prev + achievement.points);
    
    // Auto-hide the animation after a delay
    setTimeout(() => {
      setShowUnlockAnimation(false);
      setUnlockedAchievement(null);
    }, 3000);
  };
  
  // Update section lock status based on points
  useEffect(() => {
    const totalPoints = userPoints;
    const updatedSections = sections.map(section => ({
      ...section,
      isLocked: section.requiredPoints > totalPoints
    }));
    setSections(updatedSections);
  }, [userPoints]);
  
  // Achievement stats
  const unlockedCount = achievements.filter(a => a.isUnlocked).length;
  const totalCount = achievements.length;
  const progressPercentage = (unlockedCount / totalCount) * 100;
  
  return (
    <div className="min-h-screen bg-background">
      <ModernDashboardTopbar />
      
      <main className="py-6 px-4 lg:px-8 pb-20">
        <div className="max-w-7xl mx-auto">
          <div className="mb-8">
            <h1 className="text-2xl lg:text-3xl font-bold font-display mb-1">Pengaturan</h1>
            <p className="text-muted-foreground">Kelola akun dan preferensi Anda</p>
          </div>
          
          {/* Achievement progress overview */}
          <div className="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-6 mb-8 text-white">
            <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
              <div className="col-span-2">
                <h2 className="text-xl font-semibold mb-2">Achievement Progress</h2>
                <p className="mb-4 text-blue-50">Buka achievement untuk mendapatkan poin dan fitur eksklusif</p>
                
                <div className="mb-3">
                  <div className="flex justify-between text-sm mb-1">
                    <span>Achievement Master Level</span>
                    <span>{unlockedCount}/{totalCount} achievements</span>
                  </div>
                  <div className="w-full bg-white/20 rounded-full h-2.5">
                    <div className="bg-white h-2.5 rounded-full" style={{ width: `${progressPercentage}%` }}></div>
                  </div>
                </div>
                
                <div className="flex flex-wrap gap-2 mt-4">
                  <div className="bg-white/10 backdrop-blur-sm rounded-lg p-3 text-center">
                    <div className="text-2xl font-bold">{userPoints}</div>
                    <div className="text-xs text-blue-100">Total Poin</div>
                  </div>
                  <div className="bg-white/10 backdrop-blur-sm rounded-lg p-3 text-center">
                    <div className="text-2xl font-bold">{unlockedCount}</div>
                    <div className="text-xs text-blue-100">Achievements</div>
                  </div>
                  <div className="bg-white/10 backdrop-blur-sm rounded-lg p-3 text-center">
                    <div className="text-2xl font-bold">
                      {achievements.filter(a => a.rarity === 'legendary' && a.isUnlocked).length}
                    </div>
                    <div className="text-xs text-blue-100">Legendary</div>
                  </div>
                </div>
              </div>
              
              <div className="flex items-center justify-center">
                <div className="relative">
                  <svg className="w-32 h-32" viewBox="0 0 100 100">
                    <circle
                      cx="50"
                      cy="50"
                      r="40"
                      fill="none"
                      stroke="rgba(255,255,255,0.2)"
                      strokeWidth="8"
                    />
                    <circle
                      cx="50"
                      cy="50"
                      r="40"
                      fill="none"
                      stroke="white"
                      strokeWidth="8"
                      strokeDasharray={`${(progressPercentage * 2.51)} ${251 - (progressPercentage * 2.51)}`}
                      strokeDashoffset="62.75"
                      transform="rotate(-90 50 50)"
                    />
                  </svg>
                  <div className="absolute inset-0 flex flex-col items-center justify-center">
                    <div className="text-2xl font-bold">{Math.round(progressPercentage)}%</div>
                    <div className="text-xs">Complete</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {/* Settings navigation */}
            <div className="space-y-2">
              {sections.map((section) => (
                <SettingsSection
                  key={section.id}
                  section={section}
                  isActive={activeSection === section.id}
                  onClick={() => !section.isLocked && setActiveSection(section.id)}
                  totalPoints={userPoints}
                />
              ))}
            </div>
            
            {/* Achievements for selected section */}
            <div className="lg:col-span-2">
              <div className="bg-background border border-border rounded-xl p-6">
                <h2 className="text-xl font-semibold mb-1">
                  {sections.find(s => s.id === activeSection)?.title} Achievements
                </h2>
                <p className="text-foreground/70 mb-6">Selesaikan achievements untuk mendapatkan poin dan rewards</p>
                
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                  {achievements
                    .filter(a => a.category === activeSection)
                    .map(achievement => (
                      <AchievementCard
                        key={achievement.id}
                        achievement={achievement}
                        onUnlock={handleUnlockAchievement}
                      />
                    ))
                  }
                  
                  {achievements.filter(a => a.category === activeSection).length === 0 && (
                    <div className="col-span-2 py-12 text-center">
                      <div className="inline-flex h-12 w-12 items-center justify-center rounded-full bg-foreground/5 mb-4">
                        <i className="ri-trophy-line text-xl text-foreground/50"></i>
                      </div>
                      <p className="text-foreground/50">Tidak ada achievement untuk kategori ini</p>
                    </div>
                  )}
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
      
      {/* Achievement unlock animation */}
      <AnimatePresence>
        {showUnlockAnimation && unlockedAchievement && (
          <motion.div
            className="fixed inset-0 flex items-center justify-center z-50 bg-black/50"
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            exit={{ opacity: 0 }}
          >
            <motion.div
              className="bg-background rounded-2xl p-6 max-w-md w-full text-center relative overflow-hidden"
              initial={{ scale: 0.8, opacity: 0 }}
              animate={{ scale: 1, opacity: 1 }}
              exit={{ scale: 0.8, opacity: 0 }}
            >
              {/* Confetti-like particles */}
              <div className="absolute inset-0 overflow-hidden">
                {Array.from({ length: 30 }).map((_, i) => (
                  <motion.div 
                    key={i}
                    className="absolute w-2 h-2 rounded-full"
                    style={{
                      backgroundColor: ['#4f46e5', '#ec4899', '#10b981', '#f59e0b'][i % 4],
                      top: `${Math.random() * 100}%`,
                      left: `${Math.random() * 100}%`,
                    }}
                    initial={{ opacity: 0, scale: 0 }}
                    animate={{ 
                      opacity: [0, 1, 0],
                      scale: [0, 1.5, 0],
                      y: [0, -100 - Math.random() * 100],
                      x: [0, (Math.random() - 0.5) * 100],
                      rotate: [0, Math.random() * 360]
                    }}
                    transition={{ 
                      duration: 2,
                      delay: i * 0.02,
                      repeat: Infinity,
                      repeatDelay: 3
                    }}
                  />
                ))}
              </div>
              
              <motion.div
                className="mb-4 relative z-10"
                initial={{ y: 20, opacity: 0 }}
                animate={{ y: 0, opacity: 1 }}
                transition={{ delay: 0.2 }}
              >
                <div className="w-16 h-16 mx-auto rounded-full bg-blue-100 flex items-center justify-center mb-2">
                  <i className={`${unlockedAchievement.icon} text-3xl text-blue-600`}></i>
                </div>
                <h3 className="text-xl font-bold mb-1">Achievement Unlocked!</h3>
                <p className="text-foreground/70">{unlockedAchievement.title}</p>
              </motion.div>
              
              <motion.div
                className="relative z-10"
                initial={{ y: 20, opacity: 0 }}
                animate={{ y: 0, opacity: 1 }}
                transition={{ delay: 0.4 }}
              >
                <div className="text-2xl font-bold text-blue-600 mb-2">
                  +{unlockedAchievement.points} Points
                </div>
                
                <div className="mb-4">
                  <p className="text-sm text-foreground/70 mb-2">Rewards Unlocked:</p>
                  <div className="flex flex-wrap justify-center gap-2">
                    {unlockedAchievement.rewards.map((reward, idx) => (
                      <div 
                        key={idx} 
                        className="px-2 py-1 rounded-md text-sm border border-blue-200 bg-blue-50 text-blue-700"
                      >
                        {reward}
                      </div>
                    ))}
                  </div>
                </div>
                
                <motion.button
                  className="px-6 py-2 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700"
                  whileTap={{ scale: 0.95 }}
                  onClick={() => {
                    setShowUnlockAnimation(false);
                    setUnlockedAchievement(null);
                  }}
                >
                  Awesome!
                </motion.button>
              </motion.div>
            </motion.div>
          </motion.div>
        )}
      </AnimatePresence>
      
      <Footer />
    </div>
  );
};

export default SettingsPage;