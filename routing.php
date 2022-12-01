class Response {
  public function json(Array $response, ?int $code = 200) 
  {
    json_encode($response);
  }
}
function response(): Response {
  return new Response();
}

final class Route {
  protected string $path, $name;
  private static string $group;

  private static function action(string $method, string $path, $controller, ?string $name = null, $middleware = null) 
  {
    self::match($path, $method) && call_user_func($controller);

  }
  public static function get(string $path, $controller, ?string $name = null, $middleware = null): void
  {
    self::action(__FUNCTION__, $path, $controller, $name, $middleware);
  }

  public static function post(string $path, $controller, ?string $name = null, $middleware = null): void 
  {
    self::action(__FUNCTION__, $path, $controller, $name, $middleware);
  }

  public static function delete(string $path, $controller, ?string $name = null, $middleware = null): void 
  {
    self::action(__FUNCTION__, $path, $controller, $name, $middleware);
  }

  public static function update(string $path, $controller, ?string $name = null, $middleware = null): void
  {
    self::action(__FUNCTION__, $path, $controller, $name, $middleware);
  }

  private static function requestMethodMatch(string $method): bool
  {
    return strtolower($_SERVER['REQUEST_METHOD']) === strtolower($method);
  }

  private static function match(string $path, string $method): bool
  {
    return self::requestMethodMatch($method) && 
      self::getActualPath() === self::getScript() . self::getGroup() . strtolower($path);
  }

  private static function getActualPath() {
    return strtolower( parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) );
  }

  private static function getScript()
  {
    return '/' . basename(__FILE__) . '/';
  }

  private static function appendBar(string $stringToAppend) {
    if (substr($stringToAppend, -1) !== '/') $stringToAppend .= '/';
    return $stringToAppend;
  }

  public static function getGroup() {
    return self::$group;
  }

  public static function setGroup(string $group)
  {
    self::$group = self::appendBar($group);
  }

  public static function unsetGroup()
  {
    self::$group = '';
  }

  public static function testPathAndGroup($path) 
  {
    return self::getGroup() . $path === parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  }

}

Route::setGroup('api');

Route::get('ramais-status', function() {
  echo 'teste';
}, 'ramais.status');

Route::unsetGroup();