<?php
/**
 * NIE UŻYWAĆ
 *
 * @author Konrad Kowalewski <k.j.kowalewski@gmail.com>
 */
class SSE
{
  private $event;
  private $msg;
  
  public function __construct($event, $msg = array())
  {
    $this->event = $event;
    $this->msg = $msg;
  }
  
  private function content()
  {
    $echo = 'id: '.time().PHP_EOL;
    $echo .= 'event: '.$this->event.PHP_EOL;
    $echo .= 'data: '.json_encode($this->msg).PHP_EOL;
    $echo .= PHP_EOL;
    return $echo;
  }
  
  public function broadcast()
  {
    header('Content-Type: text/event-stream');
    header('Cache-Control: no-cache'); // recommended to prevent caching of event data.
    echo $this->content();
    ob_flush();
    flush(); 
  }
  
  public function respond()
  {
    $response = Response::make($this->content(), 200)
            ->header('Content-Type', 'text/event-stream')
            ->header('Cache-Control', 'no-cache');
    return $response;
  }
}
