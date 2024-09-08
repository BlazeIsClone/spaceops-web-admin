jQuery(document).ready(function ($) {
    const IS_MOBILE_DEVICE = window.matchMedia(
        "only screen and (max-width: 767px)"
    ).matches;
    const IS_TAB_DEVICE = window.matchMedia(
        "only screen and (min-width: 768px) and (max-width: 1024px)"
    ).matches;
    const IS_DESKTOP_DEVICE = !IS_MOBILE_DEVICE && !IS_TAB_DEVICE;

    if (IS_MOBILE_DEVICE || IS_TAB_DEVICE) {
        new Mmenu(
            "#primaryNav",
            {
                offCanvas: {
                    position: "right-front",
                },
                navbars: [
                    {
                        position: "top",
                        content: ["<img src='" + SITE_LOGO + "' />"],
                    },
                    {
                        position: "bottom",
                        content: window.SOCIAL_MEDIA,
                    },
                ],
            },
            {
                offCanvas: {
                    page: {
                        selector: "#page",
                    },
                },
            }
        );
    }

    // Init addons
    if ($(".select2").length) {
        $(".select2").select2({
            theme: 'bootstrap-5'
        });
    }

    if ($("[data-fancybox]").length) {
        Fancybox.bind("[data-fancybox]");
    }

    /**
     * Select2 template with icon.
     */
    function select2IconTemplate(option) {
        if (option.disabled) return option.text;
        let tag = option.element;

        if (!tag?.dataset?.icon) return option.text;
        return $(`<span><img style="width: 25px;" src="${tag.dataset.icon}"/>${option.text}</span>`);
    }

    if ($("#country").length) {
        $("#country").select2({
            theme: 'bootstrap-5',
            allowClear: false,
            templateResult: select2IconTemplate,
            templateSelection: select2IconTemplate,
        });
    }

    if ($("#homeToursSwiper").length) {
        const element = $("#homeToursSwiper");
        let childCount = $(element).find(".swiper-slide").length;

        let enableSwiper =
            (IS_MOBILE_DEVICE && childCount > 1) ||
            (IS_TAB_DEVICE && childCount > 2) ||
            (IS_DESKTOP_DEVICE && childCount > 4);

        if (!enableSwiper) {
            $(element).parent().css('padding', '0px');
            $(element).next(".swiper-nav").hide();
        }

        new Swiper("#homeToursSwiper", {
            loop: true,
            autoplay: enableSwiper
                ? {
                    delay: 5000,
                    disableOnInteraction: false,
                }
                : false,
            speed: 500,
            preventClicksPropagation: false,
            navigation: {
                nextEl: "#itinerariesNext",
                prevEl: "#itinerariesPrev",
            },
            spaceBetween: 25,
            breakpoints: {
                0: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                1025: {
                    slidesPerView: 4,
                },
            },
        });
    }

    if ($("#homeAudienceSwiper").length) {
        const element = $("#homeAudienceSwiper");
        let childCount = $(element).find(".swiper-slide").length;

        let enableSwiper =
            (IS_MOBILE_DEVICE && childCount > 1) ||
            (IS_TAB_DEVICE && childCount > 2) ||
            (IS_DESKTOP_DEVICE && childCount > 4);

        if (!enableSwiper) {
            $(element).parent().css('padding', '0px');
            $(element).next(".swiper-nav").hide();
        }

        new Swiper("#homeAudienceSwiper", {
            loop: true,
            autoplay: enableSwiper
                ? {
                    delay: 5000,
                    disableOnInteraction: false,
                }
                : false,
            speed: 500,
            preventClicksPropagation: false,
            navigation: {
                nextEl: "#packagesNext",
                prevEl: "#packagesPrev",
            },
            spaceBetween: 25,
            breakpoints: {
                0: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                1025: {
                    slidesPerView: 4,
                },
            },
        });
    }

    if ($("#homeExperiencesSwiper").length) {
        const element = $("#homeExperiencesSwiper");
        let childCount = $(element).find(".swiper-slide").length;

        let enableSwiper =
            (IS_MOBILE_DEVICE && childCount > 1) ||
            (IS_TAB_DEVICE && childCount > 2) ||
            (IS_DESKTOP_DEVICE && childCount > 3);

        if (!enableSwiper) {
            $(element).parent().css('padding', '0px');
            $(element).next(".swiper-nav").hide();
        }

        new Swiper("#homeExperiencesSwiper", {
            loop: true,
            autoplay: enableSwiper
                ? {
                    delay: 5000,
                    disableOnInteraction: false,
                }
                : false,
            speed: 500,
            preventClicksPropagation: false,
            navigation: {
                nextEl: "#experiencesNext",
                prevEl: "#experiencesPrev",
            },
            spaceBetween: 25,
            breakpoints: {
                0: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                1025: {
                    slidesPerView: 3,
                },
            },
        });
    }

    if ($("section.gallery").length) {
        Fancybox.bind("section.gallery .image", {
            groupAll: true,
        });
    }

    if ($("#contact_form").length) {
        $("#contact_form").on("submit", function (event) {
            event.preventDefault();

            let validated = true;

            $(this)
                .find("input[required], textarea[required], select[required], radio[required], checkbox[required]")
                .each(function () {
                    if (!$(this).val()) {
                        $("#contact_form").addClass("was-validated");
                        validated = false;
                    }
                });

            if (validated) {
                formSubmitButtonState($("#contact_form"), true);

                $.ajax({
                    type: "POST",
                    url: $(this).attr("action"),
                    data: $(this).serializeArray(),
                    success: function (response) {
                        if (response["status"]) {
                            SuccessAlert.fire(
                                "Success!",
                                response["message"],
                                "success"
                            );
                            document
                                .getElementById("contact_form")
                                .reset();

                            $("#contact_form")
                                .find("input, textarea, select, radio, checkbox").removeClass('is-invalid');

                            $("#contact_form").find("select").val(null).trigger("change");
                        } else {
                            DangerAlert.fire(
                                "Error!",
                                response["message"],
                                "error"
                            );
                        }
                    },
                    error: function (response) {
                        let errorMessage = 'An unknown error has occurred';

                        if (response.responseJSON && response.responseJSON.errors) {
                            let errors = response.responseJSON.errors;
                            errorMessage = '';
                            $.each(errors, function (field, messages) {
                                errorMessage += messages.join(' ') + '\n';
                                $(`[name="${field}"]`).addClass('is-invalid');
                                $(`[name="${field}"]`).next('.invalid-feedback').remove();
                                $(`[name="${field}"]`).after(`<div class="invalid-feedback">${messages.join(' ')}</div>`);
                            });
                        }

                        DangerAlert.fire(
                            "Error!",
                            response["message"] ?? 'An unknown error has occured',
                            "error"
                        );
                    },
                    complete: function () {
                        formSubmitButtonState($("#contact_form"), false);
                    }
                });
            }
        });
    };

    if ($("#inquiry_form").length) {
        $("#inquiry_form").on("submit", function (event) {
            event.preventDefault();

            let validated = true;

            $(this)
                .find("input[required], textarea[required], select[required], radio[required], checkbox[required]")
                .each(function () {
                    if (!$(this).val()) {
                        $("#inquiry_form").addClass("was-validated");
                        validated = false;
                    }
                });

            if (validated) {
                formSubmitButtonState($("#inquiry_form"), true);

                $.ajax({
                    type: "POST",
                    url: $(this).attr("action"),
                    data: $(this).serializeArray(),
                    success: function (response) {
                        if (response["status"]) {
                            SuccessAlert.fire(
                                "Success!",
                                response["message"],
                                "success"
                            );
                            document
                                .getElementById("inquiry_form")
                                .reset();

                            $("#inquiry_form")
                                .find("input, textarea, select, radio, checkbox").removeClass('is-invalid');

                            $("#inquiry_form").find("select").val(null).trigger("change");

                        } else {
                            DangerAlert.fire(
                                "Error!",
                                response["message"],
                                "error"
                            );
                        }
                    },
                    error: function (response) {
                        let errorMessage = 'An unknown error has occurred';

                        if (response.responseJSON && response.responseJSON.errors) {
                            let errors = response.responseJSON.errors;
                            errorMessage = '';
                            $.each(errors, function (field, messages) {
                                errorMessage += messages.join(' ') + '\n';
                                $(`[name="${field}"]`).addClass('is-invalid');
                                $(`[name="${field}"]`).next('.invalid-feedback').remove();
                                $(`[name="${field}"]`).after(`<div class="invalid-feedback">${messages.join(' ')}</div>`);
                            });
                        }

                        DangerAlert.fire(
                            "Error!",
                            response["message"] ?? 'An unknown error has occured',
                            "error"
                        );
                    },
                    complete: function () {
                        formSubmitButtonState($("#inquiry_form"), false);
                    }
                });
            }
        });
    }

    let accordionButtons = document.querySelectorAll('.accordion-button');

    if (accordionButtons.length) {
        accordionButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                let icon = this.querySelector('.icon i');
                let isCollapsed = this.classList.contains('collapsed');

                if (isCollapsed) {
                    icon.classList.remove('fa-minus');
                    icon.classList.add('fa-plus');
                } else {
                    icon.classList.remove('fa-plus');
                    icon.classList.add('fa-minus');
                }

                // Toggle the icon for all buttons
                accordionButtons.forEach(function (btn) {
                    if (btn !== button) {
                        let iconOther = btn.querySelector('.icon i');

                        iconOther.classList.remove('fa-minus');
                        iconOther.classList.add('fa-plus');
                    }
                });
            });
        });
    }

    if ($("#trip_start_date").length) {
        let departurePicker = $('#trip_start_date').flatpickr({
            minDate: "today",
        });
    }

    if ($("#arrival").length && $("#departure").length) {
        let departurePicker = $('#departure').flatpickr({
            minDate: "today",
        });

        let arrivalInput = $('#arrival').flatpickr({
            minDate: "today",
            onChange: function (selectedDates, dateStr, instance) {
                if (selectedDates.length > 0) {
                    let arrivalDate = new Date(selectedDates[0]);
                    arrivalDate.setDate(arrivalDate.getDate() + 2);

                    let departureMinDate = arrivalDate.toISOString().split('T')[0];

                    if (departurePicker) {
                        departurePicker.set('minDate', departureMinDate);
                    }
                }
            }
        })
    }

});

