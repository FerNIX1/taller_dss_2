<?php

class Template
{
    private $data;
    private $alert_types = array('success', 'alert', 'error');

    function __construct() {}

 
    public function load($url, $title = '')
    {
        if ($title != ''){ $this->set_data('page_title', $title); }
        include($url);
    }

   
    public function redirect($url)
    {
        header("Location: $url");
        exit;
    }

    
    public function set_data($name, $value, $clean = FALSE)
    {
        if ($clean == TRUE)
        {
            $this->data[$name] = htmlentities($value, ENT_QUOTES);
        }
        else
        {
            $this->data[$name] = $value;
        }
    }

   
    public function get_data($name, $echo = TRUE)
    {
        if (isset($this->data[$name]))
        {
            if ($echo)
            {
                echo $this->data[$name];
            }
            else
            {
                return $this->data[$name];
            }
        return '';
        }
    }
   
    public function set_alert($value, $type = 'success')
    {
        $_SESSION[$type][] = $value;
    }

  
    public function get_alerts()
    {
        $data = '';

        foreach($this->alert_types as $alert)
        {
            if (isset($_SESSION[$alert]))
            {
                foreach($_SESSION[$alert] as $value)
                {
                    $data .= '<li class="' . $alert . '">' . $value . '</li>';
                }
                unset($_SESSION[$alert]);
            }
        }
        echo $data;
    }
}