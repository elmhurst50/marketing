<?php namespace ElmhurstProjects\CommunicationsExampleReal\EmailViewData\Development;

use SamJoyce777\Marketing\EmailViewData\EmailViewDataAbstract;
use SamJoyce777\Marketing\EmailViewData\EmailViewDataInterface;

class ConfirmOrderViewData extends EmailViewDataAbstract implements EmailViewDataInterface
{
    /**
     * Gets the view data based on the order ID, ie via database
     * @param int $order_id
     * @return int
     */
    public function setViewDataByOrderID(int $order_id)
    {
        $this->view_data = [
          'order_id' => $order_id,
          'amount' => '£100'
        ];
   }
}
