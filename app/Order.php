<?php

namespace Ojlinks;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['order_id', 'custom_str1', 'amount', 'order_details'];
}
