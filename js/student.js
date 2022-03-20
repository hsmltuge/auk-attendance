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
        emailaddress: {
          validators: {
            notEmpty: {
              message: "Email address is required",
            },
            callback: {
              message: "The value is not a valid email address",
              callback: function (input) {
                const value = input.value;
                if (value === "") {
                  return true;
                }
                // I want the value has to pass both emailAddress and regexp validators
                return (
                  FormValidation.validators.emailAddress().validate({
                    value: value,
                  }).valid &&
                  FormValidation.validators.regexp().validate({
                    value: value,
                    options: {
                      regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                    },
                  }).valid
                );
              },
            },
          },
        },
        regNo: {
          validators: {
            notEmpty: {
              message: "Registration number is required",
            },
            callback: {
              message: "Registration number not recognized",
              callback: function (input) {
                const value = input.value;
                if (value === "") {
                  return true;
                }
                // I want the value has to pass both emailAddress and regexp validators
                if (value.split("/").length === 4) {
                  if (value.split("/")[3].length > 3) {
                    return true;
                  } else {
                    return false;
                  }
                } else {
                  return false;
                }
              },
            },
          },
        },
        fullNames: {
          validators: {
            notEmpty: {
              message: "Names are required",
            },
          },
        },
        programmes: {
          validators: {
            notEmpty: {
              message: "Programme is required",
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
              emailaddress: form.querySelector('[name="emailaddress"]').value,
              regNo: form.querySelector('[name="regNo"]').value,
              fullNames: form.querySelector('[name="fullNames"]').value,
              programmes: form.querySelector('[name="programmes"]').value,
            },
          })
          .then(function (response) {
            // Return valid JSON
            // Release button
            console.log(response);
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
                location.href = "index.php";
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
