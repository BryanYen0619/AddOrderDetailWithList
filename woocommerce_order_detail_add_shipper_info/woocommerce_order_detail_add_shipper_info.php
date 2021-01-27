<?php
/*
	Plugin Name: Woocommerce Order Detail Add Shipper Info
	Plugin URI: http://www.livebricks.com
	Description: Plugin for Woocommerce Add Shipper Info with Order Detail View
	Author: Bryan Yen
	Version: 1.0
	Author URI: http://www.livebricks.com
*/

add_action( 'woocommerce_order_details_after_order_table', 'so_32457241_before_order_itemmeta');
function so_32457241_before_order_itemmeta($order){
	if ( 'wc-shipped' == $order->post_status ) {

        $order_id = $order->post->ID;

        if ( get_post_meta( $order_id ) )
        {
            @$order_express = get_post_meta( $order_id, 'express', true );
            if (@$order_express)
            {
                // 空白行高 Begin.
                echo '</br>';
                echo '</br>';
                echo '</br>';
                // 空白行高 End.
				
                echo'<h2>Shipping Info</h2>';

				echo '<table class="shop_table">';

                $express_link_field = 'tracking_link_'.$order_express;
                $express = ($order_express == 'faydawan') ? ( "新航(飛達旺)快遞" ) : ( strtoupper($order_express) );
                @$order_express_link = get_post_meta( $order_id, $express_link_field, true );
                @$order_tracking_number = get_post_meta( $order_id, 'tracking_number', true );
                @$order_express_document = get_post_meta( $order_id, 'express_document', true );
                @$order_note = get_post_meta( $order_id, 'order_note', true );

                if (@$order_express_link && @$order_tracking_number)
                {
                	echo '<tr>';
					echo '<th>TRACKING CODE:</th>';
                    echo '<td>'.$order_tracking_number.'</td>';
                    echo '</tr>';

                    echo '<tr>';
					echo '<th>TRACKING INQUIRY:</th>';
                    echo '<td><a style="color: #15c !important;" href="'.$order_express_link.'" target="_blank">'.$order_express_link.'</td></p>';
                    echo '</tr>';
                }
                if (@$order_express_document)
                {
                	echo '<tr>';
					echo '<th>DOWNLOAD SHIPPING DOCUMENTS:</th>';
                    $order_express_document_url = wp_get_attachment_url( $order_express_document );
                    echo '<td><a style="color: #15c !important;" href="'.$order_express_document_url.'" target="_blank">'.$order_express_document_url.'</a></td>';
                    echo '</tr>';
                }
            }
            $items = $order->get_items();

            $first = '1';
            foreach ($items as $item) {
                $product_id = $item['product_id'];
                $soft_link_all = get_post_meta($product_id, 'software_link', true);
                $soft_link = explode(',', $soft_link_all);
                if ($soft_link_all)
                {
                    if ( $first == '1')
                    {
                    	echo '<tr>';
						echo '<th>TECHNICAL DOCUMENTS:</th>';
                    }
                    echo '<td>';
                    foreach ($soft_link as $link) {
                        echo '<a style="color: #15c !important;" href="'.$link.'" target="_blank">'.$link.'</a>';
                    }
                    echo '</td>';
                    echo '</tr>';
                    $first .= '2';
                }
            }
        // echo '<div class="row top-buffer" style="margin-top:20px;"></div>';
        if ($order_note)
        	echo '<tr>';
			echo '<th>NOTE:</th>';
            echo '<td>'.$order_note.'</br></td>';
            echo '</tr>';
        }
        echo '</table>';

        // 空白行高 Begin.
        echo '</br>';
        echo '</br>';
        echo '</br>';
        // 空白行高 End.
    }
}

?>