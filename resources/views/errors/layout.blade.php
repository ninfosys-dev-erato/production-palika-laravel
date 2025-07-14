<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #01399a;
            --card-bg: #E6F0FD;
            --title-color: #B83955;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
        }

        .error-card {
            background-color: var(--card-bg);
            border-radius: 1rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            max-width: 500px;
            text-align: center;
            border: 2px solid var(--primary-color);
        }

        .org-logo {
            width: 100px;
            height: auto;
            margin-bottom: 1.5rem;
        }

        .org-name {
            color: var(--title-color);
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .error-code {
            font-size: 4rem;
            font-weight: bold;
            color: var(--title-color);
            margin-bottom: 1rem;
        }

        .error-message {
            font-size: 1.25rem;
            color: var(--title-color);
            margin-bottom: 2rem;
        }

        .back-button {
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .back-button:hover {
            background-color: darkblue;
            color: #fff;
        }

        footer {
            margin-top: 2rem;
            font-size: 0.85rem;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center">
        <div class="error-card">
            <img src="{{ asset('assets/img/np.png') }}" alt="Government Logo" class="org-logo">
            <div class="org-name">{{ getSetting('palika-name') }}</div>
            <div class="error-code">@yield('code')</div>
            <div class="error-message">@yield('message')</div>
            <a href="javascript:history.back()" class="back-button">← पछाडि जानुहोस्</a>
        </div>
    </div>
</body>

</html>
