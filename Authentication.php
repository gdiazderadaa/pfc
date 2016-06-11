<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authentication {

	var $CI;
	
	/**
	 * Constructor
	 */
    function __construct()
    {
		// Obtain a reference to the ci super object
		$this->CI =& get_instance();
		
		$this->CI->load->library('session');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Check user signin status
	 *
	 * @access public
	 * @return bool
	 */
	function is_signed_in()
	{
		return $this->CI->session->userdata('account_id') ? TRUE : FALSE;
	}
		
	/**
	 * Sign user in ldap
	 *
	 * @access public
	 * @param int $account_id
	 * @param bool $remember
	 * @return void
	 */
	function sign_in_ldap($account_id, $account_pass, $remember = FALSE)
	{
		
		  $servidor_LDAP = "ident.uniovi.es";
		  $servidor_dominio = "uniovi.es";
		  $ldap_dn = "ou=Personal,dc=uniovi,dc=es";
		  $usuario_LDAP = $account_id;
		  $contrasena_LDAP = $account_pass;
		  $idAlumno = null;
		  $idProfesor = null;
			 
		  // Conectando con servidor LDAP desde PHP;

		  $conectado_LDAP = ldap_connect($servidor_LDAP);
		  ldap_set_option($conectado_LDAP, LDAP_OPT_PROTOCOL_VERSION, 3);
		  ldap_set_option($conectado_LDAP, LDAP_OPT_REFERRALS, 0);
		 

		  if ($conectado_LDAP) 
		  {
			//Conectado correctamente al servidor LDAP 

			//Comprobando usuario y contraseNa en Servidor LDAP
			
			
			$autenticado_LDAP = ldap_bind($conectado_LDAP, 
			$usuario_LDAP . "@" . $servidor_dominio, $contrasena_LDAP);
			
			if ($autenticado_LDAP)
			{
				//Autenticacion en servidor LDAP desde Apache y PHP correcta.
				$this->CI->session->set_userdata('account_id', $account_id);
				$remember ? $this->CI->session->cookie_monster(TRUE) : 
				$this->CI->session->cookie_monster(FALSE);

				$usuario_LDAP = $account_id;
				
				//buscamos el usuario en el directorio OU=Personal,DC=ident,DC=uniovi,DC=es
				$busqueda=ldap_search($conectado_LDAP,"OU=Personal,DC=ident,DC=uniovi,DC=es", "CN=$usuario_LDAP", array("UOPerfil"))
				or die ("Error in search query: ".ldap_error($conectado_LDAP));
				$entry = ldap_first_entry($conectado_LDAP, $busqueda);
				$values = null;
				if($entry!= null){
					$values = ldap_get_values($conectado_LDAP, $entry, "UOPerfil");
				}
				//Si devuelve algo es personal, comprobamos que roles tiene
				if($values!= null && $values[count] >0){
					$parents = array('guest');
					$esAdministrativo = false;
					if($values[0] == "PAS" ){
						$esAdministrativo = true;
					}
					/* Se busca el usuario en la base de datos en la que se almacenan los
					 administrativos y los administradores */
					$this->CI->load->model('account/account_model');
					$user = $this->CI->account_model->get_by_username($usuario_LDAP);
					if($user!=false){
						$this->CI->load->model('account_role_model');
						$roles = $this->CI->account_role_model->get_roles_by_id($user->id);
						if($roles != false)
						{
							foreach($roles as $role)
							{  						
								if($role->id != 2|| ($role->id == 2 && $esAdministrativo)){
									$parents[] = $role->name;
								}
							}
						}
					}
					//Si no es administrativo tiene que ser un profesor
					if($esAdministrativo == false){
						if($values[0] == "PDI" ){
							$parents[] = 'profesor';		
							$profesor = $this->CI->account_model->get_profesor_by_username($usuario_LDAP);
							$idProfesor = $profesor->ID_Profesor;							
						}						
					}		
				}	
				else{
					$busqueda=ldap_search($conectado_LDAP,"OU=Alumnos,DC=ident,DC=uniovi,DC=es", "CN=$usuario_LDAP")
					or die ("Error in search query: ".ldap_error($conectado_LDAP));
					$numeroEntradas = ldap_count_entries($conectado_LDAP, $busqueda);		
					if($numeroEntradas>0){
						$parents = array('alumno');
						$alumno = $this->CI->account_model->get_alumno_by_username($account_id);
						$idAlumno = $alumno->ID_Alumno;	
					}
					else{
						$parents = array('guest');
						$this->sign_out();
						return "El usuario no existe en el servidor LDAP ";
					}
				}
				
				$this->CI->session->set_userdata('idAlumno',$idAlumno);	
				$this->CI->session->set_userdata('idProfesor',$idProfesor);	
				$this->CI->session->set_userdata('roles',$parents);	
				
				
			   }
			else
			{
			  $this->sign_out();
			  return "No se ha podido autenticar con el servidor LDAP";
						 
			}
					
			
		  }
		  else 
		  {
			return "No se ha podido realizar la conexiÛn con el servidor LDAP: " .
				$servidor_LDAP;
		  }
		  // Redirect signed in user with session redirect
		  if ($redirect = $this->CI->session->userdata('sign_in_redirect')) 
		  {
			$this->CI->session->unset_userdata('sign_in_redirect');
			redirect($redirect); 
		  }
		  // Redirect signed in user with GET continue
		  elseif ($this->CI->input->get('continue')) 
		  {
			redirect($this->CI->input->get('continue')); 
		  }
		
		  redirect('');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Sign user out
	 *
	 * @access public
	 * @return void
	 */
	function sign_out()
	{
		$this->CI->session->sess_destroy();
	}
	
}


/* End of file Authentication.php */
/* Location: ./application/modules/account/libraries/Authentication.php */