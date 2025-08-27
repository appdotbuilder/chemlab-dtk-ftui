import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';
import React from 'react';

interface Props {
    stats?: {
        totalLabs: number;
        totalEquipment: number;
        activeLoans: number;
        totalUsers: number;
    };
    [key: string]: unknown;
}

export default function Welcome({ stats }: Props) {
    const { auth } = usePage<SharedData>().props;

    return (
        <>
            <Head title="ChemLab Deptekim DTK FTUI">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
            </Head>
            <div className="min-h-screen bg-gradient-to-br from-blue-50 via-white to-green-50 text-gray-900">
                {/* Navigation */}
                <header className="relative z-50 bg-white/80 backdrop-blur-md border-b border-gray-200">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="flex justify-between items-center py-4">
                            <div className="flex items-center space-x-3">
                                <div className="w-10 h-10 bg-gradient-to-br from-blue-600 to-green-600 rounded-lg flex items-center justify-center">
                                    <span className="text-white text-lg font-bold">🧪</span>
                                </div>
                                <div>
                                    <h1 className="font-bold text-xl text-gray-900">ChemLab</h1>
                                    <p className="text-xs text-gray-600">DTK FTUI</p>
                                </div>
                            </div>
                            
                            <nav className="flex items-center space-x-4">
                                {auth.user ? (
                                    <Link
                                        href={route('dashboard')}
                                        className="inline-flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200"
                                    >
                                        📊 Dashboard
                                    </Link>
                                ) : (
                                    <div className="flex items-center space-x-3">
                                        <Link
                                            href={route('login')}
                                            className="inline-flex items-center px-4 py-2 text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200"
                                        >
                                            🔐 Masuk
                                        </Link>
                                        <Link
                                            href={route('register')}
                                            className="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-blue-600 to-green-600 hover:from-blue-700 hover:to-green-700 text-white font-medium rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl"
                                        >
                                            📝 Daftar Mahasiswa
                                        </Link>
                                    </div>
                                )}
                            </nav>
                        </div>
                    </div>
                </header>

                {/* Hero Section */}
                <section className="relative py-20 lg:py-32">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="text-center">
                            <h1 className="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">
                                🧪 <span className="bg-gradient-to-r from-blue-600 to-green-600 bg-clip-text text-transparent">
                                    ChemLab Deptekim
                                </span>
                            </h1>
                            <p className="text-xl lg:text-2xl text-gray-600 mb-4">
                                Departemen Teknik Kimia FTUI
                            </p>
                            <p className="text-lg text-gray-600 max-w-3xl mx-auto mb-12">
                                Sistem manajemen laboratorium modern untuk mengelola peminjaman dan pengembalian alat laboratorium 
                                dengan dukungan untuk berbagai peran pengguna, pelaporan, dan audit.
                            </p>

                            {/* CTA Buttons */}
                            <div className="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                                {!auth.user && (
                                    <>
                                        <Link
                                            href={route('register')}
                                            className="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-green-600 hover:from-blue-700 hover:to-green-700 text-white font-bold rounded-xl transition-all duration-200 shadow-lg hover:shadow-2xl transform hover:-translate-y-1"
                                        >
                                            🎓 Daftar sebagai Mahasiswa
                                        </Link>
                                        <Link
                                            href={route('login')}
                                            className="inline-flex items-center px-8 py-4 bg-white hover:bg-gray-50 text-gray-900 font-semibold rounded-xl border-2 border-gray-200 hover:border-blue-300 transition-all duration-200 shadow-lg hover:shadow-xl"
                                        >
                                            🔐 Masuk Staf/Dosen
                                        </Link>
                                    </>
                                )}
                            </div>
                        </div>
                    </div>

                    {/* Decorative Elements */}
                    <div className="absolute top-20 left-10 text-6xl opacity-20 animate-bounce">⚗️</div>
                    <div className="absolute bottom-20 right-10 text-5xl opacity-20 animate-pulse">🔬</div>
                    <div className="absolute top-32 right-20 text-4xl opacity-20 animate-bounce" style={{animationDelay: '1s'}}>🧬</div>
                </section>

                {/* Stats Section */}
                {stats && (
                    <section className="py-16 bg-white/50 backdrop-blur-sm">
                        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <div className="grid grid-cols-2 lg:grid-cols-4 gap-8">
                                <div className="text-center">
                                    <div className="text-4xl mb-2">🏢</div>
                                    <div className="text-3xl font-bold text-blue-600">{stats.totalLabs}</div>
                                    <div className="text-gray-600">Laboratorium</div>
                                </div>
                                <div className="text-center">
                                    <div className="text-4xl mb-2">🔧</div>
                                    <div className="text-3xl font-bold text-green-600">{stats.totalEquipment}</div>
                                    <div className="text-gray-600">Alat Tersedia</div>
                                </div>
                                <div className="text-center">
                                    <div className="text-4xl mb-2">📋</div>
                                    <div className="text-3xl font-bold text-orange-600">{stats.activeLoans}</div>
                                    <div className="text-gray-600">Peminjaman Aktif</div>
                                </div>
                                <div className="text-center">
                                    <div className="text-4xl mb-2">👥</div>
                                    <div className="text-3xl font-bold text-purple-600">{stats.totalUsers}</div>
                                    <div className="text-gray-600">Pengguna Terdaftar</div>
                                </div>
                            </div>
                        </div>
                    </section>
                )}

                {/* Features Section */}
                <section className="py-20">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="text-center mb-16">
                            <h2 className="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                                ✨ Fitur Utama Sistem
                            </h2>
                            <p className="text-lg text-gray-600 max-w-2xl mx-auto">
                                Sistem lengkap untuk mengelola aktivitas laboratorium dengan efisien dan aman
                            </p>
                        </div>

                        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                            {/* Feature Cards */}
                            <div className="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-200 border border-gray-100">
                                <div className="text-4xl mb-4">📝</div>
                                <h3 className="text-xl font-bold mb-3">Peminjaman Digital</h3>
                                <p className="text-gray-600">
                                    Ajukan peminjaman alat secara online dengan upload JSA, pilih waktu, dan tracking real-time
                                </p>
                            </div>

                            <div className="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-200 border border-gray-100">
                                <div className="text-4xl mb-4">✅</div>
                                <h3 className="text-xl font-bold mb-3">Persetujuan Cepat</h3>
                                <p className="text-gray-600">
                                    Sistem persetujuan berlapis dengan notifikasi otomatis untuk laboran dan supervisor
                                </p>
                            </div>

                            <div className="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-200 border border-gray-100">
                                <div className="text-4xl mb-4">📸</div>
                                <h3 className="text-xl font-bold mb-3">Dokumentasi Lengkap</h3>
                                <p className="text-gray-600">
                                    Foto kondisi alat saat check-out dan check-in, plus QR code untuk bukti peminjaman
                                </p>
                            </div>

                            <div className="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-200 border border-gray-100">
                                <div className="text-4xl mb-4">👥</div>
                                <h3 className="text-xl font-bold mb-3">Multi-Role Access</h3>
                                <p className="text-gray-600">
                                    Akses berbeda untuk Admin, Kepala Lab, Laboran, Dosen, dan Mahasiswa
                                </p>
                            </div>

                            <div className="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-200 border border-gray-100">
                                <div className="text-4xl mb-4">📊</div>
                                <h3 className="text-xl font-bold mb-3">Laporan & Analytics</h3>
                                <p className="text-gray-600">
                                    Dashboard dengan KPI, laporan utilisasi alat, dan export ke Excel/PDF
                                </p>
                            </div>

                            <div className="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-200 border border-gray-100">
                                <div className="text-4xl mb-4">🔒</div>
                                <h3 className="text-xl font-bold mb-3">Keamanan & Audit</h3>
                                <p className="text-gray-600">
                                    Log aktivitas lengkap, verifikasi akun mahasiswa, dan sistem bantuan password
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                {/* Role-based Features */}
                <section className="py-20 bg-gradient-to-r from-blue-50 to-green-50">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="text-center mb-16">
                            <h2 className="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                                🎯 Akses Sesuai Peran
                            </h2>
                            <p className="text-lg text-gray-600 max-w-2xl mx-auto">
                                Setiap pengguna mendapat akses dan fitur yang sesuai dengan perannya
                            </p>
                        </div>

                        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div className="bg-white rounded-xl p-6 shadow-lg border-l-4 border-red-500">
                                <div className="flex items-center mb-3">
                                    <span className="text-2xl mr-3">👨‍💼</span>
                                    <h3 className="text-lg font-bold">Admin</h3>
                                </div>
                                <ul className="text-sm text-gray-600 space-y-1">
                                    <li>• Kelola semua lab dan pengguna</li>
                                    <li>• Verifikasi akun mahasiswa</li>
                                    <li>• Akses semua laporan</li>
                                    <li>• Edit konten landing page</li>
                                </ul>
                            </div>

                            <div className="bg-white rounded-xl p-6 shadow-lg border-l-4 border-purple-500">
                                <div className="flex items-center mb-3">
                                    <span className="text-2xl mr-3">👨‍🔬</span>
                                    <h3 className="text-lg font-bold">Kepala Lab</h3>
                                </div>
                                <ul className="text-sm text-gray-600 space-y-1">
                                    <li>• Dashboard khusus lab</li>
                                    <li>• Laporan utilisasi lab</li>
                                    <li>• Monitor aktivitas lab</li>
                                    <li>• Supervisi operasional</li>
                                </ul>
                            </div>

                            <div className="bg-white rounded-xl p-6 shadow-lg border-l-4 border-blue-500">
                                <div className="flex items-center mb-3">
                                    <span className="text-2xl mr-3">🔧</span>
                                    <h3 className="text-lg font-bold">Laboran</h3>
                                </div>
                                <ul className="text-sm text-gray-600 space-y-1">
                                    <li>• Kelola alat laboratorium</li>
                                    <li>• Proses check-out/check-in</li>
                                    <li>• Review permintaan peminjaman</li>
                                    <li>• Bantuan reset password</li>
                                </ul>
                            </div>

                            <div className="bg-white rounded-xl p-6 shadow-lg border-l-4 border-green-500">
                                <div className="flex items-center mb-3">
                                    <span className="text-2xl mr-3">👨‍🏫</span>
                                    <h3 className="text-lg font-bold">Dosen</h3>
                                </div>
                                <ul className="text-sm text-gray-600 space-y-1">
                                    <li>• Ajukan peminjaman alat</li>
                                    <li>• Monitor mahasiswa bimbingan</li>
                                    <li>• Riwayat peminjaman pribadi</li>
                                    <li>• Dashboard aktivitas</li>
                                </ul>
                            </div>

                            <div className="bg-white rounded-xl p-6 shadow-lg border-l-4 border-yellow-500">
                                <div className="flex items-center mb-3">
                                    <span className="text-2xl mr-3">🎓</span>
                                    <h3 className="text-lg font-bold">Mahasiswa</h3>
                                </div>
                                <ul className="text-sm text-gray-600 space-y-1">
                                    <li>• Katalog alat laboratorium</li>
                                    <li>• Ajukan peminjaman online</li>
                                    <li>• Upload dokumen JSA</li>
                                    <li>• Tracking status peminjaman</li>
                                </ul>
                            </div>

                            <div className="bg-white rounded-xl p-6 shadow-lg border-l-4 border-gray-400">
                                <div className="flex items-center mb-3">
                                    <span className="text-2xl mr-3">❓</span>
                                    <h3 className="text-lg font-bold">Bantuan</h3>
                                </div>
                                <ul className="text-sm text-gray-600 space-y-1">
                                    <li>• Tiket bantuan password</li>
                                    <li>• Panduan penggunaan</li>
                                    <li>• FAQ sistem</li>
                                    <li>• Kontak support</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>

                {/* Contact & Footer */}
                <footer className="py-16 bg-gray-900 text-white">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                            <div>
                                <div className="flex items-center space-x-3 mb-4">
                                    <div className="w-10 h-10 bg-gradient-to-br from-blue-600 to-green-600 rounded-lg flex items-center justify-center">
                                        <span className="text-white text-lg font-bold">🧪</span>
                                    </div>
                                    <div>
                                        <h3 className="font-bold text-lg">ChemLab DTK</h3>
                                        <p className="text-sm text-gray-400">FTUI</p>
                                    </div>
                                </div>
                                <p className="text-gray-400 text-sm">
                                    Sistem manajemen laboratorium modern untuk Departemen Teknik Kimia FTUI
                                </p>
                            </div>

                            <div>
                                <h4 className="font-semibold mb-4">📧 Kontak</h4>
                                <div className="space-y-2 text-sm text-gray-400">
                                    <p>📧 chemlab@che.ui.ac.id</p>
                                    <p>📞 (021) 7270032</p>
                                    <p>📍 Kampus UI Depok</p>
                                    <p>🕒 Senin-Jumat 08:00-17:00</p>
                                </div>
                            </div>

                            <div>
                                <h4 className="font-semibold mb-4">🔗 Link Cepat</h4>
                                <div className="space-y-2 text-sm">
                                    <div><Link href="#" className="text-gray-400 hover:text-white">Panduan Mahasiswa</Link></div>
                                    <div><Link href="#" className="text-gray-400 hover:text-white">Panduan Dosen</Link></div>
                                    <div><Link href="#" className="text-gray-400 hover:text-white">SOP Laboratorium</Link></div>
                                    <div><Link href="#" className="text-gray-400 hover:text-white">FAQ</Link></div>
                                </div>
                            </div>

                            <div>
                                <h4 className="font-semibold mb-4">ℹ️ Informasi</h4>
                                <div className="space-y-2 text-sm text-gray-400">
                                    <p>Sistem terintegrasi untuk</p>
                                    <p>manajemen laboratorium</p>
                                    <p>yang aman dan efisien</p>
                                    <p className="mt-4 text-xs">© 2024 DTK FTUI</p>
                                </div>
                            </div>
                        </div>

                        <div className="border-t border-gray-800 mt-12 pt-8 text-center">
                            <p className="text-gray-400 text-sm">
                                🚀 Dibangun dengan teknologi modern untuk kemudahan akses dan keamanan data
                            </p>
                        </div>
                    </div>
                </footer>
            </div>
        </>
    );
}