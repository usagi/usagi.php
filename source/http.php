<?php

namespace usagi\http;

function make_base_url( $scheme, $host, $port = 80 )
{
  if ( $scheme === 'http' && $port === 80 )
    return $scheme.'://'.$host;
  else if ( $scheme === 'https' && $port === 443 )
    return $scheme.'://'.$host;
  return $scheme.'://'.$host.':'.$port;
}

function make_path( $path_parts = [] )
{ return '/'.implode( '/', array_map( 'urlencode', $path_parts ) ); }

function make_query( $queries = [] )
{
  if ( empty( $queries ) )
    return '';
  
  $intermediate = [];
  foreach ( $queries as $key => $value )
  {
    $element = urlencode( $key );
    if ( is_scalar( $value ) )
      $element .= '='.urlencode( var_export( $value, true ) );
    array_push( $intermediate, $element );
  }
  
  return '?'.implode( '&', $intermediate );
}

function make_url_without_queries( $scheme, $host, $port, $path_parts = [] )
{
  return
      make_base_url( $scheme, $host, $port )
    . make_path( $path_parts )
    ;
}

function make_url( $scheme, $host, $port, $path_parts = [], $queries = [] )
{
  return
      make_url_without_queries( $scheme, $host, $port, $path_parts )
    . make_query( $queries )
    ;
}

function is_succeeded( $response )
{
  $status_code = $response[ 'status_code' ];
  return $status_code >= 200 && $status_code < 300;
}

function request( $url, $method = 'GET', $data = null, $headers = [], $ignore_errors = true )
{
  $header_intermediate = [];
  foreach ( $headers as $key => $value )
    array_push( $header_intermediate, trim( $key ).':'.trim( $value ) );
  
  $content = file_get_contents
    ( $url
    , false
    , stream_context_create
      ( [ 'http' =>
          [ 'method' => $method
          , 'content' => $data
          , 'header' => implode( "\r\n", $header_intermediate )
          , 'ignore_errors' => $ignore_errors
          ]
        ]
      )
  );
  
  preg_match
  ( '/HTTP\/1\.[0|1|x] ([0-9]{3})/'
  , array_shift( $http_response_header )
  , $matches
  );
  $status_code = intval( $matches[ 1 ] );
  
  $headers = [];
  foreach ( $http_response_header as $line )
  {
    $intermediate = explode( ':', $line, 2 );
    if ( count( $intermediate ) === 2 )
      $headers[ trim( $intermediate[ 0 ] ) ] = trim( $intermediate[ 1 ] );
  }
  
  return
    [ 'status_code' => $status_code
    , 'headers'     => $headers
    , 'content'     => $content
    ];
}
