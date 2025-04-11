(function ($) {
    "use strict";

    var Medi = {
        init: function () {
            this.Basic.init();
        },

        Basic: {
            init: function () {
                this.BackgroundImage();
                this.Plan_Price_Toggle();
                this.LearningTestimonial();
            },
            BackgroundImage: function () {
                $("[data-background]").each(function () {
                    $(this).css("background-image", "url(" + $(this).attr("data-background") + ")");
                });
            },
            Plan_Price_Toggle: function () {
                $(".zPrice-plan-switch").on("click", function () {
                    // Toggle visibility of monthly and yearly amounts
                    $(this).closest('section').find(".planPrice-monthly-amount").toggleClass("d-none");
                    $(this).closest('section').find(".planPrice-yearly-amount").toggleClass("d-block");

                    // Toggle value of the hidden input
                    let monthlyInput = $(this).closest('section').find("input.monthly-type");
                    let currentValue = monthlyInput.val();

                    if (currentValue == "1") {
                        monthlyInput.val("0"); // Switch to yearly
                    } else {
                        monthlyInput.val("1"); // Switch to monthly
                    }

                    // Toggle button states for monthly and yearly plans
                    let monthlyBtn = $(this).closest('section').find(".monthly-btn");
                    let yearlyBtn = $(this).closest('section').find(".yearly-btn");

                    monthlyBtn.toggleClass("d-none");
                    yearlyBtn.toggleClass("d-none");
                });

                $(".zPrice-plan-switch-tab").on("click", function () {
                    // Toggle visibility of monthly and yearly amounts
                    $(this).closest('.tab-pane').find(".planPrice-monthly-amount").toggleClass("d-none");
                    $(this).closest('.tab-pane').find(".planPrice-yearly-amount").toggleClass("d-block");

                    // Toggle value of the hidden input
                    let monthlyInput = $(this).closest('.tab-pane').find("input.monthly-type");
                    let currentValue = monthlyInput.val();

                    if (currentValue == "1") {
                        monthlyInput.val("0"); // Switch to yearly
                    } else {
                        monthlyInput.val("1"); // Switch to monthly
                    }

                    // Toggle button states for monthly and yearly plans
                    let monthlyBtn = $(this).closest('.tab-pane').find(".monthly-btn");
                    let yearlyBtn = $(this).closest('.tab-pane').find(".yearly-btn");

                    monthlyBtn.toggleClass("d-none");
                    yearlyBtn.toggleClass("d-none");
                });
            },
            LearningTestimonial: function () {
                // var swiper = new Swiper(".learningTestiItems", {
                //   slidesPerView: 2,
                //   spaceBetween: 24,
                //   autoPlan: true,
                //   centeredSlides: true,
                //   roundLengths: true,
                //   loop: true,
                //   // loopAdditionalSlides: 30,
                //   navigation: {
                //     nextEl: ".swiper-button-next",
                //     prevEl: ".swiper-button-prev",
                //   },
                //   // breakpoints: {
                //   //   992: {
                //   //     slidesPerView: 2,
                //   //     spaceBetween: 24,
                //   //   },
                //   //   // 768: {
                //   //   //   slidesPerView: 4,
                //   //   //   spaceBetween: 40,
                //   //   // },
                //   //   // 1024: {
                //   //   //   slidesPerView: 5,
                //   //   //   spaceBetween: 50,
                //   //   // },
                //   // },
                // });
                var swiper = new Swiper(".mySwiper", {
                    slidesPerView: 2,
                    spaceBetween: 24,
                    autoPlay: true,
                    centeredSlides: true,
                    pagination: {
                        el: ".swiper-pagination",
                        clickable: true,
                    },
                    // breakpoints: {
                    //   640: {
                    //     slidesPerView: 2,
                    //     spaceBetween: 20,
                    //   },
                    //   768: {
                    //     slidesPerView: 4,
                    //     spaceBetween: 40,
                    //   },
                    //   1024: {
                    //     slidesPerView: 5,
                    //     spaceBetween: 50,
                    //   },
                    // },
                });
            },
        },
    };
    jQuery(document).ready(function () {
        Medi.init();
    });
})(jQuery);
