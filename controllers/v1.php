<?php

require(APPPATH.'/libraries/REST_Controller.php');

class V1 extends REST_Controller
{
	
	function agreement_get () {
		
		if(!$this->get('id')) $this->response(NULL, 400);
		
		$this->load->model('agreement');
		$data = $this->agreement->getLatest($this->get('id'));
		
		if (is_array($data)) $this->response($data, 200);
		else $this->response(array('error' => 'Agreement not found.'), 404);
	}
	
	function auth_get () {
		
		/*
			RETRIEVE VALIDATION SESSION
		*/
		
		if(!$this->get('sid') && !$this->get('token')) $this->response(NULL, 400);
		
		if ($this->get('sid')) $this->db->where('sid',$this->get('sid'));
		else $this->db->where('token',$this->get('token'));
		
		
		$q = $this->db->get('auth');
		$data = $q->row_array();
		
		if ($data) $this->response($data, 200);
		else $this->response(array('error' => 'Authorization session not found.'), 404);
	}
	
	function auth_init_post () {
		
		/*
			CREATE VALIDATION SESSION
		*/
		
		if(!$this->post('sid') || !$this->post('returnURI')) $this->response(NULL, 400);
		
		// Clean Up Database
		$this->db->where('tsCreated + INTERVAL 10 MINUTE < NOW()',null,FALSE);
		$this->db->delete('auth');
		
		// Remove Old Session Keys
		$this->db->where('sid',$this->post('sid'));
		$this->db->delete('auth');
		
		// Generate Token and Store
		$data['brid'] = $this->post('brid');
		$data['sid'] = $this->post('sid');
		$data['returnURI'] = $this->post('returnURI');
		$q = $this->db->insert('auth',$data);
		
		if ($q) $this->response($data, 200);
		else $this->response(array('error' => 'Session could not be stored.'), 500);
	
	}
	
	function auth_validate_post () {
		
		/*
			UPDATE VALIDATION SESSION
		*/
		
		$this->db->select('entities.eid, entities.password, emailbook.email');
		$this->db->join('emailbook','entities.eid=emailbook.eid','left');
		$this->db->where("emailbook.email",$this->post('email'));
		$this->db->where("entities.password",$this->post('hash'));
		$this->db->limit(1);
		$q = $this->db->get_where('entities');
		$r = $q->row_array();
		
		if ($q->num_rows() > 0) {
			
			$data['eid'] = $r['eid'];
			$data['token'] = uniqid();
			
			$this->db->where('sid',$this->post('sid'));
			$this->db->update('auth',$data);
			
			$this->response($data, 200);
			
		} else $this->response(array('error' => 'Entity not found.'), 404);
		
	}
	
	function auth_delete () {
		
		/*
			DELETE VALIDATION SESSION
		*/
		
		if(!$this->get('token')) $this->response(NULL, 400);
		
		$this->db->where('token',$this->delete('token'));
		$q = $this->db->get('auth');
		$session = $q->row_array();
		
		if (isset($session['eid'])) {
			$entity = $this->entity->get($session['eid']);
			
			$this->db->where('token',$this->delete('token'));
			$q = $this->db->delete('auth');
			
			$data['eid'] = $entity['eid'];
			$data['name'] = $entity['firstName'];
			$data['acctnum'] = $entity['acctnum'];
			$data['isCompany'] = $entity['isCompany'];
			$data['tsUpdated'] = time();
			
			$this->response($data, 200);
			
		} else $this->response(array('error' => 'Error retrieving token.'), 404);

	}
	
	function brand_get () {
		
		if(!$this->post('sid')) $this->response(NULL, 400);
		
		$this->load->model('brand');
		$data = $this->brand->get($this->get('id'));
		
		if ($data) $this->response($data, 200);
		else $this->response(array('error' => 'Brand not found.'), 404);
	}
	
	function eid_email_get () {
		
		if(!$this->post('email')) $this->response(NULL, 400);
		
		$this->load->model('entity');
		$data = $this->entity->getEidByEmail($this->get('email'));
		
		if ($data) $this->response($data, 200);
		else $this->response(array('error' => 'Email not found.'), 404);
	}
	
	function entity_get ()
    {
        if(!$this->get('id')) $this->response(NULL, 400);
		
    	$data = $this->entity->get($this->get('id'));
    	
        if($data) $this->response($data, 200);
        else $this->response(array('error' => 'Entity could not be found.'), 404);
    }
    
    function entity_emails_get ()
    {
        if(!$this->get('id')) $this->response(NULL, 400);
		
    	$user = $this->entity->getEmails($this->get('id'));
    	
        if($user)
        {
            $this->response($user, 200);
        }

        else
        {
            $this->response(array('error' => 'Entity could not be found.'), 404);
        }
    }
    
    function entity_password_put ()
    {
        $data = $this->entity->updatePassword( $this->put('eid'), $this->put('old'), $this->put('new'));
        
        if ($data) $this->response($data, 200);
        else $this->response(array('error' => 'Password could not be updated.'), 500);
    }
    
    function email_put () 
    {
    	$data = $this->entity->addEmail( $this->put('eid'), $this->put('email') );
    	
    	if ($data) $this->response($data, 200);
    	else $this->response(array('error' => 'Email could not be stored.'), 500);
    }
    
    function email_default_put () 
    {
    	$data = $this->entity->updateDefaultEmail( $this->put('eid'), $this->put('emid') );
    	
    	if ($data) $this->response($data, 200);
    	else $this->response(array('error' => 'Email could not be updated.'), 500);
    }
    
    function email_delete ()
    {
    	$data = $this->entity->deleteEmail( $this->delete('emid') );
    	
    	if ($data) $this->response($data, 200);
    	else $this->response(array('error' => 'Email could not be stored.'), 500);
    }
    
    function hosting_domains_get () {
    	
    	$this->load->model('hosting');
    	
    	$data = $this->hosting->getDomains( $this->get('id') );
    	
    	if ($data) $this->response($data, 200);
    	else $this->response(array('error' => 'Domains could not be retrieved.'), 500);
    }
}

?>