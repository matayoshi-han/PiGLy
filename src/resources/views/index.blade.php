@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="weight-logs__index">
    <div class="weight-logs__index-group">
        <h3 class="weight-logs__index-title">目標体重</h3>
        <p class="weight-logs__index-data">{{ $targetWeight ?? '' }}<span class="kg">kg</span></p>
    </div>

    <div class="weight-logs__index-group">
        <h3 class="weight-logs__index-title">目標まで</h3>
        <p class="weight-logs__index-data">
            @if(isset($targetWeight) && isset($latestWeightLog->weight))
            {{ $targetWeight - $latestWeightLog->weight }}
            @endif
            <span class="kg">kg</span>
        </p>
    </div>

    <div class="weight-logs__index-group">
        <h3 class="weight-logs__index-title">最新体重</h3>
        <p class="weight-logs__index-data">{{ $latestWeightLog->weight ?? '' }}<span class="kg">kg</span></p>
    </div>
</div>

<div class="weight-logs__content">
    <div class="weight-logs__form">
        <div class="weight-logs__form-header">

            <form action="/search" method="GET" class="weight-logs__form-search">
                <input type="date" name="start_date" id="start_date" class="weight-logs__form-input" value="{{ $startDate ?? '' }}">
                <span>〜</span>
                <input type="date" name="end_date" id="end_date" class="weight-logs__form-input" value="{{ $endDate ?? '' }}">
                <input type="submit" value="検索" class="weight-logs__form-submit">
            </form>
            <a href="#create-modal" class="add-button">データを追加</a>
        </div>
        <div class="weight-logs__table">
            <table class="weight-logs__table-inner">
                <thead class="weight-logs__table-header">
                    <tr class="weight-logs__table-header-row">
                        <th class="weight-logs__table-content_date table-content__header">日付</th>
                        <th class="weight-logs__table-content_weight table-content__header">体重</th>
                        <th class="weight-logs__table-content_calories table-content__header">摂取カロリー</th>
                        <th class="weight-logs__table-content_exercise_time table-content__header">運動時間</th>
                        <th class="weight-logs__table-content_update table-content__header"> </th>
                    </tr>
                </thead>
                <tbody class="weight-logs__table-body">
                    @foreach ($logs as $log)
                    <tr class="weight-logs__table-body-row">
                        <td class="weight-logs__table-content_date table-content__item">{{ $log->date }}</td>
                        <td class="weight-logs__table-content_weight table-content__item">{{ $log->weight }}<span>kg</span></td>
                        <td class="weight-logs__table-content_calories table-content__item">{{ $log->calories }}<span>cal</span></td>
                        <td class="weight-logs__table-content_exercise_time table-content__item">{{ $log->exercise_time }}</td>
                        <td class="weight-logs__table-content_update"><a href="#update-modal" class="update-button">更新</a></td>
                        </a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination-content">
            {{ $logs->links() }}
        </div>
    </div>
</div>

<div class="modal {{ $errors->target_error->any() ? 'is-active' : '' }}" id="target-modal">
    <div class="target-modal-content">
        <h2>目標体重設定</h2>
        <form action="/weight_logs/goal_setting" method="POST" class="weight-logs-target__form">
            @csrf
            <div class="weight-logs-target__form-group">
                <div class="weight-logs-new__form-input-group">
                    <input type="number" step="0.1" name="target_weight" id="weight" placeholder="50.0" class="weight-logs-new__form-input" value="{{ old('target_weight') }}"><span class="unit">kg</span>
                </div>
            </div>
            <div class="weight-logs__form-button">
                <a href="#" class="close-button">戻る</a>
                <input type="submit" value="更新" class="add-button">
            </div>
        </form>
    </div>
</div>

