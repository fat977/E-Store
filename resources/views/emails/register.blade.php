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
        <tr><td>Welcome to stack developers .Your account has been created successfully</td></tr>
        <tr><td>&nbsp;<br></td></tr>
        <tr><td>Your Information :-</td></tr>
        <tr><td>&nbsp;<br></td></tr>
        <tr><td>Name : {{ $name }}</td></tr>
        <tr><td>&nbsp;<br></td></tr>
        <tr><td>Mobile : {{ $mobile }}</td></tr>
        <tr><td>&nbsp;<br></td></tr>
        <tr><td>Email : {{ $email }}</td></tr>
        <tr><td>&nbsp;<br></td></tr>
        <tr><td>Password : **** (as you choose)</td></tr>
        <tr><td>&nbsp;<br></td></tr>
        <tr><td>Thanks & Regards</td></tr>
        <tr><td>Stack Developers</td></tr>
    </table>
</body>

</html>