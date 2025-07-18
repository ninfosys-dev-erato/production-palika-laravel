<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
            text-align: center;
            margin: 20px;
        }

        .title {
            font-weight: bold;
            margin-bottom: 20px;
        }

        .btn-option {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <div class="container-wrapper">
        <div class="form-container">
            <div class="title">
                <h5>सेवाग्राही लग-इन वा गुनासो दर्ता</h5>
                <p>(Customer Login or Apply Anonymous Grievance)</p>
            </div>
            <div class="d-grid gap-3">
                <a href="{{ route('digital-service') }}" class="btn btn-primary btn-option">सेवाग्राही लग-इन (Customer
                    Login)</a>
                <a href="{{ route('apply-grievance') }}" class="btn btn-secondary btn-option">गुनासो दर्ता (Apply
                    Anonymous Grievance)</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
