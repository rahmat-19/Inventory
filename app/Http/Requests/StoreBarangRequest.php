<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBarangRequest extends FormRequest
{
    /**
     *
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category_id' => ['required'],
            'serialNumber' => ['required', 'min:4', 'unique:barang_masuks'],
            'device' => ['required'],
            'gambar' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'tanggalMasuk' => 'required|date',
            'keterangan' => 'nullable',
        ];
    }
}
