<x-mail::message>
Dear {{$user->name}},
<br>
<p>
We want to inform you that there has been an update on the support ticket you submitted ({{$ticket->ticket_number}}). Our team has been diligently working to address your inquiry, and we want to keep you informed about the progress.
<br>

<b>Latest Update:</b><br>
Status Update: {{$ticket->state}}<br><br>

{{-- ⁃	Company: {{$user->companyUser->company->company_name}} <br>
⁃	Ticket Number: {{$ticket->ticket_number}}<br>
⁃	Incident Type: {{$ticket->incident_type}}<br>
⁃	Severity: {{$ticket->severity}}<br>
⁃	Date and Time of Submission: {{$ticket->created_at}}<br> --}}

<b>Reference Information:</b><br>
Please login and view the same ticket number ({{$ticket->ticket_number}}) in any future communication regarding this matter. It helps us track and manage your request more efficiently. You can leave your comments on the updated ticket.
<br><br>
Best Regards,
<br>

Unicore Online Development team
<br>
www.unicoreonline.com

</p>

</x-mail::message>
