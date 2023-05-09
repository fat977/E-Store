<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Verify Your Account</title>
</head>

<body>
    <table>
        <tr><td>Dear {{ $name }} </td></tr>
        <tr><td>&nbsp;<br></td></tr>
        <tr><td>Please click on link below to activate your account :-</td></tr>
        <tr><td>&nbsp;<br></td></tr>
        <tr><td><a class="btn btn-primary" href="{{ url('/user/confirm/'.$code) }}">Verify</a></td></tr>
        <tr><td>&nbsp;<br></td></tr>
        <tr><td>&nbsp;<br></td></tr>
        <tr><td>Thanks & Regards</td></tr>
        <tr><td>Stack Developers</td></tr>
    </table>
</body>

</html>