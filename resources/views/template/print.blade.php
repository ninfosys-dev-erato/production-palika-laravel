<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Recommendation Letter</title>
    <style>
        /* Reset and base styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html, body {
            width: 210mm;
            min-height: 297mm;
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        /* A4 Page Container */
        .a4-page {
            background: #fff;
            width: 210mm;
            min-height: 297mm;
            padding: 20mm;
            margin: 20px auto;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            font-family: "DejaVu Sans", sans-serif;
            color: #000;
            position: relative;
        }

        @page {
            size: A4;
            margin: 0;
        }

        /* Page breaks for multi-page letters */
        .page-break {
            page-break-after: always;
        }
    </style>

    {!! $styles ?? '' !!}
</head>
<body>
    <div class="a4-page">
        {!! $html !!}
    </div>
</body>
</html>
