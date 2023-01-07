<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Report extends MY_Auth_Controller {

	protected $ci_name;//declare ci_name varriabe current controler name as image folder name to upload image

    public function __construct() 
    {
	    parent::__construct();
	    $this->ci_name = strtolower($this->router->fetch_class());
	    $this->load->model('Report_model','model');
	    $this->load->library('pdf');
	    $this->load->library('upload');
        if (!$this->is_logged_in()) //login only registered user from db
        { 
          redirect('Login');
        }
    }

//////////////////////////////////////////SALES////////////////////////////////////////////////////////
  
    public function sales_report_index() {

    	$this->load->view('report/sales_report');

    }

    public function sales_report() {

        $list = $this->model->get_datatables_sales();
        $data = array();
        $no;

        foreach ($list as $order) {


	        $no++;
	        $row = array();
	        $row[] = $no;
	        $row[] = $order['user_name'];
	        $row[] = $order['total_amt'];
	        $row[] = $order['date'];
	       

           $data[] = $row;
        }

        $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->model->count_sales(),
        "recordsFiltered" => $this->model->count_filtered_sales(),
        "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    
    
    
    
    public function sales_report_print(){
    
    $this->load->library('pdf');
    
    $list = $this->model->get_datatables_sales();
  
    $no;

        
    
    $output ='<style>
                th 
                {
                text-align: center; 
                vertical-align: middle;

                }

                td 
                {
                height: 50px; 
                text-align: center; 
                vertical-align: middle;
                }
            </style>
    
            <table border="1" width="100%" class="table table-striped table-bordered table-hover" id="tree-table">
                                    <thead>
                                        <tr>
                                          <th>#Serial</th>
                                          <th>User name</th>
                                          <th>MRP</th>
                                          <th>Date</th>
                                          
                                          
                                        </tr>
                                    </thead>';
                                    foreach ($list as $order) {               
                              $no++;
                    $output .=  '<tbody>        
                                	       
                                	        <tr>
                                	        <td >'.$no.'</td>
                                	        <td >'.$order['user_name'].'</td>
                                	        <td >'.$order['total_amt'].'</td>
                                	        <td >'.$order['date'].'</td>
                                            </tr>
                                	        
                                	        
                                	 </tbody>';
                                	} 
                     
                   $output .= ' </table>'; 
                    
                 
                $this->pdf->loadHtml($output);
                $this->pdf->set_paper("a4", "portrait" );
                $this->pdf->render();
                $this->pdf->stream("Report.pdf");
                $pdf = $this->pdf->output();
                $file_location = $_SERVER['DOCUMENT_ROOT'].'uploads/reports/sales_report/"Report.pdf" ';
                file_put_contents($file_location,$pdf);
   
 
    
}    
    
    
    
    
    
    
    
    
    
    
    
    
    
//***********************************************************************************//

//////////////////////////////////////////STOCK////////////////////////////////////////////////////////
    
    
    public function stock_report_index() {

    	$this->load->view('report/stock_report');

    }

    public function stock_report() {

        $list = $this->model->get_datatables_stock();
        $data = array();
        $no;

        foreach ($list as $order) {


	        $no++;
	        $row = array();
	        $row[] = $no;
	        $row[] = $order['product_name'];
	        $row[] = $order['stock_name'];
	        $row[] = $order['stock'];
	        $row[] = $order['price'];
	        $row[] = $order['list_price'];
	        $row[] = $order['discount'];
	       
           $data[] = $row;
        }

        $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->model->count_stock(),
        "recordsFiltered" => $this->model->count_filtered_stock(),
        "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }   
    
    
    
    public function stock_report_print(){
    
    $this->load->library('pdf');
    
    $list = $this->model->get_datatables_stock();
  
    $no;

        
    
    $output ='<style>
                th 
                {
                text-align: center; 
                vertical-align: middle;

                }

                td 
                {
                height: 50px; 
                text-align: center; 
                vertical-align: middle;
                }
            </style>
    
            <table border="1" width="100%" class="table table-striped table-bordered table-hover" id="tree-table">
                                    <thead>
                                        <tr>
                                          <th>#Serial</th>
                                          <th>Product name</th>
                                          <th>Stock Name</th>
                                          <th>Stock</th>
                                          <th>Price</th>
                                          <th>List Price</th>
                                          <th>Discount</th>
                                          
                                          
                                        </tr>
                                    </thead>';
                                    foreach ($list as $order) {               
                              $no++;
                    $output .=  '<tbody>
                                            <tr>
                                	        <td >'.$no.'</td>
                                	        <td >'.$order['product_name'].'</td>
                                	        <td >'.$order['stock_name'].'</td>
                                	        <td >'.$order['stock'].'</td>
                                	        <td >'.$order['price'].'</td>
                                	        <td >'.$order['list_price'].'</td>
                                	        <td >'.$order['discount'].'</td>
                                            </tr>
                                	        
                                	        
                                	 </tbody>';
                                	} 
                     
                   $output .= ' </table>'; 
                //   $file_location = CUSTOM_BASE_URL.'uploads/reports/stock_report/';
                //      print_r($file_location);exit;
                 
                $this->pdf->loadHtml($output);
                $this->pdf->set_paper("a4", "portrait" );
                $this->pdf->render();
                $this->pdf->stream("Report.pdf");
                $pdf = $this->pdf->output();
                $file_location = CUSTOM_BASE_URL.'uploads/reports/stock_report/';
                file_put_contents($file_location,$pdf);
   
 
    
}    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
//////////////////////////////////////////ORDER WISE////////////////////////////////////////////////////////
  


    public function order_wise_index() {
       
    
            
        $status = $this->input->post('status');
   
        $from = $this->input->post('from');
          
        $to = $this->input->post('to');  
            
        $data['list'] = $this->model->get_data_orderwise($status,$from,$to);
        
        $data['status'] = $status;
        $data['from'] = $from;
        $data['to'] = $to;
        
        $this->load->view('report/order_status_wise_report',$data);

    }
    
    
    
    
        
    public function order_wise_report_print(){
        
    
    $status = $this->input->post('status');
   

    $from = $this->input->post('from');
    
    
    $to = $this->input->post('to');      

    $this->load->library('pdf');
    
    $list = $this->model->get_data_orderwise($status,$from,$to);
  
    $no;

        
    
    $output ='<style>
                th 
                {
                text-align: center; 
                vertical-align: middle;

                }

                td 
                {
                height: 50px; 
                text-align: center; 
                vertical-align: middle;
                }
            </style>
    
            <table border="1" width="100%" class="table table-striped table-bordered table-hover" id="tree-table">
                                    <thead>
                                        <tr>
                                          <th>#Serial</th>
                                          <th>User name</th>
                                          <th>MRP</th>
                                          <th>Date</th>
                                          <th>Status</th>
                                          
                                          
                                        </tr>
                                    </thead>';
                                    foreach ($list as $order) {               
                              $no++;
                    $output .=  '<tbody>
                                            <tr>
                                	        <td >'.$no.'</td>
                                	        <td >'.$order->user_name.'</td>
                                	        <td >'.$order->total_amt.'</td>
                                	        <td >'.$order->date.'</td>';
                                	        if($order->status == 1)
                              $output .=  	'<td >Delivered</td>';
                                            if($order->status == 2)
                              $output .= 	'<td >Pending</td>';
                                	        if($order->status == 0)
                              $output .=  	'<td >Cancelled</td>
                                            </tr>
                                            

                                	        
                                	        
                                	 </tbody>';
                                	} 
                     
                   $output .= ' </table>'; 

             
                 
                $this->pdf->loadHtml($output);
                $this->pdf->set_paper("a4", "portrait" );
                $this->pdf->render();
                $this->pdf->stream("Report.pdf");
                $pdf = $this->pdf->output();
                $file_location = CUSTOM_BASE_URL.'uploads/reports/order_wise_report/';
                file_put_contents($file_location,$pdf);
   
 
    
}    


//***********************************************************************************//
    
    
     public function product_wise_index() {
       
    
            
        $category = $this->input->post('category');
        
        $data['category'] = $this->model->getCategory();
            
        $data['list'] = $this->model->get_data_categorywise($category);

        $data['cat'] = $category;
        
        $this->load->view('report/category_wise_product_report',$data);

    }   
    
    
         
    public function product_wise_report_print(){
        
    
    $category = $this->input->post('category');
   

    $this->load->library('pdf');
    
    $list = $this->model->get_data_categorywise($category);
  
    $no;

        
    
    $output ='<style>
                th 
                {
                text-align: center; 
                vertical-align: middle;

                }

                td 
                {
                height: 50px; 
                text-align: center; 
                vertical-align: middle;
                }
            </style>
    
            <table border="1" width="100%" class="table table-striped table-bordered table-hover" id="tree-table">
                                    <thead>
                                        <tr>
                                          <th>#Serial</th>
                                          <th>Product name</th>
                                          <th>Stock Name</th>
                                          <th>Stock</th>
                                          <th>Price</th>
                                          <th>List Price</th>
                                          <th>Discount</th>
                                          
                                          
                                        </tr>
                                    </thead>';
                                    foreach ($list as $order) {               
                              $no++;
                    $output .=  '<tbody>
                                            <tr>
                                	        <td >'.$no.'</td>
                  	                        <td>'.$order->product_name.'</td>
                                	        <td>'.$order->stock_name.'</td>
                                	        <td>'.$order->stock.'</td>
                                	        <td>'.$order->price.'</td>
                                	        <td>'.$order->list_price.'</td>
                                	        <td>'.$order->discount.'</td>
          
                                            </tr>

              
                                	        
                                	        
                                	 </tbody>';
                                	} 
                     
                   $output .= ' </table>'; 

             
                
                $this->pdf->loadHtml($output);
                $this->pdf->set_paper("a4", "portrait" );
                $this->pdf->render();
                $this->pdf->stream("Report.pdf");
                $pdf = $this->pdf->output();
                $file_location = CUSTOM_BASE_URL.'uploads/reports/order_wise_report/';
                file_put_contents($file_location,$pdf);
   
 
    
}    
    
    
    

    
    
    
    
    
    
    
}
