<?php namespace SamJoyce777\Marketing\Models\SMS;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class SMSSent extends Model implements AuditableContract
{
    use Auditable;

    protected $table = 'sms_sent';

    protected $guarded = ['id'];

    public function sms_template()
    {
        return $this->hasOne(SMSTemplate::class, 'id', 'sms_template_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
