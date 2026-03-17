@extends('template.user')
@section('content')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #fafafa;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
        }

        .login-container {
            background: #fff;
            padding: 40px 35px;
            margin: 80px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 420px;
            transition: all 0.3s ease;
        }

        .login-container:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            font-weight: 700;
            color: #00845c;
            margin-bottom: 25px;
            letter-spacing: 0.3px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-size: 14px;
            margin-bottom: 6px;
            color: #555;
            font-weight: 500;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 14px;
            border-radius: 10px;
            border: 1px solid #ddd;
            font-size: 15px;
            transition: all 0.3s ease;
            background-color: #fdfdfd;
        }

        input:focus {
            outline: none;
            border-color: #7cc652;
            box-shadow: 0 0 0 3px rgba(124, 198, 82, 0.2);
        }

        button {
            width: 100%;
            background: linear-gradient(135deg, #7cc652, #00845c);
            border: none;
            color: white;
            font-size: 15px;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button:hover {
            background: linear-gradient(135deg, #6abf4a, #006b46);
            transform: translateY(-1px);
        }

        .alert-error,
        .alert-success {
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .alert-error {
            background: #fdecea;
            color: #b91c1c;
        }

        .alert-success {
            background: #ecfdf5;
            color: #166534;
        }

        .footer {
            margin-top: 18px;
            text-align: center;
            font-size: 14px;
            color: #666;
        }

        .footer a {
            color: #00845c;
            text-decoration: none;
            font-weight: 600;
            margin: 0 6px;
            transition: color 0.2s;
        }

        .footer a:hover {
            text-decoration: underline;
            color: #7cc652;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-container {
                padding: 30px 25px;
                margin: 20px;
            }
        }
    </style>

    <div class="login-container">
        <h2>Đăng nhập</h2>

        @if ($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="you@example.com" required />
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required />
            </div>
            <button type="submit">Đăng nhập</button>
        </form>

        <div class="footer">
            <a href="/register">Đăng ký ngay</a> |
            <a href="{{ route('password.request') }}">Quên mật khẩu?</a>
        </div>
    </div>
@endsection
