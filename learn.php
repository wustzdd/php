<?php
/**
 * Design Patterns:
 * Bridge Pattern
 * Adapter Pattern
 * Decorator Pattern
 * Single Pattern
 * Factory Pattern
 * Observer Pattern
 **/

/**
	Bridge Pattern
**/
interface software{
    public function start();   
}
class weixin implements software{
    public function start() {
        echo '<br>start weixin';
    }
}
class qq implements software{
    public function start() {
        echo '<br>start qq';
    }
}

abstract class system{
   abstract public function run(software $soft);
}
class ios extends system{
    public function run(software $soft) {
        echo '<br>ios system:';
        $soft->start();
    }
}
class android extends system{
    public function run(software $soft) {
        echo '<br>android system:';
        $soft->start();
    }
}

echo '<br>--- Bridge Pattern ---<br>';
$weixin = new weixin();
$qq = new qq();

$ios = new ios();
$ios->run($weixin);
$ios->run($qq);

$android = new android();
$android->run($weixin);
$android->run($qq);
echo "<br>";



/**
	Adapter Pattern
**/
//老的代码     
class User {    
    private $name;    
    function __construct($name) {    
        $this->name = $name;    
    }    
    public function getName() {    
        return $this->name;    
    }    
}   
//新代码，开放平台标准接口    
interface UserInterface {    
    function getUserName();    
}    
class UserInfo implements UserInterface {    
    protected $user;    
    function __construct($user) {    
        $this->user = $user;    
    }    
    public function getUserName() {    
        return $this->user->getName();    
    }    
}

echo '<br>--- Adapter Pattern ---<br>';
$olduser = new User('张三');    
echo $olduser->getName()."<br>";    
$newuser = new UserInfo($olduser);    
echo $newuser->getUserName()."<br>";  



/**
    Decorator Pattern
 **/
//被装饰者基类
interface Component
{
    public function operation();
}
//具体装饰者类
class ConcreteComponent implements Component
{
    public function operation()
    {
        echo '<br>do operation'.PHP_EOL;
    }
}
//装饰者基类
abstract class Decorator implements Component
{
    protected $component;
    public function __construct(Component $component)
    {
        $this->component = $component;
    }
    public function operation()
    {
        $this->component->operation();
    }
}
//具体装饰类A
class ConcreteDecoratorA extends Decorator {
    public function __construct(Component $component) {
        parent::__construct($component);
    }
    public function operation() {
        parent::operation();
        $this->addedOperationA();   //  新增加的操作
    }
    public function addedOperationA() {
        echo '<br>Add Operation A '.PHP_EOL;
    }
}
//具体装饰类B
class ConcreteDecoratorB extends Decorator {
    public function __construct(Component $component) {
        parent::__construct($component);
    }
    public function operation() {
        parent::operation();
        $this->addedOperationB();
    }
    public function addedOperationB() {
        echo '<br>Add Operation B '.PHP_EOL;
    }
}

class Client {
    public static function main() {
        /*
        do operation
        Add Operation A
        */
        $decoratorA = new ConcreteDecoratorA(new ConcreteComponent());
        $decoratorA->operation();
        /*
        do operation
        Add Operation A 
        Add Operation B  
        */
        $decoratorB = new ConcreteDecoratorB($decoratorA);
        $decoratorB->operation();
    }
}
echo '<br>--- Decorator Pattern ---<br>';
Client::main();



/** Single Pattern
 * 设计模式之单例模式
 * $_instance必须声明为静态的私有变量
 * 构造函数必须声明为私有,防止外部程序new类从而失去单例模式的意义
 * getInstance()方法必须设置为公有的,必须调用此方法以返回实例的一个引用
 * ::操作符只能访问静态变量和静态函数
 * new对象都会消耗内存
 * 使用场景:最常用的地方是数据库连接。
 * 使用单例模式生成一个对象后，该对象可以被其它众多对象所使用。
 */
class man
{
    //保存例实例在此属性中
    private static $_instance;

    //构造函数声明为private,防止直接创建对象
    private function __construct()
    {
        echo '我被实例化了！';
    }

    //单例方法
    public static function get_instance()
    {
        if(!isset(self::$_instance))
        {
            self::$_instance=new self();
        }
        return self::$_instance;
    }

    //阻止用户复制对象实例
    private function __clone()
    {
        trigger_error('Clone is not allow' ,E_USER_ERROR);
    }

    function test()
    {
        echo("test");

    }
}
echo "<br>--- Single Pattern ---<br>";
// 这个写法会出错，因为构造方法被声明为private
//$test = new man;

// 下面将得到Example类的单例对象
$test = man::get_instance();
$test->test();

// 复制对象将导致一个E_USER_ERROR.
//$test_clone = clone $test;



/**
    Factory Pattern
**/

abstract class Operation{
    //抽象方法不能包含函数体
    abstract public function getValue($num1,$num2);//强烈要求子类必须实现该功能函数
}
/**
 * 加法类
 */
class OperationAdd extends Operation {
    public function getValue($num1,$num2){
        return $num1+$num2;
    }
}
/**
 * 减法类
 */
class OperationSub extends Operation {
    public function getValue($num1,$num2){
        return $num1-$num2;
    }
}
/**
 * 乘法类
 */
class OperationMul extends Operation {
    public function getValue($num1,$num2){
        return $num1*$num2;
    }
}
/**
 * 除法类
 */
class OperationDiv extends Operation {
    public function getValue($num1,$num2){
        try {
            if ($num2==0){
                throw new Exception("除数不能为0");
            }else {
                return $num1/$num2;
            }
        }catch (Exception $e){
            echo "错误信息：".$e->getMessage();
        }
    }
}
/**
 * 工程类，主要用来创建对象
 * 功能：根据输入的运算符号，工厂就能实例化出合适的对象
 *
 */
class Factory{
    public static function createObj($operate){
        switch ($operate){
            case '+':
                return new OperationAdd();
                break;
            case '-':
                return new OperationSub();
                break;
            case '*':
                return new OperationMul();
                break;
            case '/':
                return new OperationDiv();
                break;
        }
    }
}
echo "<br>--- Factory Pattern ---<br>";
$test=Factory::createObj('+');
$result=$test->getValue(23,0);
echo $result;



// Example implementation of Observer design pattern:
class MyObserver1 implements SplObserver {
    public function update(SplSubject $subject) {
        echo __CLASS__ . ' - ' . $subject->getName();
    }
}

class MyObserver2 implements SplObserver {
    public function update(SplSubject $subject) {
        echo __CLASS__ . ' - ' . $subject->getName();
    }
}

class MySubject implements SplSubject {
    private $_observers;
    private $_name;

    public function __construct($name) {
        $this->_observers = new SplObjectStorage();
        $this->_name = $name;
    }

    public function attach(SplObserver $observer) {
        $this->_observers->attach($observer);
    }

    public function detach(SplObserver $observer) {
        $this->_observers->detach($observer);
    }

    public function notify() {
        foreach ($this->_observers as $observer) {
            $observer->update($this);
        }
    }

    public function getName() {
        return $this->_name;
    }
}
echo "<br>--- Observer Pattern ---<br>";
$observer1 = new MyObserver1();
$observer2 = new MyObserver2();

$subject = new MySubject("test");

$subject->attach($observer1);
$subject->attach($observer2);
$subject->notify();

/* 
will output:

MyObserver1 - test
MyObserver2 - test
*/

$subject->detach($observer2);
$subject->notify();

/* 
will output:

MyObserver1 - test
*/
