<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $table = 'payment_methods';  // Nome da tabela no banco de dados

    protected $fillable = [
        'code', // Adapte para os campos reais que sua tabela possui
        'name',
        'description',
        'status',
    ];

    // Se você precisa de outras funções ou relacionamentos, adicione conforme necessário
}
