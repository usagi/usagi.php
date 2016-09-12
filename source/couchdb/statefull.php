<?php

namespace usagi\couchdb;

require_once dirname(__FILE__).'/stateless.php';

class statefull
{
  public $scheme = 'http';
  public $host = '127.0.0.1';
  public $port = 5984;
  public $database = null;
  public $document = null;
  public $attachment = null;
  public $design = null;
  public $view = null;
  public $queries = [];
  public $data = [];
  public $rev = null;
  
  public $results = [];
  public $lock_results = false;
  
  public $auto_memorize_parameters = true;
  
  public function set_scheme( $in ) { $this->scheme = $in; return $this; }
  public function set_host( $in ) { $this->host = $in; return $this; }
  public function set_port( $in ) { $this->port = $in; return $this; }
  public function set_database( $in ) { $this->database = $in; return $this; }
  public function set_document( $in ) { $this->document = $in; return $this; }
  public function set_design( $in ) { $this->design = $in; return $this; }
  public function set_view( $in ) { $this->view = $in; return $this; }
  public function set_queries( $in ) { $this->queries = $in; return $this; }
  public function set_data( $in ) { $this->data = $in; return $this; }
  
  public function set_auto_memorize_parameters( $in ) { $this->auto_memorize_parameters = $in; return $this; }
  
  public function get_version
  ( $port = null
  , $host = null
  , $scheme = null
  )
  {
    if ( $this->auto_memorize_parameters )
    {
      if ( ! is_null( $port ) )
        $this->port = $port;
      if ( ! is_null( $host ) )
        $this->host = $host;
      if ( ! is_null( $scheme ) )
        $this->scheme = $scheme;
    }
    
    array_push
    ( $this->results
    , get_version
      ( $this->scheme
      , $this->host
      , $this->port
      )
    );
    
    return $this;
  }
  
  public function is_exists_database
  ( $database = null
  , $port = null
  , $host = null
  , $scheme = null
  )
  {
    if ( $this->auto_memorize_parameters )
    {
      if ( ! is_null( $database ) )
        $this->database = $database;
      if ( ! is_null( $port ) )
        $this->port = $port;
      if ( ! is_null( $host ) )
        $this->host = $host;
      if ( ! is_null( $scheme ) )
        $this->scheme = $scheme;
    }
    
    array_push
    ( $this->results
    , is_exists_database
      ( $this->scheme
      , $this->host
      , $this->port
      , $this->database
      )
    );
    
    return $this;
  }
  
  public function create_database
  ( $database = null
  , $port = null
  , $host = null
  , $scheme = null
  )
  {
    if ( $this->auto_memorize_parameters )
    {
      if ( ! is_null( $database ) )
        $this->database = $database;
      if ( ! is_null( $port ) )
        $this->port = $port;
      if ( ! is_null( $host ) )
        $this->host = $host;
      if ( ! is_null( $scheme ) )
        $this->scheme = $scheme;
    }
    
    array_push
    ( $this->results
    , create_database
      ( $this->scheme
      , $this->host
      , $this->port
      , $this->database
      )
    );
    
    return $this;
  }
  
  public function delete_database
  ( $database = null
  , $port = null
  , $host = null
  , $scheme = null
  )
  {
    if ( $this->auto_memorize_parameters )
    {
      if ( ! is_null( $database ) )
        $this->database = $database;
      if ( ! is_null( $port ) )
        $this->port = $port;
      if ( ! is_null( $host ) )
        $this->host = $host;
      if ( ! is_null( $scheme ) )
        $this->scheme = $scheme;
    }
    
    array_push
    ( $this->results
    , delete_database
      ( $this->scheme
      , $this->host
      , $this->port
      , $this->database
      )
    );
    
    return $this;
  }
  
  public function is_exists_document
  ( $document = null
  , $database = null
  , $port = null
  , $host = null
  , $scheme = null
  )
  {
    if ( $this->auto_memorize_parameters )
    {
      if ( ! is_null( $document ) )
        $this->document = $document;
      if ( ! is_null( $database ) )
        $this->database = $database;
      if ( ! is_null( $port ) )
        $this->port = $port;
      if ( ! is_null( $host ) )
        $this->host = $host;
      if ( ! is_null( $scheme ) )
        $this->scheme = $scheme;
    }
    
    array_push
    ( $this->results
    , is_exists_document
      ( $this->scheme
      , $this->host
      , $this->port
      , $this->database
      , $this->document
      )
    );
    
    return $this;
  }
  
