<?php

namespace classes\Bank;

class DebitCard extends Card
{

    //Сверх нормы
    private int $overdraft = 100;
    public int $credit = 0;

    public function setLimit($limit = 100): void
    {
        $this->limit = $limit + $this->overdraft;
    }

    public function setOverdraft ($overdraft = 100)
    {
        $this->overdraft = $overdraft;
    }

    public function getOverdraft (): int
    {
        return $this->overdraft;
    }


    public function pay($amount): void
    {

        if ($this->limit >= $amount && $amount <= $this->holderBalance+$this->overdraft) {
            self::$balanceBank -= $amount;
            $this->holderBalance -= $amount;
            if($this->holderBalance<0){
                $this->credit = $this->holderBalance;
                $this->holderBalance = 0;
            }
        } else {
            echo "Операция не удалась<br>";
        }

    }

    public function repayCredit($amount): void
    {
        $this->credit += $amount;
        if($this->credit>0){
            $this->holderBalance += $this->credit;
            $this->credit=0;
        }
        self::$balanceBank += $amount;
    }

}