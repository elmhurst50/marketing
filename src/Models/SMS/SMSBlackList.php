<?php namespace SamJoyce777\Marketing\Models\SMS;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class SMSBlackList extends Model implements AuditableContract
{
    use Auditable;

    protected $table = 'sms_black_list';

    protected $guarded = ['id'];

}
