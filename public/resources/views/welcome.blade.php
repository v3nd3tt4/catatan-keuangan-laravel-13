<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                * { margin: 0; padding: 0; box-sizing: border-box; }
                html { scroll-behavior: smooth; }
                body { font-family: 'Inter', sans-serif; background: #ffffff; color: #1f2937; }
            </style>
        @endif
    </head>
    <body class="bg-white">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center shadow-sm">
                            <span class="text-white font-bold text-lg">₽</span>
                        </div>
                        <span class="text-2xl font-bold text-gray-900">{{ config('app.name', 'Laravel') }}</span>
                    </div>

                    <!-- Nav Links -->
                    @if (Route::has('login'))
                        <div class="flex items-center space-x-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-indigo-600 font-medium transition">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 font-medium transition">
                                    Login
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium transition">
                                        Daftar
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="bg-gradient-to-br from-white via-indigo-50 to-white py-24 px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                            Kelola Keuangan Anda dengan <span class="bg-gradient-to-r from-indigo-600 to-indigo-500 bg-clip-text text-transparent">Mudah & Cerdas</span>
                        </h1>
                        <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                            Lacak setiap transaksi, kelola kategori pengeluaran, dan buat laporan keuangan yang komprehensif. Semua dalam satu dashboard yang intuitif, powerful, dan gratis.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4">
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-8 py-4 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-semibold transition text-center shadow-lg hover:shadow-xl">
                                    Mulai Gratis Sekarang
                                </a>
                            @endif
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="px-8 py-4 bg-white border-2 border-gray-300 text-gray-900 rounded-lg hover:border-indigo-600 hover:text-indigo-600 font-semibold transition text-center">
                                    Login ke Akun
                                </a>
                            @endif
                        </div>
                        <p class="text-sm text-gray-500 mt-6">✓ Gratis selamanya • ✓ Tidak perlu kartu kredit • ✓ Data aman & privat</p>
                    </div>
                    <div class="hidden md:block">
                        <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-2xl p-8 shadow-xl border border-indigo-100">
                            <div class="space-y-4">
                                <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-100">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600 font-medium">Total Saldo</span>
                                        <span class="text-3xl font-bold text-indigo-600">Rp 25.5M</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-100">
                                        <div class="text-xs text-gray-600 mb-2 font-medium">Pemasukan</div>
                                        <div class="text-2xl font-bold text-green-600">Rp 35.2M</div>
                                        <div class="text-xs text-green-600 mt-1">↑ 12%</div>
                                    </div>
                                    <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-100">
                                        <div class="text-xs text-gray-600 mb-2 font-medium">Pengeluaran</div>
                                        <div class="text-2xl font-bold text-red-600">Rp 9.7M</div>
                                        <div class="text-xs text-red-600 mt-1">↓ 5%</div>
                                    </div>
                                </div>
                                <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-100">
                                    <div class="text-xs text-gray-600 mb-3 font-medium">Transaksi Terbaru</div>
                                    <div class="space-y-3">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">Gaji Bulan</div>
                                                <div class="text-xs text-gray-500">15 Juni 2026</div>
                                            </div>
                                            <span class="text-green-600 font-semibold">+Rp 5.0M</span>
                                        </div>
                                        <div class="h-px bg-gray-100"></div>
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">Belanja Groceries</div>
                                                <div class="text-xs text-gray-500">14 Juni 2026</div>
                                            </div>
                                            <span class="text-red-600 font-semibold">-Rp 850K</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-24 px-4 sm:px-6 lg:px-8 bg-gray-50">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-20">
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Fitur Unggulan</h2>
                    <p class="text-xl text-gray-600">Semua yang Anda butuhkan untuk mengelola keuangan pribadi dengan efektif</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-white rounded-xl p-8 shadow-sm hover:shadow-lg transition border border-gray-100 hover:border-indigo-200">
                        <div class="w-14 h-14 bg-indigo-100 rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Pelacakan Transaksi</h3>
                        <p class="text-gray-600 leading-relaxed">Catat setiap transaksi income dan expense dengan detail lengkap. Kategorisasi otomatis untuk analisis yang lebih baik dan tracking yang akurat.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-white rounded-xl p-8 shadow-sm hover:shadow-lg transition border border-gray-100 hover:border-indigo-200">
                        <div class="w-14 h-14 bg-indigo-100 rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Laporan & Analitik</h3>
                        <p class="text-gray-600 leading-relaxed">Dapatkan insight mendalam tentang pola pengeluaran Anda. Filter berdasarkan periode dan kategori untuk analisis yang lebih detail dan actionable.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-white rounded-xl p-8 shadow-sm hover:shadow-lg transition border border-gray-100 hover:border-indigo-200">
                        <div class="w-14 h-14 bg-indigo-100 rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Kategori Fleksibel</h3>
                        <p class="text-gray-600 leading-relaxed">Buat kategori custom untuk setiap kebutuhan Anda. Atur warna favorit dan kelola dengan mudah untuk organisasi keuangan yang sempurna.</p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="bg-white rounded-xl p-8 shadow-sm hover:shadow-lg transition border border-gray-100 hover:border-indigo-200">
                        <div class="w-14 h-14 bg-indigo-100 rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Export PDF</h3>
                        <p class="text-gray-600 leading-relaxed">Download laporan keuangan Anda dalam format PDF yang profesional. Siap untuk dibagikan, diarsipkan, atau dicetak kapan saja.</p>
                    </div>

                    <!-- Feature 5 -->
                    <div class="bg-white rounded-xl p-8 shadow-sm hover:shadow-lg transition border border-gray-100 hover:border-indigo-200">
                        <div class="w-14 h-14 bg-indigo-100 rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Dashboard Intuitif</h3>
                        <p class="text-gray-600 leading-relaxed">Interface yang user-friendly dengan overview lengkap tentang keuangan Anda. Statistik dan visualisasi yang mudah dipahami.</p>
                    </div>

                    <!-- Feature 6 -->
                    <div class="bg-white rounded-xl p-8 shadow-sm hover:shadow-lg transition border border-gray-100 hover:border-indigo-200">
                        <div class="w-14 h-14 bg-indigo-100 rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Keamanan Terjamin</h3>
                        <p class="text-gray-600 leading-relaxed">Data Anda dilindungi dengan enkripsi tingkat enterprise. Verifikasi email dan sistem keamanan yang robust untuk akun Anda.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-r from-indigo-600 to-indigo-700">
            <div class="max-w-6xl mx-auto">
                <div class="grid md:grid-cols-3 gap-8 text-center">
                    <div class="transform hover:scale-105 transition">
                        <div class="text-5xl font-bold text-white mb-3">100%</div>
                        <p class="text-indigo-100 text-lg font-medium">Gratis Selamanya</p>
                    </div>
                    <div class="transform hover:scale-105 transition">
                        <div class="text-5xl font-bold text-white mb-3">∞</div>
                        <p class="text-indigo-100 text-lg font-medium">Transaksi Unlimited</p>
                    </div>
                    <div class="transform hover:scale-105 transition">
                        <div class="text-5xl font-bold text-white mb-3">🔒</div>
                        <p class="text-indigo-100 text-lg font-medium">Data Aman & Privat</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonial Section -->
        <section class="py-24 px-4 sm:px-6 lg:px-8 bg-white">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">Apa Kata Pengguna?</h2>
                    <p class="text-xl text-gray-600">Ribuan pengguna telah mempercayai Finance Tracker</p>
                </div>
                <div class="grid md:grid-cols-2 gap-8">
                    <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl p-8 border border-indigo-200">
                        <div class="flex items-center mb-4">
                            <div class="text-yellow-400">★★★★★</div>
                        </div>
                        <p class="text-gray-700 mb-4 leading-relaxed">"Finance Tracker benar-benar mengubah cara saya mengelola keuangan. Interface-nya yang mudah membuat saya bisa track pengeluaran dengan konsisten!"</p>
                        <p class="font-semibold text-gray-900">Budi Santoso</p>
                        <p class="text-sm text-gray-600">Pengusaha Muda</p>
                    </div>
                    <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl p-8 border border-indigo-200">
                        <div class="flex items-center mb-4">
                            <div class="text-yellow-400">★★★★★</div>
                        </div>
                        <p class="text-gray-700 mb-4 leading-relaxed">"Fitur laporan PDF-nya sangat membantu untuk audit finansial pribadi saya. Rekomendasikan untuk siapa saja yang ingin terorganisir!"</p>
                        <p class="font-semibold text-gray-900">Siti Nurhaliza</p>
                        <p class="text-sm text-gray-600">Profesional Keuangan</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-24 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-white via-indigo-50 to-white">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">Siap Mengambil Kontrol Keuangan Anda?</h2>
                <p class="text-xl text-gray-600 mb-10">Bergabunglah dengan ribuan pengguna yang telah mengoptimalkan pengelolaan keuangan pribadi mereka.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-10 py-4 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-semibold transition text-center text-lg shadow-lg hover:shadow-xl">
                            Daftar Gratis Sekarang
                        </a>
                    @endif
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="px-10 py-4 bg-gray-100 text-gray-900 rounded-lg hover:bg-gray-200 font-semibold transition text-center text-lg border-2 border-gray-300">
                            Sudah Punya Akun? Login
                        </a>
                    @endif
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 text-gray-300 py-16 px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <div class="grid md:grid-cols-4 gap-8 mb-12">
                    <div>
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center">
                                <span class="text-white font-bold">₽</span>
                            </div>
                            <span class="font-bold text-white text-lg">Finance Tracker</span>
                        </div>
                        <p class="text-sm text-gray-400">Platform manajemen keuangan pribadi yang mudah digunakan dan gratis selamanya.</p>
                    </div>
                    <div>
                        <h4 class="font-semibold text-white mb-4">Fitur</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="hover:text-indigo-400 transition">Dashboard</a></li>
                            <li><a href="#" class="hover:text-indigo-400 transition">Laporan</a></li>
                            <li><a href="#" class="hover:text-indigo-400 transition">Kategori</a></li>
                            <li><a href="#" class="hover:text-indigo-400 transition">Export PDF</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold text-white mb-4">Bantuan</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="hover:text-indigo-400 transition">FAQ</a></li>
                            <li><a href="#" class="hover:text-indigo-400 transition">Dokumentasi</a></li>
                            <li><a href="#" class="hover:text-indigo-400 transition">Support</a></li>
                            <li><a href="#" class="hover:text-indigo-400 transition">Blog</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold text-white mb-4">Legal</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="hover:text-indigo-400 transition">Privacy Policy</a></li>
                            <li><a href="#" class="hover:text-indigo-400 transition">Terms of Service</a></li>
                            <li><a href="#" class="hover:text-indigo-400 transition">Cookie Policy</a></li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-gray-800 pt-8 text-center text-sm text-gray-400">
                    <p>&copy; 2026 Finance Tracker. Semua hak dilindungi. | Dibuat dengan ❤️ untuk membantu Anda mengelola keuangan</p>
                </div>
            </div>
        </footer>
    </body>
</html>
