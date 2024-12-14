/*
 * ajax requests
 */
jQuery(document).ready(function () {

    jQuery(document).on('click', '#searchByFiltersReports', function () {
        jQuery('.report_response').html(sb_js_loader());
        var formula_gross_margin = jQuery('#formula_gross_margin').html();
        var formula_revenue = jQuery('#formula_revenue').html();
        console.log(formula_revenue);
        data1 = jQuery('#reporting-form').serialize();
        jQuery('#labelGenerationBefore').removeClass('haserror');
        jQuery('#labelGenerationAfter').removeClass('haserror');
        labelGenerationAfter = jQuery('#labelGenerationAfter').val();
        labelGenerationBefore = jQuery('#labelGenerationBefore').val();
        if (labelGenerationAfter == '') {
            jQuery('#labelGenerationAfter').addClass('haserror');
            return false;
        }
        if (labelGenerationBefore == '') {
            jQuery('#labelGenerationBefore').addClass('haserror');
            return false;
        }

        //         data_actual = data1 + '&action=get_allreportsdata';
        //        jQuery.ajax({
        //            url: ajaxurl,
        //            data: data_actual,
        //            method: 'post',
        //            type: 'post',
        //            success: function (res) {
        //                response = jQuery.parseJSON(res);
        //                html_response = '<ul><li><b>Order Shipping: </b>' + response._order_shipping + '$</li><li><b>Discount: </b>' + response._cart_discount + '$</li><li><b>Total Number Of Orders: </b>' + response.total_orders + '</li><li><b>Revenue:<br/>' + formula_revenue + ' </b>' + response._order_revenue + '$</li><li><b>Revenue Today:<br/>' + formula_revenue + ' </b>' + response._order_revenue_today + '$</li><li><b>Revenue Weekly:<br/>' + formula_revenue + ' </b>' + response._order_revenue_weekly + '$</li><li><b>Revenue Monthly:<br/>' + formula_revenue + ' </b>' + response._order_revenue_monthally + '$</li><li><b>Gross Margin %:<br />' + formula_gross_margin + ' </b>' + response._gross_margin + '%</li><li><b>Order Total: </b>' + response._order_total + '$</li></ul>';
        //                jQuery('#all-orders-response').html(html_response);
        //               // total_number_of_orders_geha_rev_sbr_report(data1);
        //            }
        //        });
        // return false;
        data_actual = data1 + '&action=total_number_of_orders_rev_sbr_report';
        jQuery.ajax({
            url: ajaxurl,
            data: data_actual,
            method: 'post',
            type: 'post',
            success: function (res) {
                response = jQuery.parseJSON(res);
                //   html_response = '<ul><li><b>Order Shipping: </b>' + response._order_shipping + '$</li><li><b>Discount: </b>' + response._cart_discount + '$</li><li><b>Total Number Of Orders: </b>' + response.total_orders + '</li><li><b>Revenue:<br/>' + formula_revenue + ' </b>' + response._order_revenue + '$</li><li><b>Revenue Today:<br/>' + formula_revenue + ' </b>' + response._order_revenue_today + '$</li><li><b>Revenue Weekly:<br/>' + formula_revenue + ' </b>' + response._order_revenue_weekly + '$</li><li><b>Revenue Monthly:<br/>' + formula_revenue + ' </b>' + response._order_revenue_monthally + '$</li><li><b>Gross Margin %:<br />' + formula_gross_margin + ' </b>' + response._gross_margin + '%</li><li><b>Order Total: </b>' + response._order_total + '$</li> </ul>';
                html_response = '<ul><li><b>Order Shipping: </b>' + response._order_shipping + '$</li><li><b>Easypost Shipping: </b>' + response._easypostCost + '$</li><li><b>Easypost Shipments: </b>' + response._totalShipments + '</li><li><b>Discount: </b>' + response._cart_discount + '$</li><li><b>Refunds: </b>' + response._refunds + '$</li><li><b>Total Number Of Orders: </b>' + response.total_orders + '</li><li><b>Revenue:<br/>' + formula_revenue + ' </b>' + response._order_revenue + '$</li><li><b>Revenue Today:<br/>' + formula_revenue + ' </b>' + response._order_revenue_today + '$</li><li><b>Revenue Weekly:<br/>' + formula_revenue + ' </b>' + response._order_revenue_weekly + '$</li><li><b>Revenue Monthly:<br/>' + formula_revenue + ' </b>' + response._order_revenue_monthally + '$</li><li><b>Gross Margin %:<br />' + formula_gross_margin + ' </b>' + response._gross_margin + '%</li><li><b>Order Total: </b>' + response._order_total + '$</li><li><b>HSA/FSA Total Order: </b>' + response.hfa_hsa + '</li> </ul>';
                jQuery('#all-orders-response').html(html_response);
                total_number_of_orders_geha_rev_sbr_report(data1);
            }
        });
    });
    /*
     * Download Reports
     */
    jQuery(document).on('click', '#searchByFiltersReportsDownload', function () {

        jQuery('.report_response').html(sb_js_loader());
        var formula_gross_margin = jQuery('#formula_gross_margin').html();
        var formula_revenue = jQuery('#formula_revenue').html();
        console.log(formula_revenue);
        data1 = jQuery('#reporting-form').serialize();
        jQuery('#labelGenerationBefore').removeClass('haserror');
        jQuery('#labelGenerationAfter').removeClass('haserror');
        labelGenerationAfter = jQuery('#labelGenerationAfter').val();
        labelGenerationBefore = jQuery('#labelGenerationBefore').val();
        if (labelGenerationAfter == '') {
            jQuery('#labelGenerationAfter').addClass('haserror');
            return false;
        }
        if (labelGenerationBefore == '') {
            jQuery('#labelGenerationBefore').addClass('haserror');
            return false;
        }

        data_actual = data1 + '&action=get_allreportsdata';
        jQuery.ajax({
            url: ajaxurl,
            data: data_actual,
            method: 'post',
            type: 'post',
            success: function (res) {

                // html_response = '<ul><li><b>Order Shipping: </b>' + response._order_shipping + '$</li><li><b>Discount: </b>' + response._cart_discount + '$</li><li><b>Total Number Of Orders: </b>' + response.total_orders + '</li><li><b>Revenue:<br/>' + formula_revenue + ' </b>' + response._order_revenue + '$</li><li><b>Revenue Today:<br/>' + formula_revenue + ' </b>' + response._order_revenue_today + '$</li><li><b>Revenue Weekly:<br/>' + formula_revenue + ' </b>' + response._order_revenue_weekly + '$</li><li><b>Revenue Monthly:<br/>' + formula_revenue + ' </b>' + response._order_revenue_monthally + '$</li><li><b>Gross Margin %:<br />' + formula_gross_margin + ' </b>' + response._gross_margin + '%</li><li><b>Order Total: </b>' + response._order_total + '$</li></ul>';
                jQuery('#download-repor-res').html(res);
                // total_number_of_orders_geha_rev_sbr_report(data1);
            }
        });
        // return false;

    });

});
function total_upsell_mbt(data) {

    data_actual = data + '&action=total_upsell_mbt';
    jQuery.ajax({
        url: ajaxurl,
        data: data_actual,
        method: 'post',
        type: 'post',
        success: function (res) {
            jQuery('#upsell_items').html(res);
            easypost_report_mbt(data);
        }
    });
}
function total_number_of_orders_geha_rev_sbr_report(data) {
    var formula_gross_margin = jQuery('#formula_gross_margin').html();
    var formula_revenue = jQuery('#formula_revenue').html();
    data_actual = data + '&action=total_number_of_orders_geha_rev_sbr_report';
    jQuery.ajax({
        url: ajaxurl,
        data: data_actual,
        method: 'post',
        type: 'post',
        success: function (res) {
            response = jQuery.parseJSON(res);
            //html_response = '<ul><li><b>Order Shipping: </b>' + response._order_shipping + '$</li><li><b>Discount: </b>' + response._cart_discount + '$</li><li><b>Total Number Of Orders: </b>' + response.total_orders + '</li><li><b>Revenue:<br/>' + formula_revenue + ' </b>' + response._order_revenue + '$</li><li><b>Gross Margin %:<br />' + formula_gross_margin + ' </b>' + response._gross_margin + '%</li><li><b>Order Total: </b>' + response._order_total + '$</li> <li><b>Geha Coupons Generated: </b>' + response.total_geha_coupons_geerated + '</li> <li><b>Geha Coupons Used: </b>' + response.total_geha_coupons_used + '</li></ul>';
            html_response = '<ul><li><b>Order Shipping: </b>' + response._order_shipping + '$</li><li><b>Easypost Shipping: </b>' + response._easypostCost + '$</li><li><b>Easypost Shipments: </b>' + response._totalShipments + '</li><li><b>Discount: </b>' + response._cart_discount + '$</li><li><b>Total Number Of Orders: </b>' + response.total_orders + '</li><li><b>Revenue:<br/>' + formula_revenue + ' </b>' + response._order_revenue + '$</li><li><b>Gross Margin %:<br />' + formula_gross_margin + ' </b>' + response._gross_margin + '%</li><li><b>Order Total: </b>' + response._order_total + '$</li> <li><b>Geha Coupons Generated: </b>' + response.total_geha_coupons_geerated + '</li> <li><b>Geha Coupons Used: </b>' + response.total_geha_coupons_used + '</li><li><b>HFA HSA Total Order: </b>' + response.hfa_hsa + '</li> </ul>';
            
            jQuery('#geha-orders-response').html(html_response);
            total_number_of_orders_geha_exsiting_rev_sbr_report(data);
            geha_experiments_mbt(data);

        }
    });
}
function total_number_of_orders_geha_exsiting_rev_sbr_report(data) {
    var formula_gross_margin = jQuery('#formula_gross_margin').html();
    var formula_revenue = jQuery('#formula_revenue').html();
    data_actual = data + '&action=total_number_of_orders_geha_exsiting_rev_sbr_report';
    jQuery.ajax({
        url: ajaxurl,
        data: data_actual,
        method: 'post',
        type: 'post',
        success: function (res) {
            response = jQuery.parseJSON(res);
            html_response = '<ul><li><b>Order Shipping: </b>' + response._order_shipping + '$</li><li><b>Easypost Shipping: </b>' + response._easypostCost + '$</li><li><b>Easypost Shipments: </b>' + response._totalShipments + '</li><li><b>Discount: </b>' + response._cart_discount + '$</li><li><b>Total Number Of Orders: </b>' + response.total_orders + '</li><li><b>Revenue:<br/>' + formula_revenue + ' </b>' + response._order_revenue + '$</li><li><b>Gross Margin %:<br />' + formula_gross_margin + ' </b>' + response._gross_margin + '%</li><li><b>Order Total: </b>' + response._order_total + '$</li></ul>';
            jQuery('#geha-orders-response-existing').html(html_response);
            total_number_of_orders_geha_new_rev_sbr_report(data);

        }
    });
}
function total_number_of_orders_geha_new_rev_sbr_report(data) {
    var formula_gross_margin = jQuery('#formula_gross_margin').html();
    var formula_revenue = jQuery('#formula_revenue').html();
    data_actual = data + '&action=total_number_of_orders_geha_new_rev_sbr_report';
    jQuery.ajax({
        url: ajaxurl,
        data: data_actual,
        method: 'post',
        type: 'post',
        success: function (res) {
            response = jQuery.parseJSON(res);
            html_response = '<ul><li><b>Order Shipping: </b>' + response._order_shipping + '$</li><li><b>Easypost Shipping: </b>' + response._easypostCost + '$</li><li><b>Easypost Shipments: </b>' + response._totalShipments + '</li><li><b>Discount: </b>' + response._cart_discount + '$</li><li><b>Total Number Of Orders: </b>' + response.total_orders + '</li><li><b>Revenue:<br/>' + formula_revenue + ' </b>' + response._order_revenue + '$</li><li><b>Gross Margin %:<br />' + formula_gross_margin + ' </b>' + response._gross_margin + '%</li><li><b>Order Total: </b>' + response._order_total + '$</li></ul>';
            jQuery('#geha-orders-response-new').html(html_response);
            total_number_of_orders_non_geha_rev_sbr_report(data);
        }
    });
}
function total_number_of_orders_non_geha_rev_sbr_report(data) {
    var formula_gross_margin = jQuery('#formula_gross_margin').html();
    var formula_revenue = jQuery('#formula_revenue').html();
    data_actual = data + '&action=total_number_of_orders_non_geha_rev_sbr_report';
    jQuery.ajax({
        url: ajaxurl,
        data: data_actual,
        method: 'post',
        type: 'post',
        success: function (res) {
            response = jQuery.parseJSON(res);
            html_response = '<ul><li><b>Order Shipping: </b>' + response._order_shipping + '$</li><li><b>Easypost Shipping: </b>' + response._easypostCost + '$</li><li><b>Easypost Shipments: </b>' + response._totalShipments + '</li><li><b>Discount: </b>' + response._cart_discount + '$</li><li><b>Total Number Of Orders: </b>' + response.total_orders + '</li><li><b>Revenue:<br/>' + formula_revenue + ' </b>' + response._order_revenue + '$</li><li><b>Gross Margin %:<br />' + formula_gross_margin + ' </b>' + response._gross_margin + '%</li><li><b>Order Total: </b>' + response._order_total + '$</li><li><b>HFA HSA Total Order: </b>' + response.hfa_hsa + '</li> </ul>';
            jQuery('#non-geha-response').html(html_response);
            rev_from_existing_customers_sbr_report(data);

        }
    });
}
function rev_from_existing_customers_sbr_report(data) {
    var formula_gross_margin = jQuery('#formula_gross_margin').html();
    var formula_revenue = jQuery('#formula_revenue').html();
    data_actual = data + '&action=total_number_of_orders_existing_customers_rev_sbr_report';
    jQuery.ajax({
        url: ajaxurl,
        data: data_actual,
        method: 'post',
        type: 'post',
        success: function (res) {
            response = jQuery.parseJSON(res);
            html_response = '<ul><li><b>Order Shipping: </b>' + response._order_shipping + '$</li><li><b>Discount: </b>' + response._cart_discount + '$</li><li><b>Total Number Of Orders: </b>' + response.total_orders + '</li><li><b>Revenue:<br/>' + formula_revenue + ' </b>' + response._order_revenue + '$</li><li><b>Gross Margin %:<br />' + formula_gross_margin + ' </b>' + response._gross_margin + '%</li><li><b>Order Total: </b>' + response._order_total + '$</li></ul>';
            jQuery('#Revenue-from-existing-customers').html(html_response);
            total_number_of_orders_new_customers_rev_sbr_report(data);

        }
    });
}
function total_number_of_orders_new_customers_rev_sbr_report(data) {
    var formula_gross_margin = jQuery('#formula_gross_margin').html();
    var formula_revenue = jQuery('#formula_revenue').html();
    data_actual = data + '&action=total_number_of_orders_new_customers_rev_sbr_report';
    jQuery.ajax({
        url: ajaxurl,
        data: data_actual,
        method: 'post',
        type: 'post',
        success: function (res) {
            response = jQuery.parseJSON(res);

            html_response = '<ul><li><b>Order Shipping: </b>' + response._order_shipping + '$</li><li><b>Discount: </b>' + response._cart_discount + '$</li><li><b>Total Number Of Orders: </b>' + response.total_orders + '</li><li><b>Revenue:<br/>' + formula_revenue + ' </b>' + response._order_revenue + '$</li><li><b>Gross Margin %:<br />' + formula_gross_margin + ' </b>' + response._gross_margin + '%</li><li><b>Order Total: </b>' + response._order_total + '$</li></ul>';
            //   jQuery('#all-orders-response').html(html_response);
            jQuery('#Revenue-from-new-customers').html(html_response);
            total_item_night_guard_shipped_sbr_report(data);

        }
    });
}

