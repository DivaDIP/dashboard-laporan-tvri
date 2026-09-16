<x-guest-layout>
    <div class="min-h-screen w-full flex flex-col md:flex-row bg-white overflow-hidden">
        
        <!-- Left Side: Solid TVRI Blue & Wave/Cloud Curve -->
        <div class="relative w-full md:w-1/2 bg-[#003366] p-8 md:p-12 text-white flex flex-col justify-between min-h-[400px] md:min-h-screen z-10">
            
            <!-- Cloud/Wave SVG Divider Right Edge -->
            <div class="absolute -right-1 top-0 bottom-0 w-20 md:w-28 h-full pointer-events-none z-20 hidden md:block">
                <svg class="h-full w-full" viewBox="0 0 100 500" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 0 C50 60, 30 120, 65 180 C100 240, 20 300, 60 360 C90 420, 40 460, 100 500 L100 0 Z" fill="white"/>
                </svg>
            </div>

            <!-- Header Welcome -->
            <div class="relative z-30 text-center mt-4 md:mt-8">
                <h3 class="text-2xl md:text-3xl font-bold tracking-wide">Selamat Datang</h3>
            </div>

            <!-- Logo & Title Center -->
            <div class="relative z-30 flex flex-col items-center my-auto py-8">
                <div class="w-32 h-32 md:w-40 md:h-40 rounded-full bg-white p-4 shadow-md flex items-center justify-center">
                    <img src="{{ asset('logo-tvri.svg') }}" alt="Logo TVRI Bengkulu" class="w-full h-full object-contain">
                </div>
                <h2 class="text-2xl md:text-3xl font-extrabold mt-6 tracking-wide text-center">TVRI Stasiun Bengkulu</h2>
                <p class="text-sm text-blue-100/80 text-center mt-3 max-w-sm leading-relaxed font-light">
                    Sistem Informasi Laporan Kegiatan Staf Terpadu LPP TVRI Bengkulu.
                </p>
            </div>

            <!-- Footer Text -->
            <div class="relative z-30 flex justify-between items-center text-xs text-blue-200/70 uppercase tracking-widest pb-4 max-w-xs mx-auto w-full">
                <span>LPP TVRI</span>
                <span>|</span>
                <span>STASIUN BENGKULU</span>
            </div>
        </div>

        <!-- Right Side: Full Height Form Login -->
        <div class="w-full md:w-1/2 bg-white p-8 md:p-16 flex flex-col justify-center min-h-[500px] md:min-h-screen z-10">
            <div class="max-w-md w-full mx-auto">
                <div class="mb-10">
                    <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Masuk ke Akun Anda</h2>
                    <p class="text-sm text-gray-500 mt-2">Silakan masukkan kredensial akun Anda untuk mengakses sistem.</p>
                </div>

                <x-auth-session-status class="mb-6" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Input -->
                    <div class="relative border-b-2 border-gray-200 focus-within:border-[#003366] transition-colors py-2">
                        <label for="email" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">E-mail Address</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                            class="w-full border-none p-0 text-gray-900 focus:ring-0 text-base placeholder-gray-400 bg-transparent font-medium"
                            placeholder="contoh@admin.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs" />
                    </div>

                    <!-- Password Input -->
                    <div class="relative border-b-2 border-gray-200 focus-within:border-[#003366] transition-colors py-2">
                        <label for="password" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">Password</label>
                        <input id="password" type="password" name="password" required 
                            class="w-full border-none p-0 text-gray-900 focus:ring-0 text-base placeholder-gray-400 bg-transparent font-medium"
                            placeholder="••••••••">
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs" />
                    </div>

                    {{-- <!-- Remember & Forgot -->
                    <div class="flex items-center justify-between text-xs text-gray-500 pt-2">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-[#003366] shadow-sm focus:ring-[#003366]">
                            <span class="ms-2 font-medium text-gray-600">Ingatkan Saya</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a class="hover:underline font-semibold text-[#003366]" href="{{ route('password.request') }}">
                                Lupa Password?
                            </a>
                        @endif
                    </div> --}}

                    <!-- Submit Button -->
                    <div class="pt-6">
                        <button type="submit" 
                            class="w-full bg-[#003366] hover:bg-[#002244] text-white font-bold py-4 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 text-sm tracking-wider uppercase">
                            MASUK
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-guest-layout>