/**
 * Theme danger alert handler.
 */
const SuccessAlert = Swal.mixin({
    customClass: {
        confirmButton: "btn btn-primary mx-1",
        cancelButton: "btn btn-primary mx-1",
    },
    buttonsStyling: false,
});

/**
 * Submit button state handler for AJAX forms.
 *
 * @param {jQuery} form Form element
 * @param {boolean} isLoading Loading state
 */
function formSubmitButtonState(form, isLoading) {
    if (isLoading) {
        $(form).find("button #children").hide();
        $(form).find("button #loading").show();
        $(form).find(".theme-btn").attr("disabled", true);
    } else {
        $(form).find("button #children").show();
        $(form).find("button #loading").hide();
        $(form).find(".theme-btn").attr("disabled", false);
    }
}

/**
 * Theme danger alert handler.
 */
const DangerAlert = Swal.mixin({
    customClass: {
        confirmButton: "btn btn-danger mx-1",
        cancelButton: "btn btn-secondary mx-1",
    },
    buttonsStyling: false,
});

/**
 * Prevent user interaction.
 */
const PageBlocker = (function () {
    return {
        block: () => {
            jQuery("body").addClass("page-blocker");
        },

        unblock: () => {
            jQuery("body").removeClass("page-blocker");
        },
    };
})();
