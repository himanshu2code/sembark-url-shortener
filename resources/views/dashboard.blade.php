<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | URL Shortener</title>

    <style>
        
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f8fafc;
            color: #172554;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            padding: 20px 6%;
            background: white;
            border-bottom: 1px solid #e2e8f0;
        }

        .brand {
            font-size: 21px;
            font-weight: bold;
        }

        .brand span {
            color: #2563eb;
        }

        .logout-button {
            padding: 10px 17px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            background: white;
            color: #334155;
            cursor: pointer;
        }

        main {
            max-width: 1100px;
            margin: 45px auto;
            padding: 0 24px;
        }

        .welcome {
            margin-bottom: 30px;
        }

        .welcome h1 {
            margin: 0 0 10px;
            font-size: 30px;
        }

        .welcome p {
            color: #64748b;
        }

        .profile-card {
            padding: 28px;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(15, 23, 42, 0.04);
        }

        .profile-card h2 {
            margin-top: 0;
        }

        .detail {
            padding: 15px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .detail:last-child {
            border-bottom: 0;
        }

        .label {
            display: block;
            margin-bottom: 7px;
            color: #64748b;
            font-size: 13px;
        }

        .value {
            font-weight: 600;
            overflow-wrap: anywhere;
        }

        .role {
            display: inline-block;
            padding: 6px 11px;
            border-radius: 20px;
            background: #dbeafe;
            color: #1d4ed8;
            font-size: 13px;
            font-weight: bold;
        }

        @media (max-width: 600px) {
            header {
                padding: 18px;
            }

            main {
                margin-top: 28px;
                padding: 0 16px;
            }

            .welcome h1 {
                font-size: 25px;
            }
        }
        .invitation-card {
    margin-top: 24px;
    padding: 28px;
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(15, 23, 42, 0.04);
}

.invitation-card h2 {
    margin-top: 0;
}

.invitation-form-group {
    margin-top: 18px;
}

.invitation-form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
}

.invitation-form-group input,
.invitation-form-group select {
    width: 100%;
    padding: 12px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    background: white;
    color: #172554;
}

.invitation-button {
    margin-top: 22px;
    padding: 12px 20px;
    border: 0;
    border-radius: 8px;
    background: #2563eb;
    color: white;
    font-weight: 600;
    cursor: pointer;
}

.invitation-button:hover {
    background: #1d4ed8;
}


/* Short URL list */
.urls-card {
    margin-top: 28px;
    padding: 30px;
    overflow: hidden;
}

.urls-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 26px;
}

.urls-header h2 {
    margin: 0 0 8px;
    font-size: 23px;
    font-weight: 700;
    color: #172554;
}

.urls-subtitle {
    margin: 0;
    color: #64748b;
    font-size: 14px;
}

.urls-count {
    white-space: nowrap;
    padding: 8px 13px;
    border-radius: 20px;
    background: #eff6ff;
    color: #1d4ed8;
    font-size: 13px;
    font-weight: 600;
}

.urls-table-wrapper {
    width: 100%;
    overflow-x: auto;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
}

.urls-table {
    width: 100%;
    min-width: 760px;
    border-collapse: collapse;
    text-align: left;
}

.urls-table thead {
    background: #f8fafc;
}

.urls-table th {
    padding: 16px;
    color: #64748b;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 1px solid #e2e8f0;
}

.urls-table td {
    padding: 17px 16px;
    border-bottom: 1px solid #f1f5f9;
    color: #334155;
    font-size: 14px;
}

.urls-table tbody tr:last-child td {
    border-bottom: none;
}

.urls-table tbody tr {
    transition: background 0.2s ease;
}

.urls-table tbody tr:hover {
    background: #f8fbff;
}

.destination-link {
    display: inline-block;
    max-width: 230px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    color: #334155;
    font-weight: 500;
    text-decoration: none;
}

.destination-link:hover {
    color: #2563eb;
}

.short-link {
    color: #2563eb;
    font-weight: 600;
    text-decoration: none;
    white-space: nowrap;
}

.short-link:hover {
    text-decoration: underline;
}

.click-badge {
    display: inline-block;
    min-width: 32px;
    padding: 6px 10px;
    text-align: center;
    border-radius: 8px;
    background: #f1f5f9;
    color: #334155;
    font-weight: 700;
}

.created-date {
    white-space: nowrap;
    color: #334155;
}

.created-date span {
    display: block;
    margin-top: 5px;
    color: #94a3b8;
    font-size: 12px;
}

.copy-button {
    padding: 8px 12px;
    border: 1px solid #bfdbfe;
    border-radius: 8px;
    background: #ffffff;
    color: #2563eb;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.copy-button:hover {
    background: #eff6ff;
    border-color: #60a5fa;
}

.copy-button.copied {
    background: #dcfce7;
    border-color: #86efac;
    color: #166534;
}

.empty-urls {
    padding: 42px 20px;
    text-align: center;
    border: 1px dashed #cbd5e1;
    border-radius: 12px;
    background: #f8fafc;
}

.empty-urls h3 {
    margin: 0 0 8px;
    color: #1e293b;
}

.empty-urls p {
    margin: 0;
    color: #64748b;
    font-size: 14px;
}

@media (max-width: 640px) {
    .urls-card {
        padding: 20px 14px;
    }

    .urls-header {
        align-items: flex-start;
    }

    .urls-header h2 {
        font-size: 20px;
    }
}

    </style>
