<?php

namespace App\Models;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;

    protected $table= 'tickets';
    protected $fillable= [
       'company_id', 'state', 'ticket_number' , 
        'created_by','module_name', 'description',
        'severity', 'incident_type', 'dev_notes', 'user_comments',
        'attachments'
    ];
    public $timestamps = true;

    /**
     * Get the company that owns the Ticket
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
