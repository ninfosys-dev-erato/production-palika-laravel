<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
    <style>
        body {
            background-image: url('{{ asset('assets/img/mountain_photo.jpg') }}');
            background-size: cover;
            background-repeat: no-repeat;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: auto;
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 500px;
            margin: 20px;
        }

        .title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            max-width: 100px;
        }

        .container-wrapper {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            overflow-y: auto;
            /* Enables scrolling inside */
        }
    </style>
</head>

<body>
    <div class="container-wrapper">
        <div class="form-container">
            <div class="logo">
                <img src="{{ asset('assets/img/np.png') }}" alt="Logo">
            </div>
            <div class="title">
                <h5>ई-नक्सा पास</h5>
                <p>विधुतीय घरनक्सा प्रमाणीकरण प्राणली</p>
            </div>
            <form action="{{ route('organization.authenticate') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label visually-hidden">इमेल</label>
                    <input name="email" class="form-control @error('email') is-invalid @enderror" type="email"
                        value="{{ old('email') }}" id="email" placeholder="इमेल" />
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">पासवर्ड </label>
                    <span class="text-danger">*</span>
                    <input type="password" name="password" id="password" class="form-control" placeholder="पासवर्ड"
                        required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">लग-इन</button>
                </div>
            </form>
            <div class="text-center mt-3">
                <a href="{{ route('organization.register') }}">संस्था / परामर्शदाता दर्ता गर्नु भएको छैन भने?  दर्ता गर्नुहोस</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
