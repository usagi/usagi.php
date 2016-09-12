<?php

namespace usagi\couchdb;

require_once dirname(__FILE__).'/../http.php';

function json_decode_wrapped( $in )
{ return json_decode( $in, true, 512, JSON_BIGINT_AS_STRING ); }

function trim_etag( $in )
{ return trim( $in, '"'); }

function extract_etag( $response_headers )
{ return trim_etag( $response_headers[ 'ETag' ] ); }

function extract_etag_if_status_code_was_succeeded( $response )
{
  return ( \usagi\http\is_succeeded( $response ) )
    ? extract_etag( $response[ 'headers' ] )
    : false
    ;
}

function extract_decoded_content_if_status_code_was_succeeded( $response )
{
  return ( \usagi\http\is_succeeded( $response ) )
    ? json_decode_wrapped( $response[ 'content' ] )
    : false
    ;
}

function extract_content_if_status_code_was_succeeded( $response )
{
  return ( \usagi\http\is_succeeded( $response ) )
    ? $response[ 'content' ]
    : false
    ;
}

function extract_rev_if_status_code_was_succeeded( $response )
{
  $data = extract_decoded_content_if_status_code_was_succeeded( $response );
  
  if ( ! $data )
    return false;
  
  if ( ! array_key_exists( '_rev', $data ) )
    return false;
  
  return $data[ '_rev' ];
}

function get_version( $scheme, $host, $port )
{
  $r = \usagi\http\request
    ( \usagi\http\make_base_url
      ( $scheme
      , $host
      , $port
      )
    );
  
  return extract_decoded_content_if_status_code_was_succeeded( $r );
}

function is_exists_database( $scheme, $host, $port, $database )
{
  $r = \usagi\http\request
    ( \usagi\http\make_url
      ( $scheme
      , $host
      , $port
      , [ $database ]
      )
    , 'HEAD'
    );
  
  return \usagi\http\is_succeeded( $r );
}

function create_database( $scheme, $host, $port, $database )
{
  $r = \usagi\http\request
    ( \usagi\http\make_url
      ( $scheme
      , $host
      , $port
      , [ $database ]
      )
    , 'PUT'
    );
  
  return \usagi\http\is_succeeded( $r );
}

function delete_database( $scheme, $host, $port, $database )
{
  $r = \usagi\http\request
    ( \usagi\http\make_url
      ( $scheme
      , $host
      , $port
      , [ $database ]
      )
    , 'DELETE'
    );
  
  return \usagi\http\is_succeeded( $r );
}

function is_exists_document( $scheme, $host, $port, $database, $document )
{
  $r = \usagi\http\request
    ( \usagi\http\make_url
      ( $scheme
      , $host
      , $port
      , [ $database, $document ]
      )
    , 'HEAD'
    );
  
  return extract_etag_if_status_code_was_succeeded( $r );
}

function get_document( $scheme, $host, $port, $database, $document )
{
  $r = \usagi\http\request
    ( \usagi\http\make_url
      ( $scheme
      , $host
      , $port
      , [ $database, $document ]
      )
    );
  
  return extract_decoded_content_if_status_code_was_succeeded( $r );
}

function create_document( $scheme, $host, $port, $database, $document, $data = [] )
{
  $data = is_array( $data )
    ? json_encode( $data, JSON_FORCE_OBJECT )
    : '{}'
    ;
  
  $r = \usagi\http\request
    ( \usagi\http\make_url
      ( $scheme
      , $host
      , $port
      , [ $database, $document ]
      )
    , 'PUT'
    , $data
    , [ 'content-type' => 'application/json' ]
    );
  
  return extract_decoded_content_if_status_code_was_succeeded( $r );
}

function delete_document( $scheme, $host, $port, $database, $document, $rev = null )
{
  if ( empty( $rev ) )
  {
    $rev = is_exists_document( $scheme, $host, $port, $database, $document );
    
    if ( $rev === false )
      return false;
  }
  
  $r2 = \usagi\http\request
    ( \usagi\http\make_url
      ( $scheme
      , $host
      , $port
      , [ $database, $document ]
      , [ 'rev' => $rev ]
      )
    , 'DELETE'
    );
  
  return \usagi\http\is_succeeded( $r2 );
}