  public function get_document
  ( $document = null
  , $database = null
  , $port = null
  , $host = null
  , $scheme = null
  )
  {
    if ( $this->auto_memorize_parameters )
    {
      if ( ! is_null( $document ) )
        $this->document = $document;
      if ( ! is_null( $database ) )
        $this->database = $database;
      if ( ! is_null( $port ) )
        $this->port = $port;
      if ( ! is_null( $host ) )
        $this->host = $host;
      if ( ! is_null( $scheme ) )
        $this->scheme = $scheme;
    }
    
    array_push
    ( $this->results
    , get_document
      ( $this->scheme
      , $this->host
      , $this->port
      , $this->database
      , $this->document
      )
    );
    
    return $this;
  }
  
  public function create_document
  ( $data = null
  , $document = null
  , $database = null
  , $port = null
  , $host = null
  , $scheme = null
  )
  {
    if ( $this->auto_memorize_parameters )
    {
      if ( ! is_null( $data ) )
        $this->data = $data;
      if ( ! is_null( $document ) )
        $this->document = $document;
      if ( ! is_null( $database ) )
        $this->database = $database;
      if ( ! is_null( $port ) )
        $this->port = $port;
      if ( ! is_null( $host ) )
        $this->host = $host;
      if ( ! is_null( $scheme ) )
        $this->scheme = $scheme;
    }
    
    array_push
    ( $this->results
    , create_document
      ( $this->scheme
      , $this->host
      , $this->port
      , $this->database
      , $this->document
      , $this->data
      )
    );
    
    return $this;
  }
  
  public function delete_document
  ( $document = null, $rev = null
  , $database = null
  , $port = null
  , $host = null
  , $scheme = null
  )
  {
    if ( $this->auto_memorize_parameters )
    {
      if ( ! is_null( $document ) )
        $this->document = $document;
      if ( ! is_null( $rev ) )
        $this->rev = $rev;
      
      if ( ! is_null( $database ) )
        $this->database = $database;
      if ( ! is_null( $port ) )
        $this->port = $port;
      if ( ! is_null( $host ) )
        $this->host = $host;
      if ( ! is_null( $scheme ) )
        $this->scheme = $scheme;
    }
    
    array_push
    ( $this->results
    , delete_document
      ( $this->scheme
      , $this->host
      , $this->port
      , $this->database
      , $this->document
      , $this->rev
      )
    );
    
    return $this;
  }
  
  public function update_document
  ( $data = null
  , $document = null
  , $database = null
  , $port = null
  , $host = null
  , $scheme = null
  )
  {
    if ( $this->auto_memorize_parameters )
    {
      if ( ! is_null( $data ) )
        $this->data = $data;
      if ( ! is_null( $document ) )
        $this->document = $document;
      if ( ! is_null( $database ) )
        $this->database = $database;
      if ( ! is_null( $port ) )
        $this->port = $port;
      if ( ! is_null( $host ) )
        $this->host = $host;
      if ( ! is_null( $scheme ) )
        $this->scheme = $scheme;
    }
    
    array_push
    ( $this->results
    , update_document
      ( $this->scheme
      , $this->host
      , $this->port
      , $this->database
      , $this->document
      , $data
      )
    );
    
    return $this;
  }
  
  public function is_exists_attachment
  ( $attachment = null
  , $document = null
  , $database = null
  , $port = null
  , $host = null
  , $scheme = null
  )
  {
    if ( $this->auto_memorize_parameters )
    {
      if ( ! is_null( $attachment ) )
        $this->attachment = $attachment;
      if ( ! is_null( $document ) )
        $this->document = $document;
      if ( ! is_null( $database ) )
        $this->database = $database;
      if ( ! is_null( $port ) )
        $this->port = $port;
      if ( ! is_null( $host ) )
        $this->host = $host;
      if ( ! is_null( $scheme ) )
        $this->scheme = $scheme;
    }
    
    array_push
    ( $this->results
    , is_exists_attachment
      ( $this->scheme
      , $this->host
      , $this->port
      , $this->database
      , $this->document
      , $this->attachment
      )
    );
    
    return $this;
  }
  
  public function get_attachment
  ( $attachment = null
  , $document = null
  , $database = null
  , $port = null
  , $host = null
  , $scheme = null
  )
  {
    if ( $this->auto_memorize_parameters )
    {
      if ( ! is_null( $attachment ) )
        $this->attachment = $attachment;
      if ( ! is_null( $document ) )
        $this->document = $document;
      if ( ! is_null( $database ) )
        $this->database = $database;
      if ( ! is_null( $port ) )
        $this->port = $port;
      if ( ! is_null( $host ) )
        $this->host = $host;
      if ( ! is_null( $scheme ) )
        $this->scheme = $scheme;
    }
    
    array_push
    ( $this->results
    , get_attachment
      ( $this->scheme
      , $this->host
      , $this->port
      , $this->database
      , $this->document
      , $this->attachment
      )
    );
    
    return $this;
  }
  
