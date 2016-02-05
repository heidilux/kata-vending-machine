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
        $this->machine->acceptCoins(['nickel' => 1]);
        $this->assertEquals(5, $this->machine->currentAmount);
        $this->assertEquals('$0.05', $this->machine->display);
        $this->assertEquals([
            'nickel' => 11,
            'dime' => 10,
            'quarter' => 10
        ], $this->machine->bank);
    }

    public function testCustomerInsertsOneDime()
    {
        $this->machine->acceptCoins(['dime' => 1]);
        $this->assertEquals(10, $this->machine->currentAmount);
        $this->assertEquals('$0.10', $this->machine->display);
        $this->assertEquals([
            'nickel' => 10,
            'dime' => 11,
            'quarter' => 10
        ], $this->machine->bank);
    }

    public function testCustomerInsertsOneQuarter()
    {
        $this->machine->acceptCoins(['quarter' => 1]);
        $this->assertEquals(25, $this->machine->currentAmount);
        $this->assertEquals('$0.25', $this->machine->display);
        $this->assertEquals([
            'nickel' => 10,
            'dime' => 10,
            'quarter' => 11
        ], $this->machine->bank);
    }

    public function testCustomerInsertsTwoNickels()
    {
        $this->machine->acceptCoins(['nickel' => 2]);
        $this->assertEquals(10, $this->machine->currentAmount);
        $this->assertEquals('$0.10', $this->machine->display);
        $this->assertEquals([
            'nickel' => 12,
            'dime' => 10,
            'quarter' => 10
        ], $this->machine->bank);
    }

    public function testCustomerInsertsTwoDimes()
    {
        $this->machine->acceptCoins(['dime' => 2]);
        $this->assertEquals(20, $this->machine->currentAmount);
        $this->assertEquals('$0.20', $this->machine->display);
        $this->assertEquals([
            'nickel' => 10,
            'dime' => 12,
            'quarter' => 10
        ], $this->machine->bank);
    }

    public function testCustomerInsertsTwoQuarters()
    {
        $this->machine->acceptCoins(['quarter' => 2]);
        $this->assertEquals(50, $this->machine->currentAmount);
        $this->assertEquals('$0.50', $this->machine->display);
        $this->assertEquals([
            'nickel' => 10,
            'dime' => 10,
            'quarter' => 12
        ], $this->machine->bank);
    }

    public function testCustomerInsertsOnePenny()
    {
        $this->machine->acceptCoins(['penny' => 1]);
        $this->assertEquals(0, $this->machine->currentAmount);
        $this->assertEquals([1 => 'penny'], $this->machine->coinReturnContents);
        $this->assertEquals('INSERT COINS', $this->machine->display);
    }

    public function testCustomerInsertsTwoPennies()
    {
        $this->machine->acceptCoins(['penny' => 2]);
        $this->assertEquals(0, $this->machine->currentAmount);
        $this->assertEquals([2 => 'penny'], $this->machine->coinReturnContents);
        $this->assertEquals('INSERT COINS', $this->machine->display);
    }

    public function testCustomerInsertsOneNickelAndOneDime()
    {
        $this->machine->acceptCoins(['nickel' => 1, 'dime' => 1]);
        $this->assertEquals(15, $this->machine->currentAmount);
        $this->assertEquals('$0.15', $this->machine->display);
        $this->assertEquals([
            'nickel' => 11,
            'dime' => 11,
            'quarter' => 10
        ], $this->machine->bank);
    }

    public function testCustomerInsertsOneNickelAndOneDimeAndOneQuarter()
    {
        $this->machine->acceptCoins(['nickel' => 1, 'dime' => 1, 'quarter' => 1]);
        $this->assertEquals(40, $this->machine->currentAmount);
        $this->assertEquals('$0.40', $this->machine->display);
        $this->assertEquals([
            'nickel' => 11,
            'dime' => 11,
            'quarter' => 11
        ], $this->machine->bank);
    }

}