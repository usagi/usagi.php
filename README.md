# Usagi's PHP library

# Features

## 1. http wrapper

```php
require_once 'usagi.php/source/http.php'
```

### 1.1. http library // stateles, simple and convinient

#### GET

```php
// a simple GET request
var_dump( \usagi\http\request( 'http://php.net' ) );
```

```php
array(3) {
  ["status_code"]=>
  int(200)
  ["headers"]=>
  array(11) {
    ["Server"]=>
    string(11) "nginx/1.6.2"
    ["Date"]=>
    string(29) "Wed, 31 Aug 2016 08:27:02 GMT"
    ["Content-Type"]=>
    string(24) "text/html; charset=utf-8"
    ["Connection"]=>
    string(5) "close"
    ["X-Powered-By"]=>
    string(19) "PHP/5.6.24-0+deb8u1"
    ["Last-Modified"]=>
    string(29) "Wed, 31 Aug 2016 08:10:14 GMT"
    ["Content-language"]=>
    string(2) "en"
    ["X-Frame-Options"]=>
    string(10) "SAMEORIGIN"
    ["Set-Cookie"]=>
    string(102) "LAST_NEWS=1472632022; expires=Thu, 31-Aug-2017 08:27:02 GMT; Max-Age=31536000; path=/; domain=.php.net"
    ["Link"]=>
    string(36) "<http://php.net/index>; rel=shorturl"
    ["Vary"]=>
    string(15) "Accept-Encoding"
  }
  ["content"]=>
  string(21472) "<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
...
}
```

#### HEAD, DELETE, ...

```php
$response = \usagi\http\request( 'http://example.net', 'HEAD' ) );
$response = \usagi\http\request( 'http://example.net', 'DELETE' ) );
```

#### PUT, POST, ...

```php
$response = \usagi\http\request( 'http://example.net', 'PUT' , $data ) );
$response = \usagi\http\request( 'http://example.net', 'POST', $data ) );
```

#### add custom headers

```php
$response = \usagi\http\request
  ( 'http://example.net'
  , 'PUT'
  , $data
  , [ 'x-my-custom-request-header-1' => 'custom value 1'
    , 'x-my-custom-request-header-2' => 'custom value 2'
    ]
  );
```

#### with convinient stateless helpers

```php
echo \usagi\http\make_url( 'http', 'example.net', '12345' );
```

> http://example.net:12345

```php
echo \usagi\http\make_url
  ( 'http'
  , 'example.net'
  , '12345'
  , [ 'path1', 'path2', 'path3   ' ]
  );
```

> http://example.net:12345/path1/path2/path3%20%20%20

```php
echo \usagi\http\make_url
  ( 'http'
  , 'example.net'
  , '12345'
  , [ 'path1', 'path2', 'path3   ' ]
  , [ 'q1_key' => 'q1_value', 'q2_key' => 'q2_value' ]
  );
```

> http://example.net:12345/path1/path2/path3%20%20%20?q1_key=q1_value&q2_key=q2_value

and etc.

## 2. CouchDB library

```php
require_once 'usagi.php/source/couchdb.php'
```

### 2.1. stateless library // for a simple usecases

```php
require_once 'usagi.php/source/couchdb/stateless.php'
```

#### get version infos

```php
var_dump( \usagi\couchdb\get_version( 'http', '127.0.0.1', 5984 ) );
```

```php
array(4) {
  ["couchdb"]=>
  string(7) "Welcome"
  ["uuid"]=>
  string(32) "4fa79ddb179218126c1245256d74878f"
  ["version"]=>
  string(5) "1.6.1"
  ["vendor"]=>
  array(2) {
    ["version"]=>
    string(5) "16.04"
    ["name"]=>
    string(6) "Ubuntu"
  }
}
```

#### database features

```php
$is_exists = \usagi\couchdb\is_exists_database( 'http', '127.0.0.1', 5984, 'test' );
$is_succeeded = \usagi\couchdb\create_database( 'http', '127.0.0.1', 5984, 'test' );
$is_succeeded = \usagi\couchdb\delete_database( 'http', '127.0.0.1', 5984, 'test' );
```

#### document features

```php
// rev or FALSE
$rev = \usagi\couchdb\is_exists_document( 'http', '127.0.0.1', 5984, 'test', 'd1' );

// get data with decoded to a PHP array from a JSON result
$php_array_data = usagi\couchdb\get_document( 'http', '127.0.0.1', 5984, 'test2', 'd1' ) );

// create document
$id_and_rev = \usagi\couchdb\create_document( 'http', '127.0.0.1', 5984, 'test2', 'd1', $omissible_your_php_array_data );

// delete document
$is_succeeded = \usagi\couchdb\delete_document( 'http', '127.0.0.1', 5984, 'test2', 'd1' );

// update document
$id_and_rev = \usagi\couchdb\update_document( 'http', '127.0.0.1', 5984, 'test2', 'd1', [ 'hoge' => 'fuga' ] );
```

##### document attachment features

```php
// attach
$is_succeeded = \usagi\couchdb\attach_document( 'http', '127.0.0.1', 5984, 'test2', 'd1', 'somthing.png' );

// detach
$is_succeeded = \usagi\couchdb\detach_document( 'http', '127.0.0.1', 5984, 'test2', 'd1', 'gondwana-logo-white-120x120.png' ) );

// attachment header infos with rev included or FALSE
$rev_and_header_infos = \usagi\couchdb\is_exists_attachment( 'http', '127.0.0.1', 5984, 'test2', 'd1', 'something.png' ) );

// get attachment binary
file_put_contents( 'somthing.png', \usagi\couchdb\get_attachment( 'http', '127.0.0.1', 5984, 'test2', 'd1', 'something.png' ), LOCK_EX );
```

### 2.2. statefull library // function chain, auto memorize parameters, auto result queueing

```php
$c1 = new \usagi\couchdb\statefull;

// save parameters implicit
// and functions are chainable
// and results are auto stacked/queued and exportable anythime!

$c1 -> set_auto_memorize_parameters( true ) // enabling auto memorize parameters, default is true
    -> get_document( 'document1', 'database1', 5984, '127.0.0.1', 'http' ) // queue result to results[ 0 ]
    -> shift_result( $x ) // move results[ 0 ] to $x ( remove results[ 0 ] and data be set to $x )
    -> get_document( 'document2' ) // result[ 0 ]
    -> get_attachment( 'attachemnet2-1.png' ) // result[ 1 ]
    -> get_document( $x['foobar'] ) // result[ 2 ]
    -> peek_result( 0, $y ) // copy result[ 0 ] to $y ( result[ 0 ] be not delete )
    -> get_document( $x['foobar'], 'databse2' ) // result[ 3 ]
    -> get_document( $x['foobar'], 'databse3' ) // result[ 4 ]
    -> get_document( $x['foobar'], 'databse4' ) // result[ 5 ]
    ;

// this will be out 5 results
var_dump( $c->results )
```

# License

[MIT](LICENSE)

# Author

Usagi Ito

