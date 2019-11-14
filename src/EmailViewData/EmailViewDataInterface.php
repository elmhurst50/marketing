<?php namespace SamJoyce777\Marketing\EmailViewData;

interface EmailViewDataInterface
{
    public function setViewDataByArray(array $view_data);

    public function getViewData():array;
}