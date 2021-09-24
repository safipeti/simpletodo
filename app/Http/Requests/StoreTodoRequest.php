<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTodoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'description' => 'required',
            'due' => 'required|after_or_equal:'.date('Y-m-d'),
            'upload_file' => 'mimes:pdf,xml,jpg,jpeg,txt|max:5000',
        ];
    }

    public function messages(): array
    {
        return [
          'name.required' => 'A név megadása kötelező',
          'description.required' => 'A leírás megadása kötelező',
          'due_date.required' => 'A lejárat dátumának megadása kötelező',
          'due.after_or_equal' => 'A lejárat dátum nem lehet múlbéli. Mai, vagy a mai napnál nagyobbnak kell lennie',
          'upload_file.mimes' => 'Csak pdf, xml, jpg vagy jpeg formátumú fájl tölthető fel.',
          'upload_file.max' => 'Max 5 MB nagyságú fájl tölthető fel.'
        ];
    }
}
