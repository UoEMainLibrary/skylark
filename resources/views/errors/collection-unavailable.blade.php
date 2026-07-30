<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $fullname }} — temporarily unavailable</title>
    <style>
        body {
            margin: 0;
            font-family: Georgia, "Times New Roman", serif;
            background: #f5f5f5;
            color: #222;
        }
        main {
            max-width: 36rem;
            margin: 4rem auto;
            padding: 0 1.5rem;
        }
        h1 {
            font-size: 1.75rem;
            font-weight: normal;
            margin-bottom: 0.75rem;
        }
        p {
            line-height: 1.5;
            margin: 0 0 1rem;
        }
        a {
            color: #041e42;
        }
    </style>
</head>
<body>
    <main>
        <h1>{{ $fullname }} is temporarily unavailable</h1>
        <p>
            This collection is not available at the moment. Please try again later,
            or return to the
            <a href="{{ url('/') }}">University Collections homepage</a>.
        </p>
    </main>
</body>
</html>
