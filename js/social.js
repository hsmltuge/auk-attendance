"use strict";
$.fn.sort_select_box = function () {
  var my_options = $("#" + this.attr("id") + " option");
  my_options.sort(function (a, b) {
    if (a.text > b.text) return 1;
    else if (a.text < b.text) return -1;
    else return 0;
  });
  return my_options;
};
// Class Definition
var KTLogin = (function () {
  var _buttonSpinnerClasses = "spinner spinner-right spinner-white pr-15";

  var SubmitSiwesForm = function () {
    var form = KTUtil.getById("kt_register_form");
    var formSubmitUrl = KTUtil.attr(form, "action");
    var formSubmitButton = KTUtil.getById("kt_register_form_submit_button");

    if (!form) {
      return;
    }
    FormValidation.formValidation(form, {
      fields: {
        facebook: {
          validators: {
            notEmpty: {
              message: "Answer is required",
            },
          },
        },
        twitter: {
          validators: {
            notEmpty: {
              message: "Answer is required",
            },
          },
        },
        instagram: {
          validators: {
            notEmpty: {
              message: "Answer is required",
            },
          },
        },
        whatsapp: {
          validators: {
            notEmpty: {
              message: "Answer is required",
            },
          },
        },
        linkedin: {
          validators: {
            notEmpty: {
              message: "Answer is required",
            },
          },
        },
        computer: {
          validators: {
            notEmpty: {
              message: "Answer is required",
            },
          },
        },
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        submitButton: new FormValidation.plugins.SubmitButton(),
        //defaultSubmit: new FormValidation.plugins.DefaultSubmit(), // Uncomment this line to enable normal button submit after form validation
        bootstrap: new FormValidation.plugins.Bootstrap({
          //	eleInvalidClass: '', // Repace with uncomment to hide bootstrap validation icons
          //	eleValidClass: '',   // Repace with uncomment to hide bootstrap validation icons
        }),
      },
    })
      .on("core.form.valid", function () {
        // Show loading state on button
        KTUtil.btnWait(formSubmitButton, _buttonSpinnerClasses, "Please wait");
        // Form Validation & Ajax Submission: https://formvalidation.io/guide/examples/using-ajax-to-submit-the-form
        FormValidation.utils
          .fetch(formSubmitUrl, {
            method: "POST",
            dataType: "json",
            params: {
              facebook: form.querySelector('[name="facebook"]').value,
              twitter: form.querySelector('[name="twitter"]').value,
              instagram: form.querySelector('[name="instagram"]').value,
              whatsapp: form.querySelector('[name="whatsapp"]').value,
              linkedin: form.querySelector('[name="linkedin"]').value,
              computer: form.querySelector('[name="computer"]').value,
            },
          })
          .then(function (response) {
            // Return valid JSON
            // Release button
            KTUtil.btnRelease(formSubmitButton);
            if (response.type === "success" || response.type === "no File") {
              Swal.fire({
                text: "Your record uploaded successfully",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                  confirmButton: "btn font-weight-bold btn-light-primary",
                },
              }).then(() => {
                location.href = "photo.php";
              });
            } else {
              Swal.fire({
                text: response.msg,
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                  confirmButton: "btn font-weight-bold btn-light-primary",
                },
              });
            }
          });
      })
      .on("core.form.invalid", function () {
        Swal.fire({
          text: "Sorry, looks like there are some errors detected, please try again.",
          icon: "error",
          buttonsStyling: false,
          confirmButtonText: "Ok, got it!",
          customClass: {
            confirmButton: "btn font-weight-bold btn-light-primary",
          },
        });
      });
  };
  // Public Functions
  return {
    init: function () {
      SubmitSiwesForm();
    },
  };
})();

// Class Initialization
jQuery(document).ready(function () {
  KTLogin.init();
});
