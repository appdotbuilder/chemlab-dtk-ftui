import { Head, Link } from '@inertiajs/react';
import AppLayout from '@/components/app-layout';

interface Props {
    user: {
        id: number;
        name: string;
        email: string;
        roles: string[];
        is_verified: boolean;
    };
    stats?: {
        totalLabs?: number;
        totalEquipment?: number;
        myLoans?: number;
        pendingRequests?: number;
        overdueLoans?: number;
        unverifiedStudents?: number;
    };
    recentActivity?: Array<{
        id: number;
        message: string;
        created_at: string;
    }>;
    [key: string]: unknown;
}

export default function Dashboard({ user, stats = {}, recentActivity = [] }: Props) {
    const getRoleDisplay = (roles: string[]) => {
        const roleMap: Record<string, string> = {
            'admin': '👨‍💼 Administrator',
            'kepala_lab': '👨‍🔬 Kepala Lab',
            'laboran': '🔧 Laboran',
            'dosen': '👨‍🏫 Dosen',
            'mahasiswa': '🎓 Mahasiswa'
        };
        return roles.map(role => roleMap[role] || role).join(', ');
    };

    const isAdmin = user.roles.includes('admin');
    const isLaboran = user.roles.includes('laboran');
    const isKepalaLab = user.roles.includes('kepala_lab');
    const isDosen = user.roles.includes('dosen');
    const isMahasiswa = user.roles.includes('mahasiswa');

    return (
        <AppLayout>
            <Head title="Dashboard - ChemLab DTK" />
            
            <div className="px-4 sm:px-0">
                {/* Welcome Section */}
                <div className="bg-white rounded-2xl shadow-lg p-8 mb-8 border border-gray-100">
                    <div className="flex items-center justify-between">
                        <div>
                            <h1 className="text-3xl font-bold text-gray-900 mb-2">
                                Selamat datang, {user.name}! 👋
                            </h1>
                            <p className="text-gray-600 mb-2">{getRoleDisplay(user.roles)}</p>
                            <p className="text-sm text-gray-500">{user.email}</p>
                            
                            {isMahasiswa && !user.is_verified && (
                                <div className="mt-4 p-3 bg-amber-50 rounded-lg border-l-4 border-amber-400">
                                    <div className="flex items-center">
                                        <span className="text-lg mr-2">⏳</span>
                                        <div>
                                            <p className="text-sm font-medium text-amber-800">Akun Menunggu Verifikasi</p>
                                            <p className="text-xs text-amber-700 mt-1">
                                                Akun Anda sedang menunggu verifikasi dari Admin/Laboran. Anda akan mendapat notifikasi email setelah diverifikasi.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            )}
                        </div>
                        
                        <div className="text-right">
                            <p className="text-sm text-gray-500">Terakhir login</p>
                            <p className="text-sm font-medium text-gray-900">Hari ini</p>
                        </div>
                    </div>
                </div>

                {/* Stats Cards */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    {isAdmin && (
                        <>
                            <div className="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                                <div className="flex items-center">
                                    <div className="p-3 bg-blue-100 rounded-lg">
                                        <span className="text-2xl">🏢</span>
                                    </div>
                                    <div className="ml-4">
                                        <h3 className="text-2xl font-bold text-gray-900">{stats.totalLabs || 0}</h3>
                                        <p className="text-gray-600">Total Lab</p>
                                    </div>
                                </div>
                            </div>

                            <div className="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                                <div className="flex items-center">
                                    <div className="p-3 bg-green-100 rounded-lg">
                                        <span className="text-2xl">🔧</span>
                                    </div>
                                    <div className="ml-4">
                                        <h3 className="text-2xl font-bold text-gray-900">{stats.totalEquipment || 0}</h3>
                                        <p className="text-gray-600">Total Alat</p>
                                    </div>
                                </div>
                            </div>

                            <div className="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                                <div className="flex items-center">
                                    <div className="p-3 bg-amber-100 rounded-lg">
                                        <span className="text-2xl">👥</span>
                                    </div>
                                    <div className="ml-4">
                                        <h3 className="text-2xl font-bold text-gray-900">{stats.unverifiedStudents || 0}</h3>
                                        <p className="text-gray-600">Mahasiswa Pending</p>
                                    </div>
                                </div>
                            </div>
                        </>
                    )}

                    {(isLaboran || isKepalaLab) && (
                        <>
                            <div className="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                                <div className="flex items-center">
                                    <div className="p-3 bg-purple-100 rounded-lg">
                                        <span className="text-2xl">📋</span>
                                    </div>
                                    <div className="ml-4">
                                        <h3 className="text-2xl font-bold text-gray-900">{stats.pendingRequests || 0}</h3>
                                        <p className="text-gray-600">Permintaan Pending</p>
                                    </div>
                                </div>
                            </div>

                            <div className="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                                <div className="flex items-center">
                                    <div className="p-3 bg-red-100 rounded-lg">
                                        <span className="text-2xl">⏰</span>
                                    </div>
                                    <div className="ml-4">
                                        <h3 className="text-2xl font-bold text-gray-900">{stats.overdueLoans || 0}</h3>
                                        <p className="text-gray-600">Peminjaman Terlambat</p>
                                    </div>
                                </div>
                            </div>
                        </>
                    )}

                    {(isDosen || isMahasiswa) && (
                        <div className="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                            <div className="flex items-center">
                                <div className="p-3 bg-blue-100 rounded-lg">
                                    <span className="text-2xl">📊</span>
                                </div>
                                <div className="ml-4">
                                    <h3 className="text-2xl font-bold text-gray-900">{stats.myLoans || 0}</h3>
                                    <p className="text-gray-600">Peminjaman Saya</p>
                                </div>
                            </div>
                        </div>
                    )}
                </div>

                {/* Quick Actions */}
                <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <div className="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                        <h3 className="text-xl font-bold text-gray-900 mb-4">⚡ Aksi Cepat</h3>
                        <div className="space-y-3">
                            {isAdmin && (
                                <>
                                    <Link href="/admin/labs" className="block p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                                        <div className="flex items-center">
                                            <span className="text-lg mr-3">🏢</span>
                                            <span className="font-medium">Kelola Laboratorium</span>
                                        </div>
                                    </Link>
                                    <Link href="/admin/users" className="block p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                                        <div className="flex items-center">
                                            <span className="text-lg mr-3">👥</span>
                                            <span className="font-medium">Kelola Pengguna</span>
                                        </div>
                                    </Link>
                                    <Link href="/admin/verify-students" className="block p-3 bg-amber-50 rounded-lg hover:bg-amber-100 transition-colors">
                                        <div className="flex items-center">
                                            <span className="text-lg mr-3">✅</span>
                                            <span className="font-medium">Verifikasi Mahasiswa</span>
                                        </div>
                                    </Link>
                                </>
                            )}

                            {(isLaboran || isKepalaLab) && (
                                <>
                                    <Link href="/laboran/equipment" className="block p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                                        <div className="flex items-center">
                                            <span className="text-lg mr-3">🔧</span>
                                            <span className="font-medium">Kelola Alat</span>
                                        </div>
                                    </Link>
                                    <Link href="/laboran/loans" className="block p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                                        <div className="flex items-center">
                                            <span className="text-lg mr-3">📋</span>
                                            <span className="font-medium">Review Peminjaman</span>
                                        </div>
                                    </Link>
                                </>
                            )}

                            {(isDosen || (isMahasiswa && user.is_verified)) && (
                                <>
                                    <Link href="/loans/create" className="block p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                                        <div className="flex items-center">
                                            <span className="text-lg mr-3">➕</span>
                                            <span className="font-medium">Ajukan Peminjaman</span>
                                        </div>
                                    </Link>
                                    <Link href="/equipment" className="block p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                                        <div className="flex items-center">
                                            <span className="text-lg mr-3">📱</span>
                                            <span className="font-medium">Katalog Alat</span>
                                        </div>
                                    </Link>
                                </>
                            )}
                        </div>
                    </div>

                    {/* Recent Activity */}
                    <div className="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                        <h3 className="text-xl font-bold text-gray-900 mb-4">📈 Aktivitas Terbaru</h3>
                        <div className="space-y-3">
                            {recentActivity.length > 0 ? (
                                recentActivity.slice(0, 5).map((activity, index) => (
                                    <div key={index} className="flex items-center p-2 bg-gray-50 rounded-lg">
                                        <span className="text-sm text-gray-600">{activity.message}</span>
                                    </div>
                                ))
                            ) : (
                                <div className="text-center py-8">
                                    <span className="text-4xl mb-2 block">📝</span>
                                    <p className="text-gray-500 text-sm">Belum ada aktivitas terbaru</p>
                                </div>
                            )}
                        </div>
                    </div>

                    {/* System Info */}
                    <div className="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                        <h3 className="text-xl font-bold text-gray-900 mb-4">ℹ️ Info Sistem</h3>
                        <div className="space-y-3 text-sm text-gray-600">
                            <div className="flex items-center justify-between">
                                <span>Status Sistem</span>
                                <span className="inline-flex items-center px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                    🟢 Online
                                </span>
                            </div>
                            <div className="flex items-center justify-between">
                                <span>Maintenance</span>
                                <span className="text-xs text-gray-500">Minggu, 02:00-04:00</span>
                            </div>
                            <div className="flex items-center justify-between">
                                <span>Versi Sistem</span>
                                <span className="text-xs text-gray-500">v1.0.0</span>
                            </div>
                        </div>

                        <div className="mt-4 pt-4 border-t border-gray-200">
                            <p className="text-xs text-gray-500 mb-2">Butuh bantuan?</p>
                            <Link href="/password-help" className="text-xs text-blue-600 hover:text-blue-800 hover:underline">
                                🔗 Ajukan Tiket Bantuan
                            </Link>
                        </div>
                    </div>
                </div>

                {/* Role-specific Features */}
                {isMahasiswa && !user.is_verified && (
                    <div className="bg-gradient-to-r from-blue-50 to-green-50 rounded-2xl p-8 border border-blue-200">
                        <div className="text-center">
                            <span className="text-6xl mb-4 block">⏳</span>
                            <h3 className="text-2xl font-bold text-gray-900 mb-2">Akun Menunggu Verifikasi</h3>
                            <p className="text-gray-600 mb-6">
                                Akun mahasiswa Anda sedang dalam proses verifikasi oleh Admin atau Laboran. 
                                Setelah diverifikasi, Anda dapat mengakses semua fitur sistem.
                            </p>
                            <div className="bg-white rounded-lg p-4 text-sm text-gray-600">
                                <p><strong>Yang dapat Anda lakukan saat ini:</strong></p>
                                <ul className="mt-2 space-y-1 text-left">
                                    <li>• Melihat katalog alat laboratorium</li>
                                    <li>• Membaca panduan penggunaan sistem</li>
                                    <li>• Mengatur profil akun</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                )}
            </div>
        </AppLayout>
    );
}