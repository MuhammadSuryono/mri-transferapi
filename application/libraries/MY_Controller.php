<?php
    class MY_Controller extends Controller {
        function __construct(){
            parent::__construct();

            $this->load->helper('url');
            $this->load->helper('cookie');
            if(!get_cookie('lemon')){
                redirect('http://www.google.com/'); 
            }
        }
    }
?>