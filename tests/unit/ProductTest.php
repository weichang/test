<?
use App\Product;
class ProductTest extends PHPUnit_Framework_TestCase
{
    protected $product;

    public function setUp()
    {
       $this->product = new Product('Test',59);
    }

    function testAProductHasName()
    {

        $this->assertEquals('Test',$this->product->name());
    }


    function testAProductHasCost()
    {

        $this->assertEquals( 59 ,$this->product->cost());
    }
}