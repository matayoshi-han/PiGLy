@extends('layouts.auth_app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register-form__content">
    <div class="register-form__heading">
        <h2>新規会員登録</h2>
        <h3>STEP2 体重データの入力</h3>
    </div>
    <form class="form" action="/register/step2" method="POST">
        @csrf
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">現在の体重</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="weight" value="{{ old('weight') }}" placeholder="現在の体重を入力" /><span>kg</span>
                </div>
                <div class="form__error">
                    @error('weight')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">目標の体重</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="target_weight" value="{{ old('target_weight') }}" placeholder="目標の体重を入力" /><span>kg</span>
                </div>
                <div class="form__error">
                    @error('target_weight')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">アカウント作成</button>
        </div>
    </form>
</div>
@endsection