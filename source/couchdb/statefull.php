<?php

namespace usagi\couchdb;

require_once dirname(__FILE__).'/stateless.php';

class statefull
{
  private $scheme = 'http';
  private $host = '127.0.0.1';
  private $port = 5984;
  private $database = null;
  private $document = null;
  private $design = null;
  private $view = null;
  private $queries = [];
  private $last_return = null;
  
  public function set_scheme( $in ) { $this->scheme = $in; return $this; }
  public function set_host( $in ) { $this->host = $in; return $this; }
  public function set_port( $in ) { $this->port = $in; return $this; }
  public function set_database( $in ) { $this->database = $in; return $this; }
  public function set_document( $in ) { $this->document = $in; return $this; }
  public function set_design( $in ) { $this->design = $in; return $this; }
  public function set_view( $in ) { $this->view = $in; return $this; }
  public function set_queries( $in ) { $this->queries = $in; return $this; }
  
  public function get_scheme( $in ) { return $this->scheme; }
  public function get_host( $in ) { return $this->host; }
  public function get_port( $in ) { return $this->port; }
  public function get_database( $in ) { return $this->database; }
  public function get_document( $in ) { return $this->document; }
  public function get_design( $in ) { return $this->design; }
  public function get_view( $in ) { return $this->view; }
  public function get_queries( $in ) { return $this->queries; }
  
  public function get_version()
  {
    return get_version
      ( $this->scheme
      , $this->host
      , $this->port
      );
  }
  
  public static function is_exists_database()
  {
    return is_exists_database
      ( $this->scheme
      , $this->host
      , $this->port
      , $this->database
      );
  }
  
  public static function create_database()
  {
    return create_database
    ( $this->scheme
    , $this->host
    , $this->port
    , $this->database
    );
  }
  
  public static function delete_database()
  {
    return delete_database
      ( $this->scheme
      , $this->host
      , $this->port
      , $this->database
      );
  }
}
