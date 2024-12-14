<?php
$startDate = isset($_REQUEST['start_date']) ? $_REQUEST['start_date'] : date('Y-m-d');
$endDate = isset($_REQUEST['end_date']) ? $_REQUEST['end_date'] : date('Y-m-d');
$params = array('end_date' => '2021-08-20', 'start_date' => '2021-07-19');
$default_configs = "MathJax = {\n  tex: {\n    inlineMath: [['$','$'],['\\\\(','\\\\)']], \n    processEscapes: true\n  },\n  options: {\n    ignoreHtmlClass: 'tex2jax_ignore|editor-rich-text'\n  }\n};\n";

?>
<div class="search-shipement">
    <h3>Smile Brilliant Dashboard <span class="dashicons dashicons-search"></span> </h3>
    <script type="application/javascript" src="//cdn.jsdelivr.net/npm/mathjax@3/es5/tex-chtml.js"></script>
    <?php echo "\n<script>\n{$default_configs}\n</script>\n"; ?>
    <form action="<?php echo admin_url('admin.php?page=sbr-reporting-report-functions.php') ?>" method="post"
          id="reporting-form">
        <div class="shipment-inner-container">
            <div class="flex-row">


                <div class="col-sm-3">
                    <div class="form-group">
                        <span style="display:none" id="formula_gross_margin">$${{Price - Discount - Cost}\over {Price - Discount}} x 100$$ </span>
                        <span style="display:none" id="formula_revenue">$$Price - Discount$$ </span>
                        <label>Order Type 
                            <select id="order_type" class="form-control" name="order_type">
                                <option value="">All</option>
                                <option value="local">US orders</option>
                                <option value="international">International orders</option>
                            </select>
                        </label>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Start Date

                            <input name="start_date" placeholder="Date On or After" type="date"
                                   id="labelGenerationAfter" value="<?php echo $startDate; ?>" class="form-control">
                        </label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>End Date
                            <input name="end_date" placeholder="Date On or Before" type="date"
                                   id="labelGenerationBefore" value="<?php echo $endDate; ?>" class="form-control">
                        </label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Shipping State 
                            <select id="shipping_state" class="form-control" name="shipping_state">
                                <option value="">All</option>
                                <option value="MO">Missouri</option>
                            </select>
                        </label>
                    </div>
                </div>
                <div class="buttons-custom-added wrap">
                    <a href="javascript:;" id="searchByFiltersReports" class="page-title-action">Search</a>
                </div>
            </div>

        </div>
    </form>

    <div class="reporting-contianer-mbt">
        <div class="flex-row-reporting">
            <div class="col-sm-4-report">
                <div class="report-inner">
                    <h4>Revenue all orders</h4>
                    <div class="report_response" id="all-orders-response">
                    </div>
                </div>
            </div>
            <div class="col-sm-4-report">
                <div class="report-inner">
                    <h4>Revenue from GEHA Customers</h4>
                    <div class="report_response" id="geha-orders-response">
                    </div>
                </div>
            </div>
            <div class="col-sm-4-report">
                <div class="report-inner">
                    <h4>Revenue from GEHA Customers Existing</h4>
                    <div class="report_response" id="geha-orders-response-existing">
                    </div>
                </div>
            </div>
            <div class="col-sm-4-report">
                <div class="report-inner">
                    <h4>Revenue from GEHA Customers New</h4>
                    <div class="report_response" id="geha-orders-response-new">
                    </div>
                </div>
            </div>
            <div class="col-sm-4-report">
                <div class="report-inner">
                    <h4>Revenue from Non GEHA customers</h4>
                    <div class="report_response" id="non-geha-response">

                    </div>
                </div>
            </div>
            <div class="col-sm-4-report">
                <div class="report-inner">
                    <h4>Revenue from existing customers</h4>
                    <div class="report_response" id="Revenue-from-existing-customers">

                    </div>
                </div>
            </div>
            <div class="col-sm-4-report">
                <div class="report-inner">
                    <h4>Revenue from new customers</h4>
                    <div class="report_response" id="Revenue-from-new-customers">

                    </div>
                </div>
            </div>
            <div class="col-sm-4-report">
                <div class="report-inner">
                    <h4>Revenue from add-on orders</h4>
                    <div class="report_response" id="rev-add-on-orders">

                    </div>
                </div>
            </div>
            <div class="col-sm-4-report qyt-hide ">
                <div class="report-inner">
                    <h4>Item quantity of add-on orders</h4>
                    <div class="report_response" id="qty-add-on-orders">

                    </div>
                </div>
            </div>
            <div class="col-sm-4-report qyt-hide">
                <div class="report-inner">
                    <h4 class="block-flex"><span class="heading-report">Total number of whitening trays shipped</span> <span class="qty-report">qty</span></h4>
                    <div class="report_response" id="whitening-trays-shipped">

                    </div>
                </div>
            </div>
            <div class="col-sm-4-report qyt-hide">
                <div class="report-inner">
                    <h4 class="block-flex"><span class="heading-report">Total number of night guards shipped</span><span class="qty-report">qty</span> </h4>
                    <div class="report_response" id="night-guards-shipped">

                    </div>
                </div>
            </div>
            <div class="col-sm-4-report qyt-hide">
                <div class="report-inner">
                    <h4 class="block-flex"><span class="heading-report">Upsell Items</span><span class="qty-report">Mini Cart | Checkout Pop | Total</span></h4>
                    <div class="report_response" id="upsell_items">

                    </div>
                </div>
            </div>
            <div class="col-sm-4-report  qyt-hide">
                <div class="report-inner">
                    <h4 class="block-flex"><span class="heading-report">Easypost</span><span class="qty-report"></span></h4>
                    <div class="report_response" id="easypost_report">

                    </div>
                </div>
            </div>
            <!-- half-screen-width -->
            <div class="col-sm-4-report  qyt-hide">
                <div class="report-inner">
                    <h4 class="block-flex"><span class="heading-report">Quantity of units sold for each item</span><span class="qty-report">qty</span>  </h4>
                    <div class="report_response" id="units-sold-for-each-item">

                    </div>
                </div>
            </div>
            <div class="col-sm-4-report qyt-hide">
                <div class="report-inner">
                    <h4 class="block-flex"><span class="heading-report">Quantity of raw inventory used</span><span class="qty-report">qty</span></h4>
                    <div class="report_response" id="raw-inventory-used">

                    </div>
                </div>
            </div>
            <div class="col-sm-4-report  qyt-hide">
                <div class="report-inner">
                    <h4 class="block-flex"><span class="heading-report">Impressions Good/Bad</span><span class="qty-report">qty</span></h4>
                    <div class="report_response" id="tray_impressions">

                    </div>
                </div>
            </div>

            <div class="col-sm-4-report half-screen-width qyt-hide">
                <div class="report-inner">
                    <h4 class="block-flex"><span class="heading-report">GEHA Experiments</span><span class="qty-report"></span></h4>
                    <div class="report_response" id="geha_experiments">

                    </div>
                </div>
            </div>

            <div class="col-sm-4-report half-screen-width qyt-hide">
                <div class="report-inner">
                    <h4 class="block-flex"><span class="heading-report">RM Inventory with Easypost</span><span class="qty-report"></span></h4>
                    <div class="report_response" id="rm_inventory">

                    </div>
                </div>
            </div>


        </div>


    </div>
</div>
<style>
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