<?php namespace SamJoyce777\Marketing\Console\Commands\Emails;

use SamJoyce777\Marketing\Models\EmailMarketing;
use Illuminate\Console\Command;

class ImportEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import emails from a csv file';

    protected $list;

    protected $email;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $file = storage_path() . '/emails/import/sent-outlook.csv';

        if (!file_exists($file)) dd('File not found!');

        $current_row = -1;

        if (($handle = fopen($file, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 100000, ",")) !== FALSE) {
                $current_row++;

                if ($current_row < 1) continue;

                if (isset($data[1]) && $this->is_email($data[1])) $this->insertEmail($data[0], $data[1]);

                if (isset($data[4]) && $this->is_email($data[4])) $this->insertEmail($data[3], $data[4]);

                if (isset($data[7]) && $this->is_email($data[7])) $this->insertEmail($data[6], $data[7]);
            }
            fclose($handle);
        }

        $this->info('Complete.');
    }

    /**
     * Inserts the data into the database
     * @param $data
     */
    protected function insertEmail($name, $email)
    {
        $name = $this->getCleanName($name);

        $email = $this->getCleanEmail($email);

        if($email != ''){
            EmailMarketing::updateOrCreate([
                'email' => $email
            ], [
                'name' => $name,
                'email' => $email,
                'group' => 'outlook'
            ]);

            $this->info('Inserted email: ' . $email);
        }

    }

    protected function getCleanName($name){
        $name = str_replace('\'', '', $name);

        $name = ucwords($name);

        $name_array = explode(';', $name);

        if(strpos($name_array[0], '@') > -1) return '';

        return $name_array[0];
    }

    protected function getCleanEmail($email){
        $email = strtolower($email);

        $email_array = explode(';', $email);

        if(strpos($email_array[0], 'britweb') > -1) return '';

        return $email_array[0];
    }

    /**
     * Checks to see if it is a valid email
     * @param $string
     * @return bool
     */
    protected function is_email($string)
    {
        $email = filter_var(filter_var($string, FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);

        if ($email !== false) return true;

        return false;
    }

}
