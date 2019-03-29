<?php namespace SamJoyce777\Marketing\Managers\Statistics\Emails;

use Carbon\Carbon;
use SamJoyce777\Marketing\Models\EmailSent;

class ActivitiesStatisticsManager
{
    public function emailOverview(Carbon $start_date, Carbon $end_date)
    {
        $emailsSent = EmailSent::select([
            \DB::raw('email_identifier'),
            \DB::raw('COUNT(id) as total_attempted'),
            \DB::raw('SUM(CASE WHEN spam > 0 THEN 1 ELSE 0 END) as total_spam'),
            \DB::raw('SUM(CASE WHEN opened > 0 THEN 1 ELSE 0 END) as total_opened'),
            \DB::raw('SUM(CASE WHEN clicked > 0 THEN 1 ELSE 0 END) as total_clicked'),
            \DB::raw('SUM(CASE WHEN mandrill_status = "bounced" THEN 1 ELSE 0 END) as total_bounced'),
            \DB::raw('SUM(CASE WHEN mandrill_status = "soft-bounced" THEN 1 ELSE 0 END) as total_soft_bounced'),
            \DB::raw('SUM(CASE WHEN mandrill_status = "rejected" THEN 1 ELSE 0 END) as total_rejected'),
            \DB::raw('SUM(CASE WHEN mandrill_status = "sent" THEN 1 ELSE 0 END) as total_sent'),
        ])
            ->whereBetween('sent_at', [$start_date, $end_date])
            ->groupby('email_identifier')
            ->get();

        return $this->addEmailInformation($emailsSent);
    }

    /**
     * Adds the fields from the class to the query result
     * @param $emailsSent
     * @return mixed
     */
    protected function addEmailInformation($emailsSent)
    {
        foreach ($emailsSent as $emailSent) {
            $email_class = config('marketing.emails.' . $emailSent->email_identifier);

            $email_provider = new $email_class();

            $emailSent->title = $email_provider->getTitle();

            $emailSent->description = $email_provider->getDescription();
        }

        return $emailsSent;
    }
}