@foreach ($logs as $log)
<div class="modal {{ $errors->create_log_error->any() ? 'is-active' : '' }}" id="create-modal">
    <div class="modal-content">
        <h2>Weight Logを追加</h2>
        <form action="/weight_logs" method="POST" class="weight-logs-new__form">
            @csrf
            <div class="weight-logs-new__form-group">
                <h3>日付<span class="require">必須</span></h3>
                <input type="date" name="date" id="date" class="weight-logs-new__form-input" value="{{ old('date') }}">
                @error('date')
                <div class="error-message" style="color: red;">{{ $message }}</div>
                @enderror
            </div>

            <div class="weight-logs-new__form-group">
                <h3>体重<span class="require">必須</span></h3>
                <div class="weight-logs-new__form-input-group">
                    <input type="number" step="0.1" name="weight" id="weight" placeholder="50.0" class="weight-logs-new__form-input" value="{{ old('weight') }}"><span class="unit">kg</span>
                </div>
                @error('weight')
                <div class="error-message" style="color: red;">{{ $message }}</div>
                @enderror
            </div>

            <div class="weight-logs-new__form-group">
                <h3>摂取カロリー<span class="require">必須</span></h3>
                <div class="weight-logs-new__form-input-group">
                    <input type="number" name="calories" id="calories" placeholder="1200" class="weight-logs-new__form-input" value="{{ old('calories') }}"><span class="unit">cal</span>
                </div>
                @error('calories')
                <div class="error-message" style="color: red;">{{ $message }}</div>
                @enderror
            </div>

            <div class="weight-logs-new__form-group">
                <h3>運動時間<span class="require">必須</span></h3>
                <input type="time" name="exercise_time" id="exercise_time" placeholder="00:00" class="weight-logs-new__form-input" value="{{ old('exercise_time') }}">
                @error('exercise_time')
                <div class="error-message" style="color: red;">{{ $message }}</div>
                @enderror
            </div>

            <div class="weight-logs-new__form-group">
                <h3>運動内容</h3>
                <textarea name="exercise_content" id="exercise_content" placeholder="運動内容を追加" class="weight-logs-new__form-textarea">{{ old('exercise_content') }}</textarea>
            </div>

            <div class="weight-logs__form-button">
                <a href="/weight_logs" class="close-button">戻る</a>
                <input type="submit" value="登録" class="add-button">
            </div>
        </form>
    </div>
</div>
@endforeach

@foreach ($logs as $log)
<div class="modal {{ $errors->any() ? 'is-active' : '' }}" id="update-modal">
    <div class="modal-content">
        <h2>Weight Logを追加</h2>
        <form action="/weight_logs/{{ $log->id }}/update" method="POST" class="weight-logs-new__form">
            @csrf
            @method('PATCH')
            <div class="weight-logs-new__form-group">
                <h3>日付<span class="require">必須</span></h3>
                <input type="date" name="date" id="date" class="weight-logs-new__form-input" value="{{ $log->date }}">
                @error('date')
                <div class="error-message" style="color: red;">{{ $message }}</div>
                @enderror
            </div>

            <div class="weight-logs-new__form-group">
                <h3>体重<span class="require">必須</span></h3>
                <div class="weight-logs-new__form-input-group">
                    <input type="number" step="0.1" name="weight" id="weight" placeholder="50.0" class="weight-logs-new__form-input" value="{{ $log->weight }}"><span class="unit">kg</span>
                </div>
                @error('weight')
                <div class="error-message" style="color: red;">{{ $message }}</div>
                @enderror
            </div>

            <div class="weight-logs-new__form-group">
                <h3>摂取カロリー<span class="require">必須</span></h3>
                <div class="weight-logs-new__form-input-group">
                    <input type="number" name="calories" id="calories" placeholder="1200" class="weight-logs-new__form-input" value="{{ $log->calories }}"><span class="unit">cal</span>
                </div>
                @error('calories')
                <div class="error-message" style="color: red;">{{ $message }}</div>
                @enderror
            </div>

            <div class="weight-logs-new__form-group">
                <h3>運動時間<span class="require">必須</span></h3>
                <input type="time" name="exercise_time" id="exercise_time" placeholder="00:00" class="weight-logs-new__form-input" value="{{ $log->exercise_time }}">
                @error('exercise_time')
                <div class="error-message" style="color: red;">{{ $message }}</div>
                @enderror
            </div>

            <div class="weight-logs-new__form-group">
                <h3>運動内容</h3>
                <textarea name="exercise_content" id="exercise_content" placeholder="運動内容を追加" class="weight-logs-new__form-textarea">{{ $log->exercise_content }}</textarea>
            </div>

            <div class="weight-logs__form-button">
                <a href="/weight_logs" class="close-button">戻る</a>
                <input type="submit" value="更新" class="add-button">
            </div>
        </form>
        <form action="/weight_logs/{{ $log->id }}/delete" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="delete-button">削除</button>
        </form>
    </div>
</div>
@endforeach

@endsection