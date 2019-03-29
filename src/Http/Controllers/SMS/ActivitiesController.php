<?php

namespace SamJoyce777\Marketing\Http\Controllers\SMS;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use SamJoyce777\Marketing\Managers\Statistics\SMS\ActivitiesStatisticsManager;
use SamJoyce777\Marketing\Models\SMS\SMSReply;

class ActivitiesController extends Controller
{
    protected $activities_statistics_manager;

    public function __construct()
    {
        $this->activities_statistics_manager = new ActivitiesStatisticsManager();
    }

    public function index($start_date, $end_date)
    {
        $sms_overview_statistics = $this->activities_statistics_manager->smsOverview(Carbon::createFromFormat('Y-m-d', $start_date)->startOfDay(), Carbon::createFromFormat('Y-m-d', $end_date)->endOfDay());

        return view('marketing::sms.activities.index')->with('sms_overview_statistics', $sms_overview_statistics);
    }

    public function replies($start_date, $end_date)
    {
        $smsReplies = SMSReply::whereBetween('created_at', [Carbon::createFromFormat('Y-m-d', $start_date)->startOfDay(), Carbon::createFromFormat('Y-m-d', $end_date)->endOfDay()])->get();

        return view('marketing::sms.activities.replies')->with('smsReplies', $smsReplies);
    }
}
