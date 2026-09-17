<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'room_id' => [
                'required',
                'exists:rooms,id',
            ],

            'booking_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            'start_time' => [
                'required',
                'date_format:H:i',
            ],

            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time',
            ],

            'name' => [
                'required',
                'string',
                'max:100',
            ],

            'institution' => [
                'required',
                'string',
                'max:150',
            ],

            'whatsapp' => [
                'required',
                'string',
                'max:20',
            ],

            'participant_count' => [
                'required',
                'integer',
                'min:1',
            ],

            'purpose' => [
                'required',
                'string',
                'max:1000',
            ],

            'additional_facilities' => [
                'nullable',
                'array',
            ],

            'additional_facilities.*' => [
                'string',
                'max:100',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'room_id.required' => 'Silakan pilih ruangan.',
            'room_id.exists' => 'Ruangan tidak ditemukan.',

            'booking_date.required' => 'Tanggal booking wajib diisi.',
            'booking_date.after_or_equal' => 'Tanggal booking tidak boleh sebelum hari ini.',

            'start_time.required' => 'Jam mulai wajib diisi.',
            'start_time.date_format' => 'Format jam mulai tidak valid.',

            'end_time.required' => 'Jam selesai wajib diisi.',
            'end_time.after' => 'Jam selesai harus setelah jam mulai.',

            'name.required' => 'Nama pemesan wajib diisi.',
            'institution.required' => 'Instansi/perusahaan wajib diisi.',
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',

            'participant_count.required' => 'Jumlah peserta wajib diisi.',
            'participant_count.min' => 'Jumlah peserta minimal 1 orang.',

            'purpose.required' => 'Keperluan wajib diisi.',
        ];
    }
}