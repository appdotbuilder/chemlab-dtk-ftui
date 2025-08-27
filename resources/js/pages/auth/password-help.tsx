import { Head, useForm, Link } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';
import { FormEventHandler } from 'react';

import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import AuthLayout from '@/components/auth-layout';

interface Props {
    title?: string;
    description?: string;
    [key: string]: unknown;
}

type PasswordHelpForm = {
    name: string;
    email: string;
    message: string;
};

export default function PasswordHelp({ title, description }: Props) {
    const { data, setData, post, processing, errors } = useForm<Required<PasswordHelpForm>>({
        name: '',
        email: '',
        message: '',
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(route('password-help.store'));
    };

    return (
        <AuthLayout 
            title={title || "❓ Bantuan Reset Password"} 
            description={description || "Ajukan tiket bantuan untuk reset password"}
        >
            <Head title="Bantuan Reset Password - ChemLab DTK" />
            
            <div className="mb-6 p-4 bg-amber-50 rounded-lg border-l-4 border-amber-400">
                <div className="flex items-start">
                    <span className="text-2xl mr-3">⚠️</span>
                    <div>
                        <h3 className="text-sm font-medium text-amber-800">Penting!</h3>
                        <p className="text-sm text-amber-700 mt-1">
                            Sistem ini tidak mengirim email reset password otomatis. Tim admin akan memproses permintaan Anda secara manual 
                            dan memberikan password sementara melalui email dalam 1-2 hari kerja.
                        </p>
                    </div>
                </div>
            </div>

            <form className="flex flex-col gap-6" onSubmit={submit}>
                <div className="grid gap-6">
                    <div className="grid gap-2">
                        <Label htmlFor="name">Nama Lengkap</Label>
                        <Input
                            id="name"
                            type="text"
                            required
                            autoFocus
                            tabIndex={1}
                            autoComplete="name"
                            value={data.name}
                            onChange={(e) => setData('name', e.target.value)}
                            disabled={processing}
                            placeholder="Masukkan nama lengkap sesuai akun"
                        />
                        <InputError message={errors.name} />
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="email">Email Akun</Label>
                        <Input
                            id="email"
                            type="email"
                            required
                            tabIndex={2}
                            autoComplete="email"
                            value={data.email}
                            onChange={(e) => setData('email', e.target.value)}
                            disabled={processing}
                            placeholder="Email yang terdaftar dalam sistem"
                        />
                        <InputError message={errors.email} />
                        <p className="text-xs text-gray-600">
                            💡 Gunakan email yang sama dengan akun Anda
                        </p>
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="message">Keterangan Tambahan (Opsional)</Label>
                        <Textarea
                            id="message"
                            rows={4}
                            tabIndex={3}
                            value={data.message}
                            onChange={(e) => setData('message', e.target.value)}
                            disabled={processing}
                            placeholder="Jelaskan masalah yang Anda alami atau informasi tambahan yang dapat membantu proses verifikasi..."
                        />
                        <InputError message={errors.message} />
                        <p className="text-xs text-gray-600">
                            Contoh: "Lupa password setelah tidak login selama 3 bulan" atau "Password tidak bisa diubah"
                        </p>
                    </div>

                    <Button type="submit" className="mt-4 w-full bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700" tabIndex={4} disabled={processing}>
                        {processing && <LoaderCircle className="h-4 w-4 animate-spin mr-2" />}
                        🎫 Ajukan Tiket Bantuan
                    </Button>
                </div>

                <div className="text-center text-sm text-muted-foreground">
                    Sudah ingat password?{' '}
                    <Link href={route('login')} className="text-blue-600 hover:text-blue-800 hover:underline">
                        Kembali ke Login
                    </Link>
                </div>

                <div className="border-t pt-4">
                    <div className="bg-blue-50 rounded-lg p-4 border border-blue-200">
                        <div className="flex items-start">
                            <span className="text-xl mr-3">📋</span>
                            <div>
                                <h4 className="font-medium text-blue-800 text-sm">Proses Bantuan Password</h4>
                                <div className="text-xs text-blue-700 mt-2 space-y-1">
                                    <p>1️⃣ <strong>Ajukan tiket:</strong> Isi form di atas dengan lengkap</p>
                                    <p>2️⃣ <strong>Verifikasi:</strong> Admin akan memverifikasi identitas Anda</p>
                                    <p>3️⃣ <strong>Reset password:</strong> Anda akan menerima password sementara via email</p>
                                    <p>4️⃣ <strong>Login & ganti:</strong> Login dengan password sementara dan wajib menggantinya</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <div className="flex items-start">
                        <span className="text-xl mr-3">📞</span>
                        <div>
                            <h4 className="font-medium text-gray-800 text-sm">Kontak Darurat</h4>
                            <div className="text-xs text-gray-600 mt-2 space-y-1">
                                <p>📧 <strong>Email:</strong> admin@che.ui.ac.id</p>
                                <p>📱 <strong>WhatsApp:</strong> +62 812-3456-7890 (jam kerja)</p>
                                <p>📍 <strong>Lokasi:</strong> Departemen Teknik Kimia FTUI</p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </AuthLayout>
    );
}