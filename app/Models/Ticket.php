<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table= 'tickets';
    protected $fillable= [
        'state', 'ticket_number' , 
        'created_by','module_name', 'description',
        'severity', 'incident_type', 'dev_notes', 'user_comments',
        'attachments'
    ];
    public $timestamps = true;

}
