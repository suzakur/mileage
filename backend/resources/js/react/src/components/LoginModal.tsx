import React, { useState } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { useLocation } from 'wouter';

interface LoginModalProps {
  isOpen: boolean;
  onClose: () => void;
  mode: 'login' | 'register';
  onChangeMode: () => void;
}

const LoginModal: React.FC<LoginModalProps> = ({ isOpen, onClose, mode, onChangeMode }) => {
  const [_, navigate] = useLocation();
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    password: '',
    confirmPassword: '',
  });
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState('');

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = e.target;
    setFormData(prev => ({ ...prev, [name]: value }));
    setError('');
  };

  const handleSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    setIsLoading(true);
    setError('');

    try {
      // Simulate API call
      await new Promise(resolve => setTimeout(resolve, 1000));

      if (mode === 'register') {
        if (formData.password !== formData.confirmPassword) {
          throw new Error('Kata sandi tidak cocok');
        }
        // Registration logic would go here
        console.log('Register user:', formData);
      } else {
        // Login logic would go here
        console.log('Login user:', formData);
      }

      onClose();
      // Redirect or update UI after successful login/register
    } catch (err) {
      setError(err instanceof Error ? err.message : 'Terjadi kesalahan');
    } finally {
      setIsLoading(false);
    }
  };

  return (
    <AnimatePresence>
      {isOpen && (
        <>
          <motion.div
            className="fixed inset-0 bg-black/60 backdrop-blur-sm z-50"
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            exit={{ opacity: 0 }}
            onClick={onClose}
          />
          
          <motion.div
            className="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 max-w-md w-full bg-gray-900 rounded-2xl p-8 z-50"
            initial={{ opacity: 0, scale: 0.9, y: 20 }}
            animate={{ opacity: 1, scale: 1, y: 0 }}
            exit={{ opacity: 0, scale: 0.9, y: 20 }}
            transition={{ type: 'spring', damping: 25, stiffness: 300 }}
          >
            <div className="relative">
              {/* Header */}
              <div className="text-center mb-6">
                <h2 className="text-2xl font-display font-bold text-white">
                  {mode === 'login' ? 'Masuk ke Akun Anda' : 'Buat Akun Baru'}
                </h2>
                <p className="text-gray-400 text-sm mt-2">
                  {mode === 'login' 
                    ? 'Akses fitur khusus member dan dapatkan rekomendasi kartu' 
                    : 'Daftar untuk fitur khusus member dan rekomendasi personal'}
                </p>
              </div>
              
              {/* Close button */}
              <button 
                className="absolute top-0 right-0 text-gray-400 hover:text-white p-1"
                onClick={onClose}
              >
                <i className="ri-close-line text-xl"></i>
              </button>
              
              {/* Form */}
              <form onSubmit={handleSubmit}>
                {mode === 'register' && (
                  <div className="mb-4">
                    <label htmlFor="name" className="block text-sm font-medium text-gray-300 mb-1">
                      Nama Lengkap
                    </label>
                    <input
                      type="text"
                      id="name"
                      name="name"
                      value={formData.name}
                      onChange={handleChange}
                      className="w-full px-4 py-3 rounded-lg bg-gray-800 border border-gray-700 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                      placeholder="Masukkan nama lengkap"
                      required
                    />
                  </div>
                )}
                
                <div className="mb-4">
                  <label htmlFor="email" className="block text-sm font-medium text-gray-300 mb-1">
                    Email
                  </label>
                  <input
                    type="email"
                    id="email"
                    name="email"
                    value={formData.email}
                    onChange={handleChange}
                    className="w-full px-4 py-3 rounded-lg bg-gray-800 border border-gray-700 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="email@contoh.com"
                    required
                  />
                </div>
                
                <div className="mb-4">
                  <label htmlFor="password" className="block text-sm font-medium text-gray-300 mb-1">
                    Kata Sandi
                  </label>
                  <input
                    type="password"
                    id="password"
                    name="password"
                    value={formData.password}
                    onChange={handleChange}
                    className="w-full px-4 py-3 rounded-lg bg-gray-800 border border-gray-700 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder={mode === 'login' ? 'Masukkan kata sandi' : 'Buat kata sandi'}
                    required
                  />
                </div>
                
                {mode === 'register' && (
                  <div className="mb-4">
                    <label htmlFor="confirmPassword" className="block text-sm font-medium text-gray-300 mb-1">
                      Konfirmasi Kata Sandi
                    </label>
                    <input
                      type="password"
                      id="confirmPassword"
                      name="confirmPassword"
                      value={formData.confirmPassword}
                      onChange={handleChange}
                      className="w-full px-4 py-3 rounded-lg bg-gray-800 border border-gray-700 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                      placeholder="Konfirmasi kata sandi"
                      required
                    />
                  </div>
                )}
                
                {error && (
                  <div className="mb-4 p-3 bg-red-500/10 border border-red-500/30 rounded-lg text-red-400 text-sm">
                    {error}
                  </div>
                )}
                
                <button
                  type="submit"
                  className="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium rounded-lg flex items-center justify-center transition-all hover:shadow-lg hover:shadow-blue-500/20 focus:outline-none focus:ring-2 focus:ring-blue-500"
                  disabled={isLoading}
                >
                  {isLoading ? (
                    <motion.div
                      className="w-5 h-5 border-2 border-white border-t-transparent rounded-full"
                      animate={{ rotate: 360 }}
                      transition={{ repeat: Infinity, duration: 1, ease: "linear" }}
                    />
                  ) : (
                    mode === 'login' ? 'Masuk' : 'Daftar'
                  )}
                </button>
                
                <div className="mt-6 text-center">
                  <p className="text-gray-400 text-sm">
                    {mode === 'login' ? 'Belum punya akun?' : 'Sudah punya akun?'}
                    <button
                      type="button"
                      className="ml-2 text-blue-400 hover:text-blue-300 transition-colors"
                      onClick={onChangeMode}
                    >
                      {mode === 'login' ? 'Daftar sekarang' : 'Masuk sekarang'}
                    </button>
                  </p>
                </div>
              </form>
              
              {/* Social login */}
              <div className="mt-6 pt-6 border-t border-gray-800">
                <p className="text-gray-400 text-sm text-center mb-4">Atau lanjutkan dengan</p>
                <div className="flex space-x-3">
                  <button className="flex-1 py-3 px-4 bg-white/5 border border-gray-700 rounded-lg flex items-center justify-center text-white hover:bg-white/10 transition-colors">
                    <i className="ri-google-fill mr-2 text-red-500"></i>
                    Google
                  </button>
                  <button className="flex-1 py-3 px-4 bg-white/5 border border-gray-700 rounded-lg flex items-center justify-center text-white hover:bg-white/10 transition-colors">
                    <i className="ri-facebook-fill mr-2 text-blue-500"></i>
                    Facebook
                  </button>
                </div>
              </div>
            </div>
          </motion.div>
        </>
      )}
    </AnimatePresence>
  );
};

export default LoginModal;