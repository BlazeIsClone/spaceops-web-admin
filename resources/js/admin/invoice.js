"use strict";

// Set datatable defaults
if (window.GLOBAL_STATE?.ADMIN_DATATABLE_DEFAULTS) {
    $.extend(
        true,
        $.fn.dataTable.defaults,
        window.GLOBAL_STATE.ADMIN_DATATABLE_DEFAULTS
    );
}

// Filter input states.
let dateStart = "",
    dateEnd = "",
    status = "",
    paymentStatus = "",
    number = "",
    customer = "",
    company = "";

let datatable;

// Class definition
let KTDatatablesServerSide = (function () {
    // Private functions
    let initDatatable = function () {
        datatable = $("#kt_datatable").DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            responsive: true,
            dom: '<"top">rt<"bottom"<"d-flex flex-stack"li><"d-flex justify-content-center"p>><"clear">',
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"],
            ],
            ajax: {
                url: window.location.href + "/list",
                type: "POST",
            },
            order: [[0, "desc"]], // Show latest first
            columnDefs: [
                {
                    targets: ["id"],
                    width: 50,
                },
                {
                    targets: ["status"],
                    className: "text-md-center",
                    width: 100,
                },
                {
                    targets: ["payment_status"],
                    className: "text-md-center",
                    width: 130,
                },
                {
                    targets: ["image"],
                    orderable: false,
                    className: "text-md-center",
                    width: 100,
                },
                {
                    targets: ["actions"],
                    width: 150,
                    orderable: false,
                    className: "text-md-end export-hidden",
                    render: (items) => {
                        let template = `<div class="d-flex gap-3 justify-content-end">`;

                        if (items.overdue) {
                            template += `<button id="overdue" type="button" class="btn btn-sm btn-icon btn-danger" title="Overdue Notification"><i class="fa-solid fa-bell"></i></button>`;
                        }

                        if (items.show) {
                            template += `<a href="${items.show}" class="btn btn-sm btn-icon btn-light-dark" title="Show"><i class="fa-solid fa-eye"></i></a>`;
                        }

                        if (items.edit) {
                            template += `<a href="${items.edit}" class="btn btn-sm btn-icon btn-light-primary" title="Edit"><i class="fa-solid fa-pen"></i></a>`;
                        }

                        if (items.destroy) {
                            template += `<a href="${items.destroy}" class="btn btn-sm btn-icon btn-light-danger" title="Delete" data-kt-docs-table-filter="delete_row"><i class="fa-solid fa-trash-can"></i></a>`;
                        }

                        template += `</div>`;

                        return template;
                    },
                },
            ],
            ajax: {
                url: `${window.location.href}/list`,
                type: "POST",
                data: function (data) {
                    data._token = $('meta[name="csrf-token"]').attr("content");
                    data.date_start = dateStart;
                    data.date_end = dateEnd;
                    data.status = status;
                    data.payment_status = paymentStatus;
                    data.number = number;
                    data.customer = customer;
                    data.company = company;
                },
            },
        });

        // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
        datatable.on("draw", function () {
            window.AppDataTable.initToggleToolbar();
            window.AppDataTable.toggleToolbars();
            window.AppDataTable.handleRowActionDelete(datatable);
            KTMenu.createInstances();
        });
    };

    // Public methods
    return {
        init: function () {
            initDatatable();
            window.AppDataTable.handleSearchDatatable(datatable);
            window.AppDataTable.initToggleToolbar();
            window.AppDataTable.handleRowActionDelete(datatable);
            window.AppDataTable.exportButtons(datatable);
            window.AppDataTable.handleResetForm(datatable);
        },
    };
})();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    // Configure jQuery to include the CSRF token with every AJAX request
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    if (document.getElementById("kt_datatable")) {
        KTDatatablesServerSide.init();

        $("#date_range").on("apply.daterangepicker", function (ev, picker) {
            dateStart = picker.startDate.format("YYYY-MM-DD");
            dateEnd = picker.endDate.format("YYYY-MM-DD");
            $(this).val(dateStart + " - " + dateEnd);
        });

        $("#datatable_index").on("submit", function (event) {
            event.preventDefault();
            status = $("#status").val();
            paymentStatus = $("#payment_status").val();
            number = $("#number").val();
            customer = $("#customer").val();
            company = $("#company").val();
            datatable.draw();
        });

        $("#datatable_index").on("reset", function (event) {
            dateStart = "";
            dateEnd = "";
            status = "";
            paymentStatus = "";
            number = "";
            customer = "";
            company = "";
            setTimeout(() => {
                $(this).find("select").trigger("change");
            }, 200);
            datatable.draw();
        });
    }

    if ($('.draggable-zone').length) {
        InvoiceDraggable.init();
    }

    if ($('#invoiceData').length) {
        InvoiceRepeater.init();
    }

    if (document.getElementById("payment_method")) {
        $("#payment_date, #payment_link").hide();

        // Map enum values to their corresponding strings
        const paymentMethods = {
            card: 0,
            cash: 1,
        };

        /**
         * Handle payment method state ineactions.
         */
        function handlePaymentMethodInputs() {
            const selectedPaymentMethod = parseInt($("#payment_method").val());

            if (selectedPaymentMethod == paymentMethods.card) {
                $('label[for="payment_date"]').hide();
                $('input[name="payment_date"]').prop("disabled", true).hide();

                $('label[for="payment_link"]').show();
                $('input[name="payment_link"]').show();

                $('label[for="payment_reference"]').hide();
                $('textarea[name="payment_reference"]')
                    .prop("disabled", true)
                    .hide();
            }

            if (selectedPaymentMethod == paymentMethods.cash) {
                $('label[for="payment_date"]').show();
                $('input[name="payment_date"]').prop("disabled", false).show();

                $('label[for="payment_link"]').hide();
                $('input[name="payment_link"]').hide();

                $('label[for="payment_reference"]').show();
                $('textarea[name="payment_reference"]')
                    .prop("disabled", false)
                    .show();
            }
        }

        // on load.
        handlePaymentMethodInputs();

        // on update.
        $('select[name="payment_method"]').on("change", () =>
            handlePaymentMethodInputs()
        );
    }

    if (document.getElementById("invoice_download")) {
        $("#invoice_download").on("click", function () {
            window.open($(this).data("url"), "_blank");
        });
    }

    setTimeout(() => {
        if ($("button#overdue").length) {
            $("button#overdue").on("click", function (event) {
                event.preventDefault();

                const parent = event.target.closest("tr");
                const resourceId = parent.querySelectorAll("td")[0].innerText;

                Swal.fire({
                    title: "Send invoice overdue mail?",
                    icon: "info",
                    showCancelButton: true,
                    reverseButtons: true,
                    confirmButtonText: "Send Mail",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: `${window.location.href}/${resourceId}/overdue`,
                            beforeSend: function (xhr, options) {
                                Swal.fire({
                                    text: "Sending..",
                                    icon: "info",
                                    showConfirmButton: false,
                                });

                                setTimeout(function () {
                                    $.ajax(
                                        $.extend(options, {
                                            beforeSend: $.noop,
                                        })
                                    );
                                }, 1000);

                                return false;
                            },
                            success: function (response) {
                                if (response["status"]) {
                                    Swal.fire(
                                        "Success",
                                        response["message"],
                                        "success"
                                    );
                                } else {
                                    Swal.fire(
                                        "Error",
                                        response["message"],
                                        "error"
                                    );
                                }
                            },
                            error: function ({ responseJSON }) {
                                Swal.fire(
                                    "Failed to Delete",
                                    responseJSON["message"],
                                    "error"
                                );
                            },
                            complete: function () {
                                datatable.draw();
                            },
                        });
                    }
                });
            });
        }
    }, 2000);

    if (document.getElementById('payment_link')) {
        const target = document.getElementById('payment_link');
        const button = target.nextElementSibling;

        let clipboard = new ClipboardJS(button, {
            target: target,
            text: function () {
                return target.value;
            }
        });

        clipboard.on('success', function (e) {
            const currentLabel = button.innerHTML;
            const icon = '<i class="ki-duotone ki-copy-success"><span class="path1"></span><span class="path2"></span></i>';

            if (button.innerHTML === icon) {
                return;
            }

            button.innerHTML = icon;

            setTimeout(function () {
                button.innerHTML = currentLabel;
            }, 3000)
        });
    }
});

