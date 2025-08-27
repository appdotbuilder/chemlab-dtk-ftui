import React from 'react';
import { Link } from '@inertiajs/react';

interface AuthLayoutProps {
    title: string;
    description: string;
    children: React.ReactNode;
}

export default function AuthLayout({ title, description, children }: AuthLayoutProps) {
    return (
        <div className="min-h-screen bg-gradient-to-br from-blue-50 via-white to-green-50">
            <div className="flex min-h-screen">
                {/* Left Side - Branding */}
                <div className="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-blue-600 to-green-600 text-white flex-col justify-center items-center p-12">
                    <div className="text-center">
                        <div className="mb-8">
                            <div className="w-24 h-24 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-6">
                                <span className="text-4xl">🧪</span>
                            </div>
                            <h1 className="text-4xl font-bold mb-4">ChemLab DTK</h1>
                            <p className="text-xl text-blue-100">Fakultas Teknik Universitas Indonesia</p>
                        </div>
                        
                        <div className="max-w-md">
                            <h2 className="text-2xl font-semibold mb-4">🔬 Sistem Manajemen Lab Modern</h2>
                            <div className="space-y-3 text-left">
                                <div className="flex items-center">
                                    <span className="text-lg mr-3">✅</span>
                                    <span>Peminjaman alat digital dengan JSA</span>
                                </div>
                                <div className="flex items-center">
                                    <span className="text-lg mr-3">📊</span>
                                    <span>Dashboard dan laporan real-time</span>
                                </div>
                                <div className="flex items-center">
                                    <span className="text-lg mr-3">🔒</span>
                                    <span>Keamanan dan audit lengkap</span>
                                </div>
                                <div className="flex items-center">
                                    <span className="text-lg mr-3">👥</span>
                                    <span>Multi-role access control</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Right Side - Form */}
                <div className="w-full lg:w-1/2 flex items-center justify-center p-8">
                    <div className="w-full max-w-md">
                        {/* Mobile Header */}
                        <div className="lg:hidden text-center mb-8">
                            <Link href="/" className="inline-block">
                                <div className="w-16 h-16 bg-gradient-to-br from-blue-600 to-green-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                                    <span className="text-2xl text-white">🧪</span>
                                </div>
                                <h1 className="text-2xl font-bold text-gray-900">ChemLab DTK</h1>
                                <p className="text-sm text-gray-600">FTUI</p>
                            </Link>
                        </div>

                        {/* Form Header */}
                        <div className="text-center mb-8">
                            <h2 className="text-2xl lg:text-3xl font-bold text-gray-900 mb-2">{title}</h2>
                            <p className="text-gray-600">{description}</p>
                        </div>

                        {/* Form Content */}
                        <div className="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
                            {children}
                        </div>

                        {/* Footer */}
                        <div className="text-center mt-8">
                            <Link 
                                href="/" 
                                className="text-sm text-gray-600 hover:text-blue-600 transition-colors duration-200"
                            >
                                ← Kembali ke Beranda
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}