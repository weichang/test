<?php

use App\Product;
use App\Order;

class OrderTest extends PHPUnit_Framework_TestCase
{
    protected $order;

    public function setUp()
    {
        $this->order = $this->createOrderWithProducts();
    }

    public function test_order_count()
    {
        //$order = $this->createOrderWithProducts();
        // 計算產品總數
        $this->assertEquals(2,count($this->order->products()));
        $this->assertCount(2,$this->order->products() );

    }

    public function test_order_total()
    {
        $order = $this->createOrderWithProducts();
        // 計算產品訂單總額

        $this->assertEquals(300,$order->total());
    }

    public function createOrderWithProducts(){

        $product = new Product('bmw',100);
        $product2 = new Product('bmw2',200);

        $order = new Order();

        $order->add($product);
        $order->add($product2);

        return $order;
    }

}