$('input[name="item_type"]').on('change', function (event) {
    let value = parseInt($('input[name="item_type"]:checked').val());
    $('.itinerary-type').addClass('d-none');
    if (value == 1) {
        $('#itinerarySelect').removeClass('d-none');
    } else if (value == 2) {
        $('#customItinerarySelect').removeClass('d-none');
    } else if (value == 3) {
        $('#activitySelect').removeClass('d-none');
    } else {
        $('#customItem').removeClass('d-none');
    }
});

$('#addInvoiceItemBtn').on('click', function (event) {
    event.preventDefault();

    let itemType = parseInt($('input[name="item_type"]:checked').val());
    let itemTypeName = $('input[name="item_type"]:checked').parent().find('.form-check-label').text();
    let itemName = null;
    let itemID = null;

    if (itemType == ITEM_TYPE_ITINERARY) {
        itemID = $('#itinerary').val();
        itemName = $('#itinerary option:selected').text();
    } else if (itemType == ITEM_TYPE_CUSTOM_ITINERARY) {
        itemID = $('#custom_itinerary').val();
        itemName = $('#custom_itinerary option:selected').text();
    } else if (itemType == ITEM_TYPE_ACTIVITY) {
        itemID = $('#activity').val();
        itemName = $('#activity option:selected').text();
    } else {
        itemID = $('#title').val();
        itemName = $('#title').val();
    }

    let description = $('#description').val();
    let quantity = $('#quantity').val();
    let unitPrice = parseFloat($('#unit_price').val())
        .toFixed(2)
        .toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        });

    if (itemType && itemTypeName && itemID && itemName && unitPrice && !isNaN(unitPrice)) {
        let currentInvoiceData = ($('tr.draggable').length) ? $('#invoiceData').repeaterVal()['invoice_items'] : [];

        let updatedCurrentInvoiceData = [];

        for (const [key, value] of Object.entries(currentInvoiceData)) {
            updatedCurrentInvoiceData.push({
                'type_id': value['type_id'],
                'type': value['type'],
                'item_id': value['item_id'],
                'title': value['title'],
                'description': value['description'],
                'quantity': value['quantity'],
                'unit_price': value['unit_price'],
                'amount': value['amount'],
            });
        }

        let rowTotal = parseFloat(parseFloat(quantity) * parseFloat(unitPrice))
            .toFixed(2)
            .toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            });

        updatedCurrentInvoiceData.push({
            'type_id': itemType,
            'type': itemTypeName.trim(),
            'item_id': itemID,
            'title': itemName.trim(),
            'description': description,
            'quantity': quantity,
            'unit_price': unitPrice,
            'amount': rowTotal,
        });

        invoiceItemsRepeater.setList(updatedCurrentInvoiceData);

        let totalPrice = parseFloat($('#totalPriceInput').val());
        if (isNaN(totalPrice)) {
            totalPrice = 0;
        }

        let total = parseFloat(parseFloat(totalPrice) + parseFloat(rowTotal))
            .toFixed(2)
            .toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            });

        $('#totalPrice').text(total);
        $('#totalPriceInput').val(total);

        $('#invoiceItemForm input[type=text], #invoiceItemForm input[type=number]').val('');
        $('#invoiceItemForm select').val('');
        $('#invoiceItemForm select').trigger('change');
    } else {
        Swal.fire('Error', 'Please fill out all required fields.', 'error');
    }
});

