
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitation Created | Sembark</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            background: #f0f5fa;
            color: #172554;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 24px;
        }

        .container {
            width: 100%;
            max-width: 560px;
        }

        .brand {
            text-align: center;
            font-size: 27px;
            font-weight: 800;
            margin-bottom: 28px;
        }

        .brand span {
            color: #2864f0;
        }

        .card {
            background: white;
            border: 1px solid #e0e8f2;
            border-radius: 20px;
            padding: 36px;
            box-shadow: 0 16px 45px rgba(31, 61, 100, 0.08);
        }

        .success-icon {
            height: 58px;
            width: 58px;
            display: grid;
            place-items: center;
            border-radius: 16px;
            background: #dcfce7;
            color: #15803d;
            font-size: 30px;
            margin-bottom: 24px;
        }

        h1 {
            margin: 0 0 12px;
            font-size: 27px;
        }

        .description {
            color: #64748b;
            line-height: 1.7;
            margin-bottom: 26px;
        }

        .details {
            background: #f8fbff;
            border: 1px solid #dbeafe;
            border-radius: 12px;
            padding: 18px;
            margin-bottom: 24px;
        }

        .label {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 6px;
        }

        .value {
            font-weight: 700;
            overflow-wrap: anywhere;
            margin-bottom: 16px;
        }

        .value:last-child {
            margin-bottom: 0;
        }

        .role {
            display: inline-block;
            background: #dbeafe;
            color: #1d4ed8;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
        }

        .link-input {
            width: 100%;
            padding: 13px;
            border: 1px solid #cbd5e1;
            border-radius: 9px;
            font-size: 13px;
            margin: 10px 0 14px;
            color: #334155;
            background: #f8fafc;
        }

        .button {
            display: block;
            width: 100%;
            text-align: center;
            text-decoration: none;
            border: 0;
            border-radius: 9px;
            padding: 14px 18px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            margin-top: 12px;
        }

        .primary {
            background: #2864f0;
            color: white;
        }

        .primary:hover {
            background: #1d4ed8;
        }

        .secondary {
            background: white;
            color: #2457d6;
            border: 1px solid #cbdcfb;
        }

        .dashboard {
            display: block;
            text-align: center;
            margin-top: 24px;
            color: #64748b;
            text-decoration: none;
            font-size: 14px;
        }

        .note {
            color: #64748b;
            font-size: 13px;
            line-height: 1.6;
            margin-top: 18px;
        }

        @media (max-width: 480px) {
            .card {
                padding: 24px;
            }

            h1 {
                font-size: 23px;
            }
        }
    </style>
</head>
<body>
<div class="container">

    <div class="brand">Sembark <span>URL Shortener</span></div>

    <div class="card">
        <div class="success-icon">✓</div>

        <h1>Invitation Created!</h1>

        <p class="description">
            Your invitation is ready. Share the link below with the invited
            person so they can create an account and join the company workspace.
        </p>

        <div class="details">
            <div class="label">Invited email address</div>
            <div class="value">{{ $invitation->email }}</div>

            <div class="label">Assigned role</div>
            <div class="value">
                <span class="role">{{ $invitation->role }}</span>
            </div>

            <div class="label">Invitation expires</div>
            <div class="value">
                {{ $invitation->expires_at->format('d M Y, h:i A') }}
            </div>
        </div>

        <label for="invitationLink"><strong>Invitation link</strong></label>

        <input
            id="invitationLink"
            class="link-input"
            type="text"
            value="{{ $invitationUrl }}"
            readonly
        >

        <button class="button primary" type="button" onclick="copyLink()">
            Copy Invitation Link
        </button>

        <a class="button secondary" href="{{ $invitationUrl }}" target="_blank"
           rel="noopener noreferrer">
            Open Invitation Page ↗
        </a>

        <p class="note">
            Anyone who has this link may be able to accept the invitation.
            Share it only with the intended recipient. This link expires
            after the date shown above.
        </p>
    </div>

    <a class="dashboard" href="{{ route('dashboard') }}">
        ← Back to Dashboard
    </a>
</div>

<script>
    async function copyLink() {
        const input = document.getElementById('invitationLink');

        try {
            await navigator.clipboard.writeText(input.value);
            alert('Invitation link copied successfully!');
        } catch (error) {
            input.select();
            input.setSelectionRange(0, 99999);

            const copied = document.execCommand('copy');

            alert(copied
                ? 'Invitation link copied successfully!'
                : 'Please copy the selected invitation link manually.');
        }
    }
</script>
</body>
</html>