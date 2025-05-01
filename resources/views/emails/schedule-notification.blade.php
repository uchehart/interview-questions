<!DOCTYPE html>
<html>
<head>
    <title>Irrigation Schedule Notification</title>
</head>
<body>
    <h1>Irrigation Schedule {{ ucfirst($action) }}</h1>
    <p>Hello Admin,</p>
    <p>This is to notify you that an irrigation schedule has been {{ $action }}.</p>

    <h2>Schedule Details:</h2>
    <ul>
        <li><strong>Zone:</strong> {{ $zone->name }} ({{ $zone->area }})</li>
        <li><strong>Start Time:</strong> {{ $schedule->start_time }}</li>
        <li><strong>Duration:</strong> {{ $schedule->duration }}</li>
        <li><strong>Days of Week:</strong> {{ implode(', ', $schedule->days_of_week) }}</li>
    </ul>

    <p>Thank you,<br>Irrigation System</p>
</body>
</html>
