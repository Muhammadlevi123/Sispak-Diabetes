<template>
    <div class="min-h-screen bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50">

        <Head title="DiabetCare - Sistem Pakar Diagnosa Diabetes Melitus" />

        <nav class="bg-white/70 backdrop-blur-lg border-b border-emerald-100/50 sticky top-0 z-50 shadow-sm">
            <div class="max-w-7xl mx-auto px-6 py-3">
                <div class="flex items-center justify-between">
                    <!-- Logo Section -->
                    <div class="flex items-center space-x-8">
                        <Link href="/user/dashboard" class="flex items-center space-x-3 group">
                        <div
                            class="relative w-12 h-12 bg-gradient-to-br from-emerald-500 via-teal-500 to-cyan-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300 group-hover:scale-105">
                            <div
                                class="absolute inset-0 bg-gradient-to-br from-emerald-400 to-teal-600 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                            <svg class="w-7 h-7 text-white relative z-10" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 1H5C3.9 1 3 1.9 3 3V21C3 22.1 3.9 23 5 23H19C20.1 23 21 22.1 21 21V9M19 9H15V5H19V9Z" />
                            </svg>
                            <div
                                class="absolute -inset-1 bg-gradient-to-br from-emerald-400 to-teal-600 rounded-2xl blur opacity-30 group-hover:opacity-60 transition-opacity duration-300">
                            </div>
                        </div>
                        <div class="relative">
                            <h1
                                class="text-2xl font-bold bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 bg-clip-text text-transparent">
                                DiabetCare
                            </h1>
                            <p class="text-xs text-emerald-600/70 font-medium tracking-wider">
                                SISTEM PAKAR DIABETES
                            </p>
                            <div
                                class="absolute -bottom-1 left-0 w-full h-0.5 bg-gradient-to-r from-emerald-500 to-teal-500 scale-x-0 group-hover:scale-x-100 transition-transform duration-300">
                            </div>
                        </div>
                        </Link>

                        <!-- Navigation Links -->
                        <nav class="hidden lg:flex space-x-1">
                            <Link href="/user/dashboard" :class="[
                                'relative px-4 py-2 font-medium transition-all duration-300 rounded-lg group',
                                $page.url === '/user/dashboard'
                                    ? 'text-emerald-600 bg-emerald-50'
                                    : 'text-gray-700 hover:text-emerald-600 hover:bg-emerald-50/50'
                            ]">
                            <span class="relative z-10">Beranda</span>
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-lg opacity-0 group-hover:opacity-10 transition-opacity duration-300">
                            </div>
                            </Link>
                            <Link href="/user/diagnosa" :class="[
                                'relative px-4 py-2 font-medium transition-all duration-300 rounded-lg group',
                                $page.url === 'user/diagnosa'
                                    ? 'text-emerald-600 bg-emerald-50'
                                    : 'text-gray-700 hover:text-emerald-600 hover:bg-emerald-50/50'
                            ]">
                            <span class="relative z-10">Diagnosis</span>
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-lg opacity-0 group-hover:opacity-10 transition-opacity duration-300">
                            </div>
                            </Link>
                        </nav>
                    </div>

                    <!-- Right Section -->
                    <div class="flex items-center space-x-4">
                        <!-- Authenticated User Menu -->
                        <div v-if="$page.props.auth.user" class="relative">
                            <button @click="toggleProfileDropdown"
                                class="relative w-11 h-11 bg-gradient-to-br from-emerald-500 via-teal-500 to-cyan-500 rounded-full flex items-center justify-center hover:shadow-lg transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 hover:scale-105 group">
                                <span class="text-white text-sm font-bold relative z-10">
                                    {{ $page.props.auth.user.name.charAt(0).toUpperCase() }}
                                </span>
                                <div
                                    class="absolute inset-0 bg-gradient-to-br from-emerald-400 to-teal-600 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>
                                <div
                                    class="absolute -inset-1 bg-gradient-to-br from-emerald-400 to-teal-600 rounded-full blur opacity-30 group-hover:opacity-60 transition-opacity duration-300">
                                </div>
                            </button>

                            <!-- Enhanced Profile Dropdown -->
                            <transition enter-active-class="transition ease-out duration-200"
                                enter-from-class="transform opacity-0 scale-95"
                                enter-to-class="transform opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-150"
                                leave-from-class="transform opacity-100 scale-100"
                                leave-to-class="transform opacity-0 scale-95">
                                <div v-if="showProfileDropdown"
                                    class="absolute right-0 mt-3 w-64 bg-white/95 backdrop-blur-lg rounded-2xl shadow-2xl border border-emerald-100/50 py-2 z-50"
                                    @click.away="showProfileDropdown = false">
                                    <!-- User Info Header -->
                                    <div
                                        class="px-4 py-3 border-b border-emerald-100/50 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-t-2xl">
                                        <div class="flex items-center space-x-3">
                                            <div
                                                class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-full flex items-center justify-center">
                                                <span class="text-white text-sm font-bold">
                                                    {{ $page.props.auth.user.name.charAt(0).toUpperCase() }}
                                                </span>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">{{
                                                    $page.props.auth.user.name }}</p>
                                                <p class="text-xs text-emerald-600">{{ $page.props.auth.user.email }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Menu Items -->
                                    <div class="py-2">
                                        <Link href="/profile"
                                            class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-emerald-50 hover:to-teal-50 hover:text-emerald-600 transition-all duration-200 group"
                                            @click="showProfileDropdown = false">
                                        <div
                                            class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-emerald-200 transition-colors duration-200">
                                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                </path>
                                            </svg>
                                        </div>
                                        <span class="font-medium">Profil Saya</span>
                                        </Link>

                                        <Link href="/riwayat"
                                            class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-emerald-50 hover:to-teal-50 hover:text-emerald-600 transition-all duration-200 group"
                                            @click="showProfileDropdown = false">
                                        <div
                                            class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors duration-200">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <span class="font-medium">Riwayat Diagnosis</span>
                                        </Link>

                                        <Link href="/pengaturan"
                                            class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-emerald-50 hover:to-teal-50 hover:text-emerald-600 transition-all duration-200 group"
                                            @click="showProfileDropdown = false">
                                        <div
                                            class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-purple-200 transition-colors duration-200">
                                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </div>
                                        <span class="font-medium">Pengaturan</span>
                                        </Link>

                                        <div class="border-t border-emerald-100/50 mt-2 pt-2">
                                            <button @click="logout"
                                                class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-all duration-200 group">
                                                <div
                                                    class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-red-200 transition-colors duration-200">
                                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <span class="font-medium">Keluar</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </transition>
                        </div>

                        <!-- Guest Menu -->
                        <template v-else>
                            <Link href="/login"
                                class="hidden md:block px-4 py-2 text-gray-700 hover:text-emerald-600 font-medium transition-all duration-200 rounded-lg hover:bg-emerald-50/50">
                            Masuk
                            </Link>
                            <Link href="/register"
                                class="relative px-6 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105 group overflow-hidden">
                            <span class="relative z-10">Daftar</span>
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-emerald-500 to-teal-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                            </Link>
                        </template>

                        <!-- Mobile Menu Button -->
                        <button @click="toggleMobileMenu"
                            class="lg:hidden p-2 text-gray-700 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Enhanced Mobile Menu -->
                <transition enter-active-class="transition ease-out duration-300"
                    enter-from-class="transform opacity-0 scale-95 -translate-y-2"
                    enter-to-class="transform opacity-100 scale-100 translate-y-0"
                    leave-active-class="transition ease-in duration-200"
                    leave-from-class="transform opacity-100 scale-100 translate-y-0"
                    leave-to-class="transform opacity-0 scale-95 -translate-y-2">
                    <div v-if="showMobileMenu"
                        class="lg:hidden mt-4 p-4 bg-white/95 backdrop-blur-lg rounded-2xl shadow-2xl border border-emerald-100/50">
                        <div class="flex flex-col space-y-2">
                            <Link href="/"
                                class="text-gray-700 hover:text-emerald-600 hover:bg-emerald-50 font-medium py-3 px-4 rounded-xl transition-all duration-200"
                                @click="showMobileMenu = false">
                            Beranda
                            </Link>
                            <Link href="/user/diagnosa"
                                class="text-gray-700 hover:text-emerald-600 hover:bg-emerald-50 font-medium py-3 px-4 rounded-xl transition-all duration-200"
                                @click="showMobileMenu = false">
                            Diagnosis
                            </Link>

                            <!-- Mobile User Menu -->
                            <div v-if="$page.props.auth.user" class="border-t border-emerald-100/50 pt-4 mt-4">
                                <div
                                    class="flex items-center space-x-3 mb-4 p-3 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-full flex items-center justify-center">
                                        <span class="text-white text-sm font-bold">
                                            {{ $page.props.auth.user.name.charAt(0).toUpperCase() }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $page.props.auth.user.name }}
                                        </p>
                                        <p class="text-xs text-emerald-600">{{ $page.props.auth.user.email }}</p>
                                    </div>
                                </div>

                                <Link href="/profile"
                                    class="block text-gray-700 hover:text-emerald-600 hover:bg-emerald-50 font-medium py-3 px-4 rounded-xl transition-all duration-200"
                                    @click="showMobileMenu = false">
                                Profil Saya
                                </Link>
                                <Link href="/riwayat"
                                    class="block text-gray-700 hover:text-emerald-600 hover:bg-emerald-50 font-medium py-3 px-4 rounded-xl transition-all duration-200"
                                    @click="showMobileMenu = false">
                                Riwayat Diagnosis
                                </Link>
                                <button @click="logout"
                                    class="block w-full text-left text-red-600 hover:text-red-700 hover:bg-red-50 font-medium py-3 px-4 rounded-xl transition-all duration-200">
                                    Keluar
                                </button>
                            </div>

                            <!-- Mobile Guest Menu -->
                            <div v-else class="border-t border-emerald-100/50 pt-4 mt-4 space-y-2">
                                <Link href="/login"
                                    class="block text-gray-700 hover:text-emerald-600 hover:bg-emerald-50 font-medium py-3 px-4 rounded-xl transition-all duration-200"
                                    @click="showMobileMenu = false">
                                Masuk
                                </Link>
                                <Link href="/register"
                                    class="block bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white px-4 py-3 rounded-xl font-semibold transition-all duration-300 text-center shadow-lg"
                                    @click="showMobileMenu = false">
                                Daftar
                                </Link>
                            </div>
                        </div>
                    </div>
                </transition>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="px-6 py-20">
            <div class="max-w-7xl mx-auto">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    <div class="space-y-8">
                        <div class="space-y-4">
                            <div
                                class="inline-flex items-center space-x-2 bg-emerald-100 text-emerald-800 px-4 py-2 rounded-full text-sm font-medium">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Forward Chaining AI Technology</span>
                            </div>
                            <h1 class="text-5xl lg:text-6xl font-bold text-gray-900 leading-tight">
                                Sistem Pakar
                                <span
                                    class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-600">
                                    Diagnosa Diabetes
                                </span>
                                Melitus
                            </h1>
                            <p class="text-xl text-gray-600 leading-relaxed">
                                Dapatkan diagnosa awal untuk 5 jenis Diabetes Melitus menggunakan metode Forward
                                Chaining.
                                Deteksi dini dengan akurasi tinggi berdasarkan gejala yang Anda alami.
                            </p>
                        </div>

                        <!-- Diabetes Types Preview -->
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div class="flex items-center space-x-2 text-gray-600">
                                <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
                                <span>Diabetes Tipe 1</span>
                            </div>
                            <div class="flex items-center space-x-2 text-gray-600">
                                <div class="w-2 h-2 bg-teal-500 rounded-full"></div>
                                <span>Diabetes Tipe 2</span>
                            </div>
                            <div class="flex items-center space-x-2 text-gray-600">
                                <div class="w-2 h-2 bg-cyan-500 rounded-full"></div>
                                <span>Pra Diabetes</span>
                            </div>
                            <div class="flex items-center space-x-2 text-gray-600">
                                <div class="w-2 h-2 bg-emerald-400 rounded-full"></div>
                                <span>Diabetes Gestasional</span>
                            </div>
                            <div class="flex items-center space-x-2 text-gray-600 col-span-2">
                                <div class="w-2 h-2 bg-teal-400 rounded-full"></div>
                                <span>Diabetes karena Malnutrisi</span>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4">
                            <Link href="/user/diagnosa"
                                class="group bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 inline-flex items-center justify-center space-x-3 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Mulai Diagnosis</span>
                            </Link>
                            <Link href="/edukasi"
                                class="group border-2 border-emerald-200 hover:border-emerald-300 text-emerald-700 hover:text-emerald-800 px-8 py-4 rounded-xl font-semibold transition-all duration-300 inline-flex items-center justify-center space-x-3 hover:bg-emerald-50">
                            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <span>Pelajari Diabetes</span>
                            </Link>
                        </div>
                    </div>

                    <!-- Visual Illustration -->
                    <div class="relative">
                        <!-- Main Illustration -->
                        <div
                            class="relative bg-gradient-to-br from-emerald-100 via-teal-50 to-cyan-100 rounded-3xl p-8 shadow-2xl">
                            <!-- Forward Chaining Diagram -->
                            <div class="space-y-6">
                                <div class="text-center">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Metode Forward Chaining</h3>
                                </div>

                                <!-- Facts (Gejala) -->
                                <div class="flex flex-wrap gap-2 justify-center">
                                    <div
                                        class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-medium">
                                        G01:
                                        Sering Lapar</div>
                                    <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-medium">
                                        G02:
                                        Sering Haus</div>
                                    <div
                                        class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs font-medium">
                                        G03:
                                        Sering Kencing</div>
                                </div>

                                <!-- Arrow -->
                                <div class="flex justify-center">
                                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                    </svg>
                                </div>

                                <!-- Rules Engine -->
                                <div class="bg-white rounded-xl p-4 shadow-lg">
                                    <div class="text-center">
                                        <div
                                            class="w-12 h-12 bg-emerald-600 rounded-full mx-auto mb-2 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <p class="text-sm font-medium text-gray-800">IF-THEN Rules</p>
                                        <p class="text-xs text-gray-600">Basis Pengetahuan</p>
                                    </div>
                                </div>

                                <!-- Arrow -->
                                <div class="flex justify-center">
                                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                    </svg>
                                </div>

                                <!-- Conclusion -->
                                <div
                                    class="bg-gradient-to-r from-emerald-500 to-teal-500 rounded-xl p-4 text-white text-center">
                                    <div class="font-semibold">P01: Diabetes Tipe 1</div>
                                    <p class="text-xs text-emerald-100 mt-1">Hasil Diagnosis</p>
                                </div>
                            </div>
                        </div>

                        <!-- Floating Stats -->
                        <div
                            class="absolute -top-6 -right-6 bg-white rounded-2xl shadow-lg p-4 border border-emerald-100">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800">95%</p>
                                    <p class="text-xs text-gray-600">Akurasi</p>
                                </div>
                            </div>
                        </div>

                        <div
                            class="absolute -bottom-4 -left-4 bg-white rounded-2xl shadow-lg p-4 border border-teal-100">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-teal-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800">1000+</p>
                                    <p class="text-xs text-gray-600">Pengguna</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- How It Works Section -->
        <section class="px-6 py-20 bg-white">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                        Bagaimana Sistem Pakar Bekerja?
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Menggunakan metode Forward Chaining untuk menalar dari fakta (gejala) menuju kesimpulan
                        (diagnosis)
                        berdasarkan aturan IF-THEN yang telah ditentukan.
                    </p>
                </div>

                <div class="grid lg:grid-cols-4 gap-8">
                    <!-- Step 1 -->
                    <div class="text-center group">
                        <div class="relative">
                            <div
                                class="w-20 h-20 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl mx-auto mb-6 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div
                                class="absolute -top-2 -right-2 w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                1</div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Input Gejala</h3>
                        <p class="text-gray-600 text-sm">
                            Masukkan gejala yang Anda rasakan seperti sering haus (G02), sering lapar (G01), atau gejala
                            lainnya.
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="text-center group">
                        <div class="relative">
                            <div
                                class="w-20 h-20 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-2xl mx-auto mb-6 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                                </svg>
                            </div>
                            <div
                                class="absolute -top-2 -right-2 w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                2</div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Basis Pengetahuan</h3>
                        <p class="text-gray-600 text-sm">
                            Sistem mencocokkan gejala dengan basis pengetahuan dari referensi medis terpercaya.
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="text-center group">
                        <div class="relative">
                            <div
                                class="w-20 h-20 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-2xl mx-auto mb-6 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                            </div>
                            <div
                                class="absolute -top-2 -right-2 w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                3</div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Forward Chaining</h3>
                        <p class="text-gray-600 text-sm">
                            Proses penalaran dari fakta menuju kesimpulan menggunakan aturan IF-THEN.
                        </p>
                    </div>

                    <!-- Step 4 -->
                    <div class="text-center group">
                        <div class="relative">
                            <div
                                class="w-20 h-20 bg-gradient-to-br from-green-400 to-emerald-500 rounded-2xl mx-auto mb-6 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div
                                class="absolute -top-2 -right-2 w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                4</div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Hasil Diagnosis</h3>
                        <p class="text-gray-600 text-sm">
                            Dapatkan diagnosis awal dengan penjelasan informatif tentang jenis diabetes yang terdeteksi.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Diabetes Types Section -->
        <section class="px-6 py-20 bg-gradient-to-br from-emerald-50 to-teal-50">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                        5 Jenis Diabetes yang Dapat Dideteksi
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Sistem kami dapat mendiagnosis lima jenis Diabetes Melitus dengan karakteristik dan pola gejala
                        yang
                        unik.
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Diabetes Tipe 1 -->
                    <div
                        class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow border border-emerald-100">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                                <span class="text-red-600 font-bold">P01</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Diabetes Tipe 1</h3>
                                <p class="text-sm text-gray-600">Autoimun</p>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">
                            Kondisi autoimun di mana pankreas tidak dapat memproduksi insulin. Biasanya terjadi pada
                            anak-anak
                            dan remaja.
                        </p>
                        <div class="space-y-2">
                            <div class="flex items-center space-x-2 text-xs text-gray-600">
                                <div class="w-1.5 h-1.5 bg-red-400 rounded-full"></div>
                                <span>Sering lapar & haus</span>
                            </div>
                            <div class="flex items-center space-x-2 text-xs text-gray-600">
                                <div class="w-1.5 h-1.5 bg-red-400 rounded-full"></div>
                                <span>Penurunan berat badan drastis</span>
                            </div>
                            <div class="flex items-center space-x-2 text-xs text-gray-600">
                                <div class="w-1.5 h-1.5 bg-red-400 rounded-full"></div>
                                <span>Kelelahan berlebihan</span>
                            </div>
                        </div>
                    </div>

                    <!-- Diabetes Tipe 2 -->
                    <div
                        class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow border border-emerald-100">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                <span class="text-blue-600 font-bold">P02</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Diabetes Tipe 2</h3>
                                <p class="text-sm text-gray-600">Resistensi Insulin</p>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">
                            Tubuh tidak dapat menggunakan insulin dengan efektif. Paling umum terjadi pada orang dewasa.
                        </p>
                        <div class="space-y-2">
                            <div class="flex items-center space-x-2 text-xs text-gray-600">
                                <div class="w-1.5 h-1.5 bg-blue-400 rounded-full"></div>
                                <span>Gejala berkembang perlahan</span>
                            </div>
                            <div class="flex items-center space-x-2 text-xs text-gray-600">
                                <div class="w-1.5 h-1.5 bg-blue-400 rounded-full"></div>
                                <span>Sering infeksi</span>
                            </div>
                            <div class="flex items-center space-x-2 text-xs text-gray-600">
                                <div class="w-1.5 h-1.5 bg-blue-400 rounded-full"></div>
                                <span>Luka sulit sembuh</span>
                            </div>
                        </div>
                    </div>

                    <!-- Pra Diabetes -->
                    <div
                        class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow border border-emerald-100">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                                <span class="text-yellow-600 font-bold">P03</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Pra Diabetes</h3>
                                <p class="text-sm text-gray-600">Stadium Awal</p>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">
                            Kadar gula darah lebih tinggi dari normal tapi belum mencapai kriteria diabetes.
                        </p>
                        <div class="space-y-2">
                            <div class="flex items-center space-x-2 text-xs text-gray-600">
                                <div class="w-1.5 h-1.5 bg-yellow-400 rounded-full"></div>
                                <span>Dapat dicegah</span>
                            </div>
                            <div class="flex items-center space-x-2 text-xs text-gray-600">
                                <div class="w-1.5 h-1.5 bg-yellow-400 rounded-full"></div>
                                <span>Gejala ringan</span>
                            </div>
                            <div class="flex items-center space-x-2 text-xs text-gray-600">
                                <div class="w-1.5 h-1.5 bg-yellow-400 rounded-full"></div>
                                <span>Deteksi dini penting</span>
                            </div>
                        </div>
                    </div>

                    <!-- Diabetes Gestasional -->
                    <div
                        class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow border border-emerald-100">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="w-12 h-12 bg-pink-100 rounded-xl flex items-center justify-center">
                                <span class="text-pink-600 font-bold">P04</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Diabetes Gestasional</h3>
                                <p class="text-sm text-gray-600">Saat Kehamilan</p>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">
                            Diabetes yang terjadi selama kehamilan dan biasanya hilang setelah melahirkan.
                        </p>
                        <div class="space-y-2">
                            <div class="flex items-center space-x-2 text-xs text-gray-600">
                                <div class="w-1.5 h-1.5 bg-pink-400 rounded-full"></div>
                                <span>Terjadi saat hamil</span>
                            </div>
                            <div class="flex items-center space-x-2 text-xs text-gray-600">
                                <div class="w-1.5 h-1.5 bg-pink-400 rounded-full"></div>
                                <span>Risiko komplikasi kehamilan</span>
                            </div>
                            <div class="flex items-center space-x-2 text-xs text-gray-600">
                                <div class="w-1.5 h-1.5 bg-pink-400 rounded-full"></div>
                                <span>Perlu monitoring ketat</span>
                            </div>
                        </div>
                    </div>

                    <!-- Diabetes Malnutrisi -->
                    <div
                        class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow border border-emerald-100 md:col-span-2 lg:col-span-1">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                                <span class="text-purple-600 font-bold">P05</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Diabetes Malnutrisi</h3>
                                <p class="text-sm text-gray-600">Kekurangan Nutrisi</p>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">
                            Diabetes yang disebabkan oleh malnutrisi kronis, terutama kekurangan protein.
                        </p>
                        <div class="space-y-2">
                            <div class="flex items-center space-x-2 text-xs text-gray-600">
                                <div class="w-1.5 h-1.5 bg-purple-400 rounded-full"></div>
                                <span>Akibat malnutrisi</span>
                            </div>
                            <div class="flex items-center space-x-2 text-xs text-gray-600">
                                <div class="w-1.5 h-1.5 bg-purple-400 rounded-full"></div>
                                <span>Kekurangan protein kronis</span>
                            </div>
                            <div class="flex items-center space-x-2 text-xs text-gray-600">
                                <div class="w-1.5 h-1.5 bg-purple-400 rounded-full"></div>
                                <span>Sering di negara berkembang</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="px-6 py-20 bg-white">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                        Keunggulan Sistem DiabetCare
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Teknologi Forward Chaining dengan basis pengetahuan medis terpercaya untuk diagnosa yang akurat
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feature 1: Forward Chaining -->
                    <div
                        class="group bg-gradient-to-br from-emerald-50 to-teal-50 rounded-2xl p-8 hover:shadow-lg transition-all duration-300">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Forward Chaining AI</h3>
                        <p class="text-gray-600 mb-4">
                            Menggunakan metode penalaran maju dari gejala (fakta) menuju diagnosis berdasarkan aturan
                            IF-THEN
                            yang telah terdefinisi.
                        </p>
                        <div class="text-sm text-emerald-600 font-medium">
                            Gejala → Aturan → Diagnosis
                        </div>
                    </div>

                    <!-- Feature 2: Medical Knowledge Base -->
                    <div
                        class="group bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-8 hover:shadow-lg transition-all duration-300">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Basis Pengetahuan Medis</h3>
                        <p class="text-gray-600 mb-4">
                            Dibangun dari referensi medis terpercaya seperti buku, jurnal, dan artikel medis dari
                            berbagai
                            sumber ilmiah.
                        </p>
                        <div class="text-sm text-blue-600 font-medium">
                            Buku + Jurnal + Artikel Medis
                        </div>
                    </div>

                    <!-- Feature 3: Symptom Coding -->
                    <div
                        class="group bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl p-8 hover:shadow-lg transition-all duration-300">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Sistem Pengkodean</h3>
                        <p class="text-gray-600 mb-4">
                            Gejala dan penyakit dikodekan untuk memudahkan pemrosesan data. Contoh: G02 (Sering Haus),
                            P01
                            (Diabetes Tipe 1).
                        </p>
                        <div class="text-sm text-orange-600 font-medium">
                            G01-G20: Gejala | P01-P05: Penyakit
                        </div>
                    </div>

                    <!-- Feature 4: 5 Types Detection -->
                    <div
                        class="group bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-8 hover:shadow-lg transition-all duration-300">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">5 Jenis Diabetes</h3>
                        <p class="text-gray-600 mb-4">
                            Mampu mendeteksi Diabetes Tipe 1, Tipe 2, Pra Diabetes, Gestasional, dan karena Malnutrisi
                            dengan
                            pola gejala unik.
                        </p>
                        <div class="text-sm text-purple-600 font-medium">
                            Deteksi Komprehensif & Akurat
                        </div>
                    </div>

                    <!-- Feature 5: Educational -->
                    <div
                        class="group bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-8 hover:shadow-lg transition-all duration-300">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Edukatif & Informatif</h3>
                        <p class="text-gray-600 mb-4">
                            Tidak hanya memberikan diagnosis, tetapi juga penjelasan informatif tentang setiap jenis
                            diabetes
                            untuk edukasi pengguna.
                        </p>
                        <div class="text-sm text-green-600 font-medium">
                            Diagnosis + Edukasi Kesehatan
                        </div>
                    </div>

                    <!-- Feature 6: Web-based -->
                    <div
                        class="group bg-gradient-to-br from-cyan-50 to-blue-50 rounded-2xl p-8 hover:shadow-lg transition-all duration-300">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Akses Mudah</h3>
                        <p class="text-gray-600 mb-4">
                            Berbasis web sehingga dapat diakses kapan saja, di mana saja melalui browser tanpa perlu
                            instalasi
                            aplikasi.
                        </p>
                        <div class="text-sm text-cyan-600 font-medium">
                            24/7 Available | Cross Platform
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Statistics Section -->
        <section class="px-6 py-20 bg-gradient-to-br from-gray-900 via-emerald-900 to-teal-900 text-white">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-4xl font-bold mb-4">
                        Statistik & Pencapaian
                    </h2>
                    <p class="text-xl text-emerald-100 max-w-3xl mx-auto">
                        Sistem pakar DiabetCare telah membantu ribuan pengguna dalam deteksi dini diabetes
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Stat 1 -->
                    <div class="text-center group">
                        <div
                            class="w-20 h-20 bg-emerald-500/20 backdrop-blur-sm rounded-2xl mx-auto mb-6 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-10 h-10 text-emerald-300" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z" />
                            </svg>
                        </div>
                        <div class="text-4xl font-bold text-white mb-2">1,250+</div>
                        <div class="text-emerald-200">Pengguna Aktif</div>
                        <div class="text-sm text-emerald-300 mt-1">Per bulan</div>
                    </div>

                    <!-- Stat 2 -->
                    <div class="text-center group">
                        <div
                            class="w-20 h-20 bg-teal-500/20 backdrop-blur-sm rounded-2xl mx-auto mb-6 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-10 h-10 text-teal-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="text-4xl font-bold text-white mb-2">95.8%</div>
                        <div class="text-teal-200">Tingkat Akurasi</div>
                        <div class="text-sm text-teal-300 mt-1">Forward Chaining</div>
                    </div>

                    <!-- Stat 3 -->
                    <div class="text-center group">
                        <div
                            class="w-20 h-20 bg-cyan-500/20 backdrop-blur-sm rounded-2xl mx-auto mb-6 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-10 h-10 text-cyan-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 00-2-2z" />
                            </svg>
                        </div>
                        <div class="text-4xl font-bold text-white mb-2">3,450+</div>
                        <div class="text-cyan-200">Diagnosis Selesai</div>
                        <div class="text-sm text-cyan-300 mt-1">Total keseluruhan</div>
                    </div>

                    <!-- Stat 4 -->
                    <div class="text-center group">
                        <div
                            class="w-20 h-20 bg-emerald-400/20 backdrop-blur-sm rounded-2xl mx-auto mb-6 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-10 h-10 text-emerald-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="text-4xl font-bold text-white mb-2">24/7</div>
                        <div class="text-emerald-200">Tersedia</div>
                        <div class="text-sm text-emerald-300 mt-1">Akses kapan saja</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Call to Action Section -->
        <section class="px-6 py-20 bg-gradient-to-br from-emerald-500 via-teal-500 to-cyan-500">
            <div class="max-w-4xl mx-auto text-center text-white">
                <h2 class="text-3xl lg:text-5xl font-bold mb-6">
                    Mulai Deteksi Dini Diabetes Anda
                </h2>
                <p class="text-xl lg:text-2xl text-emerald-100 mb-8 leading-relaxed">
                    Jangan tunggu gejala semakin parah. Gunakan sistem pakar DiabetCare untuk
                    mendapatkan diagnosis awal yang akurat dan terpercaya.
                </p>

                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center mb-12">
                    <Link href="/user/diagnosa"
                        class="group bg-white text-emerald-600 hover:text-emerald-700 px-10 py-4 rounded-2xl font-bold text-lg transition-all duration-300 inline-flex items-center space-x-3 shadow-xl hover:shadow-2xl transform hover:-translate-y-2">
                    <svg class="w-6 h-6 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Mulai Diagnosis Sekarang</span>
                    </Link>

                    <Link href="/edukasi"
                        class="group border-2 border-white/30 hover:border-white text-white hover:bg-white/10 px-10 py-4 rounded-2xl font-bold text-lg transition-all duration-300 inline-flex items-center space-x-3 backdrop-blur-sm">
                    <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span>Pelajari Lebih Lanjut</span>
                    </Link>
                </div>

                <!-- Trust Indicators -->
                <div class="flex flex-wrap justify-center items-center gap-8 text-emerald-100">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm">Berbasis Referensi Medis</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm">Forward Chaining AI</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm">Gratis & Mudah Digunakan</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white px-6 py-16">
            <div class="max-w-7xl mx-auto">
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Brand -->
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 1H5C3.9 1 3 1.9 3 3V21C3 22.1 3.9 23 5 23H19C20.1 23 21 22.1 21 21V9M19 9H15V5H19V9Z" />
                                </svg>
                            </div>
                            <div>
                                <span class="text-xl font-bold">DiabetCare</span>
                                <p class="text-xs text-gray-400">Sistem Pakar Diabetes</p>
                            </div>
                        </div>
                        <p class="text-gray-400 text-sm leading-relaxed">
                            Sistem pakar berbasis web untuk diagnosis awal Diabetes Melitus menggunakan metode Forward
                            Chaining
                            dengan akurasi tinggi.
                        </p>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h3 class="font-semibold text-lg mb-4">Menu Utama</h3>
                        <div class="space-y-3">
                            <Link href="/" class="block text-gray-400 hover:text-emerald-400 transition-colors text-sm">
                            Beranda
                            </Link>
                            <Link href="/diagnosis"
                                class="block text-gray-400 hover:text-emerald-400 transition-colors text-sm">Mulai
                            Diagnosis
                            </Link>
                            <Link href="/gejala"
                                class="block text-gray-400 hover:text-emerald-400 transition-colors text-sm">
                            Daftar Gejala</Link>
                            <Link href="/edukasi"
                                class="block text-gray-400 hover:text-emerald-400 transition-colors text-sm">
                            Edukasi Diabetes</Link>
                        </div>
                    </div>

                    <!-- Diabetes Types -->
                    <div>
                        <h3 class="font-semibold text-lg mb-4">Jenis Diabetes</h3>
                        <div class="space-y-3">
                            <div class="text-gray-400 text-sm">P01: Diabetes Tipe 1</div>
                            <div class="text-gray-400 text-sm">P02: Diabetes Tipe 2</div>
                            <div class="text-gray-400 text-sm">P03: Pra Diabetes</div>
                            <div class="text-gray-400 text-sm">P04: Diabetes Gestasional</div>
                            <div class="text-gray-400 text-sm">P05: Diabetes Malnutrisi</div>
                        </div>
                    </div>

                    <!-- Kontak -->
                    <div>
                        <h3 class="text-lg font-semibold mb-6">Kontak</h3>
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <svg class="w-5 h-5 text-emerald-400 mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <div>
                                    <p class="text-emerald-200">Jl. Mawar</p>
                                    <p class="text-emerald-200">kos Mawar Sehati</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                                <span class="text-emerald-200">+62 81 575 433 296</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span class="text-emerald-200">info@diabetcare.com</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Section -->
                <div class="border-t border-emerald-700 mt-12 pt-8">
                    <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                        <div class="text-emerald-200 text-sm">
                            © 2024 DiabetCare. Semua hak cipta dilindungi.
                        </div>
                        <div class="flex space-x-6 text-sm">
                            <a href="/privacy" class="text-emerald-200 hover:text-white transition-colors">Kebijakan
                                Privasi</a>
                            <a href="/terms" class="text-emerald-200 hover:text-white transition-colors">Syarat &
                                Ketentuan</a>
                            <a href="/support" class="text-emerald-200 hover:text-white transition-colors">Dukungan</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { Head, Link, useForm, router } from '@inertiajs/vue3'

