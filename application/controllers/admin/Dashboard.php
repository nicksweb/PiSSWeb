<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();

        // load the language files
        $this->lang->load('dashboard');

         // load the language files
         $this->lang->load('security');

         // load the users model
         $this->load->model('security_model');
    }


    /**
     * Dashboard
     */
    function index()
    {
        // setup page header data
		$this
			->add_js_theme('dashboard_i18n.js', TRUE)
			->set_title(lang('admin title admin'));

        $data = $this->includes;

        $piss = $this->security_model->get_zone_status();
        $pissClear = $this->security_model->get_zoneInAlarm();

        // load views
        #$data['content'] = $this->load->view('admin/dashboard', NULL, TRUE);
        #$data['zones'] = $piss['results'];

        // set content data
        $content_data = array(
            'content'   => $this->load->view('admin/dashboard', NULL, TRUE),
            'zones'      => $piss['results'],
            'ZoneInAlarms' => $pissClear['results'],
            'apikey' => $this->settings->apitoken
       );

        // load views
        $data['content'] = $this->load->view('admin/dashboard', $content_data, TRUE);
        $this->load->view($this->template, $data);

    }

}
