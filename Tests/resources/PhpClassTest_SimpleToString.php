abstract class Foo extends stdClass
{
    /**
     * @var string
     */
    const FOO = 'theValue';
    /**
     * @var string
     */
    const BAR = 'theOtherValue';
    /**
     * @var int
     */
    public $bar = 1;
    /**
     * - documentation: The ID of the contact that performed the action, if available.
     * May be blank for anonymous activity.
     * @var bool
     */
    public $sample = true;
    /**
     * @var string
     */
    public $noValue;
    /**
     * This method is very useful
     * @date 2012-03-01
     * @return mixed
     */
    public function getMyValue($asString = true, $unusedParameter)
    {
    }
    /**
     * This method is very useless
     * @date 2012-03-01
     * @return void
     */
    public function uselessMethod($uselessParameter = null, $unusedParameter)
    {
    }
}