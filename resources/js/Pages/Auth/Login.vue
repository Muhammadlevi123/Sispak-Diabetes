<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div class="min-h-screen bg-gradient-to-br from-emerald-50 via-teal-100 to-green-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <Head title="Login - DiabetCare" />

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

        <div class="max-w-md w-full space-y-8 relative">
            <!-- Enhanced Logo and Header -->
            <div class="text-center">
                <div class="relative inline-block">
                    <!-- Pulse Ring -->
                    <div class="absolute inset-0 bg-emerald-500 rounded-2xl opacity-20 animate-ping"></div>
                    <div class="relative mx-auto h-20 w-20 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center shadow-2xl transform hover:scale-105 transition-transform duration-300">
                        <!-- Medical Stethoscope Logo -->
                        <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth="2">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    </div>
                </div>
                <h2 class="mt-6 text-4xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent">DiabetCare</h2>
                <!-- <p class="mt-2 text-sm text-gray-600 font-medium">Sistem Pakar Diagnosa Diabetes Melitus</p> -->
                <div class="mt-4 flex items-center justify-center space-x-2">
                    <div class="h-1 w-8 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full"></div>
                    <div class="h-1 w-4 bg-gradient-to-r from-teal-500 to-green-500 rounded-full"></div>
                    <div class="h-1 w-2 bg-green-500 rounded-full"></div>
                </div>
                <p class="mt-3 text-xs text-emerald-600 font-semibold tracking-wider uppercase">Masuk ke akun Anda</p>
            </div>

            <!-- Enhanced Glassmorphic Card -->
            <div class="backdrop-blur-xl bg-white/30 rounded-3xl shadow-2xl border border-white/20 p-8 relative">
                <!-- Decorative Corner Elements -->
                <div class="absolute top-4 right-4 w-6 h-6 border-t-2 border-r-2 border-emerald-300 opacity-50"></div>
                <div class="absolute bottom-4 left-4 w-6 h-6 border-b-2 border-l-2 border-teal-300 opacity-50"></div>

                <!-- Status Message -->
                <div v-if="status" class="mb-6 p-4 bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200 rounded-xl backdrop-blur-sm">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-emerald-500 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                        <p class="text-sm font-medium text-emerald-700">{{ status }}</p>
                    </div>
                </div>

                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Enhanced Email Input -->
                    <div class="relative">
                        <InputLabel for="email" value="Email" class="text-gray-800 font-semibold text-sm" />
                        <div class="relative mt-2 group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors duration-200 group-focus-within:text-emerald-500">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-emerald-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                </svg>
                            </div>
                            <TextInput
                                id="email"
                                type="email"
                                class="block w-full pl-12 pr-4 py-4 border border-gray-200/50 rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white/50 backdrop-blur-sm transition-all duration-300 hover:bg-white/70 focus:bg-white/80 text-gray-800 placeholder-gray-500"
                                v-model="form.email"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="contoh@email.com"
                            />
                            <div class="absolute inset-x-0 bottom-0 h-0.5 bg-gradient-to-r from-emerald-500 to-teal-500 transform scale-x-0 group-focus-within:scale-x-100 transition-transform duration-300"></div>
                        </div>
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <!-- Enhanced Password Input -->
                    <div class="relative">
                        <InputLabel for="password" value="Password" class="text-gray-800 font-semibold text-sm" />
                        <div class="relative mt-2 group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors duration-200 group-focus-within:text-emerald-500">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-emerald-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <TextInput
                                id="password"
                                type="password"
                                class="block w-full pl-12 pr-4 py-4 border border-gray-200/50 rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white/50 backdrop-blur-sm transition-all duration-300 hover:bg-white/70 focus:bg-white/80 text-gray-800 placeholder-gray-500"
                                v-model="form.password"
                                required
                                autocomplete="current-password"
                                placeholder="Masukkan password"
                            />
                            <div class="absolute inset-x-0 bottom-0 h-0.5 bg-gradient-to-r from-emerald-500 to-teal-500 transform scale-x-0 group-focus-within:scale-x-100 transition-transform duration-300"></div>
                        </div>
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <!-- Enhanced Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between pt-2">
                        <label class="flex items-center group cursor-pointer">
                            <Checkbox
                                name="remember"
                                v-model:checked="form.remember"
                                class="rounded-lg border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500 focus:ring-offset-0 transition-all duration-200"
                            />
                            <span class="ml-3 text-sm text-gray-700 group-hover:text-gray-900 transition-colors duration-200">Ingat saya</span>
                        </label>

                        <Link
                            v-if="canResetPassword"
                            :href="route('password.request')"
                            class="text-sm bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent hover:from-emerald-700 hover:to-teal-700 font-semibold transition-all duration-200 relative group"
                        >
                            Lupa password?
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-emerald-600 to-teal-600 group-hover:w-full transition-all duration-300"></span>
                        </Link>
                    </div>

                    <!-- Enhanced Login Button -->
                    <div class="pt-4">
                        <PrimaryButton
                            class="group relative w-full flex justify-center py-4 px-6 border border-transparent rounded-2xl text-sm font-semibold text-white bg-gradient-to-r from-emerald-600 to-teal-700 hover:from-emerald-700 hover:to-teal-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transform transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl overflow-hidden"
                            :class="{ 'opacity-75 cursor-not-allowed': form.processing }"
                            :disabled="form.processing"
                        >
                            <!-- Button Background Effect -->
                            <span class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></span>

                            <svg v-if="form.processing" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>

                            <span class="relative flex items-center">
                                {{ form.processing ? 'Memproses...' : 'Masuk ke DiabetCare' }}
                                <svg v-if="!form.processing" class="ml-2 w-4 h-4 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </span>
                        </PrimaryButton>
                    </div>
                </form>

                <!-- Enhanced Additional Info -->
                <div class="mt-8 pt-6 border-t border-white/20">
                    <div class="text-center">
                        <p class="text-sm text-gray-600">
                            Belum punya akun?
                            <Link :href="'/register'" class="ml-1 font-semibold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent hover:from-emerald-700 hover:to-teal-700 transition-all duration-200 relative group">
                                Daftar sekarang
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-emerald-600 to-teal-600 group-hover:w-full transition-all duration-300"></span>
                            </Link>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Enhanced Footer
            <div class="text-center space-y-2">
                <p class="text-xs text-gray-500 font-medium">
                    © 2024 DiabetCare. Semua hak dilindungi.
                </p>
                <div class="flex items-center justify-center space-x-2">
                    <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div>
                    <p class="text-xs text-gray-400">
                        Powered by Forward Chaining AI Technology
                    </p>
                    <div class="w-2 h-2 bg-teal-400 rounded-full animate-pulse" style="animation-delay: 0.5s;"></div>
                </div>
            </div> -->
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
