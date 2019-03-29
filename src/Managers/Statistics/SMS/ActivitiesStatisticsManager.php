<?php namespace SamJoyce777\Marketing\Managers\Statistics\SMS;

use Carbon\Carbon;
use SamJoyce777\Marketing\Models\SMS\SMSSent;

class ActivitiesStatisticsManager
{
    public function smsOverview(Carbon $start_date, Carbon $end_date)
    {
        $smssSent = SMSSent::select([
            \DB::raw('sms_identifier'),
            \DB::raw('COUNT(id) as total_sent'),
        ])
            ->whereBetween('sent_at', [$start_date, $end_date])
            ->groupby('sms_identifier')
            ->get();

        return $this->addSMSInformation($smssSent);
    }

    /**
     * Adds the fields from the class to the query result
     * @param $smssSent
     * @return mixed
     */
    protected function addSMSInformation($smssSent)
    {
        foreach ($smssSent as $smsSent) {
            $sms_class = config('marketing.sms.' . $smsSent->sms_identifier);

            $sms_provider = new $sms_class();

            $smsSent->title = $sms_provider->getTitle();

            $smsSent->description = $sms_provider->getDescription();
        }

        return $smssSent;
    }
}
