<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && in_array(auth()->user()->role, ['admin', 'dosen']);
    }

    public function rules(): array
    {
        return [
            'status'  => ['required', 'in:admin_verifikasi,dosen_ttd,selesai,ditolak'],
            'catatan' => ['nullable', 'string', 'max:500'],
            // Wajib ada catatan jika menolak
            'catatan' => [
                $this->input('status') === 'ditolak' ? 'required' : 'nullable',
                'string', 'max:500',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required'  => 'Status baru harus ditentukan.',
            'status.in'        => 'Status tidak valid.',
            'catatan.required' => 'Alasan penolakan wajib diisi.',
        ];
    }
}