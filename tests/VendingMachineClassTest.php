<?php

class VendingMachineClassTest extends PHPUnit_Framework_TestCase
{
    protected $machine;

    public function setUp()
    {
        $this->machine = new VendingMachine();
    }

    public function testInitialState()
    {
        $this->assertEquals('INSERT COINS', $this->machine->display);
        $this->assertEquals([
            'nickel' => 10,
            'dime' => 10,
            'quarter' => 10
        ], $this->machine->bank);

    }
}