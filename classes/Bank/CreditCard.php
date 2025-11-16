<?php

namespace classes\Bank;

class CreditCard extends Card {
    private int $currentDebet;
    private int $percent = 20;

    public function getProcent(){
        return $this->percent;
    }
    public function setProcent($percent){
        $this->percent = $percent;
    }

    public function getDebet(){
        return $this->currentDebet;
    }
    public function setDebet($amount){
        self::$balanceBank -= $amount;
        $this->currentDebet = $amount+floor($amount*($this->percent/100));
    }


    public function pay($amount): void
    {
        if($this->limit >= $amount && $amount <= $this->currentDebet) {
            self::$balanceBank -= $amount;
            $this->currentDebet -= $amount;
        } else {
            echo "Операция не удалась<br>";
        }
    }

    public function refund($amount): void
    {

        //Вносит 1000, но мы в банк зачисляем 1000, но на счет учитываем процент
        self::$balanceBank += $amount;
        $this->currentDebet -= $amount;
    }

}