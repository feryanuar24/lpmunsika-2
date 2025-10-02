<footer class="bg-gray-100">
    <div class="kt-container-fixed py-10">
        <div class="grid grid-cols-4 gap-8">
            <!-- About Section -->
            <div class="col-span-2">
                <h3 class="text-xl font-semibold mb-4">LPM UNSIKA</h3>
                <p class="text-gray-500 mb-4">
                    LPM Unsika merupakan unit kegiatan mahasiswa
                    yang berperan sebagai wadah untuk
                    menyalurkan bakat dan hobi dalam bidang
                    jurnalistik.
                </p>
                <div class="flex space-x-2">
                    <a href="https://facebook.com/lpmunsika" class="kt-btn kt-btn-mono">
                        <i class="ki-filled ki-facebook text-lg"></i>
                    </a>
                    <a href="https://twitter.com/lpmunsika" class="kt-btn kt-btn-mono">
                        <i class="ki-filled ki-twitter text-lg"></i>
                    </a>
                    <a href="https://instagram.com/lpmunsika" class="kt-btn kt-btn-mono">
                        <i class="ki-filled ki-instagram text-lg"></i>
                    </a>
                    <a href="https://youtube.com/lpmunsika" class="kt-btn kt-btn-mono">
                        <i class="ki-filled ki-youtube text-lg"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="font-semibold mb-4">Tautan Cepat</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('landing') }}" class="text-gray-500 kt-link kt-link-mono">Beranda</a></li>
                    <li><a href="#" class="text-gray-500 kt-link kt-link-mono">Tentang Kami</a></li>
                    <li><a href="#" class="text-gray-500 kt-link kt-link-mono">Redaksi</a></li>
                    <li><a href="#" class="text-gray-500 kt-link kt-link-mono">Kontak</a></li>
                    <li><a href="#" class="text-gray-500 kt-link kt-link-mono">Kebijakan Privasi</a>
                    </li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h4 class="font-semibold mb-4">Kontak</h4>
                <div class="space-y-2">
                    <div class="flex items-center">
                        <i class="ki-filled ki-geolocation text-lg text-gray-500 mr-1"></i>
                        <a href="https://maps.app.goo.gl/knLR6F9KTrQLqgNH7" class="text-gray-500 kt-link kt-link-mono">Jl. HS. Ronggowaluyo, Karawang</a>
                    </div>
                    <div class="flex items-center">
                        <i class="ki-filled ki-sms text-lg text-gray-500 mr-1"></i>
                        <a href="mailto:lpmunsika@gmail.com" class="text-gray-500 kt-link kt-link-mono">
                            lpmunsika@gmail.com
                        </a>
                    </div>
                    <div class="flex items-center">
                        <i class="ki-filled ki-phone text-lg text-gray-500 mr-1"></i>
                        <a href="tel:+6282135315586" class="text-gray-500 kt-link kt-link-mono">
                            (0821) 3531-5586
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <div class="border-t border-gray-300 my-7.5"></div>

        <!-- Bottom Footer -->
        <div class="flex flex-row justify-between items-center">
            <div class="text-gray-500 text-sm">
                &copy; {{ date('Y') }} LPM UNSIKA. Semua hak cipta dilindungi undang-undang.
            </div>
            <div class="flex space-x-2">
                <a href="#" class="text-gray-500 kt-link kt-link-mono">Syarat & Ketentuan</a>
                <a href="#" class="text-gray-500 kt-link kt-link-mono">Disclaimer</a>
                <a href="#" class="text-gray-500 kt-link kt-link-mono">Sitemap</a>
            </div>
        </div>
    </div>
</footer>
