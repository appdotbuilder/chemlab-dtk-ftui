import { Head, useForm } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';
import { FormEventHandler } from 'react';

import InputError from '@/components/input-error';
import TextLink from '@/components/text-link';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AuthLayout from '@/components/auth-layout';

interface Props {
    title?: string;
    description?: string;
    [key: string]: unknown;
}

type RegisterForm = {
    name: string;
    email: string;
    phone: string;
    study_program: string;
    batch_year: string;
    password: string;
    password_confirmation: string;
};

export default function Register({ title, description }: Props) {
    const { data, setData, post, processing, errors, reset } = useForm<Required<RegisterForm>>({
        name: '',
        email: '',
        phone: '',
        study_program: '',
        batch_year: '',
        password: '',
        password_confirmation: '',
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(route('register'), {
            onFinish: () => reset('password', 'password_confirmation'),
        });
    };

    const currentYear = new Date().getFullYear();
    const batchYears = Array.from({ length: 10 }, (_, i) => currentYear - i);
    
    const studyPrograms = [
        'Teknik Kimia',
        'Teknik Industri', 
        'Teknik Metalurgi dan Material',
        'Teknik Komputer',
        'Teknik Elektro',
        'Teknik Mesin',
        'Teknik Sipil',
        'Arsitektur',
        'Lainnya'
    ];

    return (
        <AuthLayout 
            title={title || "🎓 Pendaftaran Mahasiswa"} 
            description={description || "Daftar akun untuk mengakses sistem ChemLab DTK FTUI"}
        >
            <Head title="Pendaftaran Mahasiswa - ChemLab DTK" />
            
            <div className="mb-6 p-4 bg-blue-50 rounded-lg border-l-4 border-blue-400">
                <div className="flex items-center">
                    <span className="text-2xl mr-3">ℹ️</span>
                    <div>
                        <h3 className="text-sm font-medium text-blue-800">Khusus Mahasiswa UI</h3>
                        <p className="text-sm text-blue-700 mt-1">
                            Gunakan email dengan domain @ui.ac.id. Akun akan diverifikasi oleh Admin/Laboran sebelum dapat digunakan.
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
                            placeholder="Contoh: Budi Santoso"
                        />
                        <InputError message={errors.name} />
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="email">Email Mahasiswa UI</Label>
                        <Input
                            id="email"
                            type="email"
                            required
                            tabIndex={2}
                            autoComplete="email"
                            value={data.email}
                            onChange={(e) => setData('email', e.target.value)}
                            disabled={processing}
                            placeholder="nama.mahasiswa@ui.ac.id"
                        />
                        <InputError message={errors.email} />
                        <p className="text-xs text-gray-600">
                            ⚠️ Harus menggunakan email dengan domain @ui.ac.id
                        </p>
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="phone">Nomor Telepon</Label>
                        <Input
                            id="phone"
                            type="tel"
                            required
                            tabIndex={3}
                            autoComplete="tel"
                            value={data.phone}
                            onChange={(e) => setData('phone', e.target.value)}
                            disabled={processing}
                            placeholder="081234567890"
                        />
                        <InputError message={errors.phone} />
                    </div>

                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div className="grid gap-2">
                            <Label htmlFor="study_program">Program Studi</Label>
                            <Select value={data.study_program} onValueChange={(value) => setData('study_program', value)}>
                                <SelectTrigger>
                                    <SelectValue placeholder="Pilih program studi" />
                                </SelectTrigger>
                                <SelectContent>
                                    {studyPrograms.map((program) => (
                                        <SelectItem key={program} value={program}>
                                            {program}
                                        </SelectItem>
                                    ))}
                                </SelectContent>
                            </Select>
                            <InputError message={errors.study_program} />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="batch_year">Angkatan</Label>
                            <Select value={data.batch_year} onValueChange={(value) => setData('batch_year', value)}>
                                <SelectTrigger>
                                    <SelectValue placeholder="Pilih angkatan" />
                                </SelectTrigger>
                                <SelectContent>
                                    {batchYears.map((year) => (
                                        <SelectItem key={year} value={year.toString()}>
                                            {year}
                                        </SelectItem>
                                    ))}
                                </SelectContent>
                            </Select>
                            <InputError message={errors.batch_year} />
                        </div>
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="password">Kata Sandi</Label>
                        <Input
                            id="password"
                            type="password"
                            required
                            tabIndex={4}
                            autoComplete="new-password"
                            value={data.password}
                            onChange={(e) => setData('password', e.target.value)}
                            disabled={processing}
                            placeholder="Minimal 8 karakter dengan huruf dan angka"
                        />
                        <InputError message={errors.password} />
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="password_confirmation">Konfirmasi Kata Sandi</Label>
                        <Input
                            id="password_confirmation"
                            type="password"
                            required
                            tabIndex={5}
                            autoComplete="new-password"
                            value={data.password_confirmation}
                            onChange={(e) => setData('password_confirmation', e.target.value)}
                            disabled={processing}
                            placeholder="Ulangi kata sandi"
                        />
                        <InputError message={errors.password_confirmation} />
                    </div>

                    <Button type="submit" className="mt-4 w-full bg-gradient-to-r from-blue-600 to-green-600 hover:from-blue-700 hover:to-green-700" tabIndex={6} disabled={processing}>
                        {processing && <LoaderCircle className="h-4 w-4 animate-spin mr-2" />}
                        🎓 Daftar sebagai Mahasiswa
                    </Button>
                </div>

                <div className="text-center text-sm text-muted-foreground">
                    Sudah punya akun?{' '}
                    <TextLink href={route('login')} tabIndex={7}>
                        Masuk di sini
                    </TextLink>
                </div>

                <div className="mt-4 p-3 bg-amber-50 rounded-lg border border-amber-200">
                    <div className="flex items-start">
                        <span className="text-xl mr-2">👨‍💼</span>
                        <div>
                            <p className="text-sm font-medium text-amber-800">Untuk Staf & Dosen</p>
                            <p className="text-xs text-amber-700 mt-1">
                                Akun staf/dosen dibuat oleh Administrator. Hubungi admin jika belum memiliki akun.
                            </p>
                        </div>
                    </div>
                </div>
            </form>
        </AuthLayout>
    );
}