function addon_rev_sbr_report(data) {
    var formula_gross_margin = jQuery('#formula_gross_margin').html();
    var formula_revenue = jQuery('#formula_revenue').html();
    data_actual = data + '&action=addon_rev_sbr_report';
    jQuery.ajax({
        url: ajaxurl,
        data: data_actual,
        method: 'post',
        type: 'post',
        success: function (res) {
            response = jQuery.parseJSON(res);
            html_response = '<ul><li><b>Order Shipping: </b>' + response._order_shipping + '$</li><li><b>Discount: </b>' + response._cart_discount + '$</li><li><b>Total Number Of Orders: </b>' + response.total_orders + '</li><li><b>Revenue:<br/>' + formula_revenue + ' </b>' + response._order_revenue + '$</li><li><b>Gross Margin %:<br />' + formula_gross_margin + ' </b>' + response._gross_margin + '%</li><li><b>Order Total: </b>' + response._order_total + '$</li></ul>';
            jQuery('#rev-add-on-orders').html(html_response);
            total_tray_info_mbt(data);

        }
    });
}
function total_item_whitening_tray_shipped_sbr_report(data) {
    var formula_gross_margin = jQuery('#formula_gross_margin').html();
    var formula_revenue = jQuery('#formula_revenue').html();
    data_actual = data + '&action=total_item_whitening_tray_shipped_sbr_report';
    jQuery.ajax({
        url: ajaxurl,
        data: data_actual,
        method: 'post',
        type: 'post',
        success: function (res) {
            response = jQuery.parseJSON(res);
            jQuery('#whitening-trays-shipped').html(response.whitening);
            total_item_night_guard_shipped_sbr_report(data);

        }
    });
}

