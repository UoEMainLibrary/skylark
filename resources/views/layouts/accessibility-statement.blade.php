<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Accessibility Statement')</title>
    <style>
        @page { size: 21cm 29.7cm; margin: 2.54cm; }
        body, p, ul, ol, li {
            font-family: Arial, sans-serif;
            font-size: 12pt;
            line-height: 1.5;
            text-align: left;
            margin-bottom: 0.25cm;
            direction: ltr;
            background: transparent;
            color: #000;
        }
        body {
            max-width: 21cm;
            margin: 2.54cm auto;
            padding: 0 1cm;
        }
        h1, h2, h3, h4 {
            color: #2f5496;
            text-align: left;
            margin-top: 0.75cm;
            margin-bottom: 0.5cm;
            direction: ltr;
            background: transparent;
            page-break-after: avoid;
            font-family: Arial, sans-serif;
        }
        h1 { font-size: 24pt; }
        h2 { font-size: 20pt; }
        h3 { font-size: 16pt; }
        h4 { font-size: 14pt; }
        a:link, a:visited {
            color: #0563c1;
            text-decoration: underline;
        }
        ul { list-style-type: disc; margin-left: 1.5em; padding-left: 0.5em; }
        ul ul { list-style-type: circle; }
        ul ul ul { list-style-type: square; }
        ol { list-style-type: decimal; margin-left: 1.5em; padding-left: 0.5em; }
        li { margin-bottom: 0.1cm; }
    </style>
    @stack('styles')
</head>
<body lang="en-GB" link="#0563c1" vlink="#954f72" dir="ltr">
@yield('content')
</body>
</html>
