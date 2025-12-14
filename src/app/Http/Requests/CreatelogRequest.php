<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatelogRequest extends FormRequest
{
    protected $errorBag = 'create_log_error';
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
            'date' => 'required|date',
            'weight' => 'required|numeric|between:0,999.9|regex:/^\d{1,3}(\.\d{1})?$/',
            'calories' => 'required|integer',
            'exercise_time' => 'required',
            'exercise_content' => 'nullable|max:120',
        ];
    }

    public function messages()
    {
        return [
            'date.required' => '日付を入力してください。',
            'weight.required' => '体重を入力してください。',
            'weight.between' => '体重は4桁までの数字で入力してください。',
            'weight.regex' => '体重は小数点１桁で入力してください。',
            'calories.required' => '摂取カロリーを入力してください。',
            'calories.integer' => '摂取カロリーは数字で入力してください。',
            'exercise_time.required' => '運動時間を入力してください。',
            'exercise_content.max' => '運動内容は120文字以内で入力してください。',
        ];
    }
}
