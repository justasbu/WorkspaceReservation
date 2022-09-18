<html>
<head>
    <meta charset="utf-8">
    <title>{{ config('app.name') }}</title>
    <script>
        @if($token !== '')
        window.opener.postMessage({ token: "{{ $token }}" }, "{{ config('app.client_url') }}")
        window.close()
        @endif
        @if($token === '')
        window.close()
        @endif
    </script>
</head>
<body>
</body>
</html>
