<?php namespace SamJoyce777\Marketing\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class EmailBounceList extends Model implements AuditableContract
{
    use Auditable;

    protected $table = 'email_bounce_list';

    protected $guarded = ['id'];

}
