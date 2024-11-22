<!DOCTYPE html>
<html>
<head>
    <title>Account Created</title>
</head>
<body>
    <h1>Welcome, {{ $user->first_name }}!</h1>
    <p>Your account has been successfully created. Here are your login details:</p>
    <ul>
        <li><strong>Username:</strong> {{ $user->email }}</li>
        <li><strong>Password:</strong> {{ $password }}</li>
    </ul>
    <p>Please log in and change your password for security purposes.</p>
    <p><a href="{{ route('login') }}">Click here to log in</a></p>
    <p>Thank you for choosing us!</p>
</body>
</html>
