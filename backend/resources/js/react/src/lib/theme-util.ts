/**
 * Utilitas untuk mengatur tema gelap/terang
 */

/**
 * Mengaktifkan tema gelap di seluruh aplikasi
 */
export function enableDarkMode() {
  document.documentElement.classList.add('dark');
  document.documentElement.classList.remove('light');
  document.documentElement.style.colorScheme = 'dark';
  localStorage.setItem('darkMode', 'true');
}

/**
 * Mengaktifkan tema terang di seluruh aplikasi
 */
export function enableLightMode() {
  document.documentElement.classList.add('light');
  document.documentElement.classList.remove('dark');
  document.documentElement.style.colorScheme = 'light';
  localStorage.setItem('darkMode', 'false');
}

/**
 * Toggle antara tema gelap dan terang
 * @returns {boolean} - Nilai baru dari isDarkMode
 */
export function toggleTheme(): boolean {
  const isDarkMode = localStorage.getItem('darkMode') === 'true';
  
  if (isDarkMode) {
    enableLightMode();
    return false;
  } else {
    enableDarkMode();
    return true;
  }
}

/**
 * Mengambil status tema saat ini
 * @returns {boolean} - true jika dark mode aktif
 */
export function isDarkMode(): boolean {
  // Default ke true (dark mode) jika tidak ada preferensi tersimpan
  return localStorage.getItem('darkMode') !== 'false';
}

/**
 * Menginisialisasi tema berdasarkan localStorage atau defaultDark
 * @param {boolean} defaultDark - Default ke dark mode jika tidak ada preferensi tersimpan
 */
export function initializeTheme(defaultDark = true) {
  const savedTheme = localStorage.getItem('darkMode');
  
  if (savedTheme === null) {
    // Tidak ada preferensi tersimpan, gunakan default
    if (defaultDark) {
      enableDarkMode();
    } else {
      enableLightMode();
    }
  } else {
    // Terapkan preferensi tersimpan
    if (savedTheme === 'true') {
      enableDarkMode();
    } else {
      enableLightMode();
    }
  }
}