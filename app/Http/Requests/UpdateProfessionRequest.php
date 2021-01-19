<?php

namespace App\Http\Requests;

use App\Models\Profession;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfessionRequest extends FormRequest
{
    /**
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
            'title' => 'required',
        ];
    }

    public function messages()
    {
        return[
            'title.required' => 'El campo es obligatorio',
        ];
    }

    public function updateProfession(Profession $profession)
    {
        $profession->fill([
            'title' => $this->title,
        ]);

        $profession->save();
       
    }
}
