<?php
/*
Template Name: sales per hour
*/

//require_one _DIR_ . '/public/wp-content/plugins/smile-brilliant/inc/twillio.php';
if(isset($_REQUEST['sbr_key']) && $_REQUEST['sbr_key']=='SBR_MBT_99@321'){

  $order_end_date_time = date('Y-m-d H:i:s',current_time( 'timestamp', 0 ));
  
   $exclude_Array = array('01','02','03','04','05','06','07');
   if(in_array(date('H',current_time( 'timestamp', 0 )),$exclude_Array)) {
   $message_to =' not in time range';
    $to = 'kamran@mindblazetech.com,abidoon@mindblazetech.com';
    $subject = 'SBR Sale per hour';
    $body = $message_to;
    $headers = array('Content-Type: text/html; charset=UTF-8');
  //  wp_mail( $to, $subject, $body, $headers );
    // send_twilio_text_sms('+923214401191','not in time range');
    // send_twilio_text_sms('+923328030748','not in time range');
    // die();
    die();
}
   //$order_end_date_time = '2022-04-14 05:49:55';
   $order_start_date_time = date('Y-m-d H:i:s',strtotime("-1 hours",strtotime($order_end_date_time)));
   $order_end_date_time_last_week = date('Y-m-d H:i:s',strtotime("-7 days",strtotime($order_end_date_time)));
   $order_start_date_time_last_week = date('Y-m-d H:i:s',strtotime("-1 hours",strtotime($order_end_date_time_last_week)));
   $end_hours =  date('H:i', strtotime($order_end_date_time));
   $start_hours =  date('H:i', strtotime($order_start_date_time));
   $end_hours_week =  date('H:i', strtotime($order_end_date_time_last_week));
   $start_hours_week =  date('H:i', strtotime($order_start_date_time_last_week));
   $start_day =  date('F j y', strtotime($order_start_date_time));
   $start_day_week =  date('F j y', strtotime($order_start_date_time_last_week));

    $sql_hourly = "select P.ID from wp_posts as P where P.post_type='shop_order'  AND P.post_status IN ('wc-completed' , 'wc-partial_ship' , 'wc-shipped' , 'wc-on-hold' , 'wc-processing')";
    $sql_hourly .= ' AND P.post_date BETWEEN "' . $order_start_date_time . '" AND "' . $order_end_date_time . '"';
    $results_hourly = $wpdb->get_results($sql_hourly, 'ARRAY_A');

    $sql_hourly_last_week = "select P.ID from wp_posts as P where P.post_type='shop_order'  AND P.post_status IN ('wc-completed' , 'wc-partial_ship' , 'wc-shipped' , 'wc-on-hold' , 'wc-processing')";
    $sql_hourly_last_week .= ' AND P.post_date BETWEEN "' . $order_start_date_time_last_week . '" AND "' . $order_end_date_time_last_week . '"';
    $results_hourly_lst_week = $wpdb->get_results($sql_hourly_last_week, 'ARRAY_A');
   
    $geha_order_last_week_count = 0;
    if(count($results_hourly_lst_week) > 0) {
        
        foreach($results_hourly_lst_week as $res) {
            $geha_order_last_week = get_post_meta($res['ID'], 'gehaOrder', true);
            if ($geha_order_last_week == 'yes') {
                $geha_order_last_week_count ++;
            }
        }
    }
    $difference = count($results_hourly_lst_week) - count($results_hourly);
    if($difference > 1) {
        if(count($results_hourly) == 0) {
            //$message_to = 'Not a single order on website in last hour ('.$order_end_date_time.')'; 
            $message_to = "No order received between ".$start_hours." to ".$end_hours." on ".$start_day.". Last week on the same day & time we got ".count($results_hourly_lst_week)." order(s).  ";
            send_twilio_text_sms('+923214401191',$message_to);
            send_twilio_text_sms('+923328030748',$message_to);
            send_twilio_text_sms('+16363465155',$message_to);
            $to = 'kamran@mindblazetech.com,abidoon@mindblazetech.com,amir.shah@smilebrilliant.com,mike@smilebrilliant.com';
            $subject = 'SBR Sale per hour';
            $body = $message_to;
            $headers = array('Content-Type: text/html; charset=UTF-8');
            wp_mail( $to, $subject, $body, $headers );
            //echo $message_to;
        }
        else{
            $message_to = 'Every thing is fine . Total Numbers of order:'.count($results_hourly).'('.$order_end_date_time.')'; 
            $to = 'kamran@mindblazetech.com,abidoon@mindblazetech.com,amir.shah@smilebrilliant.com';
            $subject = 'SBR Sale per hour';
            $body = $message_to;
            $headers = array('Content-Type: text/html; charset=UTF-8');
          //  wp_mail( $to, $subject, $body, $headers );
    
        }
    }
  
    $geha_order_count = 0;
    if(count($results_hourly) > 0) {
        
        foreach($results_hourly as $res) {
          
           $geha_order = get_post_meta($res['ID'], 'gehaOrder', true);
            if ($geha_order == 'yes') {
                $geha_order_count++;
            }
        }
    }
    $difference = $geha_order_last_week_count - $geha_order_count;
    if($difference>1) { 
    if($geha_order_count == 0 ) {

       // $message_to = 'Not a single Geha order on website in last hour ('.$order_end_date_time.')';
        $message_to = "No GEHA order received between ".$start_hours." to ".$end_hours." on ".$start_day.". Last week on the same day&time we got ".$geha_order_last_week_count." order(s).  ";
        send_twilio_text_sms('+923214401191',$message_to);
        send_twilio_text_sms('+923328030748',$message_to);
        send_twilio_text_sms('+16363465155',$message_to);

      
        $to = 'kamran@mindblazetech.com,abidoon@mindblazetech.com,amir.shah@smilebrilliant.com,mike@smilebrilliant.com';
        $subject = 'SBR Sale per hour';
        $body = $message_to;
        $headers = array('Content-Type: text/html; charset=UTF-8');
        wp_mail( $to, $subject, $body, $headers );
        //echo $message_to;
    }
   else{
        $message_to = 'Every thing is fine . Total Numbers of Geha order:'.$geha_order_count.'('.$order_end_date_time.')'; 
        $to = 'kamran@mindblazetech.com,abidoon@mindblazetech.com,amir.shah@smilebrilliant.com';
        $subject = 'SBR Sale per hour';
        $body = $message_to;
        $headers = array('Content-Type: text/html; charset=UTF-8');
      //  wp_mail( $to, $subject, $body, $headers );
   }
}
    $total_hourly = count($results_hourly);
    $added_30_percent = ($total_hourly*30)/100;
    $added_30_percent = round( $added_30_percent );
    $after_adding_30_percent = $total_hourly+ $added_30_percent;
   
    
    if(count($results_hourly_lst_week) > $after_adding_30_percent && $total_hourly>0) {
        $difference = count($results_hourly_lst_week) - $after_adding_30_percent;
            if($difference>1) { 
            //$message_to = 'lower number of orders in one hour then last week ('.$order_end_date_time.')';
            $percent = ($total_hourly/count($results_hourly_lst_week))*100;
            $percent = 100-$percent;
            $percent = round( $percent);
            $message_to = "Total no. of orders between ".$start_hours." to ".$end_hours." on ".$start_day." dropped from ".count($results_hourly_lst_week)." to ".$total_hourly." compared to last week on the same day. This is a ".$percent ."% drop. ";
            send_twilio_text_sms('+923214401191',$message_to);
            send_twilio_text_sms('+923328030748',$message_to);
            send_twilio_text_sms('+16363465155',$message_to);
            $to = 'kamran@mindblazetech.com,abidoon@mindblazetech.com,amir.shah@smilebrilliant.com,mike@smilebrilliant.com';
            $subject = 'SBR Sale per hour';
            $body = $message_to;
            $headers = array('Content-Type: text/html; charset=UTF-8');
            wp_mail( $to, $subject, $body, $headers );
            //echo $message_to; 
        }
    }
   
    $added_30_percent_geha = ($geha_order_count*30)/100;
    $added_30_percent_geha = round( $added_30_percent_geha );
    $after_adding_30_percent_geha = $geha_order_count+ $added_30_percent_geha;
    if($geha_order_last_week_count > $after_adding_30_percent_geha && $geha_order_count>0) {
        $difference = $geha_order_last_week_count - $after_adding_30_percent_geha;
        if($difference > 1) {
            // $message_to = 'lower number of Geha orders in one hour then last week ('.$order_end_date_time.')';
        $percent = ($geha_order_count/$geha_order_last_week_count)*100;
        $percent = 100-$percent;
        $percent = round( $percent);
        $message_to = "Total no. of geha orders between ".$start_hours." to ".$end_hours." on ".$start_day." dropped from ".$geha_order_last_week_count." to ".$geha_order_count." compared to last week on same day. This is a ".$percent ."% drop. ";
        send_twilio_text_sms('+923214401191', $message_to);
        send_twilio_text_sms('+923328030748', $message_to);
        send_twilio_text_sms('+16363465155',$message_to);
        $to = 'kamran@mindblazetech.com,abidoon@mindblazetech.com,amir.shah@smilebrilliant.com,mike@smilebrilliant.com';
        $subject = 'SBR Sale per hour';
        $body = $message_to;
        $headers = array('Content-Type: text/html; charset=UTF-8');
        wp_mail( $to, $subject, $body, $headers );
      //  echo $message_to;
        }
       
    }
}

