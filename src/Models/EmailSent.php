<?php namespace SamJoyce777\Marketing\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class EmailSent extends Model implements AuditableContract
{
    use Auditable;

    protected $table = 'emails_sent';

    protected $guarded = ['id'];

}
