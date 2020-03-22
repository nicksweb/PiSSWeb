<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Security extends Admin_Controller {

    /**
     * @var string
     */
    private $_redirect_url;


    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();

        // load the language files
        $this->lang->load('security');

        // load the users model
        $this->load->model('security_model');

        // set constants
        define('REFERRER', "referrer");
        define('THIS_URL', base_url('admin/security'));
        define('DEFAULT_LIMIT', $this->settings->per_page_limit);
        define('DEFAULT_OFFSET', 0);
        define('DEFAULT_SORT', "ID");
        define('DEFAULT_DIR', "desc");

        // use the url in session (if available) to return to the previous filter/sorted/paginated list
        if ($this->session->userdata(REFERRER))
        {
            $this->_redirect_url = $this->session->userdata(REFERRER);
        }
        else
        {
            $this->_redirect_url = THIS_URL;
        }
    }


    /**************************************************************************************
     * PUBLIC FUNCTIONS
     **************************************************************************************/

    /**
     * User list page
     */
    function index()
    {
        // get parameters
        $limit  = $this->input->get('limit')  ? $this->input->get('limit', TRUE)  : DEFAULT_LIMIT;
        $offset = $this->input->get('offset') ? $this->input->get('offset', TRUE) : DEFAULT_OFFSET;
        $sort   = $this->input->get('sort')   ? $this->input->get('sort', TRUE)   : DEFAULT_SORT;
        $dir    = $this->input->get('dir')    ? $this->input->get('dir', TRUE)    : DEFAULT_DIR;

        // get filters
        $filters = array();

        if ($this->input->get('port'))
        {
            $filters['Name'] = $this->input->get('port', TRUE);
        }

        if ($this->input->get('status'))
        {
            $filters['db3.Status'] = $this->input->get('status', TRUE);
        }

        if ($this->input->get('loggedtime'))
        {
            $filters['LoggedTime'] = $this->input->get('loggedtime', TRUE);
        }

        // build filter string
        $filter = "";
        foreach ($filters as $key => $value)
        {
            $filter .= "&{$key}={$value}";
        }

        // save the current url to session for returning
        $this->session->set_userdata(REFERRER, THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");

        // are filters being submitted?
        if ($this->input->post())
        {
            if ($this->input->post('clear'))
            {
                // reset button clicked
                redirect(THIS_URL);
            }
            else
            {
                // apply the filter(s)
                $filter = "";

                if ($this->input->post('port'))
                {
                    $filter .= "&port=" . $this->input->post('port', TRUE);
                }

                if ($this->input->post('status'))
                {
                    $filter .= "&status=" . $this->input->post('status', TRUE);
                }

                if ($this->input->post('loggedtime'))
                {
                    $filter .= "&loggedtime=" . $this->input->post('loggedtime', TRUE);
                }

                // redirect using new filter(s)
                redirect(THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
        }

        // get list
        $piss = $this->security_model->get_all_SensorLog($limit, $offset, $filters, $sort, $dir);

        // build pagination
        $this->pagination->initialize(array(
            'base_url'   => THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
            'total_rows' => $piss['total'],
            'per_page'   => $limit
        ));

        // setup page header data
		$this
			->add_js_theme('users_i18n.js', TRUE )
			->set_title(lang('security title security_list'));

        $data = $this->includes;

        // set content data
        $content_data = array(
            'this_url'   => THIS_URL,
            'securitys'      => $piss['results'],
            'total'      => $piss['total'],
            'filters'    => $filters,
            'filter'     => $filter,
            'pagination' => $this->pagination->create_links(),
            'limit'      => $limit,
            'offset'     => $offset,
            'sort'       => $sort,
            'dir'        => $dir
        );

        // load views
        $data['content'] = $this->load->view('admin/security/list_security', $content_data, TRUE);
        $this->load->view($this->template, $data);
    } 

    /**
     * User list page
     */
    function armingLog()
    {
        // get parameters
        $limit  = $this->input->get('limit')  ? $this->input->get('limit', TRUE)  : DEFAULT_LIMIT;
        $offset = $this->input->get('offset') ? $this->input->get('offset', TRUE) : DEFAULT_OFFSET;
        $sort   = $this->input->get('sort')   ? $this->input->get('sort', TRUE)   : DEFAULT_SORT;
        $dir    = $this->input->get('dir')    ? $this->input->get('dir', TRUE)    : DEFAULT_DIR;

        // get filters
        $filters = array();

        if ($this->input->get('port'))
        {
            $filters['db2.Name'] = $this->input->get('port', TRUE);
        }

        if ($this->input->get('status'))
        {
            $filters['db3.Status'] = $this->input->get('status', TRUE);
        }

        if ($this->input->get('date'))
        {
            $filters['db3.Date'] = $this->input->get('date', TRUE);
        }

        // build filter string
        $filter = "";
        foreach ($filters as $key => $value)
        {
            $filter .= "&{$key}={$value}";
        }

        // save the current url to session for returning
        $this->session->set_userdata(REFERRER, THIS_URL . "/armingLog?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");

        // are filters being submitted?
        if ($this->input->post())
        {
            if ($this->input->post('clear'))
            {
                // reset button clicked
                redirect(THIS_URL);
            }
            else
            {
                // apply the filter(s)
                $filter = "";

                if ($this->input->post('port'))
                {
                    $filter .= "&port=" . $this->input->post('port', TRUE);
                }

                if ($this->input->post('date'))
                {
                    $filter .= "&date=" . $this->input->post('date', TRUE);
                }

                if ($this->input->post('status'))
                {
                    $filter .= "&status=" . $this->input->post('status', TRUE);
                }

                // redirect using new filter(s)
                redirect(THIS_URL . "/armingLog?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
        }

        // get list
        $piss = $this->security_model->get_all_arming_log($limit, $offset, $filters, $sort, $dir);

        // build pagination
        $this->pagination->initialize(array(
            'base_url'   => THIS_URL . "/armingLog?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
            'total_rows' => $piss['total'],
            'per_page'   => $limit
        ));

        // setup page header data
		$this
			->add_js_theme('users_i18n.js', TRUE )
			->set_title(lang('security title arming_list'));

        $data = $this->includes;

        // set content data
        $content_data = array(
            'this_url'   => THIS_URL,
            'securitys'      => $piss['results'],
            'total'      => $piss['total'],
            'filters'    => $filters,
            'filter'     => $filter,
            'pagination' => $this->pagination->create_links(),
            'limit'      => $limit,
            'offset'     => $offset,
            'sort'       => $sort,
            'dir'        => $dir
        );

        // load views
        $data['content'] = $this->load->view('admin/security/list_armingLog', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }

    /**
     * User list page
     */
    function settings()
    {
        // get parameters
        $limit  = $this->input->get('limit')  ? $this->input->get('limit', TRUE)  : DEFAULT_LIMIT;
        $offset = $this->input->get('offset') ? $this->input->get('offset', TRUE) : DEFAULT_OFFSET;
        $sort   = $this->input->get('sort')   ? $this->input->get('sort', TRUE)   : DEFAULT_SORT;
        $dir    = $this->input->get('dir')    ? $this->input->get('dir', TRUE)    : DEFAULT_DIR;

        // get filters
        $filters = array();

        if ($this->input->get('zone'))
        {
            $filters['zone'] = $this->input->get('zone', TRUE);
        }

        if ($this->input->get('first_name'))
        {
            $filters['status'] = $this->input->get('status', TRUE);
        }

        if ($this->input->get('id'))
        {
            $filters['id'] = $this->input->get('id', TRUE);
        }

        // build filter string
        $filter = "";
        foreach ($filters as $key => $value)
        {
            $filter .= "&{$key}={$value}";
        }

        // save the current url to session for returning
        $this->session->set_userdata(REFERRER, THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");

        // are filters being submitted?
        if ($this->input->post())
        {
            if ($this->input->post('clear'))
            {
                // reset button clicked
                redirect(THIS_URL);
            }
            else
            {
                // apply the filter(s)
                $filter = "";

                if ($this->input->post('zone'))
                {
                    $filter .= "&zone=" . $this->input->post('zone', TRUE);
                }

                if ($this->input->post('id'))
                {
                    $filter .= "&id=" . $this->input->post('id', TRUE);
                }

                if ($this->input->post('status'))
                {
                    $filter .= "&status=" . $this->input->post('lasstatust_name', TRUE);
                }

                // redirect using new filter(s)
                redirect(THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}&offset={$offset}{$filter}");
            }
        }

        // get list
        $piss = $this->security_model->get_all($limit, $offset, $filters, $sort, $dir);

        // build pagination
        $this->pagination->initialize(array(
            'base_url'   => THIS_URL . "?sort={$sort}&dir={$dir}&limit={$limit}{$filter}",
            'total_rows' => $piss['total'],
            'per_page'   => $limit
        ));

        // setup page header data
		$this
			->add_js_theme('users_i18n.js', TRUE )
			->set_title(lang('security title user_list'));

        $data = $this->includes;

        // set content data
        $content_data = array(
            'this_url'   => THIS_URL,
            'users'      => $piss['results'],
            'total'      => $piss['total'],
            'filters'    => $filters,
            'filter'     => $filter,
            'pagination' => $this->pagination->create_links(),
            'limit'      => $limit,
            'offset'     => $offset,
            'sort'       => $sort,
            'dir'        => $dir
        );

        // load views
        $data['content'] = $this->load->view('admin/security/list', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }


    /**
     * Add new user
     */
    function add()
    {
        // validators
        $this->form_validation->set_error_delimiters($this->config->item('error_delimeter_left'), $this->config->item('error_delimeter_right'));
        $this->form_validation->set_rules('username', lang('security input username'), 'required|trim|min_length[5]|max_length[30]|callback__check_username[]');
        $this->form_validation->set_rules('first_name', lang('security input first_name'), 'required|trim|min_length[2]|max_length[32]');
        $this->form_validation->set_rules('last_name', lang('security input last_name'), 'required|trim|min_length[2]|max_length[32]');
        $this->form_validation->set_rules('email', lang('security input email'), 'required|trim|max_length[128]|valid_email|callback__check_email[]');
        $this->form_validation->set_rules('language', lang('security input language'), 'required|trim');
        $this->form_validation->set_rules('status', lang('security input status'), 'required|numeric');
        $this->form_validation->set_rules('is_admin', lang('security input is_admin'), 'required|numeric');
        $this->form_validation->set_rules('password', lang('security input password'), 'required|trim|min_length[5]');
        $this->form_validation->set_rules('password_repeat', lang('security input password_repeat'), 'required|trim|matches[password]');

        if ($this->form_validation->run() == TRUE)
        {
            // save the new user
            $saved = $this->security_model->add_user($this->input->post());

            if ($saved)
            {
                $this->session->set_flashdata('message', sprintf(lang('security msg add_user_success'), $this->input->post('first_name') . " " . $this->input->post('last_name')));
            }
            else
            {
                $this->session->set_flashdata('error', sprintf(lang('security error add_user_failed'), $this->input->post('first_name') . " " . $this->input->post('last_name')));
            }

            // return to list and display message
            redirect($this->_redirect_url);
        }

        // setup page header data
        $this->set_title(lang('security title user_add'));

        $data = $this->includes;

        // set content data
        $content_data = array(
            'cancel_url'        => $this->_redirect_url,
            'user'              => NULL,
            'password_required' => TRUE
        );

        // load views
        $data['content'] = $this->load->view('admin/security/form', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }


    /**
     * Edit existing user
     *
     * @param  int $id
     */
    function edit($id=NULL)
    {
        // make sure we have a numeric id
        if (is_null($id) OR ! is_numeric($id))
        {
            redirect($this->_redirect_url);
        }

        // get the data
        $user = $this->security_model->get_user($id);

        // if empty results, return to list
        if ( ! $user)
        {
            redirect($this->_redirect_url);
        }

        // validators
        $this->form_validation->set_error_delimiters($this->config->item('error_delimeter_left'), $this->config->item('error_delimeter_right'));
        $this->form_validation->set_rules('username', lang('security input username'), 'required|trim|min_length[5]|max_length[30]|callback__check_username[' . $user['username'] . ']');
        $this->form_validation->set_rules('first_name', lang('security input first_name'), 'required|trim|min_length[2]|max_length[32]');
        $this->form_validation->set_rules('last_name', lang('security input last_name'), 'required|trim|min_length[2]|max_length[32]');
        $this->form_validation->set_rules('email', lang('security input email'), 'required|trim|max_length[128]|valid_email|callback__check_email[' . $user['email'] . ']');
        $this->form_validation->set_rules('language', lang('security input language'), 'required|trim');
        $this->form_validation->set_rules('status', lang('security input status'), 'required|numeric');
        $this->form_validation->set_rules('is_admin', lang('security input is_admin'), 'required|numeric');
        $this->form_validation->set_rules('password', lang('security input password'), 'min_length[5]|matches[password_repeat]');
        $this->form_validation->set_rules('password_repeat', lang('security input password_repeat'), 'matches[password]');

        if ($this->form_validation->run() == TRUE)
        {
            // save the changes
            $saved = $this->security_model->edit_user($this->input->post());

            if ($saved)
            {
                $this->session->set_flashdata('message', sprintf(lang('security msg edit_user_success'), $this->input->post('first_name') . " " . $this->input->post('last_name')));
            }
            else
            {
                $this->session->set_flashdata('error', sprintf(lang('security error edit_user_failed'), $this->input->post('first_name') . " " . $this->input->post('last_name')));
            }

            // return to list and display message
            redirect($this->_redirect_url);
        }

        // setup page header data
        $this->set_title(lang('security title user_edit'));

        $data = $this->includes;

        // set content data
        $content_data = array(
            'cancel_url'        => $this->_redirect_url,
            'user'              => $user,
            'user_id'           => $id,
            'password_required' => FALSE
        );

        // load views
        $data['content'] = $this->load->view('admin/security/form', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }


    /**
     * Delete a user
     *
     * @param  int $id
     */
    function delete($id=NULL)
    {
        // make sure we have a numeric id
        if ( ! is_null($id) OR ! is_numeric($id))
        {
            // get user details
            $user = $this->security_model->get_user($id);

            if ($user)
            {
                // soft-delete the user
                $delete = $this->security_model->delete_user($id);

                if ($delete)
                {
                    $this->session->set_flashdata('message', sprintf(lang('security msg delete_user'), $user['first_name'] . " " . $user['last_name']));
                }
                else
                {
                    $this->session->set_flashdata('error', sprintf(lang('security error delete_user'), $user['first_name'] . " " . $user['last_name']));
                }
            }
            else
            {
                $this->session->set_flashdata('error', lang('security error user_not_exist'));
            }
        }
        else
        {
            $this->session->set_flashdata('error', lang('security error user_id_required'));
        }

        // return to list and display message
        redirect($this->_redirect_url);
    }


    /**
     * Export list to CSV
     */
    function export()
    {
        // get parameters
        $sort = $this->input->get('sort') ? $this->input->get('sort', TRUE) : DEFAULT_SORT;
        $dir  = $this->input->get('dir')  ? $this->input->get('dir', TRUE)  : DEFAULT_DIR;

        // get filters
        $filters = array();

        if ($this->input->get('username'))
        {
            $filters['username'] = $this->input->get('username', TRUE);
        }

        if ($this->input->get('first_name'))
        {
            $filters['first_name'] = $this->input->get('first_name', TRUE);
        }

        if ($this->input->get('last_name'))
        {
            $filters['last_name'] = $this->input->get('last_name', TRUE);
        }

        // get all users
        $piss = $this->security_model->get_all(0, 0, $filters, $sort, $dir);

        if ($piss['total'] > 0)
        {
            // manipulate the output array
            foreach ($piss['results'] as $key=>$user)
            {
                unset($piss['results'][$key]['password']);
                unset($piss['results'][$key]['deleted']);

                if ($user['status'] == 0)
                {
                    $piss['results'][$key]['status'] = lang('admin input inactive');
                }
                else
                {
                    $piss['results'][$key]['status'] = lang('admin input active');
                }
            }

            // export the file
            array_to_csv($piss['results'], "users");
        }
        else
        {
            // nothing to export
            $this->session->set_flashdata('error', lang('core error no_results'));
            redirect($this->_redirect_url);
        }

        exit;
    }


    /**************************************************************************************
     * PRIVATE VALIDATION CALLBACK FUNCTIONS
     **************************************************************************************/


    /**
     * Make sure username is available
     *
     * @param  string $username
     * @param  string|null $current
     * @return int|boolean
     */
    function _check_username($username, $current)
    {
        if (trim($username) != trim($current) && $this->security_model->username_exists($username))
        {
            $this->form_validation->set_message('_check_username', sprintf(lang('security error username_exists'), $username));
            return FALSE;
        }
        else
        {
            return $username;
        }
    }


    /**
     * Make sure email is available
     *
     * @param  string $email
     * @param  string|null $current
     * @return int|boolean
     */
    function _check_email($email, $current)
    {
        if (trim($email) != trim($current) && $this->security_model->email_exists($email))
        {
            $this->form_validation->set_message('_check_email', sprintf(lang('security error email_exists'), $email));
            return FALSE;
        }
        else
        {
            return $email;
        }
    }

}
