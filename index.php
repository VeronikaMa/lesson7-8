<?php

class Card
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

	public function pay($amount): void
	{
		if ($this->limit >= $amount && $amount <= $this->holderBalance) {
			self::$balanceBank -= $amount;
			$this->holderBalance -= $amount;
		} else {
			echo "Операция не удалась<br>";
		}
	}

	public function refund($amount): void
	{
		self::$balanceBank += $amount;
		$this->holderBalance += $amount;
	}

}

//Сверхоплата по карте
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

//Кредитная карта с процентами
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


//$newCard = new DebitCard('Veronika', "Мир");
//
//echo "Остаток на счете клиента {$newCard->holder}: " . $newCard->getBalanceHolder() . "<br>";
//$newCard->setLimit(1000);
//echo "Ваш лимит: " . $newCard->getLimit() . "<br>";
//echo "Пополнение на 500<br>";
//$newCard->refund(500);
//echo "Остаток на счете клиента: " . $newCard->getBalanceHolder() . "<br>";
//echo "Остаток на счете Банка: " . Card::getBalanceBank() . "<br>";
//
////Снимем деньги
//echo "Снятие на 600<br>";
//$newCard->pay(600);
//echo "Остаток на счете клиента: " . $newCard->getBalanceHolder() . "<br>";
//echo "Остаток на счете Банка: " . Card::getBalanceBank() . "<br>";
//if($newCard->credit != 0){
//	echo "У клиента {$newCard->holder} задолжность: " . $newCard->credit . "<br>";
//}
//
////Гасит кредит
//$newCard->repayCredit(200);
//echo "У клиента {$newCard->holder} задолжность: " . $newCard->credit . "<br>";
//echo "Остаток на счете клиента: " . $newCard->getBalanceHolder() . "<br>";
//echo "Остаток на счете Банка: " . Card::getBalanceBank() . "<br>";



//
$newCard2 = new CreditCard('Dima', "Мир");
//Взятие кредите
$newCard2->setDebet(1000);
echo "Остаток на счете клиента {$newCard2->holder}: " . $newCard2->getBalanceHolder() . "<br>";
$newCard2->setLimit(10000);
echo "Ваш лимит: " . $newCard2->getLimit() . "<br>";
echo "Пополнение на 500<br>";
//$newCard2->refund(500);

echo "Остаток на счете клиента: " . $newCard2->getBalanceHolder() . "<br>";
echo "Остаток на счете Банка: " . Card::getBalanceBank() . "<br>";
echo "Кредит: " . $newCard2->getDebet() . "<br>";
$newCard2->refund(1200);
//Снимем деньги
echo "Снятие на 10000<br>";
$newCard2->pay(10000);
echo "Остаток на счете клиента: " . $newCard2->getBalanceHolder() . "<br>";
echo "Остаток на счете Банка: " . Card::getBalanceBank() . "<br>";