function update_document( $scheme, $host, $port, $database, $document, $data )
{
  if ( ! is_array( $data ) )
    return false;
  
  if ( ! array_key_exists( '_rev', $data ) )
  {
    $rev = is_exists_document( $scheme, $host, $port, $database, $document );
    
    if ( $rev === false )
      return false;
    
    $data[ '_rev' ] = $rev;
  }
  
  $r2 = \usagi\http\request
    ( \usagi\http\make_url
      ( $scheme
      , $host
      , $port
      , [ $database, $document ]
      )
    , 'PUT'
    , json_encode( $data, JSON_FORCE_OBJECT )
    );
  
  return extract_decoded_content_if_status_code_was_succeeded( $r2 );
}

function is_exists_attachment( $scheme, $host, $port, $database, $document, $attachment )
{
  $rev = is_exists_document( $scheme, $host, $port, $database, $document );
  
  if ( $rev === false )
    return false;
  
  $r = \usagi\http\request
    ( \usagi\http\make_url
      ( $scheme
      , $host
      , $port
      , [ $database, $document, $attachment ]
      )
    , 'HEAD'
    );
  
  if ( ! \usagi\http\is_succeeded( $r ) )
    return false;
  
  $headers = $r[ 'headers' ];
  
  return
    [ 'rev'     => $rev
    , 'headers' =>
      [ 'Date'           => $headers[ 'Date'           ]
      , 'Content-Type'   => $headers[ 'Content-Type'   ]
      , 'Content-MD5'    => $headers[ 'Content-MD5'    ]
      , 'Content-Length' => $headers[ 'Content-Length' ]
      ]
    ];
}

function get_attachment( $scheme, $host, $port, $database, $document, $attachment )
{
  $r = \usagi\http\request
    ( \usagi\http\make_url
      ( $scheme
      , $host
      , $port
      , [ $database, $document, $attachment ]
      )
    );
  
  return extract_content_if_status_code_was_succeeded( $r );
}

function attach_document( $scheme, $host, $port, $database, $document, $local_file_path, $attachment = null, $rev = null )
{
  $binary = file_get_contents( $local_file_path );
  
  if ( $binary === false )
    return false;
  
  if ( empty( $attachment ) )
    $attachment = basename( $local_file_path );
  
  if ( empty( $rev ) )
    $rev = is_exists_document( $scheme, $host, $port, $database, $document );
  
  if ( $rev === false )
    return false;
  
  $r = \usagi\http\request
    ( \usagi\http\make_url
      ( $scheme
      , $host
      , $port
      , [ $database, $document, $attachment ]
      , [ 'rev' => $rev ]
      )
    , 'PUT'
    , $binary
    , [ 'content-type' => mime_content_type( $local_file_path ) ]
    );
  
  return extract_decoded_content_if_status_code_was_succeeded( $r );
}

function detach_document( $scheme, $host, $port, $database, $document, $attachment, $rev = null )
{
  if ( empty( $rev ) )
  {
    $attachment_head = is_exists_attachment( $scheme, $host, $port, $database, $document, $attachment );
    if ( $attachment_head === false )
      return false;
    
    $rev = $attachment_head[ 'rev' ];
  }
  
  $r = \usagi\http\request
    ( \usagi\http\make_url
      ( $scheme
      , $host
      , $port
      , [ $database, $document, $attachment ]
      , [ 'rev' => $rev ]
      )
    , 'DELETE'
    );
  
  return \usagi\http\is_succeeded( $r );
}

function all_docs( $scheme, $host, $port, $database, $queries = [] )
{
  $r = \usagi\http\request
    ( \usagi\http\make_url
      ( $scheme
      , $host
      , $port
      , [ $database, '_all_docs' ]
      , $queries
      )
    );
  
  return extract_decoded_content_if_status_code_was_succeeded( $r );
}

function all_docs_include_docs( $scheme, $host, $port, $database, $queries = [] )
{
  $queries[ 'include_docs' ] = true;
  $r = \usagi\http\request
    ( \usagi\http\make_url
      ( $scheme
      , $host
      , $port
      , [ $database, '_all_docs' ]
      , $queries
      )
    );
  
  return extract_decoded_content_if_status_code_was_succeeded( $r );
}

function get_view( $scheme, $host, $port, $database, $design, $view, $queries = [] )
{
  $r = \usagi\http\request
    ( \usagi\http\make_url
      ( $scheme
      , $host
      , $port
      , [ $database, '_design', $design, '_view', $view ]
      , $queries
      )
    );
  
  return extract_decoded_content_if_status_code_was_succeeded( $r );
}

