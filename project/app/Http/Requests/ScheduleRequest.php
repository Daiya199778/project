<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // 認証の設定に応じて適切な値を返す（true: 認証あり、false: 認証なし）
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'start_date' => 'required|integer',
            'end_date' => 'required|integer',
            'event_name' => 'required|max:20',
        ];
    }
}
