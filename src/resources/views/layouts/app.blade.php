<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Todo</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  @yield('css')
</head>

<body>
  <header class="header">
    <div class="header__inner">
      <div class="header-utilities">
      <a class="header__logo" href="/">
        Todo
      </a>
          {{-- ★ハンバーガーメニュー --}}
      <div class="menu">
        <div class="menu__icon" id="menu-icon">
          <span></span>
          <span></span>
          <span></span>
        </div>
        <nav class="menu__nav" id="menu-nav">
          <ul class="menu__list">
            <li><a href="/categories">カテゴリ一覧</a></li>
            <li><a href="/todos/archived">アーカイブ一覧</a></li>
            <li><a href="/">Todo一覧</a></li>
          </ul>
        </nav>
      </div>
    </div>
  </header>

  <main>
    @yield('content')
  </main>

    <script>
    document.getElementById('menu-icon').addEventListener('click', function() {
      document.getElementById('menu-nav').classList.toggle('is-active');
    });

    // メニューの外側をクリックしたら閉じる設定
    document.addEventListener('click', function(e) {
      if (!e.target.closest('.menu')) {
        document.getElementById('menu-nav').classList.remove('is-active');
      }
    });
  </script>
</body>

</html>
