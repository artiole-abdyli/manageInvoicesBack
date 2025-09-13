<?php

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class Invoice extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    protected $fillable = [
        'status',
        'type',
        'contact_id',
        'contact_address',
        'subject',
        'number',
        'date',
        'due_date',
        'delivery_date',
        'header_text',
        'footer_text',
        'net_amount',
        'sales_tax',
        'total_amount'
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
