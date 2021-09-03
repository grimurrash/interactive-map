<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="app-locale" content="{{ App::getLocale() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Авторизация - Волонтеры Москвы</title>
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

<main class="d-flex w-100">
    <div class="container d-flex flex-column">
        <div class="row vh-100">
            <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                <div class="d-table-cell align-middle">

                    <div class="text-center mt-4">
                        <h1 class="h2">Авторизация</h1>
                        <p class="lead">
                            Войдите в свою учетную запись, чтобы продолжить
                        </p>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="m-sm-4">
                                <div class="text-center">
                                    <img src="{{ asset('favicon.png') }}" alt="Charles Hall"
                                         class="img-fluid rounded-circle" width="132" height="132"/>
                                </div>
                                <form method="POST" action="{{route('login')}}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input id="email" value="{{ old('email') }}" autocomplete="email"
                                               class="form-control form-control-lg @error('email')is-invalid @enderror"
                                               type="email" name="email" required
                                               placeholder="Введите ваш email"/>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Пароль</label>
                                        <input placeholder="Введите ваш пароль" id="password"
                                               class="form-control form-control-lg @error('password') is-invalid @enderror"
                                               type="password" name="password"
                                               required autocomplete="current-password"/>
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="form-check" for="remember">
                                            <input class="form-check-input" type="checkbox" id="remember"
                                                   name="remember-me" {{ old('remember') ? 'checked' : '' }} checked>
                                            <span class="form-check-label">
                                              Запомнить
                                            </span>
                                        </label>
                                    </div>
                                    <div class="text-center mt-3">
                                        <button type="submit" class="btn btn-lg btn-primary">Войти</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>

<script src="{{asset('js/admin.js')}}"></script>
</body>
</html>
