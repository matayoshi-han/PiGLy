<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TargetWeightRequest extends FormRequest
{
    protected $errorBag = 'target_error';
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
            'target_weight' => 'required|numeric|between:0,999.9',
        ];
    }

    public function messages()
    {
        return [
            'target_weight.required' => '目標体重は必須項目です。',
            'target_weight.numeric' => '目標体重は数値で入力してください。',
            'target_weight.between' => '目標体重は４桁の数字で入力してください。',
        ];
    }
}
