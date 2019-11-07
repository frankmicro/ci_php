<?php

class MY_Loader extends CI_Loader {

    public function template($template_name, $vars = array(), $return = FALSE)
    {
        if($return):
            $content  = $this->view('layouts/header', $vars, $return);
        if ($this->session->userdata('logged_in') == 1) {
            $content  = $this->view('layouts/navbar', $vars, $return);
        }
        $content .= $this->view($template_name, $vars, $return);
        $content .= $this->view('layouts/footer', $vars, $return);

        return $content;
    else:
        $this->view('layouts/header', $vars);
        if ($this->session->userdata('logged_in') == 1) {
            $this->view('layouts/navbar', $vars);
        }
        $this->view($template_name, $vars);
        $this->view('layouts/footer', $vars);
    endif;
    }
}