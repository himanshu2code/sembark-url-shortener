<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | URL Shortener</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            font-family: Arial, sans-serif;
            color: #172554;
            background:
                radial-gradient(circle at 10% 30%, #dbeafe 0, transparent 28%),
                radial-gradient(circle at 90% 75%, #ede9fe 0, transparent 30%),
                #f8fafc;
        }

        .login-card {
            width: 100%;
            max-width: 440px;
            padding: 40px;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(15, 23, 42, 0.10);
        }

        .brand {
            width: 58px;
            height: 58px;
            display: grid;
            place-items: center;
            margin: 0 auto 20px;
            border-radius: 16px;
            background: #eff6ff;
            color: #2563eb;
            font-size: 28px;
        }

        h1 {
            margin: 0;
            text-align: center;
            font-size: 29px;
        }

        .subtitle {
            margin: 12px 0 30px;
            text-align: center;
            color: #64748b;
            font-size: 14px;
        }

        label {
            display: block;
            margin: 18px 0 8px;
            font-size: 14px;
            font-weight: 600;
        }

        input {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font-size: 15px;
            outline: none;
        }

        input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px #dbeafe;
        }

        button {
            width: 100%;
            margin-top: 25px;
            padding: 14px;
            border: 0;
            border-radius: 10px;
            background: #2563eb;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }

        button:hover {
            background: #1d4ed8;
        }

        .error {
            margin-top: 18px;
            padding: 12px;
            border-radius: 9px;
            background: #fef2f2;
            color: #b91c1c;
            font-size: 14px;
        }

        .footer {
            margin-top: 26px;
            text-align: center;
            color: #64748b;
            font-size: 12px;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 28px 22px;
            }
        }
    </style>
</head>

<body>
    <main class="login-card">
        <div class="brand">🔐</div>

        <h1>Welcome</h1>
        <p class="subtitle">Sign in to access your account</p>

        <form method="POST" action="{{ url('/login') }}">
            @csrf

            <label for="email">Email address</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Enter your email"
                autocomplete="username"
                required
            >

            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Enter your password"
                autocomplete="current-password"
                required
            >

            @if ($errors->any())
                <div class="error">
                    {{ $errors->first() }}
                </div>
            @endif

            <button type="submit">Sign In</button>
        </form>

        <div class="footer">
            Secure access to your URL Shortener dashboard
        </div>
    </main>
</body>
</html>