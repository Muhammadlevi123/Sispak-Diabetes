<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <div class="min-h-screen bg-gradient-to-br from-emerald-50 via-teal-100 to-green-100 flex items-center justify-center p-4 relative overflow-hidden">
        <Head title="Daftar - DiabetCare" />

        <!-- Animated Background Elements -->
        <div class="absolute inset-0">
            <!-- Medical Cross Patterns -->
            <div class="absolute top-20 left-20 w-8 h-8 text-emerald-200 opacity-30 animate-bounce">
                <svg fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 8h-2v3h-3v2h3v3h2v-3h3v-2h-3V8z"/>
                </svg>
            </div>
            <div class="absolute top-40 right-32 w-6 h-6 text-teal-200 opacity-40 animate-pulse">
                <svg fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
            </div>
            <div class="absolute bottom-32 left-32 w-10 h-10 text-green-200 opacity-20 animate-spin" style="animation-duration: 8s;">
                <svg fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
            </div>

            <!-- Floating Orbs -->
            <div class="absolute top-1/4 left-1/3 w-32 h-32 bg-gradient-to-r from-emerald-300 to-teal-400 rounded-full opacity-20 blur-xl animate-float"></div>
            <div class="absolute bottom-1/4 right-1/3 w-24 h-24 bg-gradient-to-r from-green-300 to-emerald-400 rounded-full opacity-25 blur-xl animate-float-delayed"></div>
        </div>

        <div class="w-full max-w-md relative">
            <!-- Enhanced Header Compact with Stethoscope Logo -->
            <div class="text-center mb-6">
                <div class="relative inline-block">
                    <!-- Pulse Ring -->
                    <div class="absolute inset-0 bg-emerald-500 rounded-2xl opacity-20 animate-ping"></div>
                    <div class="relative inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl mb-4 shadow-2xl transform hover:scale-105 transition-transform duration-300">
                        <!-- Medical Stethoscope Logo -->
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth="2">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    </div>
                </div>
                <h1 class="text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent mb-2">
                    Bergabung dengan <span class="bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">DiabetCare</span>
                </h1>
                <p class="text-gray-600 text-sm font-medium">
                    Sistem Pakar Diagnosa Diabetes Melitus
                </p>
                <div class="mt-4 flex items-center justify-center space-x-2">
                    <div class="h-1 w-8 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full"></div>
                    <div class="h-1 w-4 bg-gradient-to-r from-teal-500 to-green-500 rounded-full"></div>
                    <div class="h-1 w-2 bg-green-500 rounded-full"></div>
                </div>
                <p class="mt-3 text-xs text-emerald-600 font-semibold tracking-wider uppercase">Buat akun baru</p>
            </div>

            <!-- Enhanced Glassmorphic Form Card -->
            <div class="backdrop-blur-xl bg-white/30 rounded-3xl shadow-2xl border border-white/20 p-6 relative">
                <!-- Decorative Corner Elements -->
                <div class="absolute top-4 right-4 w-6 h-6 border-t-2 border-r-2 border-emerald-300 opacity-50"></div>
                <div class="absolute bottom-4 left-4 w-6 h-6 border-b-2 border-l-2 border-teal-300 opacity-50"></div>

                <form @submit.prevent="submit" class="space-y-4">
                    <!-- Enhanced Name Field -->
                    <div>
                        <InputLabel for="name" value="Nama Lengkap" class="text-gray-800 font-semibold text-sm mb-1" />
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none transition-colors duration-200 group-focus-within:text-emerald-500">
                                <svg class="h-4 w-4 text-gray-400 group-focus-within:text-emerald-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <TextInput
                                id="name"
                                type="text"
                                class="block w-full pl-10 pr-3 py-2.5 border border-gray-200/50 rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white/50 backdrop-blur-sm transition-all duration-300 hover:bg-white/70 focus:bg-white/80 text-gray-800 placeholder-gray-500 text-sm"
                                v-model="form.name"
                                required
                                autofocus
                                autocomplete="name"
                                placeholder="Masukkan nama lengkap"
                            />
                            <div class="absolute inset-x-0 bottom-0 h-0.5 bg-gradient-to-r from-emerald-500 to-teal-500 transform scale-x-0 group-focus-within:scale-x-100 transition-transform duration-300"></div>
                        </div>
                        <InputError class="mt-1 text-xs" :message="form.errors.name" />
                    </div>

                    <!-- Enhanced Email Field -->
                    <div>
                        <InputLabel for="email" value="Alamat Email" class="text-gray-800 font-semibold text-sm mb-1" />
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none transition-colors duration-200 group-focus-within:text-emerald-500">
                                <svg class="h-4 w-4 text-gray-400 group-focus-within:text-emerald-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                </svg>
                            </div>
                            <TextInput
                                id="email"
                                type="email"
                                class="block w-full pl-10 pr-3 py-2.5 border border-gray-200/50 rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white/50 backdrop-blur-sm transition-all duration-300 hover:bg-white/70 focus:bg-white/80 text-gray-800 placeholder-gray-500 text-sm"
                                v-model="form.email"
                                required
                                autocomplete="username"
                                placeholder="contoh@email.com"
                            />
                            <div class="absolute inset-x-0 bottom-0 h-0.5 bg-gradient-to-r from-emerald-500 to-teal-500 transform scale-x-0 group-focus-within:scale-x-100 transition-transform duration-300"></div>
                        </div>
                        <InputError class="mt-1 text-xs" :message="form.errors.email" />
                    </div>

                    <!-- Enhanced Password Fields - Dalam 1 baris untuk laptop -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <!-- Enhanced Password Field -->
                        <div>
                            <InputLabel for="password" value="Kata Sandi" class="text-gray-800 font-semibold text-sm mb-1" />
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none transition-colors duration-200 group-focus-within:text-emerald-500">
                                    <svg class="h-4 w-4 text-gray-400 group-focus-within:text-emerald-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <TextInput
                                    id="password"
                                    type="password"
                                    class="block w-full pl-10 pr-3 py-2.5 border border-gray-200/50 rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white/50 backdrop-blur-sm transition-all duration-300 hover:bg-white/70 focus:bg-white/80 text-gray-800 placeholder-gray-500 text-sm"
                                    v-model="form.password"
                                    required
                                    autocomplete="new-password"
                                    placeholder="Min. 8 karakter"
                                />
                                <div class="absolute inset-x-0 bottom-0 h-0.5 bg-gradient-to-r from-emerald-500 to-teal-500 transform scale-x-0 group-focus-within:scale-x-100 transition-transform duration-300"></div>
                            </div>
                            <InputError class="mt-1 text-xs" :message="form.errors.password" />
                        </div>

                        <!-- Enhanced Confirm Password Field -->
                        <div>
                            <InputLabel for="password_confirmation" value="Konfirmasi" class="text-gray-800 font-semibold text-sm mb-1" />
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none transition-colors duration-200 group-focus-within:text-emerald-500">
                                    <svg class="h-4 w-4 text-gray-400 group-focus-within:text-emerald-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <TextInput
                                    id="password_confirmation"
                                    type="password"
                                    class="block w-full pl-10 pr-3 py-2.5 border border-gray-200/50 rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white/50 backdrop-blur-sm transition-all duration-300 hover:bg-white/70 focus:bg-white/80 text-gray-800 placeholder-gray-500 text-sm"
                                    v-model="form.password_confirmation"
                                    required
                                    autocomplete="new-password"
                                    placeholder="Ulangi kata sandi"
                                />
                                <div class="absolute inset-x-0 bottom-0 h-0.5 bg-gradient-to-r from-emerald-500 to-teal-500 transform scale-x-0 group-focus-within:scale-x-100 transition-transform duration-300"></div>
                            </div>
                            <InputError class="mt-1 text-xs" :message="form.errors.password_confirmation" />
                        </div>
                    </div>

                    <!-- Enhanced Terms - Compact -->
                    <div class="bg-gradient-to-r from-emerald-50/80 to-teal-50/80 backdrop-blur-sm rounded-2xl p-3 border border-emerald-200/50">
                        <div class="flex items-center space-x-3">
                            <div class="w-6 h-6 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-full flex items-center justify-center flex-shrink-0 shadow-lg">
                                <svg class="h-3 w-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <p class="text-xs text-emerald-700 font-medium">
                                Dengan mendaftar, Anda menyetujui
                                <a href="#" class="underline hover:text-emerald-900 transition-colors duration-200">Syarat & Ketentuan</a>
                                serta <a href="#" class="underline hover:text-emerald-900 transition-colors duration-200">Kebijakan Privasi</a>
                            </p>
                        </div>
                    </div>

                    <!-- Enhanced Register Button -->
                    <button
                        type="submit"
                        class="group relative w-full flex justify-center py-3 px-6 border border-transparent rounded-2xl text-sm font-semibold text-white bg-gradient-to-r from-emerald-600 to-teal-700 hover:from-emerald-700 hover:to-teal-800 shadow-2xl hover:shadow-3xl transform transition-all duration-300 hover:scale-[1.02] focus:outline-none focus:ring-4 focus:ring-emerald-300/50 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none overflow-hidden"
                        :class="{ 'opacity-75 cursor-not-allowed': form.processing }"
                        :disabled="form.processing"
                    >
                        <!-- Button Background Effect -->
                        <span class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></span>

                        <span v-if="!form.processing" class="relative flex items-center justify-center space-x-2">
                            <span>Daftar Sekarang</span>
                            <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </span>
                        <span v-else class="relative flex items-center justify-center space-x-2">
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-sm">Mendaftar...</span>
                        </span>
                    </button>

                    <!-- Enhanced Login Link -->
                    <div class="text-center pt-4 border-t border-white/20">
                        <p class="text-gray-600 text-sm">
                            Sudah memiliki akun?
                            <Link
                                :href="'/'"
                                class="ml-1 font-semibold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent hover:from-emerald-700 hover:to-teal-700 transition-all duration-200 relative group"
                            >
                                Masuk ke DiabetCare
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-emerald-600 to-teal-600 group-hover:w-full transition-all duration-300"></span>
                            </Link>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Enhanced Features Info - Inline -->
            <div class="mt-4 flex justify-center space-x-6">
                <div class="flex items-center space-x-2 text-emerald-600">
                    <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-xs font-medium">Diagnosa Akurat</span>
                </div>
                <div class="flex items-center space-x-2 text-emerald-600">
                    <div class="w-2 h-2 bg-teal-400 rounded-full animate-pulse" style="animation-delay: 0.5s;"></div>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <span class="text-xs font-medium">Data Aman</span>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(5deg); }
}

@keyframes float-delayed {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-15px) rotate(-3deg); }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animate-float-delayed {
    animation: float-delayed 8s ease-in-out infinite;
    animation-delay: -2s;
}

/* Enhanced focus styles */
input:focus {
    box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
}

/* Glass effect */
.backdrop-blur-xl {
    backdrop-filter: blur(16px);
}

/* Custom scrollbar for better aesthetics */
::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 3px;
}

::-webkit-scrollbar-thumb {
    background: rgba(16, 185, 129, 0.3);
    border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
    background: rgba(16, 185, 129, 0.5);
}
</style>
