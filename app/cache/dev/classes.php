<?php 
namespace Symfony\Component\EventDispatcher
{
interface EventSubscriberInterface
{
public static function getSubscribedEvents();
}
}
namespace Symfony\Component\HttpKernel\EventListener
{
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
abstract class SessionListener implements EventSubscriberInterface
{
public function onKernelRequest(GetResponseEvent $event)
{
if (!$event->isMasterRequest()) {
return;
}
$request = $event->getRequest();
$session = $this->getSession();
if (null === $session || $request->hasSession()) {
return;
}
$request->setSession($session);
}
public static function getSubscribedEvents()
{
return array(
KernelEvents::REQUEST => array('onKernelRequest', 128),
);
}
abstract protected function getSession();
}
}
namespace Symfony\Bundle\FrameworkBundle\EventListener
{
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\EventListener\SessionListener as BaseSessionListener;
class SessionListener extends BaseSessionListener
{
private $container;
public function __construct(ContainerInterface $container)
{
$this->container = $container;
}
protected function getSession()
{
if (!$this->container->has('session')) {
return;
}
return $this->container->get('session');
}
}
}
namespace Symfony\Component\HttpFoundation\Session\Storage
{
use Symfony\Component\HttpFoundation\Session\SessionBagInterface;
interface SessionStorageInterface
{
public function start();
public function isStarted();
public function getId();
public function setId($id);
public function getName();
public function setName($name);
public function regenerate($destroy = false, $lifetime = null);
public function save();
public function clear();
public function getBag($name);
public function registerBag(SessionBagInterface $bag);
public function getMetadataBag();
}
}
namespace Symfony\Component\HttpFoundation\Session\Storage
{
use Symfony\Component\HttpFoundation\Session\SessionBagInterface;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\NativeSessionHandler;
use Symfony\Component\HttpFoundation\Session\Storage\Proxy\AbstractProxy;
use Symfony\Component\HttpFoundation\Session\Storage\Proxy\NativeProxy;
use Symfony\Component\HttpFoundation\Session\Storage\Proxy\SessionHandlerProxy;
class NativeSessionStorage implements SessionStorageInterface
{
protected $bags;
protected $started = false;
protected $closed = false;
protected $saveHandler;
protected $metadataBag;
public function __construct(array $options = array(), $handler = null, MetadataBag $metaBag = null)
{
$options += array('cache_limiter'=>'','use_cookies'=> 1,
);
if (\PHP_VERSION_ID >= 50400) {
session_register_shutdown();
} else {
register_shutdown_function('session_write_close');
}
$this->setMetadataBag($metaBag);
$this->setOptions($options);
$this->setSaveHandler($handler);
}
public function getSaveHandler()
{
return $this->saveHandler;
}
public function start()
{
if ($this->started) {
return true;
}
if (\PHP_VERSION_ID >= 50400 && \PHP_SESSION_ACTIVE === session_status()) {
throw new \RuntimeException('Failed to start the session: already started by PHP.');
}
if (\PHP_VERSION_ID < 50400 && !$this->closed && isset($_SESSION) && session_id()) {
throw new \RuntimeException('Failed to start the session: already started by PHP ($_SESSION is set).');
}
if (ini_get('session.use_cookies') && headers_sent($file, $line)) {
throw new \RuntimeException(sprintf('Failed to start the session because headers have already been sent by "%s" at line %d.', $file, $line));
}
if (!session_start()) {
throw new \RuntimeException('Failed to start the session');
}
$this->loadSession();
if (!$this->saveHandler->isWrapper() && !$this->saveHandler->isSessionHandlerInterface()) {
$this->saveHandler->setActive(true);
}
return true;
}
public function getId()
{
return $this->saveHandler->getId();
}
public function setId($id)
{
$this->saveHandler->setId($id);
}
public function getName()
{
return $this->saveHandler->getName();
}
public function setName($name)
{
$this->saveHandler->setName($name);
}
public function regenerate($destroy = false, $lifetime = null)
{
if (\PHP_VERSION_ID >= 50400 && \PHP_SESSION_ACTIVE !== session_status()) {
return false;
}
if (\PHP_VERSION_ID < 50400 &&''=== session_id()) {
return false;
}
if (headers_sent()) {
return false;
}
if (null !== $lifetime) {
ini_set('session.cookie_lifetime', $lifetime);
}
if ($destroy) {
$this->metadataBag->stampNew();
}
$isRegenerated = session_regenerate_id($destroy);
$this->loadSession();
return $isRegenerated;
}
public function save()
{
session_write_close();
if (!$this->saveHandler->isWrapper() && !$this->saveHandler->isSessionHandlerInterface()) {
$this->saveHandler->setActive(false);
}
$this->closed = true;
$this->started = false;
}
public function clear()
{
foreach ($this->bags as $bag) {
$bag->clear();
}
$_SESSION = array();
$this->loadSession();
}
public function registerBag(SessionBagInterface $bag)
{
if ($this->started) {
throw new \LogicException('Cannot register a bag when the session is already started.');
}
$this->bags[$bag->getName()] = $bag;
}
public function getBag($name)
{
if (!isset($this->bags[$name])) {
throw new \InvalidArgumentException(sprintf('The SessionBagInterface %s is not registered.', $name));
}
if (!$this->started && $this->saveHandler->isActive()) {
$this->loadSession();
} elseif (!$this->started) {
$this->start();
}
return $this->bags[$name];
}
public function setMetadataBag(MetadataBag $metaBag = null)
{
if (null === $metaBag) {
$metaBag = new MetadataBag();
}
$this->metadataBag = $metaBag;
}
public function getMetadataBag()
{
return $this->metadataBag;
}
public function isStarted()
{
return $this->started;
}
public function setOptions(array $options)
{
if (headers_sent() || (\PHP_VERSION_ID >= 50400 && \PHP_SESSION_ACTIVE === session_status())) {
return;
}
$validOptions = array_flip(array('cache_expire','cache_limiter','cookie_domain','cookie_httponly','cookie_lifetime','cookie_path','cookie_secure','entropy_file','entropy_length','gc_divisor','gc_maxlifetime','gc_probability','hash_bits_per_character','hash_function','lazy_write','name','referer_check','serialize_handler','use_strict_mode','use_cookies','use_only_cookies','use_trans_sid','upload_progress.enabled','upload_progress.cleanup','upload_progress.prefix','upload_progress.name','upload_progress.freq','upload_progress.min_freq','url_rewriter.tags','sid_length','sid_bits_per_character','trans_sid_hosts','trans_sid_tags',
));
foreach ($options as $key => $value) {
if (isset($validOptions[$key])) {
ini_set('url_rewriter.tags'!== $key ?'session.'.$key : $key, $value);
}
}
}
public function setSaveHandler($saveHandler = null)
{
if (!$saveHandler instanceof AbstractProxy &&
!$saveHandler instanceof NativeSessionHandler &&
!$saveHandler instanceof \SessionHandlerInterface &&
null !== $saveHandler) {
throw new \InvalidArgumentException('Must be instance of AbstractProxy or NativeSessionHandler; implement \SessionHandlerInterface; or be null.');
}
if (!$saveHandler instanceof AbstractProxy && $saveHandler instanceof \SessionHandlerInterface) {
$saveHandler = new SessionHandlerProxy($saveHandler);
} elseif (!$saveHandler instanceof AbstractProxy) {
$saveHandler = \PHP_VERSION_ID >= 50400 ?
new SessionHandlerProxy(new \SessionHandler()) : new NativeProxy();
}
$this->saveHandler = $saveHandler;
if (headers_sent() || (\PHP_VERSION_ID >= 50400 && \PHP_SESSION_ACTIVE === session_status())) {
return;
}
if ($this->saveHandler instanceof \SessionHandlerInterface) {
if (\PHP_VERSION_ID >= 50400) {
session_set_save_handler($this->saveHandler, false);
} else {
session_set_save_handler(
array($this->saveHandler,'open'),
array($this->saveHandler,'close'),
array($this->saveHandler,'read'),
array($this->saveHandler,'write'),
array($this->saveHandler,'destroy'),
array($this->saveHandler,'gc')
);
}
}
}
protected function loadSession(array &$session = null)
{
if (null === $session) {
$session = &$_SESSION;
}
$bags = array_merge($this->bags, array($this->metadataBag));
foreach ($bags as $bag) {
$key = $bag->getStorageKey();
$session[$key] = isset($session[$key]) ? $session[$key] : array();
$bag->initialize($session[$key]);
}
$this->started = true;
$this->closed = false;
}
}
}
namespace Symfony\Component\HttpFoundation\Session\Storage
{
use Symfony\Component\HttpFoundation\Session\Storage\Handler\NativeSessionHandler;
use Symfony\Component\HttpFoundation\Session\Storage\Proxy\AbstractProxy;
class PhpBridgeSessionStorage extends NativeSessionStorage
{
public function __construct($handler = null, MetadataBag $metaBag = null)
{
$this->setMetadataBag($metaBag);
$this->setSaveHandler($handler);
}
public function start()
{
if ($this->started) {
return true;
}
$this->loadSession();
if (!$this->saveHandler->isWrapper() && !$this->saveHandler->isSessionHandlerInterface()) {
$this->saveHandler->setActive(true);
}
return true;
}
public function clear()
{
foreach ($this->bags as $bag) {
$bag->clear();
}
$this->loadSession();
}
}
}
namespace Symfony\Component\HttpFoundation\Session\Storage\Handler
{
if (\PHP_VERSION_ID >= 50400) {
class NativeSessionHandler extends \SessionHandler
{
}
} else {
class NativeSessionHandler
{
}
}
}
namespace Symfony\Component\HttpFoundation\Session\Storage\Handler
{
class NativeFileSessionHandler extends NativeSessionHandler
{
public function __construct($savePath = null)
{
if (null === $savePath) {
$savePath = ini_get('session.save_path');
}
$baseDir = $savePath;
if ($count = substr_count($savePath,';')) {
if ($count > 2) {
throw new \InvalidArgumentException(sprintf('Invalid argument $savePath \'%s\'', $savePath));
}
$baseDir = ltrim(strrchr($savePath,';'),';');
}
if ($baseDir && !is_dir($baseDir) && !@mkdir($baseDir, 0777, true) && !is_dir($baseDir)) {
throw new \RuntimeException(sprintf('Session Storage was not able to create directory "%s"', $baseDir));
}
ini_set('session.save_path', $savePath);
ini_set('session.save_handler','files');
}
}
}
namespace Symfony\Component\HttpFoundation\Session\Storage\Proxy
{
abstract class AbstractProxy
{
protected $wrapper = false;
protected $active = false;
protected $saveHandlerName;
public function getSaveHandlerName()
{
return $this->saveHandlerName;
}
public function isSessionHandlerInterface()
{
return $this instanceof \SessionHandlerInterface;
}
public function isWrapper()
{
return $this->wrapper;
}
public function isActive()
{
if (\PHP_VERSION_ID >= 50400) {
return $this->active = \PHP_SESSION_ACTIVE === session_status();
}
return $this->active;
}
public function setActive($flag)
{
if (\PHP_VERSION_ID >= 50400) {
throw new \LogicException('This method is disabled in PHP 5.4.0+');
}
$this->active = (bool) $flag;
}
public function getId()
{
return session_id();
}
public function setId($id)
{
if ($this->isActive()) {
throw new \LogicException('Cannot change the ID of an active session');
}
session_id($id);
}
public function getName()
{
return session_name();
}
public function setName($name)
{
if ($this->isActive()) {
throw new \LogicException('Cannot change the name of an active session');
}
session_name($name);
}
}
}
namespace Symfony\Component\HttpFoundation\Session\Storage\Proxy
{
class SessionHandlerProxy extends AbstractProxy implements \SessionHandlerInterface
{
protected $handler;
public function __construct(\SessionHandlerInterface $handler)
{
$this->handler = $handler;
$this->wrapper = ($handler instanceof \SessionHandler);
$this->saveHandlerName = $this->wrapper ? ini_get('session.save_handler') :'user';
}
public function open($savePath, $sessionName)
{
$return = (bool) $this->handler->open($savePath, $sessionName);
if (true === $return) {
$this->active = true;
}
return $return;
}
public function close()
{
$this->active = false;
return (bool) $this->handler->close();
}
public function read($sessionId)
{
return (string) $this->handler->read($sessionId);
}
public function write($sessionId, $data)
{
return (bool) $this->handler->write($sessionId, $data);
}
public function destroy($sessionId)
{
return (bool) $this->handler->destroy($sessionId);
}
public function gc($maxlifetime)
{
return (bool) $this->handler->gc($maxlifetime);
}
}
}
namespace Symfony\Component\HttpFoundation\Session
{
use Symfony\Component\HttpFoundation\Session\Storage\MetadataBag;
interface SessionInterface
{
public function start();
public function getId();
public function setId($id);
public function getName();
public function setName($name);
public function invalidate($lifetime = null);
public function migrate($destroy = false, $lifetime = null);
public function save();
public function has($name);
public function get($name, $default = null);
public function set($name, $value);
public function all();
public function replace(array $attributes);
public function remove($name);
public function clear();
public function isStarted();
public function registerBag(SessionBagInterface $bag);
public function getBag($name);
public function getMetadataBag();
}
}
namespace Symfony\Component\HttpFoundation\Session
{
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBagInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface;
class Session implements SessionInterface, \IteratorAggregate, \Countable
{
protected $storage;
private $flashName;
private $attributeName;
public function __construct(SessionStorageInterface $storage = null, AttributeBagInterface $attributes = null, FlashBagInterface $flashes = null)
{
$this->storage = $storage ?: new NativeSessionStorage();
$attributes = $attributes ?: new AttributeBag();
$this->attributeName = $attributes->getName();
$this->registerBag($attributes);
$flashes = $flashes ?: new FlashBag();
$this->flashName = $flashes->getName();
$this->registerBag($flashes);
}
public function start()
{
return $this->storage->start();
}
public function has($name)
{
return $this->storage->getBag($this->attributeName)->has($name);
}
public function get($name, $default = null)
{
return $this->storage->getBag($this->attributeName)->get($name, $default);
}
public function set($name, $value)
{
$this->storage->getBag($this->attributeName)->set($name, $value);
}
public function all()
{
return $this->storage->getBag($this->attributeName)->all();
}
public function replace(array $attributes)
{
$this->storage->getBag($this->attributeName)->replace($attributes);
}
public function remove($name)
{
return $this->storage->getBag($this->attributeName)->remove($name);
}
public function clear()
{
$this->storage->getBag($this->attributeName)->clear();
}
public function isStarted()
{
return $this->storage->isStarted();
}
public function getIterator()
{
return new \ArrayIterator($this->storage->getBag($this->attributeName)->all());
}
public function count()
{
return \count($this->storage->getBag($this->attributeName)->all());
}
public function invalidate($lifetime = null)
{
$this->storage->clear();
return $this->migrate(true, $lifetime);
}
public function migrate($destroy = false, $lifetime = null)
{
return $this->storage->regenerate($destroy, $lifetime);
}
public function save()
{
$this->storage->save();
}
public function getId()
{
return $this->storage->getId();
}
public function setId($id)
{
if ($this->storage->getId() !== $id) {
$this->storage->setId($id);
}
}
public function getName()
{
return $this->storage->getName();
}
public function setName($name)
{
$this->storage->setName($name);
}
public function getMetadataBag()
{
return $this->storage->getMetadataBag();
}
public function registerBag(SessionBagInterface $bag)
{
$this->storage->registerBag($bag);
}
public function getBag($name)
{
return $this->storage->getBag($name);
}
public function getFlashBag()
{
return $this->getBag($this->flashName);
}
}
}
namespace Symfony\Bundle\FrameworkBundle\Templating
{
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\SecurityContext;
class GlobalVariables
{
protected $container;
public function __construct(ContainerInterface $container)
{
$this->container = $container;
}
public function getSecurity()
{
@trigger_error('The '.__METHOD__.' method is deprecated since Symfony 2.6 and will be removed in 3.0.', E_USER_DEPRECATED);
if ($this->container->has('security.context')) {
return $this->container->get('security.context');
}
}
public function getUser()
{
if (!$this->container->has('security.token_storage')) {
return;
}
$tokenStorage = $this->container->get('security.token_storage');
if (!$token = $tokenStorage->getToken()) {
return;
}
$user = $token->getUser();
if (!\is_object($user)) {
return;
}
return $user;
}
public function getRequest()
{
if ($this->container->has('request_stack')) {
return $this->container->get('request_stack')->getCurrentRequest();
}
}
public function getSession()
{
if ($request = $this->getRequest()) {
return $request->getSession();
}
}
public function getEnvironment()
{
return $this->container->getParameter('kernel.environment');
}
public function getDebug()
{
return (bool) $this->container->getParameter('kernel.debug');
}
}
}
namespace Symfony\Component\Templating
{
interface TemplateReferenceInterface
{
public function all();
public function set($name, $value);
public function get($name);
public function getPath();
public function getLogicalName();
public function __toString();
}
}
namespace Symfony\Component\Templating
{
class TemplateReference implements TemplateReferenceInterface
{
protected $parameters;
public function __construct($name = null, $engine = null)
{
$this->parameters = array('name'=> $name,'engine'=> $engine,
);
}
public function __toString()
{
return $this->getLogicalName();
}
public function set($name, $value)
{
if (array_key_exists($name, $this->parameters)) {
$this->parameters[$name] = $value;
} else {
throw new \InvalidArgumentException(sprintf('The template does not support the "%s" parameter.', $name));
}
return $this;
}
public function get($name)
{
if (array_key_exists($name, $this->parameters)) {
return $this->parameters[$name];
}
throw new \InvalidArgumentException(sprintf('The template does not support the "%s" parameter.', $name));
}
public function all()
{
return $this->parameters;
}
public function getPath()
{
return $this->parameters['name'];
}
public function getLogicalName()
{
return $this->parameters['name'];
}
}
}
namespace Symfony\Bundle\FrameworkBundle\Templating
{
use Symfony\Component\Templating\TemplateReference as BaseTemplateReference;
class TemplateReference extends BaseTemplateReference
{
public function __construct($bundle = null, $controller = null, $name = null, $format = null, $engine = null)
{
$this->parameters = array('bundle'=> $bundle,'controller'=> $controller,'name'=> $name,'format'=> $format,'engine'=> $engine,
);
}
public function getPath()
{
$controller = str_replace('\\','/', $this->get('controller'));
$path = (empty($controller) ?'': $controller.'/').$this->get('name').'.'.$this->get('format').'.'.$this->get('engine');
return empty($this->parameters['bundle']) ?'views/'.$path :'@'.$this->get('bundle').'/Resources/views/'.$path;
}
public function getLogicalName()
{
return sprintf('%s:%s:%s.%s.%s', $this->parameters['bundle'], $this->parameters['controller'], $this->parameters['name'], $this->parameters['format'], $this->parameters['engine']);
}
}
}
namespace Symfony\Component\Templating
{
interface TemplateNameParserInterface
{
public function parse($name);
}
}
namespace Symfony\Component\Templating
{
class TemplateNameParser implements TemplateNameParserInterface
{
public function parse($name)
{
if ($name instanceof TemplateReferenceInterface) {
return $name;
}
$engine = null;
if (false !== $pos = strrpos($name,'.')) {
$engine = substr($name, $pos + 1);
}
return new TemplateReference($name, $engine);
}
}
}
namespace Symfony\Bundle\FrameworkBundle\Templating
{
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Templating\TemplateNameParser as BaseTemplateNameParser;
use Symfony\Component\Templating\TemplateReferenceInterface;
class TemplateNameParser extends BaseTemplateNameParser
{
protected $kernel;
protected $cache = array();
public function __construct(KernelInterface $kernel)
{
$this->kernel = $kernel;
}
public function parse($name)
{
if ($name instanceof TemplateReferenceInterface) {
return $name;
} elseif (isset($this->cache[$name])) {
return $this->cache[$name];
}
$name = str_replace(':/',':', preg_replace('#/{2,}#','/', str_replace('\\','/', $name)));
if (false !== strpos($name,'..')) {
throw new \RuntimeException(sprintf('Template name "%s" contains invalid characters.', $name));
}
if (!preg_match('/^(?:([^:]*):([^:]*):)?(.+)\.([^\.]+)\.([^\.]+)$/', $name, $matches) || $this->isAbsolutePath($name) || 0 === strpos($name,'@')) {
return parent::parse($name);
}
$template = new TemplateReference($matches[1], $matches[2], $matches[3], $matches[4], $matches[5]);
if ($template->get('bundle')) {
try {
$this->kernel->getBundle($template->get('bundle'));
} catch (\Exception $e) {
throw new \InvalidArgumentException(sprintf('Template name "%s" is not valid.', $name), 0, $e);
}
}
return $this->cache[$name] = $template;
}
private function isAbsolutePath($file)
{
return (bool) preg_match('#^(?:/|[a-zA-Z]:)#', $file);
}
}
}
namespace Symfony\Component\Config
{
interface FileLocatorInterface
{
public function locate($name, $currentPath = null, $first = true);
}
}
namespace Symfony\Bundle\FrameworkBundle\Templating\Loader
{
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\Templating\TemplateReferenceInterface;
class TemplateLocator implements FileLocatorInterface
{
protected $locator;
protected $cache;
private $cacheHits = array();
public function __construct(FileLocatorInterface $locator, $cacheDir = null)
{
if (null !== $cacheDir && is_file($cache = $cacheDir.'/templates.php')) {
$this->cache = require $cache;
}
$this->locator = $locator;
}
protected function getCacheKey($template)
{
return $template->getLogicalName();
}
public function locate($template, $currentPath = null, $first = true)
{
if (!$template instanceof TemplateReferenceInterface) {
throw new \InvalidArgumentException('The template must be an instance of TemplateReferenceInterface.');
}
$key = $this->getCacheKey($template);
if (isset($this->cacheHits[$key])) {
return $this->cacheHits[$key];
}
if (isset($this->cache[$key])) {
return $this->cacheHits[$key] = realpath($this->cache[$key]) ?: $this->cache[$key];
}
try {
return $this->cacheHits[$key] = $this->locator->locate($template->getPath(), $currentPath);
} catch (\InvalidArgumentException $e) {
throw new \InvalidArgumentException(sprintf('Unable to find template "%s" : "%s".', $template, $e->getMessage()), 0, $e);
}
}
}
}
namespace Symfony\Component\Routing
{
interface RequestContextAwareInterface
{
public function setContext(RequestContext $context);
public function getContext();
}
}
namespace Symfony\Component\Routing\Generator
{
use Symfony\Component\Routing\Exception\InvalidParameterException;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\RequestContextAwareInterface;
interface UrlGeneratorInterface extends RequestContextAwareInterface
{
const ABSOLUTE_URL = 0;
const ABSOLUTE_PATH = 1;
const RELATIVE_PATH = 2;
const NETWORK_PATH = 3;
public function generate($name, $parameters = array(), $referenceType = self::ABSOLUTE_PATH);
}
}
namespace Symfony\Component\Routing\Generator
{
interface ConfigurableRequirementsInterface
{
public function setStrictRequirements($enabled);
public function isStrictRequirements();
}
}
namespace Symfony\Component\Routing\Generator
{
use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Exception\InvalidParameterException;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
class UrlGenerator implements UrlGeneratorInterface, ConfigurableRequirementsInterface
{
protected $routes;
protected $context;
protected $strictRequirements = true;
protected $logger;
protected $decodedChars = array('%2F'=>'/','%40'=>'@','%3A'=>':','%3B'=>';','%2C'=>',','%3D'=>'=','%2B'=>'+','%21'=>'!','%2A'=>'*','%7C'=>'|',
);
public function __construct(RouteCollection $routes, RequestContext $context, LoggerInterface $logger = null)
{
$this->routes = $routes;
$this->context = $context;
$this->logger = $logger;
}
public function setContext(RequestContext $context)
{
$this->context = $context;
}
public function getContext()
{
return $this->context;
}
public function setStrictRequirements($enabled)
{
$this->strictRequirements = null === $enabled ? null : (bool) $enabled;
}
public function isStrictRequirements()
{
return $this->strictRequirements;
}
public function generate($name, $parameters = array(), $referenceType = self::ABSOLUTE_PATH)
{
if (null === $route = $this->routes->get($name)) {
throw new RouteNotFoundException(sprintf('Unable to generate a URL for the named route "%s" as such route does not exist.', $name));
}
$compiledRoute = $route->compile();
return $this->doGenerate($compiledRoute->getVariables(), $route->getDefaults(), $route->getRequirements(), $compiledRoute->getTokens(), $parameters, $name, $referenceType, $compiledRoute->getHostTokens(), $route->getSchemes());
}
protected function doGenerate($variables, $defaults, $requirements, $tokens, $parameters, $name, $referenceType, $hostTokens, array $requiredSchemes = array())
{
if (\is_bool($referenceType) || \is_string($referenceType)) {
@trigger_error('The hardcoded value you are using for the $referenceType argument of the '.__CLASS__.'::generate method is deprecated since Symfony 2.8 and will not be supported anymore in 3.0. Use the constants defined in the UrlGeneratorInterface instead.', E_USER_DEPRECATED);
if (true === $referenceType) {
$referenceType = self::ABSOLUTE_URL;
} elseif (false === $referenceType) {
$referenceType = self::ABSOLUTE_PATH;
} elseif ('relative'=== $referenceType) {
$referenceType = self::RELATIVE_PATH;
} elseif ('network'=== $referenceType) {
$referenceType = self::NETWORK_PATH;
}
}
$variables = array_flip($variables);
$mergedParams = array_replace($defaults, $this->context->getParameters(), $parameters);
if ($diff = array_diff_key($variables, $mergedParams)) {
throw new MissingMandatoryParametersException(sprintf('Some mandatory parameters are missing ("%s") to generate a URL for route "%s".', implode('", "', array_keys($diff)), $name));
}
$url ='';
$optional = true;
foreach ($tokens as $token) {
if ('variable'=== $token[0]) {
if (!$optional || !array_key_exists($token[3], $defaults) || null !== $mergedParams[$token[3]] && (string) $mergedParams[$token[3]] !== (string) $defaults[$token[3]]) {
if (null !== $this->strictRequirements && !preg_match('#^'.$token[2].'$#', $mergedParams[$token[3]])) {
$message = sprintf('Parameter "%s" for route "%s" must match "%s" ("%s" given) to generate a corresponding URL.', $token[3], $name, $token[2], $mergedParams[$token[3]]);
if ($this->strictRequirements) {
throw new InvalidParameterException($message);
}
if ($this->logger) {
$this->logger->error($message);
}
return;
}
$url = $token[1].$mergedParams[$token[3]].$url;
$optional = false;
}
} else {
$url = $token[1].$url;
$optional = false;
}
}
if (''=== $url) {
$url ='/';
}
$url = strtr(rawurlencode($url), $this->decodedChars);
$url = strtr($url, array('/../'=>'/%2E%2E/','/./'=>'/%2E/'));
if ('/..'=== substr($url, -3)) {
$url = substr($url, 0, -2).'%2E%2E';
} elseif ('/.'=== substr($url, -2)) {
$url = substr($url, 0, -1).'%2E';
}
$schemeAuthority ='';
$host = $this->context->getHost();
$scheme = $this->context->getScheme();
if ($requiredSchemes) {
if (!\in_array($scheme, $requiredSchemes, true)) {
$referenceType = self::ABSOLUTE_URL;
$scheme = current($requiredSchemes);
}
} elseif (isset($requirements['_scheme']) && ($req = strtolower($requirements['_scheme'])) && $scheme !== $req) {
$referenceType = self::ABSOLUTE_URL;
$scheme = $req;
}
if ($hostTokens) {
$routeHost ='';
foreach ($hostTokens as $token) {
if ('variable'=== $token[0]) {
if (null !== $this->strictRequirements && !preg_match('#^'.$token[2].'$#i', $mergedParams[$token[3]])) {
$message = sprintf('Parameter "%s" for route "%s" must match "%s" ("%s" given) to generate a corresponding URL.', $token[3], $name, $token[2], $mergedParams[$token[3]]);
if ($this->strictRequirements) {
throw new InvalidParameterException($message);
}
if ($this->logger) {
$this->logger->error($message);
}
return;
}
$routeHost = $token[1].$mergedParams[$token[3]].$routeHost;
} else {
$routeHost = $token[1].$routeHost;
}
}
if ($routeHost !== $host) {
$host = $routeHost;
if (self::ABSOLUTE_URL !== $referenceType) {
$referenceType = self::NETWORK_PATH;
}
}
}
if ((self::ABSOLUTE_URL === $referenceType || self::NETWORK_PATH === $referenceType) && !empty($host)) {
$port ='';
if ('http'=== $scheme && 80 != $this->context->getHttpPort()) {
$port =':'.$this->context->getHttpPort();
} elseif ('https'=== $scheme && 443 != $this->context->getHttpsPort()) {
$port =':'.$this->context->getHttpsPort();
}
$schemeAuthority = self::NETWORK_PATH === $referenceType ?'//': "$scheme://";
$schemeAuthority .= $host.$port;
}
if (self::RELATIVE_PATH === $referenceType) {
$url = self::getRelativePath($this->context->getPathInfo(), $url);
} else {
$url = $schemeAuthority.$this->context->getBaseUrl().$url;
}
$extra = array_udiff_assoc(array_diff_key($parameters, $variables), $defaults, function ($a, $b) {
return $a == $b ? 0 : 1;
});
if ($extra && $query = http_build_query($extra,'','&')) {
$url .='?'.strtr($query, array('%2F'=>'/'));
}
return $url;
}
public static function getRelativePath($basePath, $targetPath)
{
if ($basePath === $targetPath) {
return'';
}
$sourceDirs = explode('/', isset($basePath[0]) &&'/'=== $basePath[0] ? substr($basePath, 1) : $basePath);
$targetDirs = explode('/', isset($targetPath[0]) &&'/'=== $targetPath[0] ? substr($targetPath, 1) : $targetPath);
array_pop($sourceDirs);
$targetFile = array_pop($targetDirs);
foreach ($sourceDirs as $i => $dir) {
if (isset($targetDirs[$i]) && $dir === $targetDirs[$i]) {
unset($sourceDirs[$i], $targetDirs[$i]);
} else {
break;
}
}
$targetDirs[] = $targetFile;
$path = str_repeat('../', \count($sourceDirs)).implode('/', $targetDirs);
return''=== $path ||'/'=== $path[0]
|| false !== ($colonPos = strpos($path,':')) && ($colonPos < ($slashPos = strpos($path,'/')) || false === $slashPos)
? "./$path" : $path;
}
}
}
namespace Symfony\Component\Routing
{
use Symfony\Component\HttpFoundation\Request;
class RequestContext
{
private $baseUrl;
private $pathInfo;
private $method;
private $host;
private $scheme;
private $httpPort;
private $httpsPort;
private $queryString;
private $parameters = array();
public function __construct($baseUrl ='', $method ='GET', $host ='localhost', $scheme ='http', $httpPort = 80, $httpsPort = 443, $path ='/', $queryString ='')
{
$this->setBaseUrl($baseUrl);
$this->setMethod($method);
$this->setHost($host);
$this->setScheme($scheme);
$this->setHttpPort($httpPort);
$this->setHttpsPort($httpsPort);
$this->setPathInfo($path);
$this->setQueryString($queryString);
}
public function fromRequest(Request $request)
{
$this->setBaseUrl($request->getBaseUrl());
$this->setPathInfo($request->getPathInfo());
$this->setMethod($request->getMethod());
$this->setHost($request->getHost());
$this->setScheme($request->getScheme());
$this->setHttpPort($request->isSecure() ? $this->httpPort : $request->getPort());
$this->setHttpsPort($request->isSecure() ? $request->getPort() : $this->httpsPort);
$this->setQueryString($request->server->get('QUERY_STRING',''));
return $this;
}
public function getBaseUrl()
{
return $this->baseUrl;
}
public function setBaseUrl($baseUrl)
{
$this->baseUrl = $baseUrl;
return $this;
}
public function getPathInfo()
{
return $this->pathInfo;
}
public function setPathInfo($pathInfo)
{
$this->pathInfo = $pathInfo;
return $this;
}
public function getMethod()
{
return $this->method;
}
public function setMethod($method)
{
$this->method = strtoupper($method);
return $this;
}
public function getHost()
{
return $this->host;
}
public function setHost($host)
{
$this->host = strtolower($host);
return $this;
}
public function getScheme()
{
return $this->scheme;
}
public function setScheme($scheme)
{
$this->scheme = strtolower($scheme);
return $this;
}
public function getHttpPort()
{
return $this->httpPort;
}
public function setHttpPort($httpPort)
{
$this->httpPort = (int) $httpPort;
return $this;
}
public function getHttpsPort()
{
return $this->httpsPort;
}
public function setHttpsPort($httpsPort)
{
$this->httpsPort = (int) $httpsPort;
return $this;
}
public function getQueryString()
{
return $this->queryString;
}
public function setQueryString($queryString)
{
$this->queryString = (string) $queryString;
return $this;
}
public function getParameters()
{
return $this->parameters;
}
public function setParameters(array $parameters)
{
$this->parameters = $parameters;
return $this;
}
public function getParameter($name)
{
return isset($this->parameters[$name]) ? $this->parameters[$name] : null;
}
public function hasParameter($name)
{
return array_key_exists($name, $this->parameters);
}
public function setParameter($name, $parameter)
{
$this->parameters[$name] = $parameter;
return $this;
}
}
}
namespace Symfony\Component\Routing\Matcher
{
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContextAwareInterface;
interface UrlMatcherInterface extends RequestContextAwareInterface
{
public function match($pathinfo);
}
}
namespace Symfony\Component\Routing
{
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
interface RouterInterface extends UrlMatcherInterface, UrlGeneratorInterface
{
public function getRouteCollection();
}
}
namespace Symfony\Component\Routing\Matcher
{
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
interface RequestMatcherInterface
{
public function matchRequest(Request $request);
}
}
namespace Symfony\Component\Routing
{
use Psr\Log\LoggerInterface;
use Symfony\Component\Config\ConfigCacheFactory;
use Symfony\Component\Config\ConfigCacheFactoryInterface;
use Symfony\Component\Config\ConfigCacheInterface;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\ConfigurableRequirementsInterface;
use Symfony\Component\Routing\Generator\Dumper\GeneratorDumperInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Matcher\Dumper\MatcherDumperInterface;
use Symfony\Component\Routing\Matcher\RequestMatcherInterface;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
class Router implements RouterInterface, RequestMatcherInterface
{
protected $matcher;
protected $generator;
protected $context;
protected $loader;
protected $collection;
protected $resource;
protected $options = array();
protected $logger;
private $configCacheFactory;
private $expressionLanguageProviders = array();
public function __construct(LoaderInterface $loader, $resource, array $options = array(), RequestContext $context = null, LoggerInterface $logger = null)
{
$this->loader = $loader;
$this->resource = $resource;
$this->logger = $logger;
$this->context = $context ?: new RequestContext();
$this->setOptions($options);
}
public function setOptions(array $options)
{
$this->options = array('cache_dir'=> null,'debug'=> false,'generator_class'=>'Symfony\\Component\\Routing\\Generator\\UrlGenerator','generator_base_class'=>'Symfony\\Component\\Routing\\Generator\\UrlGenerator','generator_dumper_class'=>'Symfony\\Component\\Routing\\Generator\\Dumper\\PhpGeneratorDumper','generator_cache_class'=>'ProjectUrlGenerator','matcher_class'=>'Symfony\\Component\\Routing\\Matcher\\UrlMatcher','matcher_base_class'=>'Symfony\\Component\\Routing\\Matcher\\UrlMatcher','matcher_dumper_class'=>'Symfony\\Component\\Routing\\Matcher\\Dumper\\PhpMatcherDumper','matcher_cache_class'=>'ProjectUrlMatcher','resource_type'=> null,'strict_requirements'=> true,
);
$invalid = array();
foreach ($options as $key => $value) {
if (array_key_exists($key, $this->options)) {
$this->options[$key] = $value;
} else {
$invalid[] = $key;
}
}
if ($invalid) {
throw new \InvalidArgumentException(sprintf('The Router does not support the following options: "%s".', implode('", "', $invalid)));
}
}
public function setOption($key, $value)
{
if (!array_key_exists($key, $this->options)) {
throw new \InvalidArgumentException(sprintf('The Router does not support the "%s" option.', $key));
}
$this->options[$key] = $value;
}
public function getOption($key)
{
if (!array_key_exists($key, $this->options)) {
throw new \InvalidArgumentException(sprintf('The Router does not support the "%s" option.', $key));
}
return $this->options[$key];
}
public function getRouteCollection()
{
if (null === $this->collection) {
$this->collection = $this->loader->load($this->resource, $this->options['resource_type']);
}
return $this->collection;
}
public function setContext(RequestContext $context)
{
$this->context = $context;
if (null !== $this->matcher) {
$this->getMatcher()->setContext($context);
}
if (null !== $this->generator) {
$this->getGenerator()->setContext($context);
}
}
public function getContext()
{
return $this->context;
}
public function setConfigCacheFactory(ConfigCacheFactoryInterface $configCacheFactory)
{
$this->configCacheFactory = $configCacheFactory;
}
public function generate($name, $parameters = array(), $referenceType = self::ABSOLUTE_PATH)
{
return $this->getGenerator()->generate($name, $parameters, $referenceType);
}
public function match($pathinfo)
{
return $this->getMatcher()->match($pathinfo);
}
public function matchRequest(Request $request)
{
$matcher = $this->getMatcher();
if (!$matcher instanceof RequestMatcherInterface) {
return $matcher->match($request->getPathInfo());
}
return $matcher->matchRequest($request);
}
public function getMatcher()
{
if (null !== $this->matcher) {
return $this->matcher;
}
if (null === $this->options['cache_dir'] || null === $this->options['matcher_cache_class']) {
$this->matcher = new $this->options['matcher_class']($this->getRouteCollection(), $this->context);
if (method_exists($this->matcher,'addExpressionLanguageProvider')) {
foreach ($this->expressionLanguageProviders as $provider) {
$this->matcher->addExpressionLanguageProvider($provider);
}
}
return $this->matcher;
}
$class = $this->options['matcher_cache_class'];
$baseClass = $this->options['matcher_base_class'];
$expressionLanguageProviders = $this->expressionLanguageProviders;
$that = $this;
$cache = $this->getConfigCacheFactory()->cache($this->options['cache_dir'].'/'.$class.'.php',
function (ConfigCacheInterface $cache) use ($that, $class, $baseClass, $expressionLanguageProviders) {
$dumper = $that->getMatcherDumperInstance();
if (method_exists($dumper,'addExpressionLanguageProvider')) {
foreach ($expressionLanguageProviders as $provider) {
$dumper->addExpressionLanguageProvider($provider);
}
}
$options = array('class'=> $class,'base_class'=> $baseClass,
);
$cache->write($dumper->dump($options), $that->getRouteCollection()->getResources());
}
);
require_once $cache->getPath();
return $this->matcher = new $class($this->context);
}
public function getGenerator()
{
if (null !== $this->generator) {
return $this->generator;
}
if (null === $this->options['cache_dir'] || null === $this->options['generator_cache_class']) {
$this->generator = new $this->options['generator_class']($this->getRouteCollection(), $this->context, $this->logger);
} else {
$class = $this->options['generator_cache_class'];
$baseClass = $this->options['generator_base_class'];
$that = $this; $cache = $this->getConfigCacheFactory()->cache($this->options['cache_dir'].'/'.$class.'.php',
function (ConfigCacheInterface $cache) use ($that, $class, $baseClass) {
$dumper = $that->getGeneratorDumperInstance();
$options = array('class'=> $class,'base_class'=> $baseClass,
);
$cache->write($dumper->dump($options), $that->getRouteCollection()->getResources());
}
);
require_once $cache->getPath();
$this->generator = new $class($this->context, $this->logger);
}
if ($this->generator instanceof ConfigurableRequirementsInterface) {
$this->generator->setStrictRequirements($this->options['strict_requirements']);
}
return $this->generator;
}
public function addExpressionLanguageProvider(ExpressionFunctionProviderInterface $provider)
{
$this->expressionLanguageProviders[] = $provider;
}
public function getGeneratorDumperInstance()
{
return new $this->options['generator_dumper_class']($this->getRouteCollection());
}
public function getMatcherDumperInstance()
{
return new $this->options['matcher_dumper_class']($this->getRouteCollection());
}
private function getConfigCacheFactory()
{
if (null === $this->configCacheFactory) {
$this->configCacheFactory = new ConfigCacheFactory($this->options['debug']);
}
return $this->configCacheFactory;
}
}
}
namespace Symfony\Component\Routing\Matcher
{
interface RedirectableUrlMatcherInterface
{
public function redirect($path, $route, $scheme = null);
}
}
namespace Symfony\Component\Routing\Matcher
{
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
class UrlMatcher implements UrlMatcherInterface, RequestMatcherInterface
{
const REQUIREMENT_MATCH = 0;
const REQUIREMENT_MISMATCH = 1;
const ROUTE_MATCH = 2;
protected $context;
protected $allow = array();
protected $routes;
protected $request;
protected $expressionLanguage;
protected $expressionLanguageProviders = array();
public function __construct(RouteCollection $routes, RequestContext $context)
{
$this->routes = $routes;
$this->context = $context;
}
public function setContext(RequestContext $context)
{
$this->context = $context;
}
public function getContext()
{
return $this->context;
}
public function match($pathinfo)
{
$this->allow = array();
if ($ret = $this->matchCollection(rawurldecode($pathinfo), $this->routes)) {
return $ret;
}
throw 0 < \count($this->allow)
? new MethodNotAllowedException(array_unique($this->allow))
: new ResourceNotFoundException(sprintf('No routes found for "%s".', $pathinfo));
}
public function matchRequest(Request $request)
{
$this->request = $request;
$ret = $this->match($request->getPathInfo());
$this->request = null;
return $ret;
}
public function addExpressionLanguageProvider(ExpressionFunctionProviderInterface $provider)
{
$this->expressionLanguageProviders[] = $provider;
}
protected function matchCollection($pathinfo, RouteCollection $routes)
{
foreach ($routes as $name => $route) {
$compiledRoute = $route->compile();
if (''!== $compiledRoute->getStaticPrefix() && 0 !== strpos($pathinfo, $compiledRoute->getStaticPrefix())) {
continue;
}
if (!preg_match($compiledRoute->getRegex(), $pathinfo, $matches)) {
continue;
}
$hostMatches = array();
if ($compiledRoute->getHostRegex() && !preg_match($compiledRoute->getHostRegex(), $this->context->getHost(), $hostMatches)) {
continue;
}
$status = $this->handleRouteRequirements($pathinfo, $name, $route);
if (self::REQUIREMENT_MISMATCH === $status[0]) {
continue;
}
if ($requiredMethods = $route->getMethods()) {
if ('HEAD'=== $method = $this->context->getMethod()) {
$method ='GET';
}
if (!\in_array($method, $requiredMethods)) {
if (self::REQUIREMENT_MATCH === $status[0]) {
$this->allow = array_merge($this->allow, $requiredMethods);
}
continue;
}
}
if (self::ROUTE_MATCH === $status[0]) {
return $status[1];
}
return $this->getAttributes($route, $name, array_replace($matches, $hostMatches));
}
}
protected function getAttributes(Route $route, $name, array $attributes)
{
$attributes['_route'] = $name;
return $this->mergeDefaults($attributes, $route->getDefaults());
}
protected function handleRouteRequirements($pathinfo, $name, Route $route)
{
if ($route->getCondition() && !$this->getExpressionLanguage()->evaluate($route->getCondition(), array('context'=> $this->context,'request'=> $this->request ?: $this->createRequest($pathinfo)))) {
return array(self::REQUIREMENT_MISMATCH, null);
}
$scheme = $this->context->getScheme();
$status = $route->getSchemes() && !$route->hasScheme($scheme) ? self::REQUIREMENT_MISMATCH : self::REQUIREMENT_MATCH;
return array($status, null);
}
protected function mergeDefaults($params, $defaults)
{
foreach ($params as $key => $value) {
if (!\is_int($key)) {
$defaults[$key] = $value;
}
}
return $defaults;
}
protected function getExpressionLanguage()
{
if (null === $this->expressionLanguage) {
if (!class_exists('Symfony\Component\ExpressionLanguage\ExpressionLanguage')) {
throw new \RuntimeException('Unable to use expressions as the Symfony ExpressionLanguage component is not installed.');
}
$this->expressionLanguage = new ExpressionLanguage(null, $this->expressionLanguageProviders);
}
return $this->expressionLanguage;
}
protected function createRequest($pathinfo)
{
if (!class_exists('Symfony\Component\HttpFoundation\Request')) {
return null;
}
return Request::create($this->context->getScheme().'://'.$this->context->getHost().$this->context->getBaseUrl().$pathinfo, $this->context->getMethod(), $this->context->getParameters(), array(), array(), array('SCRIPT_FILENAME'=> $this->context->getBaseUrl(),'SCRIPT_NAME'=> $this->context->getBaseUrl(),
));
}
}
}
namespace Symfony\Component\Routing\Matcher
{
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Route;
abstract class RedirectableUrlMatcher extends UrlMatcher implements RedirectableUrlMatcherInterface
{
public function match($pathinfo)
{
try {
$parameters = parent::match($pathinfo);
} catch (ResourceNotFoundException $e) {
if ('/'=== substr($pathinfo, -1) || !\in_array($this->context->getMethod(), array('HEAD','GET'))) {
throw $e;
}
try {
parent::match($pathinfo.'/');
return $this->redirect($pathinfo.'/', null);
} catch (ResourceNotFoundException $e2) {
throw $e;
}
}
return $parameters;
}
protected function handleRouteRequirements($pathinfo, $name, Route $route)
{
if ($route->getCondition() && !$this->getExpressionLanguage()->evaluate($route->getCondition(), array('context'=> $this->context,'request'=> $this->request ?: $this->createRequest($pathinfo)))) {
return array(self::REQUIREMENT_MISMATCH, null);
}
$scheme = $this->context->getScheme();
$schemes = $route->getSchemes();
if ($schemes && !$route->hasScheme($scheme)) {
return array(self::ROUTE_MATCH, $this->redirect($pathinfo, $name, current($schemes)));
}
return array(self::REQUIREMENT_MATCH, null);
}
}
}
namespace Symfony\Bundle\FrameworkBundle\Routing
{
use Symfony\Component\Routing\Matcher\RedirectableUrlMatcher as BaseMatcher;
class RedirectableUrlMatcher extends BaseMatcher
{
public function redirect($path, $route, $scheme = null)
{
return array('_controller'=>'Symfony\\Bundle\\FrameworkBundle\\Controller\\RedirectController::urlRedirectAction','path'=> $path,'permanent'=> true,'scheme'=> $scheme,'httpPort'=> $this->context->getHttpPort(),'httpsPort'=> $this->context->getHttpsPort(),'_route'=> $route,
);
}
}
}
namespace Symfony\Component\HttpKernel\CacheWarmer
{
interface WarmableInterface
{
public function warmUp($cacheDir);
}
}
namespace Symfony\Bundle\FrameworkBundle\Routing
{
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\HttpKernel\CacheWarmer\WarmableInterface;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Router as BaseRouter;
class Router extends BaseRouter implements WarmableInterface
{
private $container;
public function __construct(ContainerInterface $container, $resource, array $options = array(), RequestContext $context = null)
{
$this->container = $container;
$this->resource = $resource;
$this->context = $context ?: new RequestContext();
$this->setOptions($options);
}
public function getRouteCollection()
{
if (null === $this->collection) {
$this->collection = $this->container->get('routing.loader')->load($this->resource, $this->options['resource_type']);
$this->resolveParameters($this->collection);
}
return $this->collection;
}
public function warmUp($cacheDir)
{
$currentDir = $this->getOption('cache_dir');
$this->setOption('cache_dir', $cacheDir);
$this->getMatcher();
$this->getGenerator();
$this->setOption('cache_dir', $currentDir);
}
private function resolveParameters(RouteCollection $collection)
{
foreach ($collection as $route) {
foreach ($route->getDefaults() as $name => $value) {
$route->setDefault($name, $this->resolve($value));
}
foreach ($route->getRequirements() as $name => $value) {
if ('_scheme'=== $name ||'_method'=== $name) {
continue; }
$route->setRequirement($name, $this->resolve($value));
}
$route->setPath($this->resolve($route->getPath()));
$route->setHost($this->resolve($route->getHost()));
$schemes = array();
foreach ($route->getSchemes() as $scheme) {
$schemes = array_merge($schemes, explode('|', $this->resolve($scheme)));
}
$route->setSchemes($schemes);
$methods = array();
foreach ($route->getMethods() as $method) {
$methods = array_merge($methods, explode('|', $this->resolve($method)));
}
$route->setMethods($methods);
$route->setCondition($this->resolve($route->getCondition()));
}
}
private function resolve($value)
{
if (\is_array($value)) {
foreach ($value as $key => $val) {
$value[$key] = $this->resolve($val);
}
return $value;
}
if (!\is_string($value)) {
return $value;
}
$container = $this->container;
$escapedValue = preg_replace_callback('/%%|%([^%\s]++)%/', function ($match) use ($container, $value) {
if (!isset($match[1])) {
return'%%';
}
$resolved = $container->getParameter($match[1]);
if (\is_string($resolved) || is_numeric($resolved)) {
return (string) $resolved;
}
throw new RuntimeException(sprintf('The container parameter "%s", used in the route configuration value "%s", must be a string or numeric, but it is of type %s.', $match[1], $value, \gettype($resolved)));
}, $value);
return str_replace('%%','%', $escapedValue);
}
}
}
namespace Symfony\Component\Config
{
class FileLocator implements FileLocatorInterface
{
protected $paths;
public function __construct($paths = array())
{
$this->paths = (array) $paths;
}
public function locate($name, $currentPath = null, $first = true)
{
if (''== $name) {
throw new \InvalidArgumentException('An empty file name is not valid to be located.');
}
if ($this->isAbsolutePath($name)) {
if (!file_exists($name)) {
throw new \InvalidArgumentException(sprintf('The file "%s" does not exist.', $name));
}
return $name;
}
$paths = $this->paths;
if (null !== $currentPath) {
array_unshift($paths, $currentPath);
}
$paths = array_unique($paths);
$filepaths = array();
foreach ($paths as $path) {
if (@file_exists($file = $path.\DIRECTORY_SEPARATOR.$name)) {
if (true === $first) {
return $file;
}
$filepaths[] = $file;
}
}
if (!$filepaths) {
throw new \InvalidArgumentException(sprintf('The file "%s" does not exist (in: %s).', $name, implode(', ', $paths)));
}
return $filepaths;
}
private function isAbsolutePath($file)
{
if ('/'=== $file[0] ||'\\'=== $file[0]
|| (\strlen($file) > 3 && ctype_alpha($file[0])
&&':'=== $file[1]
&& ('\\'=== $file[2] ||'/'=== $file[2])
)
|| null !== parse_url($file, PHP_URL_SCHEME)
) {
return true;
}
return false;
}
}
}
namespace Symfony\Component\EventDispatcher
{
class Event
{
private $propagationStopped = false;
private $dispatcher;
private $name;
public function isPropagationStopped()
{
return $this->propagationStopped;
}
public function stopPropagation()
{
$this->propagationStopped = true;
}
public function setDispatcher(EventDispatcherInterface $dispatcher)
{
$this->dispatcher = $dispatcher;
}
public function getDispatcher()
{
@trigger_error('The '.__METHOD__.' method is deprecated since Symfony 2.4 and will be removed in 3.0. The event dispatcher instance can be received in the listener call instead.', E_USER_DEPRECATED);
return $this->dispatcher;
}
public function getName()
{
@trigger_error('The '.__METHOD__.' method is deprecated since Symfony 2.4 and will be removed in 3.0. The event name can be received in the listener call instead.', E_USER_DEPRECATED);
return $this->name;
}
public function setName($name)
{
$this->name = $name;
}
}
}
namespace Symfony\Component\EventDispatcher
{
interface EventDispatcherInterface
{
public function dispatch($eventName, Event $event = null);
public function addListener($eventName, $listener, $priority = 0);
public function addSubscriber(EventSubscriberInterface $subscriber);
public function removeListener($eventName, $listener);
public function removeSubscriber(EventSubscriberInterface $subscriber);
public function getListeners($eventName = null);
public function hasListeners($eventName = null);
}
}
namespace Symfony\Component\EventDispatcher
{
class EventDispatcher implements EventDispatcherInterface
{
private $listeners = array();
private $sorted = array();
public function dispatch($eventName, Event $event = null)
{
if (null === $event) {
$event = new Event();
}
$event->setDispatcher($this);
$event->setName($eventName);
if ($listeners = $this->getListeners($eventName)) {
$this->doDispatch($listeners, $eventName, $event);
}
return $event;
}
public function getListeners($eventName = null)
{
if (null !== $eventName) {
if (!isset($this->listeners[$eventName])) {
return array();
}
if (!isset($this->sorted[$eventName])) {
$this->sortListeners($eventName);
}
return $this->sorted[$eventName];
}
foreach ($this->listeners as $eventName => $eventListeners) {
if (!isset($this->sorted[$eventName])) {
$this->sortListeners($eventName);
}
}
return array_filter($this->sorted);
}
public function getListenerPriority($eventName, $listener)
{
if (!isset($this->listeners[$eventName])) {
return;
}
foreach ($this->listeners[$eventName] as $priority => $listeners) {
if (false !== \in_array($listener, $listeners, true)) {
return $priority;
}
}
}
public function hasListeners($eventName = null)
{
return (bool) $this->getListeners($eventName);
}
public function addListener($eventName, $listener, $priority = 0)
{
$this->listeners[$eventName][$priority][] = $listener;
unset($this->sorted[$eventName]);
}
public function removeListener($eventName, $listener)
{
if (!isset($this->listeners[$eventName])) {
return;
}
foreach ($this->listeners[$eventName] as $priority => $listeners) {
if (false !== ($key = array_search($listener, $listeners, true))) {
unset($this->listeners[$eventName][$priority][$key], $this->sorted[$eventName]);
}
}
}
public function addSubscriber(EventSubscriberInterface $subscriber)
{
foreach ($subscriber->getSubscribedEvents() as $eventName => $params) {
if (\is_string($params)) {
$this->addListener($eventName, array($subscriber, $params));
} elseif (\is_string($params[0])) {
$this->addListener($eventName, array($subscriber, $params[0]), isset($params[1]) ? $params[1] : 0);
} else {
foreach ($params as $listener) {
$this->addListener($eventName, array($subscriber, $listener[0]), isset($listener[1]) ? $listener[1] : 0);
}
}
}
}
public function removeSubscriber(EventSubscriberInterface $subscriber)
{
foreach ($subscriber->getSubscribedEvents() as $eventName => $params) {
if (\is_array($params) && \is_array($params[0])) {
foreach ($params as $listener) {
$this->removeListener($eventName, array($subscriber, $listener[0]));
}
} else {
$this->removeListener($eventName, array($subscriber, \is_string($params) ? $params : $params[0]));
}
}
}
protected function doDispatch($listeners, $eventName, Event $event)
{
foreach ($listeners as $listener) {
if ($event->isPropagationStopped()) {
break;
}
\call_user_func($listener, $event, $eventName, $this);
}
}
private function sortListeners($eventName)
{
krsort($this->listeners[$eventName]);
$this->sorted[$eventName] = \call_user_func_array('array_merge', $this->listeners[$eventName]);
}
}
}
namespace Symfony\Component\EventDispatcher
{
use Symfony\Component\DependencyInjection\ContainerInterface;
class ContainerAwareEventDispatcher extends EventDispatcher
{
private $container;
private $listenerIds = array();
private $listeners = array();
public function __construct(ContainerInterface $container)
{
$this->container = $container;
}
public function addListenerService($eventName, $callback, $priority = 0)
{
if (!\is_array($callback) || 2 !== \count($callback)) {
throw new \InvalidArgumentException('Expected an array("service", "method") argument');
}
$this->listenerIds[$eventName][] = array($callback[0], $callback[1], $priority);
}
public function removeListener($eventName, $listener)
{
$this->lazyLoad($eventName);
if (isset($this->listenerIds[$eventName])) {
foreach ($this->listenerIds[$eventName] as $i => $args) {
list($serviceId, $method) = $args;
$key = $serviceId.'.'.$method;
if (isset($this->listeners[$eventName][$key]) && $listener === array($this->listeners[$eventName][$key], $method)) {
unset($this->listeners[$eventName][$key]);
if (empty($this->listeners[$eventName])) {
unset($this->listeners[$eventName]);
}
unset($this->listenerIds[$eventName][$i]);
if (empty($this->listenerIds[$eventName])) {
unset($this->listenerIds[$eventName]);
}
}
}
}
parent::removeListener($eventName, $listener);
}
public function hasListeners($eventName = null)
{
if (null === $eventName) {
return $this->listenerIds || $this->listeners || parent::hasListeners();
}
if (isset($this->listenerIds[$eventName])) {
return true;
}
return parent::hasListeners($eventName);
}
public function getListeners($eventName = null)
{
if (null === $eventName) {
foreach ($this->listenerIds as $serviceEventName => $args) {
$this->lazyLoad($serviceEventName);
}
} else {
$this->lazyLoad($eventName);
}
return parent::getListeners($eventName);
}
public function getListenerPriority($eventName, $listener)
{
$this->lazyLoad($eventName);
return parent::getListenerPriority($eventName, $listener);
}
public function addSubscriberService($serviceId, $class)
{
foreach ($class::getSubscribedEvents() as $eventName => $params) {
if (\is_string($params)) {
$this->listenerIds[$eventName][] = array($serviceId, $params, 0);
} elseif (\is_string($params[0])) {
$this->listenerIds[$eventName][] = array($serviceId, $params[0], isset($params[1]) ? $params[1] : 0);
} else {
foreach ($params as $listener) {
$this->listenerIds[$eventName][] = array($serviceId, $listener[0], isset($listener[1]) ? $listener[1] : 0);
}
}
}
}
public function getContainer()
{
return $this->container;
}
protected function lazyLoad($eventName)
{
if (isset($this->listenerIds[$eventName])) {
foreach ($this->listenerIds[$eventName] as $args) {
list($serviceId, $method, $priority) = $args;
$listener = $this->container->get($serviceId);
$key = $serviceId.'.'.$method;
if (!isset($this->listeners[$eventName][$key])) {
$this->addListener($eventName, array($listener, $method), $priority);
} elseif ($this->listeners[$eventName][$key] !== $listener) {
parent::removeListener($eventName, array($this->listeners[$eventName][$key], $method));
$this->addListener($eventName, array($listener, $method), $priority);
}
$this->listeners[$eventName][$key] = $listener;
}
}
}
}
}
namespace Symfony\Component\HttpKernel\EventListener
{
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
class ResponseListener implements EventSubscriberInterface
{
private $charset;
public function __construct($charset)
{
$this->charset = $charset;
}
public function onKernelResponse(FilterResponseEvent $event)
{
if (!$event->isMasterRequest()) {
return;
}
$response = $event->getResponse();
if (null === $response->getCharset()) {
$response->setCharset($this->charset);
}
$response->prepare($event->getRequest());
}
public static function getSubscribedEvents()
{
return array(
KernelEvents::RESPONSE =>'onKernelResponse',
);
}
}
}
namespace Symfony\Component\HttpKernel\EventListener
{
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\FinishRequestEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\RequestMatcherInterface;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RequestContextAwareInterface;
class RouterListener implements EventSubscriberInterface
{
private $matcher;
private $context;
private $logger;
private $request;
private $requestStack;
public function __construct($matcher, $requestStack = null, $context = null, $logger = null)
{
if ($requestStack instanceof RequestContext || $context instanceof LoggerInterface || $logger instanceof RequestStack) {
$tmp = $requestStack;
$requestStack = $logger;
$logger = $context;
$context = $tmp;
@trigger_error('The '.__METHOD__.' method now requires a RequestStack to be given as second argument as '.__CLASS__.'::setRequest method will not be supported anymore in 3.0.', E_USER_DEPRECATED);
} elseif (!$requestStack instanceof RequestStack) {
@trigger_error('The '.__METHOD__.' method now requires a RequestStack instance as '.__CLASS__.'::setRequest method will not be supported anymore in 3.0.', E_USER_DEPRECATED);
}
if (null !== $requestStack && !$requestStack instanceof RequestStack) {
throw new \InvalidArgumentException('RequestStack instance expected.');
}
if (null !== $context && !$context instanceof RequestContext) {
throw new \InvalidArgumentException('RequestContext instance expected.');
}
if (null !== $logger && !$logger instanceof LoggerInterface) {
throw new \InvalidArgumentException('Logger must implement LoggerInterface.');
}
if (!$matcher instanceof UrlMatcherInterface && !$matcher instanceof RequestMatcherInterface) {
throw new \InvalidArgumentException('Matcher must either implement UrlMatcherInterface or RequestMatcherInterface.');
}
if (null === $context && !$matcher instanceof RequestContextAwareInterface) {
throw new \InvalidArgumentException('You must either pass a RequestContext or the matcher must implement RequestContextAwareInterface.');
}
$this->matcher = $matcher;
$this->context = $context ?: $matcher->getContext();
$this->requestStack = $requestStack;
$this->logger = $logger;
}
public function setRequest(Request $request = null)
{
@trigger_error('The '.__METHOD__.' method is deprecated since Symfony 2.4 and will be made private in 3.0.', E_USER_DEPRECATED);
$this->setCurrentRequest($request);
}
private function setCurrentRequest(Request $request = null)
{
if (null !== $request && $this->request !== $request) {
try {
$this->context->fromRequest($request);
} catch (\UnexpectedValueException $e) {
throw new BadRequestHttpException($e->getMessage(), $e, $e->getCode());
}
}
$this->request = $request;
}
public function onKernelFinishRequest(FinishRequestEvent $event)
{
if (null === $this->requestStack) {
return; }
$this->setCurrentRequest($this->requestStack->getParentRequest());
}
public function onKernelRequest(GetResponseEvent $event)
{
$request = $event->getRequest();
if (null !== $this->requestStack) {
$this->setCurrentRequest($request);
}
if ($request->attributes->has('_controller')) {
return;
}
try {
if ($this->matcher instanceof RequestMatcherInterface) {
$parameters = $this->matcher->matchRequest($request);
} else {
$parameters = $this->matcher->match($request->getPathInfo());
}
if (null !== $this->logger) {
$this->logger->info(sprintf('Matched route "%s".', isset($parameters['_route']) ? $parameters['_route'] :'n/a'), array('route_parameters'=> $parameters,'request_uri'=> $request->getUri(),
));
}
$request->attributes->add($parameters);
unset($parameters['_route'], $parameters['_controller']);
$request->attributes->set('_route_params', $parameters);
} catch (ResourceNotFoundException $e) {
$message = sprintf('No route found for "%s %s"', $request->getMethod(), $request->getPathInfo());
if ($referer = $request->headers->get('referer')) {
$message .= sprintf(' (from "%s")', $referer);
}
throw new NotFoundHttpException($message, $e);
} catch (MethodNotAllowedException $e) {
$message = sprintf('No route found for "%s %s": Method Not Allowed (Allow: %s)', $request->getMethod(), $request->getPathInfo(), implode(', ', $e->getAllowedMethods()));
throw new MethodNotAllowedHttpException($e->getAllowedMethods(), $message, $e);
}
}
public static function getSubscribedEvents()
{
return array(
KernelEvents::REQUEST => array(array('onKernelRequest', 32)),
KernelEvents::FINISH_REQUEST => array(array('onKernelFinishRequest', 0)),
);
}
}
}
namespace Symfony\Component\HttpKernel\Controller
{
use Symfony\Component\HttpFoundation\Request;
interface ControllerResolverInterface
{
public function getController(Request $request);
public function getArguments(Request $request, $controller);
}
}
namespace Symfony\Component\HttpKernel\Controller
{
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
class ControllerResolver implements ControllerResolverInterface
{
private $logger;
private $supportsVariadic;
private $supportsScalarTypes;
public function __construct(LoggerInterface $logger = null)
{
$this->logger = $logger;
$this->supportsVariadic = method_exists('ReflectionParameter','isVariadic');
$this->supportsScalarTypes = method_exists('ReflectionParameter','getType');
}
public function getController(Request $request)
{
if (!$controller = $request->attributes->get('_controller')) {
if (null !== $this->logger) {
$this->logger->warning('Unable to look for the controller as the "_controller" parameter is missing.');
}
return false;
}
if (\is_array($controller)) {
return $controller;
}
if (\is_object($controller)) {
if (method_exists($controller,'__invoke')) {
return $controller;
}
throw new \InvalidArgumentException(sprintf('Controller "%s" for URI "%s" is not callable.', \get_class($controller), $request->getPathInfo()));
}
if (false === strpos($controller,':')) {
if (method_exists($controller,'__invoke')) {
return $this->instantiateController($controller);
} elseif (\function_exists($controller)) {
return $controller;
}
}
$callable = $this->createController($controller);
if (!\is_callable($callable)) {
throw new \InvalidArgumentException(sprintf('Controller "%s" for URI "%s" is not callable.', $controller, $request->getPathInfo()));
}
return $callable;
}
public function getArguments(Request $request, $controller)
{
if (\is_array($controller)) {
$r = new \ReflectionMethod($controller[0], $controller[1]);
} elseif (\is_object($controller) && !$controller instanceof \Closure) {
$r = new \ReflectionObject($controller);
$r = $r->getMethod('__invoke');
} else {
$r = new \ReflectionFunction($controller);
}
return $this->doGetArguments($request, $controller, $r->getParameters());
}
protected function doGetArguments(Request $request, $controller, array $parameters)
{
$attributes = $request->attributes->all();
$arguments = array();
foreach ($parameters as $param) {
if (array_key_exists($param->name, $attributes)) {
if ($this->supportsVariadic && $param->isVariadic() && \is_array($attributes[$param->name])) {
$arguments = array_merge($arguments, array_values($attributes[$param->name]));
} else {
$arguments[] = $attributes[$param->name];
}
} elseif ($param->getClass() && $param->getClass()->isInstance($request)) {
$arguments[] = $request;
} elseif ($param->isDefaultValueAvailable()) {
$arguments[] = $param->getDefaultValue();
} elseif ($this->supportsScalarTypes && $param->hasType() && $param->allowsNull()) {
$arguments[] = null;
} else {
if (\is_array($controller)) {
$repr = sprintf('%s::%s()', \get_class($controller[0]), $controller[1]);
} elseif (\is_object($controller)) {
$repr = \get_class($controller);
} else {
$repr = $controller;
}
throw new \RuntimeException(sprintf('Controller "%s" requires that you provide a value for the "$%s" argument (because there is no default value or because there is a non optional argument after this one).', $repr, $param->name));
}
}
return $arguments;
}
protected function createController($controller)
{
if (false === strpos($controller,'::')) {
throw new \InvalidArgumentException(sprintf('Unable to find controller "%s".', $controller));
}
list($class, $method) = explode('::', $controller, 2);
if (!class_exists($class)) {
throw new \InvalidArgumentException(sprintf('Class "%s" does not exist.', $class));
}
return array($this->instantiateController($class), $method);
}
protected function instantiateController($class)
{
return new $class();
}
}
}
namespace Symfony\Component\HttpKernel\Event
{
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
class KernelEvent extends Event
{
private $kernel;
private $request;
private $requestType;
public function __construct(HttpKernelInterface $kernel, Request $request, $requestType)
{
$this->kernel = $kernel;
$this->request = $request;
$this->requestType = $requestType;
}
public function getKernel()
{
return $this->kernel;
}
public function getRequest()
{
return $this->request;
}
public function getRequestType()
{
return $this->requestType;
}
public function isMasterRequest()
{
return HttpKernelInterface::MASTER_REQUEST === $this->requestType;
}
}
}
namespace Symfony\Component\HttpKernel\Event
{
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
class FilterControllerEvent extends KernelEvent
{
private $controller;
public function __construct(HttpKernelInterface $kernel, $controller, Request $request, $requestType)
{
parent::__construct($kernel, $request, $requestType);
$this->setController($controller);
}
public function getController()
{
return $this->controller;
}
public function setController($controller)
{
if (!\is_callable($controller)) {
throw new \LogicException(sprintf('The controller must be a callable (%s given).', $this->varToString($controller)));
}
$this->controller = $controller;
}
private function varToString($var)
{
if (\is_object($var)) {
return sprintf('Object(%s)', \get_class($var));
}
if (\is_array($var)) {
$a = array();
foreach ($var as $k => $v) {
$a[] = sprintf('%s => %s', $k, $this->varToString($v));
}
return sprintf('Array(%s)', implode(', ', $a));
}
if (\is_resource($var)) {
return sprintf('Resource(%s)', get_resource_type($var));
}
if (null === $var) {
return'null';
}
if (false === $var) {
return'false';
}
if (true === $var) {
return'true';
}
return (string) $var;
}
}
}
namespace Symfony\Component\HttpKernel\Event
{
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
class FilterResponseEvent extends KernelEvent
{
private $response;
public function __construct(HttpKernelInterface $kernel, Request $request, $requestType, Response $response)
{
parent::__construct($kernel, $request, $requestType);
$this->setResponse($response);
}
public function getResponse()
{
return $this->response;
}
public function setResponse(Response $response)
{
$this->response = $response;
}
}
}
namespace Symfony\Component\HttpKernel\Event
{
use Symfony\Component\HttpFoundation\Response;
class GetResponseEvent extends KernelEvent
{
private $response;
public function getResponse()
{
return $this->response;
}
public function setResponse(Response $response)
{
$this->response = $response;
$this->stopPropagation();
}
public function hasResponse()
{
return null !== $this->response;
}
}
}
namespace Symfony\Component\HttpKernel\Event
{
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
class GetResponseForControllerResultEvent extends GetResponseEvent
{
private $controllerResult;
public function __construct(HttpKernelInterface $kernel, Request $request, $requestType, $controllerResult)
{
parent::__construct($kernel, $request, $requestType);
$this->controllerResult = $controllerResult;
}
public function getControllerResult()
{
return $this->controllerResult;
}
public function setControllerResult($controllerResult)
{
$this->controllerResult = $controllerResult;
}
}
}
namespace Symfony\Component\HttpKernel\Event
{
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
class GetResponseForExceptionEvent extends GetResponseEvent
{
private $exception;
public function __construct(HttpKernelInterface $kernel, Request $request, $requestType, \Exception $e)
{
parent::__construct($kernel, $request, $requestType);
$this->setException($e);
}
public function getException()
{
return $this->exception;
}
public function setException(\Exception $exception)
{
$this->exception = $exception;
}
}
}
namespace Symfony\Component\HttpKernel
{
final class KernelEvents
{
const REQUEST ='kernel.request';
const EXCEPTION ='kernel.exception';
const VIEW ='kernel.view';
const CONTROLLER ='kernel.controller';
const RESPONSE ='kernel.response';
const TERMINATE ='kernel.terminate';
const FINISH_REQUEST ='kernel.finish_request';
}
}
namespace Symfony\Component\HttpKernel\Config
{
use Symfony\Component\Config\FileLocator as BaseFileLocator;
use Symfony\Component\HttpKernel\KernelInterface;
class FileLocator extends BaseFileLocator
{
private $kernel;
private $path;
public function __construct(KernelInterface $kernel, $path = null, array $paths = array())
{
$this->kernel = $kernel;
if (null !== $path) {
$this->path = $path;
$paths[] = $path;
}
parent::__construct($paths);
}
public function locate($file, $currentPath = null, $first = true)
{
if (isset($file[0]) &&'@'=== $file[0]) {
return $this->kernel->locateResource($file, $this->path, $first);
}
return parent::locate($file, $currentPath, $first);
}
}
}
namespace Symfony\Bundle\FrameworkBundle\Controller
{
use Symfony\Component\HttpKernel\KernelInterface;
class ControllerNameParser
{
protected $kernel;
public function __construct(KernelInterface $kernel)
{
$this->kernel = $kernel;
}
public function parse($controller)
{
$parts = explode(':', $controller);
if (3 !== \count($parts) || \in_array('', $parts, true)) {
throw new \InvalidArgumentException(sprintf('The "%s" controller is not a valid "a:b:c" controller string.', $controller));
}
$originalController = $controller;
list($bundle, $controller, $action) = $parts;
$controller = str_replace('/','\\', $controller);
$bundles = array();
try {
$allBundles = $this->kernel->getBundle($bundle, false);
} catch (\InvalidArgumentException $e) {
$message = sprintf('The "%s" (from the _controller value "%s") does not exist or is not enabled in your kernel!',
$bundle,
$originalController
);
if ($alternative = $this->findAlternative($bundle)) {
$message .= sprintf(' Did you mean "%s:%s:%s"?', $alternative, $controller, $action);
}
throw new \InvalidArgumentException($message, 0, $e);
}
foreach ($allBundles as $b) {
$try = $b->getNamespace().'\\Controller\\'.$controller.'Controller';
if (class_exists($try)) {
return $try.'::'.$action.'Action';
}
$bundles[] = $b->getName();
$msg = sprintf('The _controller value "%s:%s:%s" maps to a "%s" class, but this class was not found. Create this class or check the spelling of the class and its namespace.', $bundle, $controller, $action, $try);
}
if (\count($bundles) > 1) {
$msg = sprintf('Unable to find controller "%s:%s" in bundles %s.', $bundle, $controller, implode(', ', $bundles));
}
throw new \InvalidArgumentException($msg);
}
public function build($controller)
{
if (0 === preg_match('#^(.*?\\\\Controller\\\\(.+)Controller)::(.+)Action$#', $controller, $match)) {
throw new \InvalidArgumentException(sprintf('The "%s" controller is not a valid "class::method" string.', $controller));
}
$className = $match[1];
$controllerName = $match[2];
$actionName = $match[3];
foreach ($this->kernel->getBundles() as $name => $bundle) {
if (0 !== strpos($className, $bundle->getNamespace())) {
continue;
}
return sprintf('%s:%s:%s', $name, $controllerName, $actionName);
}
throw new \InvalidArgumentException(sprintf('Unable to find a bundle that defines controller "%s".', $controller));
}
private function findAlternative($nonExistentBundleName)
{
$bundleNames = array_map(function ($b) {
return $b->getName();
}, $this->kernel->getBundles());
$alternative = null;
$shortest = null;
foreach ($bundleNames as $bundleName) {
if (false !== strpos($bundleName, $nonExistentBundleName)) {
return $bundleName;
}
$lev = levenshtein($nonExistentBundleName, $bundleName);
if ($lev <= \strlen($nonExistentBundleName) / 3 && (null === $alternative || $lev < $shortest)) {
$alternative = $bundleName;
$shortest = $lev;
}
}
return $alternative;
}
}
}
namespace Symfony\Bundle\FrameworkBundle\Controller
{
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolver as BaseControllerResolver;
class ControllerResolver extends BaseControllerResolver
{
protected $container;
protected $parser;
public function __construct(ContainerInterface $container, ControllerNameParser $parser, LoggerInterface $logger = null)
{
$this->container = $container;
$this->parser = $parser;
parent::__construct($logger);
}
protected function createController($controller)
{
if (false === strpos($controller,'::')) {
$count = substr_count($controller,':');
if (2 == $count) {
$controller = $this->parser->parse($controller);
} elseif (1 == $count) {
list($service, $method) = explode(':', $controller, 2);
return array($this->container->get($service), $method);
} elseif ($this->container->has($controller) && method_exists($service = $this->container->get($controller),'__invoke')) {
return $service;
} else {
throw new \LogicException(sprintf('Unable to parse the controller name "%s".', $controller));
}
}
return parent::createController($controller);
}
protected function instantiateController($class)
{
if ($this->container->has($class)) {
return $this->container->get($class);
}
$controller = parent::instantiateController($class);
if ($controller instanceof ContainerAwareInterface) {
$controller->setContainer($this->container);
}
return $controller;
}
}
}
namespace Symfony\Component\Security\Http
{
use Symfony\Component\HttpFoundation\Request;
interface AccessMapInterface
{
public function getPatterns(Request $request);
}
}
namespace Symfony\Component\Security\Http
{
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestMatcherInterface;
class AccessMap implements AccessMapInterface
{
private $map = array();
public function add(RequestMatcherInterface $requestMatcher, array $attributes = array(), $channel = null)
{
$this->map[] = array($requestMatcher, $attributes, $channel);
}
public function getPatterns(Request $request)
{
foreach ($this->map as $elements) {
if (null === $elements[0] || $elements[0]->matches($request)) {
return array($elements[1], $elements[2]);
}
}
return array(null, null);
}
}
}
namespace Symfony\Component\Security\Http
{
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FinishRequestEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Http\Firewall\AccessListener;
class Firewall implements EventSubscriberInterface
{
private $map;
private $dispatcher;
private $exceptionListeners;
public function __construct(FirewallMapInterface $map, EventDispatcherInterface $dispatcher)
{
$this->map = $map;
$this->dispatcher = $dispatcher;
$this->exceptionListeners = new \SplObjectStorage();
}
public function onKernelRequest(GetResponseEvent $event)
{
if (!$event->isMasterRequest()) {
return;
}
$listeners = $this->map->getListeners($event->getRequest());
$authenticationListeners = $listeners[0];
$exceptionListener = $listeners[1];
$logoutListener = isset($listeners[2]) ? $listeners[2] : null;
if (null !== $exceptionListener) {
$this->exceptionListeners[$event->getRequest()] = $exceptionListener;
$exceptionListener->register($this->dispatcher);
}
$accessListener = null;
foreach ($authenticationListeners as $listener) {
if ($listener instanceof AccessListener) {
$accessListener = $listener;
continue;
}
$listener->handle($event);
if ($event->hasResponse()) {
break;
}
}
if (null !== $logoutListener) {
$logoutListener->handle($event);
}
if (!$event->hasResponse() && null !== $accessListener) {
$accessListener->handle($event);
}
}
public function onKernelFinishRequest(FinishRequestEvent $event)
{
$request = $event->getRequest();
if (isset($this->exceptionListeners[$request])) {
$this->exceptionListeners[$request]->unregister($this->dispatcher);
unset($this->exceptionListeners[$request]);
}
}
public static function getSubscribedEvents()
{
return array(
KernelEvents::REQUEST => array('onKernelRequest', 8),
KernelEvents::FINISH_REQUEST =>'onKernelFinishRequest',
);
}
}
}
namespace Symfony\Component\Security\Core\User
{
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
interface UserProviderInterface
{
public function loadUserByUsername($username);
public function refreshUser(UserInterface $user);
public function supportsClass($class);
}
}
namespace Symfony\Component\Security\Core\Authentication
{
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
interface AuthenticationManagerInterface
{
public function authenticate(TokenInterface $token);
}
}
namespace Symfony\Component\Security\Core\Authentication
{
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\AuthenticationEvents;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;
use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;
use Symfony\Component\Security\Core\Exception\AccountStatusException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\ProviderNotFoundException;
class AuthenticationProviderManager implements AuthenticationManagerInterface
{
private $providers;
private $eraseCredentials;
private $eventDispatcher;
public function __construct(array $providers, $eraseCredentials = true)
{
if (!$providers) {
throw new \InvalidArgumentException('You must at least add one authentication provider.');
}
foreach ($providers as $provider) {
if (!$provider instanceof AuthenticationProviderInterface) {
throw new \InvalidArgumentException(sprintf('Provider "%s" must implement the AuthenticationProviderInterface.', \get_class($provider)));
}
}
$this->providers = $providers;
$this->eraseCredentials = (bool) $eraseCredentials;
}
public function setEventDispatcher(EventDispatcherInterface $dispatcher)
{
$this->eventDispatcher = $dispatcher;
}
public function authenticate(TokenInterface $token)
{
$lastException = null;
$result = null;
foreach ($this->providers as $provider) {
if (!$provider->supports($token)) {
continue;
}
try {
$result = $provider->authenticate($token);
if (null !== $result) {
break;
}
} catch (AccountStatusException $e) {
$lastException = $e;
break;
} catch (AuthenticationException $e) {
$lastException = $e;
}
}
if (null !== $result) {
if (true === $this->eraseCredentials) {
$result->eraseCredentials();
}
if (null !== $this->eventDispatcher) {
$this->eventDispatcher->dispatch(AuthenticationEvents::AUTHENTICATION_SUCCESS, new AuthenticationEvent($result));
}
return $result;
}
if (null === $lastException) {
$lastException = new ProviderNotFoundException(sprintf('No Authentication Provider found for token of class "%s".', \get_class($token)));
}
if (null !== $this->eventDispatcher) {
$this->eventDispatcher->dispatch(AuthenticationEvents::AUTHENTICATION_FAILURE, new AuthenticationFailureEvent($token, $lastException));
}
$lastException->setToken($token);
throw $lastException;
}
}
}
namespace Symfony\Component\Security\Core\Authentication\Token\Storage
{
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
interface TokenStorageInterface
{
public function getToken();
public function setToken(TokenInterface $token = null);
}
}
namespace Symfony\Component\Security\Core\Authentication\Token\Storage
{
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
class TokenStorage implements TokenStorageInterface
{
private $token;
public function getToken()
{
return $this->token;
}
public function setToken(TokenInterface $token = null)
{
$this->token = $token;
}
}
}
namespace Symfony\Component\Security\Core\Authorization
{
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
interface AccessDecisionManagerInterface
{
public function decide(TokenInterface $token, array $attributes, $object = null);
public function supportsAttribute($attribute);
public function supportsClass($class);
}
}
namespace Symfony\Component\Security\Core\Authorization
{
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
class AccessDecisionManager implements AccessDecisionManagerInterface
{
const STRATEGY_AFFIRMATIVE ='affirmative';
const STRATEGY_CONSENSUS ='consensus';
const STRATEGY_UNANIMOUS ='unanimous';
private $voters;
private $strategy;
private $allowIfAllAbstainDecisions;
private $allowIfEqualGrantedDeniedDecisions;
public function __construct(array $voters = array(), $strategy = self::STRATEGY_AFFIRMATIVE, $allowIfAllAbstainDecisions = false, $allowIfEqualGrantedDeniedDecisions = true)
{
$strategyMethod ='decide'.ucfirst($strategy);
if (!\is_callable(array($this, $strategyMethod))) {
throw new \InvalidArgumentException(sprintf('The strategy "%s" is not supported.', $strategy));
}
$this->voters = $voters;
$this->strategy = $strategyMethod;
$this->allowIfAllAbstainDecisions = (bool) $allowIfAllAbstainDecisions;
$this->allowIfEqualGrantedDeniedDecisions = (bool) $allowIfEqualGrantedDeniedDecisions;
}
public function setVoters(array $voters)
{
$this->voters = $voters;
}
public function decide(TokenInterface $token, array $attributes, $object = null)
{
return $this->{$this->strategy}($token, $attributes, $object);
}
public function supportsAttribute($attribute)
{
@trigger_error('The '.__METHOD__.' is deprecated since Symfony 2.8 and will be removed in version 3.0.', E_USER_DEPRECATED);
foreach ($this->voters as $voter) {
if ($voter->supportsAttribute($attribute)) {
return true;
}
}
return false;
}
public function supportsClass($class)
{
@trigger_error('The '.__METHOD__.' is deprecated since Symfony 2.8 and will be removed in version 3.0.', E_USER_DEPRECATED);
foreach ($this->voters as $voter) {
if ($voter->supportsClass($class)) {
return true;
}
}
return false;
}
private function decideAffirmative(TokenInterface $token, array $attributes, $object = null)
{
$deny = 0;
foreach ($this->voters as $voter) {
$result = $voter->vote($token, $object, $attributes);
switch ($result) {
case VoterInterface::ACCESS_GRANTED:
return true;
case VoterInterface::ACCESS_DENIED:
++$deny;
break;
default:
break;
}
}
if ($deny > 0) {
return false;
}
return $this->allowIfAllAbstainDecisions;
}
private function decideConsensus(TokenInterface $token, array $attributes, $object = null)
{
$grant = 0;
$deny = 0;
foreach ($this->voters as $voter) {
$result = $voter->vote($token, $object, $attributes);
switch ($result) {
case VoterInterface::ACCESS_GRANTED:
++$grant;
break;
case VoterInterface::ACCESS_DENIED:
++$deny;
break;
}
}
if ($grant > $deny) {
return true;
}
if ($deny > $grant) {
return false;
}
if ($grant > 0) {
return $this->allowIfEqualGrantedDeniedDecisions;
}
return $this->allowIfAllAbstainDecisions;
}
private function decideUnanimous(TokenInterface $token, array $attributes, $object = null)
{
$grant = 0;
foreach ($attributes as $attribute) {
foreach ($this->voters as $voter) {
$result = $voter->vote($token, $object, array($attribute));
switch ($result) {
case VoterInterface::ACCESS_GRANTED:
++$grant;
break;
case VoterInterface::ACCESS_DENIED:
return false;
default:
break;
}
}
}
if ($grant > 0) {
return true;
}
return $this->allowIfAllAbstainDecisions;
}
}
}
namespace Symfony\Component\Security\Core\Authorization
{
interface AuthorizationCheckerInterface
{
public function isGranted($attributes, $object = null);
}
}
namespace Symfony\Component\Security\Core\Authorization
{
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;
class AuthorizationChecker implements AuthorizationCheckerInterface
{
private $tokenStorage;
private $accessDecisionManager;
private $authenticationManager;
private $alwaysAuthenticate;
public function __construct(TokenStorageInterface $tokenStorage, AuthenticationManagerInterface $authenticationManager, AccessDecisionManagerInterface $accessDecisionManager, $alwaysAuthenticate = false)
{
$this->tokenStorage = $tokenStorage;
$this->authenticationManager = $authenticationManager;
$this->accessDecisionManager = $accessDecisionManager;
$this->alwaysAuthenticate = $alwaysAuthenticate;
}
final public function isGranted($attributes, $object = null)
{
if (null === ($token = $this->tokenStorage->getToken())) {
throw new AuthenticationCredentialsNotFoundException('The token storage contains no authentication token. One possible reason may be that there is no firewall configured for this URL.');
}
if ($this->alwaysAuthenticate || !$token->isAuthenticated()) {
$this->tokenStorage->setToken($token = $this->authenticationManager->authenticate($token));
}
if (!\is_array($attributes)) {
$attributes = array($attributes);
}
return $this->accessDecisionManager->decide($token, $attributes, $object);
}
}
}
namespace Symfony\Component\Security\Core\Authorization\Voter
{
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
interface VoterInterface
{
const ACCESS_GRANTED = 1;
const ACCESS_ABSTAIN = 0;
const ACCESS_DENIED = -1;
public function supportsAttribute($attribute);
public function supportsClass($class);
public function vote(TokenInterface $token, $object, array $attributes);
}
}
namespace Symfony\Component\Security\Http
{
use Symfony\Component\HttpFoundation\Request;
interface FirewallMapInterface
{
public function getListeners(Request $request);
}
}
namespace Symfony\Bundle\SecurityBundle\Security
{
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\FirewallMapInterface;
class FirewallMap implements FirewallMapInterface
{
protected $container;
protected $map;
public function __construct(ContainerInterface $container, array $map)
{
$this->container = $container;
$this->map = $map;
}
public function getListeners(Request $request)
{
foreach ($this->map as $contextId => $requestMatcher) {
if (null === $requestMatcher || $requestMatcher->matches($request)) {
return $this->container->get($contextId)->getContext();
}
}
return array(array(), null, null);
}
}
}
namespace Symfony\Bundle\SecurityBundle\Security
{
use Symfony\Component\Security\Http\Firewall\ExceptionListener;
use Symfony\Component\Security\Http\Firewall\LogoutListener;
class FirewallContext
{
private $listeners;
private $exceptionListener;
private $logoutListener;
public function __construct(array $listeners, ExceptionListener $exceptionListener = null, LogoutListener $logoutListener = null)
{
$this->listeners = $listeners;
$this->exceptionListener = $exceptionListener;
$this->logoutListener = $logoutListener;
}
public function getContext()
{
return array($this->listeners, $this->exceptionListener, $this->logoutListener);
}
}
}
namespace Symfony\Component\HttpFoundation
{
interface RequestMatcherInterface
{
public function matches(Request $request);
}
}
namespace Symfony\Component\HttpFoundation
{
class RequestMatcher implements RequestMatcherInterface
{
private $path;
private $host;
private $methods = array();
private $ips = array();
private $attributes = array();
private $schemes = array();
public function __construct($path = null, $host = null, $methods = null, $ips = null, array $attributes = array(), $schemes = null)
{
$this->matchPath($path);
$this->matchHost($host);
$this->matchMethod($methods);
$this->matchIps($ips);
$this->matchScheme($schemes);
foreach ($attributes as $k => $v) {
$this->matchAttribute($k, $v);
}
}
public function matchScheme($scheme)
{
$this->schemes = null !== $scheme ? array_map('strtolower', (array) $scheme) : array();
}
public function matchHost($regexp)
{
$this->host = $regexp;
}
public function matchPath($regexp)
{
$this->path = $regexp;
}
public function matchIp($ip)
{
$this->matchIps($ip);
}
public function matchIps($ips)
{
$this->ips = null !== $ips ? (array) $ips : array();
}
public function matchMethod($method)
{
$this->methods = null !== $method ? array_map('strtoupper', (array) $method) : array();
}
public function matchAttribute($key, $regexp)
{
$this->attributes[$key] = $regexp;
}
public function matches(Request $request)
{
if ($this->schemes && !\in_array($request->getScheme(), $this->schemes, true)) {
return false;
}
if ($this->methods && !\in_array($request->getMethod(), $this->methods, true)) {
return false;
}
foreach ($this->attributes as $key => $pattern) {
if (!preg_match('{'.$pattern.'}', $request->attributes->get($key))) {
return false;
}
}
if (null !== $this->path && !preg_match('{'.$this->path.'}', rawurldecode($request->getPathInfo()))) {
return false;
}
if (null !== $this->host && !preg_match('{'.$this->host.'}i', $request->getHost())) {
return false;
}
if (IpUtils::checkIp($request->getClientIp(), $this->ips)) {
return true;
}
return 0 === \count($this->ips);
}
}
}
namespace Twig
{
use Twig\Cache\CacheInterface;
use Twig\Cache\FilesystemCache;
use Twig\Cache\NullCache;
use Twig\Error\Error;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\CoreExtension;
use Twig\Extension\EscaperExtension;
use Twig\Extension\ExtensionInterface;
use Twig\Extension\OptimizerExtension;
use Twig\Loader\ArrayLoader;
use Twig\Loader\ChainLoader;
use Twig\Loader\LoaderInterface;
use Twig\Node\ModuleNode;
use Twig\Node\Node;
use Twig\NodeVisitor\NodeVisitorInterface;
use Twig\RuntimeLoader\RuntimeLoaderInterface;
use Twig\TokenParser\TokenParserInterface;
class Environment
{
const VERSION ='2.8.1';
const VERSION_ID = 20801;
const MAJOR_VERSION = 2;
const MINOR_VERSION = 8;
const RELEASE_VERSION = 1;
const EXTRA_VERSION ='';
private $charset;
private $loader;
private $debug;
private $autoReload;
private $cache;
private $lexer;
private $parser;
private $compiler;
private $baseTemplateClass;
private $globals = [];
private $resolvedGlobals;
private $loadedTemplates;
private $strictVariables;
private $templateClassPrefix ='__TwigTemplate_';
private $originalCache;
private $extensionSet;
private $runtimeLoaders = [];
private $runtimes = [];
private $optionsHash;
public function __construct(LoaderInterface $loader, $options = [])
{
$this->setLoader($loader);
$options = array_merge(['debug'=> false,'charset'=>'UTF-8','base_template_class'=> Template::class,'strict_variables'=> false,'autoescape'=>'html','cache'=> false,'auto_reload'=> null,'optimizations'=> -1,
], $options);
$this->debug = (bool) $options['debug'];
$this->setCharset($options['charset']);
$this->baseTemplateClass ='\\'.ltrim($options['base_template_class'],'\\');
if ('\\'.Template::class !== $this->baseTemplateClass &&'\Twig_Template'!== $this->baseTemplateClass) {
@trigger_error('The "base_template_class" option on '.__CLASS__.' is deprecated since Twig 2.7.0.', E_USER_DEPRECATED);
}
$this->autoReload = null === $options['auto_reload'] ? $this->debug : (bool) $options['auto_reload'];
$this->strictVariables = (bool) $options['strict_variables'];
$this->setCache($options['cache']);
$this->extensionSet = new ExtensionSet();
$this->addExtension(new CoreExtension());
$this->addExtension(new EscaperExtension($options['autoescape']));
$this->addExtension(new OptimizerExtension($options['optimizations']));
}
public function getBaseTemplateClass()
{
if (1 > \func_num_args() || \func_get_arg(0)) {
@trigger_error('The '.__METHOD__.' is deprecated since Twig 2.7.0.', E_USER_DEPRECATED);
}
return $this->baseTemplateClass;
}
public function setBaseTemplateClass($class)
{
@trigger_error('The '.__METHOD__.' is deprecated since Twig 2.7.0.', E_USER_DEPRECATED);
$this->baseTemplateClass = $class;
$this->updateOptionsHash();
}
public function enableDebug()
{
$this->debug = true;
$this->updateOptionsHash();
}
public function disableDebug()
{
$this->debug = false;
$this->updateOptionsHash();
}
public function isDebug()
{
return $this->debug;
}
public function enableAutoReload()
{
$this->autoReload = true;
}
public function disableAutoReload()
{
$this->autoReload = false;
}
public function isAutoReload()
{
return $this->autoReload;
}
public function enableStrictVariables()
{
$this->strictVariables = true;
$this->updateOptionsHash();
}
public function disableStrictVariables()
{
$this->strictVariables = false;
$this->updateOptionsHash();
}
public function isStrictVariables()
{
return $this->strictVariables;
}
public function getCache($original = true)
{
return $original ? $this->originalCache : $this->cache;
}
public function setCache($cache)
{
if (\is_string($cache)) {
$this->originalCache = $cache;
$this->cache = new FilesystemCache($cache);
} elseif (false === $cache) {
$this->originalCache = $cache;
$this->cache = new NullCache();
} elseif ($cache instanceof CacheInterface) {
$this->originalCache = $this->cache = $cache;
} else {
throw new \LogicException(sprintf('Cache can only be a string, false, or a \Twig\Cache\CacheInterface implementation.'));
}
}
public function getTemplateClass($name, $index = null)
{
$key = $this->getLoader()->getCacheKey($name).$this->optionsHash;
return $this->templateClassPrefix.hash('sha256', $key).(null === $index ?'':'___'.$index);
}
public function render($name, array $context = [])
{
return $this->load($name)->render($context);
}
public function display($name, array $context = [])
{
$this->load($name)->display($context);
}
public function load($name)
{
if ($name instanceof TemplateWrapper) {
return $name;
}
if ($name instanceof Template) {
@trigger_error('Passing a \Twig\Template instance to '.__METHOD__.' is deprecated since Twig 2.7.0, use \Twig\TemplateWrapper instead.', E_USER_DEPRECATED);
return new TemplateWrapper($this, $name);
}
return new TemplateWrapper($this, $this->loadTemplate($name));
}
public function loadTemplate($name, $index = null)
{
return $this->loadClass($this->getTemplateClass($name), $name, $index);
}
public function loadClass($cls, $name, $index = null)
{
$mainCls = $cls;
if (null !== $index) {
$cls .='___'.$index;
}
if (isset($this->loadedTemplates[$cls])) {
return $this->loadedTemplates[$cls];
}
if (!class_exists($cls, false)) {
$key = $this->cache->generateKey($name, $mainCls);
if (!$this->isAutoReload() || $this->isTemplateFresh($name, $this->cache->getTimestamp($key))) {
$this->cache->load($key);
}
$source = null;
if (!class_exists($cls, false)) {
$source = $this->getLoader()->getSourceContext($name);
$content = $this->compileSource($source);
$this->cache->write($key, $content);
$this->cache->load($key);
if (!class_exists($mainCls, false)) {
eval('?>'.$content);
}
if (!class_exists($cls, false)) {
throw new RuntimeError(sprintf('Failed to load Twig template "%s", index "%s": cache might be corrupted.', $name, $index), -1, $source);
}
}
}
$this->extensionSet->initRuntime($this);
return $this->loadedTemplates[$cls] = new $cls($this);
}
public function createTemplate($template, string $name = null)
{
$hash = hash('sha256', $template, false);
if (null !== $name) {
$name = sprintf('%s (string template %s)', $name, $hash);
} else {
$name = sprintf('__string_template__%s', $hash);
}
$loader = new ChainLoader([
new ArrayLoader([$name => $template]),
$current = $this->getLoader(),
]);
$this->setLoader($loader);
try {
return new TemplateWrapper($this, $this->loadTemplate($name));
} finally {
$this->setLoader($current);
}
}
public function isTemplateFresh($name, $time)
{
return $this->extensionSet->getLastModified() <= $time && $this->getLoader()->isFresh($name, $time);
}
public function resolveTemplate($names)
{
if (!\is_array($names)) {
$names = [$names];
}
foreach ($names as $name) {
if ($name instanceof Template) {
return $name;
}
if ($name instanceof TemplateWrapper) {
return $name;
}
try {
return $this->loadTemplate($name);
} catch (LoaderError $e) {
if (1 === \count($names)) {
throw $e;
}
}
}
throw new LoaderError(sprintf('Unable to find one of the following templates: "%s".', implode('", "', $names)));
}
public function setLexer(Lexer $lexer)
{
$this->lexer = $lexer;
}
public function tokenize(Source $source)
{
if (null === $this->lexer) {
$this->lexer = new Lexer($this);
}
return $this->lexer->tokenize($source);
}
public function setParser(Parser $parser)
{
$this->parser = $parser;
}
public function parse(TokenStream $stream)
{
if (null === $this->parser) {
$this->parser = new Parser($this);
}
return $this->parser->parse($stream);
}
public function setCompiler(Compiler $compiler)
{
$this->compiler = $compiler;
}
public function compile(Node $node)
{
if (null === $this->compiler) {
$this->compiler = new Compiler($this);
}
return $this->compiler->compile($node)->getSource();
}
public function compileSource(Source $source)
{
try {
return $this->compile($this->parse($this->tokenize($source)));
} catch (Error $e) {
$e->setSourceContext($source);
throw $e;
} catch (\Exception $e) {
throw new SyntaxError(sprintf('An exception has been thrown during the compilation of a template ("%s").', $e->getMessage()), -1, $source, $e);
}
}
public function setLoader(LoaderInterface $loader)
{
$this->loader = $loader;
}
public function getLoader()
{
return $this->loader;
}
public function setCharset($charset)
{
if ('UTF8'=== $charset = strtoupper($charset)) {
$charset ='UTF-8';
}
$this->charset = $charset;
}
public function getCharset()
{
return $this->charset;
}
public function hasExtension($class)
{
return $this->extensionSet->hasExtension($class);
}
public function addRuntimeLoader(RuntimeLoaderInterface $loader)
{
$this->runtimeLoaders[] = $loader;
}
public function getExtension($class)
{
return $this->extensionSet->getExtension($class);
}
public function getRuntime($class)
{
if (isset($this->runtimes[$class])) {
return $this->runtimes[$class];
}
foreach ($this->runtimeLoaders as $loader) {
if (null !== $runtime = $loader->load($class)) {
return $this->runtimes[$class] = $runtime;
}
}
throw new RuntimeError(sprintf('Unable to load the "%s" runtime.', $class));
}
public function addExtension(ExtensionInterface $extension)
{
$this->extensionSet->addExtension($extension);
$this->updateOptionsHash();
}
public function setExtensions(array $extensions)
{
$this->extensionSet->setExtensions($extensions);
$this->updateOptionsHash();
}
public function getExtensions()
{
return $this->extensionSet->getExtensions();
}
public function addTokenParser(TokenParserInterface $parser)
{
$this->extensionSet->addTokenParser($parser);
}
public function getTokenParsers()
{
return $this->extensionSet->getTokenParsers();
}
public function getTags()
{
$tags = [];
foreach ($this->getTokenParsers() as $parser) {
$tags[$parser->getTag()] = $parser;
}
return $tags;
}
public function addNodeVisitor(NodeVisitorInterface $visitor)
{
$this->extensionSet->addNodeVisitor($visitor);
}
public function getNodeVisitors()
{
return $this->extensionSet->getNodeVisitors();
}
public function addFilter(TwigFilter $filter)
{
$this->extensionSet->addFilter($filter);
}
public function getFilter($name)
{
return $this->extensionSet->getFilter($name);
}
public function registerUndefinedFilterCallback(callable $callable)
{
$this->extensionSet->registerUndefinedFilterCallback($callable);
}
public function getFilters()
{
return $this->extensionSet->getFilters();
}
public function addTest(TwigTest $test)
{
$this->extensionSet->addTest($test);
}
public function getTests()
{
return $this->extensionSet->getTests();
}
public function getTest($name)
{
return $this->extensionSet->getTest($name);
}
public function addFunction(TwigFunction $function)
{
$this->extensionSet->addFunction($function);
}
public function getFunction($name)
{
return $this->extensionSet->getFunction($name);
}
public function registerUndefinedFunctionCallback(callable $callable)
{
$this->extensionSet->registerUndefinedFunctionCallback($callable);
}
public function getFunctions()
{
return $this->extensionSet->getFunctions();
}
public function addGlobal($name, $value)
{
if ($this->extensionSet->isInitialized() && !\array_key_exists($name, $this->getGlobals())) {
throw new \LogicException(sprintf('Unable to add global "%s" as the runtime or the extensions have already been initialized.', $name));
}
if (null !== $this->resolvedGlobals) {
$this->resolvedGlobals[$name] = $value;
} else {
$this->globals[$name] = $value;
}
}
public function getGlobals()
{
if ($this->extensionSet->isInitialized()) {
if (null === $this->resolvedGlobals) {
$this->resolvedGlobals = array_merge($this->extensionSet->getGlobals(), $this->globals);
}
return $this->resolvedGlobals;
}
return array_merge($this->extensionSet->getGlobals(), $this->globals);
}
public function mergeGlobals(array $context)
{
foreach ($this->getGlobals() as $key => $value) {
if (!\array_key_exists($key, $context)) {
$context[$key] = $value;
}
}
return $context;
}
public function getUnaryOperators()
{
return $this->extensionSet->getUnaryOperators();
}
public function getBinaryOperators()
{
return $this->extensionSet->getBinaryOperators();
}
private function updateOptionsHash()
{
$this->optionsHash = implode(':', [
$this->extensionSet->getSignature(),
PHP_MAJOR_VERSION,
PHP_MINOR_VERSION,
self::VERSION,
(int) $this->debug,
$this->baseTemplateClass,
(int) $this->strictVariables,
]);
}
}
class_alias('Twig\Environment','Twig_Environment');
}
namespace Twig\Extension
{
use Twig\NodeVisitor\NodeVisitorInterface;
use Twig\TokenParser\TokenParserInterface;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\TwigTest;
interface ExtensionInterface
{
public function getTokenParsers();
public function getNodeVisitors();
public function getFilters();
public function getTests();
public function getFunctions();
public function getOperators();
}
class_alias('Twig\Extension\ExtensionInterface','Twig_ExtensionInterface');
class_exists('Twig\Environment');
}
namespace Twig\Extension
{
abstract class AbstractExtension implements ExtensionInterface
{
public function getTokenParsers()
{
return [];
}
public function getNodeVisitors()
{
return [];
}
public function getFilters()
{
return [];
}
public function getTests()
{
return [];
}
public function getFunctions()
{
return [];
}
public function getOperators()
{
return [];
}
}
class_alias('Twig\Extension\AbstractExtension','Twig_Extension');
}
namespace Twig\Extension {
use Twig\ExpressionParser;
use Twig\Node\Expression\Binary\AddBinary;
use Twig\Node\Expression\Binary\AndBinary;
use Twig\Node\Expression\Binary\BitwiseAndBinary;
use Twig\Node\Expression\Binary\BitwiseOrBinary;
use Twig\Node\Expression\Binary\BitwiseXorBinary;
use Twig\Node\Expression\Binary\ConcatBinary;
use Twig\Node\Expression\Binary\DivBinary;
use Twig\Node\Expression\Binary\EndsWithBinary;
use Twig\Node\Expression\Binary\EqualBinary;
use Twig\Node\Expression\Binary\FloorDivBinary;
use Twig\Node\Expression\Binary\GreaterBinary;
use Twig\Node\Expression\Binary\GreaterEqualBinary;
use Twig\Node\Expression\Binary\InBinary;
use Twig\Node\Expression\Binary\LessBinary;
use Twig\Node\Expression\Binary\LessEqualBinary;
use Twig\Node\Expression\Binary\MatchesBinary;
use Twig\Node\Expression\Binary\ModBinary;
use Twig\Node\Expression\Binary\MulBinary;
use Twig\Node\Expression\Binary\NotEqualBinary;
use Twig\Node\Expression\Binary\NotInBinary;
use Twig\Node\Expression\Binary\OrBinary;
use Twig\Node\Expression\Binary\PowerBinary;
use Twig\Node\Expression\Binary\RangeBinary;
use Twig\Node\Expression\Binary\StartsWithBinary;
use Twig\Node\Expression\Binary\SubBinary;
use Twig\Node\Expression\Filter\DefaultFilter;
use Twig\Node\Expression\NullCoalesceExpression;
use Twig\Node\Expression\Test\ConstantTest;
use Twig\Node\Expression\Test\DefinedTest;
use Twig\Node\Expression\Test\DivisiblebyTest;
use Twig\Node\Expression\Test\EvenTest;
use Twig\Node\Expression\Test\NullTest;
use Twig\Node\Expression\Test\OddTest;
use Twig\Node\Expression\Test\SameasTest;
use Twig\Node\Expression\Unary\NegUnary;
use Twig\Node\Expression\Unary\NotUnary;
use Twig\Node\Expression\Unary\PosUnary;
use Twig\TokenParser\BlockTokenParser;
use Twig\TokenParser\DeprecatedTokenParser;
use Twig\TokenParser\DoTokenParser;
use Twig\TokenParser\EmbedTokenParser;
use Twig\TokenParser\ExtendsTokenParser;
use Twig\TokenParser\FilterTokenParser;
use Twig\TokenParser\FlushTokenParser;
use Twig\TokenParser\ForTokenParser;
use Twig\TokenParser\FromTokenParser;
use Twig\TokenParser\IfTokenParser;
use Twig\TokenParser\ImportTokenParser;
use Twig\TokenParser\IncludeTokenParser;
use Twig\TokenParser\MacroTokenParser;
use Twig\TokenParser\SetTokenParser;
use Twig\TokenParser\SpacelessTokenParser;
use Twig\TokenParser\UseTokenParser;
use Twig\TokenParser\WithTokenParser;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\TwigTest;
final class CoreExtension extends AbstractExtension
{
private $dateFormats = ['F j, Y H:i','%d days'];
private $numberFormat = [0,'.',','];
private $timezone = null;
private $escapers = [];
public function setEscaper($strategy, callable $callable)
{
$this->escapers[$strategy] = $callable;
}
public function getEscapers()
{
return $this->escapers;
}
public function setDateFormat($format = null, $dateIntervalFormat = null)
{
if (null !== $format) {
$this->dateFormats[0] = $format;
}
if (null !== $dateIntervalFormat) {
$this->dateFormats[1] = $dateIntervalFormat;
}
}
public function getDateFormat()
{
return $this->dateFormats;
}
public function setTimezone($timezone)
{
$this->timezone = $timezone instanceof \DateTimeZone ? $timezone : new \DateTimeZone($timezone);
}
public function getTimezone()
{
if (null === $this->timezone) {
$this->timezone = new \DateTimeZone(date_default_timezone_get());
}
return $this->timezone;
}
public function setNumberFormat($decimal, $decimalPoint, $thousandSep)
{
$this->numberFormat = [$decimal, $decimalPoint, $thousandSep];
}
public function getNumberFormat()
{
return $this->numberFormat;
}
public function getTokenParsers()
{
return [
new ForTokenParser(),
new IfTokenParser(),
new ExtendsTokenParser(),
new IncludeTokenParser(),
new BlockTokenParser(),
new UseTokenParser(),
new FilterTokenParser(),
new MacroTokenParser(),
new ImportTokenParser(),
new FromTokenParser(),
new SetTokenParser(),
new SpacelessTokenParser(),
new FlushTokenParser(),
new DoTokenParser(),
new EmbedTokenParser(),
new WithTokenParser(),
new DeprecatedTokenParser(),
];
}
public function getFilters()
{
return [
new TwigFilter('date','twig_date_format_filter', ['needs_environment'=> true]),
new TwigFilter('date_modify','twig_date_modify_filter', ['needs_environment'=> true]),
new TwigFilter('format','sprintf'),
new TwigFilter('replace','twig_replace_filter'),
new TwigFilter('number_format','twig_number_format_filter', ['needs_environment'=> true]),
new TwigFilter('abs','abs'),
new TwigFilter('round','twig_round'),
new TwigFilter('url_encode','twig_urlencode_filter'),
new TwigFilter('json_encode','json_encode'),
new TwigFilter('convert_encoding','twig_convert_encoding'),
new TwigFilter('title','twig_title_string_filter', ['needs_environment'=> true]),
new TwigFilter('capitalize','twig_capitalize_string_filter', ['needs_environment'=> true]),
new TwigFilter('upper','twig_upper_filter', ['needs_environment'=> true]),
new TwigFilter('lower','twig_lower_filter', ['needs_environment'=> true]),
new TwigFilter('striptags','strip_tags'),
new TwigFilter('trim','twig_trim_filter'),
new TwigFilter('nl2br','nl2br', ['pre_escape'=>'html','is_safe'=> ['html']]),
new TwigFilter('spaceless','twig_spaceless', ['is_safe'=> ['html']]),
new TwigFilter('join','twig_join_filter'),
new TwigFilter('split','twig_split_filter', ['needs_environment'=> true]),
new TwigFilter('sort','twig_sort_filter'),
new TwigFilter('merge','twig_array_merge'),
new TwigFilter('batch','twig_array_batch'),
new TwigFilter('column','twig_array_column'),
new TwigFilter('reverse','twig_reverse_filter', ['needs_environment'=> true]),
new TwigFilter('length','twig_length_filter', ['needs_environment'=> true]),
new TwigFilter('slice','twig_slice', ['needs_environment'=> true]),
new TwigFilter('first','twig_first', ['needs_environment'=> true]),
new TwigFilter('last','twig_last', ['needs_environment'=> true]),
new TwigFilter('default','_twig_default_filter', ['node_class'=> DefaultFilter::class]),
new TwigFilter('keys','twig_get_array_keys_filter'),
new TwigFilter('escape','twig_escape_filter', ['needs_environment'=> true,'is_safe_callback'=>'twig_escape_filter_is_safe']),
new TwigFilter('e','twig_escape_filter', ['needs_environment'=> true,'is_safe_callback'=>'twig_escape_filter_is_safe']),
];
}
public function getFunctions()
{
return [
new TwigFunction('max','max'),
new TwigFunction('min','min'),
new TwigFunction('range','range'),
new TwigFunction('constant','twig_constant'),
new TwigFunction('cycle','twig_cycle'),
new TwigFunction('random','twig_random', ['needs_environment'=> true]),
new TwigFunction('date','twig_date_converter', ['needs_environment'=> true]),
new TwigFunction('include','twig_include', ['needs_environment'=> true,'needs_context'=> true,'is_safe'=> ['all']]),
new TwigFunction('source','twig_source', ['needs_environment'=> true,'is_safe'=> ['all']]),
];
}
public function getTests()
{
return [
new TwigTest('even', null, ['node_class'=> EvenTest::class]),
new TwigTest('odd', null, ['node_class'=> OddTest::class]),
new TwigTest('defined', null, ['node_class'=> DefinedTest::class]),
new TwigTest('same as', null, ['node_class'=> SameasTest::class]),
new TwigTest('none', null, ['node_class'=> NullTest::class]),
new TwigTest('null', null, ['node_class'=> NullTest::class]),
new TwigTest('divisible by', null, ['node_class'=> DivisiblebyTest::class]),
new TwigTest('constant', null, ['node_class'=> ConstantTest::class]),
new TwigTest('empty','twig_test_empty'),
new TwigTest('iterable','twig_test_iterable'),
];
}
public function getOperators()
{
return [
['not'=> ['precedence'=> 50,'class'=> NotUnary::class],'-'=> ['precedence'=> 500,'class'=> NegUnary::class],'+'=> ['precedence'=> 500,'class'=> PosUnary::class],
],
['or'=> ['precedence'=> 10,'class'=> OrBinary::class,'associativity'=> ExpressionParser::OPERATOR_LEFT],'and'=> ['precedence'=> 15,'class'=> AndBinary::class,'associativity'=> ExpressionParser::OPERATOR_LEFT],'b-or'=> ['precedence'=> 16,'class'=> BitwiseOrBinary::class,'associativity'=> ExpressionParser::OPERATOR_LEFT],'b-xor'=> ['precedence'=> 17,'class'=> BitwiseXorBinary::class,'associativity'=> ExpressionParser::OPERATOR_LEFT],'b-and'=> ['precedence'=> 18,'class'=> BitwiseAndBinary::class,'associativity'=> ExpressionParser::OPERATOR_LEFT],'=='=> ['precedence'=> 20,'class'=> EqualBinary::class,'associativity'=> ExpressionParser::OPERATOR_LEFT],'!='=> ['precedence'=> 20,'class'=> NotEqualBinary::class,'associativity'=> ExpressionParser::OPERATOR_LEFT],'<'=> ['precedence'=> 20,'class'=> LessBinary::class,'associativity'=> ExpressionParser::OPERATOR_LEFT],'>'=> ['precedence'=> 20,'class'=> GreaterBinary::class,'associativity'=> ExpressionParser::OPERATOR_LEFT],'>='=> ['precedence'=> 20,'class'=> GreaterEqualBinary::class,'associativity'=> ExpressionParser::OPERATOR_LEFT],'<='=> ['precedence'=> 20,'class'=> LessEqualBinary::class,'associativity'=> ExpressionParser::OPERATOR_LEFT],'not in'=> ['precedence'=> 20,'class'=> NotInBinary::class,'associativity'=> ExpressionParser::OPERATOR_LEFT],'in'=> ['precedence'=> 20,'class'=> InBinary::class,'associativity'=> ExpressionParser::OPERATOR_LEFT],'matches'=> ['precedence'=> 20,'class'=> MatchesBinary::class,'associativity'=> ExpressionParser::OPERATOR_LEFT],'starts with'=> ['precedence'=> 20,'class'=> StartsWithBinary::class,'associativity'=> ExpressionParser::OPERATOR_LEFT],'ends with'=> ['precedence'=> 20,'class'=> EndsWithBinary::class,'associativity'=> ExpressionParser::OPERATOR_LEFT],'..'=> ['precedence'=> 25,'class'=> RangeBinary::class,'associativity'=> ExpressionParser::OPERATOR_LEFT],'+'=> ['precedence'=> 30,'class'=> AddBinary::class,'associativity'=> ExpressionParser::OPERATOR_LEFT],'-'=> ['precedence'=> 30,'class'=> SubBinary::class,'associativity'=> ExpressionParser::OPERATOR_LEFT],'~'=> ['precedence'=> 40,'class'=> ConcatBinary::class,'associativity'=> ExpressionParser::OPERATOR_LEFT],'*'=> ['precedence'=> 60,'class'=> MulBinary::class,'associativity'=> ExpressionParser::OPERATOR_LEFT],'/'=> ['precedence'=> 60,'class'=> DivBinary::class,'associativity'=> ExpressionParser::OPERATOR_LEFT],'//'=> ['precedence'=> 60,'class'=> FloorDivBinary::class,'associativity'=> ExpressionParser::OPERATOR_LEFT],'%'=> ['precedence'=> 60,'class'=> ModBinary::class,'associativity'=> ExpressionParser::OPERATOR_LEFT],'is'=> ['precedence'=> 100,'associativity'=> ExpressionParser::OPERATOR_LEFT],'is not'=> ['precedence'=> 100,'associativity'=> ExpressionParser::OPERATOR_LEFT],'**'=> ['precedence'=> 200,'class'=> PowerBinary::class,'associativity'=> ExpressionParser::OPERATOR_RIGHT],'??'=> ['precedence'=> 300,'class'=> NullCoalesceExpression::class,'associativity'=> ExpressionParser::OPERATOR_RIGHT],
],
];
}
}
class_alias('Twig\Extension\CoreExtension','Twig_Extension_Core');
}
namespace {
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Node\Expression\ConstantExpression;
use Twig\Node\Node;
use Twig\Source;
use Twig\Template;
function twig_cycle($values, $position)
{
if (!\is_array($values) && !$values instanceof \ArrayAccess) {
return $values;
}
return $values[$position % \count($values)];
}
function twig_random(Environment $env, $values = null, $max = null)
{
if (null === $values) {
return null === $max ? mt_rand() : mt_rand(0, $max);
}
if (\is_int($values) || \is_float($values)) {
if (null === $max) {
if ($values < 0) {
$max = 0;
$min = $values;
} else {
$max = $values;
$min = 0;
}
} else {
$min = $values;
$max = $max;
}
return mt_rand($min, $max);
}
if (\is_string($values)) {
if (''=== $values) {
return'';
}
$charset = $env->getCharset();
if ('UTF-8'!== $charset) {
$values = iconv($charset,'UTF-8', $values);
}
$values = preg_split('/(?<!^)(?!$)/u', $values);
if ('UTF-8'!== $charset) {
foreach ($values as $i => $value) {
$values[$i] = iconv('UTF-8', $charset, $value);
}
}
}
if (!twig_test_iterable($values)) {
return $values;
}
$values = twig_to_array($values);
if (0 === \count($values)) {
throw new RuntimeError('The random function cannot pick from an empty array.');
}
return $values[array_rand($values, 1)];
}
function twig_date_format_filter(Environment $env, $date, $format = null, $timezone = null)
{
if (null === $format) {
$formats = $env->getExtension(CoreExtension::class)->getDateFormat();
$format = $date instanceof \DateInterval ? $formats[1] : $formats[0];
}
if ($date instanceof \DateInterval) {
return $date->format($format);
}
return twig_date_converter($env, $date, $timezone)->format($format);
}
function twig_date_modify_filter(Environment $env, $date, $modifier)
{
$date = twig_date_converter($env, $date, false);
return $date->modify($modifier);
}
function twig_date_converter(Environment $env, $date = null, $timezone = null)
{
if (false !== $timezone) {
if (null === $timezone) {
$timezone = $env->getExtension(CoreExtension::class)->getTimezone();
} elseif (!$timezone instanceof \DateTimeZone) {
$timezone = new \DateTimeZone($timezone);
}
}
if ($date instanceof \DateTimeImmutable) {
return false !== $timezone ? $date->setTimezone($timezone) : $date;
}
if ($date instanceof \DateTimeInterface) {
$date = clone $date;
if (false !== $timezone) {
$date->setTimezone($timezone);
}
return $date;
}
if (null === $date ||'now'=== $date) {
return new \DateTime($date, false !== $timezone ? $timezone : $env->getExtension(CoreExtension::class)->getTimezone());
}
$asString = (string) $date;
if (ctype_digit($asString) || (!empty($asString) &&'-'=== $asString[0] && ctype_digit(substr($asString, 1)))) {
$date = new \DateTime('@'.$date);
} else {
$date = new \DateTime($date, $env->getExtension(CoreExtension::class)->getTimezone());
}
if (false !== $timezone) {
$date->setTimezone($timezone);
}
return $date;
}
function twig_replace_filter($str, $from)
{
if (!twig_test_iterable($from)) {
throw new RuntimeError(sprintf('The "replace" filter expects an array or "Traversable" as replace values, got "%s".', \is_object($from) ? \get_class($from) : \gettype($from)));
}
return strtr($str, twig_to_array($from));
}
function twig_round($value, $precision = 0, $method ='common')
{
if ('common'== $method) {
return round($value, $precision);
}
if ('ceil'!= $method &&'floor'!= $method) {
throw new RuntimeError('The round filter only supports the "common", "ceil", and "floor" methods.');
}
return $method($value * pow(10, $precision)) / pow(10, $precision);
}
function twig_number_format_filter(Environment $env, $number, $decimal = null, $decimalPoint = null, $thousandSep = null)
{
$defaults = $env->getExtension(CoreExtension::class)->getNumberFormat();
if (null === $decimal) {
$decimal = $defaults[0];
}
if (null === $decimalPoint) {
$decimalPoint = $defaults[1];
}
if (null === $thousandSep) {
$thousandSep = $defaults[2];
}
return number_format((float) $number, $decimal, $decimalPoint, $thousandSep);
}
function twig_urlencode_filter($url)
{
if (\is_array($url)) {
return http_build_query($url,'','&', PHP_QUERY_RFC3986);
}
return rawurlencode($url);
}
function twig_array_merge($arr1, $arr2)
{
if (!twig_test_iterable($arr1)) {
throw new RuntimeError(sprintf('The merge filter only works with arrays or "Traversable", got "%s" as first argument.', \gettype($arr1)));
}
if (!twig_test_iterable($arr2)) {
throw new RuntimeError(sprintf('The merge filter only works with arrays or "Traversable", got "%s" as second argument.', \gettype($arr2)));
}
return array_merge(twig_to_array($arr1), twig_to_array($arr2));
}
function twig_slice(Environment $env, $item, $start, $length = null, $preserveKeys = false)
{
if ($item instanceof \Traversable) {
while ($item instanceof \IteratorAggregate) {
$item = $item->getIterator();
}
if ($start >= 0 && $length >= 0 && $item instanceof \Iterator) {
try {
return iterator_to_array(new \LimitIterator($item, $start, null === $length ? -1 : $length), $preserveKeys);
} catch (\OutOfBoundsException $e) {
return [];
}
}
$item = iterator_to_array($item, $preserveKeys);
}
if (\is_array($item)) {
return \array_slice($item, $start, $length, $preserveKeys);
}
$item = (string) $item;
return (string) mb_substr($item, $start, $length, $env->getCharset());
}
function twig_first(Environment $env, $item)
{
$elements = twig_slice($env, $item, 0, 1, false);
return \is_string($elements) ? $elements : current($elements);
}
function twig_last(Environment $env, $item)
{
$elements = twig_slice($env, $item, -1, 1, false);
return \is_string($elements) ? $elements : current($elements);
}
function twig_join_filter($value, $glue ='', $and = null)
{
if (!twig_test_iterable($value)) {
$value = (array) $value;
}
$value = twig_to_array($value, false);
if (0 === \count($value)) {
return'';
}
if (null === $and || $and === $glue) {
return implode($glue, $value);
}
if (1 === \count($value)) {
return $value[0];
}
return implode($glue, \array_slice($value, 0, -1)).$and.$value[\count($value) - 1];
}
function twig_split_filter(Environment $env, $value, $delimiter, $limit = null)
{
if (!empty($delimiter)) {
return null === $limit ? explode($delimiter, $value) : explode($delimiter, $value, $limit);
}
if ($limit <= 1) {
return preg_split('/(?<!^)(?!$)/u', $value);
}
$length = mb_strlen($value, $env->getCharset());
if ($length < $limit) {
return [$value];
}
$r = [];
for ($i = 0; $i < $length; $i += $limit) {
$r[] = mb_substr($value, $i, $limit, $env->getCharset());
}
return $r;
}
function _twig_default_filter($value, $default ='')
{
if (twig_test_empty($value)) {
return $default;
}
return $value;
}
function twig_get_array_keys_filter($array)
{
if ($array instanceof \Traversable) {
while ($array instanceof \IteratorAggregate) {
$array = $array->getIterator();
}
if ($array instanceof \Iterator) {
$keys = [];
$array->rewind();
while ($array->valid()) {
$keys[] = $array->key();
$array->next();
}
return $keys;
}
$keys = [];
foreach ($array as $key => $item) {
$keys[] = $key;
}
return $keys;
}
if (!\is_array($array)) {
return [];
}
return array_keys($array);
}
function twig_reverse_filter(Environment $env, $item, $preserveKeys = false)
{
if ($item instanceof \Traversable) {
return array_reverse(iterator_to_array($item), $preserveKeys);
}
if (\is_array($item)) {
return array_reverse($item, $preserveKeys);
}
$string = (string) $item;
$charset = $env->getCharset();
if ('UTF-8'!== $charset) {
$item = iconv($charset,'UTF-8', $string);
}
preg_match_all('/./us', $item, $matches);
$string = implode('', array_reverse($matches[0]));
if ('UTF-8'!== $charset) {
$string = iconv('UTF-8', $charset, $string);
}
return $string;
}
function twig_sort_filter($array)
{
if ($array instanceof \Traversable) {
$array = iterator_to_array($array);
} elseif (!\is_array($array)) {
throw new RuntimeError(sprintf('The sort filter only works with arrays or "Traversable", got "%s".', \gettype($array)));
}
asort($array);
return $array;
}
function twig_in_filter($value, $compare)
{
if (\is_array($compare)) {
return \in_array($value, $compare, \is_object($value) || \is_resource($value));
} elseif (\is_string($compare) && (\is_string($value) || \is_int($value) || \is_float($value))) {
return''=== $value || false !== strpos($compare, (string) $value);
} elseif ($compare instanceof \Traversable) {
if (\is_object($value) || \is_resource($value)) {
foreach ($compare as $item) {
if ($item === $value) {
return true;
}
}
} else {
foreach ($compare as $item) {
if ($item == $value) {
return true;
}
}
}
return false;
}
return false;
}
function twig_trim_filter($string, $characterMask = null, $side ='both')
{
if (null === $characterMask) {
$characterMask =" \t\n\r\0\x0B";
}
switch ($side) {
case'both':
return trim($string, $characterMask);
case'left':
return ltrim($string, $characterMask);
case'right':
return rtrim($string, $characterMask);
default:
throw new RuntimeError('Trimming side must be "left", "right" or "both".');
}
}
function twig_spaceless($content)
{
return trim(preg_replace('/>\s+</','><', $content));
}
function twig_escape_filter(Environment $env, $string, $strategy ='html', $charset = null, $autoescape = false)
{
if ($autoescape && $string instanceof Markup) {
return $string;
}
if (!\is_string($string)) {
if (\is_object($string) && method_exists($string,'__toString')) {
$string = (string) $string;
} elseif (\in_array($strategy, ['html','js','css','html_attr','url'])) {
return $string;
}
}
if (''=== $string) {
return'';
}
if (null === $charset) {
$charset = $env->getCharset();
}
switch ($strategy) {
case'html':
static $htmlspecialcharsCharsets = ['ISO-8859-1'=> true,'ISO8859-1'=> true,'ISO-8859-15'=> true,'ISO8859-15'=> true,'utf-8'=> true,'UTF-8'=> true,'CP866'=> true,'IBM866'=> true,'866'=> true,'CP1251'=> true,'WINDOWS-1251'=> true,'WIN-1251'=> true,'1251'=> true,'CP1252'=> true,'WINDOWS-1252'=> true,'1252'=> true,'KOI8-R'=> true,'KOI8-RU'=> true,'KOI8R'=> true,'BIG5'=> true,'950'=> true,'GB2312'=> true,'936'=> true,'BIG5-HKSCS'=> true,'SHIFT_JIS'=> true,'SJIS'=> true,'932'=> true,'EUC-JP'=> true,'EUCJP'=> true,'ISO8859-5'=> true,'ISO-8859-5'=> true,'MACROMAN'=> true,
];
if (isset($htmlspecialcharsCharsets[$charset])) {
return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE, $charset);
}
if (isset($htmlspecialcharsCharsets[strtoupper($charset)])) {
$htmlspecialcharsCharsets[$charset] = true;
return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE, $charset);
}
$string = iconv($charset,'UTF-8', $string);
$string = htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE,'UTF-8');
return iconv('UTF-8', $charset, $string);
case'js':
if ('UTF-8'!== $charset) {
$string = iconv($charset,'UTF-8', $string);
}
if (!preg_match('//u', $string)) {
throw new RuntimeError('The string to escape is not a valid UTF-8 string.');
}
$string = preg_replace_callback('#[^a-zA-Z0-9,\._]#Su', function ($matches) {
$char = $matches[0];
static $shortMap = ['\\'=>'\\\\','/'=>'\\/',"\x08"=>'\b',"\x0C"=>'\f',"\x0A"=>'\n',"\x0D"=>'\r',"\x09"=>'\t',
];
if (isset($shortMap[$char])) {
return $shortMap[$char];
}
$char = twig_convert_encoding($char,'UTF-16BE','UTF-8');
$char = strtoupper(bin2hex($char));
if (4 >= \strlen($char)) {
return sprintf('\u%04s', $char);
}
return sprintf('\u%04s\u%04s', substr($char, 0, -4), substr($char, -4));
}, $string);
if ('UTF-8'!== $charset) {
$string = iconv('UTF-8', $charset, $string);
}
return $string;
case'css':
if ('UTF-8'!== $charset) {
$string = iconv($charset,'UTF-8', $string);
}
if (!preg_match('//u', $string)) {
throw new RuntimeError('The string to escape is not a valid UTF-8 string.');
}
$string = preg_replace_callback('#[^a-zA-Z0-9]#Su', function ($matches) {
$char = $matches[0];
return sprintf('\\%X ', 1 === \strlen($char) ? \ord($char) : mb_ord($char,'UTF-8'));
}, $string);
if ('UTF-8'!== $charset) {
$string = iconv('UTF-8', $charset, $string);
}
return $string;
case'html_attr':
if ('UTF-8'!== $charset) {
$string = iconv($charset,'UTF-8', $string);
}
if (!preg_match('//u', $string)) {
throw new RuntimeError('The string to escape is not a valid UTF-8 string.');
}
$string = preg_replace_callback('#[^a-zA-Z0-9,\.\-_]#Su', function ($matches) {
$chr = $matches[0];
$ord = \ord($chr);
if (($ord <= 0x1f &&"\t"!= $chr &&"\n"!= $chr &&"\r"!= $chr) || ($ord >= 0x7f && $ord <= 0x9f)) {
return'&#xFFFD;';
}
if (1 === \strlen($chr)) {
static $entityMap = [
34 =>'&quot;',
38 =>'&amp;',
60 =>'&lt;',
62 =>'&gt;',
];
if (isset($entityMap[$ord])) {
return $entityMap[$ord];
}
return sprintf('&#x%02X;', $ord);
}
return sprintf('&#x%04X;', mb_ord($chr,'UTF-8'));
}, $string);
if ('UTF-8'!== $charset) {
$string = iconv('UTF-8', $charset, $string);
}
return $string;
case'url':
return rawurlencode($string);
default:
static $escapers;
if (null === $escapers) {
$escapers = $env->getExtension(CoreExtension::class)->getEscapers();
}
if (isset($escapers[$strategy])) {
return $escapers[$strategy]($env, $string, $charset);
}
$validStrategies = implode(', ', array_merge(['html','js','url','css','html_attr'], array_keys($escapers)));
throw new RuntimeError(sprintf('Invalid escaping strategy "%s" (valid ones: %s).', $strategy, $validStrategies));
}
}
function twig_escape_filter_is_safe(Node $filterArgs)
{
foreach ($filterArgs as $arg) {
if ($arg instanceof ConstantExpression) {
return [$arg->getAttribute('value')];
}
return [];
}
return ['html'];
}
function twig_convert_encoding($string, $to, $from)
{
return iconv($from, $to, $string);
}
function twig_length_filter(Environment $env, $thing)
{
if (null === $thing) {
return 0;
}
if (is_scalar($thing)) {
return mb_strlen($thing, $env->getCharset());
}
if ($thing instanceof \Countable || \is_array($thing) || $thing instanceof \SimpleXMLElement) {
return \count($thing);
}
if ($thing instanceof \Traversable) {
return iterator_count($thing);
}
if (method_exists($thing,'__toString') && !$thing instanceof \Countable) {
return mb_strlen((string) $thing, $env->getCharset());
}
return 1;
}
function twig_upper_filter(Environment $env, $string)
{
return mb_strtoupper($string, $env->getCharset());
}
function twig_lower_filter(Environment $env, $string)
{
return mb_strtolower($string, $env->getCharset());
}
function twig_title_string_filter(Environment $env, $string)
{
if (null !== $charset = $env->getCharset()) {
return mb_convert_case($string, MB_CASE_TITLE, $charset);
}
return ucwords(strtolower($string));
}
function twig_capitalize_string_filter(Environment $env, $string)
{
$charset = $env->getCharset();
return mb_strtoupper(mb_substr($string, 0, 1, $charset), $charset).mb_strtolower(mb_substr($string, 1, null, $charset), $charset);
}
function twig_ensure_traversable($seq)
{
if ($seq instanceof \Traversable || \is_array($seq)) {
return $seq;
}
return [];
}
function twig_to_array($seq, $preserveKeys = true)
{
if ($seq instanceof \Traversable) {
return iterator_to_array($seq, $preserveKeys);
}
if (!\is_array($seq)) {
return $seq;
}
return $preserveKeys ? $seq : array_values($seq);
}
function twig_test_empty($value)
{
if ($value instanceof \Countable) {
return 0 == \count($value);
}
if (\is_object($value) && method_exists($value,'__toString')) {
return''=== (string) $value;
}
return''=== $value || false === $value || null === $value || [] === $value;
}
function twig_test_iterable($value)
{
return $value instanceof \Traversable || \is_array($value);
}
function twig_include(Environment $env, $context, $template, $variables = [], $withContext = true, $ignoreMissing = false, $sandboxed = false)
{
$alreadySandboxed = false;
$sandbox = null;
if ($withContext) {
$variables = array_merge($context, $variables);
}
if ($isSandboxed = $sandboxed && $env->hasExtension(SandboxExtension::class)) {
$sandbox = $env->getExtension(SandboxExtension::class);
if (!$alreadySandboxed = $sandbox->isSandboxed()) {
$sandbox->enableSandbox();
}
}
try {
$loaded = null;
try {
$loaded = $env->resolveTemplate($template);
} catch (LoaderError $e) {
if (!$ignoreMissing) {
throw $e;
}
}
return $loaded ? $loaded->render($variables) :'';
} finally {
if ($isSandboxed && !$alreadySandboxed) {
$sandbox->disableSandbox();
}
}
}
function twig_source(Environment $env, $name, $ignoreMissing = false)
{
$loader = $env->getLoader();
try {
return $loader->getSourceContext($name)->getCode();
} catch (LoaderError $e) {
if (!$ignoreMissing) {
throw $e;
}
}
}
function twig_constant($constant, $object = null)
{
if (null !== $object) {
$constant = \get_class($object).'::'.$constant;
}
return \constant($constant);
}
function twig_constant_is_defined($constant, $object = null)
{
if (null !== $object) {
$constant = \get_class($object).'::'.$constant;
}
return \defined($constant);
}
function twig_array_batch($items, $size, $fill = null, $preserveKeys = true)
{
if (!twig_test_iterable($items)) {
throw new RuntimeError(sprintf('The "batch" filter expects an array or "Traversable", got "%s".', \is_object($items) ? \get_class($items) : \gettype($items)));
}
$size = ceil($size);
$result = array_chunk(twig_to_array($items, $preserveKeys), $size, $preserveKeys);
if (null !== $fill && $result) {
$last = \count($result) - 1;
if ($fillCount = $size - \count($result[$last])) {
for ($i = 0; $i < $fillCount; ++$i) {
$result[$last][] = $fill;
}
}
}
return $result;
}
function twig_get_attribute(Environment $env, Source $source, $object, $item, array $arguments = [], $type ='any', $isDefinedTest = false, $ignoreStrictCheck = false, $sandboxed = false)
{
if ('method'!== $type) {
$arrayItem = \is_bool($item) || \is_float($item) ? (int) $item : $item;
if (((\is_array($object) || $object instanceof \ArrayObject) && (isset($object[$arrayItem]) || \array_key_exists($arrayItem, $object)))
|| ($object instanceof ArrayAccess && isset($object[$arrayItem]))
) {
if ($isDefinedTest) {
return true;
}
return $object[$arrayItem];
}
if ('array'=== $type || !\is_object($object)) {
if ($isDefinedTest) {
return false;
}
if ($ignoreStrictCheck || !$env->isStrictVariables()) {
return;
}
if ($object instanceof ArrayAccess) {
$message = sprintf('Key "%s" in object with ArrayAccess of class "%s" does not exist.', $arrayItem, \get_class($object));
} elseif (\is_object($object)) {
$message = sprintf('Impossible to access a key "%s" on an object of class "%s" that does not implement ArrayAccess interface.', $item, \get_class($object));
} elseif (\is_array($object)) {
if (empty($object)) {
$message = sprintf('Key "%s" does not exist as the array is empty.', $arrayItem);
} else {
$message = sprintf('Key "%s" for array with keys "%s" does not exist.', $arrayItem, implode(', ', array_keys($object)));
}
} elseif ('array'=== $type) {
if (null === $object) {
$message = sprintf('Impossible to access a key ("%s") on a null variable.', $item);
} else {
$message = sprintf('Impossible to access a key ("%s") on a %s variable ("%s").', $item, \gettype($object), $object);
}
} elseif (null === $object) {
$message = sprintf('Impossible to access an attribute ("%s") on a null variable.', $item);
} else {
$message = sprintf('Impossible to access an attribute ("%s") on a %s variable ("%s").', $item, \gettype($object), $object);
}
throw new RuntimeError($message, -1, $source);
}
}
if (!\is_object($object)) {
if ($isDefinedTest) {
return false;
}
if ($ignoreStrictCheck || !$env->isStrictVariables()) {
return;
}
if (null === $object) {
$message = sprintf('Impossible to invoke a method ("%s") on a null variable.', $item);
} elseif (\is_array($object)) {
$message = sprintf('Impossible to invoke a method ("%s") on an array.', $item);
} else {
$message = sprintf('Impossible to invoke a method ("%s") on a %s variable ("%s").', $item, \gettype($object), $object);
}
throw new RuntimeError($message, -1, $source);
}
if ($object instanceof Template) {
throw new RuntimeError('Accessing \Twig\Template attributes is forbidden.');
}
if ('method'!== $type) {
if (isset($object->$item) || \array_key_exists((string) $item, $object)) {
if ($isDefinedTest) {
return true;
}
if ($sandboxed) {
$env->getExtension(SandboxExtension::class)->checkPropertyAllowed($object, $item, $source);
}
return $object->$item;
}
}
static $cache = [];
$class = \get_class($object);
if (!isset($cache[$class])) {
$methods = get_class_methods($object);
sort($methods);
$lcMethods = array_map('strtolower', $methods);
$classCache = [];
foreach ($methods as $i => $method) {
$classCache[$method] = $method;
$classCache[$lcName = $lcMethods[$i]] = $method;
if ('g'=== $lcName[0] && 0 === strpos($lcName,'get')) {
$name = substr($method, 3);
$lcName = substr($lcName, 3);
} elseif ('i'=== $lcName[0] && 0 === strpos($lcName,'is')) {
$name = substr($method, 2);
$lcName = substr($lcName, 2);
} elseif ('h'=== $lcName[0] && 0 === strpos($lcName,'has')) {
$name = substr($method, 3);
$lcName = substr($lcName, 3);
if (\in_array('is'.$lcName, $lcMethods)) {
continue;
}
} else {
continue;
}
if ($name) {
if (!isset($classCache[$name])) {
$classCache[$name] = $method;
}
if (!isset($classCache[$lcName])) {
$classCache[$lcName] = $method;
}
}
}
$cache[$class] = $classCache;
}
$call = false;
if (isset($cache[$class][$item])) {
$method = $cache[$class][$item];
} elseif (isset($cache[$class][$lcItem = strtolower($item)])) {
$method = $cache[$class][$lcItem];
} elseif (isset($cache[$class]['__call'])) {
$method = $item;
$call = true;
} else {
if ($isDefinedTest) {
return false;
}
if ($ignoreStrictCheck || !$env->isStrictVariables()) {
return;
}
throw new RuntimeError(sprintf('Neither the property "%1$s" nor one of the methods "%1$s()", "get%1$s()"/"is%1$s()"/"has%1$s()" or "__call()" exist and have public access in class "%2$s".', $item, $class), -1, $source);
}
if ($isDefinedTest) {
return true;
}
if ($sandboxed) {
$env->getExtension(SandboxExtension::class)->checkMethodAllowed($object, $method, $source);
}
try {
$ret = $object->$method(...$arguments);
} catch (\BadMethodCallException $e) {
if ($call && ($ignoreStrictCheck || !$env->isStrictVariables())) {
return;
}
throw $e;
}
return $ret;
}
function twig_array_column($array, $name): array
{
if ($array instanceof Traversable) {
$array = iterator_to_array($array);
} elseif (!\is_array($array)) {
throw new RuntimeError(sprintf('The column filter only works with arrays or "Traversable", got "%s" as first argument.', \gettype($array)));
}
return array_column($array, $name);
}
}
namespace Twig\Extension {
use Twig\FileExtensionEscapingStrategy;
use Twig\NodeVisitor\EscaperNodeVisitor;
use Twig\TokenParser\AutoEscapeTokenParser;
use Twig\TwigFilter;
final class EscaperExtension extends AbstractExtension
{
private $defaultStrategy;
public function __construct($defaultStrategy ='html')
{
$this->setDefaultStrategy($defaultStrategy);
}
public function getTokenParsers()
{
return [new AutoEscapeTokenParser()];
}
public function getNodeVisitors()
{
return [new EscaperNodeVisitor()];
}
public function getFilters()
{
return [
new TwigFilter('raw','twig_raw_filter', ['is_safe'=> ['all']]),
];
}
public function setDefaultStrategy($defaultStrategy)
{
if ('name'=== $defaultStrategy) {
$defaultStrategy = [FileExtensionEscapingStrategy::class,'guess'];
}
$this->defaultStrategy = $defaultStrategy;
}
public function getDefaultStrategy($name)
{
if (!\is_string($this->defaultStrategy) && false !== $this->defaultStrategy) {
return \call_user_func($this->defaultStrategy, $name);
}
return $this->defaultStrategy;
}
}
class_alias('Twig\Extension\EscaperExtension','Twig_Extension_Escaper');
}
namespace {
function twig_raw_filter($string)
{
return $string;
}
}
namespace Twig\Extension
{
use Twig\NodeVisitor\OptimizerNodeVisitor;
final class OptimizerExtension extends AbstractExtension
{
private $optimizers;
public function __construct($optimizers = -1)
{
$this->optimizers = $optimizers;
}
public function getNodeVisitors()
{
return [new OptimizerNodeVisitor($this->optimizers)];
}
}
class_alias('Twig\Extension\OptimizerExtension','Twig_Extension_Optimizer');
}
namespace Twig\Loader
{
use Twig\Error\LoaderError;
use Twig\Source;
interface LoaderInterface
{
public function getSourceContext($name);
public function getCacheKey($name);
public function isFresh($name, $time);
public function exists($name);
}
class_alias('Twig\Loader\LoaderInterface','Twig_LoaderInterface');
}
namespace Twig
{
class Markup implements \Countable, \JsonSerializable
{
private $content;
private $charset;
public function __construct($content, $charset)
{
$this->content = (string) $content;
$this->charset = $charset;
}
public function __toString()
{
return $this->content;
}
public function count()
{
return mb_strlen($this->content, $this->charset);
}
public function jsonSerialize()
{
return $this->content;
}
}
class_alias('Twig\Markup','Twig_Markup');
}
namespace Twig
{
use Twig\Error\Error;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
abstract class Template
{
const ANY_CALL ='any';
const ARRAY_CALL ='array';
const METHOD_CALL ='method';
protected $parent;
protected $parents = [];
protected $env;
protected $blocks = [];
protected $traits = [];
protected $extensions = [];
protected $sandbox;
public function __construct(Environment $env)
{
$this->env = $env;
$this->extensions = $env->getExtensions();
}
public function __toString()
{
return $this->getTemplateName();
}
abstract public function getTemplateName();
abstract public function getDebugInfo();
public function getSourceContext()
{
return new Source('', $this->getTemplateName());
}
public function getParent(array $context)
{
if (null !== $this->parent) {
return $this->parent;
}
try {
$parent = $this->doGetParent($context);
if (false === $parent) {
return false;
}
if ($parent instanceof self || $parent instanceof TemplateWrapper) {
return $this->parents[$parent->getSourceContext()->getName()] = $parent;
}
if (!isset($this->parents[$parent])) {
$this->parents[$parent] = $this->loadTemplate($parent);
}
} catch (LoaderError $e) {
$e->setSourceContext(null);
$e->guess();
throw $e;
}
return $this->parents[$parent];
}
protected function doGetParent(array $context)
{
return false;
}
public function isTraitable()
{
return true;
}
public function displayParentBlock($name, array $context, array $blocks = [])
{
if (isset($this->traits[$name])) {
$this->traits[$name][0]->displayBlock($name, $context, $blocks, false);
} elseif (false !== $parent = $this->getParent($context)) {
$parent->displayBlock($name, $context, $blocks, false);
} else {
throw new RuntimeError(sprintf('The template has no parent and no traits defining the "%s" block.', $name), -1, $this->getSourceContext());
}
}
public function displayBlock($name, array $context, array $blocks = [], $useBlocks = true, self $templateContext = null)
{
if ($useBlocks && isset($blocks[$name])) {
$template = $blocks[$name][0];
$block = $blocks[$name][1];
} elseif (isset($this->blocks[$name])) {
$template = $this->blocks[$name][0];
$block = $this->blocks[$name][1];
} else {
$template = null;
$block = null;
}
if (null !== $template && !$template instanceof self) {
throw new \LogicException('A block must be a method on a \Twig\Template instance.');
}
if (null !== $template) {
try {
$template->$block($context, $blocks);
} catch (Error $e) {
if (!$e->getSourceContext()) {
$e->setSourceContext($template->getSourceContext());
}
if (-1 === $e->getTemplateLine()) {
$e->guess();
}
throw $e;
} catch (\Exception $e) {
$e = new RuntimeError(sprintf('An exception has been thrown during the rendering of a template ("%s").', $e->getMessage()), -1, $template->getSourceContext(), $e);
$e->guess();
throw $e;
}
} elseif (false !== $parent = $this->getParent($context)) {
$parent->displayBlock($name, $context, array_merge($this->blocks, $blocks), false, $templateContext ?? $this);
} elseif (isset($blocks[$name])) {
throw new RuntimeError(sprintf('Block "%s" should not call parent() in "%s" as the block does not exist in the parent template "%s".', $name, $blocks[$name][0]->getTemplateName(), $this->getTemplateName()), -1, $blocks[$name][0]->getSourceContext());
} else {
throw new RuntimeError(sprintf('Block "%s" on template "%s" does not exist.', $name, $this->getTemplateName()), -1, ($templateContext ?? $this)->getSourceContext());
}
}
public function renderParentBlock($name, array $context, array $blocks = [])
{
ob_start();
$this->displayParentBlock($name, $context, $blocks);
return ob_get_clean();
}
public function renderBlock($name, array $context, array $blocks = [], $useBlocks = true)
{
ob_start();
$this->displayBlock($name, $context, $blocks, $useBlocks);
return ob_get_clean();
}
public function hasBlock($name, array $context, array $blocks = [])
{
if (isset($blocks[$name])) {
return $blocks[$name][0] instanceof self;
}
if (isset($this->blocks[$name])) {
return true;
}
if (false !== $parent = $this->getParent($context)) {
return $parent->hasBlock($name, $context);
}
return false;
}
public function getBlockNames(array $context, array $blocks = [])
{
$names = array_merge(array_keys($blocks), array_keys($this->blocks));
if (false !== $parent = $this->getParent($context)) {
$names = array_merge($names, $parent->getBlockNames($context));
}
return array_unique($names);
}
protected function loadTemplate($template, $templateName = null, $line = null, $index = null)
{
try {
if (\is_array($template)) {
return $this->env->resolveTemplate($template);
}
if ($template instanceof self || $template instanceof TemplateWrapper) {
return $template;
}
if ($template === $this->getTemplateName()) {
$class = \get_class($this);
if (false !== $pos = strrpos($class,'___', -1)) {
$class = substr($class, 0, $pos);
}
return $this->env->loadClass($class, $template, $index);
}
return $this->env->loadTemplate($template, $index);
} catch (Error $e) {
if (!$e->getSourceContext()) {
$e->setSourceContext($templateName ? new Source('', $templateName) : $this->getSourceContext());
}
if ($e->getTemplateLine() > 0) {
throw $e;
}
if (!$line) {
$e->guess();
} else {
$e->setTemplateLine($line);
}
throw $e;
}
}
public function getBlocks()
{
return $this->blocks;
}
public function display(array $context, array $blocks = [])
{
$this->displayWithErrorHandling($this->env->mergeGlobals($context), array_merge($this->blocks, $blocks));
}
public function render(array $context)
{
$level = ob_get_level();
ob_start();
try {
$this->display($context);
} catch (\Throwable $e) {
while (ob_get_level() > $level) {
ob_end_clean();
}
throw $e;
}
return ob_get_clean();
}
protected function displayWithErrorHandling(array $context, array $blocks = [])
{
try {
$this->doDisplay($context, $blocks);
} catch (Error $e) {
if (!$e->getSourceContext()) {
$e->setSourceContext($this->getSourceContext());
}
if (-1 === $e->getTemplateLine()) {
$e->guess();
}
throw $e;
} catch (\Exception $e) {
$e = new RuntimeError(sprintf('An exception has been thrown during the rendering of a template ("%s").', $e->getMessage()), -1, $this->getSourceContext(), $e);
$e->guess();
throw $e;
}
}
abstract protected function doDisplay(array $context, array $blocks = []);
}
class_alias('Twig\Template','Twig_Template');
}