  public function attach_document
  ( $local_file_path
  , $attachment = null
  , $rev = null
  , $document = null
  , $database = null
  , $port = null
  , $host = null
  , $scheme = null
  )
  {
    if ( $this->auto_memorize_parameters )
    {
      if ( ! is_null( $attachment ) )
        $this->attachment = $attachment;
      if ( ! is_null( $document ) )
        $this->document = $document;
      if ( ! is_null( $database ) )
        $this->database = $database;
      if ( ! is_null( $port ) )
        $this->port = $port;
      if ( ! is_null( $host ) )
        $this->host = $host;
      if ( ! is_null( $scheme ) )
        $this->scheme = $scheme;
    }
    
    array_push
    ( $this->results
    , attach_document
      ( $this->scheme
      , $this->host
      , $this->port
      , $this->database
      , $this->document
      , $local_file_path
      , $attachment
      , $rev
      )
    );
    
    return $this;
  }
  
  public function detach_document
  ( $attachment = null, $rev = null
  , $document = null
  , $database = null
  , $port = null
  , $host = null
  , $scheme = null
  )
  {
    if ( $this->auto_memorize_parameters )
    {
      if ( ! is_null( $attachment ) )
        $this->attachment = $attachment;
      
      if ( ! is_null( $document ) )
        $this->document = $document;
      if ( ! is_null( $database ) )
        $this->database = $database;
      if ( ! is_null( $port ) )
        $this->port = $port;
      if ( ! is_null( $host ) )
        $this->host = $host;
      if ( ! is_null( $scheme ) )
        $this->scheme = $scheme;
    }
    
    array_push
    ( $this->results
    , detach_document
      ( $this->scheme
      , $this->host
      , $this->port
      , $this->database
      , $this->document
      , $this->attachment
      , $rev
      )
    );
    
    return $this;
  }
  
  public function all_docs
  ( $queries = null
  , $database = null
  , $port = null
  , $host = null
  , $scheme = null
  )
  {
    if ( $this->auto_memorize_parameters )
    {
      if ( ! is_null( $queries ) )
        $this->queries = $queries;
      if ( ! is_null( $database ) )
        $this->database = $database;
      if ( ! is_null( $port ) )
        $this->port = $port;
      if ( ! is_null( $host ) )
        $this->host = $host;
      if ( ! is_null( $scheme ) )
        $this->scheme = $scheme;
    }
    
    array_push
    ( $this->results
    , all_docs
      ( $this->scheme
      , $this->host
      , $this->port
      , $this->database
      , $queries
      )
    );
    
    return $this;
  }
  
  public function all_docs_include_docs
  ( $queries = null
  , $database = null
  , $port = null
  , $host = null
  , $scheme = null
  )
  {
    if ( $this->auto_memorize_parameters )
    {
      if ( ! is_null( $queries ) )
        $this->queries = $queries;
      if ( ! is_null( $database ) )
        $this->database = $database;
      if ( ! is_null( $port ) )
        $this->port = $port;
      if ( ! is_null( $host ) )
        $this->host = $host;
      if ( ! is_null( $scheme ) )
        $this->scheme = $scheme;
    }
    
    array_push
    ( $this->results
    , all_docs_include_docs
      ( $this->scheme
      , $this->host
      , $this->port
      , $this->database
      , $queries
      )
    );
    
    return $this;
  }
  
  public function get_view
  ( $queries = null
  , $view = null
  , $design = null
  , $database = null
  , $port = null
  , $host = null
  , $scheme = null
  )
  {
    if ( $this->auto_memorize_parameters )
    {
      if ( ! is_null( $queries ) )
        $this->queries = $queries;
      if ( ! is_null( $view ) )
        $this->view = $view;
      if ( ! is_null( $design ) )
        $this->design = $design;
      if ( ! is_null( $database ) )
        $this->database = $database;
      if ( ! is_null( $port ) )
        $this->port = $port;
      if ( ! is_null( $host ) )
        $this->host = $host;
      if ( ! is_null( $scheme ) )
        $this->scheme = $scheme;
    }
    
    array_push
    ( $this->results
    , get_view
      ( $this->scheme
      , $this->host
      , $this->port
      , $this->database
      , $this->design
      , $this->view
      , $queries
      )
    );
    
    return $this;
  }
  
  public function shift_results()
  {
    if ( empty( $this->results ) )
      return FALSE;
    return array_shift( $this->results );
  }
  
  public function pop_results()
  {
    if ( empty( $this->results ) )
      return FALSE;
    return array_pop( $this->results );
  }
  
}
