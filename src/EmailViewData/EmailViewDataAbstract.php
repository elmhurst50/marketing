<?php namespace SamJoyce777\Marketing\EmailViewData;

/**
 * Is in charge of creating the data for the email creator to use within the view
 * Class Email
 * @package SamJoyce777\Marketing\Emails
 */
abstract class EmailViewDataAbstract
{
    protected $view_data = [];

    /**
     * This allows you to set the view data as an array directly
     * @param array $view_data
     * @return $this
     */
    public function setViewDataByArray(array $view_data)
    {
        $this->view_data = $view_data;

        return $this;
    }

    /**
     * Gets the view data
     * @return array
     */
    public function getViewData(): array
    {
        return $this->view_data;
    }
}
