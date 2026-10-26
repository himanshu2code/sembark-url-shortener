
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Accept Invitation | Sembark URL Shortener</title>

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
            padding: 28px 16px;
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            color: #172554;
        }

        .page {
            width: 100%;
            max-width: 480px;
        }

        .brand {
            margin-bottom: 25px;
            text-align: center;
            font-size: 23px;
            font-weight: 800;
            color: #172554;
        }

        .brand span {
            color: #2563eb;
        }

        .card {
            padding: 36px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            box-shadow: 0 16px 45px rgba(15, 23, 42, 0.08);
        }

        .icon {
            width: 58px;
            height: 58px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 22px;
            border-radius: 16px;
            background: #eff6ff;
            color: #2563eb;
            font-size: 28px;
        }

        h1 {
            margin: 0 0 12px;
            font-size: 27px;
            letter-spacing: -0.6px;
        }

        .description {
            margin: 0 0 25px;
            color: #64748b;
            font-size: 14px;
            line-height: 1.7;
        }

        .invitation-info {
            margin-bottom: 25px;
            padding: 17px;
            border: 1px solid #dbeafe;
            border-radius: 12px;
            background: #f8fbff;
        }

        .info-label {
            display: block;
            margin-bottom: 6px;
            color: #64748b;
            font-size: 12px;
        }

        .info-value {
            display: block;
            overflow-wrap: anywhere;
            color: #1e293b;
            font-size: 14px;
            font-weight: 600;
        }

        .role-badge {
            display: inline-block;
            margin-top: 12px;
            padding: 6px 10px;
            border-radius: 20px;
            background: #dbeafe;
            color: #1d4ed8;
            font-size: 12px;
            font-weight: 700;
        }

        .field {
            margin-bottom: 19px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #334155;
            font-size: 13px;
            font-weight: 600;
        }

        input {
            width: 100%;
            padding: 12px 13px;
            border: 1px solid #cbd5e1;
            border-radius: 9px;
            outline: none;
            background: #ffffff;
            color: #0f172a;
            font-size: 14px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12);
        }

        .password-wrap {
            position: relative;
        }

        .password-wrap input {
            padding-right: 70px;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            padding: 5px;
            border: 0;
            background: transparent;
            color: #2563eb;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
        }

        .error {
            margin-top: 7px;
            color: #dc2626;
            font-size: 12px;
        }

        .general-error {
            margin-bottom: 20px;
            padding: 12px;
            border: 1px solid #fecaca;
            border-radius: 8px;
            background: #fef2f2;
            color: #b91c1c;
            font-size: 13px;
            line-height: 1.5;
        }

        .submit-button {
            width: 100%;
            margin-top: 5px;
            padding: 14px;
            border: 0;
            border-radius: 9px;
            background: #2563eb;
            color: #ffffff;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s, transform 0.2s;
        }

        .submit-button:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }

        .footer {
            margin-top: 22px;
            color: #94a3b8;
            font-size: 12px;
            text-align: center;
        }

        @media (max-width: 480px) {
            .card {
                padding: 25px 21px;
            }

            h1 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>
    <main class="page">
        <div class="brand">Sembark <span>URL Shortener</span></div>

        <section class="card">
            <div class="icon" aria-hidden="true">✉</div>

            <h1>You're invited!</h1>

            <p class="description">
                You've been invited to join a company workspace.
                Create your account below to accept the invitation and get started.
            </p>

            <div class="invitation-info">
                <span class="info-label">Invited email address</span>
                <span class="info-value">{{ $invitation->email }}</span>

                <span class="role-badge">
                    {{ $invitation->role }}
                </span>
            </div>

            @if ($errors->any())
                <div class="general-error">
                    Please check the information below and try again.
                </div>
            @endif

            <form
                method="POST"
                action="{{ route('invitations.register', ['token' => $token]) }}"
            >
                @csrf

                <div class="field">
                    <label for="name">Full name</label>

                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        maxlength="255"
                        autocomplete="name"
                        placeholder="Enter your full name"
                        required
                    >

                    @error('name')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="password">Create password</label>

                    <div class="password-wrap">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            minlength="8"
                            autocomplete="new-password"
                            placeholder="At least 8 characters"
                            required
                        >

                        <button
                            type="button"
                            class="toggle-password"
                            data-target="password"
                            aria-label="Show password"
                        >
                            Show
                        </button>
                    </div>

                    @error('password')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="password_confirmation">
                        Confirm password
                    </label>

                    <div class="password-wrap">
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            minlength="8"
                            autocomplete="new-password"
                            placeholder="Enter password again"
                            required
                        >

                        <button
                            type="button"
                            class="toggle-password"
                            data-target="password_confirmation"
                            aria-label="Show password confirmation"
                        >
                            Show
                        </button>
                    </div>
                </div>

                <button type="submit" class="submit-button">
                    Create Account &amp; Accept Invitation
                </button>
            </form>
        </section>

        <div class="footer">
            Secure account registration · Sembark URL Shortener
        </div>
    </main>

    <script>
        document.querySelectorAll('.toggle-password').forEach((button) => {
            button.addEventListener('click', () => {
                const input = document.getElementById(button.dataset.target);
                const isPassword = input.type === 'password';

                input.type = isPassword ? 'text' : 'password';
                button.textContent = isPassword ? 'Hide' : 'Show';
                button.setAttribute(
                    'aria-label',
                    isPassword ? 'Hide password' : 'Show password'
                );
            });
        });
    </script>
</body>
</html>