<?php
$startDate = isset($_REQUEST['start_date']) ? $_REQUEST['start_date'] : date('Y-m-d');
$endDate = isset($_REQUEST['end_date']) ? $_REQUEST['end_date'] : date('Y-m-d');
$order_type = isset($_REQUEST['order_type']) ? $_REQUEST['order_type'] : '';
$params = array('end_date' => '2021-08-20', 'start_date' => '2021-07-19');
global $pconfiguration;

 $new_array = $pconfiguration['pterms'];
 array_push($new_array, "raw", "packaging", "landing-page","data-only");
$args = array(
            'posts_per_page' => -1,
            'post_type' => 'product',
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'operator' => 'NOT IN',
                    'terms' => $new_array,
                )
            )
        );
       
        $posts_array = get_posts(
                $args
        );
$selected_html = "<select name='product_id' class='packaging-product select21 ".$class_existing."'>";
            if (count($posts_array) > 0) {
                foreach ($posts_array as $PR) {
                    $term_list = wp_get_post_terms($PR->ID, 'type', array('fields' => 'names'));
                    $term_name = isset($term_list[0]) ? $term_list[0] : '';
                    $obj = wc_get_product($PR->ID);
                    $sku = $obj->get_sku();
                    $skuString = '';
                    if ($sku != '') {
                        $skuString = ' (' . $sku . ')';
                    }
                    if(130266 == $PR->ID){
                        $sel = 'selected';
                    }
                    else{
                        $sel = '';
                    }
                    
                    $selected_html .= '<option value="' . $PR->ID . '" '.$sel.'> ' . $PR->post_title . $skuString . ' ' . $term_name . '</option>';
                }
            }
           $selected_html .= "</select>";
?>
<div class="search-shipement sbr-reporting-report-functions-php">
    <h3>Smile Brilliant Dashboard <span class="dashicons dashicons-search"></span> </h3>
    
    <form action="<?php echo admin_url('admin.php?page=sbr-reporting-report-functions.php') ?>" method="post"
          id="reporting-form">
        <div class="shipment-inner-container">
            <div class="flex-row">


                <div class="col-sm-4">
                    <div class="form-group">
                        <span style="display:none" id="formula_gross_margin">$${{Price - Discount - Cost}\over {Price - Discount}} x 100$$ </span>
                        <span style="display:none" id="formula_revenue">$$Price - Discount$$ </span>
                        <label>Order Type 
                            <select id="order_type" class="form-control" name="order_type">
                                <option value="">All</option>
                                <option value="local" <?php if($order_type=='local'){ echo 'selected'; }?>>US orders</option>
                                <option value="international" <?php if($order_type=='international'){ echo 'selected'; }?>>International orders</option>
                            </select>
                        </label>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Start Date

                            <input name="start_date" placeholder="Date On or After" type="date"
                                   id="labelGenerationAfter" value="<?php echo $startDate; ?>" class="form-control">
                        </label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>End Date
                            <input name="end_date" placeholder="Date On or Before" type="date"
                                   id="labelGenerationBefore" value="<?php echo $endDate; ?>" class="form-control">
                        </label>
                    </div>
                </div>
             
               
                   <div class="col-sm-4">
                    <div class="form-group">
                        <span style="display:none" id="formula_gross_margin">$${{Price - Discount - Cost}\over {Price - Discount}} x 100$$ </span>
                        <span style="display:none" id="formula_revenue">$$Price - Discount$$ </span>
                        <label>Product 
                               <?php echo $selected_html;?>
                        </label>
                    </div>
                </div>
<div class="col-sm-4">

                
                    <a href="javascript:;" class="button btn" id="searchByFiltersReportsDownload" class="page-title-action">Search</a>
               
</div>
            </div>

        </div>
    </form>

    <div class="reporting-contianer-mbt">
      
           
        <div class="report_response table-reporting" id="download-repor-res">


        </div>

    
    </div>
</div>
<style>
    
    .table-reporting td, .table-reporting th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

.table-reporting tr:nth-child(even) {
  background-color: #dddddd;
}
    .flex-row {

        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        background-color: #f0f0f0;
        box-shadow: inset -1px -1px 0 #e0e0e0;
        width: 100%;
        -webkit-box-align: center !important;
        -ms-flex-align: center !important;
        align-items: center !important;
        margin-right: 0px;
        margin-top: 45px;
        margin-left: 0px;
    }

    .flex-child {
        -ms-flex-preferred-size: 0;
        flex-basis: 0;
        -webkit-box-flex: 1;
        -ms-flex-positive: 1;
        flex-grow: 1;
        max-width: 100%;
        border-top: 1px solid #e0e0e0;
        border-right: 1px solid #e0e0e0;
        background: #fff;
        padding: 10px 15px;
        border-bottom: 1px solid #e0e0e0;
    }

    .flex-row .flex-child:first-child {
        border-left: 1px solid #e0e0e0;
    }

    .flex-child h4 {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
        font-weight: 600;
        font-size: 18px;
        line-height: 15px;
    }

    #example {
        border-collapse: collapse;
        width: 98%;
        margin-top: 30px;
        border: 1px solid #ccc;
    }

    #example tr th,
    #example tr td {
        padding: 10px 10px;
        background-color: #fff;

        white-space: nowrap;
        text-align: left;
        border-left: 1px solid #ccc;
    }

    #example tr td {
        font-weight: normal;
        border-bottom: 1px solid #ccc;
    }

    #example tr th {
        border-bottom: 1px solid #ccc;
        border-left: 1px solid #ccc;
    }

    #example thead tr th {
        border-bottom: 1px solid #ccc;
        border-left: 1px solid #ccc;
        padding: 10px 10px;
        background: #f2f2f2;
        border-bottom: 1px solid #ccc;
        font-weight: bold;
        text-align: center;
        font-size: 12px;
        text-transform: uppercase;
    }

    .diplaytickets-mbt tr td {
        font-size: 14px;
    }

    .diplaytickets-mbt .flex-mbt-container .flex-mbt>div {
        display: flex;
        justify-content: space-between;
        padding-bottom: 4px;
        border-bottom: 1px solid #cccccc96;
        margin-bottom: 4px;
        margin-left: -10px;
        margin-right: -10px;
        padding-left: 10px;
        padding-right: 10px;
        font-weight: bold;
    }

    .flex-mbt-container .flex-mbt>div:last-child {
        border-bottom: 0px;
        padding-bottom: 0;
        margin-bottom: 0;
    }

    .flex-mbt-container .flex-mbt>div p {
        margin: 0;
        font-weight: normal;
        font-size: 14px;
    }

    a.action-icon-inbox {
        display: flex;
        justify-content: center;
        align-items: center;
        color: #000;
        text-decoration: none;
    }

    #example.diplaytickets-mbt tr td,
    #example.diplaytickets-mbt tfoot th {
        text-align: center;
    }
</style>