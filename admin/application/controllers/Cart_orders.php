<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cart_orders extends MY_Auth_Controller {

	protected $ci_name;//declare ci_name varriabe current controler name as image folder name to upload image

    public function __construct() 
    {
	    parent::__construct();
	    $this->ci_name = strtolower($this->router->fetch_class());
        $this->load->library('pdf');
	    $this->load->model('Cart_orders_model','model');
        if (!$this->is_logged_in()) //login only registered user from db
        { 
          redirect('Login');
        }
    }
  
    public function index() {

    	$this->load->view('order/list');

    }

    public function product_list() {

        $list = $this->model->get_datatables();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $order) {

        	if($order['status']=='1') {

        		$selected='<option value="1" selected>Delivered</option>
                           <option value="2" >Pending</option>
                           <option value="0" >Canceled</option>';
        	}
          
        	else if($order['status']=='2') {

        		$selected='<option value="1" >Delivered</option>
                           <option value="2" selected>Pending</option>
                           <option value="0" >Canceled</option>';
        	}

        	else if($order['status']=='0') {

        		$selected='<option value="1" >Delivered</option>
                           <option value="2" >Pending</option>
                           <option value="0" selected>Canceled</option>';
        	}

            else{

                $selected='';

            }

	        $no++;
	        $row = array();
	        $row[] = $no;
	        $row[] = '#'.$order['id'];
	        $row[] = $order['user_name'];
	        $row[] = $order['total_amt'];
	        $row[] = '<img src="'.CUSTOM_BASE_URL.'uploads/userprofile/'.$order['prof_image'].'" class="img-responsive" height=60 width=80 /></a>';
            $row[] = '
                    <select  name='.$order['id'].' onchange="getval(this);" id="mySelect">
                        '.$selected.'
                    </select>';
            // //add html for action
	        $row[] = '<a data-toggle="modal" data-id='.$order['id'].' data-target="#view-modal" class="btn  btn-info" href="#"><i class="fa fa-eye" aria-hidden="true"> More</i></a>

            <a href="'.CUSTOM_BASE_URL.'cart_orders/cart_order_print/'.$order['id'].'" class="btn  btn-info" href="#"> Download Bill</a>

	            <a data-toggle="modal" data-id='.$order['id'].' data-target="#delModal" class="btn  btn-danger" href="#"><i class="fa  fa-trash-o" aria-hidden="true"></i></a>';

           $data[] = $row;
        }

        $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->model->count_all(),
        "recordsFiltered" => $this->model->count_filtered(),
        "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    
    public function cancel_order() {

        $this->load->view('order/cancel-list');

    }

    public function cancel_order_list() {

        $status='cancel';

        $list = $this->model->get_datatables($status);
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $order) {

            if($order['status']=='1') {

                $selected='<option value="1" selected>Delivered</option>
                           <option value="2" >Pending</option>
                           <option value="0" >Canceled</option>';
            }
          
            else if($order['status']=='2') {

                $selected='<option value="1" >Delivered</option>
                           <option value="2" selected>Pending</option>
                           <option value="0" >Canceled</option>';
            }

            else if($order['status']=='0') {

                $selected='<option value="1" >Delivered</option>
                           <option value="2" >Pending</option>
                           <option value="0" selected>Canceled</option>';
            }

            else{

                $selected='';

            }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '#'.$order['id'];
            $row[] = $order['user_name'];
            $row[] = $order['total_amt'];
            $row[] = '<img src="'.CUSTOM_BASE_URL.'uploads/userprofile/'.$order['prof_image'].'" class="img-responsive" height=60 width=80 /></a>';
            $row[] = '
                    <select  name='.$order['id'].' onchange="getval(this);" id="mySelect">
                        '.$selected.'
                    </select>';
            // //add html for action
            $row[] = '<a data-toggle="modal" data-id='.$order['id'].' data-target="#view-modal" class="btn  btn-info" href="#"><i class="fa fa-eye" aria-hidden="true"> Products</i></a>

                <a data-toggle="modal" data-id='.$order['id'].' data-target="#delModal" class="btn  btn-danger" href="#"><i class="fa  fa-trash-o" aria-hidden="true"></i></a>';

           $data[] = $row;
        }

        $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->model->count_all(),
        "recordsFiltered" => $this->model->count_filtered(),
        "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function pending_orders() {

        $this->load->view('order/pending-list');

    }

    public function pending_orders_list() {

        $list = $this->model->get_datatables(2);
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $order) {

           if($order['status']=='1') {

                $selected='<option value="1" selected>Delivered</option>
                           <option value="2" >Pending</option>
                           <option value="0" >Canceled</option>';
            }
          
            else if($order['status']=='2') {

                $selected='<option value="1" >Delivered</option>
                           <option value="2" selected>Pending</option>
                           <option value="0" >Canceled</option>';
            }

            else if($order['status']=='0') {

                $selected='<option value="1" >Delivered</option>
                           <option value="2" >Pending</option>
                           <option value="0" selected>Canceled</option>';
            }

            else{

                $selected='';

            }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '#'.$order['id'];
            $row[] = $order['user_name'];
            $row[] = $order['total_amt'];
            $row[] = '<img src="'.CUSTOM_BASE_URL.'uploads/userprofile/'.$order['prof_image'].'" class="img-responsive" height=60 width=80 /></a>';
            $row[] = '
                    <select  name='.$order['id'].' onchange="getval(this);" id="mySelect">
                        '.$selected.'
                    </select>';
            // //add html for action
            $row[] = '<a data-toggle="modal" data-id='.$order['id'].' data-target="#view-modal" class="btn  btn-info" href="#"><i class="fa fa-eye" aria-hidden="true"> Products</i></a>

                <a data-toggle="modal" data-id='.$order['id'].' data-target="#delModal" class="btn  btn-danger" href="#"><i class="fa  fa-trash-o" aria-hidden="true"></i></a>';

           $data[] = $row;
        }

        $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->model->count_all(),
        "recordsFiltered" => $this->model->count_filtered(),
        "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function deliverd_orders() {

        $this->load->view('order/deliverd-list');

    }

    public function deliverd_orders_list() {

        $list = $this->model->get_datatables(1);
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $order) {

            if($order['status']=='1') {

                $selected='<option value="1" selected>Delivered</option>
                           <option value="2" >Pending</option>
                           <option value="0" >Canceled</option>';
            }
          
            else if($order['status']=='2') {

                $selected='<option value="1" >Delivered</option>
                           <option value="2" selected>Pending</option>
                           <option value="0" >Canceled</option>';
            }

            else if($order['status']=='0') {

                $selected='<option value="1" >Delivered</option>
                           <option value="2" >Pending</option>
                           <option value="0" selected>Canceled</option>';
            }

            else{

                $selected='';

            }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '#'.$order['id'];
            $row[] = $order['user_name'];
            $row[] = $order['total_amt'];
            $row[] = '<img src="'.CUSTOM_BASE_URL.'uploads/userprofile/'.$order['prof_image'].'" class="img-responsive" height=60 width=80 /></a>';
            $row[] = '
                    <select  name='.$order['id'].' onchange="getval(this);" id="mySelect">
                        '.$selected.'
                    </select>';
            // //add html for action
            $row[] = '<a data-toggle="modal" data-id='.$order['id'].' data-target="#view-modal" class="btn  btn-info" href="#"><i class="fa fa-eye" aria-hidden="true"> Products</i></a>

                <a data-toggle="modal" data-id='.$order['id'].' data-target="#delModal" class="btn  btn-danger" href="#"><i class="fa  fa-trash-o" aria-hidden="true"></i></a>';

           $data[] = $row;
        }

        $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->model->count_all(),
        "recordsFiltered" => $this->model->count_filtered(),
        "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function view() {

        $id = $this->input->post('rowid');
        $data['result'] = $this->model->viewOrderData($id);
        $this->load->view('order/view', $data);
    }

   

	public function delete(){

	    $this->load->view('order/delete');
	    if (isset($_POST['delete'])) 
	    {
		    $id=$_POST['rowid'];
			$this->model->delete($id);
	        redirect('Cart_orders');
	    }
	}

    public function setStatus() 
    {
        $status=$_POST['status'];

        $id=$_POST['rowid'];

        $result=$this->model->setOrderStatus($id,$status);

   }

    public function cart_order_print() {

        $this->load->library('pdf');
        
        $id = $this->uri->segment(3);
        $list = $this->model->CartOrderPrintData($id);

        $no;

        $output ='<style>
                th 
                {
                text-align: left; 
                vertical-align: middle;

                }

                td 
                {
                height: 30px; 
                text-align: left; 
                vertical-align: middle;
                }
                .center {
                  margin-left: 40%;
                  margin-right: 50%;
                }
            </style>

            <img src="'.CUSTOM_BASE_URL.'assets/dist/img/print_icon.png" class="center" height=100 width=100 />
            Ahlul Kaif Qatar Group | Contact us: +97431609156 | www.ahlulkaif.com | Email: it@ahlulkaif.com  <hr>

            <p>Delivey Date:</p>

            <table border="1" width="100%" class="table table-striped table-bordered table-hover" id="tree-table">
                <thead>
                    <tr>
                      <th>#Slno</th>
                      <th>Product</th>
                      <th>Qty</th>
                      <th>Price</th>
                      <th>Total</th>
                      
                      
                    </tr>
                </thead>';

                                     

                foreach ($list as $order) { 

                    foreach ($order['product'] as $orders) { 

                    $subtotal = $orders['qty']* $orders['list_price'];

                    $grandtotal += $subtotal;

                 $no++;

                    $output .=  '<tbody>        
                                   
                                    <tr>
                                    <td >'.$no.'</td>
                                    <td >'.$orders['stock_name'].'</td>
                                    <td >'.$orders['qty'].'</td>
                                    <td >'.$orders['list_price'].'</td>
                                    <td >'.$subtotal.'</td>
                                    </tr>
                                    
                                    
                             </tbody>';
                            } 

                    if($grandtotal>250)
                    {
                        $delivery=30;
                    }
                    else{
                        $delivery=0;
                    }

                    $amount_pay = $grandtotal+ $delivery;

                    $output .= '<tr><td colspan="2"> Grand Total</td><td colspan="3">'.$grandtotal.'</td></tr>';

                   $output .= '<tr><td colspan="2"> Delivery Charge</td><td colspan="3">'.$delivery.'</td></tr>';

                   $output .= '<tr><td colspan="2"> <b>Amount Payable</b> </td><td colspan="3"><b>'.$amount_pay.'</b></td></tr>';
                     
                   $output .= ' </table>'; 

                   $output .= '<p>Invoice No : #'.$order['id'].'</p>';
                   $output .= '<p>Invoice Date : '.date("D d , M Y", strtotime($order['date'])).'</p>';

                   $output .= '<p>Name : '.$order['name'].'</p>';

                   $output .= '<p>Phone : '.$order['phone'].'</p>';

                   $output .= '<p>Delivery Address : '.$order['land_mark'].'</p>';
                    
                $this->pdf->loadHtml($output);
                $this->pdf->set_paper("a4", "portrait" );
                $this->pdf->render();
                $this->pdf->stream("slip.pdf");
                $pdf = $this->pdf->output();
                $file_location = $_SERVER['DOCUMENT_ROOT'].'uploads/reports/sales_report/"slip.pdf" ';
                file_put_contents($file_location,$pdf);
   
        }
    
    } 


}
