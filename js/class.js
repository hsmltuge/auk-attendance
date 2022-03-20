"use strict";

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
        code: {
          validators: {
            notEmpty: {
              message: "Course code is required",
            },
          },
        },
        title: {
          validators: {
            notEmpty: {
              message: "Course title is required",
            },
          },
        },
        year: {
          validators: {
            notEmpty: {
              message: "Year is required",
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
              title: form.querySelector('[name="title"]').value,
              code: form.querySelector('[name="code"]').value,
              year: form.querySelector('[name="year"]').value,
            },
          })
          .then(function (response) {
            // Return valid JSON
            // Release button
            console.log(response);
            KTUtil.btnRelease(formSubmitButton);
            if (response.type === "success" || response.type === "no File") {
              Swal.fire({
                text: response.msg,
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                  confirmButton: "btn font-weight-bold btn-light-primary",
                },
              }).then(() => {
                location.reload();
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
