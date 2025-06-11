<template>
    <div class="min-h-screen bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50">
        <!-- Header -->
        <nav class="bg-white/70 backdrop-blur-lg border-b border-emerald-100/50 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-3">
            <div class="flex items-center justify-between">
                <!-- Logo Section -->
                <div class="flex items-center space-x-8">
                    <Link href="/user/dashboard" class="flex items-center space-x-3 group">
                        <div class="relative w-12 h-12 bg-gradient-to-br from-emerald-500 via-teal-500 to-cyan-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300 group-hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-br from-emerald-400 to-teal-600 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <svg class="w-7 h-7 text-white relative z-10" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 1H5C3.9 1 3 1.9 3 3V21C3 22.1 3.9 23 5 23H19C20.1 23 21 22.1 21 21V9M19 9H15V5H19V9Z" />
                            </svg>
                            <div class="absolute -inset-1 bg-gradient-to-br from-emerald-400 to-teal-600 rounded-2xl blur opacity-30 group-hover:opacity-60 transition-opacity duration-300"></div>
                        </div>
                        <div class="relative">
                            <h1 class="text-2xl font-bold bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 bg-clip-text text-transparent">
                                DiabetCare
                            </h1>
                            <p class="text-xs text-emerald-600/70 font-medium tracking-wider">
                                SISTEM PAKAR DIABETES
                            </p>
                            <div class="absolute -bottom-1 left-0 w-full h-0.5 bg-gradient-to-r from-emerald-500 to-teal-500 scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
                        </div>
                    </Link>

                    <!-- Navigation Links -->
                    <nav class="hidden lg:flex space-x-1">
                        <Link href="/user/dashboard"
                            :class="['relative px-4 py-2 font-medium transition-all duration-300 rounded-lg group',
                                    isCurrentPage('/user/dashboard') ? 'text-emerald-600 bg-emerald-50' : 'text-gray-700 hover:text-emerald-600 hover:bg-emerald-50/50']">
                            <span class="relative z-10">Beranda</span>
                            <div class="absolute inset-0 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-lg opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                        </Link>
                        <Link href="/user/diagnosa"
                            :class="['relative px-4 py-2 font-medium transition-all duration-300 rounded-lg group',
                                    isCurrentPage('/user/diagnosa') ? 'text-emerald-600 bg-emerald-50' : 'text-gray-700 hover:text-emerald-600 hover:bg-emerald-50/50']">
                            <span class="relative z-10">Diagnosis</span>
                            <div class="absolute inset-0 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-lg opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                        </Link>
                    </nav>
                </div>

                <!-- Right Section -->
                <div class="flex items-center space-x-4">
                    <!-- Authenticated User Menu -->
                    <div v-if="$page.props.auth.user" class="relative" ref="profileDropdownRef">
                        <button @click.stop="toggleProfileDropdown"
                            class="relative w-11 h-11 bg-gradient-to-br from-emerald-500 via-teal-500 to-cyan-500 rounded-full flex items-center justify-center hover:shadow-lg transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 hover:scale-105 group">
                            <span class="text-white text-sm font-bold relative z-10">
                                {{ getUserInitial() }}
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-br from-emerald-400 to-teal-600 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <div class="absolute -inset-1 bg-gradient-to-br from-emerald-400 to-teal-600 rounded-full blur opacity-30 group-hover:opacity-60 transition-opacity duration-300"></div>
                        </button>

                        <!-- Enhanced Profile Dropdown -->
                        <Transition
                            enter-active-class="transition ease-out duration-200"
                            enter-from-class="transform opacity-0 scale-95"
                            enter-to-class="transform opacity-100 scale-100"
                            leave-active-class="transition ease-in duration-150"
                            leave-from-class="transform opacity-100 scale-100"
                            leave-to-class="transform opacity-0 scale-95">
                            <div v-show="showProfileDropdown"
                                @click.stop
                                class="absolute right-0 mt-3 w-64 bg-white/95 backdrop-blur-lg rounded-2xl shadow-2xl border border-emerald-100/50 py-2 z-50">
                                <!-- User Info Header -->
                                <div class="px-4 py-3 border-b border-emerald-100/50 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-t-2xl">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-full flex items-center justify-center">
                                            <span class="text-white text-sm font-bold">
                                                {{ getUserInitial() }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">{{ $page.props.auth.user.name }}</p>
                                            <p class="text-xs text-emerald-600">{{ $page.props.auth.user.email }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Menu Items -->
                                <div class="py-2">
                                    <Link href="/profile"
                                        @click="closeProfileDropdown"
                                        class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-emerald-50 hover:to-teal-50 hover:text-emerald-600 transition-all duration-200 group">
                                        <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-emerald-200 transition-colors duration-200">
                                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        <span class="font-medium">Profil Saya</span>
                                    </Link>

                                    <Link href="/riwayat"
                                        @click="closeProfileDropdown"
                                        class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-emerald-50 hover:to-teal-50 hover:text-emerald-600 transition-all duration-200 group">
                                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors duration-200">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <span class="font-medium">Riwayat Diagnosis</span>
                                    </Link>

                                    <Link href="/pengaturan"
                                        @click="closeProfileDropdown"
                                        class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-emerald-50 hover:to-teal-50 hover:text-emerald-600 transition-all duration-200 group">
                                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-purple-200 transition-colors duration-200">
                                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </div>
                                        <span class="font-medium">Pengaturan</span>
                                    </Link>

                                    <div class="border-t border-emerald-100/50 mt-2 pt-2">
                                        <button @click="logout"
                                            class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-all duration-200 group">
                                            <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-red-200 transition-colors duration-200">
                                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                                </svg>
                                            </div>
                                            <span class="font-medium">Keluar</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </Transition>
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
                            <div class="absolute inset-0 bg-gradient-to-r from-emerald-500 to-teal-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </Link>
                    </template>

                    <!-- Mobile Menu Button -->
                    <button @click="toggleMobileMenu"
                        class="lg:hidden p-2 text-gray-700 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Enhanced Mobile Menu -->
            <Transition
                enter-active-class="transition ease-out duration-300"
                enter-from-class="transform opacity-0 scale-95 -translate-y-2"
                enter-to-class="transform opacity-100 scale-100 translate-y-0"
                leave-active-class="transition ease-in duration-200"
                leave-from-class="transform opacity-100 scale-100 translate-y-0"
                leave-to-class="transform opacity-0 scale-95 -translate-y-2">
                <div v-show="showMobileMenu"
                    @click.stop
                    class="lg:hidden mt-4 p-4 bg-white/95 backdrop-blur-lg rounded-2xl shadow-2xl border border-emerald-100/50">
                    <div class="flex flex-col space-y-2">
                        <Link href="/user/dashboard"
                            @click="closeMobileMenu"
                            class="text-gray-700 hover:text-emerald-600 hover:bg-emerald-50 font-medium py-3 px-4 rounded-xl transition-all duration-200">
                            Beranda
                        </Link>
                        <Link href="/user/diagnosa"
                            @click="closeMobileMenu"
                            class="text-gray-700 hover:text-emerald-600 hover:bg-emerald-50 font-medium py-3 px-4 rounded-xl transition-all duration-200">
                            Diagnosis
                        </Link>

                        <!-- Mobile User Menu -->
                        <div v-if="$page.props.auth.user" class="border-t border-emerald-100/50 pt-4 mt-4">
                            <div class="flex items-center space-x-3 mb-4 p-3 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl">
                                <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-bold">
                                        {{ getUserInitial() }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">{{ $page.props.auth.user.name }}</p>
                                    <p class="text-xs text-emerald-600">{{ $page.props.auth.user.email }}</p>
                                </div>
                            </div>

                            <Link href="/profile"
                                @click="closeMobileMenu"
                                class="block text-gray-700 hover:text-emerald-600 hover:bg-emerald-50 font-medium py-3 px-4 rounded-xl transition-all duration-200">
                                Profil Saya
                            </Link>
                            <Link href="/riwayat"
                                @click="closeMobileMenu"
                                class="block text-gray-700 hover:text-emerald-600 hover:bg-emerald-50 font-medium py-3 px-4 rounded-xl transition-all duration-200">
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
                                @click="closeMobileMenu"
                                class="block text-gray-700 hover:text-emerald-600 hover:bg-emerald-50 font-medium py-3 px-4 rounded-xl transition-all duration-200">
                                Masuk
                            </Link>
                            <Link href="/register"
                                @click="closeMobileMenu"
                                class="block bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white px-4 py-3 rounded-xl font-semibold transition-all duration-300 text-center shadow-lg">
                                Daftar
                            </Link>
                        </div>
                    </div>
                </div>
            </Transition>
        </div>
    </nav>

        <div class="max-w-4xl mx-auto px-4 py-8">
            <!-- Progress Bar -->
            <div v-if="!isComplete" class="mb-8">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm text-gray-600">Progress Diagnosis</span>
                    <span class="text-sm text-emerald-600">{{ Math.round(progress) }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-gradient-to-r from-emerald-400 to-teal-500 h-2 rounded-full transition-all duration-500"
                        :style="{ width: progress + '%' }"></div>
                </div>
            </div>

            <!-- Error Message -->
            <div v-if="errorMessage" class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-center">
                    <AlertCircleIcon class="w-5 h-5 text-red-500 mr-2" />
                    <p class="text-red-700">{{ errorMessage }}</p>
                </div>
            </div>

            <!-- Question Card -->
            <!-- Initial Confirmation Div -->
            <div v-if="!hasStarted" class="bg-white rounded-2xl shadow-xl p-8 mb-6">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <AlertCircleIcon class="w-8 h-8 text-blue-600" />
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">
                        Mulai Diagnosis Diabetes?
                    </h2>
                    <p class="text-gray-600">
                        Apakah Anda siap untuk memulai serangkaian pertanyaan ini?
                    </p>
                </div>

                <!-- Answer Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <!-- Menjadi ini: -->
                    <button @click="startAssessment()" :disabled="isLoading"
                        class="flex-1 max-w-xs mx-auto bg-emerald-500 hover:bg-emerald-600 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-200 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">
                        <CheckIcon class="w-5 h-5 inline mr-2" />
                        Ya, Mulai
                    </button>
                    <button @click="goToDashboard()" :disabled="isLoading"
                        class="flex-1 max-w-xs mx-auto bg-gray-500 hover:bg-gray-600 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-200 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">
                        <XIcon class="w-5 h-5 inline mr-2" />
                        Tidak, Kembali
                    </button>
                </div>
            </div>

            <!-- Existing Question Div (modified condition) -->
            <div v-if="hasStarted && !isComplete && currentQuestion" class="bg-white rounded-2xl shadow-xl p-8 mb-6">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <AlertCircleIcon class="w-8 h-8 text-emerald-600" />
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">
                        {{ currentQuestion.question }}
                    </h2>
                    <p class="text-gray-600">
                        {{ currentQuestion.description }}
                    </p>
                </div>

                <!-- Answer Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button @click="answerQuestion('yes')" :disabled="isLoading"
                        class="flex-1 max-w-xs mx-auto bg-emerald-500 hover:bg-emerald-600 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-200 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">
                        <CheckIcon class="w-5 h-5 inline mr-2" />
                        Ya
                    </button>
                    <button @click="answerQuestion('no')" :disabled="isLoading"
                        class="flex-1 max-w-xs mx-auto bg-gray-500 hover:bg-gray-600 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-200 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">
                        <XIcon class="w-5 h-5 inline mr-2" />
                        Tidak
                    </button>
                </div>
            </div>

            <!-- Result Card -->
            <div v-if="isComplete && result" class="bg-white rounded-2xl shadow-xl p-8">
                <div class="text-center mb-8">
                    <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4"
                        :class="getResultColorClass(result.color)">
                        <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            strokeWidth="2">
                            <path strokeLinecap="round" strokeLinejoin="round"
                                d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">
                        Hasil Diagnosis
                    </h2>
                    <div class="inline-block px-4 py-2 rounded-full text-sm font-semibold mb-4"
                        :class="getResultBadgeClass(result.color)">
                        {{ result.type }} - {{ result.risk_level }}
                    </div>
                    <p class="text-gray-700 text-lg mb-4">
                        {{ result.description }}
                    </p>
                    <div class="text-sm text-gray-500">
                        Tingkat Kepercayaan: {{ result.confidence }}%
                    </div>
                </div>

                <!-- Recommendations -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Rekomendasi</h3>
                    <div class="grid gap-3">
                        <div v-for="(recommendation, index) in result.recommendations" :key="index"
                            class="flex items-start space-x-3 p-4 bg-gray-50 rounded-lg">
                            <div
                                class="w-6 h-6 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <span class="text-xs font-bold text-emerald-600">{{ index + 1 }}</span>
                            </div>
                            <p class="text-gray-700">{{ recommendation }}</p>
                        </div>
                    </div>
                </div>

                <!-- Summary -->
                <div class="bg-blue-50 rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-bold text-blue-900 mb-2">Ringkasan Jawaban</h3>
                    <p class="text-blue-700 mb-3">Total pertanyaan dijawab: {{ answers.length }}</p>
                    <div class="space-y-2">
                        <div v-for="(answer, index) in answers" :key="index" class="text-sm text-blue-600">
                            <strong>{{ answer.kode_gejala }}:</strong> {{ answer.question }} -
                            <span class="font-semibold">{{ answer.answer === 'yes' ? 'Ya' : 'Tidak' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button @click="resetDiagnosis"
                        class="bg-emerald-500 hover:bg-emerald-600 text-white px-8 py-3 rounded-xl font-semibold transition-colors duration-200">
                        Diagnosis Ulang
                    </button>
                    <button @click="printResult"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-8 py-3 rounded-xl font-semibold transition-colors duration-200">
                        Cetak Hasil
                    </button>
                    <a v-if="authUser" href="/user/diagnosa/history"
                        class="bg-purple-500 hover:bg-purple-600 text-white px-8 py-3 rounded-xl font-semibold transition-colors duration-200 text-center inline-block">
                        Riwayat Diagnosis
                    </a>
                </div>
            </div>

            <!-- Answer History -->
            <div v-if="answers.length > 0 && !isComplete" class="mt-8">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Riwayat Jawaban</h3>
                    <div class="space-y-2 max-h-64 overflow-y-auto">
                        <div v-for="(answer, index) in answers" :key="index"
                            class="flex items-center justify-between p-3 bg-gray-50 rounded-lg text-sm">
                            <div class="flex-1">
                                <span class="text-xs text-gray-500 block">{{ answer.kode_gejala }}</span>
                                <span class="text-gray-700">{{ answer.question }}</span>
                            </div>
                            <span class="px-2 py-1 rounded text-xs font-semibold ml-2"
                                :class="answer.answer === 'yes' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'">
                                {{ answer.answer === 'yes' ? 'Ya' : 'Tidak' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loading Overlay -->
        <div v-if="isLoading" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 text-center">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-emerald-500 mx-auto mb-4"></div>
                <p class="text-gray-700">Memproses diagnosis...</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, nextTick } from 'vue'
import { usePage, router } from '@inertiajs/vue3'
import {
    Activity as ActivityIcon,
    AlertCircle as AlertCircleIcon,
    Check as CheckIcon,
    X as XIcon,
    Heart as HeartIcon
} from 'lucide-vue-next'

// Props
const props = defineProps({
    diagnosisTree: {
        type: Object,
        required: true
    },
    gejalas: {
        type: Array,
        default: () => []
    },
    penyakits: {
        type: Array,
        default: () => []
    },
    firstNode: {
        type: String,
        default: null
    }
})

const page = usePage()

// Navigation state
const showProfileDropdown = ref(false)
const showMobileMenu = ref(false)

// Diagnosis state
const currentNode = ref(null)
const answers = ref([])
const isComplete = ref(false)
const result = ref(null)
const isLoading = ref(false)
const progress = ref(0)
const errorMessage = ref('')
const hasStarted = ref(false)

// Computed properties
const authUser = computed(() => page.props.auth?.user || null)

const currentQuestion = computed(() => {
    if (!currentNode.value || !props.diagnosisTree[currentNode.value]) {
        return null
    }
    return props.diagnosisTree[currentNode.value]
})

// Navigation methods
const isCurrentPage = (path) => {
    return window.location.pathname === path
}

const getUserInitial = () => {
    if (!authUser.value) return 'U'
    return authUser.value.name.charAt(0).toUpperCase()
}

const toggleProfileDropdown = () => {
    showProfileDropdown.value = !showProfileDropdown.value
}

const closeProfileDropdown = () => {
    showProfileDropdown.value = false
}

const toggleMobileMenu = () => {
    showMobileMenu.value = !showMobileMenu.value
}

const closeMobileMenu = () => {
    showMobileMenu.value = false
}

const logout = async () => {
    try {
        await router.post('/logout')
    } catch (error) {
        console.error('Logout error:', error)
    }
}

function goToDashboard() {
    router.visit('/user/dashboard')
}

// Diagnosis methods
const startAssessment = () => {
    hasStarted.value = true
    // Mulai dengan gejala pertama dari props
    currentNode.value = props.firstNode || (props.gejalas.length > 0 ? props.gejalas[0].kode_gejala : null)
    answers.value = []
    isComplete.value = false
    result.value = null
    progress.value = 0
    errorMessage.value = ''

    // Jika tidak ada gejala yang tersedia
    if (!currentNode.value) {
        errorMessage.value = 'Tidak ada pertanyaan diagnosis yang tersedia.'
    }
}

const answerQuestion = async (answer) => {
    if (!currentNode.value) {
        errorMessage.value = 'Node pertanyaan tidak valid.'
        return
    }

    errorMessage.value = ''
    isLoading.value = true

    try {
        const response = await fetch('/user/diagnosa/process', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify({
                currentNode: currentNode.value,
                answer: answer,
                answers: answers.value
            })
        })

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`)
        }

        const data = await response.json()

        if (data.success === false) {
            throw new Error(data.message || 'Server returned an error')
        }

        // Update answers dari response
        answers.value = data.answers || answers.value

        if (data.isComplete) {
            // Diagnosis selesai
            result.value = data.result
            isComplete.value = true
            progress.value = 100
        } else {
            // Lanjut ke pertanyaan berikutnya
            currentNode.value = data.nextNode
            progress.value = data.progress || 0

            // Jika tidak ada pertanyaan selanjutnya
            if (!data.nextNode) {
                errorMessage.value = 'Tidak ada pertanyaan selanjutnya yang tersedia.'
            }
        }

    } catch (error) {
        errorMessage.value = 'Terjadi kesalahan saat memproses jawaban. Silakan coba lagi.'
        console.error('Error processing answer:', error)
    } finally {
        isLoading.value = false
    }
}

const resetDiagnosis = () => {
    hasStarted.value = false
    currentNode.value = null
    answers.value = []
    isComplete.value = false
    result.value = null
    progress.value = 0
    errorMessage.value = ''
}

const printResult = () => {
    window.print()
}

const getResultColorClass = (color) => {
    const colorMap = {
        'red': 'bg-red-500',
        'orange': 'bg-orange-500',
        'yellow': 'bg-yellow-500',
        'green': 'bg-green-500'
    }
    return colorMap[color] || 'bg-gray-500'
}

const getResultBadgeClass = (color) => {
    const colorMap = {
        'red': 'bg-red-100 text-red-800',
        'orange': 'bg-orange-100 text-orange-800',
        'yellow': 'bg-yellow-100 text-yellow-800',
        'green': 'bg-green-100 text-green-800'
    }
    return colorMap[color] || 'bg-gray-100 text-gray-800'
}

// Click outside directive simulation
const handleClickOutside = (event) => {
    // Close dropdowns if clicking outside
    if (!event.target.closest('.profile-dropdown') && !event.target.closest('.profile-button')) {
        showProfileDropdown.value = false
    }
    if (!event.target.closest('.mobile-menu') && !event.target.closest('.mobile-menu-button')) {
        showMobileMenu.value = false
    }
}

onMounted(() => {
    console.log('DiabetCare diagnosis page loaded')
    console.log('Props:', {
        diagnosisTree: props.diagnosisTree,
        gejalas: props.gejalas,
        firstNode: props.firstNode
    })

    // Add click outside listener
    document.addEventListener('click', handleClickOutside)

    // Cleanup function akan dijalankan saat component unmounted
    return () => {
        document.removeEventListener('click', handleClickOutside)
    }
})
</script>
