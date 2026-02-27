<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body style="font-family: Arial, sans-serif;">
    <h2>You’ve been invited to a Coloc </h2>

    <p>{{ $name }} invited you to join their colocation.</p>
    <p>
        <a href="{{ url('/request/' . $token ) }}" 
           style="background:#4A7C6F;color:white;padding:10px 20px;text-decoration:none;border-radius:6px;">
            check Invitation 
        </a>
    </p>
</body>
</html>