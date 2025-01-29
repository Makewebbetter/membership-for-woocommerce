jQuery( document ).ready( function( $ ){

    jQuery(document).find('.wps_org_offer_plan_id').select2();
    // Target products search.
    jQuery( ".wc-membership-product-search" ).select2({

        ajax:{

            url: add_new_obj.ajax_url,
            dataType: "json",
            delay:    200,
            data: function( params ) {
                return {
                    q: params.term,
                    action: "wps_membership_search_products_for_membership",
                };
            },
            processResults: function( data ) {

                var options = [];
                if ( data ) {

                    $.each( data, function( index, text ) {
                        text[1]+='( #'+text[0]+')';
                        options.push( { id: text[0], text: text[1] } );
                    });
                }
                return {
                    results:options
                };
            },
            cache: true
        },
        minimumInputLength: 3 // The minimum number of characters to input to perform a search.
    });


    // Target category search.
    jQuery( ".wc-membership-product-category-search" ).select2({

        ajax:{

            url: add_new_obj.ajax_url,
            dataType: "json",
            delay: 200,
            data: function( params ) {
                return {
                    q: params.term,
                    action: "wps_membership_search_product_categories_for_membership",
                };
            },
            processResults: function( data ) {
                var options = [];
                if ( data ) {

                    $.each( data, function( index, text ) {

                        text[1]+='( #'+text[0]+')';
                        options.push( { id: text[0], text: text[1] } )

                    });
                }
                return {
                    results: options
                };
            },
            cache: true
        },
        minimumInputLength: 3 // The minimum number of characters to input to perform a search.
    });


    // set limit when fixed and discount type is selected in new plan price.
    jQuery(document).on('change', '#wps_membership_plan_for_discount_offer', function(){
        
        var plan_id = jQuery(this).val();
        
        jQuery('#wps_membership_discount_amount_'+plan_id).attr( 'max', '100' );
        jQuery(document).on('change', '#wps_membership_discount_type_'+plan_id, function(){

            var discount_type = jQuery(this).val();
            
            if ( 'fixed' == discount_type ) {
            
                jQuery('#wps_membership_discount_amount_'+plan_id).removeAttr( 'max' );
            } else {
    
                jQuery('#wps_membership_discount_amount_'+plan_id).attr( 'max', '100' );
            }
        });
    });

    // send offer notification on whatsapp.
    jQuery(document).on('click', '#wps_wpr_send_on_whatsap_btn', function(){

        var wps_org_offer_plan_id = jQuery('.wps_org_offer_plan_id').val();
        var wps_wpr_offer_message = jQuery('.wps_wpr_offer_message').val();
        if (Array.isArray(wps_org_offer_plan_id) && wps_org_offer_plan_id.length !== 0) {

            jQuery('.wps_wpr_offer_msg_notice').hide();
            jQuery('.wps_wpr_whatsapp_loader').show();
            jQuery('#wps_wpr_send_on_whatsap_btn').prop('disabled', true);
            var data = {
                'action'                : 'send_offer_message_on_whatsapp',
                'nonce'                 : add_new_obj.wps_nonce,
                'wps_org_offer_plan_id' : wps_org_offer_plan_id,
                'wps_wpr_offer_message' : wps_wpr_offer_message,
            };

            jQuery.ajax({
                'method' : 'POST',
                'url'    : add_new_obj.ajax_url,
                'data'   : data,
                success  : function(response) {

                    jQuery('.wps_wpr_whatsapp_loader').hide();
                    jQuery('#wps_wpr_send_on_whatsap_btn').prop('disabled', false);
                    console.log(response);
                }
            });
        } else {

            jQuery('.wps_wpr_offer_msg_notice').show();
            jQuery('.wps_wpr_offer_msg_notice').css('color', 'red');
            jQuery('.wps_wpr_offer_msg_notice').html('This is a required fields, please enter some values !!');
            return false;
        }
    });
});
