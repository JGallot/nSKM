<?php
class soapclientd extends soapclient
{
	public $action = false;

    public function __construct($wsdl, $options = array())
	{
        parent::__construct($wsdl, $options);
    }

	public function __doRequest($request, $location, $action, $version, $one_way = 0)
	{
//        echo '<pre>' . htmlspecialchars(str_replace(array ('<ns', '></'), array (PHP_EOL . '<ns', '>'.PHP_EOL.'</'), $request)) . '</pre>';
        $resp = parent::__doRequest($request, $location, $action, $version, $one_way);
		return $resp;
	}

}

$client = new soapclientd('https://uvcenter-adm2.unr-runn.fr/sdk/vimService.wsdl', array ('location' => 'https://uvcenter-adm2.unr-runn.fr/sdk', 'trace' => 1));

try
{
    $request = new stdClass();
    $request->_this = array ('_' => 'ServiceInstance', 'type' => 'ServiceInstance');
    $response = $client->__soapCall('RetrieveServiceContent', array((array)$request));
} catch (Exception $e)
{
    echo $e->getMessage();
    exit;
}
$ret = $response->returnval;

try
{
    $request = new stdClass();
    $request->_this = $ret->sessionManager;
    $request->userName = 'YYYYY';
    $request->password = 'XXXXXXX';
    $response = $client->__soapCall('Login', array((array)$request));
} catch (Exception $e)
{
    echo $e->getMessage();
    exit;
}

$ss1 = new soapvar(array ('name' => 'FolderTraversalSpec'), SOAP_ENC_OBJECT, null, null, 'selectSet', null);
$ss2 = new soapvar(array ('name' => 'DataCenterVMTraversalSpec'), SOAP_ENC_OBJECT, null, null, 'selectSet', null);
$a = array ('name' => 'FolderTraversalSpec', 'type' => 'Folder', 'path' => 'childEntity', 'skip' => false, $ss1, $ss2);

$ss = new soapvar(array ('name' => 'FolderTraversalSpec'), SOAP_ENC_OBJECT, null, null, 'selectSet', null);
$b = array ('name' => 'DataCenterVMTraversalSpec', 'type' => 'Datacenter', 'path' => 'vmFolder', 'skip' => false, $ss);

$res = null;
try
{
    $request = new stdClass();
    $request->_this = $ret->propertyCollector;
    $request->specSet = array (
        'propSet' => array (
            array ('type' => 'VirtualMachine', 'all' => 0, 'pathSet' => array ('name', 'guest.ipAddress', 'guest.guestState', 'runtime.powerState', 'config.hardware.numCPU', 'config.hardware.memoryMB')),
        ),
        'objectSet' => array (
            'obj' => $ret->rootFolder,
            'skip' => false,
            'selectSet' => array (
                new soapvar($a, SOAP_ENC_OBJECT, 'TraversalSpec'),
                new soapvar($b, SOAP_ENC_OBJECT, 'TraversalSpec'),
                ),
            )
        );
    $res = $client->__soapCall('RetrieveProperties', array((array)$request));
} catch (Exception $e)
{
    echo $e->getMessage();
}
echo '<pre>';
print_r($res);

?>
