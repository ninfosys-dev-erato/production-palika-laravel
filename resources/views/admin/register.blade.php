<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('https://source.unsplash.com/1600x900/?mountains');
            /* Replace with your image URL */
            background-size: cover;
            background-repeat: no-repeat;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 500px;
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
    </style>
</head>

<body style="background-image: url({{ asset('assets/img/mountain_photo.jpg') }});
height: 100vh;
overflow: hidden">
    <div class="form-container">
        <div class="logo">
            <img src="{{ asset('assets/img/np.png') }}" height="80" alt="Logo">
        </div>
        <div class="title">
            <h5>डिजिटल पालिका व्यवस्थापन प्रणाली</h5>
            <p>(Digital Palika Management System)</p>
        </div>
        <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">सेवाग्राहीको नाम </label>
                <span class="text-danger">*</span>
                <input type="text" name="name" id="name" class="form-control" placeholder="सेवाग्राहीको नाम"
                    value="{{ old('name') }}" required>
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="avatar" class="form-label">सेवाग्राहीको फोटो</label>
                <input type="file" name="avatar" id="avatar" class="form-control" accept="image/*">
                @error('avatar')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="mobile_no" class="form-label">सेवाग्राहीको मोबाइल नम्बर </label>
                <span class="text-danger">*</span>
                <input type="text" name="mobile_no" id="mobile_no" class="form-control"
                    placeholder="सेवाग्राहीको मोबाइल नम्बर" value="{{ old('mobile_no') }}" required>
                @error('mobile_no')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">सेवाग्राहीको इमेल </label>
                <span class="text-danger">*</span>
                <input type="email" name="email" id="email" class="form-control" placeholder="सेवाग्राहीको इमेल"
                    value="{{ old('email') }}" required>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">पासवर्ड </label>
                <span class="text-danger">*</span>
                <input type="password" name="password" id="password" class="form-control" placeholder="पासवर्ड"
                    required>
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">पासवर्ड पुनःप्रविष्ट गर्नुहोस् </label>
                <span class="text-danger">*</span>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                    placeholder="पासवर्ड" required>
                @error('password_confirmation')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">साइन-अप</button>
            </div>
        </form>
        <div class="text-center mt-3">
            <a href="{{ route('digital-service') }}">{{ __('Already have account? Login') }}</a>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