</head>

<body>
    <header>
        <div class="brand">Sembark <span>URL Shortener</span></div>

        <form method="POST" action="{{ url('/logout') }}">
            @csrf
            <button class="logout-button" type="submit">Log Out</button>
        </form>
    </header>

    <main>
        
        @if (session('success'))
            <div style="margin-bottom: 20px; padding: 14px; background: #dcfce7; color: #166534; border-radius: 8px;">
                {{ session('success') }}
            </div>
        @endif

        <section class="welcome">
            <h1>Dashboard</h1>
            <p>Manage your account and access your URL shortener workspace.</p>
        </section>

        <section class="profile-card">
            <h2>Account Information</h2>

            <div class="detail">
                <span class="label">Name</span>
                <span class="value">{{ $user->name }}</span>
            </div>

            <div class="detail">
                <span class="label">Email Address</span>
                <span class="value">{{ $user->email }}</span>
            </div>

            <div class="detail">
                <span class="label">Role</span>
                <span class="role">{{ $user->role }}</span>
            </div>
        </section>

        
@if (in_array($user->role, ['Admin', 'Member']))
    <section class="profile-card" style="margin-top: 24px;">
        <h2>Create a Short URL</h2>

        <form method="POST" action="{{ url('/short-urls') }}">
            @csrf

            <div class="detail">
                <label for="original_url" class="label">
                    Original URL
                </label>

                <input
                    id="original_url"
                    type="url"
                    name="original_url"
                    value="{{ old('original_url') }}"
                    required
                    placeholder="https://example.com"
                    style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px;"
                >
            </div>

            <button
                type="submit"
                class="logout-button"
                style="background: #2563eb; color: white;"
            >
                Create Short URL
            </button>
        </form>
    </section>
@endif


        
@if (in_array($user->role, ['SuperAdmin', 'Admin']))
    <section class="invitation-card">
        <h2>Invite a User</h2>
        @if ($errors->any())
            <div role="alert" style="margin: 16px 0; padding: 14px 16px; background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; border-radius: 10px;">
                <strong style="display: block; margin-bottom: 5px;">
                    ⚠ Invitation could not be sent
                </strong>

                @foreach ($errors->all() as $error)
                    <div style="font-size: 14px; line-height: 1.6;">
                        {{ $error }}
                    </div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ url('/invitations') }}">
            @csrf

            <div class="invitation-form-group">
                <label for="email">Email address</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                >
            </div>

            <div class="invitation-form-group">
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="Admin">Admin</option>

                    @if ($user->role === 'Admin')
                        <option value="Member">Member</option>
                    @endif
                </select>
            </div>

            @if ($user->role === 'SuperAdmin')
                <div class="invitation-form-group">
                    <label for="company_id">Company</label>
                    <select id="company_id" name="company_id" required>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}">
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <button class="invitation-button" type="submit">
                Send Invitation
            </button>
        </form>
    </section>
@endif


<section class="profile-card urls-card">
    <div class="urls-header">
        <div>
            <h2>Your Short URLs</h2>
            <p class="urls-subtitle">
                Manage, track and share your shortened links.
            </p>
        </div>

        <span class="urls-count">
            {{ $shortUrls->count() }} Links
        </span>
    </div>

    @if ($shortUrls->isEmpty())
        <div class="empty-urls">
            <h3>No short URLs yet</h3>
            <p>Create your first short URL using the form above.</p>
        </div>
    @else
        <div class="urls-table-wrapper">
            <table class="urls-table">
                <thead>
                    <tr>
                        <th>Destination</th>
                        <th>Short Link</th>
                        <th>Clicks</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($shortUrls as $shortUrl)
                        <tr>
                            <td>
                                <a
                                    class="destination-link"
                                    href="{{ $shortUrl->original_url }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    title="{{ $shortUrl->original_url }}"
                                >
                                    {{ \Illuminate\Support\Str::limit($shortUrl->original_url, 38) }}
                                </a>
                            </td>

                            <td>
                                <a
                                    class="short-link"
                                    href="{{ url($shortUrl->short_code) }}"
                                    target="_blank"
                                >
                                    {{ url($shortUrl->short_code) }}
                                </a>
                            </td>

                            <td>
                                <span class="click-badge">
                                    {{ number_format($shortUrl->clicks) }}
                                </span>
                            </td>

                            <td class="created-date">
                                {{ $shortUrl->created_at->format('d M Y') }}
                                <span>
                                    {{ $shortUrl->created_at->format('h:i A') }}
                                </span>
                            </td>

                            <td>
                                <button
                                    type="button"
                                    class="copy-button"
                                    data-copy-url="{{ url($shortUrl->short_code) }}"
                                    onclick="copyShortUrl(this)"
                                >
                                    Copy link
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</section>

<script>
    function copyShortUrl(button) {
        const shortUrl = button.dataset.copyUrl;

        navigator.clipboard.writeText(shortUrl).then(() => {
            button.textContent = 'Copied!';
            button.classList.add('copied');

            setTimeout(() => {
                button.textContent = 'Copy link';
                button.classList.remove('copied');
            }, 1500);
        }).catch(() => {
            window.prompt('Copy your short URL:', shortUrl);
        });
    }
</script>
    </main>
</body>
</html>