import { Head, useForm, Link } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';
import { FormEventHandler } from 'react';

import InputError from '@/components/input-error';
import TextLink from '@/components/text-link';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthLayout from '@/components/auth-layout';

type LoginForm = {
    email: string;
    password: string;
    remember: boolean;
};

interface LoginProps {
    status?: string;
    canResetPassword: boolean;
}

export default function Login({ status }: LoginProps) {
    const { data, setData, post, processing, errors, reset } = useForm<Required<LoginForm>>({
        email: '',
        password: '',
        remember: false,
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(route('login'), {
            onFinish: () => reset('password'),
        });
    };

    return (
        <AuthLayout 
            title="🔐 Masuk ke ChemLab" 
            description="Masukkan email dan kata sandi untuk mengakses sistem laboratorium"
        >
            <Head title="Masuk - ChemLab DTK" />

            {status && (
                <div className="mb-6 p-4 bg-green-50 rounded-lg border-l-4 border-green-400">
                    <div className="flex items-center">
                        <span className="text-xl mr-2">✅</span>
                        <p className="text-sm text-green-800">{status}</p>
                    </div>
                </div>
            )}

            <form className="flex flex-col gap-6" onSubmit={submit}>
                <div className="grid gap-6">
                    <div className="grid gap-2">
                        <Label htmlFor="email">Alamat Email</Label>
                        <Input
                            id="email"
                            type="email"
                            required
                            autoFocus
                            tabIndex={1}
                            autoComplete="email"
                            value={data.email}
                            onChange={(e) => setData('email', e.target.value)}
                            placeholder="email@che.ui.ac.id atau nama@ui.ac.id"
                        />
                        <InputError message={errors.email} />
                    </div>

                    <div className="grid gap-2">
                        <div className="flex items-center">
                            <Label htmlFor="password">Kata Sandi</Label>
                            <Link 
                                href="/password-help" 
                                className="ml-auto text-sm text-blue-600 hover:text-blue-800 hover:underline" 
                                tabIndex={5}
                            >
                                Lupa kata sandi?
                            </Link>
                        </div>
                        <Input
                            id="password"
                            type="password"
                            required
                            tabIndex={2}
                            autoComplete="current-password"
                            value={data.password}
                            onChange={(e) => setData('password', e.target.value)}
                            placeholder="Masukkan kata sandi"
                        />
                        <InputError message={errors.password} />
                    </div>

                    <div className="flex items-center space-x-3">
                        <Checkbox
                            id="remember"
                            name="remember"
                            checked={data.remember}
                            onClick={() => setData('remember', !data.remember)}
                            tabIndex={3}
                        />
                        <Label htmlFor="remember">Ingat saya</Label>
                    </div>

                    <Button type="submit" className="mt-4 w-full bg-gradient-to-r from-blue-600 to-green-600 hover:from-blue-700 hover:to-green-700" tabIndex={4} disabled={processing}>
                        {processing && <LoaderCircle className="h-4 w-4 animate-spin mr-2" />}
                        🔐 Masuk ke Sistem
                    </Button>
                </div>

                <div className="text-center text-sm text-muted-foreground">
                    Mahasiswa belum punya akun?{' '}
                    <TextLink href={route('register')} tabIndex={6}>
                        Daftar di sini
                    </TextLink>
                </div>

                <div className="border-t pt-4">
                    <div className="bg-blue-50 rounded-lg p-4 border border-blue-200">
                        <div className="flex items-start">
                            <span className="text-xl mr-3">💡</span>
                            <div>
                                <h4 className="font-medium text-blue-800 text-sm">Info Login</h4>
                                <div className="text-xs text-blue-700 mt-2 space-y-1">
                                    <p>👨‍🎓 <strong>Mahasiswa:</strong> @ui.ac.id (perlu verifikasi admin)</p>
                                    <p>👨‍💼 <strong>Staf/Dosen:</strong> @che.ui.ac.id (dibuat oleh admin)</p>
                                    <p>❓ <strong>Lupa password?</strong> Ajukan tiket bantuan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </AuthLayout>
    );
}