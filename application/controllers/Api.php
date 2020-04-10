<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends API_Controller {

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();

    }


    /**
     * Default
     */
    function index()
    {
        $this->lang->load('core');
        $results['error'] = lang('core error no_results');
        display_json($results);
        exit;
    }

    public function checkaccess() {
		
		$accesslive = $this->input->get("accesstoken");
		$sitetoken = $this->settings->apitoken;
	
	if ($sitetoken == $accesslive ) {
	 return True; 		  			
		} else { 
		 die("Access is strictly prohibited!");
		}
		
	}


    /**
     * Users API - DO NOT LEAVE THIS ACTIVE IN A PRODUCTION ENVIRONMENT !!! - for demo purposes only
     *
    function users()
    {
        // load the users model and admin language file
        $this->load->model('users_model');
        $this->lang->load('admin');

        // get user data
        $users = $this->users_model->get_all();
        $results['data'] = NULL;

        if ($users)
        {
            // build usable array
            foreach($users['results'] as $user)
            {
                $results['data'][$user['id']] = array(
                    'name'   => $user['first_name'] . " " . $user['last_name'],
                    'email'  => $user['email'],
                    'status' => ($user['status']) ? lang('admin input active') : lang('admin input inactive')
                );
            }
            $results['total'] = $users['total'];
        }
        else
            $results['error'] = lang('core error no_results');

        // display results using the JSON formatter helper
        display_json($results);
        exit;
    } */

    function setZone()
    {        
        if($this->checkaccess()) { 

        // save the changes
        $mode = $this->input->get('mode');

        if ($mode == "true" or $mode == "false") {

        $zone = $this->input->get('zone');

        // load the security model
        $this->load->model('security_model');

        // set zone data
        $zone = $this->security_model->setZone($zone,$mode);

        // return to list and display message
        #redirect($this->_redirect_url);
        echo $mode, "   ", $zone;

        exit;
        } 

        if ($mode == "remote") {

            $zone = $this->input->get('zone'); 

            $sitetoken = $this->settings->apitoken;
            $siteurl = $this->settings->siteurl;
            
            $file = $siteurl . $sitetoken . "/" . $zone;

            $command = file_get_contents($file);

            echo $file; 

        } 

    }
    }

}
