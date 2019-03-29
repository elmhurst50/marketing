<?php namespace SamJoyce777\Marketing\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class EmailBlackList extends Model implements AuditableContract
{
    use Auditable;

    protected $table = 'email_black_list';

    protected $guarded = ['id'];

}