function total_item_night_guard_shipped_sbr_report(data) {
    var formula_gross_margin = jQuery('#formula_gross_margin').html();
    var formula_revenue = jQuery('#formula_revenue').html();
    data_actual = data + '&action=total_item_night_guard_shipped_sbr_report';
    jQuery.ajax({
        url: ajaxurl,
        data: data_actual,
        method: 'post',
        //type: 'JSON',
        success: function (res) {
            response = jQuery.parseJSON(res);
            console.log(response)
            jQuery('#qty-add-on-orders').html(response.addon);

        //    jQuery('#whitening-trays-shipped').html(response.whitening);
        //    jQuery('#night-guards-shipped').html(response.nightGuard);
            jQuery('#units-sold-for-each-item').html(response.products);
            jQuery('#raw-inventory-used').html(response.raw);
            addon_rev_sbr_report(data);

        }
    });
}
function total_qty_sold_sbr_report(data) {
    var formula_gross_margin = jQuery('#formula_gross_margin').html();
    var formula_revenue = jQuery('#formula_revenue').html();
    data_actual = data + '&action=total_qty_sold_sbr_report';
    jQuery.ajax({
        url: ajaxurl,
        data: data_actual,
        method: 'post',
        type: 'post',
        success: function (res) {

            jQuery('#units-sold-for-each-item').html(res);
            total_qty_sold_raw_sbr_report(data);

        }
    });
}
function total_qty_sold_raw_sbr_report(data) {
    var formula_gross_margin = jQuery('#formula_gross_margin').html();
    var formula_revenue = jQuery('#formula_revenue').html();
    data_actual = data + '&action=total_qty_sold_raw_sbr_report';
    jQuery.ajax({
        url: ajaxurl,
        data: data_actual,
        method: 'post',
        type: 'post',
        success: function (res) {
            jQuery('#raw-inventory-used').html(res);
        }
    });
}
function total_tray_info_mbt(data) {

    data_actual = data + '&action=total_tray_info_mbt';
    jQuery.ajax({
        url: ajaxurl,
        data: data_actual,
        method: 'post',
        type: 'post',
        success: function (res) {
            jQuery('#tray_impressions').html(res);
            total_upsell_mbt(data);
        }
    });
}
function easypost_report_mbt(data) {
   
    data_actual = data + '&action=easypost_report_mbt';
    jQuery.ajax({
        url: ajaxurl,
        data: data_actual,
        method: 'post',
        type: 'post',
        success: function (res) {
            jQuery('#easypost_report').html(res);
            rm_product_easypost_report_mbt(data);
        }
    });
}
function rm_product_easypost_report_mbt(data) {
   
    data_actual = data + '&action=rm_product_easypost_report_mbt';
    jQuery.ajax({
        url: ajaxurl,
        data: data_actual,
        method: 'post',
        type: 'post',
    //    type: 'JSON',
        success: function (res) {
            response = jQuery.parseJSON(res);
            console.log(response)
            jQuery('#rm_inventory').html(response.raw);
            jQuery('#whitening-trays-shipped').html(response.whitening);
            jQuery('#night-guards-shipped').html(response.nightGuard);

        }
    });
}
function geha_experiments_mbt(data) {
    data_actual = data + "&action=geha_experiments_mbt";
    jQuery.ajax({
      url: ajaxurl,
      data: data_actual,
      method: "post",
      type: "post",
      success: function (res) {
        jQuery("#geha_experiments").html(res);
      },
    });
  }
jQuery(document).ready(function () {
    jQuery('#searchByFiltersReports').click();
})
function exportTableToExcel(tableID, filename = '') {
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
  //  var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    var tableHTML = encodeURIComponent(tableSelect.outerHTML);
    // Specify file name
    filename = filename ? filename + '.xls' : 'excel_data.xls';

    // Create download link element
    downloadLink = document.createElement("a");

    document.body.appendChild(downloadLink);

    if (navigator.msSaveOrOpenBlob) {
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob(blob, filename);
    } else {
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

        // Setting the file name
        downloadLink.download = filename;

        //triggering the function
        downloadLink.click();
    }
}