<!DOCTYPE html>
<html>
<head>
    <title>Social Login</title>
</head>
<body>
<script>
    window.opener.postMessage(
        {
            token: "{{ $token }}",
            user: @json($user),
        },
        "*"
    );

    window.close();
</script>
</body>
</html>