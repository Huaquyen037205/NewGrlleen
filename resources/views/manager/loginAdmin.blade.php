<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Đăng nhập</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Poppins', sans-serif;
      background: #faf8f3;
      color: #333;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }
    .login-container {
      background: #fff;
      padding: 40px 35px;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.05);
      width: 100%;
      max-width: 400px;
    }
    h2 {
      text-align: center;
      margin-bottom: 25px;
      font-weight: 600;
      color: #2e2e2e;
    }
    .form-group {
      margin-bottom: 18px;
    }
    label {
      display: block;
      font-size: 14px;
      margin-bottom: 6px;
      color: #555;
    }
    input[type="email"], input[type="password"] {
      width: 100%;
      padding: 12px 14px;
      border-radius: 8px;
      border: 1px solid #ddd;
      font-size: 15px;
      transition: border-color 0.2s;
    }
    input:focus {
      outline: none;
      border-color: #a3c585;
    }
    button {
      width: 100%;
      background: #a3c585;
      border: none;
      color: white;
      font-size: 15px;
      padding: 12px;
      border-radius: 8px;
      cursor: pointer;
      transition: background 0.3s;
    }
    button:hover {
      background: #8cb36e;
    }
    .footer {
      margin-top: 18px;
      text-align: center;
      font-size: 14px;
      color: #777;
    }
    .footer a {
      color: #a3c585;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h2>Đăng nhập</h2>
    @if ($errors->any())
        <div style="background:#fdecea;color:#b91c1c;padding:10px 14px;border-radius:6px;margin-bottom:15px;">
            {{ $errors->first() }}
        </div>
    @endif

    @if (session('success'))
        <div style="background:#ecfdf5;color:#166534;padding:10px 14px;border-radius:6px;margin-bottom:15px;">
            {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('manager.login.post') }}" method="POST">
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
      <p>Chưa có tài khoản? <a href="#">Đăng ký ngay</a></p>
    </div>
  </div>
</body>
</html>
