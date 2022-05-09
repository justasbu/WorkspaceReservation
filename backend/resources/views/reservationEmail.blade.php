<!DOCTYPE html>
<html>
<body>

<p><b>Your reservation was successful!</b></p>
<p>Workspace: <b>{{$workspace->tableNumber}}</b></p>
<p>Reservation Start Time: <b>{{$reservation->dateFrom}}</b></p>
<p>Reservation End Time:  <b>{{$reservation->dateTo}}</b></p>

<p>Please contact <a href="mailto:support@uc.group">support@uc.group</a> if you need any assistance.</p>
</body>
</html>
