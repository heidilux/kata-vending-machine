<?php

class VendingMachineClassTest extends PHPUnit_Framework_TestCase
{
    protected $machine;

    public function setUp()
    {
        $this->machine = new VendingMachine();
    }

    public function testInitialStateOfVendingMachine()
    {
        $this->assertEquals('INSERT COINS', $this->machine->display);
        $this->assertEquals(0, $this->machine->currentAmount);
        $this->assertEquals([], $this->machine->coinReturnContents);
        $this->assertEquals([
            'nickel' => 10,
            'dime' => 10,
            'quarter' => 10
        ], $this->machine->bank);
    }

    public function testCustomerInsertsOneNickel()
    {
        $this->machine->acceptCoins([1 => 'nickel']);
        $this->assertEquals(5, $this->machine->currentAmount);
        $this->assertEquals('$0.05', $this->machine->display);
    }

    public function testCustomerInsertsOneDime()
    {
        $this->machine->acceptCoins([1 => 'dime']);
        $this->assertEquals(10, $this->machine->currentAmount);
        $this->assertEquals('$0.10', $this->machine->display);
    }

    public function testCustomerInsertsOneQuarter()
    {
        $this->machine->acceptCoins([1 => 'quarter']);
        $this->assertEquals(25, $this->machine->currentAmount);
        $this->assertEquals('$0.25', $this->machine->display);
    }
}