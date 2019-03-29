<?php

namespace SamJoyce777\Marketing\Http\Controllers\SMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SamJoyce777\Marketing\Managers\SMS\SMSManager;
use SamJoyce777\Marketing\Models\SMS\SMSReply;

class SMSController extends Controller
{
    protected $sms_manager;

    public function __construct()
    {
        $this->sms_manager = new SMSManager();
    }

    public function reply(Request $request)
    {
        try{
            $mobile_number = trim(preg_replace("/44/", "0", urldecode($request->get('originator')), 1));
            $reply = urldecode($request->get('body'));
            $original_message = urldecode($request->get('clientmessagereference'));
            $reply_date = trim(urldecode($request->get('date')));

            SMSReply::create([
                'mobile_number' => $mobile_number,
                'reply' => $reply,
                'original_message' => $original_message,
                'reply_date' => $reply_date,
                'brand' => 'WB'
            ]);

            if(strtolower($reply) == 'stop') $this->sms_manager->addToBlackList($mobile_number);

        }catch (\Exception $e){
            \Logger::error('sms', 'Could not save sms reply: ' . $e->getMessage() . ' - '. serialize($request->all()));
        }

        \Logger::info('sms', serialize($request->all()));

        die();
    }

    public function index()
    {
        return view('marketing::sms.sms.index');
    }

    public function show($category, $list)
    {
        $sms_provider_class = config('marketing.sms.'.$category.'.'.$list);

        $sms_provider = new $sms_provider_class;

        $message = $sms_provider->createMessage($sms_provider->getDefaultData());

        return view('marketing::sms.sms.show')->with('message', $message);
    }
}
