<x-mail::message>
Dear Unicore Online Development Team,

A new support ticket has been submitted by a user, or there has been an update to an existing ticket. Below are the details:

    
<b>Ticket Details: </b> <br>
<ul>
    <li>Ticket Number: {{$ticket->ticket_number}}<br></li>
    <li>Company: {{$user->companyUser->company->company_name}} <br></li>
    <li>User's Name: {{$user->name}} <br></li>
    <li>User's Email: {{$user->email}} <br></li>
    <li>Incident Type: {{$ticket->incident_type}}<br></li>
    <li>Severity: {{$ticket->severity}}<br></li>
    <li>Date and Time of Submission: {{$ticket->created_at->format('Y-m-d H:i:s')}}<br></li>
</ul>
{{-- ⁃	Company: {{$user->companyUser->company->company_name}} <br>
⁃	Ticket Number: {{$ticket->ticket_number}}<br>
⁃	Incident Type: {{$ticket->incident_type}}<br>
⁃	Severity: {{$ticket->severity}}<br>
⁃	Date and Time of Submission: {{$ticket->created_at}}<br> --}}

<p>
<b> Status Update:</b><br>
<li>
    Current Status: {{$ticket->state}}
</li>
<br>
Please review and prioritize this ticket accordingly.<br>

Best Regards,<br>

Unicore Online Support<br>
www.unicoreonline.com

</p>

</x-mail::message>
 