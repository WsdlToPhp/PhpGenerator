interface Foo extends stdClass
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
    /**
     * @var bool
     */
    /**
     * This method is very useful
     * @date 2012-03-01
     * @return mixed
     */
    public function getMyValue($asString = true, $unusedParameter);
    /**
     * This method is very useless
     * @date 2012-03-01
     * @return void
     */
    public function uselessMethod($uselessParameter = null, $unusedParameter);
}