let swappable;
let invoiceItemsRepeater;

let InvoiceDraggable = function () {
    return {
        //main function to initiate the module
        init: function () {
            let containers = document.querySelectorAll('.draggable-zone');

            if (containers.length === 0) {
                return false;
            }

            swappable = new Sortable.default(containers, {
                draggable: '.draggable',
                handle: '.draggable-handle',
                mirror: {
                    appendTo: 'body',
                    constrainDimensions: true
                }
            });
        }
    };
}();

// Invoice Items Repeater
let InvoiceRepeater = function () {

    // Private functions
    let invoiceRepeater = function () {
        invoiceItemsRepeater = $('#invoiceData').repeater({
            initEmpty: true,

            show: function () {
                $(this).slideDown();
            },

            hide: function (deleteElement) {
                Swal.fire({
                    title: 'Are you sure you want to remove this item?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes! Remove',
                    denyButtonText: 'Cancel',
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-light-primary",
                    },
                }).then((result) => {
                    if (result.isConfirmed) {

                        let totalPrice = parseFloat($('#totalPriceInput').val());
                        let amount = parseFloat($(this).find('#amount').val());

                        totalPrice = (!isNaN(totalPrice)) ? totalPrice : 0;
                        amount = (!isNaN(amount)) ? amount : 0;

                        let total = parseFloat(totalPrice - amount)
                            .toFixed(2)
                            .toLocaleString(undefined, {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2,
                            });

                        $('#totalPrice').text(total);
                        $('#totalPriceInput').val(total);

                        $(this).slideUp(deleteElement);
                    }
                });
            },

            ready: function (setIndexes) {
                swappable.on('sortable:sorted', () => {
                    setTimeout(() => {
                        setIndexes();
                    }, 1000);
                });
            },
        });
    }

    return {
        // public functions
        init: function () {
            invoiceRepeater();
            invoiceItemsRepeater.setList(items);
        }
    };
}();
