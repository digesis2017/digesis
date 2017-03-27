<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter REST Class
 *
 * Make REST requests to RESTful services with simple syntax.
 *
 * @package         CodeIgniter
 * @subpackage      Libraries
 * @category        Libraries
 * @author          Philip Sturgeon
 * @author          Chris Kacerguis
 * @created         04/06/2009
 * @license         http://philsturgeon.co.uk/code/dbad-license
 * @link            http://getsparks.org/packages/restclient/show
 */
class Billetera
{

    protected $_ci;
    Const id_tipo=1;
            
    function __construct($config = array())
    {
        $this->_ci =& get_instance();                    
        $this->_ci->load->model('mcostosot');        
        $this->_ci->load->model('meficiencia');
        $this->_ci->load->model('msolicitudes');
        $this->_ci->load->model('mencuestas');
        $this->_ci->load->model('mtecnicos');
    }        
    /**
     * get
     *
     * @access  public
     * @author  Phil Sturgeon
     * @version 1.0
     */
    public function getresumen($params = array())
    {
     
        $monto=0;
        if ($params)
        {
            $datat = $this->_ci->mtecnicos->tecnicobyDNI($params['dni']);
            if ( is_object($datat) ) 
            {
                $tid = $datat->id;            
                $atendidos = $this->msolicitudes->solicitudes_encuestas($tid, 2, true);
                $rcosto=$this->_ci->mcostosot->getSotByType(self::id_tipo,$atendidos);
                $monto=$atendidos*$rcosto['monto'];

                //$data['atendidos'] 
            }
            return $monto;
        //return $this->_call('get', $uri, NULL, $format);
    }
    
}
}
