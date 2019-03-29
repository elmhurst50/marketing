<?php namespace SamJoyce777\Marketing\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class EmailMarketing extends Model implements AuditableContract
{
    use Auditable;

    protected $table = 'emails_marketing';

    protected $guarded = ['id'];

}
