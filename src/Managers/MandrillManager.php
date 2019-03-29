<?php namespace SamJoyce777\Marketing\Managers;


use Carbon\Carbon;
use SamJoyce777\Marketing\Models\EmailSent;

class MandrillManager
{
    protected $mandrill_api;

    protected $zip;

    protected $compressed_filename;

    public function __construct()
    {
        $this->mandrill_api = new \Mandrill(env('MANDRILL_KEY'));

        $this->zip = new \ZipArchive();

        $this->compressed_filename = storage_path().'/emails/activity.zip';
    }

    /**
     * check status of report
     * @param String $id
     * @return object
     */
    public function checkReport($id)
    {
        $response = $this->mandrill_api->exports->info($id);

        var_dump($response);

        return (object)$response;
    }

    /**
     * Send the request for an activity report
     * @param Carbon $from
     * @param Carbon $to
     * @return object
     */
    public function requestActivityReport(Carbon $from, Carbon $to)
    {
        $response = $this->mandrill_api->exports->activity(null, $from->toDateTimeString(), $to->toDateTimeString());

        return (object)$response;
    }

    /**
     * Downloads the report from the url provided
     * @param $url
     */
    public function downloadReport($url)
    {
        $report = file_get_contents($url, $this->compressed_filename);

        file_put_contents($this->compressed_filename, $report);

        try{
            $this->zip->open($this->compressed_filename);
            $this->zip->extractTo(storage_path(). '/emails/');
            $this->zip->close();
        }catch(\Exception $e){
            dd($e->getMessage());
        }
    }

    /**
     * Inserts the data from the report stored in storage file
     */
    public function insertReport()
    {
        $current_row = -1;

        if (($handle = fopen(storage_path() . '/emails/activity.csv', "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 100000, ",")) !== FALSE) {
                $current_row++;

                if ($current_row < 1) continue;

                $emailSent = EmailSent::find($data[10]);

                if ($emailSent) $emailSent->update([
                    'opened' => $data[7],
                    'clicked' => $data[8],
                    'sender' => $data[2],
                    'subject' => $data[3],
                    'mandrill_status' => $data[4],
                ]);

            }
        }
    }
}
