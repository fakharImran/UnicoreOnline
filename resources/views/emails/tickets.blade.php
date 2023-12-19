<x-mail::message>
Dear {{$user->name}},

This is to confirm that we have received your support request, and a ticket has been generated for you. Your satisfaction is our top priority, and we appreciate your patience as we work to address your inquiry.

<b>Ticket Details: </b> <br>
<ul>
    <li>Company: {{$user->companyUser->company->company_name}} <br></li>
    <li>Ticket Number: {{$ticket->ticket_number}}<br></li>
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
<b> Next Steps:</b><br>
Our support team has been notified of your request and will begin investigating the matter promptly. You can expect further communication as we work to resolve your issue.

<b>Reference Information: </b><br>
Please use the following ticket number in any future correspondence related to this issue: {{$ticket->ticket_number}}

<b>Status Updates: </b><br>
We will keep you informed about the status of your ticket through regular updates. You will receive notifications when there are any changes in the status, assignment, or resolution of your request.

<b>Estimated Response Time:</b><br>
Our team strives to address all inquiries in a timely manner. An initial response from our support team can be expected within 2 business days.


Best Regards, <br>
Unicore Online Development team

www.unicoreonline.com 
</p>

{{-- 
Thanks,<br>
{{ config('app.name') }} --}}
</x-mail::message>
