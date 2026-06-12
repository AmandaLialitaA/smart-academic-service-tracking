<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePengajuanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isMahasiswa();
    }

    public function rules(): array
    {
        return [
            'jenis_layanan'   => ['required', 'in:cuti,legalisir'],
            'keperluan'       => ['required', 'string', 'min:10', 'max:1000'],
            // Dokumen wajib
            'file_ktm'        => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
            'file_surat'      => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
            // Dokumen opsional
            'file_tambahan'   => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
        ];
    }

    public function messages(): array
    {
        return [
            'jenis_layanan.required' => 'Jenis layanan harus dipilih.',
            'jenis_layanan.in'       => 'Jenis layanan tidak valid.',
            'keperluan.required'     => 'Keperluan pengajuan harus diisi.',
            'keperluan.min'          => 'Keperluan minimal 10 karakter.',
            'file_ktm.required'      => 'File KTM wajib diunggah.',
            'file_ktm.mimes'         => 'File KTM harus berformat PDF, JPG, atau PNG.',
            'file_ktm.max'           => 'File KTM maksimal 10MB.',
            'file_surat.required'    => 'Surat permohonan wajib diunggah.',
            'file_surat.mimes'       => 'Surat permohonan harus berformat PDF, JPG, atau PNG.',
            'file_surat.max'         => 'Surat permohonan maksimal 10MB.',
            'file_tambahan.mimes'    => 'Dokumen tambahan harus berformat PDF, JPG, atau PNG.',
            'file_tambahan.max'      => 'Dokumen tambahan maksimal 10MB.',
        ];
    }
}