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
        firstname: {
          validators: {
            notEmpty: {
              message: "First name is required",
            },
          },
        },
        lastname: {
          validators: {
            notEmpty: {
              message: "Last name is required",
            },
          },
        },

        password: {
          validators: {
            notEmpty: {
              message: "Password is required",
            },
            callback: {
              message: "Require more than or equal 8 characters",
              callback: function (input) {
                const value = input.value;
                if (value.length < 8) {
                  return false;
                }
                return true;
              },
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
              firstname: form.querySelector('[name="firstname"]').value,
              middlename: form.querySelector('[name="middlename"]').value,
              lastname: form.querySelector('[name="lastname"]').value,
              emailaddress: form.querySelector('[name="emailaddress"]').value,
              password: form.querySelector('[name="password"]').value,
            },
          })
          .then(function (response) {
            // Return valid JSON
            // Release button
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
