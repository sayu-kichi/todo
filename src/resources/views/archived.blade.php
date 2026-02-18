@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="todo__alert">
  @if(session('message'))
  <div class="todo__alert--success">
    {{ session('message') }}
  </div>
  @endif
  @if ($errors->any())
  <div class="todo__alert--danger">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
      </ul>
    </div>
  @endif
</div>



  <div class="section__title">
    <h2>アーカイブ検索</h2>
  </div>
  <form class="search-form" action="/todos/search" method="GET">
    @csrf
    <div class="search-form__item">
      
      <input class="search-form__item-input" type="text" name="keyword" value="{{ old('keyword') }}">
      <select class="search-form__item-select" name="category_id">
        <option value="">カテゴリ</option>
        @foreach ($categories as $category)
                  <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
        @endforeach
      </select>
      <input class="create-form__item-date" type="datetime-local" name="deadline" value="{{ old('deadline') }}">
    </div>
    <div class="search-form__button">
      <label>
            <input type="checkbox" name="overdue" value="1" {{ request('overdue') ? 'checked' : '' }}> 期限切れのみ
        </label>
      <button class="search-form__button-submit" type="submit">検索</button>
    </div>
  </form>

  <div class="todo-table">
    <form action="/todos/search" method="GET" id="sort-form">
    <table class="todo-table__inner">
       
      <tr class="todo-table__row">
        <th class="todo-table__header">
          <span class="todo-table__header-span">Todo</span>
          <span class="todo-table__header-span">カテゴリ</span> 
          <span class="todo-table__header-span">期限</span>
          <select name="sort" class="sort-select"  onchange="this.form.submit()">
        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>期限日が近い順</option>
        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>期限日が遠い順</option>
        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>作成日が新しい順</option>
        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>作成日が古い順</option>
    </select>
        </th>
      </tr>
    </form>
  

@foreach ($todos as $todo)      
<tr class="todo-table__row">
  <td class="todo-table__item">
    
    {{-- 外側の箱：フォームと削除フォームを横に並べる --}}
    <div style="display: flex; align-items: center; gap: 20px; width: 100%;">
      
      {{-- ★ポイント1: styleに flex: 1; を追加して、更新フォームを横に広げる --}}
      <form class="update-form" action="/todos/update" method="POST" style="display: flex; align-items: center; gap: 15px; flex: 1;">
        @method('PATCH')
        @csrf
        
        {{-- Todo内容 --}}
        <div class="update-form__item" style="position: relative; flex: 0 0 15%; padding-right: 10px;">
          @if($todo->deadline)
            @php
              $deadline = \Carbon\Carbon::parse($todo->deadline);
              $isOverdue = $deadline->isPast();
              $isUrgent = !$isOverdue && $deadline->diffInHours(now()) <= 24;
            @endphp
            
          @endif
          <input class="update-form__item-input" type="text" name="content" value="{{ $todo['content'] }}" style="width: 100%;">
          <input type="hidden" name="id" value="{{ $todo['id'] }}">
        </div>

        {{-- カテゴリ --}}
        <div class="update-form__item" style="flex: 0 0 10%; min-width: 60px;">
          <p class="update-form__itme-p">{{ $todo['category']['name'] }}</p>  
        </div>

        {{-- 期限 --}}
        <div class="update-form__item" style="flex: 0 0 25%; min-width: 150px; margin-left: 5px;">
          <input class="update-form__item-date" type="datetime-local" name="deadline" 
            value="{{ $todo['deadline'] ? \Carbon\Carbon::parse($todo['deadline'])->format('Y-m-d\TH:i') : '' }}"
            style="width: 100%; {{ $todo->deadline && \Carbon\Carbon::parse($todo->deadline)->isPast() ? 'color: red; font-weight: bold;' : '' }}">
        </div>

        

      {{-- 2. 削除フォーム --}}
      <form class="delete-form" action="/todos/delete" method="POST">
        @method('DELETE')
        @csrf
        <div class="delete-form__button">
          <input type="hidden" name="id" value="{{ $todo['id'] }}">
          <button class="delete-form__button-submit" type="submit">削除</button>
        </div>
      </form>
    </div>
  </td>
</tr>
@endforeach
    </table>
  </form>
</div>
@endsection
