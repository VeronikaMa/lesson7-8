<?php

namespace classes\Bank;
abstract class Card
{
    protected static int $balanceBank = 10000;

    protected int $holderBalance = 0;
    public string $holder;
    public string $network;
    protected int $limit;

    public function __construct(string $holder, string $network = "visa")
    {
        $this->holder = $holder;
        $this->network = $network;
    }

    public static function getBalanceBank(): int
    {
        return self::$balanceBank;
    }

    public function getBalanceHolder(): int
    {
        return $this->holderBalance;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function setLimit($limit = 100)
    {
        $this->limit = $limit;
    }

    abstract public function pay($amount);

    public function refund($amount): void
    {
        self::$balanceBank += $amount;
        $this->holderBalance += $amount;
    }

}
