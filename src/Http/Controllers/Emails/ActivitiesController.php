<?php

namespace SamJoyce777\Marketing\Http\Controllers\Emails;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use SamJoyce777\Marketing\Managers\Statistics\Emails\ActivitiesStatisticsManager;

class ActivitiesController extends Controller
{
    protected $activities_statistics_manager;

    public function __construct()
    {
        $this->activities_statistics_manager = new ActivitiesStatisticsManager();
    }

    public function index($start_date, $end_date)
    {
        $email_overview_statistics = $this->activities_statistics_manager->emailOverview(Carbon::createFromFormat('Y-m-d', $start_date)->startOfDay(), Carbon::createFromFormat('Y-m-d', $end_date)->endOfDay());

        return view('marketing::emails.activities.index')->with('email_overview_statistics', $email_overview_statistics);
    }

}
