jQuery(document).ready(function($) {

    // Display already selected option field.
    function selected() {

        var selection_access = $("#mwb_membership_plan_access_type  option:selected").val();

        var selection_radio = $("input[name='mwb_membership_plan_access_type']:checked").val();

        var shipping_value  =$("input[name='mwb_memebership_plan_free_shipping']:checked").val();

        switch (selection_access) {

            case 'limited':
                $("#mwb_membership_duration").show('500');
                $("#mwb_membership_recurring_plan").show('500');
                break;

            default:
                $("#mwb_membership_duration").hide('500');
                $("#mwb_membership_recurring_plan").hide('500');

        }

        switch (selection_radio) {

            case 'immediate_type':
                $("#mwb_membership_plan_time_duratin_display").hide('500');
                break;

            case 'delay_type':
                $("#mwb_membership_plan_time_duratin_display").show('500');
        }

        if ( 'yes' == shipping_value ) {
            $(".mwb_membership_free_shipping_link").show('500');
        } else {
            $(".mwb_membership_free_shipping_link").hide('500');
        }
    }

    selected(); // calling the function when the page is ready.

    // Display access type form fields as per user seletcion.
    $("#mwb_membership_plan_access_type").on('change', function() {
        var selection = $(this).val();

        switch (selection) {

            case 'limited':
                $("#mwb_membership_duration").show('500');
                $("#mwb_membership_recurring_plan").show('500');
                break;

            default:
                $("#mwb_membership_duration").hide('500');
                $("#mwb_membership_plan_duration").val("");
                $("#mwb_membership_plan_duration_type").prop("selectedIndex", 0);
                $("#mwb_membership_recurring_plan").hide('500');

        }
    });

    // Display specify time form fields as per user selection.
    $("#new_created_offers table tr:last td :radio").on("change", function() {

        if (this.id == "mwb_membership_plan_time_type") {

            $("#mwb_membership_plan_time_duratin_display").show('500');

        } else {

            $("#mwb_membership_plan_time_duratin_display").hide('500');
            $("#mwb_membership_plan_time_duration").val("");
            $("#mwb_membership_plan_time_duration_type").prop("selectedIndex", 0);

        }

    });

    // Display free shipping link as per user selection.
    $("input[name='mwb_memebership_plan_free_shipping']").on("change", function() {

        if ($(this).is(":checked")) {

            $(".mwb_membership_free_shipping_link").show('500');

        } else {

            $(".mwb_membership_free_shipping_link").hide('500');
        }
    });


    // Import CSV modal.
    $("#import_all_membership").on("click", function(e) {
        e.preventDefault();

        $(".import_csv_field_wrapper").dialog("open");

        // Ajax call for import CSV.
        $("#upload_csv_file").on("click", function(e) {
            e.preventDefault();

            var empty_check = $("#csv_file_upload").val();

            // If no file selected close the dialog box and show 'failure' sweet alert.
            if (empty_check.length == 0) {

                // CLose the import modal.
                $(".import_csv_field_wrapper").dialog("close");

                // Show "failure" response via sweet-alert.
                Swal.fire({
                    icon: 'error',
                    title: 'Oops..!!',
                    text: 'No file selected',
                });

            } else {

                var form = new FormData();
                var file = $(document).find("#csv_file_upload");

                var single_file = file[0].files[0];

                form.append("file", single_file);
                form.append("action", "csv_file_upload");
                form.append("nonce", admin_ajax_obj.nonce)

                $.ajax({
                    url: admin_ajax_obj.ajaxurl,
                    type: "POST",
                    data: form,
                    dataType: 'json',
                    contentType: false,
                    processData: false,

                    success: function(response) {

                        // Close the import modal.
                        $(".import_csv_field_wrapper").dialog("close");

                        if ('success' == response['status']) {

                            // Show "success" response via sweet-alert.
                            Swal.fire({
                                icon: 'success',
                                title: response['message'],
                            });

                            // Reload page after click on ok in
                            $(".swal2-confirm").on("click", function() {
                                window.location.href = response['redirect'];
                            });
                        } else if ('failed' == response['status']) {

                            // Show "failure" response via sweet-alert.
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops..!!',
                                text: response['message']
                            });
                        }
                    },

                });
            }

        });
    });

    $(".import_csv_field_wrapper").dialog({
        modal: true,
        autoOpen: false,
        show: { effect: "blind", duration: 800 },
        width: 600
    });

    // Applying script to admin part in all product list page
    var mwb_status = $('.membership_status').each(function() {

        if ($(this).text() == 'Live') {
            $(this).css({ 'background-color': '#c6e1c6', 'color': '#5b841b' });
        } else if ($(this).text() == 'Sandbox') {
            $(this).css({ 'background-color': '#f8dda7', 'color': '#94660c' });
        }

    });

    // Image uploader in global settings email log.
    $('#upload_img').click(function(e) {
        e.preventDefault();

        media_modal = wp.media.frames.media_modal = wp.media({
            title: 'Upload a logo.',
            button: { text: 'Select' },
            library: { type: 'image' },
        });

        media_modal.on('select', function() {

            var attachment = media_modal.state().get('selection').first().toJSON();
            var img = attachment.sizes.thumbnail || attachment.sizes.medium || attachment.sizes.full;
            $('#mwb_membership_invoice_logo').val(attachment.url);
            $('#img_thumbnail').find('img').attr('src', img.url);
            $('#img_thumbnail').show(500);
            $('#upload_img').addClass('button_hide');
            $('#remove_img').removeClass('button_hide');
        });

        media_modal.open();
    });

    // Remove image button.
    $(document).on('click', '#remove_img', function(e) {
        e.preventDefault();
        $('#mwb_membership_invoice_logo').val('');
        $('#img_thumbnail').hide(500);
        $('#img_thumbnail').find('img').attr('src', '');
        $('#upload_img').removeClass('button_hide');
        $('#remove_img').addClass('button_hide');
    });
    
    // invoice attach checkbox
    $('#mwb_membership_attach_invoice').on('change', function() {

    	var check = $(this).prop('checked');

        if ( check == true) {

            $('.mfw_membership_invoice_pdf').show('500');
        } else  if ( check == false){

            $('.mfw_membership_invoice_pdf').hide('500');

        }
    });

});