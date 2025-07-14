<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('https://source.unsplash.com/1600x900/?city');
            /* Background image for the login page */
            background-size: cover;
            background-repeat: no-repeat;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .navbar {
            background-color: rgba(0, 0, 0, 0.5);
            /* Semi-transparent background for navbar */
        }

        .navbar-brand {
            font-weight: bold;
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.8);
            /* Light background for form */
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

    <!-- Login Form -->
    <div class="form-container">
        <div class="logo">
            <img src="{{ asset('assets/img/np.png') }}" alt="Logo">
        </div>
        <div class="title">
            <h5>सेवाग्राही लग-इन</h5>
            <p>(Customer Login)</p>
        </div>
        <form action="{{ route('customer.authenticate') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="mobile_no" class="form-label">मोबाइल नम्बर</label>
                <span class="text-danger">*</span>
                <input type="text" name="mobile_no" id="mobile_no" class="form-control"
                    value="{{ old('mobile_no') }}" placeholder="सेवाग्राहीको मोबाइल नम्बर" required>

                @error('mobile_no')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">पासवर्ड</label>
                <span class="text-danger">*</span>
                <input type="password" name="password" id="password" class="form-control" placeholder="पासवर्ड"
                    value="{{ old('password') }}" required>
                @error('password')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">लग-इन</button>
            </div>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('showForm') }}">खाता छैन? साइन-अप गर्नुहोस्</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
