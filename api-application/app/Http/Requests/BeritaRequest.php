<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BeritaRequest extends CoreRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        switch ($this->getMethod()) {
            case 'POST': // Untuk membuat (store)
                return [
                    "id_admin" => "required|integer",
                    "judul" => "required|string",
                    "deskripsi" => "nullable",
                    "gambar" => "nullable",
                    "tanggal_pelaksanaan" => "required"
                ];
            case 'PUT': // Untuk membuat (store)
                return [
                    "id_berita" => "required|integer",
                    "judul" => "required|string",
                    "deskripsi" => "nullable",
                    "gambar" => "nullable",
                    "tanggal_pelaksanaan" => "required"
                ];
            case 'DELETE':
                return [
                    "id_berita" => "required|integer",
                ];
            case 'GET':
                return [
                    'id_berita' => 'nullable|integer',
                    'search' => 'nullable'
                ];
            default:
                return [];
        }
    }
    public function messages(): array
    {
        return [
            'id_programmers.integer' => 'id_programmer harus berupa angka',
            'id_projects.integer' => 'id_projects harus berupa angka',
        ];
    }
}
