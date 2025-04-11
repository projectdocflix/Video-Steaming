
(function ($) {
    "use strict";

    // $(document).on('submit', "form.ajax", function (event) {
    //     event.preventDefault();
    //     var enctype = $(this).prop("enctype");
    //     if (!enctype) {
    //         enctype = "application/x-www-form-urlencoded";
    //     }
    //
    //     $(document).find(':input[type=submit]').attr('disabled', true);
    //     $(document).find(':input[type=submit]').find('.spinner-border').removeClass('d-none');
    //     commonAjax($(this).prop('method'), $(this).prop('action'), window[$(this).data("handler")], window[$(this).data("handler")], new FormData($(this)[0]));
    // });


    $(document).on("click", "a.delete", function () {
        const selector = $(this);
        Swal.fire({
            title: 'Sure! You want to delete?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete It!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'GET',
                    url: $(this).data("url"),
                    success: function (data) {
                        selector.closest('.removable-item').fadeOut('fast');
                        Swal.fire({
                            title: 'Deleted',
                            html: ' <span style="color:red">Item has been deleted</span> ',
                            timer: 2000,
                            icon: 'success'
                        })
                    }
                })
            }
        })
    });

    $(document).on("click", ".deleteItem", function () {
        let form_id = this.dataset.formid;
        Swal.fire({
            title: 'Sure! You want to delete?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete It!'
        }).then((result) => {
            if (result.value) {
                $("#" + form_id).submit();
            } else if (result.dismiss === "cancel") {
                Swal.fire(
                    "Cancelled",
                    "Your imaginary file is safe :)",
                    "error"
                )
            }
        })
    });

    $(document).ready(function () {
        $(".multiple-basic-single").select2({
            placeholder: "Select Option",
        });

        $(".multiple-select-input").select2({
            tags: true,
            tokenSeparators: [','],
        })
    });




    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    window.getLanguage = function () {
        return {
            "sEmptyTable": "No Data Available In Table",
            "sInfo": "Showing START to END of TOTAL entries",
            "sInfoEmpty": "Showing 0 to 0 of 0 entries",
            "sInfoFiltered": "(filtered from MAX total entries)",
            "sInfoPostFix": "",
            "sInfoThousands": ",",
            "sLengthMenu": "Show MENU entries",
            "sLoadingRecords": "Loading...",
            "sProcessing": "Processing...",
            "sSearch": "Search:",
            "sZeroRecords": "No matching records found",
            "oPaginate": {
                "sFirst": "First",
                "sLast": "Last",
                "sNext": "Next",
                "sPrevious": "Previous"
            },
            "oAria": {
                "sSortAscending": ": activate to sort column ascending",
                "sSortDescending": ": activate to sort column descending"
            }
        };
    }


    window.currencyPrice = function ($price) {
        if (currencyPlacement == 'after')
            return $price + ' ' + currencySymbol;
        else {
            return currencySymbol + $price;
        }
    }

    window.dateFormat = function (date, format = 'MM-DD-YYYY') {
        return moment(date).format(format);
    }

    window.deleteItem = function (url, id) {
        Swal.fire({
            title: 'Sure! You want to delete?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete It!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'POST',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        Swal.fire({
                            title: 'Deleted',
                            html: ' <span style="color:red">Item has been deleted</span> ',
                            timer: 2000,
                            icon: 'success'
                        })
                        toastr.success(data.message);
                        if(typeof id != 'undefined'){
                            $('#' + id).DataTable().ajax.reload();
                        }else{
                            setTimeout(function (){
                                location.reload();
                            }, 1000)
                        }
                    },
                    error: function (error) {
                        toastr.error(error.responseJSON.message)
                    }
                })
            }
        })
    }

    window.commonAjax = function (type, url, successHandler, errorHandler, data) {
        var ajaxData = {
            type: type,
            url: url,
            dataType: 'json',
            success: successHandler,
            error: errorHandler
        }
        if (typeof (data) != 'undefined') {
            ajaxData.data = data;
        }

        if (type == 'POST' || type == 'post') {
            ajaxData.encType = 'enctype';
            ajaxData.contentType = false;
            ajaxData.processData = false;
        }
        $.ajax(ajaxData);
    }

    window.showMessage = function (response) {
        $(document).find(':input[type=submit]').find('.spinner-border').addClass('d-none');
        $(document).find(':input[type=submit]').removeAttr('disabled');
        if (response.status == true) {
            alertAjaxMessage('success', response.message)
            location.reload()
        } else {
            alertAjaxMessage('error', response.message)
        }
    }

    window.commonHandler = function (data) {
        $(document).find(':input[type=submit]').find('.spinner-border').addClass('d-none');
        $(document).find(':input[type=submit]').removeAttr('disabled');
        console.log("this is common handler section");
        var output = '';
        var type = 'error';
        $('.error-message').remove();
        $('.is-invalid').removeClass('is-invalid');
        if (data['status'] == false) {
            output = output + data['message'];
        } else if (data['status'] === 422) {
            var errors = data['responseJSON']['errors'];
            output = getValidationError(errors);
        } else if (typeof data['responseJSON']['error'] !== 'undefined') {
            output = data['responseJSON']['error'];
        } else {
            output = data['responseJSON']['message'];
        }
        alertAjaxMessage(type, output);
    }

    window.alertAjaxMessage = function (type, message) {
        if (type === 'success') {
            toastr.success(message);
        } else if (type === 'error') {
            toastr.error(message);
        } else if (type === 'warning') {
            toastr.error(message);
        } else {
            return false;
        }
    }

    window.getValidationError = function (errors) {
        var output = 'Validation Errors';
        $.each(errors, function (index, items) {
            if (index.indexOf('.') != -1) {
                var name = index.split('.');
                if(isNaN(parseInt(name[1])) && name.length == 2){
                    getName = name.join('_');
                    var itemSelect = $(document).find('.' + getName);
                }else{
                    var getName = name.slice(0, -1).join('-');
                    var i = name.slice(-1);
                    var itemSelect = $(document).find('.' + getName + ':eq(' + i + ')')
                }
                var message = items[0];
                itemSelect.addClass('is-invalid');
                itemSelect.closest('div').append('<span class="text-danger p-2 fs-12 z-index-10 position-relative error-message">' + message + '</span>')
            } else {
                var itemSelect = $(document).find("[name='" + index + "']");
                if (!itemSelect.length) {
                    itemSelect = $(document).find("[name^='" + index + "']");
                }
                itemSelect.addClass('is-invalid');
                itemSelect.closest('div').append('<span class="text-danger p-2 fs-12 z-index-10 position-relative error-message">' + items[0] + '</span>')
            }
        });
        return output;
    }

    window.settingCommonHandler = function (data) {
        $(document).find(':input[type=submit]').find('.spinner-border').addClass('d-none');
        $(document).find(':input[type=submit]').removeAttr('disabled');

        var output = '';
        var type = 'error';
        $('.error-message').remove();
        $('.is-invalid').removeClass('is-invalid');

        if (data['status'] == true) {
            output = output + data['message'];
            type = 'success';
            if ($('.modal.show').length) {
                $('.modal.show').modal('toggle')
            }
            if ($('.dataTable ').length) {
                $('.dataTable').DataTable().ajax.reload();
            }
            alertAjaxMessage(type, output);
            if ($(document).find('form.reset').length) {
                $(document).find('form.reset')[0].reset();
                if ($('.summernoteOne')) {
                    $('.summernoteOne').summernote('reset');
                }
                if ($('.upload-img-box').find('img')) {
                    $('.upload-img-box').find('img').attr('src', '');
                }
                if ($('.select2-hidden-accessible')) {
                    $('.select2-hidden-accessible').val(null).trigger('change');
                }
                if ($('.sf-select-without-search')) {
                    $('.sf-select-without-search').niceSelect('update');
                }
            }
        } else {
            commonHandler(data)
        }
    }

    window.getEditModal = function (url, modalId, callbackFunc) {
        $.ajax({
            type: 'GET',
            url: url,
            success: function (data) {
                $(document).find(modalId).find('.modal-content').html(data);

                if ($(document).find(modalId).find('.sf-select-edit-modal').length) {
                    $(document).find(modalId).find('.sf-select-edit-modal').select2({
                        dropdownCssClass: "sf-select-dropdown",
                        selectionCssClass: "sf-select-section",
                        dropdownParent: $(modalId),
                    });
                }

                if ($(document).find(modalId).find('.sf-select-without-search').length) {
                    $(document).find(modalId).find('.sf-select-without-search').niceSelect();
                }

                if ($(document).find(modalId).find('.date-time-picker').length) {
                    $(document).find(modalId).find('.date-time-picker').each(function () {
                        $(this).closest(".primary-form-group-wrap").addClass("calendarIcon"); // Add your custom class here
                    });

                    $(document).find(modalId).find('.date-time-picker').daterangepicker({
                        singleDatePicker: true,
                        timePicker: true,
                        locale: {
                            format: "Y-M-D h:mm",
                        },
                    });
                }

                if ($(document).find(modalId).find('.summernoteOne').length) {
                    $(document).find(modalId).find('.summernoteOne').summernote({
                        placeholder: "Write description...",
                        tabsize: 2,
                        minHeight: 183,
                    });
                }

                $(modalId).modal('toggle');

                // Execute callback after modal is fully loaded and toggled
                if (typeof callbackFunc !== 'undefined'  && typeof window[callbackFunc] === 'function') {
                    window[callbackFunc]();
                }
            },
            error: function (error) {
                toastr.error(error.responseJSON.message);
            }
        });
    }

    window.commonResponseForModal = function (response) {
        console.log("This is commonResponseForModal");
        $(document).find(':input[type=submit]').find('.spinner-border').addClass('d-none');
        $(document).find(':input[type=submit]').removeAttr('disabled');

        $('.error-message').remove();
        $('.is-invalid').removeClass('is-invalid');
        if (response['status'] === true) {
            toastr.success(response['message'])

            if ($('.modal.show').length) {
                $('.modal.show').modal('toggle');
            }

            if ($('.dataTable').length) {
                $('.dataTable').DataTable().ajax.reload();
            }
            else {
                setTimeout(() => {
                    location.reload()
                }, 1000);
            }

            if ($(document).find('form.reset').length) {
                $(document).find('form.reset')[0].reset();
                if ($('.summernoteOne')) {
                    $('.summernoteOne').summernote('reset');
                }
                if ($('.upload-img-box').find('img')) {
                    $('.upload-img-box').find('img').attr('src', '');
                }
                if ($('.select2-hidden-accessible')) {
                    $('.select2-hidden-accessible').val(null).trigger('change');
                }
                if ($('.sf-select-without-search')) {
                    $('.sf-select-without-search').niceSelect('update');
                }
            }

        } else {
            commonHandler(response)
        }
    }

    window.commonResponseWithPageLoad = function (response) {
        $('.error-message').remove();
        $('.is-invalid').removeClass('is-invalid');
        $(document).find('.spinner-border').addClass('d-none');
        if (response['status'] === true) {
            toastr.success(response['message'])

            setTimeout(() => {
                location.reload()
            }, 1000);


        } else {
            commonHandler(response)
        }
    }

    window.commonResponse = function (response) {
        $(document).find(':input[type=submit]').find('.spinner-border').addClass('d-none');
        $(document).find(':input[type=submit]').removeAttr('disabled');

        $('.error-message').remove();
        $('.is-invalid').removeClass('is-invalid');
        if (response['status'] === true) {
            toastr.success(response['message']);
            if ($('.dataTable ').length) {
                $('.dataTable').DataTable().ajax.reload();
            }

            if ($(document).find('form.reset').length) {
                $(document).find('form.reset')[0].reset();
                if ($('.summernoteOne')) {
                    $('.summernoteOne').summernote('reset');
                }
                if ($('.upload-img-box').find('img')) {
                    $('.upload-img-box').find('img').attr('src', '');
                }
                if ($('.select2-hidden-accessible')) {
                    $('.select2-hidden-accessible').val(null).trigger('change');
                }
                if ($('.sf-select-without-search')) {
                    $('.sf-select-without-search').niceSelect('update');
                }
            }

        } else {
            commonHandler(response)
        }
    }

    window.commonResponseRedirect = function (response) {
        $(document).find(':input[type=submit]').find('.spinner-border').addClass('d-none');
        $(document).find(':input[type=submit]').removeAttr('disabled');
        $('.error-message').remove();
        $('.is-invalid').removeClass('is-invalid');
        if (response['status'] === true) {
            toastr.success(response['message']);
            if ($('.dataTable ').length) {
                $('.dataTable').DataTable().ajax.reload();
            }

            if ($(document).find('form.reset').length) {
                $(document).find('form.reset')[0].reset();
                if ($('.summernoteOne')) {
                    $('.summernoteOne').summernote('reset');
                }
                if ($('.upload-img-box').find('img')) {
                    $('.upload-img-box').find('img').attr('src', '');
                }
                if ($('.select2-hidden-accessible')) {
                    $('.select2-hidden-accessible').val(null).trigger('change');
                }
                if ($('.sf-select-without-search')) {
                    $('.sf-select-without-search').niceSelect('update');
                }
            }

            if ($('form').find(`[data-redirect-url]`)) {
                setTimeout(function () {
                    location.href = $(document).find(`[data-redirect-url]`).data('redirect-url');
                }, 700);
            }

        } else {
            commonHandler(response)
        }
    }

    window.gatewayCurrencyPrice = function ($price, $currency = '$') {
        if (currencyPlacement == 'after')
            return $price + ' ' + $currency;
        else {
            return $currency + ' ' + $price;
        }
    }


    $(document).on('click', '.copy-button', function () {
        var scriptContainer = $(this).prev('.script-container');

        // Get the text from the script container
        var textToCopy = scriptContainer.text().trim();

        try {
            // Copy the text directly to the clipboard
            navigator.clipboard.writeText(textToCopy);

            toastr.success('Copied to clipboard!');
        } catch (err) {
            console.error('Unable to copy to clipboard', err);

            // Handle the error (e.g., show an alert)
            alert('Error copying to clipboard');
        }
    });

})(jQuery)