// Props dari Laravel
const props = defineProps({
    user: Object,
    departments: Array,
    stats: Object,
    flash: Object,
})

// Reactive data
const loading = ref(false)
const showMobileMenu = ref(false)
const showProfileDropdown = ref(false)
const email = ref('')
const subscribing = ref(false)

// Form logout
const logoutForm = useForm({})

// Methods
const toggleMobileMenu = () => {
    showMobileMenu.value = !showMobileMenu.value
}

const toggleProfileDropdown = () => {
    showProfileDropdown.value = !showProfileDropdown.value
}

const logout = () => {
    logoutForm.post(route('logout'))
}

const subscribe = async () => {
    subscribing.value = true

    try {
        await router.post('/newsletter/subscribe', {
            email: email.value,
        }, {
            preserveScroll: true,
            onSuccess: () => {
                email.value = ''
                // success message bisa ditampilkan di sini
            },
            onError: (errors) => {
                console.error('Subscription error:', errors)
            },
        })
    } catch (error) {
        console.error('Subscription failed:', error)
    } finally {
        subscribing.value = false
    }
}

const navigateTo = (targetRoute) => {
    router.visit(targetRoute)
}

onMounted(() => {
    console.log('ProHealth landing page loaded')
    if (props.user) {
        console.log('Logged in user:', props.user.name)
    }
})
</script>


<style scoped>
/* Custom styles if needed */
.hero-pattern {
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.05'%3E%3Ccircle cx='30' cy='30' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

/* Smooth animations */
.transition-all {
    transition: all 0.3s ease;
}
</style>
