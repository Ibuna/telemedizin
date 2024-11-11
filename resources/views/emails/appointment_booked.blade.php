<!DOCTYPE html>
<html>
<head>
    <title>Appointment Booked</title>
</head>
<body>
    <h1>Your Appointment is Booked</h1>
    <p>Dear {{ $appointment->patient_name }},</p>
    <p>Your appointment with Dr. {{ $appointment->doctor->name }} on {{ $appointment->date_time }} has been successfully booked.</p>
    <p>Thank you for using our service.</p>
</body>
</html>