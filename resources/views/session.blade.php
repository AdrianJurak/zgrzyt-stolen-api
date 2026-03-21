<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Zarządzanie Sesją</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica', 'Arial', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
        }

        h1 {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: #333;
            text-align: center;
        }

        .button-group {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        button {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-logout {
            background: #ef4444;
            color: white;
        }

        .btn-logout:hover {
            background: #dc2626;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .btn-reset {
            background: #f59e0b;
            color: white;
        }

        .btn-reset:hover {
            background: #d97706;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        }

        .btn-admin {
            background: #3b82f6;
            color: white;
        }

        .btn-admin:hover {
            background: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .info-box {
            background: #f3f4f6;
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            color: #666;
            text-align: center;
        }

        .success {
            background: #d1fae5;
            color: #065f46;
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1rem;
            text-align: center;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1rem;
            text-align: center;
        }

        .loading {
            display: none;
            text-align: center;
            margin-top: 1rem;
        }

        .spinner {
            border: 4px solid #f3f4f6;
            border-top: 4px solid #3b82f6;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔐 Zarządzanie Sesją</h1>

        <div id="message"></div>

        @if (session('error'))
            <div class="error" id="session-message">{{ session('error') }}</div>
        @elseif (session('success'))
            <div class="success" id="session-message">{{ session('success') }}</div>
        @endif

        <div class="info-box">
            <p>Jeśli masz problem z dostępem do panelu, możesz tutaj wylogować się lub zresetować sesję.</p>
        </div>

        <div class="button-group">
            <button class="btn-logout" onclick="logout()">🚪 Wyloguj się</button>
            <button class="btn-admin" onclick="window.location.href='/admin'">📊 Wróć do Panelu</button>
        </div>

        <div class="loading" id="loading">
            <div class="spinner"></div>
            <p style="margin-top: 1rem; color: #666;">Przetwarzanie...</p>
        </div>
    </div>

    <script>
        function showMessage(message, type = 'success') {
            const messageEl = document.getElementById('message');
            messageEl.innerHTML = `<div class="${type}">${message}</div>`;
            setTimeout(() => {
                messageEl.innerHTML = '';
            }, 5000);
        }

        function showLoading(show = true) {
            document.getElementById('loading').style.display = show ? 'block' : 'none';
        }

        function logout() {
            if (confirm('Czy na pewno chcesz się wylogować?')) {
                showLoading(true);
                fetch('/logout', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    showLoading(false);
                    showMessage('✅ ' + data.message, 'success');
                    setTimeout(() => {
                        window.location.href = '/admin/login';
                    }, 1500);
                })
                .catch(error => {
                    showLoading(false);
                    showMessage('❌ ' + error.message, 'error');
                });
            }
        }

        // Sprawdź status autoryzacji przy ładowaniu strony
        document.addEventListener('DOMContentLoaded', function() {
            const sessionMessage = document.getElementById('session-message');
            if (sessionMessage) {
                setTimeout(() => {
                    sessionMessage.style.display = 'none';
                }, 5000);
            }

            fetch('/auth-status')
                .then(response => {
                    // Jeśli otrzymamy błąd autoryzacji (401 lub 403)
                    if (response.status === 401 || response.status === 403) {
                        showMessage('⚠️ Błąd autoryzacji. Przekierowanie za 5 sekund...', 'error');
                        setTimeout(() => {
                            window.location.href = '/session';
                        }, 5000);
                        throw new Error('Błąd autoryzacji');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.authenticated) {
                        const user = data.user;
                        const infoBox = document.querySelector('.info-box');
                        infoBox.innerHTML = `<p>Zalogowany jako: <strong>${user.name}</strong> (${user.role})</p>`;
                    }
                })
                .catch(error => {
                    if (error.message !== 'Błąd autoryzacji') {
                        console.log('Błąd sprawdzania statusu:', error);
                    }
                });
        });
    </script>
</body>
</html>
