<?php

use App\Http\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class InvoiceItems extends Authenticatable implements JWTSubject
{
    use HapApiTokens, HasFactory, Notifiable, HasRoles;
    protected $fillable = [
        'invoice_id',
        'product_name',
        'product_quantity',
        'quantity_type',
        'product_price',
        'product_discount',
        'product_discount_type',
        'product_note',
        'product_amount',
        'product_pricing',
        'product_tax'
    ];
}
