<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Title of the document</title>
</head>

<body>
    <table>
        <tr><td>Dear {{ $name }} </td></tr>
        <tr><td>&nbsp;<br></td></tr>
        <tr><td>Request to change password . New password is as below :-</td></tr>
        <tr><td>&nbsp;<br></td></tr>
        <tr><td>Email : {{ $email }}</td></tr>
        <tr><td>&nbsp;<br></td></tr>
        <tr><td><a class="btn btn-primary" href="{{ url('/user/change-password/') }}">Change Password</a></td></tr>
        <tr><td>&nbsp;<br></td></tr>
        <tr><td>Thanks & Regards</td></tr>
        <tr><td>Stack Developers</td></tr>
    </table>
</body>

</html>