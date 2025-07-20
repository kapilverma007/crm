<html>
<body>
    <p>Dear {{ $record->customer->full_name ?? 'User' }},</p>
    <p>Please find your contract attached to this email.</p>
    <p>Regards,<br>Falcon Consultant</p>
</body>
</html>
