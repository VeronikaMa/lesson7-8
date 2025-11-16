<?php


spl_autoload_register(function($classes){

   $classes_path = __DIR__ . "/".str_replace('\\', DIRECTORY_SEPARATOR, $classes) . '.php';

    if(file_exists($classes_path)){
       require_once $classes_path;
   }
});


use classes\Bank\Card;
use classes\Bank\CreditCard;
use classes\Bank\DebitCard;
use classes\Notification\SMS;
use classes\Notification\Email;

$newCard = new DebitCard('Veronika', "Мир");

echo "Остаток на счете клиента {$newCard->holder}: " . $newCard->getBalanceHolder() . "<br>";
$newCard->setLimit(1000);
echo "Ваш лимит: " . $newCard->getLimit() . "<br>";
echo "Пополнение на 500<br>";
$newCard->refund(500);
echo "Остаток на счете клиента: " . $newCard->getBalanceHolder() . "<br>";
echo "Остаток на счете Банка: " . Card::getBalanceBank() . "<br>";

//Снимем деньги
echo "Снятие на 600<br>";
$newCard->pay(600);
echo "Остаток на счете клиента: " . $newCard->getBalanceHolder() . "<br>";
echo "Остаток на счете Банка: " . Card::getBalanceBank() . "<br>";
if($newCard->credit != 0){
	echo "У клиента {$newCard->holder} задолжность: " . $newCard->credit . "<br>";
}

//Гасит кредит
$newCard->repayCredit(200);
echo "У клиента {$newCard->holder} задолжность: " . $newCard->credit . "<br>";
echo "Остаток на счете клиента: " . $newCard->getBalanceHolder() . "<br>";
echo "Остаток на счете Банка: " . Card::getBalanceBank() . "<br>";

echo "================================<br>";

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


echo "=====================================================<br>";

$sendSms = new SMS("+799-999-999-99");
$sendSms->notify("Всем Привет!");
$sendSms->logMessageToDB();
$sendSms->getSendTime();

$sendSms->notify("Проверка времени");
$sendSms->getSendTime();
sleep(5);
$sendSms->notify("Проверка времени2");
$sendSms->getSendTime();

$sendEmail = new Email("example@example.com");
$sendEmail->notify("Всем Пока!");
$sendEmail->logMessageToDB();